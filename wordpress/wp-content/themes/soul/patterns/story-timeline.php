<?php
/**
 * Title: Our Story — 07 Timeline
 * Slug: soul/story-timeline
 * Categories: soul-content
 */
$timeline = [
	['2018 – 2019', 'Những bước khởi đầu', 'Soul ra đời với Coffee Bar đầu tiên tại TP. Hồ Chí Minh, sau đó phát triển xưởng rang và cửa hàng flagship tại Buôn Ma Thuột.', '06-spaces/Soul-SG.jpg', 'Cửa hàng Soul đầu tiên tại TP. Hồ Chí Minh', false],
	['2020 – 2022', 'Mở rộng trải nghiệm', 'Phát triển các showroom và Coffee Bar tại Đà Nẵng, Hà Nội, đưa sản phẩm Soul đến gần hơn với người thưởng thức.', '06-spaces/Soul-HN.jpg', 'Showroom & Coffee Bar Soul Hà Nội', false],
	['2023 – 2024', 'Phát triển và ghi nhận chất lượng', 'Tiếp tục mở rộng hoạt động, đồng thời ghi dấu tại các cuộc thi cà phê trong nước và khu vực, nổi bật với kết quả tại Vietnam Green Coffee 2024.', '03c-awards/web/award-photo-1.jpg', 'Đội ngũ Soul nhận giải tại cuộc thi cà phê', false],
	['2025 – 2026', 'Kết nối những thị trường mới', 'Tiếp tục phát triển Fine Robusta, ghi nhận thành tích tại các cuộc thi chất lượng và giới thiệu cà phê Việt Nam thông qua những sự kiện, hoạt động kết nối quốc tế.', '03c-awards/web/award-photo-2.jpg', 'Soul tại sự kiện cà phê quốc tế', true],
];
?>
<!-- wp:group {"align":"full","className":"s-story-tl is-style-surface-paper","anchor":"journey","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull s-story-tl is-style-surface-paper" id="journey"><!-- wp:columns {"className":"s-story-head"} -->
<div class="wp-block-columns s-story-head"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"s-story-eye"} -->
<p class="s-story-eye">06 · Hành trình</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"s-story-h2"} -->
<h2 class="wp-block-heading s-story-h2">Tám năm, và hành trình vẫn tiếp nối</h2>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"s-story-p"} -->
<p class="s-story-p">Từ Coffee Bar đầu tiên năm 2018 đến các vùng nguyên liệu, xưởng rang và thị trường quốc tế, mỗi giai đoạn đánh dấu một bước phát triển mới của Soul.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"className":"s-story-tl__rail"} -->
<div class="wp-block-columns s-story-tl__rail">
<?php foreach ($timeline as $m) : ?>
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"s-story-tl__item<?php echo $m[5] ? ' s-story-tl__item--last' : ''; ?>","layout":{"type":"default"}} -->
<div class="wp-block-group s-story-tl__item<?php echo $m[5] ? ' s-story-tl__item--last' : ''; ?>"><!-- wp:paragraph {"className":"s-story-tl__years"} -->
<p class="s-story-tl__years"><?php echo esc_html($m[0]); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"s-story-tl__title"} -->
<h3 class="wp-block-heading s-story-tl__title"><?php echo esc_html($m[1]); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-story-tl__body"} -->
<p class="s-story-tl__body"><?php echo esc_html($m[2]); ?></p>
<!-- /wp:paragraph -->

<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"s-story-tl__media"} -->
<figure class="wp-block-image size-full s-story-tl__media"><img src="<?php echo esc_url(soul_img($m[3])); ?>" alt="<?php echo esc_attr($m[4]); ?>"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
