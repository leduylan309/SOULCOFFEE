<?php
/**
 * Title: Solutions — 04 Partners
 * Slug: soul/solutions-partners
 * Categories: soul-content
 *
 * Editors: click Gallery → Upload / Media Library (no URL pasting).
 */
$logos = ['KhGE0JY', '0qvgmek', 'kAoE23U', 'dHdSZaa', 'jittxwI', 'Xa2jFtw', 'ZCMH8gH', '0cpAes0', 'UBepzyo', 'R9e0V2A', 'zOmbINo', 'Fxwzcg5', 'Ua8UnOv', 'etDhIN6', 'SMERBb7', '5JCRZ3f', 'Z4qvMvv', 'BaGKKC9', 'X9EOl29', 'WtBuhG3'];
?>
<!-- wp:group {"align":"full","className":"s-sol-pt is-style-surface-sand","anchor":"partners","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull s-sol-pt is-style-surface-sand" id="partners"><!-- wp:group {"className":"s-sol-pt__head","layout":{"type":"default"}} -->
<div class="wp-block-group s-sol-pt__head"><!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"s-sol-eye"} -->
<p class="s-sol-eye">Đối tác</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"s-sol-h2"} -->
<h2 class="wp-block-heading s-sol-h2">Đồng hành cùng Soul</h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"s-sol-pt__count"} -->
<p class="s-sol-pt__count" data-partners-count><?php echo esc_html((string) count($logos)); ?> đối tác</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:gallery {"linkTo":"none","columns":5,"className":"s-sol-pt__grid"} -->
<figure class="wp-block-gallery has-nested-images columns-5 is-cropped s-sol-pt__grid wp-block-gallery-is-layout-flex">
<?php foreach ($logos as $i => $id) : ?>
<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"s-sol-pt__logo"} -->
<figure class="wp-block-image size-full s-sol-pt__logo"><img src="<?php echo esc_url('https://i.imgur.com/' . $id . '.png'); ?>" alt="<?php echo esc_attr('Logo đối tác ' . ($i + 1)); ?>"/></figure>
<!-- /wp:image -->
<?php endforeach; ?>
</figure>
<!-- /wp:gallery -->

<!-- wp:paragraph {"className":"s-sol-pt__hint"} -->
<p class="s-sol-pt__hint">Chọn khối Gallery → Upload hoặc Thư viện để thêm / đổi logo đối tác.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
