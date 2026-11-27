<?php
/**
 * Title: Shop · Gallery 2 ảnh
 * Slug: soul/product-story-gallery
 * Categories: soul-shop, soul-content
 * Keywords: shop, gallery, 2 ảnh
 * Post Types: soul_product
 * Description: Hai ảnh vuông cạnh nhau — đổi từng ảnh từ Thư viện.
 */
$a = esc_url(get_theme_file_uri('assets/images/03-why-soul-album/SFR5.jpg'));
$b = esc_url(get_theme_file_uri('assets/images/03-why-soul-album/SFR6.jpg'));
?>
<!-- wp:columns {"className":"s-shop-story__gallery is-style-shop-gallery"} -->
<div class="wp-block-columns s-shop-story__gallery is-style-shop-gallery"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"s-shop-story__figure"} -->
<figure class="wp-block-image size-large s-shop-story__figure"><img src="<?php echo $a; ?>" alt=""/><figcaption class="wp-element-caption">Chú thích ảnh 1</figcaption></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"s-shop-story__figure"} -->
<figure class="wp-block-image size-large s-shop-story__figure"><img src="<?php echo $b; ?>" alt=""/><figcaption class="wp-element-caption">Chú thích ảnh 2</figcaption></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
