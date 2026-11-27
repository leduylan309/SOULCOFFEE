<?php
/**
 * Title: Shop · Slideshow ảnh
 * Slug: soul/product-story-slides
 * Categories: soul-shop, soul-content
 * Keywords: shop, slideshow, slider, gallery, carousel
 * Post Types: soul_product
 * Description: Gallery 3+ ảnh → slideshow trên front (nút ‹ › + dots). Editor hiện lưới xem trước.
 */
$a = esc_url(get_theme_file_uri('assets/images/06-spaces/Soul-BMT.jpg'));
$b = esc_url(get_theme_file_uri('assets/images/05-solutions/1789033571781_bag-sewing.jpg'));
$c = esc_url(get_theme_file_uri('assets/images/03b-why-soul/web/why-fermentation.jpg'));
?>
<!-- wp:gallery {"linkTo":"none","className":"s-shop-story__slides is-style-shop-slides"} -->
<figure class="wp-block-gallery has-nested-images columns-default is-cropped s-shop-story__slides is-style-shop-slides"><!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo $a; ?>" alt="Soul Buôn Ma Thuột"/></figure>
<!-- /wp:image -->

<!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo $b; ?>" alt="Xưởng rang Soul"/></figure>
<!-- /wp:image -->

<!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo $c; ?>" alt="Sơ chế Fine Robusta"/></figure>
<!-- /wp:image --></figure>
<!-- /wp:gallery -->
