<?php
/**
 * Product card.
 *
 * @package Soul
 */
$meta = soul_get_product_meta(get_the_ID());
$img  = get_the_post_thumbnail_url(get_the_ID(), 'medium_large') ?: '';
$solutions = home_url('/coffee-solutions/#contact');
$payload = [
	'id'    => $meta['sku'] ?: (string) get_the_ID(),
	'sku'   => $meta['sku'] ?: (string) get_the_ID(),
	'name'  => get_the_title(),
	'img'   => $img,
	'price' => $meta['price'],
	'type'  => $meta['badge'],
];
?>
<article <?php post_class('soul-card'); ?>>
	<a class="soul-card__media" href="<?php the_permalink(); ?>">
		<?php if (has_post_thumbnail()) : ?>
			<?php the_post_thumbnail('medium_large'); ?>
		<?php else : ?>
			<span class="soul-media-well"></span>
		<?php endif; ?>
	</a>
	<div class="soul-card__body">
		<?php if ($meta['badge']) : ?>
			<p class="soul-eyebrow"><?php echo esc_html($meta['badge']); ?></p>
		<?php endif; ?>
		<h2 class="soul-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<?php if ($meta['notes']) : ?>
			<p class="soul-notes"><?php echo esc_html($meta['notes']); ?></p>
		<?php endif; ?>
		<p class="soul-price"><?php echo esc_html(soul_format_vnd($meta['price'])); ?></p>
		<div class="soul-card__actions">
			<a class="soul-text-link" href="<?php the_permalink(); ?>"><?php esc_html_e('Chi tiết', 'soul'); ?> ↗</a>
			<?php if ($meta['quote_only']) : ?>
				<a class="soul-btn soul-btn--outline soul-btn--sm" href="<?php echo esc_url($solutions); ?>"><?php esc_html_e('Báo giá', 'soul'); ?></a>
			<?php elseif ($meta['in_stock']) : ?>
				<button
					type="button"
					class="soul-btn soul-btn--primary soul-btn--sm"
					data-component="add-to-cart"
					data-open-drawer="true"
					data-product="<?php echo esc_attr(wp_json_encode($payload, JSON_UNESCAPED_UNICODE)); ?>"
				><?php esc_html_e('Thêm', 'soul'); ?></button>
			<?php endif; ?>
		</div>
	</div>
</article>
