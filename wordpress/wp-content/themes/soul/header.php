<?php
/**
 * Header chrome.
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
	}
	if ($data_page) {
		echo ' data-page="' . esc_attr($data_page) . '"';
	}
	?>
>
<?php wp_body_open(); ?>
<a class="soul-skip" href="#main"><?php esc_html_e('Skip to content', 'soul'); ?></a>
<header class="soul-header" data-component="header" id="top">
	<nav class="soul-nav" aria-label="<?php esc_attr_e('Main', 'soul'); ?>">
		<a class="soul-brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="SOUL">
			<?php if (is_readable(SOUL_DIR . '/assets/logo/soul-elephant-ink.svg')) : ?>
				<img src="<?php echo esc_url(soul_logo_uri('soul-elephant-ink.svg')); ?>" alt="" width="30" height="30">
			<?php endif; ?>
			<img class="soul-brand__word" src="<?php echo esc_url(soul_logo_uri('soul-wordmark-ink.svg')); ?>" alt="SOUL" height="15">
		</a>
		<div class="soul-nav__links">
			<?php if (has_nav_menu('primary')) : ?>
				<?php
				wp_nav_menu([
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'soul-menu',
					'depth'          => 2,
				]);
				?>
			<?php else : ?>
				<ul class="soul-menu">
					<li><a href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html(soul_t($c['home'])); ?></a></li>
					<li><a href="<?php echo esc_url($shop); ?>"><?php echo esc_html(soul_t($c['shop'])); ?></a></li>
					<li><a href="<?php echo esc_url($soulful_url); ?>"><?php echo esc_html(soul_t($c['new_crop'])); ?></a></li>
					<li><a href="<?php echo esc_url(home_url('/our-story/')); ?>"><?php echo esc_html(soul_t($c['story'])); ?></a></li>
					<li><a href="<?php echo esc_url(home_url('/coffee-solutions/')); ?>"><?php echo esc_html(soul_t($c['solutions'])); ?></a></li>
					<li><a href="<?php echo esc_url($spaces); ?>"><?php echo esc_html(soul_t($c['spaces'])); ?></a></li>
					<li><a href="<?php echo esc_url($blog); ?>"><?php echo esc_html(soul_t($c['blog'])); ?></a></li>
				</ul>
			<?php endif; ?>
		</div>
		<div class="soul-nav__utils">
			<div class="soul-lang" data-component="lang-toggle" role="group" aria-label="Language">
				<a class="soul-lang__btn<?php echo $lang === 'vi' ? ' is-on' : ''; ?>" href="<?php echo esc_url(add_query_arg('soul_lang', 'vi')); ?>">VI</a>
				<a class="soul-lang__btn<?php echo $lang === 'en' ? ' is-on' : ''; ?>" href="<?php echo esc_url(add_query_arg('soul_lang', 'en')); ?>">EN</a>
			</div>
			<button type="button" class="soul-icon-btn" data-open="soul-search" aria-label="<?php echo esc_attr(soul_t($c['search'])); ?>">⌕</button>
			<button type="button" class="soul-icon-btn soul-cart-btn" data-open="soul-cart" aria-label="<?php echo esc_attr(soul_t($c['cart'])); ?>">
				<span aria-hidden="true">Bag</span>
				<span class="soul-cart-btn__count" data-cart-count>0</span>
			</button>
			<button type="button" class="soul-icon-btn soul-nav__burger" data-open="mobile-menu" aria-label="<?php echo esc_attr(soul_t($c['menu'])); ?>"></button>
		</div>
	</nav>
</header>
<main id="main" class="soul-main">
