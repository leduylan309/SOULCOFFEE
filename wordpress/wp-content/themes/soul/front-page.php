<?php
/**
 * Front page — uses page content (patterns).
 *
 * @package Soul
 */
get_header();
?>
<div class="soul-front entry-content">
	<?php
	while (have_posts()) :
		the_post();
		the_content();
	endwhile;
	?>
</div>
<?php
get_footer();
