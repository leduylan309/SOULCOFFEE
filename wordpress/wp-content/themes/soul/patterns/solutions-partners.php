<?php
/**
 * Title: Solutions — 04 Partners
 * Slug: soul/solutions-partners
 * Categories: soul-content
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
<p class="s-sol-pt__count">20 đối tác</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:columns {"className":"s-sol-pt__grid"} -->
<div class="wp-block-columns s-sol-pt__grid">
<?php foreach ($logos as $i => $id) : ?>
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"s-sol-pt__logo"} -->
<figure class="wp-block-image size-full s-sol-pt__logo"><img src="<?php echo esc_url('https://i.imgur.com/' . $id . '.png'); ?>" alt="<?php echo esc_attr('Logo đối tác ' . ($i + 1)); ?>"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
