<?php
/**
 * Fallback index.
 *
 * @package Soul
 */
get_header();
?>
<div class="soul-container">
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			<article <?php post_class('soul-article'); ?>>
				<h1 class="soul-article__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
				<?php the_excerpt(); ?>
			</article>
		<?php endwhile; ?>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p><?php esc_html_e('Không có nội dung.', 'soul'); ?></p>
	<?php endif; ?>
</div>
<?php
get_footer();
