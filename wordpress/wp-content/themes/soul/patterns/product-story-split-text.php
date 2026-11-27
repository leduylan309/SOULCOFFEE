<?php
/**
 * Title: Shop · Chữ trái + ảnh phải
 * Slug: soul/product-story-split-text
 * Categories: soul-shop, soul-content
 * Keywords: shop, split, reverse, columns
 * Post Types: soul_product
 * Description: Đoạn chữ trước, ảnh đứng cạnh (đảo layout).
 */
$img = esc_url(get_theme_file_uri('assets/images/05-solutions/DSCF9134_edited.jpg'));
?>
<!-- wp:columns {"className":"s-shop-story__split is-style-shop-split"} -->
<div class="wp-block-columns s-shop-story__split is-style-shop-split"><!-- wp:column {"width":"58%"} -->
<div class="wp-block-column" style="flex-basis:58%"><!-- wp:heading {"level":3,"className":"s-shop-story__h"} -->
<h3 class="wp-block-heading s-shop-story__h">Rang theo cách pha</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-shop-story__p"} -->
<p class="s-shop-story__p">Profile rang được tinh chỉnh cho từng dụng cụ: phin, máy espresso, pour over hay cold brew — giữ body và độ ngọt phù hợp.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"42%"} -->
<div class="wp-block-column" style="flex-basis:42%"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"s-shop-story__figure is-style-shop-figure"} -->
<figure class="wp-block-image size-large s-shop-story__figure is-style-shop-figure"><img src="<?php echo $img; ?>" alt=""/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
