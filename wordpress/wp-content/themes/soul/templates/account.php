<?php
/**
 * Template Name: Account
 * SoT: html/Account.dc.html — auth + dashboard (hash routes).
 *
 * @package Soul
 */
get_header();

$shop     = get_post_type_archive_link('soul_product') ?: home_url('/products/');
$help     = home_url('/help/');
$panel_img = SOUL_URI . '/assets/images/03-why-soul-album/SFR5.jpg';
$logo_y   = soul_logo_uri('soul-logo-full-yellow.svg');
$logged   = is_user_logged_in();
$user     = $logged ? wp_get_current_user() : null;

$provinces = [
	'TP. Hồ Chí Minh', 'Hà Nội', 'Đà Nẵng', 'Đắk Lắk', 'Hải Phòng', 'Cần Thơ', 'Huế',
	'An Giang', 'Bắc Ninh', 'Cà Mau', 'Cao Bằng', 'Điện Biên', 'Đồng Nai', 'Đồng Tháp',
	'Gia Lai', 'Hà Tĩnh', 'Hưng Yên', 'Khánh Hòa', 'Lai Châu', 'Lạng Sơn', 'Lào Cai',
	'Lâm Đồng', 'Nghệ An', 'Ninh Bình', 'Phú Thọ', 'Quảng Ngãi', 'Quảng Ninh', 'Quảng Trị',
	'Sơn La', 'Tây Ninh', 'Thái Nguyên', 'Thanh Hóa', 'Tuyên Quang', 'Vĩnh Long',
];
?>
<div class="s-acc" data-page="account" data-acc-root
	data-logged="<?php echo $logged ? '1' : '0'; ?>"
	data-shop="<?php echo esc_url($shop); ?>"
	data-help="<?php echo esc_url($help); ?>"
	data-checkout="<?php echo esc_url(get_permalink((int) get_option('soul_checkout_page_id')) ?: home_url('/checkout/')); ?>">

	<!-- AUTH -->
	<section class="s-acc-auth" id="top" data-acc-view="auth" data-screen-label="01 Tài khoản · Đăng nhập / Đăng ký" aria-labelledby="au-h" <?php echo $logged ? 'hidden' : ''; ?>>
		<div class="s-acc-auth__panel">
			<img class="s-acc-auth__bg" src="<?php echo esc_url($panel_img); ?>" alt="" width="960" height="1200" loading="eager">
			<div class="s-acc-auth__copy">
				<img src="<?php echo esc_url($logo_y); ?>" alt="" width="80" height="80">
				<p class="s-acc-auth__quote" data-acc-i18n="authQuote"><?php esc_html_e('Mỗi tách cà phê là một hành trình.', 'soul'); ?></p>
				<ul class="s-acc-auth__perks">
					<li><span aria-hidden="true">—</span><span data-acc-i18n="perk0"><?php esc_html_e('Theo dõi đơn hàng và mua lại nhanh', 'soul'); ?></span></li>
					<li><span aria-hidden="true">—</span><span data-acc-i18n="perk1"><?php esc_html_e('Lưu địa chỉ giao hàng', 'soul'); ?></span></li>
					<li><span aria-hidden="true">—</span><span data-acc-i18n="perk2"><?php esc_html_e('Nhận tin mùa vụ mới và ưu đãi thành viên', 'soul'); ?></span></li>
				</ul>
			</div>
		</div>
		<div class="s-acc-auth__form-wrap">
			<div class="s-acc-auth__form-inner">
				<div class="s-acc-tabs" role="tablist" data-acc-tabs>
					<a href="#login" role="tab" class="s-acc-tabs__tab is-on" data-acc-tab="login" aria-selected="true"><?php esc_html_e('Đăng nhập', 'soul'); ?></a>
					<a href="#register" role="tab" class="s-acc-tabs__tab" data-acc-tab="register" aria-selected="false"><?php esc_html_e('Đăng ký', 'soul'); ?></a>
				</div>
				<div class="s-acc-auth__head">
					<h1 id="au-h" data-acc-auth-title><?php esc_html_e('Chào mừng trở lại', 'soul'); ?></h1>
					<p data-acc-auth-intro><?php esc_html_e('Đăng nhập để xem đơn hàng và thanh toán nhanh hơn.', 'soul'); ?></p>
				</div>
				<div class="s-acc-notice" data-acc-notice hidden role="status"></div>

				<!-- Login -->
				<form class="s-acc-form" data-acc-form="login" novalidate>
					<div class="s-acc-field">
						<label for="ac-login-email"><?php esc_html_e('Email', 'soul'); ?></label>
						<input id="ac-login-email" name="email" type="email" autocomplete="email" required>
						<span class="s-acc-field__err" data-err-for="email" hidden></span>
					</div>
					<div class="s-acc-field">
						<div class="s-acc-field__row">
							<label for="ac-login-pw"><?php esc_html_e('Mật khẩu', 'soul'); ?></label>
							<a href="#recover" data-acc-goto="recover"><?php esc_html_e('Quên mật khẩu?', 'soul'); ?></a>
						</div>
						<input id="ac-login-pw" name="password" type="password" autocomplete="current-password" required>
						<span class="s-acc-field__err" data-err-for="password" hidden></span>
					</div>
					<div class="s-acc-form__alert" data-acc-form-err hidden role="alert"></div>
					<button type="submit" class="s-acc-btn s-acc-btn--primary"><?php esc_html_e('Đăng nhập', 'soul'); ?></button>
				</form>

				<!-- Register -->
				<form class="s-acc-form" data-acc-form="register" novalidate hidden>
					<div class="s-acc-field">
						<label for="ac-reg-name"><?php esc_html_e('Họ và tên', 'soul'); ?></label>
						<input id="ac-reg-name" name="name" type="text" autocomplete="name" required>
						<span class="s-acc-field__err" data-err-for="name" hidden></span>
					</div>
					<div class="s-acc-fields">
						<div class="s-acc-field">
							<label for="ac-reg-email"><?php esc_html_e('Email', 'soul'); ?></label>
							<input id="ac-reg-email" name="email" type="email" autocomplete="email" required>
							<span class="s-acc-field__err" data-err-for="email" hidden></span>
						</div>
						<div class="s-acc-field">
							<label for="ac-reg-phone"><?php esc_html_e('Số điện thoại', 'soul'); ?></label>
							<input id="ac-reg-phone" name="phone" type="tel" autocomplete="tel" required>
							<span class="s-acc-field__err" data-err-for="phone" hidden></span>
						</div>
					</div>
					<div class="s-acc-fields">
						<div class="s-acc-field">
							<label for="ac-reg-pw"><?php esc_html_e('Mật khẩu (tối thiểu 8 ký tự)', 'soul'); ?></label>
							<input id="ac-reg-pw" name="password" type="password" autocomplete="new-password" required>
							<span class="s-acc-field__err" data-err-for="password" hidden></span>
						</div>
						<div class="s-acc-field">
							<label for="ac-reg-pw2"><?php esc_html_e('Nhập lại mật khẩu', 'soul'); ?></label>
							<input id="ac-reg-pw2" name="password2" type="password" autocomplete="new-password" required>
							<span class="s-acc-field__err" data-err-for="password2" hidden></span>
						</div>
					</div>
					<label class="s-acc-check">
						<input type="checkbox" name="marketing" checked>
						<span><?php esc_html_e('Nhận email về mùa vụ mới, sự kiện và ưu đãi từ Soul.', 'soul'); ?></span>
					</label>
					<label class="s-acc-check">
						<input type="checkbox" name="agree" required>
						<span><?php esc_html_e('Tôi đồng ý với Điều khoản sử dụng và Chính sách bảo mật của Soul.', 'soul'); ?></span>
					</label>
					<span class="s-acc-field__err" data-err-for="agree" hidden></span>
					<div class="s-acc-form__alert" data-acc-form-err hidden role="alert"></div>
					<button type="submit" class="s-acc-btn s-acc-btn--primary"><?php esc_html_e('Tạo tài khoản', 'soul'); ?></button>
				</form>

				<!-- Recover -->
				<form class="s-acc-form" data-acc-form="recover" novalidate hidden>
					<div class="s-acc-field">
						<label for="ac-rec-email"><?php esc_html_e('Email', 'soul'); ?></label>
						<input id="ac-rec-email" name="email" type="email" autocomplete="email" required>
						<span class="s-acc-field__err" data-err-for="email" hidden></span>
					</div>
					<div class="s-acc-form__alert" data-acc-form-err hidden role="alert"></div>
					<button type="submit" class="s-acc-btn s-acc-btn--primary"><?php esc_html_e('Gửi đường dẫn', 'soul'); ?></button>
				</form>

				<p class="s-acc-auth__alt">
					<span data-acc-alt-text><?php esc_html_e('Chưa có tài khoản?', 'soul'); ?></span>
					<a href="#register" data-acc-alt-link><?php esc_html_e('Đăng ký', 'soul'); ?></a>
				</p>
			</div>
		</div>
	</section>

	<!-- DASHBOARD -->
	<div data-acc-view="dash" <?php echo $logged ? '' : 'hidden'; ?>>
		<section class="s-acc-hero" id="top" data-screen-label="01 Tài khoản · Tiêu đề">
			<nav class="s-acc-crumb" aria-label="<?php esc_attr_e('Breadcrumb', 'soul'); ?>">
				<a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Trang chủ', 'soul'); ?></a>
				<span aria-hidden="true">/</span>
				<a href="<?php echo esc_url(get_permalink() ?: home_url('/account/')); ?>"><?php esc_html_e('Tài khoản', 'soul'); ?></a>
				<span aria-hidden="true">/</span>
				<span class="s-acc-crumb__cur" data-acc-crumb><?php esc_html_e('Tổng quan', 'soul'); ?></span>
			</nav>
			<div class="s-acc-hero__row">
				<div>
					<div class="s-acc-hero__eye"><span aria-hidden="true"></span><span><?php esc_html_e('Tài khoản', 'soul'); ?></span></div>
					<h1 class="s-acc-hero__title" data-acc-dash-title><?php
						if ($user) {
							$parts = preg_split('/\s+/', trim($user->display_name)) ?: [];
							$first = $parts ? end($parts) : $user->user_email;
							echo esc_html(sprintf(/* translators: %s: first name */ __('Xin chào, %s', 'soul'), $first));
						} else {
							esc_html_e('Tài khoản', 'soul');
						}
					?></h1>
				</div>
				<span class="s-acc-hero__email" data-acc-email><?php echo $user ? esc_html($user->user_email) : ''; ?></span>
			</div>
		</section>

		<section class="s-acc-body" data-screen-label="02 Tài khoản · Nội dung">
			<aside class="s-acc-side">
				<nav class="s-acc-nav" aria-label="<?php esc_attr_e('Tài khoản', 'soul'); ?>">
					<a href="#" data-acc-nav="overview" class="is-on" aria-current="page"><span><?php esc_html_e('Tổng quan', 'soul'); ?></span><span data-acc-nav-count="overview"></span></a>
					<a href="#orders" data-acc-nav="orders"><span><?php esc_html_e('Đơn hàng', 'soul'); ?></span><span data-acc-nav-count="orders">0</span></a>
					<a href="#addresses" data-acc-nav="addresses"><span><?php esc_html_e('Sổ địa chỉ', 'soul'); ?></span><span data-acc-nav-count="addresses">0</span></a>
					<a href="#profile" data-acc-nav="profile"><span><?php esc_html_e('Thông tin tài khoản', 'soul'); ?></span><span></span></a>
					<button type="button" data-acc-logout><span><?php esc_html_e('Đăng xuất', 'soul'); ?></span><span></span></button>
				</nav>
			</aside>

			<div class="s-acc-main">
				<div class="s-acc-notice" data-acc-dash-notice hidden role="status"></div>

				<!-- Overview -->
				<div data-acc-panel="overview">
					<div class="s-acc-cards" data-acc-cards></div>
				</div>

				<!-- Orders list -->
				<div data-acc-panel="orders" hidden>
					<div class="s-acc-empty" data-acc-orders-empty hidden>
						<p><?php esc_html_e('Bạn chưa có đơn hàng nào.', 'soul'); ?></p>
						<a class="s-acc-btn s-acc-btn--primary" href="<?php echo esc_url($shop); ?>"><?php esc_html_e('Mua sắm', 'soul'); ?> ↗</a>
					</div>
					<ul class="s-acc-orders" data-acc-orders></ul>
				</div>

				<!-- Order detail -->
				<div data-acc-panel="order" hidden>
					<div class="s-acc-order-bar">
						<a href="#orders" data-acc-goto="orders">← <?php esc_html_e('Tất cả đơn hàng', 'soul'); ?></a>
						<div class="s-acc-order-bar__acts">
							<button type="button" class="s-acc-btn s-acc-btn--danger" data-acc-cancel hidden><?php esc_html_e('Hủy đơn', 'soul'); ?></button>
							<button type="button" class="s-acc-btn s-acc-btn--primary" data-acc-reorder><?php esc_html_e('Mua lại', 'soul'); ?></button>
						</div>
					</div>
					<div class="s-acc-form__alert" data-acc-order-cancelled hidden><?php esc_html_e('Đơn hàng đã được hủy.', 'soul'); ?></div>
					<ol class="s-acc-track" data-acc-track></ol>
					<div class="s-acc-blocks" data-acc-blocks></div>
					<ul class="s-acc-items" data-acc-items></ul>
					<dl class="s-acc-totals" data-acc-totals></dl>
				</div>

				<!-- Addresses -->
				<div data-acc-panel="addresses" hidden>
					<div class="s-acc-addrs" data-acc-addrs></div>
					<form class="s-acc-form s-acc-form--boxed" data-acc-addr-form hidden novalidate>
						<h2 data-acc-addr-title><?php esc_html_e('Địa chỉ mới', 'soul'); ?></h2>
						<div class="s-acc-fields">
							<div class="s-acc-field">
								<label for="ac-addr-name"><?php esc_html_e('Họ và tên', 'soul'); ?></label>
								<input id="ac-addr-name" name="name" type="text" autocomplete="name" required>
								<span class="s-acc-field__err" data-err-for="name" hidden></span>
							</div>
							<div class="s-acc-field">
								<label for="ac-addr-phone"><?php esc_html_e('Số điện thoại', 'soul'); ?></label>
								<input id="ac-addr-phone" name="phone" type="tel" autocomplete="tel" required>
								<span class="s-acc-field__err" data-err-for="phone" hidden></span>
							</div>
						</div>
						<div class="s-acc-field">
							<label for="ac-addr-address"><?php esc_html_e('Địa chỉ (số nhà, đường)', 'soul'); ?></label>
							<input id="ac-addr-address" name="address" type="text" autocomplete="street-address" required>
							<span class="s-acc-field__err" data-err-for="address" hidden></span>
						</div>
						<div class="s-acc-fields">
							<div class="s-acc-field">
								<label for="ac-addr-province"><?php esc_html_e('Tỉnh / Thành phố', 'soul'); ?></label>
								<select id="ac-addr-province" name="province" required>
									<option value=""><?php esc_html_e('Chọn tỉnh / thành', 'soul'); ?></option>
									<?php foreach ($provinces as $p) : ?>
										<option value="<?php echo esc_attr($p); ?>"><?php echo esc_html($p); ?></option>
									<?php endforeach; ?>
								</select>
								<span class="s-acc-field__err" data-err-for="province" hidden></span>
							</div>
							<div class="s-acc-field">
								<label for="ac-addr-ward"><?php esc_html_e('Phường / Xã', 'soul'); ?></label>
								<input id="ac-addr-ward" name="ward" type="text" required>
								<span class="s-acc-field__err" data-err-for="ward" hidden></span>
							</div>
						</div>
						<label class="s-acc-check">
							<input type="checkbox" name="def">
							<span><?php esc_html_e('Đặt làm địa chỉ mặc định', 'soul'); ?></span>
						</label>
						<div class="s-acc-form__acts">
							<button type="submit" class="s-acc-btn s-acc-btn--primary"><?php esc_html_e('Lưu địa chỉ', 'soul'); ?></button>
							<button type="button" class="s-acc-btn s-acc-btn--outline" data-acc-addr-cancel><?php esc_html_e('Hủy', 'soul'); ?></button>
						</div>
					</form>
				</div>

				<!-- Profile -->
				<div data-acc-panel="profile" hidden>
					<form class="s-acc-form s-acc-form--boxed" data-acc-profile-form novalidate>
						<h2><?php esc_html_e('Thông tin cá nhân', 'soul'); ?></h2>
						<div class="s-acc-fields">
							<div class="s-acc-field">
								<label for="ac-prof-name"><?php esc_html_e('Họ và tên', 'soul'); ?></label>
								<input id="ac-prof-name" name="name" type="text" autocomplete="name" required>
								<span class="s-acc-field__err" data-err-for="name" hidden></span>
							</div>
							<div class="s-acc-field">
								<label for="ac-prof-phone"><?php esc_html_e('Số điện thoại', 'soul'); ?></label>
								<input id="ac-prof-phone" name="phone" type="tel" autocomplete="tel" required>
								<span class="s-acc-field__err" data-err-for="phone" hidden></span>
							</div>
						</div>
						<div class="s-acc-field">
							<label for="ac-prof-email"><?php esc_html_e('Email', 'soul'); ?></label>
							<input id="ac-prof-email" name="email" type="email" readonly class="is-readonly">
						</div>
						<label class="s-acc-check">
							<input type="checkbox" name="marketing">
							<span><?php esc_html_e('Nhận email về mùa vụ mới, sự kiện và ưu đãi từ Soul.', 'soul'); ?></span>
						</label>
						<button type="submit" class="s-acc-btn s-acc-btn--primary"><?php esc_html_e('Lưu thay đổi', 'soul'); ?></button>
					</form>

					<form class="s-acc-form s-acc-form--boxed" data-acc-pw-form novalidate>
						<h2><?php esc_html_e('Đổi mật khẩu', 'soul'); ?></h2>
						<div class="s-acc-field">
							<label for="ac-pw-cur"><?php esc_html_e('Mật khẩu hiện tại', 'soul'); ?></label>
							<input id="ac-pw-cur" name="current" type="password" autocomplete="current-password" required>
							<span class="s-acc-field__err" data-err-for="current" hidden></span>
						</div>
						<div class="s-acc-fields">
							<div class="s-acc-field">
								<label for="ac-pw-npw"><?php esc_html_e('Mật khẩu (tối thiểu 8 ký tự)', 'soul'); ?></label>
								<input id="ac-pw-npw" name="password" type="password" autocomplete="new-password" required>
								<span class="s-acc-field__err" data-err-for="password" hidden></span>
							</div>
							<div class="s-acc-field">
								<label for="ac-pw-npw2"><?php esc_html_e('Nhập lại mật khẩu', 'soul'); ?></label>
								<input id="ac-pw-npw2" name="password2" type="password" autocomplete="new-password" required>
								<span class="s-acc-field__err" data-err-for="password2" hidden></span>
							</div>
						</div>
						<div class="s-acc-form__alert" data-acc-form-err hidden role="alert"></div>
						<button type="submit" class="s-acc-btn s-acc-btn--primary"><?php esc_html_e('Cập nhật mật khẩu', 'soul'); ?></button>
					</form>
				</div>
			</div>
		</section>
	</div>
</div>
<?php
get_footer();
