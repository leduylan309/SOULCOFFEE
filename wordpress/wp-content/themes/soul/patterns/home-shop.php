<?php
/**
 * Title: Home — 02 Shop Coffee
 * Slug: soul/home-shop
 * Categories: soul-layout
 */
$shop = soul_home_shop_url();
$rang = soul_home_term_url('ca-phe-rang');
$green = soul_home_term_url('ca-phe-nhan-xanh');
$fine = soul_home_term_url('fine-robusta');
$tiles = [
	['02-shop/Pha-thu-cong.png', 'Fine Robusta poured from a glass server into a tasting glass', 'Fine Robusta'],
	['02-shop/Espresso.jpg', 'Espresso extracting into a glass', 'Pha máy'],
	['02-shop/Filter.jpg', 'Hand pour-over brewing with a gooseneck kettle', 'Pha thủ công'],
	['02-shop/Phin.jpg', 'Soul gold and black phin filters on a wooden tray', 'Pha phin'],
	['02-shop/Items-Binh-ngam-Coldbrew-3.jpg', 'Soul cold brew bottle beside an iced glass', 'Cà phê ủ lạnh'],
];
?>
<!-- wp:group {"align":"full","className":"s-home-shop","anchor":"shop","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull s-home-shop" id="shop"><!-- wp:columns {"className":"s-home-head"} -->
<div class="wp-block-columns s-home-head"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"s-home-eye"} -->
<p class="s-home-eye">Cà phê của Soul</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"s-home-h2"} -->
<h2 class="wp-block-heading s-home-h2">Khám phá các dòng cà phê của Soul</h2>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"s-home-p"} -->
<p class="s-home-p">Từ những lô nhân xanh dành cho nhà rang đến các dòng cà phê rang cho espresso, pha lọc, phin và ủ lạnh, mỗi lựa chọn tại Soul được phát triển từ đặc tính của nguyên liệu và cách chúng tôi muốn hương vị được thể hiện trong tách.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"className":"s-home-collections"} -->
<div class="wp-block-columns s-home-collections"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"s-home-coll","layout":{"type":"default"}} -->
<div class="wp-block-group s-home-coll"><!-- wp:image {"sizeSlug":"full","linkDestination":"custom","className":"s-home-coll__media"} -->
<figure class="wp-block-image size-full s-home-coll__media"><a href="<?php echo $rang; ?>"><img src="<?php echo soul_img('02-shop/CA-PHE-RANG.jpg'); ?>" alt="Freshly roasted Fine Robusta beans in the cooling tray"/></a></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"s-home-coll__body","layout":{"type":"default"}} -->
<div class="wp-block-group s-home-coll__body"><!-- wp:group {"className":"s-home-coll__text","layout":{"type":"default"}} -->
<div class="wp-block-group s-home-coll__text"><!-- wp:paragraph {"className":"s-home-coll__idx"} -->
<p class="s-home-coll__idx">01</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"s-home-coll__title"} -->
<h3 class="wp-block-heading s-home-coll__title">Cà phê rang</h3>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:paragraph -->
<p><a class="s-home-coll__cta" href="#roasted">Tất cả sản phẩm ↓</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"s-home-coll s-home-coll--sand","layout":{"type":"default"}} -->
<div class="wp-block-group s-home-coll s-home-coll--sand"><!-- wp:image {"sizeSlug":"full","linkDestination":"custom","className":"s-home-coll__media"} -->
<figure class="wp-block-image size-full s-home-coll__media"><a href="<?php echo $green; ?>"><img src="<?php echo soul_img('02-shop/Nhan-xanh.jpg'); ?>" alt="Green Fine Robusta beans held in cupped hands over a sack"/></a></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"s-home-coll__body s-home-coll__body--stack","layout":{"type":"default"}} -->
<div class="wp-block-group s-home-coll__body s-home-coll__body--stack"><!-- wp:group {"className":"s-home-coll__text","layout":{"type":"default"}} -->
<div class="wp-block-group s-home-coll__text"><!-- wp:paragraph {"className":"s-home-coll__idx"} -->
<p class="s-home-coll__idx">02</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"s-home-coll__title"} -->
<h3 class="wp-block-heading s-home-coll__title">Nhân xanh</h3>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"s-home-coll__links","layout":{"type":"default"}} -->
<div class="wp-block-group s-home-coll__links"><!-- wp:paragraph -->
<p><a href="<?php echo $fine; ?>"><span>Fine Robusta</span><span class="s-home-arrow">↗</span></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="<?php echo $green; ?>"><span>Premium Robusta</span><span class="s-home-arrow">↗</span></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:paragraph {"anchor":"roasted","className":"s-home-rule"} -->
<p class="s-home-rule" id="roasted">Cà phê rang</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"className":"s-home-tiles"} -->
<div class="wp-block-columns s-home-tiles">
<?php foreach ($tiles as $t) : ?>
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"s-home-tile","layout":{"type":"default"}} -->
<div class="wp-block-group s-home-tile"><!-- wp:image {"sizeSlug":"full","linkDestination":"custom","className":"s-home-tile__media"} -->
<figure class="wp-block-image size-full s-home-tile__media"><a href="<?php echo $shop; ?>"><img src="<?php echo soul_img($t[0]); ?>" alt="<?php echo esc_attr($t[1]); ?>"/></a></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"s-home-tile__cap"} -->
<p class="s-home-tile__cap"><a href="<?php echo $shop; ?>"><span><?php echo esc_html($t[2]); ?></span><span class="s-home-arrow">↗</span></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
