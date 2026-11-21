<?php
/**
 * Title: Spaces branch — 01 Hero
 * Slug: soul/spaces-br-hero
 * Categories: soul-layout
 * Post Types: soul_space
 *
 * Hero media = Featured Image (sidebar Upload / Media Library).
 */
$id   = (int) (get_the_ID() ?: ($GLOBALS['soul_space_seed_id'] ?? 0));
$m    = $id ? soul_get_space_meta($id) : ['city' => '', 'region' => '', 'address' => '', 'hours' => '', 'hotline' => '', 'map_q' => '', 'menu_url' => ''];
$name = $id ? get_the_title($id) : 'Soul Buôn Ma Thuột';
$city = $m['city'] !== '' ? $m['city'] : $name;
$home = esc_url(home_url('/'));
$hub  = soul_url_spaces();
$map  = soul_space_map_url($m['map_q']);
$menu = $m['menu_url'];
?>
<!-- wp:columns {"align":"full","className":"s-space-br-hero","anchor":"top","layout":{"type":"default"}} -->
<div class="wp-block-columns alignfull s-space-br-hero" id="top"><!-- wp:column {"className":"s-space-br-hero__copy"} -->
<div class="wp-block-column s-space-br-hero__copy"><!-- wp:paragraph {"className":"s-space-crumb"} -->
<p class="s-space-crumb"><a href="<?php echo $home; ?>">Trang chủ</a><span class="s-space-crumb__sep" aria-hidden="true"> / </span><a href="<?php echo $hub; ?>">Cửa hàng</a><span class="s-space-crumb__sep" aria-hidden="true"> / </span><span><?php echo esc_html($city); ?></span></p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"s-space-br-hero__intro","layout":{"type":"default"}} -->
<div class="wp-block-group s-space-br-hero__intro"><!-- wp:paragraph {"className":"s-space-eye s-space-eye--bar"} -->
<p class="s-space-eye s-space-eye--bar">Soul Space · <?php echo esc_html($m['region']); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"s-space-br-hero__title"} -->
<h1 class="wp-block-heading s-space-br-hero__title"><?php echo esc_html($name); ?></h1>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"s-space-br-hero__panel","layout":{"type":"default"}} -->
<div class="wp-block-group s-space-br-hero__panel"><!-- wp:paragraph {"className":"s-space-br-hero__panel-label"} -->
<p class="s-space-br-hero__panel-label">Specialty Coffee</p>
<!-- /wp:paragraph -->

<?php if ($m['address'] !== '') : ?>
<!-- wp:paragraph {"className":"s-space-br-hero__fact"} -->
<p class="s-space-br-hero__fact"><span class="s-space-br-hero__fact-k">Địa chỉ</span><span class="s-space-br-hero__fact-v"><?php echo esc_html($m['address']); ?></span></p>
<!-- /wp:paragraph -->
<?php endif; ?>

<?php if ($m['hours'] !== '') : ?>
<!-- wp:paragraph {"className":"s-space-br-hero__fact"} -->
<p class="s-space-br-hero__fact"><span class="s-space-br-hero__fact-k">Giờ mở cửa</span><span class="s-space-br-hero__fact-v"><?php echo esc_html($m['hours']); ?></span></p>
<!-- /wp:paragraph -->
<?php endif; ?>

<?php if ($m['hotline'] !== '') : ?>
<!-- wp:paragraph {"className":"s-space-br-hero__fact"} -->
<p class="s-space-br-hero__fact"><span class="s-space-br-hero__fact-k">Hotline</span><span class="s-space-br-hero__fact-v"><?php echo esc_html($m['hotline']); ?></span></p>
<!-- /wp:paragraph -->
<?php endif; ?>

<!-- wp:buttons {"className":"s-space-br-hero__actions"} -->
<div class="wp-block-buttons s-space-br-hero__actions">
<?php if ($menu !== '') : ?>
<!-- wp:button {"className":"is-style-fill s-space-btn--ink"} -->
<div class="wp-block-button is-style-fill s-space-btn--ink"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url($menu); ?>" target="_blank" rel="noopener">Xem menu ↗</a></div>
<!-- /wp:button -->
<?php endif; ?>
<?php if ($map !== '') : ?>
<!-- wp:button {"className":"is-style-outline s-space-btn--ghost"} -->
<div class="wp-block-button is-style-outline s-space-btn--ghost"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url($map); ?>" target="_blank" rel="noopener">Chỉ đường</a></div>
<!-- /wp:button -->
<?php endif; ?>
</div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"s-space-br-hero__media-col"} -->
<div class="wp-block-column s-space-br-hero__media-col"><!-- wp:post-featured-image {"sizeSlug":"large","className":"s-space-br-hero__media"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
