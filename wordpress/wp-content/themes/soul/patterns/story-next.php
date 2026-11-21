<?php
/**
 * Title: Our Story — 08 Next
 * Slug: soul/story-next
 * Categories: soul-cta
 */
$shop = esc_url(get_post_type_archive_link('soul_product') ?: home_url('/products/'));
$sol = esc_url(home_url('/coffee-solutions/'));
$spaces = esc_url(get_post_type_archive_link('soul_space') ?: home_url('/spaces/'));
$ctas = [
	['01', 'Cà phê Soul', 'Khám phá các dòng cà phê dành cho phin, espresso, brewing và bộ sưu tập Fine Robusta mùa vụ.', 'Khám phá sản phẩm', $shop, '02-shop/CA-PHE-RANG.jpg', 'Fine Robusta vừa rang trong khay làm nguội'],
	['02', 'Giải pháp cà phê', 'Cà phê nhân xanh, cà phê rang và giải pháp sản phẩm dành cho đối tác, doanh nghiệp và ngành F&B.', 'Giải pháp cà phê', $sol, '05-solutions/DSCF9134_edited.jpg', 'Bàn cupping với mẫu nhân xanh'],
	['03', 'Không gian Soul', 'Ghé thăm các cửa hàng Soul, tìm hiểu những hương vị mới và kết nối cùng những người có chung tình yêu với cà phê Việt.', 'Tìm cửa hàng gần bạn', $spaces, '06-spaces/Soul-BMT.jpg', 'Sân Soul Buôn Ma Thuột dưới dây đèn'],
];
?>
<!-- wp:group {"align":"full","className":"s-story-next","anchor":"next","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull s-story-next" id="next"><!-- wp:columns {"className":"s-story-next__cards"} -->
<div class="wp-block-columns s-story-next__cards">
<?php foreach ($ctas as $c) : ?>
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"s-story-next__card","layout":{"type":"default"}} -->
<div class="wp-block-group s-story-next__card"><!-- wp:image {"sizeSlug":"full","linkDestination":"custom","className":"s-story-next__media"} -->
<figure class="wp-block-image size-full s-story-next__media"><a href="<?php echo esc_url($c[4]); ?>"><img src="<?php echo esc_url(soul_img($c[5])); ?>" alt="<?php echo esc_attr($c[6]); ?>"/></a></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"s-story-next__body","layout":{"type":"default"}} -->
<div class="wp-block-group s-story-next__body"><!-- wp:paragraph {"className":"s-story-next__n"} -->
<p class="s-story-next__n"><?php echo esc_html($c[0]); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"s-story-next__title"} -->
<h3 class="wp-block-heading s-story-next__title"><?php echo esc_html($c[1]); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-story-next__desc"} -->
<p class="s-story-next__desc"><?php echo esc_html($c[2]); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-story-next__cta"} -->
<p class="s-story-next__cta"><a href="<?php echo esc_url($c[4]); ?>"><?php echo esc_html($c[3]); ?> ↗</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
