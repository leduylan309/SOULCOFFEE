<?php
/**
 * Order lookup by email + order code (no account required).
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('rest_api_init', static function (): void {
	register_rest_route('soul/v1', '/order-lookup', [
		'methods'             => 'POST',
		'permission_callback' => '__return_true',
		'callback'            => static function (\WP_REST_Request $request) {
			$data  = $request->get_json_params();
			if (! is_array($data)) {
				$data = $request->get_params();
			}
			$email = sanitize_email((string) ($data['email'] ?? ''));
			$code  = strtoupper(sanitize_text_field((string) ($data['code'] ?? '')));
			if (! is_email($email) || $code === '') {
				return new \WP_Error('soul_invalid', __('Email và mã đơn là bắt buộc.', 'soul'), ['status' => 400]);
			}

			$q = new WP_Query([
				'post_type'      => 'soul_order',
				'post_status'    => 'publish',
				'posts_per_page' => 1,
				'meta_query'     => [
					[
						'key'   => 'soul_order_code',
						'value' => $code,
					],
				],
			]);
			if (! $q->have_posts()) {
				return new \WP_Error('soul_not_found', __('Không tìm thấy đơn.', 'soul'), ['status' => 404]);
			}
			$post_id  = (int) $q->posts[0]->ID;
			$customer = get_post_meta($post_id, 'soul_customer', true);
			if (! is_array($customer) || strcasecmp((string) ($customer['email'] ?? ''), $email) !== 0) {
				return new \WP_Error('soul_not_found', __('Không tìm thấy đơn.', 'soul'), ['status' => 404]);
			}

			$items  = get_post_meta($post_id, 'soul_items', true);
			$status = function_exists('soul_order_get_status')
				? soul_order_get_status($post_id)
				: (string) get_post_meta($post_id, 'soul_status', true);
			$pay_st = function_exists('soul_order_get_payment_status')
				? soul_order_get_payment_status($post_id)
				: (string) get_post_meta($post_id, 'soul_payment_status', true);
			return [
				'ok'            => true,
				'code'          => (string) get_post_meta($post_id, 'soul_order_code', true),
				'status'        => $status,
				'statusLabel'   => function_exists('soul_order_status_label') ? soul_order_status_label($status) : $status,
				'payment'       => (string) get_post_meta($post_id, 'soul_payment', true),
				'paymentStatus' => $pay_st !== '' ? $pay_st : 'unpaid',
				'total'         => (int) get_post_meta($post_id, 'soul_total', true),
				'tracking'      => (string) get_post_meta($post_id, 'soul_tracking', true),
				'items'         => is_array($items) ? $items : [],
				'date'          => get_the_date('c', $post_id),
			];
		},
	]);
});
