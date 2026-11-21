<?php
/**
 * Single space / branch — pattern-first content (CMS ↔ UI).
 *
 * @package Soul
 */
get_header();

while (have_posts()) :
	the_post();
	?>
	<main class="s-space-br">
		<?php the_content(); ?>
	</main>
	<?php
endwhile;

get_footer();
