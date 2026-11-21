<?php
/**
 * Title: Home — 04 Soulful Collection
 * Slug: soul/home-soulful
 * Categories: soul-layout
 */
$soulful_url = soul_home_term_url('soulful-flavours');
$items = [
	['cay', 'Cay', 'Pha phin', 'Fine Robusta TR Red Honey', '04-soulful/Soulful-Cay.jpg', 200000],
	['nong', 'Nồng', 'Pha máy', 'Fine Robusta TR Soul Yeast', '04-soulful/Soulful-Nong.jpg', 200000],
	['thom', 'Thơm', 'Ủ lạnh', 'Fine Robusta TR Cần Wine Yeast', '04-soulful/Soulful-Thom.jpg', 200000],
	['ngot', 'Ngọt', 'Pha thủ công', 'Fine Robusta TR Natural Cần Wine Yeast', '04-soulful/Soulful-Ngot.jpg', 220000],
];
?>
<!-- wp:group {"align":"full","className":"s-home-soulful is-style-surface-ink","anchor":"soulful","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull s-home-soulful is-style-surface-ink" id="soulful"><!-- wp:columns {"className":"s-home-soulful__intro"} -->
<div class="wp-block-columns s-home-soulful__intro"><!-- wp:column {"className":"s-home-soulful__copy"} -->
<div class="wp-block-column s-home-soulful__copy"><!-- wp:paragraph {"className":"s-home-soulful__eye"} -->
<p class="s-home-soulful__eye">New crop: Soulful Collection 2026</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"s-home-soulful__title"} -->
<h2 class="wp-block-heading s-home-soulful__title">Từ bản địa, thành bản sắc</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-home-soulful__p"} -->
<p class="s-home-soulful__p">Soulful là bộ sưu tập nơi Soul đưa những nghiên cứu về nguyên liệu, sơ chế, lên men và rang vào từng sản phẩm cụ thể. Mỗi phiên bản được hình thành từ sự khác biệt về vùng nguyên liệu, cách sơ chế và hướng phát triển hương vị.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-home-soulful__p"} -->
<p class="s-home-soulful__p">Với mùa vụ 2026, Soulful được thể hiện qua bốn tính cách hương vị: Cay, Nồng, Thơm và Ngọt, gắn với những vùng đất khác nhau của Tây Nguyên.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"s-home-soulful__cta"} -->
<div class="wp-block-buttons s-home-soulful__cta"><!-- wp:button {"className":"is-style-yellow"} -->
<div class="wp-block-button is-style-yellow"><a class="wp-block-button__link wp-element-button" href="#soulful-cards">Khám phá Soulful 2026 ↗</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"s-home-soulful__hero"} -->
<figure class="wp-block-image size-full s-home-soulful__hero"><img src="<?php echo soul_img('04-soulful/Soulful_vuong.png'); ?>" alt="Soulful Collection 2026 — four coffee bags on highland driftwood"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"anchor":"soulful-cards","className":"s-home-soulful__cards"} -->
<div class="wp-block-columns s-home-soulful__cards" id="soulful-cards">
<?php foreach ($items as $s) :
	$img = soul_img($s[4]);
	?>
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"s-home-soulful__card","layout":{"type":"default"}} -->
<div class="wp-block-group s-home-soulful__card"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"s-home-soulful__media"} -->
<figure class="wp-block-image size-full s-home-soulful__media"><img src="<?php echo $img; ?>" alt="Soulful <?php echo esc_attr($s[1]); ?>"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"s-home-soulful__card-body","layout":{"type":"default"}} -->
<div class="wp-block-group s-home-soulful__card-body"><!-- wp:group {"className":"s-home-soulful__card-top","layout":{"type":"default"}} -->
<div class="wp-block-group s-home-soulful__card-top"><!-- wp:heading {"level":3,"className":"s-home-soulful__word"} -->
<h3 class="wp-block-heading s-home-soulful__word"><?php echo esc_html($s[1]); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-home-soulful__method"} -->
<p class="s-home-soulful__method"><?php echo esc_html($s[2]); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"s-home-soulful__process"} -->
<p class="s-home-soulful__process"><?php echo esc_html($s[3]); ?></p>
<!-- /wp:paragraph -->

<!-- wp:soul/add-to-cart {"label":"Thêm vào giỏ","productId":"<?php echo esc_attr($s[0]); ?>","productName":<?php echo wp_json_encode('Soulful — ' . $s[1], JSON_UNESCAPED_UNICODE); ?>,"price":<?php echo (int) $s[5]; ?>,"imageUrl":"<?php echo esc_url($img); ?>","productType":<?php echo wp_json_encode($s[2] . ' · ' . $s[3], JSON_UNESCAPED_UNICODE); ?>,"openDrawer":true,"variant":"soulful"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns -->

<!-- wp:buttons {"className":"s-home-soulful__more"} -->
<div class="wp-block-buttons s-home-soulful__more"><!-- wp:button {"className":"is-style-outline-dark"} -->
<div class="wp-block-button is-style-outline-dark"><a class="wp-block-button__link wp-element-button" href="<?php echo $soulful_url; ?>">Xem collection ↗</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
