<?php
/**
 * Google reCAPTCHA v3 — settings + server verify.
 * Inactive until enabled + both keys are set (safe to ship empty).
 *
 * @package Soul
 */

declare(strict_types=1);

/** @return array{enabled:bool,site_key:string,secret_key:string,score:float,protect:array<string,bool>} */
function soul_recaptcha_settings(): array {
	$raw = get_option('soul_recaptcha', []);
	if (! is_array($raw)) {
		$raw = [];
	}
	$protect_in = is_array($raw['protect'] ?? null) ? $raw['protect'] : [];
	$defaults   = [
		'newsletter'   => true,
		'contact'      => true,
		'checkout'     => true,
		'auth'         => true,
		'order_lookup' => true,
	];
	$protect = [];
	foreach ($defaults as $k => $def) {
		if (array_key_exists($k, $protect_in)) {
			$protect[ $k ] = ! empty($protect_in[ $k ]);
		} else {
			$protect[ $k ] = $def;
		}
	}
	$score = isset($raw['score']) ? (float) $raw['score'] : 0.5;
	if ($score < 0.0) {
		$score = 0.0;
	}
	if ($score > 1.0) {
		$score = 1.0;
	}
	return [
		'enabled'    => ! empty($raw['enabled']),
		'site_key'   => sanitize_text_field((string) ($raw['site_key'] ?? '')),
		'secret_key' => sanitize_text_field((string) ($raw['secret_key'] ?? '')),
		'score'      => $score,
		'protect'    => $protect,
	];
}

/** Ready to enforce (toggle on + both keys present). */
function soul_recaptcha_is_active(): bool {
	$s = soul_recaptcha_settings();
	return $s['enabled'] && $s['site_key'] !== '' && $s['secret_key'] !== '';
}

/**
 * Map REST route → reCAPTCHA action + protect group.
 *
 * @return array{action:string,group:string}|null
 */
function soul_recaptcha_route_map(string $route): ?array {
	$map = [
		'/soul/v1/newsletter'     => ['action' => 'newsletter', 'group' => 'newsletter'],
		'/soul/v1/contact'        => ['action' => 'contact', 'group' => 'contact'],
		'/soul/v1/checkout'       => ['action' => 'checkout', 'group' => 'checkout'],
		'/soul/v1/order-lookup'   => ['action' => 'order_lookup', 'group' => 'order_lookup'],
		'/soul/v1/auth/login'     => ['action' => 'login', 'group' => 'auth'],
		'/soul/v1/auth/register'  => ['action' => 'register', 'group' => 'auth'],
		'/soul/v1/auth/recover'   => ['action' => 'recover', 'group' => 'auth'],
	];
	return $map[ $route ] ?? null;
}

/**
 * Verify token with Google. No-op (true) when inactive or route not protected.
 *
 * @return true|\WP_Error
 */
function soul_recaptcha_verify_request(\WP_REST_Request $request) {
	if (! soul_recaptcha_is_active()) {
		return true;
	}
	$route = $request->get_route();
	$mapped = soul_recaptcha_route_map($route);
	if (! $mapped) {
		return true;
	}
	$settings = soul_recaptcha_settings();
	if (empty($settings['protect'][ $mapped['group'] ])) {
		return true;
	}

	$token = (string) (
		$request->get_param('recaptchaToken')
		?? $request->get_param('g-recaptcha-response')
		?? ''
	);
	if ($token === '') {
		$json = $request->get_json_params();
		if (is_array($json)) {
			$token = (string) ($json['recaptchaToken'] ?? $json['g-recaptcha-response'] ?? '');
		}
	}
	if ($token === '') {
		return new \WP_Error(
			'soul_recaptcha_missing',
			__('Không xác minh được chống spam. Vui lòng tải lại trang và thử lại.', 'soul'),
			['status' => 400]
		);
	}

	return soul_recaptcha_verify_token($token, $mapped['action'], $settings);
}

/**
 * @param array{enabled:bool,site_key:string,secret_key:string,score:float,protect:array<string,bool>} $settings
 * @return true|\WP_Error
 */
