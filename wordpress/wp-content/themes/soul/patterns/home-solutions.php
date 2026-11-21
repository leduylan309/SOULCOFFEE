<?php
/**
 * Title: Home — 05 Coffee Solutions + form
 * Slug: soul/home-solutions
 * Categories: soul-layout, soul-connect
 */
$services = [
	['01', 'Nhân xanh', 'Lựa chọn nguồn cà phê theo chất lượng, mục tiêu rang và nhu cầu sản lượng.'],
	['02', 'Cà phê rang', 'Phát triển lựa chọn cà phê phù hợp với menu, thiết bị và cách phục vụ.'],
	['03', 'Đào tạo', 'Đào tạo kiến thức cà phê, đánh giá cảm quan, pha chế và vận hành dành cho chủ quán và đối tác kinh doanh cà phê.'],
	['04', 'Workshop & Sự kiện', 'Thiết kế workshop và trải nghiệm specialty coffee dành cho doanh nghiệp, agency và các sự kiện thương hiệu.'],
];
?>
<!-- wp:group {"align":"full","className":"s-home-solutions is-style-surface-sand","anchor":"solutions","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull s-home-solutions is-style-surface-sand" id="solutions"><!-- wp:columns {"className":"s-home-solutions__top"} -->
<div class="wp-block-columns s-home-solutions__top"><!-- wp:column {"className":"s-home-solutions__copy"} -->
<div class="wp-block-column s-home-solutions__copy"><!-- wp:paragraph {"className":"s-home-eye"} -->
<p class="s-home-eye">Coffee Solutions</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"s-home-solutions__title"} -->
<h2 class="wp-block-heading s-home-solutions__title">Giải pháp cà phê cho đối tác</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-home-p"} -->
<p class="s-home-p">Soul làm việc cùng nhà rang, quán cà phê và doanh nghiệp từ lựa chọn nguyên liệu đến phát triển sản phẩm, đào tạo và vận hành.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:columns {"className":"s-home-solutions__pair"} -->
<div class="wp-block-columns s-home-solutions__pair"><!-- wp:column {"width":"40%"} -->
<div class="wp-block-column" style="flex-basis:40%"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"s-home-solutions__shot s-home-solutions__shot--tall"} -->
<figure class="wp-block-image size-full s-home-solutions__shot s-home-solutions__shot--tall"><img src="<?php echo soul_img('05-solutions/1789033571781_bag-sewing.jpg'); ?>" alt="Sealing a sack of Soul Fine Robusta green coffee"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"60%"} -->
<div class="wp-block-column" style="flex-basis:60%"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"s-home-solutions__shot s-home-solutions__shot--fill"} -->
<figure class="wp-block-image size-full s-home-solutions__shot s-home-solutions__shot--fill"><img src="<?php echo soul_img('05-solutions/DSCF9134_edited.jpg'); ?>" alt="Cupping table with green coffee samples and Soulful bags"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"className":"s-home-solutions__lower"} -->
<div class="wp-block-columns s-home-solutions__lower"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"s-home-services","layout":{"type":"default"}} -->
<div class="wp-block-group s-home-services">
<?php foreach ($services as $sv) : ?>
<!-- wp:group {"className":"s-home-services__row","layout":{"type":"default"}} -->
<div class="wp-block-group s-home-services__row"><!-- wp:paragraph {"className":"s-home-services__n"} -->
<p class="s-home-services__n"><?php echo esc_html($sv[0]); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"s-home-services__text","layout":{"type":"default"}} -->
<div class="wp-block-group s-home-services__text"><!-- wp:heading {"level":3,"className":"s-home-services__title"} -->
<h3 class="wp-block-heading s-home-services__title"><?php echo esc_html($sv[1]); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-home-services__body"} -->
<p class="s-home-services__body"><?php echo esc_html($sv[2]); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:soul/lead-form {"kind":"contact","title":"Form liên hệ","source":"home-b2b","submitLabel":"Gửi thông tin"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
