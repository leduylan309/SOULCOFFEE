<?php
/**
 * Theme supports and menus.
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('after_setup_theme', static function (): void {
	load_theme_textdomain('soul', SOUL_DIR . '/languages');

	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
	add_theme_support('editor-styles');
	// Same stack as front (cms-ui-fidelity): tokens → DS → sections → chrome → editor bridge.
	add_editor_style([
		'assets/css/soul-tokens.css',
		'assets/css/soul.css',
		'assets/css/home-sections.css',
		'assets/css/newcrop-sections.css',
		'assets/css/story-sections.css',
		'assets/css/solutions-sections.css',
		'assets/css/spaces-sections.css',
		'assets/css/theme-chrome.css',
		'assets/css/editor-bridge.css',
	]);
	add_theme_support('align-wide');
	add_theme_support('responsive-embeds');
	add_theme_support('wp-block-styles');

	register_nav_menus([
		'primary' => __('Primary', 'soul'),
		'footer'  => __('Footer', 'soul'),
	]);
});

add_filter('body_class', static function (array $classes): array {
	$classes[] = 'soul-theme';
	return $classes;
});

/** Local Mailpit SMTP when DEBUG (docker service `mailpit:1025`). */
add_action('phpmailer_init', static function ($phpmailer): void {
	if (! defined('WP_DEBUG') || ! WP_DEBUG) {
		return;
	}
	$phpmailer->isSMTP();
	$phpmailer->Host     = 'mailpit';
	$phpmailer->Port     = 1025;
	$phpmailer->SMTPAuth = false;
});

/** Pretty `/search/` → core search template (`?s=`). */
add_action('init', static function (): void {
	add_rewrite_rule('^search/?$', 'index.php?s=', 'top');
}, 20);

add_action('after_switch_theme', static function (): void {
	flush_rewrite_rules();
});

add_action('init', static function (): void {
	if (get_option('soul_rewrite_flush_v15')) {
		return;
	}
	flush_rewrite_rules(false);
	update_option('soul_rewrite_flush_v15', 1);
}, 99);
