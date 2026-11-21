<?php
/**
 * Search — hero + results / idle / empty (DS Search sections).
 *
 * @package Soul
 */
get_header();
$q = get_search_query();
$shop = get_post_type_archive_link('soul_product') ?: home_url('/products/');
?>
<section class="soul-container soul-search-page soul-page-shell" data-section="search">
	<header class="soul-page__header soul-search-page__hero">
		<p class="soul-eyebrow"><?php echo esc_html(soul_t(['vi' => 'Tìm kiếm', 'en' => 'Search'])); ?></p>
		<form class="soul-search-form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
			<label class="screen-reader-text" for="soul-search-q"><?php esc_html_e('Tìm kiếm', 'soul'); ?></label>
			<input id="soul-search-q" type="search" name="s" value="<?php echo esc_attr($q); ?>" placeholder="<?php esc_attr_e('Cà phê, cửa hàng, bài viết…', 'soul'); ?>" autofocus>
			<button type="submit" class="c-btn"><?php esc_html_e('Tìm', 'soul'); ?></button>
		</form>
	</header>

	<?php if ($q === '') : ?>
		<div data-section="search-idle">
			<p class="soul-eyebrow"><?php esc_html_e('Gợi ý', 'soul'); ?></p>
			<nav class="soul-chips">
				<a class="soul-chip" href="<?php echo esc_url(add_query_arg('s', 'Fine Robusta', home_url('/'))); ?>">Fine Robusta</a>
				<a class="soul-chip" href="<?php echo esc_url(add_query_arg('s', 'Soulful', home_url('/'))); ?>">Soulful</a>
				<a class="soul-chip" href="<?php echo esc_url(add_query_arg('s', 'Buôn Ma Thuột', home_url('/'))); ?>">Buôn Ma Thuột</a>
				<a class="soul-chip" href="<?php echo esc_url($shop); ?>"><?php esc_html_e('Tất cả sản phẩm ↗', 'soul'); ?></a>
			</nav>
		</div>
	<?php elseif (have_posts()) : ?>
		<div class="soul-search-results" data-section="search-results">
			<p class="soul-eyebrow"><?php echo esc_html(sprintf(__('Kết quả cho “%s”', 'soul'), $q)); ?></p>
			<?php while (have_posts()) : the_post(); ?>
				<article <?php post_class('soul-search-hit'); ?>>
					<p class="soul-eyebrow"><?php echo esc_html(get_post_type_object(get_post_type())->labels->singular_name ?? get_post_type()); ?></p>
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<p><?php echo esc_html(wp_trim_words(get_the_excerpt() ?: wp_strip_all_tags(get_the_content()), 28)); ?></p>
				</article>
			<?php endwhile; ?>
		</div>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<div data-section="search-empty">
			<p><?php esc_html_e('Không tìm thấy kết quả phù hợp.', 'soul'); ?></p>
			<nav class="soul-chips">
				<a class="soul-chip" href="<?php echo esc_url($shop); ?>"><?php esc_html_e('Sản phẩm', 'soul'); ?></a>
				<a class="soul-chip" href="<?php echo esc_url(home_url('/help/#contact')); ?>"><?php esc_html_e('Liên hệ Soul ↗', 'soul'); ?></a>
			</nav>
		</div>
	<?php endif; ?>
</section>
<?php
get_footer();
