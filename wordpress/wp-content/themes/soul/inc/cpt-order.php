<?php
/**
 * Order CPT — store orders without online payment.
 *
 * Admin list/detail live in admin-orders.php.
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('init', static function (): void {
	register_post_type('soul_order', [
		'labels' => [
			'name'          => __('Đơn hàng', 'soul'),
			'singular_name' => __('Đơn hàng', 'soul'),
			'edit_item'     => __('Chi tiết đơn', 'soul'),
			'add_new_item'  => __('Thêm đơn', 'soul'),
			'add_new'       => __('Thêm đơn', 'soul'),
			'menu_name'     => __('Đơn hàng', 'soul'),
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
			'img'     => esc_url_raw((string) ($item['img'] ?? '')),
		];
		$total += $line['price'] * $line['qty'];
		$lines[] = $line;
	}

	if ($lines === []) {
		return new \WP_Error('soul_empty_cart', __('Cart is empty.', 'soul'), ['status' => 400]);
	}

	$payment = sanitize_text_field((string) ($data['payment'] ?? 'contact'));
	if (! in_array($payment, ['cod', 'bank', 'wallet', 'contact'], true)) {
		$payment = 'contact';
	}

	$shipping = sanitize_text_field((string) ($data['shipping'] ?? 'arrange'));
	if (! in_array($shipping, ['std', 'exp', 'pickup', 'intl', 'arrange'], true)) {
		$shipping = 'arrange';
	}

	$vat_needed = ! empty($data['vat_needed']) || ! empty($data['vat']);
	$vat        = [
		'needed'  => (bool) $vat_needed,
		'company' => sanitize_text_field((string) ($data['vat_company'] ?? '')),
		'tax_id'  => sanitize_text_field((string) ($data['vat_tax_id'] ?? '')),
		'email'   => sanitize_email((string) ($data['vat_email'] ?? '')),
		'address' => sanitize_textarea_field((string) ($data['vat_address'] ?? '')),
		'buyer'   => sanitize_text_field((string) ($data['vat_buyer'] ?? '')),
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

	$grand = (int) ($data['total'] ?? $total);

	$meta = [
		'soul_status'          => 'new',
		'soul_payment_status'  => 'unpaid',
		'soul_tracking'        => '',
		'soul_admin_notes'     => '',
		'soul_customer'        => [
			'name'     => $name,
			'email'    => $email,
			'phone'    => $phone,
			'address'  => sanitize_textarea_field((string) ($data['address'] ?? '')),
			'province' => sanitize_text_field((string) ($data['province'] ?? '')),
			'ward'     => sanitize_text_field((string) ($data['ward'] ?? '')),
			'city'     => sanitize_text_field((string) ($data['city'] ?? '')),
			'country'  => sanitize_text_field((string) ($data['country'] ?? '')),
			'note'     => sanitize_textarea_field((string) ($data['note'] ?? '')),
		],
		'soul_shipping'        => [
			'method'     => $shipping,
			'store'      => sanitize_text_field((string) ($data['store'] ?? '')),
			'store_name' => sanitize_text_field((string) ($data['store_name'] ?? '')),
			'store_addr' => sanitize_text_field((string) ($data['store_addr'] ?? '')),
			'fee'        => (int) ($data['shipping_fee'] ?? 0),
		],
		'soul_payment'         => $payment,
		'soul_vat'             => $vat,
		'soul_items'           => $lines,
		'soul_subtotal'        => (int) ($data['subtotal'] ?? $total),
		'soul_discount'        => (int) ($data['discount'] ?? 0),
		'soul_code'            => sanitize_text_field((string) ($data['code'] ?? '')),
		'soul_total'           => $grand,
		'soul_order_code'      => 'SOUL-' . $order_id,
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
		'Total: ' . (function_exists('soul_format_money') ? soul_format_money($grand) : number_format($grand, 0, ',', '.') . '₫'),
		$vat['needed'] ? 'VAT: ' . $vat['company'] . ' · MST ' . $vat['tax_id'] : 'VAT: no',
		'',
	];
	foreach ($lines as $line) {
		$body_lines[] = sprintf('%dx %s (%s) — %s₫', $line['qty'], $line['name'], $line['variant'], number_format($line['price'], 0, ',', '.'));
	}
	wp_mail($admin_email, $subject, implode("\n", $body_lines));

	return $order_id;
}
