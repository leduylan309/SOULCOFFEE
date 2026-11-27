<?php
/**
 * Title: Shop · Gallery 3 ảnh
 * Slug: soul/product-story-gallery-3
 * Categories: soul-shop, soul-content
 * Keywords: shop, gallery, 3 ảnh
 * Post Types: soul_product
 * Description: Ba ảnh vuông — phù hợp album vùng trồng / xưởng rang.
 */
$a = esc_url(get_theme_file_uri('assets/images/03-why-soul-album/SFR4.jpg'));
$b = esc_url(get_theme_file_uri('assets/images/03-why-soul-album/SFR5.jpg'));
$c = esc_url(get_theme_file_uri('assets/images/03-why-soul-album/SFR7.jpg'));
?>
<!-- wp:columns {"className":"s-shop-story__gallery is-style-shop-gallery"} -->
<div class="wp-block-columns s-shop-story__gallery is-style-shop-gallery"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"sizeSlug":"medium","linkDestination":"none"} -->
<figure class="wp-block-image size-medium"><img src="<?php echo $a; ?>" alt=""/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"sizeSlug":"medium","linkDestination":"none"} -->
<figure class="wp-block-image size-medium"><img src="<?php echo $b; ?>" alt=""/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"sizeSlug":"medium","linkDestination":"none"} -->
<figure class="wp-block-image size-medium"><img src="<?php echo $c; ?>" alt=""/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
