<?php
/**
 * Title: Shop · CTA hướng dẫn pha
 * Slug: soul/product-story-cta
 * Categories: soul-shop, soul-content
 * Keywords: shop, cta, brew, hướng dẫn
 * Post Types: soul_product
 * Description: Khối CTA giống brew guide PDP — sửa URL link tới bài blog pha chế.
 */
$blog = esc_url(home_url('/blog/'));
?>
<!-- wp:group {"className":"s-shop-story__cta is-style-shop-cta","layout":{"type":"default"}} -->
<div class="wp-block-group s-shop-story__cta is-style-shop-cta"><!-- wp:paragraph {"className":"s-shop-story__cta-k"} -->
<p class="s-shop-story__cta-k">Hướng dẫn pha</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="<?php echo $blog; ?>">Hướng dẫn pha phin chuẩn Soul ↗</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
