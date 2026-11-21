<?php
/**
 * Title: Spaces branch — 03 Gallery
 * Slug: soul/spaces-br-gallery
 * Categories: soul-layout
 * Post Types: soul_space
 *
 * Editors: click Gallery → Upload / Media Library (no URL pasting).
 */
$id      = (int) (get_the_ID() ?: ($GLOBALS['soul_space_seed_id'] ?? 0));
$name    = $id ? get_the_title($id) : 'Soul';
$glimpse = sprintf('Bên trong %s', $name);

/** @var list<array{id?:int,url:string,alt:string}> $items — seed only; live edits = Gallery block in content */
$items = $GLOBALS['soul_space_seed_gallery_items'] ?? [];
$count = str_pad((string) count($items), 2, '0', STR_PAD_LEFT);
?>
<!-- wp:group {"align":"full","className":"s-space-br-gallery js-soul-lightbox","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull s-space-br-gallery js-soul-lightbox"><!-- wp:group {"className":"s-space-br-gallery__head","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group s-space-br-gallery__head"><!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"s-space-eye s-space-eye--yellow"} -->
<p class="s-space-eye s-space-eye--yellow">Inside Soul</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2,"className":"s-space-br-gallery__h2"} -->
<h2 class="wp-block-heading s-space-br-gallery__h2" id="gl-h"><?php echo esc_html($glimpse); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"s-space-br-gallery__count"} -->
<p class="s-space-br-gallery__count" data-gallery-count><?php echo esc_html($count); ?> ảnh</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<?php if ($items) : ?>
<!-- wp:gallery {"linkTo":"none","columns":3,"className":"s-space-br-gallery__grid"} -->
<figure class="wp-block-gallery has-nested-images columns-3 is-cropped s-space-br-gallery__grid wp-block-gallery-is-layout-flex">
<?php foreach ($items as $it) :
	$img_attrs = [
		'sizeSlug'        => 'large',
		'linkDestination' => 'none',
	];
	if (! empty($it['id'])) {
		$img_attrs = ['id' => (int) $it['id']] + $img_attrs;
	}
	$img_class = ! empty($it['id']) ? 'wp-image-' . (int) $it['id'] : '';
	?>
<!-- wp:image <?php echo wp_json_encode($img_attrs, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?> -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url($it['url']); ?>" alt="<?php echo esc_attr($it['alt']); ?>"<?php echo $img_class !== '' ? ' class="' . esc_attr($img_class) . '"' : ''; ?>/></figure>
<!-- /wp:image -->
<?php endforeach; ?>
</figure>
<!-- /wp:gallery -->
<?php else : ?>
<!-- wp:gallery {"linkTo":"none","columns":3,"className":"s-space-br-gallery__grid"} -->
<figure class="wp-block-gallery has-nested-images columns-3 is-cropped s-space-br-gallery__grid wp-block-gallery-is-layout-flex"></figure>
<!-- /wp:gallery -->

<!-- wp:paragraph {"className":"s-space-br-gallery__hint"} -->
<p class="s-space-br-gallery__hint">Chọn khối Gallery → Upload hoặc Thư viện để thêm ảnh không gian.</p>
<!-- /wp:paragraph -->
<?php endif; ?>
</div>
<!-- /wp:group -->
