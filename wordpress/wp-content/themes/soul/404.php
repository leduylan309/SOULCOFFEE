<?php
/**
 * 404 — DS NotFoundSection.
 *
 * @package Soul
 */
get_header();
$shop  = get_post_type_archive_link('soul_product') ?: home_url('/products/');
$space = get_post_type_archive_link('soul_space') ?: home_url('/spaces/');
?>
<section class="soul-404" data-section="not-found">
	<p class="soul-404__num" aria-hidden="true">404</p>
	<p class="soul-eyebrow" style="color:#FFD35B">404</p>
	<h1><?php esc_html_e('Trang này không tồn tại', 'soul'); ?></h1>
	<p><?php esc_html_e('Có thể đường dẫn đã đổi. Thử tìm hoặc quay về Soul.', 'soul'); ?></p>
	<form class="soul-404-search" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
		<label class="screen-reader-text" for="soul-404-q"><?php esc_html_e('Tìm kiếm', 'soul'); ?></label>
		<input id="soul-404-q" type="search" name="s" placeholder="<?php esc_attr_e('Tìm cà phê, cửa hàng…', 'soul'); ?>">
		<button type="submit" class="c-btn c-btn--accent"><?php esc_html_e('Tìm', 'soul'); ?></button>
	</form>
	<ul class="soul-404__links" style="list-style:none;padding:0;display:flex;flex-wrap:wrap;gap:16px;margin-top:28px">
		<li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Trang chủ ↗', 'soul'); ?></a></li>
		<li><a href="<?php echo esc_url($shop); ?>"><?php esc_html_e('Sản phẩm ↗', 'soul'); ?></a></li>
		<li><a href="<?php echo esc_url($space); ?>"><?php esc_html_e('Cửa hàng ↗', 'soul'); ?></a></li>
		<li><a href="<?php echo esc_url(home_url('/help/')); ?>"><?php esc_html_e('Hỗ trợ ↗', 'soul'); ?></a></li>
	</ul>
</section>
<?php
get_footer();
