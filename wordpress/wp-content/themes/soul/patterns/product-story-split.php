<?php
/**
 * Title: Shop · Ảnh trái + chữ phải
 * Slug: soul/product-story-split
 * Categories: soul-shop, soul-content
 * Keywords: shop, split, columns, ảnh, media
 * Post Types: soul_product
 * Description: Cột ảnh 4:5 + đoạn mô tả cạnh nhau.
 */
$img = esc_url(get_theme_file_uri('assets/images/03b-why-soul/web/why-cupping.jpg'));
?>
<!-- wp:columns {"className":"s-shop-story__split is-style-shop-split"} -->
<div class="wp-block-columns s-shop-story__split is-style-shop-split"><!-- wp:column {"width":"42%"} -->
<div class="wp-block-column" style="flex-basis:42%"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"s-shop-story__figure is-style-shop-figure"} -->
<figure class="wp-block-image size-large s-shop-story__figure is-style-shop-figure"><img src="<?php echo $img; ?>" alt=""/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"58%"} -->
<div class="wp-block-column" style="flex-basis:58%"><!-- wp:heading {"level":3,"className":"s-shop-story__h"} -->
<h3 class="wp-block-heading s-shop-story__h">Từ nông hộ đến tách cà</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-shop-story__p"} -->
<p class="s-shop-story__p">Soul làm việc trực tiếp với vùng trồng Fine Robusta, theo dõi sơ chế và rang theo từng lô để giữ ổn định hương vị trên mọi túi.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-shop-story__p"} -->
<p class="s-shop-story__p">Mỗi mùa vụ là một chương mới — cùng một tinh thần: cà phê Việt được kể rõ nguồn gốc.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
