<?php
/**
 * Title: Blog · Gallery 2 ảnh
 * Slug: soul/blog-article-gallery
 * Categories: soul-blog, soul-content
 * Keywords: blog, gallery, ảnh, megazine
 * Post Types: post
 * Description: Hai ảnh cạnh nhau — đổi từng ảnh từ Thư viện.
 */
?>
<!-- wp:columns {"className":"s-blog-gallery is-style-blog-gallery"} -->
<div class="wp-block-columns s-blog-gallery is-style-blog-gallery"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"s-blog-figure"} -->
<figure class="wp-block-image size-large s-blog-figure"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/06-spaces/Soul-BMT.jpg' ) ); ?>" alt=""/><figcaption class="wp-element-caption">Chú thích ảnh trái</figcaption></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"s-blog-figure"} -->
<figure class="wp-block-image size-large s-blog-figure"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/06-spaces/Soul-SG.jpg' ) ); ?>" alt=""/><figcaption class="wp-element-caption">Chú thích ảnh phải</figcaption></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
