<?php
/**
 * Front page — page content (patterns). Same entry-content shell as page.php / editor.
 *
 * @package Soul
 */
get_header();
?>
<div class="soul-front soul-page entry-content">
	<?php
	while (have_posts()) :
		the_post();
		the_content();
	endwhile;
	?>
</div>
<?php
get_footer();
