<?php
/**
 * Order CPT — store orders without online payment.
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('init', static function (): void {
	register_post_type('soul_order', [
		'labels' => [
			'name'          => __('Orders', 'soul'),
			'singular_name' => __('Order', 'soul'),
			'edit_item'     => __('View Order', 'soul'),
		],
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_icon'           => 'dashicons-clipboard',
		'capability_type'     => 'post',
		'map_meta_cap'        => true,
		'supports'            => ['title'],
		'show_in_rest'        => false,
	]);
});

/**
 * Create an order from checkout payload.
 *
 * @param array<string,mixed> $data
 * @return int|\WP_Error
 */
function soul_create_order(array $data) {
	$items = $data['items'] ?? [];
	if (! is_array($items) || $items === []) {
		return new \WP_Error('soul_empty_cart', __('Cart is empty.', 'soul'), ['status' => 400]);
	}

	$name  = sanitize_text_field((string) ($data['name'] ?? ''));
	$email = sanitize_email((string) ($data['email'] ?? ''));
	$phone = sanitize_text_field((string) ($data['phone'] ?? ''));

	if ($name === '' || ! is_email($email)) {
		return new \WP_Error('soul_invalid_customer', __('Name and valid email are required.', 'soul'), ['status' => 400]);
	}

	$total = 0;
	$lines = [];
	foreach ($items as $item) {
		if (! is_array($item)) {
			continue;
		}
		$line = [
			'id'      => sanitize_text_field((string) ($item['id'] ?? '')),
			'name'    => sanitize_text_field((string) ($item['name'] ?? '')),
			'variant' => sanitize_text_field((string) ($item['variant'] ?? '')),
			'price'   => (int) ($item['price'] ?? 0),
			'qty'     => max(1, (int) ($item['qty'] ?? 1)),
		];
		$total += $line['price'] * $line['qty'];
		$lines[] = $line;
	}

	if ($lines === []) {
		return new \WP_Error('soul_empty_cart', __('Cart is empty.', 'soul'), ['status' => 400]);
	}

	$payment = sanitize_text_field((string) ($data['payment'] ?? 'cod'));
	if (! in_array($payment, ['cod', 'bank'], true)) {
		$payment = 'cod';
	}

	$vat_needed = ! empty($data['vat_needed']) || ! empty($data['vat']);
	$vat        = [
		'needed'  => (bool) $vat_needed,
		'company' => sanitize_text_field((string) ($data['vat_company'] ?? '')),
		'tax_id'  => sanitize_text_field((string) ($data['vat_tax_id'] ?? '')),
		'email'   => sanitize_email((string) ($data['vat_email'] ?? '')),
		'address' => sanitize_textarea_field((string) ($data['vat_address'] ?? '')),
	];
	if ($vat['needed'] && ($vat['company'] === '' || $vat['tax_id'] === '')) {
		return new \WP_Error('soul_invalid_vat', __('VAT requires company name and tax ID.', 'soul'), ['status' => 400]);
	}

	$order_id = wp_insert_post([
		'post_type'   => 'soul_order',
		'post_status' => 'publish',
		'post_title'  => sprintf(
			/* translators: 1: customer name 2: datetime */
			__('Order — %1$s — %2$s', 'soul'),
			$name,
			wp_date('Y-m-d H:i')
		),
	], true);

	if (is_wp_error($order_id)) {
		return $order_id;
	}

	$meta = [
		'soul_status'     => 'new',
		'soul_customer'   => [
			'name'    => $name,
			'email'   => $email,
			'phone'   => $phone,
			'address' => sanitize_textarea_field((string) ($data['address'] ?? '')),
			'note'    => sanitize_textarea_field((string) ($data['note'] ?? '')),
		],
		'soul_payment'    => $payment,
		'soul_vat'        => $vat,
		'soul_items'      => $lines,
		'soul_total'      => $total,
		'soul_order_code' => 'SOUL-' . $order_id,
	];

	foreach ($meta as $key => $value) {
		update_post_meta($order_id, $key, $value);
	}

	$admin_email = get_option('admin_email');
	$subject     = sprintf('[SOUL] %s', $meta['soul_order_code']);
	$body_lines  = [
		$meta['soul_order_code'],
		$name . ' <' . $email . '> · ' . $phone,
		'Payment: ' . $payment,
		'Total: ' . number_format($total, 0, ',', '.') . '₫',
		$vat['needed'] ? 'VAT: ' . $vat['company'] . ' · MST ' . $vat['tax_id'] : 'VAT: no',
		'',
	];
	foreach ($lines as $line) {
		$body_lines[] = sprintf('%dx %s (%s) — %s₫', $line['qty'], $line['name'], $line['variant'], number_format($line['price'], 0, ',', '.'));
	}
	wp_mail($admin_email, $subject, implode("\n", $body_lines));

	return $order_id;
}

