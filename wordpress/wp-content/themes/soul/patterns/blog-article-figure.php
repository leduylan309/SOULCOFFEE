<?php
/**
 * Title: Blog · Ảnh trong bài
 * Slug: soul/blog-article-figure
 * Categories: soul-blog, soul-content
 * Keywords: blog, ảnh, image, figure, caption
 * Post Types: post
 * Description: Ảnh nội dung + chú thích — đổi ảnh từ Thư viện (không dùng Custom HTML).
 */
?>
<!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"s-blog-figure is-style-blog-figure"} -->
<figure class="wp-block-image size-large s-blog-figure is-style-blog-figure"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/06-spaces/Soul-BMT.jpg' ) ); ?>" alt=""/><figcaption class="wp-element-caption">Chú thích ảnh — đổi nội dung và chọn ảnh từ Thư viện.</figcaption></figure>
<!-- /wp:image -->
