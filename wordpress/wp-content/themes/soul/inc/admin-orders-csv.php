<?php
/**
 * Export Orders CSV from admin list.
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('restrict_manage_posts', static function (string $post_type): void {
	if ($post_type !== 'soul_order') {
		return;
	}
	$url = wp_nonce_url(admin_url('edit.php?post_type=soul_order&soul_export_csv=1'), 'soul_export_csv');
	printf(
		'<a class="button" href="%s">%s</a>',
		esc_url($url),
		esc_html__('Export CSV', 'soul')
	);
});

add_action('admin_init', static function (): void {
	if (! isset($_GET['soul_export_csv']) || ! isset($_GET['post_type']) || $_GET['post_type'] !== 'soul_order') {
		return;
	}
	if (! current_user_can('edit_posts')) {
		wp_die(esc_html__('Forbidden', 'soul'));
	}
	check_admin_referer('soul_export_csv');

	$q = new WP_Query([
		'post_type'      => 'soul_order',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'DESC',
	]);

	nocache_headers();
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=soul-orders-' . gmdate('Ymd-His') . '.csv');

	$out = fopen('php://output', 'w');
	if ($out === false) {
		exit;
	}
	fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM
	fputcsv($out, ['code', 'date', 'status', 'payment', 'total', 'name', 'email', 'phone', 'address', 'note', 'vat', 'company', 'tax_id', 'items']);

	foreach ($q->posts as $post) {
		$customer = get_post_meta($post->ID, 'soul_customer', true);
		$vat      = get_post_meta($post->ID, 'soul_vat', true);
		$items    = get_post_meta($post->ID, 'soul_items', true);
		if (! is_array($customer)) {
			$customer = [];
		}
		if (! is_array($vat)) {
			$vat = [];
		}
		$item_str = '';
		if (is_array($items)) {
			$parts = [];
			foreach ($items as $line) {
				$parts[] = sprintf('%dx %s (%s)', $line['qty'] ?? 1, $line['name'] ?? '', $line['variant'] ?? '');
			}
			$item_str = implode(' | ', $parts);
		}
		fputcsv($out, [
			(string) get_post_meta($post->ID, 'soul_order_code', true),
			get_the_date('c', $post),
			(string) get_post_meta($post->ID, 'soul_status', true),
			(string) get_post_meta($post->ID, 'soul_payment', true),
			(int) get_post_meta($post->ID, 'soul_total', true),
			(string) ($customer['name'] ?? ''),
			(string) ($customer['email'] ?? ''),
			(string) ($customer['phone'] ?? ''),
			(string) ($customer['address'] ?? ''),
			(string) ($customer['note'] ?? ''),
			! empty($vat['needed']) ? '1' : '0',
			(string) ($vat['company'] ?? ''),
			(string) ($vat['tax_id'] ?? ''),
			$item_str,
		]);
	}
	fclose($out);
	exit;
});
