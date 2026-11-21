<?php
/**
 * Title: New Crop — 01 Opening (split)
 * Slug: soul/newcrop-opening-split
 * Categories: soul-layout
 */
$img = soul_img('01-hero/SOUL2024_DSF8608_edited.jpg');
$home = esc_url(home_url('/'));
?>
<!-- wp:columns {"align":"full","className":"s-newcrop-open","anchor":"opening"} -->
<div class="wp-block-columns alignfull s-newcrop-open" id="opening"><!-- wp:column {"width":"50%","className":"s-newcrop-open__copy"} -->
<div class="wp-block-column s-newcrop-open__copy" style="flex-basis:50%"><!-- wp:paragraph {"className":"s-newcrop-open__crumb"} -->
<p class="s-newcrop-open__crumb"><a href="<?php echo $home; ?>">Trang chủ</a> / Mùa vụ mới</p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"s-newcrop-open__body","layout":{"type":"default"}} -->
<div class="wp-block-group s-newcrop-open__body"><!-- wp:paragraph {"className":"s-newcrop-eye s-newcrop-eye--bar"} -->
<p class="s-newcrop-eye s-newcrop-eye--bar">New Crop · 2027</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"s-newcrop-open__title"} -->
<h1 class="wp-block-heading s-newcrop-open__title">Đi sâu vào một vùng đất</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-newcrop-open__tagline"} -->
<p class="s-newcrop-open__tagline">Mùa vụ 2027, Soul ở lại lâu hơn với Cư Bao để hiểu đất, hiểu cây và hiểu những người làm ra hạt cà phê.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"s-newcrop-open__cta"} -->
<div class="wp-block-buttons s-newcrop-open__cta"><!-- wp:button {"className":"is-style-primary"} -->
<div class="wp-block-button is-style-primary"><a class="wp-block-button__link wp-element-button" href="#story">Khám phá ↓</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"s-newcrop-open__meta","layout":{"type":"default"}} -->
<div class="wp-block-group s-newcrop-open__meta"><!-- wp:paragraph {"className":"s-newcrop-open__meta-l"} -->
<p class="s-newcrop-open__meta-l">01 / Opening</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-newcrop-open__meta-r"} -->
<p class="s-newcrop-open__meta-r">Cư Bao · Buôn Hồ · Đắk Lắk</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"50%"} -->
<div class="wp-block-column" style="flex-basis:50%"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"s-newcrop-open__media"} -->
<figure class="wp-block-image size-full s-newcrop-open__media"><img src="<?php echo esc_url($img); ?>" alt="Vườn cà phê Robusta tại vùng nguyên liệu của Soul"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
