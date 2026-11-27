<?php
/**
 * Header chrome — DS SiteHeader + mega + tools.
 *
 * @package Soul
 */
$c = soul_chrome_strings();
$lang = soul_get_lang();
$shop = get_post_type_archive_link('soul_product') ?: home_url('/products/');
$spaces = get_post_type_archive_link('soul_space') ?: home_url('/spaces/');
$blog = get_permalink((int) get_option('page_for_posts')) ?: home_url('/blog/');
$account_id = (int) get_option('soul_account_page_id');
$account    = ($account_id > 0) ? (get_permalink($account_id) ?: home_url('/account/')) : home_url('/account/');
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
	} elseif (is_page_template('templates/account.php')) {
		$data_page = 'account';
	} elseif (is_singular('soul_product')) {
		$data_page = 'product';
	} elseif (is_post_type_archive('soul_product') || is_tax('soul_collection')) {
		$data_page = 'collection';
	} elseif (is_front_page()) {
		$data_page = 'home';
	} elseif (is_home() || is_category() || is_singular('post')) {
		$data_page = 'blog';
	} elseif (is_page('help')) {
		$data_page = 'help';
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
			<a class="l-header__logo soul-brand" href="<?php echo esc_url( function_exists( 'pll_home_url' ) ? pll_home_url() : home_url( '/' ) ); ?>" aria-label="SOUL">
				<img src="<?php echo esc_url(soul_logo_uri('soul-elephant-ink.svg')); ?>" alt="" width="30" height="30">
				<img class="soul-brand__word" src="<?php echo esc_url(soul_logo_uri('soul-wordmark-ink.svg')); ?>" alt="SOUL" height="15">
			</a>
			<div class="l-header__nav soul-nav__links">
				<?php if (has_nav_menu('primary') && class_exists('Soul_Primary_Walker')) : ?>
					<?php
					wp_nav_menu([
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'l-header__menu',
						'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
						'depth'          => 3,
						'fallback_cb'    => false,
						'walker'         => new Soul_Primary_Walker(),
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
			<?php
			if ( function_exists( 'soul_pll_language_switcher' ) ) {
				soul_pll_language_switcher();
			}
			?>
			<button type="button" class="c-icon-btn soul-icon-btn" data-open="soul-search" aria-label="<?php echo esc_attr(soul_t($c['search'])); ?>">
				<svg width="17" height="17" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><circle cx="7" cy="7" r="5"></circle><path d="M11 11l4 4"></path></svg>
			</button>
			<a class="c-icon-btn soul-icon-btn soul-account-btn" href="<?php echo esc_url($account); ?>" aria-label="<?php echo esc_attr(soul_t($c['account'])); ?>">
				<svg width="18" height="18" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><circle cx="8" cy="5.5" r="3"></circle><path d="M2.5 15c.6-3 2.8-4.6 5.5-4.6s4.9 1.6 5.5 4.6"></path></svg>
			</a>
			<button type="button" class="soul-cart-btn" data-open="soul-cart" aria-label="<?php echo esc_attr(soul_t($c['cart'])); ?>">
				<span class="soul-cart-btn__label"><?php echo esc_html(soul_t($c['cart'])); ?></span>
				<span class="c-cart-count soul-cart-btn__count" data-cart-count>0</span>
			</button>
		</div>
	</nav>
	<?php
	if ( function_exists( 'soul_render_shop_mega' ) ) {
		soul_render_shop_mega();
	}
	?>
</header>
<main id="main" class="soul-main">
