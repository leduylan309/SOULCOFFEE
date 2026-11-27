<?php
/**
 * Checkout / Commerce settings — shipping, payment, bank, fees, promo, pickup.
 *
 * @package Soul
 */

declare(strict_types=1);

/**
 * @return array{
 *   shipping_methods:bool,
 *   payment_methods:bool,
 *   hotline:string,
 *   email:string,
 *   bank_name:string,
 *   bank_account:string,
 *   bank_account_name:string,
 *   free_shipping_at:int,
 *   shipping_std_fee:int,
 *   shipping_exp_fee:int,
 *   promo_codes:array<string,float>,
 *   promo_codes_raw:string,
 *   pickup_from_spaces:bool,
 *   pickup_stores:array<string,array{name:string,addr:string}>,
 *   email_on_status_change:bool
 * }
 */
function soul_checkout_settings(): array {
	$raw = get_option('soul_checkout_settings', []);
	if (! is_array($raw)) {
		$raw = [];
	}

	$contact_hotline = function_exists('soul_contact') ? soul_contact('hotline_checkout') : '0969 648 148';
	$contact_email   = function_exists('soul_contact') ? soul_contact('email_contact') : 'contact@soulcoffee.vn';

	$hotline = sanitize_text_field((string) ($raw['hotline'] ?? ''));
	$email   = sanitize_email((string) ($raw['email'] ?? ''));
	if ($hotline === '') {
		$hotline = $contact_hotline !== '' ? $contact_hotline : '0969 648 148';
	}
	if ($email === '' || ! is_email($email)) {
		$email = ($contact_email !== '' && is_email($contact_email)) ? $contact_email : 'contact@soulcoffee.vn';
	}

	$promo_raw = (string) ($raw['promo_codes_raw'] ?? 'SOUL10:0.1');
	if ($promo_raw === '' && empty($raw['promo_codes'])) {
		$promo_raw = 'SOUL10:0.1';
	}
	$promos = soul_checkout_parse_promo_codes($promo_raw);
	if ($promos === [] && is_array($raw['promo_codes'] ?? null)) {
		foreach ($raw['promo_codes'] as $code => $rate) {
			$promos[ strtoupper(sanitize_key((string) $code)) ] = (float) $rate;
		}
	}

	$stores = soul_checkout_default_pickup_stores();
	if (! empty($raw['pickup_from_spaces'])) {
		$from_spaces = soul_checkout_pickup_from_spaces();
		if ($from_spaces !== []) {
			$stores = $from_spaces;
		}
	}

	return [
		'shipping_methods'   => ! empty($raw['shipping_methods']),
		'payment_methods'    => ! empty($raw['payment_methods']),
		'hotline'            => $hotline,
		'email'              => $email,
		'bank_name'          => sanitize_text_field((string) ($raw['bank_name'] ?? 'Đang cập nhật')),
		'bank_account'       => sanitize_text_field((string) ($raw['bank_account'] ?? 'Đang cập nhật')),
		'bank_account_name'  => sanitize_text_field((string) ($raw['bank_account_name'] ?? 'Công ty Soul Fine Robusta')),
		'free_shipping_at'   => max(0, (int) ($raw['free_shipping_at'] ?? 500000)),
		'shipping_std_fee'   => max(0, (int) ($raw['shipping_std_fee'] ?? 30000)),
		'shipping_exp_fee'   => max(0, (int) ($raw['shipping_exp_fee'] ?? 50000)),
		'promo_codes'        => $promos,
		'promo_codes_raw'    => $promo_raw,
		'pickup_from_spaces'      => ! empty($raw['pickup_from_spaces']),
		'pickup_stores'           => $stores,
		'email_on_status_change'  => ! empty($raw['email_on_status_change']),
	];
}

/** @return array<string,float> */
function soul_checkout_parse_promo_codes(string $raw): array {
	$out = [];
	foreach (preg_split('/\r\n|\r|\n/', $raw) ?: [] as $line) {
		$line = trim((string) $line);
		if ($line === '' || ! str_contains($line, ':')) {
			continue;
		}
		[$code, $rate] = array_map('trim', explode(':', $line, 2));
		$code = strtoupper(preg_replace('/[^A-Z0-9_-]/i', '', $code) ?? '');
		$rate = (float) $rate;
		if ($code === '' || $rate <= 0 || $rate > 1) {
			continue;
		}
		$out[ $code ] = $rate;
	}
	return $out;
}

/** @return array<string,array{name:string,addr:string}> */
function soul_checkout_default_pickup_stores(): array {
	return [
		'hcm' => [
			'name' => 'Soul Hồ Chí Minh',
			'addr' => '386/11 Lê Văn Sỹ, P. Nhiêu Lộc, TP. Hồ Chí Minh',
		],
		'bmt' => [
			'name' => 'Soul Buôn Ma Thuột',
			'addr' => '87 Nguyễn Khuyến, P. Buôn Ma Thuột, Đắk Lắk',
		],
		'hn'  => [
			'name' => 'Soul Hà Nội',
			'addr' => '12 Đường Thành, P. Hoàn Kiếm, Hà Nội',
		],
		'dn'  => [
			'name' => 'Soul Đà Nẵng',
			'addr' => '12 An Thượng 11, P. Ngũ Hành Sơn, Đà Nẵng',
		],
	];
}

