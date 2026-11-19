<?php
/**
 * Gutenberg HTML for marketing pages (seeded, then editable).
 *
 * @package Soul
 */

declare(strict_types=1);

function soul_url_shop(): string {
	return esc_url(get_post_type_archive_link('soul_product') ?: home_url('/products/'));
}

function soul_url_soulful(): string {
	$t = get_term_by('slug', 'soulful-flavours', 'soul_collection');
	return esc_url($t ? get_term_link($t) : soul_url_shop());
}

function soul_url_spaces(): string {
	return esc_url(get_post_type_archive_link('soul_space') ?: home_url('/spaces/'));
}

function soul_home_full_content(): string {
	$shop    = soul_url_shop();
	$soulful = soul_url_soulful();
	$spaces  = soul_url_spaces();
	$story   = esc_url(home_url('/our-story/'));
	$sol     = esc_url(home_url('/coffee-solutions/'));

	return <<<HTML
<!-- wp:group {"align":"full","className":"is-style-surface-paper soul-hero","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-paper soul-hero"><!-- wp:paragraph {"className":"soul-eyebrow"} -->
<p class="soul-eyebrow">Buôn Ma Thuột, Việt Nam</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1,"fontSize":"hero"} -->
<h1 class="wp-block-heading has-hero-font-size">Một thế hệ mới của Robusta Việt Nam</h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"is-style-lead"} -->
<p class="is-style-lead">Soul lớn lên từ Buôn Ma Thuột, nơi Robusta đã gắn với đời sống qua nhiều thế hệ. Hôm nay chúng tôi tiếp tục câu chuyện ấy bằng vùng nguyên liệu, sơ chế, rang và pha chế.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-primary"} -->
<div class="wp-block-button is-style-primary"><a class="wp-block-button__link wp-element-button" href="{$shop}">Khám phá cà phê ↗</a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#story">Câu chuyện của Soul</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"is-style-surface-sand","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-sand" id="shop"><!-- wp:paragraph {"className":"soul-eyebrow"} -->
<p class="soul-eyebrow">Cà phê của Soul</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Khám phá các dòng cà phê của Soul</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Từ nhân xanh cho nhà rang đến cà phê rang cho espresso, phin, pour-over và ủ lạnh.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-primary"} -->
<div class="wp-block-button is-style-primary"><a class="wp-block-button__link wp-element-button" href="{$shop}">Xem tất cả sản phẩm ↗</a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="{$soulful}">Soulful Collection ↗</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"is-style-surface-ink","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-ink" id="story"><!-- wp:paragraph {"className":"soul-eyebrow"} -->
<p class="soul-eyebrow">Crafted by Vietnamese Soul</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Một thế hệ mới lớn lên cùng cà phê</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Soul làm việc với cà phê xuyên suốt từ vùng nguyên liệu, thu hái, sơ chế, đánh giá nhân xanh đến rang và pha chế — để nhìn sâu hơn vào những gì vốn đã quen thuộc.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="{$story}">Tìm hiểu về Soul ↗</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"is-style-surface-sand","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-sand" id="why"><!-- wp:heading -->
<h2 class="wp-block-heading">Vì sao chọn Soul?</h2>
<!-- /wp:heading -->
<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">01 · Buôn Ma Thuột</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>500 ha vùng liên kết nguyên liệu tại Tây Nguyên.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">02 · Fine Robusta</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>87.21 điểm · Top 1 Robusta · VCPC 2026.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">03 · Từ vùng đến tách</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Q-Grader · SCA Roaster · SCA Barista trong đội ngũ.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">04 · Lên men bản địa</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Soulful 2026: Cay · Nồng · Thơm · Ngọt.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"is-style-surface-ink","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-ink" id="soulful"><!-- wp:paragraph {"className":"soul-eyebrow"} -->
<p class="soul-eyebrow">New crop: Soulful Collection 2026</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Từ bản địa, thành bản sắc</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Bốn tính cách hương vị gắn với những vùng đất khác nhau của Tây Nguyên.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-yellow"} -->
<div class="wp-block-button is-style-yellow"><a class="wp-block-button__link wp-element-button" href="{$soulful}">Khám phá Soulful 2026 ↗</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"is-style-surface-sand","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-sand" id="solutions"><!-- wp:paragraph {"className":"soul-eyebrow"} -->
<p class="soul-eyebrow">Coffee Solutions</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Giải pháp cà phê cho đối tác</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Nhân xanh · Cà phê rang · Đào tạo · Workshop &amp; sự kiện.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-primary"} -->
<div class="wp-block-button is-style-primary"><a class="wp-block-button__link wp-element-button" href="{$sol}">Tìm hiểu Solutions ↗</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
<!-- wp:html -->
<div class="soul-form-embed" id="contact">
<form class="soul-lead-form" data-soul-form="contact" data-source="home-b2b">
<p class="soul-eyebrow">Form liên hệ</p>
<label>Họ tên<input name="name" required></label>
<label>Doanh nghiệp<input name="business"></label>
<label>Email<input type="email" name="email" required></label>
<label>Số điện thoại<input name="phone"></label>
<label>Quan tâm đến<input name="topic" placeholder="Nhân xanh, rang, đào tạo…"></label>
<label>Nội dung<textarea name="message" rows="3"></textarea></label>
<p class="soul-form-msg" hidden></p>
<p class="soul-hp" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></p>
<button type="submit" class="soul-btn soul-btn--primary">Gửi thông tin</button>
</form>
</div>
<!-- /wp:html --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"is-style-surface-paper","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-paper" id="spaces"><!-- wp:paragraph {"className":"soul-eyebrow"} -->
<p class="soul-eyebrow">Cửa hàng</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Ghé Soul</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Buôn Ma Thuột · Sài Gòn · Hà Nội · Đà Nẵng · Bà Nà.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="{$spaces}">Khám phá cửa hàng ↗</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"is-style-surface-yellow","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-yellow" id="newsletter"><!-- wp:heading -->
<h2 class="wp-block-heading">Theo dõi những gì sắp diễn ra tại Soul</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Cà phê mới, mùa vụ, câu chuyện từ vùng nguyên liệu.</p>
<!-- /wp:paragraph -->
<!-- wp:html -->
<form class="soul-lead-form soul-newsletter-form" data-soul-form="newsletter">
<label>Email của bạn<input type="email" name="email" required placeholder="ban@email.com"></label>
<p class="soul-hp" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></p>
<p class="soul-form-msg" hidden></p>
<button type="submit" class="soul-btn soul-btn--primary">Đăng ký</button>
</form>
<!-- /wp:html --></div>
<!-- /wp:group -->
HTML;
}

