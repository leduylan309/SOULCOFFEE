<?php
/**
 * Title: Spaces branch — 04 Other spaces
 * Slug: soul/spaces-br-others
 * Categories: soul-layout
 * Post Types: soul_space
 */
$id  = (int) (get_the_ID() ?: ($GLOBALS['soul_space_seed_id'] ?? 0));
$hub = soul_url_spaces();
$others = get_posts([
	'post_type'      => 'soul_space',
	'posts_per_page' => 20,
	'post__not_in'   => $id ? [$id] : [],
	'orderby'        => ['menu_order' => 'ASC', 'title' => 'ASC'],
	'post_status'    => 'publish',
]);
?>
<!-- wp:group {"align":"full","className":"s-space-br-others","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull s-space-br-others"><!-- wp:group {"className":"s-space-br-others__head","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group s-space-br-others__head"><!-- wp:heading {"level":2,"className":"s-space-br-others__h2"} -->
<h2 class="wp-block-heading s-space-br-others__h2" id="ot-h">Các không gian khác</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-space-br-others__all-wrap"} -->
<p class="s-space-br-others__all-wrap"><a class="s-space-br-others__all" href="<?php echo $hub; ?>">Tất cả cửa hàng ↗</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:columns {"className":"s-space-br-others__grid"} -->
<div class="wp-block-columns s-space-br-others__grid">
<?php foreach ($others as $o) :
	$om     = soul_get_space_meta((int) $o->ID);
	$othumb = get_the_post_thumbnail_url($o->ID, 'medium_large') ?: '';
	$ulink  = get_permalink($o);
	?>
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"s-space-br-others__card","layout":{"type":"default"}} -->
<div class="wp-block-group s-space-br-others__card"><!-- wp:image {"sizeSlug":"medium_large","linkDestination":"custom","className":"s-space-br-others__media"} -->
<figure class="wp-block-image size-medium_large s-space-br-others__media"><a href="<?php echo esc_url($ulink); ?>"><?php if ($othumb) : ?><img src="<?php echo esc_url($othumb); ?>" alt="<?php echo esc_attr($o->post_title); ?>"/><?php endif; ?></a></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"s-space-br-others__cap"} -->
<p class="s-space-br-others__cap"><a href="<?php echo esc_url($ulink); ?>"><span class="s-space-br-others__name"><?php echo esc_html($o->post_title); ?></span><span class="s-space-br-others__meta"><?php echo esc_html($om['region']); ?></span></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
