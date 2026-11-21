<?php
/**
 * Title: New Crop — 04 Soulful Collection
 * Slug: soul/newcrop-collection
 * Categories: soul-cards
 */
$col_url = esc_url(home_url('/collections/soulful-flavours/'));
$shop = esc_url(get_post_type_archive_link('soul_product') ?: home_url('/products/'));
$flavours = [
	[
		'id' => 'cay',
		'word' => 'Cay',
		'line' => 'Pha phin',
		'desc' => 'Fine Robusta TR sơ chế Red Honey, rang cho phin. Đậm và ấm, với sắc thái cay nhẹ của gia vị và hậu ngọt kéo dài.',
		'img' => soul_img('04-soulful/Soulful-Cay.jpg'),
		'items' => [
			['Soulful Cay Pha Phin – Fine Robusta TR – Red Honey', '200.000 ₫', 'Robusta TR · Red Honey'],
		],
	],
	[
		'id' => 'nong',
		'word' => 'Nồng',
		'line' => 'Pha máy',
		'desc' => 'Fine Robusta TR sơ chế Natural cùng Soul Yeast, rang cho espresso. Body dày, nồng ấm và đứng vững khi pha cùng sữa.',
		'img' => soul_img('04-soulful/Soulful-Nong.jpg'),
		'items' => [
			['Soulful Nồng Pha Máy – Fine Robusta TR – Natural – Soul Yeast', '200.000 ₫', 'Robusta TR · Natural'],
		],
	],
	[
		'id' => 'thom',
		'word' => 'Thơm',
		'line' => 'Cold Brew',
		'desc' => 'Fine Robusta và Arabica lên men cùng men rượu cần, rang riêng cho ủ lạnh. Hương thơm rõ, mượt và ít đắng.',
		'img' => soul_img('04-soulful/Soulful-Thom.jpg'),
		'items' => [
			['Soulful Thơm Cold Brew – Fine Robusta TR – Natural Cần Wine', '200.000 ₫', 'Robusta TR · Natural'],
			['Soulful Thơm Cold Brew – Blend TR, Catimor, Yellow Bourbon', '220.000 ₫', 'Blend · Robusta & Arabica'],
		],
	],
	[
		'id' => 'ngot',
		'word' => 'Ngọt',
		'line' => 'Brewing',
		'desc' => 'Robusta, Liberica và Arabica lên men với men bản địa và trái cây Tây Nguyên, rang sáng cho pha thủ công. Ngọt trái chín, sáng và sạch.',
		'img' => soul_img('04-soulful/Soulful-Ngot.jpg'),
		'items' => [
			['Soulful Ngọt Brewing – Specialty Liberica – Soul Yeast', '260.000 ₫', 'Liberica · Soul Yeast'],
			['Soulful Ngọt Brewing – Fine Robusta TR – Local Fruits Yeast', '220.000 ₫', 'Robusta TR · Local Fruits Yeast'],
			['Soulful Ngọt Brewing – Fine Robusta TR – Soul Yeast', '220.000 ₫', 'Robusta TR · Soul Yeast'],
			['Soulful Ngọt Brewing – Yellow Bourbon – Honey', '240.000 ₫', 'Yellow Bourbon · Honey'],
			['Soulful Ngọt Brewing – Robusta TR – Natural Cần Wine Yeast', '220.000 ₫', 'Robusta TR · Cần Wine Yeast'],
		],
	],
];
?>
<!-- wp:group {"align":"full","className":"s-newcrop-col js-flavour-tabs","anchor":"collection","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull s-newcrop-col js-flavour-tabs" id="collection"><!-- wp:columns {"className":"s-newcrop-col__head"} -->
<div class="wp-block-columns s-newcrop-col__head"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"s-newcrop-eye"} -->
<p class="s-newcrop-eye">04 / Soulful Collection 2027</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"s-newcrop-col__title"} -->
<h2 class="wp-block-heading s-newcrop-col__title">Bốn sắc thái hương vị.</h2>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"s-newcrop-col__intro"} -->
<p class="s-newcrop-col__intro">Soulful Collection 2027 là thành quả của mùa vụ, thể hiện qua bốn tính cách hương vị đặc trưng của Soul: Cay, Nồng, Thơm và Ngọt. Mỗi dòng được rang riêng cho một cách pha.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:buttons {"className":"s-newcrop-col__tabs"} -->
<div class="wp-block-buttons s-newcrop-col__tabs">
<?php foreach ($flavours as $i => $f) : ?>
<!-- wp:button {"className":"s-newcrop-col__tab<?php echo $i === 0 ? ' is-active' : ''; ?>"} -->
<div class="wp-block-button s-newcrop-col__tab<?php echo $i === 0 ? ' is-active' : ''; ?>"><a class="wp-block-button__link wp-element-button" href="#panel-<?php echo esc_attr($f['id']); ?>"><?php echo esc_html(str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT)); ?> <?php echo esc_html($f['word']); ?></a></div>
<!-- /wp:button -->
<?php endforeach; ?>
</div>
<!-- /wp:buttons -->