function soul_page_our_story_content(): string {
	return <<<HTML
<!-- wp:group {"align":"full","className":"is-style-surface-paper","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-paper"><!-- wp:paragraph {"className":"soul-eyebrow"} -->
<p class="soul-eyebrow">Về Soul</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1,"fontSize":"hero"} -->
<h1 class="wp-block-heading has-hero-font-size">Từ bản địa, thành bản sắc</h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"is-style-lead"} -->
<p class="is-style-lead">Soul lớn lên từ Buôn Ma Thuột — tiếp tục câu chuyện Robusta Việt Nam bằng cách tiếp cận mới về nguyên liệu, sơ chế và rang.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"is-style-surface-ink","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-ink" id="manifesto"><!-- wp:heading -->
<h2 class="wp-block-heading">Manifesto</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Chúng tôi tin Robusta Việt Nam có thể thể hiện nhiều hơn khi nguyên liệu, quá trình sau thu hoạch và kỹ thuật rang được chăm chút kỹ hơn.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"is-style-surface-sand","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-sand" id="philosophy"><!-- wp:heading -->
<h2 class="wp-block-heading">Triết lý</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Từ vùng nguyên liệu đến tách: sơ chế, lên men bản địa, đánh giá cảm quan, phát triển hồ sơ rang và pha chế trong cùng một quá trình.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"is-style-surface-paper","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-paper" id="journey"><!-- wp:heading -->
<h2 class="wp-block-heading">Hành trình</h2>
<!-- /wp:heading -->
<!-- wp:list {"ordered":true} -->
<ol class="wp-block-list"><!-- wp:list-item -->
<li>Gắn với Buôn Ma Thuột và vùng liên kết nguyên liệu</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Phát triển Fine Robusta và chứng nhận chuyên môn</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Soulful Collection — nghiên cứu hương vị theo mùa vụ</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Mở rộng spaces và giải pháp cho đối tác</li>
<!-- /wp:list-item --></ol>
<!-- /wp:list --></div>
<!-- /wp:group -->
HTML;
}

