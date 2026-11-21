<?php
/**
 * Title: Home — 02b Featured
 * Slug: soul/home-featured
 * Categories: soul-layout
 */
$shop = soul_home_shop_url();
/* Order matches html/Home.html PRODUCTS */
$products = [
	['lib', '02-featured/gb_sfr26_libe.jpg', 'Mùa vụ mới 25/26', 'Nhân xanh · Specialty Liberica', 'GB-SFR-Liberica', 'Vỏ cam, chanh dây, lá xá xị, gợi vị đào', "M'Drak, Đắk Lắk · Natural – lên men Soul Yeast", 450000],
	['oesp', '02-featured/espresso_fine_ro.jpg', 'Pha máy', 'Cà phê rang · Fine Robusta', 'Origin Espresso — Fine Robusta', 'Cacao, mật ong, ca-ra-men, đậm ngọt', 'Buôn Ma Thuột · Robusta TR · Khô (Natural) · Rang đậm vừa', 170000],
	['prem', '02-featured/premium_coffee_1st_thumbnail.jpg', 'Pha phin · Pha máy', 'Cà phê rang · Robusta chất lượng cao', 'Premium Coffee — Robusta', 'Chocolate, mật ong, trà đen, gu đắng đậm', 'Buôn Ma Thuột · Robusta · Khô (Natural) · Rang đậm vừa', 250000],
	['ophin', '02-featured/phin_finero.jpg', 'Pha phin', 'Cà phê rang · Fine Robusta', 'Origin Vietnamese Phin — Fine Robusta', 'Cacao, mật ong, ca-ra-men, đậm ngọt', 'Buôn Ma Thuột · Robusta TR · Khô (Natural) · Rang đậm vừa', 170000],
];
?>
<!-- wp:group {"align":"full","className":"s-home-featured","anchor":"featured","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull s-home-featured" id="featured"><!-- wp:columns {"className":"s-home-head s-home-head--divider"} -->
<div class="wp-block-columns s-home-head s-home-head--divider"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"s-home-eye"} -->
<p class="s-home-eye">Sản phẩm nổi bật</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"s-home-h2"} -->
<h2 class="wp-block-heading s-home-h2">Những lựa chọn đáng chú ý từ Soul</h2>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"s-home-p"} -->
<p class="s-home-p">Những sản phẩm được yêu thích, những lô cà phê đạt giải và những lựa chọn tiêu biểu cho cách Soul làm việc với Robusta Việt Nam.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a class="s-home-link" href="<?php echo $shop; ?>">Xem tất cả cà phê ↗</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"className":"s-home-products"} -->
<div class="wp-block-columns s-home-products">
<?php foreach ($products as $p) :
	$img = soul_img($p[1]);
	?>
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"s-home-card","layout":{"type":"default"}} -->
<div class="wp-block-group s-home-card"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"s-home-card__media is-style-ratio-1-1"} -->
<figure class="wp-block-image size-full s-home-card__media is-style-ratio-1-1"><img src="<?php echo $img; ?>" alt="<?php echo esc_attr($p[4]); ?>"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"s-home-card__badge"} -->
<p class="s-home-card__badge"><?php echo esc_html($p[2]); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-home-card__type"} -->
<p class="s-home-card__type"><?php echo esc_html($p[3]); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"s-home-card__name"} -->
<h3 class="wp-block-heading s-home-card__name"><?php echo esc_html($p[4]); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-home-card__notes is-style-tasting-notes"} -->
<p class="s-home-card__notes is-style-tasting-notes"><?php echo esc_html($p[5]); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-home-card__meta is-style-meta-chain"} -->
<p class="s-home-card__meta is-style-meta-chain"><?php echo esc_html($p[6]); ?></p>
<!-- /wp:paragraph -->

<!-- wp:soul/add-to-cart {"label":"Thêm vào giỏ","productId":"<?php echo esc_attr($p[0]); ?>","productName":<?php echo wp_json_encode($p[4], JSON_UNESCAPED_UNICODE); ?>,"price":<?php echo (int) $p[7]; ?>,"imageUrl":"<?php echo esc_url($img); ?>","productType":<?php echo wp_json_encode($p[3], JSON_UNESCAPED_UNICODE); ?>,"openDrawer":true,"variant":"card"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
