<?php
/**
 * Template Name: Checkout
 * SoT: html/Checkout.dc.html — cart / checkout / thank-you (hash steps).
 *
 * @package Soul
 */
get_header();

$shop     = get_post_type_archive_link('soul_product') ?: home_url('/products/');
$soulful  = get_term_by('slug', 'soulful-flavours', 'soul_collection');
$soulful_u = ($soulful && ! is_wp_error(get_term_link($soulful))) ? get_term_link($soulful) : $shop;
$help     = home_url('/help/');
$account  = home_url('/account/');
$elephant = soul_logo_uri('soul-elephant-ink.svg');
$ck       = function_exists('soul_checkout_settings') ? soul_checkout_settings() : [
	'shipping_methods' => false,
	'payment_methods'  => false,
	'hotline'          => function_exists('soul_contact') ? soul_contact('hotline_checkout') : '0969 648 148',
	'email'            => function_exists('soul_contact') ? soul_contact('email_contact') : 'contact@soulcoffee.vn',
	'pickup_stores'    => function_exists('soul_checkout_default_pickup_stores') ? soul_checkout_default_pickup_stores() : [],
];
$ship_on  = ! empty($ck['shipping_methods']);
$pay_on   = ! empty($ck['payment_methods']);
$hotline  = (string) ($ck['hotline'] ?? '0969 648 148');
$ck_email = (string) ($ck['email'] ?? 'contact@soulcoffee.vn');
$pickup   = is_array($ck['pickup_stores'] ?? null) ? $ck['pickup_stores'] : [];
?>
<div class="s-ck" data-page="checkout" data-ck-root
	data-ship-methods="<?php echo $ship_on ? '1' : '0'; ?>"
	data-pay-methods="<?php echo $pay_on ? '1' : '0'; ?>"
	data-hotline="<?php echo esc_attr($hotline); ?>"
	data-ck-email="<?php echo esc_attr($ck_email); ?>">
	<section class="s-ck-hero" id="top" aria-labelledby="ck-h" data-screen-label="01 Giỏ hàng · Tiêu đề">
		<nav class="s-ck-crumb" aria-label="<?php esc_attr_e('Breadcrumb', 'soul'); ?>">
			<a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Trang chủ', 'soul'); ?></a>
			<span class="s-ck-crumb__sep" aria-hidden="true">/</span>
			<a href="<?php echo esc_url($shop); ?>"><?php esc_html_e('Sản phẩm', 'soul'); ?></a>
			<span class="s-ck-crumb__sep" aria-hidden="true">/</span>
			<span class="s-ck-crumb__cur" data-ck-crumb><?php esc_html_e('Giỏ hàng', 'soul'); ?></span>
		</nav>
		<div class="s-ck-hero__row">
			<h1 class="s-ck-hero__title" id="ck-h" data-ck-title><?php esc_html_e('Giỏ hàng', 'soul'); ?></h1>
			<ol class="s-ck-steps" aria-label="<?php esc_attr_e('Tiến trình đặt hàng', 'soul'); ?>" data-ck-steps>
				<li class="s-ck-steps__item is-current" data-step="0" aria-current="step">
					<span class="s-ck-steps__n" data-step-n>1</span><?php esc_html_e('Giỏ hàng', 'soul'); ?>
				</li>
				<li class="s-ck-steps__item" data-step="1">
					<span class="s-ck-steps__n" data-step-n>2</span><?php esc_html_e('Thanh toán', 'soul'); ?>
				</li>
				<li class="s-ck-steps__item" data-step="2">
					<span class="s-ck-steps__n" data-step-n>3</span><?php esc_html_e('Hoàn tất', 'soul'); ?>
				</li>
			</ol>
		</div>
	</section>

	<!-- CART -->
	<section class="s-ck-empty" data-ck-view="cart-empty" data-screen-label="02 Giỏ hàng · Trống" hidden>
		<div class="s-ck-empty__box">
			<img src="<?php echo esc_url($elephant); ?>" alt="" width="56" height="56">
			<p class="s-ck-empty__title"><?php esc_html_e('Giỏ hàng của bạn đang trống', 'soul'); ?></p>
			<p class="s-ck-empty__body"><?php esc_html_e('Bắt đầu với bộ sưu tập Soulful 2026 hoặc những dòng Fine Robusta quen thuộc.', 'soul'); ?></p>
			<div class="s-ck-empty__actions">
				<a class="s-ck-btn s-ck-btn--primary" href="<?php echo esc_url($shop); ?>"><?php esc_html_e('Khám phá sản phẩm', 'soul'); ?> ↗</a>
				<a class="s-ck-btn s-ck-btn--outline" href="<?php echo esc_url($soulful_u); ?>">Soulful 2026</a>
			</div>
		</div>
	</section>

	<section class="s-ck-cart" data-ck-view="cart" data-screen-label="02 Giỏ hàng · Sản phẩm" hidden>
		<div class="s-ck-cart__main">
			<div class="s-ck-cart__bar">
				<span data-ck-count-label>0 <?php esc_html_e('sản phẩm', 'soul'); ?></span>
				<button type="button" class="s-ck-link" data-ck-clear><?php esc_html_e('Xóa giỏ hàng', 'soul'); ?></button>
			</div>
			<ul class="s-ck-lines" data-ck-lines></ul>
			<a class="s-ck-back" href="<?php echo esc_url($shop); ?>">← <?php esc_html_e('Tiếp tục mua sắm', 'soul'); ?></a>
		</div>
		<aside class="s-ck-aside" aria-label="<?php esc_attr_e('Tóm tắt đơn hàng', 'soul'); ?>">
			<div class="s-ck-aside__eye"><?php esc_html_e('Tóm tắt đơn hàng', 'soul'); ?></div>
			<div class="s-ck-aside__free">
				<div class="s-ck-aside__free-msg" data-ck-free-msg></div>
				<div class="s-ck-aside__free-track" aria-hidden="true"><div class="s-ck-aside__free-bar" data-ck-free-bar></div></div>
			</div>
			<dl class="s-ck-aside__dl">
				<div><dt><?php esc_html_e('Tạm tính', 'soul'); ?></dt><dd data-ck-subtotal>0₫</dd></div>
				<div><dt><?php esc_html_e('Giao hàng', 'soul'); ?></dt><dd data-ck-cart-ship><?php echo $ship_on ? esc_html__('Tính ở bước sau', 'soul') : esc_html__('Soul liên hệ xác nhận', 'soul'); ?></dd></div>
			</dl>
			<div class="s-ck-aside__total">
				<span><?php esc_html_e('Tổng tạm tính', 'soul'); ?></span>
				<strong data-ck-est>0₫</strong>
			</div>
			<a class="s-ck-btn s-ck-btn--primary s-ck-btn--block" href="#checkout" data-ck-go-checkout><?php esc_html_e('Tiến hành thanh toán', 'soul'); ?> →</a>
			<ul class="s-ck-assure">
				<li><span aria-hidden="true">—</span><?php esc_html_e('Rang mới mỗi tuần tại Buôn Ma Thuột', 'soul'); ?></li>
				<li><span aria-hidden="true">—</span><?php esc_html_e('Đổi trả trong 7 ngày nếu sản phẩm lỗi', 'soul'); ?></li>
				<li><span aria-hidden="true">—</span><?php
					echo esc_html(
						sprintf(
							/* translators: 1: hotline, 2: email */
							__('Hỗ trợ: %1$s · %2$s', 'soul'),
							$hotline,
							$ck_email
						)
					);
				?></li>
			</ul>
		</aside>
	</section>

	<!-- CHECKOUT FORM -->
	<section class="s-ck-pay" data-ck-view="checkout" data-screen-label="02 Thanh toán · Biểu mẫu" hidden>
		<form id="soul-checkout-form" class="s-ck-form" novalidate>
			<div class="s-ck-banner">
				<span><?php esc_html_e('Đã có tài khoản? Đăng nhập để điền nhanh thông tin và theo dõi đơn hàng.', 'soul'); ?></span>
				<a href="<?php echo esc_url($account); ?>#login"><?php esc_html_e('Đăng nhập', 'soul'); ?> ↗</a>
			</div>

			<fieldset class="s-ck-fs">
				<legend class="s-ck-fs__leg"><span>01</span><?php esc_html_e('Thông tin liên hệ', 'soul'); ?></legend>
				<div class="s-ck-row">
					<div class="s-ck-field">
						<label for="ck-email"><?php esc_html_e('Email', 'soul'); ?></label>
						<input id="ck-email" name="email" type="email" autocomplete="email" placeholder="ban@email.com" required>
						<span class="s-ck-field__err" data-err-for="email" hidden></span>
					</div>
					<div class="s-ck-field">
						<label for="ck-phone"><?php esc_html_e('Số điện thoại', 'soul'); ?></label>
						<input id="ck-phone" name="phone" type="tel" autocomplete="tel" placeholder="09xx xxx xxx" required>
						<span class="s-ck-field__err" data-err-for="phone" hidden></span>
					</div>
				</div>
				<div class="s-ck-row">
					<div class="s-ck-field">
						<label for="ck-name"><?php esc_html_e('Họ và tên', 'soul'); ?></label>
						<input id="ck-name" name="name" type="text" autocomplete="name" required>
						<span class="s-ck-field__err" data-err-for="name" hidden></span>
					</div>
				</div>
			</fieldset>

			<fieldset class="s-ck-fs">
				<legend class="s-ck-fs__leg"><span>02</span><?php esc_html_e('Giao hàng', 'soul'); ?></legend>

				<div class="s-ck-mode-note" data-ck-ship-notice <?php echo $ship_on ? 'hidden' : ''; ?>>
					<p class="s-ck-mode-note__title"><?php esc_html_e('Soul sẽ liên hệ để sắp xếp giao hàng', 'soul'); ?></p>
					<p class="s-ck-mode-note__body">
						<?php
						printf(
							/* translators: 1: hotline 2: email */
							esc_html__('Sau khi nhận đơn, admin sẽ gọi/email xác nhận địa chỉ và phí vận chuyển. Hotline %1$s · %2$s', 'soul'),
							esc_html($hotline),
							esc_html($ck_email)
						);
						?>
					</p>
				</div>

				<div data-ck-ship-methods <?php echo $ship_on ? '' : 'hidden'; ?>>
					<div class="s-ck-radios" data-ck-ships role="radiogroup" aria-label="<?php esc_attr_e('Giao hàng', 'soul'); ?>">
						<button type="button" class="s-ck-radio is-on" role="radio" aria-checked="true" data-ship="std">
							<span class="s-ck-radio__dot" aria-hidden="true"></span>
							<span class="s-ck-radio__copy"><span class="s-ck-radio__label"><?php esc_html_e('Giao hàng tiêu chuẩn', 'soul'); ?></span><span class="s-ck-radio__sub" data-ck-std-sub><?php esc_html_e('2–4 ngày làm việc · miễn phí từ 500.000₫', 'soul'); ?></span></span>
							<span class="s-ck-radio__fee" data-ck-std-fee><?php esc_html_e('Miễn phí', 'soul'); ?></span>
						</button>
						<button type="button" class="s-ck-radio" role="radio" aria-checked="false" data-ship="exp">
							<span class="s-ck-radio__dot" aria-hidden="true"></span>
							<span class="s-ck-radio__copy"><span class="s-ck-radio__label"><?php esc_html_e('Giao hàng nhanh', 'soul'); ?></span><span class="s-ck-radio__sub"><?php esc_html_e('1–2 ngày · nội thành TP.HCM, Hà Nội, Đà Nẵng', 'soul'); ?></span></span>
							<span class="s-ck-radio__fee">50.000₫</span>
						</button>
						<button type="button" class="s-ck-radio" role="radio" aria-checked="false" data-ship="pickup">
							<span class="s-ck-radio__dot" aria-hidden="true"></span>
							<span class="s-ck-radio__copy"><span class="s-ck-radio__label"><?php esc_html_e('Nhận tại cửa hàng', 'soul'); ?></span><span class="s-ck-radio__sub"><?php esc_html_e('Sẵn sàng sau 2 giờ trong giờ mở cửa', 'soul'); ?></span></span>
							<span class="s-ck-radio__fee"><?php esc_html_e('Miễn phí', 'soul'); ?></span>
						</button>
						<button type="button" class="s-ck-radio" role="radio" aria-checked="false" data-ship="intl">
							<span class="s-ck-radio__dot" aria-hidden="true"></span>
							<span class="s-ck-radio__copy"><span class="s-ck-radio__label"><?php esc_html_e('International Delivery · Giao hàng quốc tế', 'soul'); ?></span><span class="s-ck-radio__sub"><?php esc_html_e('Trao đổi & xác nhận qua email', 'soul'); ?></span></span>
							<span class="s-ck-radio__fee"><?php esc_html_e('Báo phí qua email', 'soul'); ?></span>
						</button>
					</div>
					<p class="s-ck-hint"><?php esc_html_e('Giao hàng tiêu chuẩn, giao nhanh và nhận tại cửa hàng áp dụng trong lãnh thổ Việt Nam.', 'soul'); ?></p>
				</div>
				<input type="hidden" name="shipping" value="<?php echo esc_attr($ship_on ? 'std' : 'arrange'); ?>" data-ck-ship-input>

				<div class="s-ck-stores" data-ck-stores hidden>
					<?php
					$i = 0;
					$first_store = '';
					foreach ($pickup as $sid => $st) :
						if ($i === 0) {
							$first_store = (string) $sid;
						}
						?>
						<button type="button" class="s-ck-store<?php echo $i === 0 ? ' is-on' : ''; ?>" role="radio" aria-checked="<?php echo $i === 0 ? 'true' : 'false'; ?>" data-store="<?php echo esc_attr((string) $sid); ?>">
							<span class="s-ck-store__name"><?php echo esc_html((string) ($st['name'] ?? '')); ?></span>
							<span class="s-ck-store__addr"><?php echo esc_html((string) ($st['addr'] ?? '')); ?></span>
						</button>
						<?php
						++$i;
					endforeach;
					?>
					<input type="hidden" name="store" value="<?php echo esc_attr($first_store); ?>" data-ck-store-input>
				</div>

				<div class="s-ck-addr" data-ck-addr>
					<div class="s-ck-row">
						<div class="s-ck-field">
							<label for="ck-address"><?php esc_html_e('Địa chỉ (số nhà, đường)', 'soul'); ?></label>
							<input id="ck-address" name="address" type="text" autocomplete="street-address">
							<span class="s-ck-field__err" data-err-for="address" hidden></span>
						</div>
					</div>
					<div class="s-ck-row" data-ck-vn-addr>
						<div class="s-ck-field">
							<label for="ck-province"><?php esc_html_e('Tỉnh / Thành phố', 'soul'); ?></label>
							<select id="ck-province" name="province" data-ck-province>
								<option value=""><?php esc_html_e('Chọn tỉnh / thành', 'soul'); ?></option>
							</select>
							<span class="s-ck-field__err" data-err-for="province" hidden></span>
						</div>
						<div class="s-ck-field">
							<label for="ck-ward"><?php esc_html_e('Phường / Xã', 'soul'); ?></label>
							<input id="ck-ward" name="ward" type="text">
							<span class="s-ck-field__err" data-err-for="ward" hidden></span>
						</div>
					</div>
					<div class="s-ck-row" data-ck-intl-addr hidden>
						<div class="s-ck-field">
							<label for="ck-city"><?php esc_html_e('Thành phố / Bang', 'soul'); ?></label>
							<input id="ck-city" name="city" type="text" autocomplete="address-level2">
							<span class="s-ck-field__err" data-err-for="city" hidden></span>
						</div>
						<div class="s-ck-field">
							<label for="ck-country"><?php esc_html_e('Quốc gia', 'soul'); ?></label>
							<input id="ck-country" name="country" type="text" autocomplete="country-name">
							<span class="s-ck-field__err" data-err-for="country" hidden></span>
						</div>
					</div>
				</div>

				<div class="s-ck-field s-ck-field--note">
					<label for="ck-note"><?php esc_html_e('Ghi chú đơn hàng (không bắt buộc)', 'soul'); ?></label>
					<textarea id="ck-note" name="note" rows="3" placeholder="<?php esc_attr_e('Ví dụ: xay cho phin, giao giờ hành chính…', 'soul'); ?>"></textarea>
				</div>
			</fieldset>

			<fieldset class="s-ck-fs">
				<legend class="s-ck-fs__leg"><span>03</span><?php esc_html_e('Thanh toán', 'soul'); ?></legend>

				<div class="s-ck-mode-note" data-ck-pay-notice <?php echo $pay_on ? 'hidden' : ''; ?>>
					<p class="s-ck-mode-note__title"><?php esc_html_e('Chưa mở thanh toán trực tuyến', 'soul'); ?></p>
					<p class="s-ck-mode-note__body">
						<?php
						printf(
							/* translators: 1: hotline 2: email */
							esc_html__('Hiện chưa có phương thức thanh toán trên website. Sau khi đặt hàng, admin sẽ liên hệ hướng dẫn thanh toán. Hotline %1$s · %2$s', 'soul'),
							esc_html($hotline),
							esc_html($ck_email)
						);
						?>
					</p>
				</div>

				<div data-ck-pay-methods <?php echo $pay_on ? '' : 'hidden'; ?>>
					<div class="s-ck-radios" data-ck-pays role="radiogroup" aria-label="<?php esc_attr_e('Thanh toán', 'soul'); ?>">
						<button type="button" class="s-ck-radio is-on" role="radio" aria-checked="true" data-pay="bank">
							<span class="s-ck-radio__dot" aria-hidden="true"></span>
							<span class="s-ck-radio__copy"><span class="s-ck-radio__label"><?php esc_html_e('Chuyển khoản ngân hàng', 'soul'); ?></span><span class="s-ck-radio__sub"><?php esc_html_e('Thông tin tài khoản hiển thị sau khi đặt hàng', 'soul'); ?></span></span>
						</button>
						<button type="button" class="s-ck-radio" role="radio" aria-checked="false" data-pay="wallet">
							<span class="s-ck-radio__dot" aria-hidden="true"></span>
							<span class="s-ck-radio__copy"><span class="s-ck-radio__label"><?php esc_html_e('Ví điện tử / thẻ (VNPay, MoMo)', 'soul'); ?></span><span class="s-ck-radio__sub"><?php esc_html_e('Chuyển đến cổng thanh toán an toàn', 'soul'); ?></span></span>
						</button>
					</div>
				</div>
				<input type="hidden" name="payment" value="<?php echo esc_attr($pay_on ? 'bank' : 'contact'); ?>" data-ck-pay-input>

				<label class="s-ck-check">
					<input type="checkbox" name="vat_needed" id="soul-vat-needed" value="1">
					<span><?php esc_html_e('Yêu cầu xuất hóa đơn VAT', 'soul'); ?></span>
				</label>
				<div id="soul-vat-fields" class="s-ck-vat" hidden>
					<div class="s-ck-row">
						<div class="s-ck-field">
							<label for="ck-vat-company"><?php esc_html_e('Tên công ty', 'soul'); ?></label>
							<input id="ck-vat-company" name="vat_company" type="text" autocomplete="organization">
							<span class="s-ck-field__err" data-err-for="vat_company" hidden></span>
						</div>
						<div class="s-ck-field">
							<label for="ck-vat-tax"><?php esc_html_e('Mã số thuế', 'soul'); ?></label>
							<input id="ck-vat-tax" name="vat_tax_id" type="text">
							<span class="s-ck-field__err" data-err-for="vat_tax_id" hidden></span>
						</div>
					</div>
					<div class="s-ck-row">
						<div class="s-ck-field s-ck-field--full">
							<label for="ck-vat-addr"><?php esc_html_e('Địa chỉ công ty', 'soul'); ?></label>
							<input id="ck-vat-addr" name="vat_address" type="text">
							<span class="s-ck-field__err" data-err-for="vat_address" hidden></span>
						</div>
					</div>
					<div class="s-ck-row">
						<div class="s-ck-field">
							<label for="ck-vat-buyer"><?php esc_html_e('Tên người mua hàng (không bắt buộc)', 'soul'); ?></label>
							<input id="ck-vat-buyer" name="vat_buyer" type="text">
						</div>
						<div class="s-ck-field">
							<label for="ck-vat-email"><?php esc_html_e('Email nhận hóa đơn', 'soul'); ?></label>
							<input id="ck-vat-email" name="vat_email" type="email" autocomplete="email">
							<span class="s-ck-field__err" data-err-for="vat_email" hidden></span>
						</div>
					</div>
					<p class="s-ck-vat__note"><?php esc_html_e('Hóa đơn sẽ được xuất trong vòng 48 giờ (không bao gồm Thứ 7, Chủ nhật và ngày lễ) kể từ khi thanh toán thành công.', 'soul'); ?></p>
				</div>
			</fieldset>

			<div class="s-ck-submit">
				<div class="s-ck-form-alert" id="soul-form-error" role="alert" hidden></div>
				<p class="soul-hp" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></p>
				<button type="submit" class="s-ck-btn s-ck-btn--primary s-ck-btn--block s-ck-btn--lg" id="soul-submit" data-ck-place><?php esc_html_e('Đặt hàng', 'soul'); ?></button>
				<p class="s-ck-terms"><?php esc_html_e('Bằng việc đặt hàng, bạn đồng ý với chính sách giao hàng, đổi trả và bảo mật của Soul.', 'soul'); ?></p>
				<a class="s-ck-back" href="#"><?php esc_html_e('← Quay lại giỏ hàng', 'soul'); ?></a>
			</div>
		</form>

		<aside class="s-ck-aside" aria-label="<?php esc_attr_e('Tóm tắt đơn hàng', 'soul'); ?>">
			<div class="s-ck-aside__head">
				<span class="s-ck-aside__eye"><?php esc_html_e('Tóm tắt đơn hàng', 'soul'); ?></span>
				<a href="#" data-ck-go-cart><?php esc_html_e('Sửa', 'soul'); ?></a>
			</div>
			<ul class="s-ck-mini" data-ck-mini></ul>
			<div class="s-ck-code">
				<label for="ck-code"><?php esc_html_e('Mã giảm giá', 'soul'); ?></label>
				<div class="s-ck-code__row">
					<input id="ck-code" type="text" data-ck-code placeholder="<?php esc_attr_e('Nhập mã', 'soul'); ?>" autocomplete="off">
					<button type="button" class="s-ck-btn s-ck-btn--outline s-ck-btn--sm" data-ck-apply><?php esc_html_e('Áp dụng', 'soul'); ?></button>
				</div>
				<span class="s-ck-code__msg" data-ck-code-msg hidden></span>
			</div>
			<dl class="s-ck-aside__dl" data-ck-lines></dl>
			<div class="s-ck-aside__total">
				<span><?php esc_html_e('Tổng cộng', 'soul'); ?></span>
				<strong data-ck-total>0₫</strong>
			</div>
		</aside>
	</section>

	<!-- DONE -->
	<section class="s-ck-done" data-ck-view="done" data-screen-label="02 Hoàn tất · Xác nhận" hidden>
		<div class="s-ck-done__main">
			<div class="s-ck-done__hero">
				<div class="s-ck-done__code" data-ck-order-label><?php esc_html_e('Đơn hàng', 'soul'); ?> <span id="soul-order-code"></span></div>
				<p class="s-ck-done__thanks" data-ck-thanks></p>
				<p class="s-ck-done__body" data-ck-done-body></p>
			</div>
			<div class="s-ck-bank" data-ck-bank hidden>
				<div class="s-ck-aside__eye"><?php esc_html_e('Thông tin chuyển khoản', 'soul'); ?></div>
				<dl class="s-ck-bank__dl" data-ck-bank-rows></dl>
			</div>
			<div class="s-ck-mode-note" data-ck-done-contact hidden>
				<p class="s-ck-mode-note__title"><?php esc_html_e('Soul sẽ liên hệ bạn', 'soul'); ?></p>
				<p class="s-ck-mode-note__body" data-ck-done-contact-body></p>
			</div>
			<div class="s-ck-blocks" data-ck-blocks></div>
			<ol class="s-ck-track" data-ck-track aria-label="<?php esc_attr_e('Trạng thái đơn', 'soul'); ?>"></ol>
			<div class="s-ck-done__actions">
				<a class="s-ck-btn s-ck-btn--primary" href="<?php echo esc_url($account); ?>" data-ck-account-cta><?php esc_html_e('Tạo tài khoản để theo dõi', 'soul'); ?> ↗</a>
				<a class="s-ck-btn s-ck-btn--outline" href="<?php echo esc_url($shop); ?>"><?php esc_html_e('Tiếp tục mua sắm', 'soul'); ?></a>
			</div>
		</div>
		<aside class="s-ck-aside" aria-label="<?php esc_attr_e('Tóm tắt đơn hàng', 'soul'); ?>">
			<div class="s-ck-aside__eye"><?php esc_html_e('Tóm tắt đơn hàng', 'soul'); ?></div>
			<ul class="s-ck-mini" data-ck-done-mini></ul>
			<dl class="s-ck-aside__dl" data-ck-done-lines></dl>
			<div class="s-ck-aside__total">
				<span><?php esc_html_e('Tổng cộng', 'soul'); ?></span>
				<strong data-ck-done-total>0₫</strong>
			</div>
		</aside>
	</section>

	<section class="s-ck-missing" data-ck-view="missing" hidden>
		<div class="s-ck-missing__box">
			<p><?php esc_html_e('Không tìm thấy đơn hàng.', 'soul'); ?></p>
			<a class="s-ck-btn s-ck-btn--outline" href="<?php echo esc_url($shop); ?>"><?php esc_html_e('Tiếp tục mua sắm', 'soul'); ?></a>
		</div>
	</section>
</div>
<?php
get_footer();
