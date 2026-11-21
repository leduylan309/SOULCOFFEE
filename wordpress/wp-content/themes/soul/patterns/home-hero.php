<?php
/**
 * Title: Home — 01 Hero
 * Slug: soul/home-hero
 * Categories: soul-layout
 * Keywords: home, hero
 */
$img = soul_img('01-hero/SOUL2024_DSF8608_edited.jpg');
$shop = soul_home_shop_url();
$sol = esc_url(home_url('/coffee-solutions/'));
$rang = soul_home_term_url('ca-phe-rang');
$green = soul_home_term_url('ca-phe-nhan-xanh');
?>
<!-- wp:columns {"align":"full","className":"s-home-hero","anchor":"top"} -->
<div class="wp-block-columns alignfull s-home-hero" id="top"><!-- wp:column {"width":"50%","className":"s-home-hero__copy"} -->
<div class="wp-block-column s-home-hero__copy" style="flex-basis:50%"><!-- wp:paragraph {"className":"s-home-hero__eyebrow"} -->
<p class="s-home-hero__eyebrow">Buôn Ma Thuột, Việt Nam</p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"s-home-hero__body","layout":{"type":"default"}} -->
<div class="wp-block-group s-home-hero__body"><!-- wp:heading {"level":1,"className":"s-home-hero__title"} -->
<h1 class="wp-block-heading s-home-hero__title">Một thế hệ mới của Robusta Việt Nam</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-home-hero__lead"} -->
<p class="s-home-hero__lead">Soul lớn lên từ Buôn Ma Thuột, nơi Robusta đã gắn với đời sống qua nhiều thế hệ. Hôm nay, chúng tôi tiếp tục câu chuyện ấy bằng những cách tiếp cận mới về vùng nguyên liệu, sơ chế, rang và pha chế, để khám phá thêm những khả năng vốn có của cà phê Việt Nam.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"s-home-hero__ctas"} -->
<div class="wp-block-buttons s-home-hero__ctas"><!-- wp:button {"className":"is-style-primary"} -->
<div class="wp-block-button is-style-primary"><a class="wp-block-button__link wp-element-button" href="<?php echo $shop; ?>">Khám phá cà phê ↗</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#story">Câu chuyện của Soul</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:columns {"className":"s-home-hero__strip"} -->
<div class="wp-block-columns s-home-hero__strip"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph -->
<p><a href="<?php echo $rang; ?>"><span>Cà phê rang</span><span class="s-home-arrow">↗</span></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph -->
<p><a href="<?php echo $green; ?>"><span>Nhân xanh</span><span class="s-home-arrow">↗</span></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph -->
<p><a href="<?php echo $sol; ?>"><span>Giải pháp cà phê</span><span class="s-home-arrow">↗</span></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"50%"} -->
<div class="wp-block-column" style="flex-basis:50%"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"s-home-hero__media"} -->
<figure class="wp-block-image size-full s-home-hero__media"><img src="<?php echo $img; ?>" alt="Ripe Robusta cherries on the branch in Buôn Ma Thuột"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
