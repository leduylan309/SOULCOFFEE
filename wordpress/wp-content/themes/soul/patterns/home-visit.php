<?php
/**
 * Title: Home — 06 Visit Soul
 * Slug: soul/home-visit
 * Categories: soul-layout
 */
$spaces = esc_url(get_post_type_archive_link('soul_space') ?: home_url('/spaces/'));
$stores = [
	['Soul Buôn Ma Thuột', '06-spaces/Soul-BMT.jpg'],
	['Soul Sài Gòn', '06-spaces/Soul-SG.jpg'],
	['Soul Hà Nội', '06-spaces/Soul-HN.jpg'],
	['Soul Đà Nẵng', '06-spaces/Soul-Da-Nang.jpg'],
	['Soul Bà Nà', '06-spaces/Soul-Ba-Na.png'],
];
?>
<!-- wp:group {"align":"full","className":"s-home-visit","anchor":"spaces","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull s-home-visit" id="spaces"><!-- wp:columns {"className":"s-home-head s-home-visit__head"} -->
<div class="wp-block-columns s-home-head s-home-visit__head"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"s-home-eye"} -->
<p class="s-home-eye">Cửa hàng</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"s-home-visit__title"} -->
<h2 class="wp-block-heading s-home-visit__title">Ghé Soul</h2>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"s-home-visit__aside"} -->
<div class="wp-block-column s-home-visit__aside"><!-- wp:paragraph {"className":"s-home-p"} -->
<p class="s-home-p">Bạn có thể ghé bất kỳ cửa hàng nào của Soul để thưởng thức cà phê theo nhiều cách khác nhau, từ cà phê pha máy đến các phương pháp pha thủ công.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-home-p"} -->
<p class="s-home-p">Mỗi ngày, quầy bar có thể mang đến những lựa chọn cà phê khác nhau. Nếu tò mò về hạt đang được phục vụ, cách pha hay hương vị trong tách, đừng ngại hỏi Barista nhé.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"s-home-visit__cta"} -->
<div class="wp-block-buttons s-home-visit__cta"><!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo $spaces; ?>">Khám phá cửa hàng ↗</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"className":"s-home-stores"} -->
<div class="wp-block-columns s-home-stores">
<?php foreach ($stores as $sp) : ?>
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"s-home-store","layout":{"type":"default"}} -->
<div class="wp-block-group s-home-store"><!-- wp:image {"sizeSlug":"full","linkDestination":"custom","className":"s-home-store__media"} -->
<figure class="wp-block-image size-full s-home-store__media"><a href="<?php echo $spaces; ?>"><img src="<?php echo soul_img($sp[1]); ?>" alt="<?php echo esc_attr($sp[0]); ?>"/></a></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"s-home-store__cap"} -->
<p class="s-home-store__cap"><a href="<?php echo $spaces; ?>"><span class="s-home-store__dot"></span><span class="s-home-store__name"><?php echo esc_html($sp[0]); ?></span></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
