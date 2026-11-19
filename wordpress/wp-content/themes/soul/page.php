<?php
/**
 * Page template.
 *
 * @package Soul
 */
get_header();
?>
<div class="soul-container soul-page">
	<?php while (have_posts()) : the_post(); ?>
		<article <?php post_class(); ?>>
			<?php if (! is_front_page()) : ?>
				<header class="soul-page__header">
					<h1><?php the_title(); ?></h1>
				</header>
			<?php endif; ?>
			<div class="soul-content entry-content">
				<?php the_content(); ?>
			</div>
		</article>
	<?php endwhile; ?>
</div>
<?php
get_footer();