function soul_recaptcha_verify_token(string $token, string $expected_action, array $settings) {
	$response = wp_remote_post(
		'https://www.google.com/recaptcha/api/siteverify',
		[
			'timeout' => 8,
			'body'    => [
				'secret'   => $settings['secret_key'],
				'response' => $token,
				'remoteip' => isset($_SERVER['REMOTE_ADDR'])
					? sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR']))
					: '',
			],
		]
	);

	if (is_wp_error($response)) {
		return new \WP_Error(
			'soul_recaptcha_unreachable',
			__('Không kết nối được dịch vụ chống spam. Thử lại sau.', 'soul'),
			['status' => 503]
		);
	}

	$code = (int) wp_remote_retrieve_response_code($response);
	$body = json_decode((string) wp_remote_retrieve_body($response), true);
	if ($code !== 200 || ! is_array($body)) {
		return new \WP_Error(
			'soul_recaptcha_bad_response',
			__('Xác minh chống spam thất bại.', 'soul'),
			['status' => 400]
		);
	}

	if (empty($body['success'])) {
		return new \WP_Error(
			'soul_recaptcha_failed',
			__('Xác minh chống spam thất bại.', 'soul'),
			['status' => 400]
		);
	}

	$action = (string) ($body['action'] ?? '');
	if ($action !== '' && $expected_action !== '' && $action !== $expected_action) {
		return new \WP_Error(
			'soul_recaptcha_action',
			__('Xác minh chống spam thất bại.', 'soul'),
			['status' => 400]
		);
	}

	$score = isset($body['score']) ? (float) $body['score'] : 0.0;
	if ($score < $settings['score']) {
		return new \WP_Error(
			'soul_recaptcha_score',
			__('Yêu cầu bị từ chối (spam). Nếu bạn là người dùng thật, hãy thử lại hoặc liên hệ Soul.', 'soul'),
			['status' => 403]
		);
	}

	return true;
}

/** Front config for SoulTheme.recaptcha. */
function soul_recaptcha_front_config(): array {
	$s = soul_recaptcha_settings();
	$active = soul_recaptcha_is_active();
	return [
		'enabled' => $active,
		'siteKey' => $active ? $s['site_key'] : '',
		'score'   => $s['score'],
		'protect' => $s['protect'],
	];
}

add_action('admin_init', static function (): void {
	register_setting(
		'soul_recaptcha_group',
		'soul_recaptcha',
		[
			'type'              => 'array',
			'sanitize_callback' => 'soul_recaptcha_sanitize_settings',
			'default'           => [],
		]
	);
});

/**
 * @param mixed $input
 * @return array<string,mixed>
 */
function soul_recaptcha_sanitize_settings($input): array {
	if (! is_array($input)) {
		$input = [];
	}
	$prev = soul_recaptcha_settings();
	$out  = [
		'enabled'    => ! empty($input['enabled']),
		'site_key'   => sanitize_text_field((string) ($input['site_key'] ?? '')),
		'secret_key' => sanitize_text_field((string) ($input['secret_key'] ?? '')),
		'score'      => isset($input['score']) ? (float) $input['score'] : 0.5,
		'protect'    => [
			'newsletter'   => ! empty($input['protect']['newsletter']),
			'contact'      => ! empty($input['protect']['contact']),
			'checkout'     => ! empty($input['protect']['checkout']),
			'auth'         => ! empty($input['protect']['auth']),
			'order_lookup' => ! empty($input['protect']['order_lookup']),
		],
	];
	// Keep previous secret if field left blank (password-style UX).
	if ($out['secret_key'] === '' && $prev['secret_key'] !== '') {
		$out['secret_key'] = $prev['secret_key'];
	}
	if ($out['score'] < 0.0) {
		$out['score'] = 0.0;
	}
	if ($out['score'] > 1.0) {
		$out['score'] = 1.0;
	}
	return $out;
}

