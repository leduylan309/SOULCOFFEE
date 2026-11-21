<?php
/**
 * Title: Solutions — 01 Hero
 * Slug: soul/solutions-hero
 * Categories: soul-layout
 */
$home = esc_url(home_url('/'));
$img = soul_img('05-solutions/DSCF9134_edited.jpg');
$strip = [
	['01', 'Nhân xanh', '#green'],
	['02', 'Cà phê rang', '#roast'],
	['03', 'Đào tạo', '#training'],
	['04', 'Sự kiện', '#events'],
	['05', 'Quà tặng', '#gifts'],
];
?>
<!-- wp:columns {"align":"full","className":"s-sol-hero","anchor":"top","layout":{"type":"default"}} -->
<div class="wp-block-columns alignfull s-sol-hero" id="top"><!-- wp:column {"className":"s-sol-hero__copy"} -->
<div class="wp-block-column s-sol-hero__copy"><!-- wp:paragraph {"className":"s-sol-hero__crumb"} -->
<p class="s-sol-hero__crumb"><a href="<?php echo $home; ?>">Trang chủ</a> / Giải pháp cà phê</p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"s-sol-hero__body","layout":{"type":"default"}} -->
<div class="wp-block-group s-sol-hero__body"><!-- wp:paragraph {"className":"s-sol-eye s-sol-eye--bar"} -->
<p class="s-sol-eye s-sol-eye--bar">Coffee Solutions · HORECA &amp; doanh nghiệp</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"s-sol-hero__title"} -->
<h1 class="wp-block-heading s-sol-hero__title">Giải pháp cà phê cho đối tác</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-sol-hero__lead"} -->
<p class="s-sol-hero__lead">Soul làm việc cùng nhà rang, quán cà phê, nhà hàng, khách sạn và doanh nghiệp, từ lựa chọn nguyên liệu đến phát triển sản phẩm, đào tạo và vận hành.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"s-sol-hero__ctas"} -->
<div class="wp-block-buttons s-sol-hero__ctas"><!-- wp:button {"className":"s-sol-hero__cta--ink"} -->
<div class="wp-block-button s-sol-hero__cta--ink"><a class="wp-block-button__link wp-element-button" href="#contact">Gửi yêu cầu hợp tác ↗</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"s-sol-hero__cta--ghost"} -->
<div class="wp-block-button s-sol-hero__cta--ghost"><a class="wp-block-button__link wp-element-button" href="#capacity">Xem năng lực</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:columns {"className":"s-sol-hero__strip"} -->
<div class="wp-block-columns s-sol-hero__strip">
<?php foreach ($strip as $c) : ?>
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph -->
<p><a href="<?php echo esc_attr($c[2]); ?>"><span class="s-sol-n"><?php echo esc_html($c[0]); ?></span><span><?php echo esc_html($c[1]); ?></span></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"s-sol-hero__media"} -->
<figure class="wp-block-image size-full s-sol-hero__media"><img src="<?php echo esc_url($img); ?>" alt="Bàn cupping với mẫu nhân xanh và túi Soulful"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
