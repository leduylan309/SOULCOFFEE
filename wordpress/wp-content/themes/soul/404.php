<?php
/**
 * 404 — SoT html/404.dc.html (full-bleed ink shell, không dùng site chrome).
 *
 * @package Soul
 */
status_header(404);
nocache_headers();

$lang      = soul_get_lang();
$shop      = get_post_type_archive_link('soul_product') ?: home_url('/products/');
$soulful   = get_term_by('slug', 'soulful-flavours', 'soul_collection');
$soulful_u = ($soulful && ! is_wp_error(get_term_link($soulful))) ? get_term_link($soulful) : $shop;
$spaces    = get_post_type_archive_link('soul_space') ?: home_url('/spaces/');
$help      = home_url('/help/');
$year      = (int) wp_date('Y');

$copy = [
	'eyebrow' => soul_t(['vi' => 'Không tìm thấy trang', 'en' => 'Page not found']),
	'title'   => soul_t(['vi' => 'Tách này chưa được pha.', 'en' => 'This cup hasn’t been brewed.']),
	'body'    => soul_t([
		'vi' => 'Trang bạn tìm có thể đã được chuyển, đổi tên hoặc không còn tồn tại. Thử tìm kiếm, hoặc chọn một lối đi bên cạnh.',
		'en' => 'The page you’re looking for may have moved, been renamed or no longer exists. Try a search, or take one of the paths alongside.',
	]),
	'search'  => soul_t(['vi' => 'Tìm', 'en' => 'Search']),
	'ph'      => soul_t(['vi' => 'Tìm cà phê, bài viết, cửa hàng…', 'en' => 'Search coffee, articles, stores…']),
	'where'   => soul_t(['vi' => 'Đi tiếp', 'en' => 'Keep going']),
];

$links = [
	[soul_t(['vi' => 'Trang chủ', 'en' => 'Home']), home_url('/')],
	[soul_t(['vi' => 'Sản phẩm', 'en' => 'Shop']), $shop],
	[soul_t(['vi' => 'Soulful Collection 2026', 'en' => 'Soulful Collection 2026']), $soulful_u],
	[soul_t(['vi' => 'Cửa hàng Soul', 'en' => 'Soul spaces']), $spaces],
	[soul_t(['vi' => 'Câu hỏi thường gặp', 'en' => 'FAQ']), $help],
	[soul_t(['vi' => 'Liên hệ', 'en' => 'Contact']), $help . '#contact'],
];

?><!DOCTYPE html>
<html <?php language_attributes(); ?> data-soul-lang="<?php echo esc_attr($lang); ?>">
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class('soul-lang-' . $lang . ' s-404-body'); ?> data-page="404">
<?php wp_body_open(); ?>

<div class="s-404" data-screen-label="404">
	<header class="s-404__top">
		<a class="s-404__brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="SOUL">
			<img src="<?php echo esc_url(soul_logo_uri('soul-logo-full-yellow.svg')); ?>" alt="SOUL" height="34">
		</a>
		<?php
		if ( function_exists( 'soul_pll_language_switcher' ) ) {
			soul_pll_language_switcher(
				[
					'class_wrap' => 's-404__lang',
					'class_btn'  => 's-404__lang-btn',
					'class_on'   => 'is-on',
				]
			);
		}
		?>
	</header>

	<main class="s-404__main" id="main">
		<div class="s-404__copy">
			<div class="s-404__eye">
				<span class="s-404__eye-rule" aria-hidden="true"></span>
				<span><?php echo esc_html($copy['eyebrow']); ?></span>
			</div>
			<div class="s-404__num" aria-hidden="true">404</div>
			<h1 class="s-404__title"><?php echo esc_html($copy['title']); ?></h1>
			<p class="s-404__body"><?php echo esc_html($copy['body']); ?></p>
			<form class="s-404__search" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
				<label class="screen-reader-text" for="nf-q"><?php echo esc_html($copy['search']); ?></label>
				<input id="nf-q" type="search" name="s" placeholder="<?php echo esc_attr($copy['ph']); ?>" value="">
				<button type="submit"><?php echo esc_html($copy['search']); ?></button>
			</form>
		</div>

		<nav class="s-404__nav" aria-label="<?php echo esc_attr($copy['where']); ?>">
			<div class="s-404__nav-eye"><?php echo esc_html($copy['where']); ?></div>
			<ul class="s-404__links">
				<?php foreach ($links as $link) : ?>
					<li>
						<a href="<?php echo esc_url($link[1]); ?>">
							<span><?php echo esc_html($link[0]); ?></span>
							<span aria-hidden="true">→</span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</nav>
	</main>

	<footer class="s-404__foot">
		<span>Crafted by Vietnamese Soul</span>
		<span>© <?php echo esc_html((string) $year); ?> SOUL Fine Robusta</span>
	</footer>
</div>

<?php wp_footer(); ?>
</body>
</html>
