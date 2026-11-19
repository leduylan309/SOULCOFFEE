<?php
/**
 * Single post.
 *
 * @package Soul
 */
get_header();
?>
<article <?php post_class('soul-container soul-single'); ?>>
	<?php while (have_posts()) : the_post(); ?>
		<header class="soul-page__header">
			<p class="soul-eyebrow"><?php echo esc_html(get_the_date()); ?></p>
			<h1><?php the_title(); ?></h1>
		</header>
		<div class="entry-content soul-content"><?php the_content(); ?></div>
	<?php endwhile; ?>
</article>
<?php
get_footer();
