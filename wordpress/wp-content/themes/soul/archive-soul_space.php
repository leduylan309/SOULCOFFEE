<?php
/**
 * Spaces hub.
 *
 * @package Soul
 */
get_header();
?>
<section class="soul-container soul-spaces-hub">
	<header class="soul-page__header">
		<p class="soul-eyebrow"><?php esc_html_e('Cửa hàng', 'soul'); ?></p>
		<h1><?php esc_html_e('Ghé Soul', 'soul'); ?></h1>
		<p><?php esc_html_e('Năm không gian — từ Buôn Ma Thuột đến các thành phố.', 'soul'); ?></p>
	</header>
	<div class="soul-product-grid soul-spaces-grid">
		<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
				<?php $m = soul_get_space_meta(get_the_ID()); ?>
				<article <?php post_class('soul-card'); ?>>
					<a class="soul-card__media" href="<?php the_permalink(); ?>">
						<?php if (has_post_thumbnail()) : the_post_thumbnail('medium_large'); else : ?>
							<span class="soul-media-well"></span>
						<?php endif; ?>
					</a>
					<div class="soul-card__body">
						<p class="soul-eyebrow"><?php echo esc_html($m['region'] ?: ''); ?></p>
						<h2 class="soul-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p><?php echo esc_html(get_the_excerpt()); ?></p>
						<a class="soul-text-link" href="<?php the_permalink(); ?>"><?php esc_html_e('Xem chi nhánh', 'soul'); ?> ↗</a>
					</div>
				</article>
			<?php endwhile; ?>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
