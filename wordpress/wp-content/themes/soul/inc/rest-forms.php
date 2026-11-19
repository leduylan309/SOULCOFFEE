<?php
/**
 * Newsletter + contact forms (no payment). Mail via wp_mail → Mailpit locally.
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('rest_api_init', static function (): void {
	register_rest_route('soul/v1', '/newsletter', [
		'methods'             => 'POST',
		'permission_callback' => '__return_true',
		'callback'            => 'soul_rest_newsletter',
	]);
	register_rest_route('soul/v1', '/contact', [
		'methods'             => 'POST',
		'permission_callback' => '__return_true',
		'callback'            => 'soul_rest_contact',
	]);
});

function soul_rest_newsletter(\WP_REST_Request $request) {
	$data  = $request->get_json_params();
	$email = sanitize_email((string) (($data['email'] ?? '') ?: $request->get_param('email')));
	if (! is_email($email)) {
		return new \WP_Error('soul_invalid_email', __('Email không hợp lệ.', 'soul'), ['status' => 400]);
	}
	$list = get_option('soul_newsletter_list', []);
	if (! is_array($list)) {
		$list = [];
	}
	if (! in_array($email, $list, true)) {
		$list[] = $email;
		update_option('soul_newsletter_list', $list, false);
	}
	wp_mail(get_option('admin_email'), '[SOUL] Newsletter signup', $email);
	return ['ok' => true];
}

function soul_rest_contact(\WP_REST_Request $request) {
	$data = $request->get_json_params();
	if (! is_array($data)) {
		$data = $request->get_params();
	}
	$name    = sanitize_text_field((string) ($data['name'] ?? ''));
	$email   = sanitize_email((string) ($data['email'] ?? ''));
	$phone   = sanitize_text_field((string) ($data['phone'] ?? ''));
	$biz     = sanitize_text_field((string) ($data['business'] ?? ''));
	$topic   = sanitize_text_field((string) ($data['topic'] ?? ''));
	$message = sanitize_textarea_field((string) ($data['message'] ?? ''));
	$source  = sanitize_text_field((string) ($data['source'] ?? 'contact'));

	if ($name === '' || ! is_email($email)) {
		return new \WP_Error('soul_invalid', __('Họ tên và email hợp lệ là bắt buộc.', 'soul'), ['status' => 400]);
	}

	$id = wp_insert_post([
		'post_type'   => 'soul_lead',
		'post_status' => 'publish',
		'post_title'  => sprintf('%s — %s', $source, $name),
	], true);
	if (is_wp_error($id)) {
		return $id;
	}
	update_post_meta($id, 'soul_lead', compact('name', 'email', 'phone', 'biz', 'topic', 'message', 'source'));

	$body = implode("\n", [
		"Source: $source",
		"Name: $name",
		"Email: $email",
		"Phone: $phone",
		"Business: $biz",
		"Topic/Interest: $topic",
		'',
		$message,
	]);
	wp_mail(get_option('admin_email'), '[SOUL] Contact — ' . $source, $body);

	return ['ok' => true, 'id' => $id];
}

add_action('init', static function (): void {
	register_post_type('soul_lead', [
		'labels'          => [
			'name'          => __('Leads', 'soul'),
			'singular_name' => __('Lead', 'soul'),
		],
		'public'          => false,
		'show_ui'         => true,
		'show_in_menu'    => true,
		'menu_icon'       => 'dashicons-email-alt',
		'supports'        => ['title'],
		'capability_type' => 'post',
	]);
});
