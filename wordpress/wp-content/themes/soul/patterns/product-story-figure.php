<?php
/**
 * Title: Shop · Ảnh + chú thích
 * Slug: soul/product-story-figure
 * Categories: soul-shop, soul-content
 * Keywords: shop, ảnh, figure, image, caption
 * Post Types: soul_product
 * Description: Ảnh 16:10 + caption — đổi từ Thư viện (không Custom HTML).
 */
$img = esc_url(get_theme_file_uri('assets/images/02-featured/phin_finero.jpg'));
?>
<!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"s-shop-story__figure is-style-shop-figure"} -->
<figure class="wp-block-image size-large s-shop-story__figure is-style-shop-figure"><img src="<?php echo $img; ?>" alt=""/><figcaption class="wp-element-caption">Đổi ảnh và chú thích từ Thư viện phương tiện.</figcaption></figure>
<!-- /wp:image -->
