<?php
/**
 * Single space / branch.
 *
 * @package Soul
 */
get_header();
while (have_posts()) :
	the_post();
	$m = soul_get_space_meta(get_the_ID());
	$map = $m['map_q'] ? 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($m['map_q']) : '';
	?>
	<article <?php post_class('soul-container soul-space'); ?>>
		<header class="soul-page__header">
			<p class="soul-eyebrow"><?php echo esc_html($m['region']); ?></p>
			<h1><?php the_title(); ?></h1>
		</header>
		<div class="soul-pdp__grid">
			<div class="soul-pdp__gallery">
				<?php if (has_post_thumbnail()) : the_post_thumbnail('large', ['class' => 'soul-pdp__img']); else : ?>
					<div class="soul-media-well"></div>
				<?php endif; ?>
			</div>
			<div>
				<ul class="soul-space-meta">
					<?php if ($m['address']) : ?><li><strong><?php esc_html_e('Địa chỉ', 'soul'); ?></strong> <?php echo esc_html($m['address']); ?></li><?php endif; ?>
					<?php if ($m['hours']) : ?><li><strong><?php esc_html_e('Giờ mở', 'soul'); ?></strong> <?php echo esc_html($m['hours']); ?></li><?php endif; ?>
					<?php if ($m['hotline']) : ?><li><strong><?php esc_html_e('Hotline', 'soul'); ?></strong> <?php echo esc_html($m['hotline']); ?></li><?php endif; ?>
				</ul>
				<?php if ($map) : ?>
					<p><a class="soul-btn soul-btn--outline" href="<?php echo esc_url($map); ?>" target="_blank" rel="noopener"><?php esc_html_e('Mở bản đồ ↗', 'soul'); ?></a></p>
				<?php endif; ?>
				<div class="entry-content"><?php the_content(); ?></div>
			</div>
		</div>
		<p><a href="<?php echo esc_url(get_post_type_archive_link('soul_space')); ?>"><?php esc_html_e('← Tất cả cửa hàng', 'soul'); ?></a></p>
	</article>
	<?php
endwhile;
get_footer();
