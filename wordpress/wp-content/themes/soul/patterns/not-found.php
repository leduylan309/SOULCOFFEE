<?php
/**
 * Title: 404 — Not found
 * Slug: soul/not-found
 * Categories: soul-pages
 * Description: SoT html/404.dc.html — ink shell, search, path links.
 */
$shop      = get_post_type_archive_link('soul_product') ?: home_url('/products/');
$soulful   = get_term_by('slug', 'soulful-flavours', 'soul_collection');
$soulful_u = ($soulful && ! is_wp_error(get_term_link($soulful))) ? get_term_link($soulful) : $shop;
$spaces    = get_post_type_archive_link('soul_space') ?: home_url('/spaces/');
$help      = home_url('/help/');
$logo      = esc_url(soul_logo_uri('soul-logo-full-yellow.svg'));
?>
<!-- wp:group {"align":"full","className":"s-404 soul-404","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull s-404 soul-404"><!-- wp:group {"className":"s-404__top","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group s-404__top"><!-- wp:image {"width":"auto","height":34,"sizeSlug":"full","linkDestination":"custom","className":"s-404__brand"} -->
<figure class="wp-block-image size-full is-resized s-404__brand"><a href="/"><img src="<?php echo $logo; ?>" alt="SOUL" style="height:34px;width:auto"/></a></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:columns {"className":"s-404__main"} -->
<div class="wp-block-columns s-404__main"><!-- wp:column {"className":"s-404__copy"} -->
<div class="wp-block-column s-404__copy"><!-- wp:paragraph {"className":"s-404__eye"} -->
<p class="s-404__eye">Không tìm thấy trang</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-404__num"} -->
<p class="s-404__num">404</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"s-404__title"} -->
<h1 class="wp-block-heading s-404__title">Tách này chưa được pha.</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-404__body"} -->
<p class="s-404__body">Trang bạn tìm có thể đã được chuyển, đổi tên hoặc không còn tồn tại. Thử tìm kiếm, hoặc chọn một lối đi bên cạnh.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"s-404__nav"} -->
<div class="wp-block-column s-404__nav"><!-- wp:paragraph {"className":"s-404__nav-eye"} -->
<p class="s-404__nav-eye">Đi tiếp</p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"s-404__links"} -->
<ul class="wp-block-list s-404__links"><!-- wp:list-item -->
<li><a href="/">Trang chủ</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url($shop); ?>">Sản phẩm</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url($soulful_u); ?>">Soulful Collection 2026</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url($spaces); ?>">Cửa hàng Soul</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url($help); ?>">Câu hỏi thường gặp</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url($help); ?>#contact">Liên hệ</a></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:paragraph {"className":"s-404__foot"} -->
<p class="s-404__foot">Crafted by Vietnamese Soul · © SOUL Fine Robusta</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
