<?php
/**
 * Contact directory — single source for hotlines / emails / Zalo / tagline.
 *
 * @package Soul
 */

declare(strict_types=1);

/**
 * @return array{
 *   hotline_retail:string,
 *   hotline_b2b:string,
 *   hotline_checkout:string,
 *   email_contact:string,
 *   email_finerobusta:string,
 *   email_hr:string,
 *   zalo_url:string,
 *   tagline:string,
 *   cart_note:string
 * }
 */
function soul_contact_defaults(): array {
	return [
		'hotline_retail'    => '0987 592 220',
		'hotline_b2b'       => '0908 267 710',
		'hotline_checkout'  => '0969 648 148',
		'email_contact'     => 'contact@soulcoffee.vn',
		'email_finerobusta' => 'finerobusta@soulcoffee.vn',
		'email_hr'          => 'hcns.soulcoffee@gmail.com',
		'zalo_url'          => 'https://zalo.me/soulspecialtycoffee',
		'tagline'           => 'Crafted by Vietnamese Soul. Buôn Ma Thuột, Việt Nam.',
		'cart_note'         => 'Không thanh toán online — gửi đơn để Soul xác nhận.',
	];
}

/** @return array<string,string> */
function soul_contact_settings(): array {
	$raw = get_option('soul_contact_settings', []);
	if (! is_array($raw)) {
		$raw = [];
	}
	$defaults = soul_contact_defaults();
	$out      = [];
	foreach ($defaults as $key => $fallback) {
		$val = isset($raw[ $key ]) ? sanitize_text_field((string) $raw[ $key ]) : $fallback;
		if ($val === '' && str_starts_with($key, 'email_')) {
			$val = $fallback;
		}
		if (str_starts_with($key, 'email_') && $val !== '' && ! is_email($val)) {
			$val = $fallback;
		}
		if ($key === 'zalo_url') {
			$val = esc_url_raw((string) ($raw[ $key ] ?? $fallback)) ?: $fallback;
		}
		if ($val === '') {
			$val = $fallback;
		}
		$out[ $key ] = $val;
	}
	return $out;
}

/** @param string $key Contact settings key. */
function soul_contact(string $key): string {
	$all = soul_contact_settings();
	return $all[ $key ] ?? '';
}

add_action('admin_init', static function (): void {
	register_setting(
		'soul_contact_group',
		'soul_contact_settings',
		[
			'type'              => 'array',
			'sanitize_callback' => 'soul_contact_sanitize_settings',
			'default'           => [],
		]
	);
});

/**
 * @param mixed $input
 * @return array<string,string>
 */
function soul_contact_sanitize_settings($input): array {
	if (! is_array($input)) {
		$input = [];
	}
	$defaults = soul_contact_defaults();
	$out      = [];
	foreach ($defaults as $key => $fallback) {
		$raw = (string) ($input[ $key ] ?? '');
		if ($key === 'zalo_url') {
			$val = esc_url_raw($raw);
			$out[ $key ] = $val !== '' ? $val : $fallback;
			continue;
		}
		if (str_starts_with($key, 'email_')) {
			$email = sanitize_email($raw);
			$out[ $key ] = ($email !== '' && is_email($email)) ? $email : $fallback;
			continue;
		}
		$val = sanitize_text_field($raw);
		$out[ $key ] = $val !== '' ? $val : $fallback;
	}
	return $out;
}

function soul_contact_render_settings_page(): void {
	if (! current_user_can('manage_options')) {
		return;
	}
	$s = soul_contact_settings();
	?>
	<div class="wrap">
		<h1><?php esc_html_e('SOUL Settings', 'soul'); ?></h1>
		<?php soul_settings_tabs('soul-settings'); ?>
		<p><?php esc_html_e('Thông tin liên hệ dùng chung cho checkout, Help, Solutions, PDP. Shortcode: [soul_contact key="hotline_retail"]', 'soul'); ?></p>
		<form method="post" action="options.php">
			<?php settings_fields('soul_contact_group'); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="soul-c-retail"><?php esc_html_e('Hotline khách lẻ', 'soul'); ?></label></th>
					<td><input type="text" class="regular-text" id="soul-c-retail" name="soul_contact_settings[hotline_retail]" value="<?php echo esc_attr($s['hotline_retail']); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="soul-c-b2b"><?php esc_html_e('Hotline B2B / nhân xanh', 'soul'); ?></label></th>
					<td><input type="text" class="regular-text" id="soul-c-b2b" name="soul_contact_settings[hotline_b2b]" value="<?php echo esc_attr($s['hotline_b2b']); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="soul-c-ck"><?php esc_html_e('Hotline checkout', 'soul'); ?></label></th>
					<td>
						<input type="text" class="regular-text" id="soul-c-ck" name="soul_contact_settings[hotline_checkout]" value="<?php echo esc_attr($s['hotline_checkout']); ?>">
						<p class="description"><?php esc_html_e('Đồng bộ mặc định với Commerce → Hotline khi Commerce để trống.', 'soul'); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="soul-c-email"><?php esc_html_e('Email liên hệ', 'soul'); ?></label></th>
					<td><input type="email" class="regular-text" id="soul-c-email" name="soul_contact_settings[email_contact]" value="<?php echo esc_attr($s['email_contact']); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="soul-c-fr"><?php esc_html_e('Email Fine Robusta', 'soul'); ?></label></th>
					<td><input type="email" class="regular-text" id="soul-c-fr" name="soul_contact_settings[email_finerobusta]" value="<?php echo esc_attr($s['email_finerobusta']); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="soul-c-hr"><?php esc_html_e('Email HR', 'soul'); ?></label></th>
					<td><input type="email" class="regular-text" id="soul-c-hr" name="soul_contact_settings[email_hr]" value="<?php echo esc_attr($s['email_hr']); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="soul-c-zalo"><?php esc_html_e('Zalo URL', 'soul'); ?></label></th>
					<td><input type="url" class="regular-text" id="soul-c-zalo" name="soul_contact_settings[zalo_url]" value="<?php echo esc_attr($s['zalo_url']); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="soul-c-tag"><?php esc_html_e('Footer tagline', 'soul'); ?></label></th>
					<td><input type="text" class="large-text" id="soul-c-tag" name="soul_contact_settings[tagline]" value="<?php echo esc_attr($s['tagline']); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="soul-c-cart"><?php esc_html_e('Cart drawer note', 'soul'); ?></label></th>
					<td><input type="text" class="large-text" id="soul-c-cart" name="soul_contact_settings[cart_note]" value="<?php echo esc_attr($s['cart_note']); ?>"></td>
				</tr>
			</table>
			<?php submit_button(__('Lưu cài đặt', 'soul')); ?>
		</form>
	</div>
	<?php
}

add_shortcode('soul_contact', static function ($atts): string {
	$atts = shortcode_atts(['key' => ''], is_array($atts) ? $atts : []);
	$key  = sanitize_key((string) $atts['key']);
	if ($key === '') {
		return '';
	}
	return esc_html(soul_contact($key));
});
