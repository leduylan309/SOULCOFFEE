<?php
/**
 * Single post — article header / body / nav / related.
 *
 * @package Soul
 */
get_header();
?>
<article <?php post_class('soul-container soul-single soul-page-shell'); ?> data-section="article">
	<?php while (have_posts()) : the_post(); ?>
		<header class="soul-page__header" data-section="article-header">
			<p class="soul-eyebrow"><?php echo esc_html(get_the_date()); ?> · <?php the_category(' · '); ?></p>
			<h1><?php the_title(); ?></h1>
		</header>
		<?php if (has_post_thumbnail()) : ?>
			<figure class="soul-article-cover" data-section="article-cover"><?php the_post_thumbnail('large'); ?></figure>
		<?php endif; ?>
		<div class="entry-content soul-content" data-section="article-body"><?php the_content(); ?></div>
		<nav class="soul-article-nav" data-section="article-nav">
			<?php
			previous_post_link('<span class="soul-prev">%link</span>', '← %title');
			next_post_link('<span class="soul-next">%link</span>', '%title →');
			?>
		</nav>
		<?php
		$related = new WP_Query([
			'post_type'           => 'post',
			'posts_per_page'      => 3,
			'post__not_in'        => [get_the_ID()],
			'ignore_sticky_posts' => true,
			'category__in'        => wp_get_post_categories(get_the_ID()),
		]);
		if ($related->have_posts()) :
			?>
			<section class="soul-related" data-section="article-related">
				<h2><?php esc_html_e('Bài liên quan', 'soul'); ?></h2>
				<div class="soul-product-grid soul-blog-grid">
					<?php while ($related->have_posts()) : $related->the_post(); ?>
						<article class="soul-card">
							<a class="soul-card__media" href="<?php the_permalink(); ?>">
								<?php if (has_post_thumbnail()) : the_post_thumbnail('medium'); else : ?><span class="soul-media-well"></span><?php endif; ?>
							</a>
							<h3 class="soul-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						</article>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
			</section>
		<?php endif; ?>
	<?php endwhile; ?>
</article>
<?php
get_footer();
