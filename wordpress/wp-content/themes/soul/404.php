<?php
/**
 * 404.
 *
 * @package Soul
 */
get_header();
$shop  = get_post_type_archive_link('soul_product') ?: home_url('/products/');
$space = get_post_type_archive_link('soul_space') ?: home_url('/spaces/');
?>
<section class="soul-container soul-404 is-style-surface-ink">
	<p class="soul-eyebrow">404</p>
	<h1><?php esc_html_e('Trang này không tồn tại', 'soul'); ?></h1>
	<p><?php esc_html_e('Có thể đường dẫn đã đổi. Thử về trang chủ hoặc tiếp tục khám phá Soul.', 'soul'); ?></p>
	<p class="soul-404__links">
		<a class="soul-btn soul-btn--primary" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Trang chủ', 'soul'); ?></a>
		<a class="soul-btn soul-btn--outline" href="<?php echo esc_url($shop); ?>"><?php esc_html_e('Sản phẩm', 'soul'); ?></a>
		<a class="soul-btn soul-btn--outline" href="<?php echo esc_url($space); ?>"><?php esc_html_e('Cửa hàng', 'soul'); ?></a>
		<a class="soul-btn soul-btn--outline" href="<?php echo esc_url(home_url('/help/')); ?>"><?php esc_html_e('Hỗ trợ', 'soul'); ?></a>
	</p>
	<form class="soul-404-search" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
		<label class="screen-reader-text" for="soul-404-q"><?php esc_html_e('Tìm kiếm', 'soul'); ?></label>
		<input id="soul-404-q" type="search" name="s" placeholder="<?php esc_attr_e('Tìm cà phê, cửa hàng…', 'soul'); ?>">
		<button type="submit" class="soul-btn soul-btn--primary"><?php esc_html_e('Tìm', 'soul'); ?></button>
	</form>
</section>
<?php
get_footer();
