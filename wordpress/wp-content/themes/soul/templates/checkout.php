<?php
/**
 * Template Name: Checkout
 * Order capture — no online payment.
 *
 * @package Soul
 */
get_header();
?>
<section class="soul-container soul-checkout soul-page-shell" data-page="checkout">
	<header class="soul-page__header">
		<p class="soul-eyebrow"><?php esc_html_e('Đặt hàng', 'soul'); ?></p>
		<h1><?php esc_html_e('Giỏ hàng & gửi đơn', 'soul'); ?></h1>
		<ol class="soul-steps" aria-label="<?php esc_attr_e('Tiến trình', 'soul'); ?>">
			<li class="is-on">01 · <?php esc_html_e('Giỏ', 'soul'); ?></li>
			<li>02 · <?php esc_html_e('Thông tin', 'soul'); ?></li>
			<li>03 · <?php esc_html_e('Xác nhận', 'soul'); ?></li>
		</ol>
		<p><?php esc_html_e('Không thanh toán online — Soul lưu đơn và liên hệ xác nhận (COD hoặc chuyển khoản).', 'soul'); ?></p>
	</header>

	<div class="soul-checkout__grid">
		<div class="soul-checkout__cart">
			<h2><?php esc_html_e('Giỏ hàng', 'soul'); ?></h2>
			<div id="soul-cart-lines" class="soul-cart-lines"></div>
			<p class="soul-cart-empty" id="soul-cart-empty"><?php esc_html_e('Giỏ hàng đang trống.', 'soul'); ?></p>
			<p class="soul-subtotal"><?php esc_html_e('Tạm tính', 'soul'); ?>: <strong id="soul-subtotal">0₫</strong></p>
		</div>

		<form id="soul-checkout-form" class="soul-checkout__form" novalidate>
			<h2><?php esc_html_e('Thông tin nhận hàng', 'soul'); ?></h2>
			<label><?php esc_html_e('Họ tên', 'soul'); ?>
				<input type="text" name="name" required autocomplete="name">
			</label>
			<label><?php esc_html_e('Email', 'soul'); ?>
				<input type="email" name="email" required autocomplete="email">
			</label>
			<label><?php esc_html_e('Số điện thoại', 'soul'); ?>
				<input type="tel" name="phone" required autocomplete="tel">
			</label>
			<label><?php esc_html_e('Địa chỉ', 'soul'); ?>
				<textarea name="address" rows="3" required></textarea>
			</label>
			<label><?php esc_html_e('Ghi chú', 'soul'); ?>
				<textarea name="note" rows="2"></textarea>
			</label>
			<fieldset>
				<legend><?php esc_html_e('Phương thức (lưu trên đơn — không charge)', 'soul'); ?></legend>
				<label class="soul-radio"><input type="radio" name="payment" value="cod" checked> <?php esc_html_e('COD — thanh toán khi nhận', 'soul'); ?></label>
				<label class="soul-radio"><input type="radio" name="payment" value="bank"> <?php esc_html_e('Chuyển khoản (Soul sẽ gửi STK)', 'soul'); ?></label>
			</fieldset>
			<label class="soul-radio"><input type="checkbox" name="vat_needed" id="soul-vat-needed" value="1"> <?php esc_html_e('Xuất hóa đơn VAT', 'soul'); ?></label>
			<div id="soul-vat-fields" class="soul-vat-fields" hidden>
				<label><?php esc_html_e('Tên công ty', 'soul'); ?>
					<input type="text" name="vat_company" autocomplete="organization">
				</label>
				<label><?php esc_html_e('Mã số thuế', 'soul'); ?>
					<input type="text" name="vat_tax_id">
				</label>
				<label><?php esc_html_e('Email nhận HĐ', 'soul'); ?>
					<input type="email" name="vat_email" autocomplete="email">
				</label>
				<label><?php esc_html_e('Địa chỉ xuất HĐ', 'soul'); ?>
					<textarea name="vat_address" rows="2"></textarea>
				</label>
			</div>
			<p class="soul-hp" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></p>
			<p class="soul-form-error" id="soul-form-error" hidden></p>
			<button type="submit" class="soul-btn soul-btn--primary" id="soul-submit"><?php esc_html_e('Gửi đơn hàng', 'soul'); ?></button>
		</form>

		<div id="soul-checkout-done" class="soul-checkout__done" hidden>
			<h2><?php esc_html_e('Đã nhận đơn', 'soul'); ?></h2>
			<p><?php esc_html_e('Mã đơn:', 'soul'); ?> <strong id="soul-order-code"></strong></p>
			<p><?php esc_html_e('Soul sẽ liên hệ xác nhận. Không có giao dịch thanh toán online.', 'soul'); ?></p>
			<p><a class="soul-btn soul-btn--outline" href="<?php echo esc_url(get_post_type_archive_link('soul_product') ?: home_url('/')); ?>"><?php esc_html_e('Tiếp tục xem cà phê', 'soul'); ?></a></p>
		</div>
	</div>
</section>
<?php
get_footer();
