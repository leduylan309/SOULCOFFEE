<?php
/**
 * Light harden: honeypot + REST throttle for public forms.
 *
 * @package Soul
 */

declare(strict_types=1);

/**
 * @return true|\WP_Error
 */
function soul_rest_guard(\WP_REST_Request $request) {
	$hp = (string) ($request->get_param('website') ?? '');
	if ($hp !== '') {
		return new \WP_Error('soul_spam', __('Rejected.', 'soul'), ['status' => 400]);
	}

	$ip  = isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'])) : '0';
	$key = 'soul_rl_' . md5($ip . '|' . $request->get_route());
	$n   = (int) get_transient($key);
	if ($n >= 12) {
		return new \WP_Error('soul_rate', __('Too many requests. Try again later.', 'soul'), ['status' => 429]);
	}
	set_transient($key, $n + 1, 10 * MINUTE_IN_SECONDS);
	return true;
}

add_filter('rest_pre_dispatch', static function ($result, $server, $request) {
	if (! $request instanceof WP_REST_Request) {
		return $result;
	}
	$route = $request->get_route();
	$guarded = [
		'/soul/v1/checkout',
		'/soul/v1/newsletter',
		'/soul/v1/contact',
		'/soul/v1/order-lookup',
	];
	if (! in_array($route, $guarded, true)) {
		return $result;
	}
	if ($request->get_method() !== 'POST') {
		return $result;
	}
	$check = soul_rest_guard($request);
	return is_wp_error($check) ? $check : $result;
}, 10, 3);
