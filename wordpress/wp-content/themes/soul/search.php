<?php
/**
 * Global search — posts, pages, products, spaces.
 *
 * @package Soul
 */
get_header();
$q = get_search_query();
?>
<section class="soul-container soul-search-page">
	<header class="soul-page__header">
		<p class="soul-eyebrow"><?php echo esc_html(soul_t(['vi' => 'Tìm kiếm', 'en' => 'Search'])); ?></p>
		<h1><?php echo $q !== '' ? esc_html(sprintf(/* translators: %s search query */ __('Kết quả cho “%s”', 'soul'), $q)) : esc_html__('Tìm kiếm', 'soul'); ?></h1>
	</header>

	<form class="soul-search-form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
		<input type="search" name="s" value="<?php echo esc_attr($q); ?>" placeholder="<?php esc_attr_e('Cà phê, cửa hàng, bài viết…', 'soul'); ?>" autofocus>
		<button type="submit" class="soul-btn soul-btn--primary"><?php esc_html_e('Tìm', 'soul'); ?></button>
	</form>

	<?php if (have_posts()) : ?>
		<div class="soul-search-results">
			<?php while (have_posts()) : the_post(); ?>
				<article <?php post_class('soul-search-hit'); ?>>
					<p class="soul-eyebrow"><?php echo esc_html(get_post_type_object(get_post_type())->labels->singular_name ?? get_post_type()); ?></p>
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<p><?php echo esc_html(wp_trim_words(get_the_excerpt() ?: wp_strip_all_tags(get_the_content()), 28)); ?></p>
				</article>
			<?php endwhile; ?>
		</div>
		<?php the_posts_pagination(); ?>
	<?php elseif ($q !== '') : ?>
		<p><?php esc_html_e('Không tìm thấy kết quả phù hợp.', 'soul'); ?></p>
		<p><a href="<?php echo esc_url(home_url('/help/#contact')); ?>"><?php esc_html_e('Liên hệ Soul ↗', 'soul'); ?></a></p>
	<?php endif; ?>
</section>
<?php
get_footer();