/** @return array<string,array{name:string,addr:string}> */
function soul_checkout_pickup_from_spaces(): array {
	$posts = get_posts([
		'post_type'      => 'soul_space',
		'post_status'    => 'publish',
		'posts_per_page' => 20,
		'orderby'        => 'menu_order title',
		'order'          => 'ASC',
	]);
	$out = [];
	foreach ($posts as $p) {
		$slug = $p->post_name !== '' ? $p->post_name : 'space-' . $p->ID;
		$meta = function_exists('soul_get_space_meta') ? soul_get_space_meta($p->ID) : [];
		$addr = (string) ($meta['address'] ?? '');
		$out[ $slug ] = [
			'name' => get_the_title($p),
			'addr' => $addr !== '' ? $addr : get_the_title($p),
		];
	}
	return $out;
}

/** Front payload for SoulTheme.checkoutUi. */
function soul_checkout_front_config(): array {
	$s = soul_checkout_settings();
	$stores = [];
	foreach ($s['pickup_stores'] as $id => $row) {
		$stores[ $id ] = [
			'name' => $row['name'],
			'addr' => $row['addr'],
		];
	}
	return [
		'shippingMethods'  => $s['shipping_methods'],
		'paymentMethods'   => $s['payment_methods'],
		'hotline'          => $s['hotline'],
		'email'            => $s['email'],
		'bankName'         => $s['bank_name'],
		'bankAccount'      => $s['bank_account'],
		'bankAccountName'  => $s['bank_account_name'],
		'freeShippingAt'   => $s['free_shipping_at'],
		'shippingStdFee'   => $s['shipping_std_fee'],
		'shippingExpFee'   => $s['shipping_exp_fee'],
		'promoCodes'       => $s['promo_codes'],
		'pickupStores'     => $stores,
	];
}

add_action('admin_init', static function (): void {
	register_setting(
		'soul_checkout_group',
		'soul_checkout_settings',
		[
			'type'              => 'array',
			'sanitize_callback' => 'soul_checkout_sanitize_settings',
			'default'           => [],
		]
	);
});

/**
 * @param mixed $input
 * @return array<string,mixed>
 */
function soul_checkout_sanitize_settings($input): array {
	if (! is_array($input)) {
		$input = [];
	}
	$hotline = sanitize_text_field((string) ($input['hotline'] ?? ''));
	$email   = sanitize_email((string) ($input['email'] ?? ''));
	$promo   = (string) ($input['promo_codes_raw'] ?? 'SOUL10:0.1');
	if ($promo === '') {
		$promo = 'SOUL10:0.1';
	}
	return [
		'shipping_methods'   => ! empty($input['shipping_methods']),
		'payment_methods'    => ! empty($input['payment_methods']),
		'hotline'            => $hotline,
		'email'              => ($email !== '' && is_email($email)) ? $email : '',
		'bank_name'          => sanitize_text_field((string) ($input['bank_name'] ?? 'Đang cập nhật')),
		'bank_account'       => sanitize_text_field((string) ($input['bank_account'] ?? 'Đang cập nhật')),
		'bank_account_name'  => sanitize_text_field((string) ($input['bank_account_name'] ?? 'Công ty Soul Fine Robusta')),
		'free_shipping_at'   => max(0, (int) ($input['free_shipping_at'] ?? 500000)),
		'shipping_std_fee'   => max(0, (int) ($input['shipping_std_fee'] ?? 30000)),
		'shipping_exp_fee'   => max(0, (int) ($input['shipping_exp_fee'] ?? 50000)),
		'promo_codes_raw'    => sanitize_textarea_field($promo),
		'promo_codes'             => soul_checkout_parse_promo_codes($promo),
		'pickup_from_spaces'      => ! empty($input['pickup_from_spaces']),
		'email_on_status_change'  => ! empty($input['email_on_status_change']),
	];
}