function soul_page_solutions_content(): string {
	return <<<HTML
<!-- wp:group {"align":"full","className":"is-style-surface-paper","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-paper"><!-- wp:paragraph {"className":"soul-eyebrow"} -->
<p class="soul-eyebrow">Coffee Solutions</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1,"fontSize":"hero"} -->
<h1 class="wp-block-heading has-hero-font-size">Giải pháp cà phê cho đối tác</h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"is-style-lead"} -->
<p class="is-style-lead">Soul làm việc cùng nhà rang, quán cà phê và doanh nghiệp từ lựa chọn nguyên liệu đến đào tạo và vận hành.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"is-style-surface-sand","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-sand" id="capacity"><!-- wp:heading -->
<h2 class="wp-block-heading">Năng lực</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>20–60 tấn/tháng · 500 ha vùng liên kết · đội ngũ Q-Grader / SCA.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"is-style-surface-paper","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-paper" id="services"><!-- wp:heading -->
<h2 class="wp-block-heading">Dịch vụ</h2>
<!-- /wp:heading -->
<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li><strong>Nhân xanh</strong> — Fine Robusta, Robusta, Arabica, Liberica theo mục tiêu rang và sản lượng.</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><strong>Cà phê rang</strong> — phát triển lựa chọn phù hợp menu và thiết bị.</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><strong>Đào tạo</strong> — cảm quan, pha chế, vận hành.</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><strong>Workshop &amp; sự kiện</strong> — trải nghiệm specialty cho doanh nghiệp và thương hiệu.</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"is-style-surface-sand","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-sand" id="contact"><!-- wp:heading -->
<h2 class="wp-block-heading">Liên hệ đối tác</h2>
<!-- /wp:heading -->
<!-- wp:html -->
<form class="soul-lead-form" data-soul-form="contact" data-source="solutions">
<label>Họ tên<input name="name" required></label>
<label>Doanh nghiệp<input name="business"></label>
<label>Email<input type="email" name="email" required></label>
<label>Số điện thoại<input name="phone"></label>
<label>Quan tâm đến<input name="topic" placeholder="Nhân xanh / rang / đào tạo / sự kiện"></label>
<label>Nội dung<textarea name="message" rows="4"></textarea></label>
<p class="soul-hp" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></p>
<p class="soul-form-msg" hidden></p>
<button type="submit" class="soul-btn soul-btn--primary">Gửi yêu cầu</button>
</form>
<!-- /wp:html --></div>
<!-- /wp:group -->
HTML;
}