function soul_recaptcha_render_settings_page(): void {
	if (! current_user_can('manage_options')) {
		return;
	}
	$s      = soul_recaptcha_settings();
	$active = soul_recaptcha_is_active();
	?>
	<div class="wrap">
		<h1><?php esc_html_e('SOUL Settings', 'soul'); ?></h1>
		<?php if (function_exists('soul_settings_tabs')) {
			soul_settings_tabs('soul-settings-security');
		} ?>
		<p><?php esc_html_e('Google reCAPTCHA v3 — chống spam form công khai. Để trống key thì hệ thống không enforce.', 'soul'); ?></p>

		<?php if ($active) : ?>
			<div class="notice notice-success inline"><p><?php esc_html_e('reCAPTCHA đang BẬT và có đủ key — các endpoint đã chọn sẽ yêu cầu token.', 'soul'); ?></p></div>
		<?php elseif ($s['enabled']) : ?>
			<div class="notice notice-warning inline"><p><?php esc_html_e('Đã bật nhưng thiếu Site key hoặc Secret key — tạm thời chưa enforce.', 'soul'); ?></p></div>
		<?php else : ?>
			<div class="notice notice-info inline"><p><?php esc_html_e('Đang TẮT — form hoạt động bình thường (honeypot + rate limit vẫn giữ).', 'soul'); ?></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields('soul_recaptcha_group'); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php esc_html_e('Bật reCAPTCHA v3', 'soul'); ?></th>
					<td>
						<label>
							<input type="checkbox" name="soul_recaptcha[enabled]" value="1" <?php checked($s['enabled']); ?>>
							<?php esc_html_e('Enforce khi đã có đủ Site + Secret key', 'soul'); ?>
						</label>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="soul-rc-site"><?php esc_html_e('Site key', 'soul'); ?></label></th>
					<td>
						<input type="text" class="regular-text" id="soul-rc-site" name="soul_recaptcha[site_key]" value="<?php echo esc_attr($s['site_key']); ?>" autocomplete="off" spellcheck="false">
						<p class="description"><?php esc_html_e('Lấy từ Google reCAPTCHA Admin → tạo key loại v3.', 'soul'); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="soul-rc-secret"><?php esc_html_e('Secret key', 'soul'); ?></label></th>
					<td>
						<input type="password" class="regular-text" id="soul-rc-secret" name="soul_recaptcha[secret_key]" value="" placeholder="<?php echo $s['secret_key'] !== '' ? esc_attr__('•••• đã lưu — để trống nếu giữ nguyên', 'soul') : ''; ?>" autocomplete="new-password" spellcheck="false">
						<p class="description">
							<?php
							echo $s['secret_key'] !== ''
								? esc_html__('Secret đã được lưu. Chỉ nhập lại khi muốn đổi.', 'soul')
								: esc_html__('Chưa có secret. Dán Secret key từ Google.', 'soul');
							?>
						</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="soul-rc-score"><?php esc_html_e('Điểm tối thiểu', 'soul'); ?></label></th>
					<td>
						<input type="number" id="soul-rc-score" name="soul_recaptcha[score]" value="<?php echo esc_attr((string) $s['score']); ?>" min="0" max="1" step="0.1" class="small-text">
						<p class="description"><?php esc_html_e('Google trả score 0.0–1.0 (1 = người dùng thật). Khuyến nghị 0.5.', 'soul'); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e('Bảo vệ endpoint', 'soul'); ?></th>
					<td>
						<fieldset>
							<label><input type="checkbox" name="soul_recaptcha[protect][newsletter]" value="1" <?php checked($s['protect']['newsletter']); ?>> <?php esc_html_e('Newsletter', 'soul'); ?></label><br>
							<label><input type="checkbox" name="soul_recaptcha[protect][contact]" value="1" <?php checked($s['protect']['contact']); ?>> <?php esc_html_e('Liên hệ / lead form', 'soul'); ?></label><br>
							<label><input type="checkbox" name="soul_recaptcha[protect][checkout]" value="1" <?php checked($s['protect']['checkout']); ?>> <?php esc_html_e('Checkout / đặt hàng', 'soul'); ?></label><br>
							<label><input type="checkbox" name="soul_recaptcha[protect][auth]" value="1" <?php checked($s['protect']['auth']); ?>> <?php esc_html_e('Đăng nhập / Đăng ký / Quên mật khẩu', 'soul'); ?></label><br>
							<label><input type="checkbox" name="soul_recaptcha[protect][order_lookup]" value="1" <?php checked($s['protect']['order_lookup']); ?>> <?php esc_html_e('Tra cứu đơn', 'soul'); ?></label>
						</fieldset>
					</td>
				</tr>
			</table>
			<?php submit_button(__('Lưu cài đặt', 'soul')); ?>
		</form>

		<hr>
		<p>
			<a href="https://www.google.com/recaptcha/admin" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Mở Google reCAPTCHA Admin ↗', 'soul'); ?></a>
			—
			<?php esc_html_e('Chọn reCAPTCHA v3, thêm domain (localhost + production).', 'soul'); ?>
		</p>
	</div>
	<?php
}

/** Enqueue Google script when active. */
add_action('wp_enqueue_scripts', static function (): void {
	if (! soul_recaptcha_is_active()) {
		return;
	}
	$s = soul_recaptcha_settings();
	wp_enqueue_script(
		'soul-recaptcha-v3',
		'https://www.google.com/recaptcha/api.js?render=' . rawurlencode($s['site_key']),
		[],
		null,
		true
	);
}, 5);