function soul_checkout_render_settings_page(): void {
	if (! current_user_can('manage_options')) {
		return;
	}
	$s = soul_checkout_settings();
	?>
	<div class="wrap">
		<h1><?php esc_html_e('SOUL Settings', 'soul'); ?></h1>
		<?php if (function_exists('soul_settings_tabs')) {
			soul_settings_tabs('soul-settings-commerce');
		} ?>
		<p><?php esc_html_e('Commerce: giao hàng, thanh toán, ngân hàng, phí ship, mã giảm giá, điểm nhận hàng.', 'soul'); ?></p>

		<form method="post" action="options.php">
			<?php settings_fields('soul_checkout_group'); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php esc_html_e('Phương thức giao hàng', 'soul'); ?></th>
					<td>
						<label>
							<input type="checkbox" name="soul_checkout_settings[shipping_methods]" value="1" <?php checked($s['shipping_methods']); ?>>
							<?php esc_html_e('Hiện lựa chọn giao hàng (tiêu chuẩn / nhanh / cửa hàng / quốc tế)', 'soul'); ?>
						</label>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e('Phương thức thanh toán', 'soul'); ?></th>
					<td>
						<label>
							<input type="checkbox" name="soul_checkout_settings[payment_methods]" value="1" <?php checked($s['payment_methods']); ?>>
							<?php esc_html_e('Hiện lựa chọn thanh toán (chuyển khoản / ví điện tử)', 'soul'); ?>
						</label>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="soul-ck-hotline"><?php esc_html_e('Hotline checkout', 'soul'); ?></label></th>
					<td>
						<input type="text" class="regular-text" id="soul-ck-hotline" name="soul_checkout_settings[hotline]" value="<?php echo esc_attr($s['hotline']); ?>">
						<p class="description"><?php esc_html_e('Để trống = dùng Contact → Hotline checkout.', 'soul'); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="soul-ck-email"><?php esc_html_e('Email checkout', 'soul'); ?></label></th>
					<td>
						<input type="email" class="regular-text" id="soul-ck-email" name="soul_checkout_settings[email]" value="<?php echo esc_attr($s['email']); ?>">
						<p class="description"><?php esc_html_e('Để trống = dùng Contact → Email liên hệ.', 'soul'); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="soul-ck-bank"><?php esc_html_e('Ngân hàng', 'soul'); ?></label></th>
					<td><input type="text" class="regular-text" id="soul-ck-bank" name="soul_checkout_settings[bank_name]" value="<?php echo esc_attr($s['bank_name']); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="soul-ck-stk"><?php esc_html_e('Số tài khoản', 'soul'); ?></label></th>
					<td><input type="text" class="regular-text" id="soul-ck-stk" name="soul_checkout_settings[bank_account]" value="<?php echo esc_attr($s['bank_account']); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="soul-ck-holder"><?php esc_html_e('Chủ tài khoản', 'soul'); ?></label></th>
					<td><input type="text" class="regular-text" id="soul-ck-holder" name="soul_checkout_settings[bank_account_name]" value="<?php echo esc_attr($s['bank_account_name']); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="soul-ck-free"><?php esc_html_e('Miễn phí ship từ (VND)', 'soul'); ?></label></th>
					<td><input type="number" class="regular-text" id="soul-ck-free" name="soul_checkout_settings[free_shipping_at]" value="<?php echo esc_attr((string) $s['free_shipping_at']); ?>" min="0" step="1000"></td>
				</tr>
				<tr>
					<th scope="row"><label for="soul-ck-std"><?php esc_html_e('Phí ship tiêu chuẩn', 'soul'); ?></label></th>
					<td><input type="number" class="regular-text" id="soul-ck-std" name="soul_checkout_settings[shipping_std_fee]" value="<?php echo esc_attr((string) $s['shipping_std_fee']); ?>" min="0" step="1000"></td>
				</tr>
				<tr>
					<th scope="row"><label for="soul-ck-exp"><?php esc_html_e('Phí ship nhanh', 'soul'); ?></label></th>
					<td><input type="number" class="regular-text" id="soul-ck-exp" name="soul_checkout_settings[shipping_exp_fee]" value="<?php echo esc_attr((string) $s['shipping_exp_fee']); ?>" min="0" step="1000"></td>
				</tr>
				<tr>
					<th scope="row"><label for="soul-ck-promo"><?php esc_html_e('Mã giảm giá', 'soul'); ?></label></th>
					<td>
						<textarea class="large-text code" rows="4" id="soul-ck-promo" name="soul_checkout_settings[promo_codes_raw]"><?php echo esc_textarea($s['promo_codes_raw']); ?></textarea>
						<p class="description"><?php esc_html_e('Mỗi dòng: CODE:0.1 (0.1 = 10%). Ví dụ SOUL10:0.1', 'soul'); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e('Điểm nhận hàng', 'soul'); ?></th>
					<td>
						<label>
							<input type="checkbox" name="soul_checkout_settings[pickup_from_spaces]" value="1" <?php checked($s['pickup_from_spaces']); ?>>
							<?php esc_html_e('Lấy danh sách từ Spaces (soul_space) thay vì danh sách mặc định', 'soul'); ?>
						</label>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e('Email khi đổi trạng thái đơn', 'soul'); ?></th>
					<td>
						<label>
							<input type="checkbox" name="soul_checkout_settings[email_on_status_change]" value="1" <?php checked(! empty($s['email_on_status_change'])); ?>>
							<?php esc_html_e('Gửi email admin mỗi khi trạng thái đơn thay đổi (mặc định tắt)', 'soul'); ?>
						</label>
					</td>
				</tr>
			</table>
			<?php submit_button(__('Lưu cài đặt', 'soul')); ?>
		</form>
	</div>
	<?php
}
