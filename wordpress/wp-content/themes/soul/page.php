<?php
/**
 * Page template — pattern pages own layout (same shell as front-page / editor).
 *
 * @package Soul
 */
get_header();
?>
<div class="soul-page entry-content">
	<?php
	while (have_posts()) :
		the_post();
		the_content();
	endwhile;
	?>
</div>
<?php
get_footer();