<?php foreach ($flavours as $i => $f) : ?>
<!-- wp:group {"className":"s-newcrop-col__panel<?php echo $i === 0 ? ' is-active' : ''; ?>","anchor":"panel-<?php echo esc_attr($f['id']); ?>","layout":{"type":"default"}} -->
<div class="wp-block-group s-newcrop-col__panel<?php echo $i === 0 ? ' is-active' : ''; ?>" id="panel-<?php echo esc_attr($f['id']); ?>"><!-- wp:columns {"className":"s-newcrop-col__feature"} -->
<div class="wp-block-columns s-newcrop-col__feature"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"s-newcrop-col__shot"} -->
<figure class="wp-block-image size-full s-newcrop-col__shot"><img src="<?php echo esc_url($f['img']); ?>" alt="<?php echo esc_attr($f['word']); ?>"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"s-newcrop-col__count"} -->
<p class="s-newcrop-col__count"><?php echo esc_html(str_pad((string) count($f['items']), 2, '0', STR_PAD_LEFT)); ?> sản phẩm</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"s-newcrop-col__word"} -->
<h3 class="wp-block-heading s-newcrop-col__word"><?php echo esc_html($f['word']); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-newcrop-col__line"} -->
<p class="s-newcrop-col__line"><?php echo esc_html($f['line']); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-newcrop-col__desc"} -->
<p class="s-newcrop-col__desc"><?php echo esc_html($f['desc']); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo $col_url; ?>">Xem sản phẩm ↗</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:paragraph {"className":"s-newcrop-col__list-label"} -->
<p class="s-newcrop-col__list-label">Danh sách sản phẩm · <?php echo esc_html($f['word']); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"s-newcrop-col__grid","layout":{"type":"default"}} -->
<div class="wp-block-group s-newcrop-col__grid">
<?php foreach ($f['items'] as $item) : ?>
<!-- wp:group {"className":"s-newcrop-col__card","layout":{"type":"default"}} -->
<div class="wp-block-group s-newcrop-col__card"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"s-newcrop-col__card-media"} -->
<figure class="wp-block-image size-full s-newcrop-col__card-media"><img src="<?php echo esc_url($f['img']); ?>" alt="<?php echo esc_attr($item[0]); ?>"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"s-newcrop-col__card-meta"} -->
<p class="s-newcrop-col__card-meta"><?php echo esc_html($item[2]); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-newcrop-col__card-name"} -->
<p class="s-newcrop-col__card-name"><a href="<?php echo $shop; ?>"><?php echo esc_html($item[0]); ?></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-newcrop-col__card-price"} -->
<p class="s-newcrop-col__card-price"><?php echo esc_html($item[1]); ?> ↗</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group -->
