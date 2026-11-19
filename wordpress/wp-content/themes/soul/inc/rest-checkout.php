<?php
/**
 * REST: submit order (no payment).
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('rest_api_init', static function (): void {
	register_rest_route('soul/v1', '/checkout', [
		'methods'             => 'POST',
		'permission_callback' => '__return_true',
		'callback'            => static function (\WP_REST_Request $request) {
			$data = $request->get_json_params();
			if (! is_array($data)) {
				$data = $request->get_params();
			}
			$result = soul_create_order(is_array($data) ? $data : []);
			if (is_wp_error($result)) {
				return $result;
			}
			$code = (string) get_post_meta($result, 'soul_order_code', true);
			return [
				'ok'        => true,
				'orderId'   => $result,
				'orderCode' => $code,
			];
		},
		'args'                => [],
	]);
});
