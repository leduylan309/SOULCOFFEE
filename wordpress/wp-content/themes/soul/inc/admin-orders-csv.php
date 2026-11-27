<?php
/**
 * Export Orders CSV from admin list (date range + filters).
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('restrict_manage_posts', static function (string $post_type): void {
	if ($post_type !== 'soul_order') {
		return;
	}
	$args = [
		'post_type' => 'soul_order',
		'soul_export_csv' => '1',
	];
	foreach ([
		'soul_status_filter',
		'soul_payment_filter',
		'soul_pay_status_filter',
		'soul_date_from',
		'soul_date_to',
		'soul_status_view',
		's',
	] as $key) {
		if (! empty($_GET[ $key ])) {
			$args[ $key ] = sanitize_text_field(wp_unslash((string) $_GET[ $key ]));
		}
	}
	$url = wp_nonce_url(add_query_arg($args, admin_url('edit.php')), 'soul_export_csv');
	printf(
		'<a class="button" href="%s">%s</a>',
		esc_url($url),
		esc_html__('Export CSV', 'soul')
	);
}, 20);

add_action('admin_init', static function (): void {
	if (! isset($_GET['soul_export_csv']) || ! isset($_GET['post_type']) || $_GET['post_type'] !== 'soul_order') {
		return;
	}
	if (! current_user_can('edit_posts')) {
		wp_die(esc_html__('Forbidden', 'soul'));
	}
	check_admin_referer('soul_export_csv');

	$query_args = [
		'post_type'      => 'soul_order',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'DESC',
	];

	$meta_query = [];
	$status = isset($_GET['soul_status_filter']) ? sanitize_text_field(wp_unslash((string) $_GET['soul_status_filter'])) : '';
	if ($status === '' && isset($_GET['soul_status_view'])) {
		$status = sanitize_text_field(wp_unslash((string) $_GET['soul_status_view']));
	}
	if ($status !== '') {
		if ($status === 'confirmed') {
			$meta_query[] = [
				'relation' => 'OR',
				['key' => 'soul_status', 'value' => 'confirmed'],
				['key' => 'soul_status', 'value' => 'processing'],
			];
		} else {
			$meta_query[] = ['key' => 'soul_status', 'value' => $status];
		}
	}
	$pay = isset($_GET['soul_payment_filter']) ? sanitize_text_field(wp_unslash((string) $_GET['soul_payment_filter'])) : '';
	if ($pay !== '') {
		$meta_query[] = ['key' => 'soul_payment', 'value' => $pay];
	}
	$pstat = isset($_GET['soul_pay_status_filter']) ? sanitize_text_field(wp_unslash((string) $_GET['soul_pay_status_filter'])) : '';
	if ($pstat === 'paid') {
		$meta_query[] = ['key' => 'soul_payment_status', 'value' => 'paid'];
	} elseif ($pstat === 'unpaid') {
		$meta_query[] = [
			'relation' => 'OR',
			['key' => 'soul_payment_status', 'value' => 'unpaid'],
			['key' => 'soul_payment_status', 'compare' => 'NOT EXISTS'],
		];
	}
	if ($meta_query !== []) {
		if (count($meta_query) > 1) {
			$meta_query['relation'] = 'AND';
		}
		$query_args['meta_query'] = $meta_query;
	}

	$from = isset($_GET['soul_date_from']) ? sanitize_text_field(wp_unslash((string) $_GET['soul_date_from'])) : '';
	$to   = isset($_GET['soul_date_to']) ? sanitize_text_field(wp_unslash((string) $_GET['soul_date_to'])) : '';
	$dq   = [];
	if ($from !== '') {
		$dq['after'] = $from;
	}
	if ($to !== '') {
		$dq['before'] = $to . ' 23:59:59';
	}
	if ($dq !== []) {
		$dq['inclusive'] = true;
		$query_args['date_query'] = [$dq];
	}

	$q = new WP_Query($query_args);

	nocache_headers();
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=soul-orders-' . gmdate('Ymd-His') . '.csv');

	$out = fopen('php://output', 'w');
	if ($out === false) {
		exit;
	}
	fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
	fputcsv($out, [
		'code', 'date', 'status', 'payment', 'payment_status', 'shipping', 'ship_fee',
		'subtotal', 'discount', 'promo', 'total', 'tracking',
		'name', 'email', 'phone', 'address', 'province', 'ward', 'note',
		'vat', 'company', 'tax_id', 'vat_email', 'vat_address', 'vat_buyer', 'items',
	]);

	foreach ($q->posts as $post) {
		$customer = get_post_meta($post->ID, 'soul_customer', true);
		$vat      = get_post_meta($post->ID, 'soul_vat', true);
		$items    = get_post_meta($post->ID, 'soul_items', true);
		$ship     = get_post_meta($post->ID, 'soul_shipping', true);
		if (! is_array($customer)) {
			$customer = [];
		}
		if (! is_array($vat)) {
			$vat = [];
		}
		if (! is_array($ship)) {
			$ship = [];
		}
		$item_str = '';
		if (is_array($items)) {
			$parts = [];
			foreach ($items as $line) {
				$parts[] = sprintf('%dx %s (%s)', $line['qty'] ?? 1, $line['name'] ?? '', $line['variant'] ?? '');
			}
			$item_str = implode(' | ', $parts);
		}
		$status = function_exists('soul_order_get_status')
			? soul_order_get_status($post->ID)
			: (string) get_post_meta($post->ID, 'soul_status', true);
		$pay_st = function_exists('soul_order_get_payment_status')
			? soul_order_get_payment_status($post->ID)
			: (string) get_post_meta($post->ID, 'soul_payment_status', true);

		fputcsv($out, [
			(string) get_post_meta($post->ID, 'soul_order_code', true),
			get_the_date('c', $post),
			$status,
			(string) get_post_meta($post->ID, 'soul_payment', true),
			$pay_st,
			(string) ($ship['method'] ?? ''),
			(int) ($ship['fee'] ?? 0),
			(int) get_post_meta($post->ID, 'soul_subtotal', true),
			(int) get_post_meta($post->ID, 'soul_discount', true),
			(string) get_post_meta($post->ID, 'soul_code', true),
			(int) get_post_meta($post->ID, 'soul_total', true),
			(string) get_post_meta($post->ID, 'soul_tracking', true),
			(string) ($customer['name'] ?? ''),
			(string) ($customer['email'] ?? ''),
			(string) ($customer['phone'] ?? ''),
			(string) ($customer['address'] ?? ''),
			(string) ($customer['province'] ?? ''),
			(string) ($customer['ward'] ?? ''),
			(string) ($customer['note'] ?? ''),
			! empty($vat['needed']) ? '1' : '0',
			(string) ($vat['company'] ?? ''),
			(string) ($vat['tax_id'] ?? ''),
			(string) ($vat['email'] ?? ''),
			(string) ($vat['address'] ?? ''),
			(string) ($vat['buyer'] ?? ''),
			$item_str,
		]);
	}
	fclose($out);
	exit;
});
