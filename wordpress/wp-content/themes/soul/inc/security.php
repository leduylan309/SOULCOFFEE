<?php
/**
 * Light harden: honeypot + REST throttle for public forms.
 *
 * @package Soul
 */

declare(strict_types=1);

/**
 * Allow form controls in post content (Home contact / newsletter patterns).
 *
 * @param array<string, array<string, bool>> $tags
 * @return array<string, array<string, bool>>
 */
add_filter('wp_kses_allowed_html', static function (array $tags, string $context): array {
	if ($context !== 'post') {
		return $tags;
	}
	$input_atts = [
		'type' => true, 'name' => true, 'id' => true, 'value' => true, 'placeholder' => true,
		'required' => true, 'autocomplete' => true, 'tabindex' => true, 'class' => true,
		'aria-hidden' => true, 'aria-label' => true, 'aria-pressed' => true, 'disabled' => true,
		'checked' => true, 'readonly' => true, 'min' => true, 'max' => true, 'step' => true,
		'rows' => true, 'cols' => true, 'maxlength' => true, 'pattern' => true, 'inputmode' => true,
	];
	$tags['input'] = array_merge($tags['input'] ?? [], $input_atts);
	$tags['form'] = array_merge($tags['form'] ?? [], [
		'action' => true, 'method' => true, 'class' => true, 'id' => true, 'novalidate' => true,
		'data-*' => true,
	]);
	$tags['textarea'] = array_merge($tags['textarea'] ?? [], [
		'name' => true, 'id' => true, 'rows' => true, 'cols' => true, 'class' => true,
		'required' => true, 'placeholder' => true, 'autocomplete' => true,
	]);
	$tags['button'] = array_merge($tags['button'] ?? [], [
		'type' => true, 'name' => true, 'value' => true, 'class' => true, 'id' => true,
		'disabled' => true, 'aria-label' => true, 'aria-pressed' => true, 'data-*' => true,
	]);
	$tags['label'] = array_merge($tags['label'] ?? [], [
		'for' => true, 'class' => true,
	]);
	$tags['fieldset'] = array_merge($tags['fieldset'] ?? [], ['class' => true, 'style' => true]);
	$tags['legend'] = array_merge($tags['legend'] ?? [], ['class' => true, 'style' => true]);
	return $tags;
}, 10, 2);

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