add_filter('manage_soul_order_posts_columns', static function (array $cols): array {
	return [
		'cb'          => $cols['cb'] ?? '',
		'title'       => __('Order', 'soul'),
		'soul_code'   => __('Code', 'soul'),
		'soul_status' => __('Status', 'soul'),
		'soul_total'  => __('Total', 'soul'),
		'date'        => __('Date', 'soul'),
	];
});

add_action('manage_soul_order_posts_custom_column', static function (string $col, int $post_id): void {
	switch ($col) {
		case 'soul_code':
			echo esc_html((string) get_post_meta($post_id, 'soul_order_code', true));
			break;
		case 'soul_status':
			echo esc_html((string) get_post_meta($post_id, 'soul_status', true));
			break;
		case 'soul_total':
			$total = (int) get_post_meta($post_id, 'soul_total', true);
			echo esc_html(number_format($total, 0, ',', '.') . '₫');
			break;
	}
}, 10, 2);

add_action('add_meta_boxes', static function (): void {
	add_meta_box('soul_order_detail', __('Order detail', 'soul'), 'soul_render_order_metabox', 'soul_order', 'normal', 'high');
});

function soul_render_order_metabox(\WP_Post $post): void {
	$customer = get_post_meta($post->ID, 'soul_customer', true);
	$items    = get_post_meta($post->ID, 'soul_items', true);
	$vat      = get_post_meta($post->ID, 'soul_vat', true);
	$status   = (string) get_post_meta($post->ID, 'soul_status', true);
	$payment  = (string) get_post_meta($post->ID, 'soul_payment', true);
	$total    = (int) get_post_meta($post->ID, 'soul_total', true);
	$code     = (string) get_post_meta($post->ID, 'soul_order_code', true);

	if (! is_array($customer)) {
		$customer = [];
	}
	if (! is_array($items)) {
		$items = [];
	}
	if (! is_array($vat)) {
		$vat = [];
	}

	wp_nonce_field('soul_order_meta', 'soul_order_meta_nonce');
	?>
	<p><strong><?php echo esc_html($code); ?></strong> · <?php echo esc_html(number_format($total, 0, ',', '.') . '₫'); ?></p>
	<p><label><?php esc_html_e('Status', 'soul'); ?>
		<select name="soul_status">
			<?php foreach (['new', 'processing', 'done', 'cancelled'] as $s) : ?>
				<option value="<?php echo esc_attr($s); ?>" <?php selected($status, $s); ?>><?php echo esc_html($s); ?></option>
			<?php endforeach; ?>
		</select>
	</label></p>
	<p><?php esc_html_e('Payment', 'soul'); ?>: <code><?php echo esc_html($payment); ?></code> (COD / bank — no online charge)</p>
	<ul>
		<li><?php echo esc_html(($customer['name'] ?? '') . ' · ' . ($customer['email'] ?? '') . ' · ' . ($customer['phone'] ?? '')); ?></li>
		<li><?php echo esc_html((string) ($customer['address'] ?? '')); ?></li>
		<li><?php echo esc_html((string) ($customer['note'] ?? '')); ?></li>
	</ul>
	<?php if (! empty($vat['needed'])) : ?>
		<p><strong><?php esc_html_e('VAT invoice requested', 'soul'); ?></strong></p>
		<ul>
			<li><?php echo esc_html((string) ($vat['company'] ?? '')); ?></li>
			<li>MST: <?php echo esc_html((string) ($vat['tax_id'] ?? '')); ?></li>
			<li><?php echo esc_html((string) ($vat['email'] ?? '')); ?></li>
			<li><?php echo esc_html((string) ($vat['address'] ?? '')); ?></li>
		</ul>
	<?php endif; ?>
	<table class="widefat striped">
		<thead><tr><th><?php esc_html_e('Item', 'soul'); ?></th><th><?php esc_html_e('Qty', 'soul'); ?></th><th><?php esc_html_e('Price', 'soul'); ?></th></tr></thead>
		<tbody>
		<?php foreach ($items as $line) : ?>
			<tr>
				<td><?php echo esc_html(($line['name'] ?? '') . ' · ' . ($line['variant'] ?? '')); ?></td>
				<td><?php echo esc_html((string) ($line['qty'] ?? 1)); ?></td>
				<td><?php echo esc_html(number_format((int) ($line['price'] ?? 0), 0, ',', '.') . '₫'); ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?php
}

add_action('save_post_soul_order', static function (int $post_id): void {
	if (! isset($_POST['soul_order_meta_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['soul_order_meta_nonce'])), 'soul_order_meta')) {
		return;
	}
	if (! current_user_can('edit_post', $post_id)) {
		return;
	}
	$status = sanitize_text_field(wp_unslash($_POST['soul_status'] ?? 'new'));
	if (in_array($status, ['new', 'processing', 'done', 'cancelled'], true)) {
		update_post_meta($post_id, 'soul_status', $status);
	}
});
