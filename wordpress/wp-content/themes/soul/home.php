<?php
/**
 * Blog posts index (page_for_posts).
 *
 * @package Soul
 */
get_header();
?>
<section class="soul-container soul-blog">
	<header class="soul-page__header">
		<p class="soul-eyebrow"><?php echo esc_html(soul_t(['vi' => 'Journal', 'en' => 'Journal'])); ?></p>
		<h1><?php echo esc_html(soul_t(['vi' => 'Blog', 'en' => 'Blog'])); ?></h1>
	</header>

	<?php
	$cats = get_categories(['hide_empty' => true]);
	if ($cats) :
		?>
		<nav class="soul-chips" aria-label="<?php esc_attr_e('Categories', 'soul'); ?>">
			<a class="soul-chip is-on" href="<?php echo esc_url(get_permalink((int) get_option('page_for_posts')) ?: home_url('/blog/')); ?>"><?php esc_html_e('Tất cả', 'soul'); ?></a>
			<?php foreach ($cats as $cat) : ?>
				<a class="soul-chip" href="<?php echo esc_url(get_category_link($cat)); ?>"><?php echo esc_html($cat->name); ?></a>
			<?php endforeach; ?>
		</nav>
	<?php endif; ?>

	<div class="soul-product-grid soul-blog-grid">
		<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
				<article <?php post_class('soul-card'); ?>>
					<a class="soul-card__media" href="<?php the_permalink(); ?>">
						<?php if (has_post_thumbnail()) : the_post_thumbnail('medium_large'); else : ?>
							<span class="soul-media-well"></span>
						<?php endif; ?>
					</a>
					<div class="soul-card__body">
						<p class="soul-eyebrow"><?php echo esc_html(get_the_date()); ?></p>
						<h2 class="soul-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p><?php echo esc_html(get_the_excerpt()); ?></p>
						<a class="soul-text-link" href="<?php the_permalink(); ?>"><?php esc_html_e('Đọc tiếp', 'soul'); ?> ↗</a>
					</div>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<p><?php esc_html_e('Chưa có bài viết.', 'soul'); ?></p>
		<?php endif; ?>
	</div>
	<?php the_posts_pagination(); ?>
</section>
<?php
get_footer();