function soul_page_help_content(): string {
	$shop = soul_url_shop();
	return <<<HTML
<!-- wp:group {"align":"full","className":"is-style-surface-paper","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-paper"><!-- wp:paragraph {"className":"soul-eyebrow"} -->
<p class="soul-eyebrow">Hỗ trợ</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1,"fontSize":"hero"} -->
<h1 class="wp-block-heading has-hero-font-size">Câu hỏi thường gặp</h1>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Đặt hàng, giao hàng, đổi trả và cách Soul nhận đơn (không thanh toán online trên website).</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"is-style-surface-sand","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-sand" id="faq"><!-- wp:details {"className":"is-style-faq"} -->
<details class="wp-block-details is-style-faq"><summary>Làm sao để đặt hàng?</summary><!-- wp:paragraph -->
<p>Thêm sản phẩm vào giỏ, vào trang Checkout, điền thông tin và gửi đơn. Soul lưu đơn và liên hệ xác nhận — không trừ tiền tự động trên web.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->
<!-- wp:details {"className":"is-style-faq"} -->
<details class="wp-block-details is-style-faq"><summary>Thanh toán như thế nào?</summary><!-- wp:paragraph -->
<p>Trên đơn bạn chọn <strong>COD</strong> hoặc <strong>chuyển khoản</strong>. Đây là preference lưu trên đơn; Soul xác nhận và hướng dẫn khi liên hệ. Website không tích hợp cổng thanh toán.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->
<!-- wp:details {"className":"is-style-faq"} -->
<details class="wp-block-details is-style-faq"><summary>Phí giao hàng?</summary><!-- wp:paragraph -->
<p>Giao tiêu chuẩn thường 30.000₫ (2–4 ngày làm việc); miễn phí từ đơn 500.000₫ (chính sách có thể điều chỉnh khi Soul xác nhận đơn).</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->
<!-- wp:details {"className":"is-style-faq"} -->
<details class="wp-block-details is-style-faq"><summary>Đổi trả?</summary><!-- wp:paragraph -->
<p>Liên hệ trong 48 giờ nếu sản phẩm lỗi, hư vận chuyển hoặc giao sai — kèm mã đơn và ảnh. Không áp dụng đổi vì lý do khẩu vị với sản phẩm đã mở.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"is-style-surface-paper","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-paper" id="shipping"><!-- wp:heading -->
<h2 class="wp-block-heading">Giao hàng</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Soul rang theo mẻ nhỏ tại Buôn Ma Thuột và giao trong Việt Nam. Đơn xanh / quốc tế: trao đổi qua email.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"is-style-surface-sand","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-sand" id="returns"><!-- wp:heading -->
<h2 class="wp-block-heading">Đổi trả</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Chấp nhận với hàng lỗi / sai / hư vận chuyển. Liên hệ Soul kèm bằng chứng trong 48 giờ.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"is-style-surface-paper","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-paper" id="payment"><!-- wp:heading -->
<h2 class="wp-block-heading">Thanh toán</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p><strong>Không thanh toán online trên website.</strong> Sau khi gửi đơn, Soul liên hệ để xác nhận và thỏa thuận COD hoặc chuyển khoản.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"is-style-surface-sand","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-sand" id="privacy"><!-- wp:heading -->
<h2 class="wp-block-heading">Bảo mật</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Soul chỉ dùng thông tin để xử lý đơn, chăm sóc khách hàng và gửi tin bạn đã đăng ký.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"is-style-surface-paper","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-paper" id="contact"><!-- wp:heading -->
<h2 class="wp-block-heading">Liên hệ hỗ trợ</h2>
<!-- /wp:heading -->
<!-- wp:html -->
<form class="soul-lead-form" data-soul-form="contact" data-source="help">
<label>Họ tên<input name="name" required></label>
<label>Email<input type="email" name="email" required></label>
<label>Chủ đề<input name="topic" placeholder="Đơn hàng, giao hàng, đổi trả…"></label>
<label>Nội dung<textarea name="message" rows="4" required></textarea></label>
<p class="soul-hp" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></p>
<p class="soul-form-msg" hidden></p>
<button type="submit" class="soul-btn soul-btn--primary">Gửi</button>
</form>
<!-- /wp:html -->
<!-- wp:paragraph -->
<p><a href="{$shop}">Tiếp tục xem sản phẩm ↗</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
HTML;
}
