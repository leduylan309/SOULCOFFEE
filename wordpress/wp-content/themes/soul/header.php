<?php
/**
 * Header chrome — DS SiteHeader + mega + tools.
 *
 * @package Soul
 */
$c = soul_chrome_strings();
$lang = soul_get_lang();
$shop = get_post_type_archive_link('soul_product') ?: home_url('/products/');
$soulful = get_term_by('slug', 'soulful-flavours', 'soul_collection');
$soulful_url = $soulful ? get_term_link($soulful) : $shop;
if (is_wp_error($soulful_url)) {
	$soulful_url = $shop;
}
$spaces = get_post_type_archive_link('soul_space') ?: home_url('/spaces/');
$blog = get_permalink((int) get_option('page_for_posts')) ?: home_url('/blog/');
$rang = get_term_by('slug', 'ca-phe-rang', 'soul_collection');
$green = get_term_by('slug', 'ca-phe-nhan-xanh', 'soul_collection');
$rang_url = ($rang && ! is_wp_error(get_term_link($rang))) ? get_term_link($rang) : $shop;
$green_url = ($green && ! is_wp_error(get_term_link($green))) ? get_term_link($green) : $shop;
?><!DOCTYPE html>
<html <?php language_attributes(); ?> data-soul-lang="<?php echo esc_attr($lang); ?>">
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class('soul-lang-' . $lang); ?>
	<?php
	$data_page = '';
	if (is_page_template('templates/checkout.php')) {
		$data_page = 'checkout';
	} elseif (is_singular('soul_product')) {
		$data_page = 'product';
	} elseif (is_post_type_archive('soul_product') || is_tax('soul_collection')) {
		$data_page = 'collection';
	} elseif (is_front_page()) {
		$data_page = 'home';
	} elseif (is_home() || is_category() || is_singular('post')) {
		$data_page = 'blog';
	} elseif (is_search()) {
		$data_page = 'search';
	}
	if ($data_page) {
		echo ' data-page="' . esc_attr($data_page) . '"';
	}
	?>
>
<?php wp_body_open(); ?>
<a class="soul-skip" href="#main"><?php esc_html_e('Skip to content', 'soul'); ?></a>
<header class="l-header soul-header" data-component="header">
	<nav class="l-header__bar soul-nav" aria-label="<?php esc_attr_e('Main', 'soul'); ?>">
		<div class="l-header__left">
			<button type="button" class="c-icon-btn l-header__burger soul-nav__burger" data-open="mobile-menu" aria-label="<?php echo esc_attr(soul_t($c['menu'])); ?>">
				<span class="soul-burger-icon" aria-hidden="true"></span>
			</button>
			<a class="l-header__logo soul-brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="SOUL">
				<img src="<?php echo esc_url(soul_logo_uri('soul-elephant-ink.svg')); ?>" alt="" width="30" height="30">
				<img class="soul-brand__word" src="<?php echo esc_url(soul_logo_uri('soul-wordmark-ink.svg')); ?>" alt="SOUL" height="15">
			</a>
			<div class="l-header__nav soul-nav__links">
				<?php if (has_nav_menu('primary')) : ?>
					<?php
					wp_nav_menu([
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'soul-menu',
						'depth'          => 2,
						'link_before'    => '',
						'link_after'     => '',
					]);
					?>
				<?php else : ?>
					<a class="l-header__link" href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html(soul_t($c['home'])); ?></a>
					<a class="l-header__link" href="<?php echo esc_url($shop); ?>" data-mega-trigger="shop" aria-haspopup="true" aria-expanded="false"><?php echo esc_html(soul_t($c['shop'])); ?> <span aria-hidden="true">▾</span></a>
					<a class="l-header__link" href="<?php echo esc_url(home_url('/new-crop/')); ?>"><?php echo esc_html(soul_t($c['new_crop'])); ?></a>
					<a class="l-header__link" href="<?php echo esc_url(home_url('/our-story/')); ?>"><?php echo esc_html(soul_t($c['story'])); ?></a>
					<a class="l-header__link" href="<?php echo esc_url(home_url('/coffee-solutions/')); ?>"><?php echo esc_html(soul_t($c['solutions'])); ?></a>
					<a class="l-header__link" href="<?php echo esc_url($spaces); ?>"><?php echo esc_html(soul_t($c['spaces'])); ?></a>
					<a class="l-header__link" href="<?php echo esc_url($blog); ?>"><?php echo esc_html(soul_t($c['blog'])); ?></a>
				<?php endif; ?>
			</div>
		</div>
		<div class="l-header__tools soul-nav__utils">
			<div class="soul-lang c-lang" data-component="lang-toggle" role="group" aria-label="Language">
				<a class="soul-lang__btn<?php echo $lang === 'vi' ? ' is-on' : ''; ?>" href="<?php echo esc_url(add_query_arg('soul_lang', 'vi')); ?>">VI</a>
				<a class="soul-lang__btn<?php echo $lang === 'en' ? ' is-on' : ''; ?>" href="<?php echo esc_url(add_query_arg('soul_lang', 'en')); ?>">EN</a>
			</div>
			<button type="button" class="c-icon-btn soul-icon-btn" data-open="soul-search" aria-label="<?php echo esc_attr(soul_t($c['search'])); ?>">
				<svg width="17" height="17" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><circle cx="7" cy="7" r="5"></circle><path d="M11 11l4 4"></path></svg>
			</button>
			<button type="button" class="c-icon-btn soul-icon-btn soul-cart-btn" data-open="soul-cart" aria-label="<?php echo esc_attr(soul_t($c['cart'])); ?>">
				<span class="soul-cart-btn__label"><?php echo esc_html(soul_t($c['cart'])); ?></span>
				<span class="c-cart-count soul-cart-btn__count" data-cart-count>0</span>
			</button>
		</div>
	</nav>
	<div class="l-mega" data-mega="shop" hidden>
		<div class="l-mega__inner">
			<div>
				<div class="l-mega__head"><?php esc_html_e('Cà phê rang', 'soul'); ?></div>
				<ul class="l-mega__list">
					<li><a href="<?php echo esc_url($rang_url); ?>"><?php esc_html_e('Cà phê rang', 'soul'); ?></a></li>
					<li><a href="<?php echo esc_url($shop); ?>"><?php esc_html_e('Tất cả sản phẩm', 'soul'); ?></a></li>
				</ul>
			</div>
			<div>
				<div class="l-mega__head"><?php esc_html_e('Nhân xanh', 'soul'); ?></div>
				<ul class="l-mega__list">
					<li><a href="<?php echo esc_url($green_url); ?>"><?php esc_html_e('Cà phê nhân xanh', 'soul'); ?></a></li>
					<li><a href="<?php echo esc_url($shop); ?>"><?php esc_html_e('Xem tất cả ↗', 'soul'); ?></a></li>
				</ul>
			</div>
			<a class="l-mega__feature" href="<?php echo esc_url($soulful_url); ?>">
				<div class="l-mega__feature-copy">
					<div class="l-mega__feature-eye"><?php esc_html_e('Mùa vụ mới', 'soul'); ?></div>
					<div class="l-mega__feature-title">Soulful Collection 2026</div>
					<div class="l-mega__feature-meta">Cay · Nồng · Thơm · Ngọt</div>
					<div class="l-mega__feature-cta"><?php esc_html_e('Khám phá ↗', 'soul'); ?></div>
				</div>
			</a>
		</div>
	</div>
</header>
<main id="main" class="soul-main">
