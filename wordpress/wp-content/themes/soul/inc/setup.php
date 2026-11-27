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
		'assets/css/blog-sections.css',
		'assets/css/help-sections.css',
		'assets/css/shop-sections.css',
		'assets/css/checkout-sections.css',
		'assets/css/404-sections.css',
		'assets/css/account-sections.css',
		'assets/css/theme-chrome.css',
		'assets/css/editor-bridge.css',
	]);
	add_theme_support('align-wide');
	add_theme_support('responsive-embeds');
	add_theme_support('wp-block-styles');

	register_nav_menus([
		'primary'         => __('Primary (header + mobile)', 'soul'),
		'footer_shop'     => __('Footer — Shop', 'soul'),
		'footer_explore'  => __('Footer — Khám phá', 'soul'),
		'footer_partners' => __('Footer — Đối tác', 'soul'),
		'footer_support'  => __('Footer — Hỗ trợ', 'soul'),
	]);
});

/**
 * Render a footer column menu or fallback list.
 *
 * @param string               $location Theme location.
 * @param string               $heading  Column label.
 * @param list<array{0:string,1:string}> $fallback [[label, url], ...].
 */
function soul_footer_col(string $location, string $heading, array $fallback): void {
	echo '<div>';
	echo '<p class="l-footer__head soul-footer__label">' . esc_html($heading) . '</p>';
	if (has_nav_menu($location)) {
		wp_nav_menu([
			'theme_location' => $location,
			'container'      => false,
			'menu_class'     => 'l-footer__links',
			'depth'          => 1,
			'fallback_cb'    => false,
		]);
	} else {
		echo '<ul class="l-footer__links">';
		foreach ($fallback as $row) {
			printf(
				'<li><a href="%s">%s</a></li>',
				esc_url($row[1]),
				esc_html($row[0])
			);
		}
		echo '</ul>';
	}
	echo '</div>';
}

add_filter('body_class', static function (array $classes): array {
	$classes[] = 'soul-theme';
	return $classes;
});

/** Avoid invalid `wordpress@localhost` From (PHPMailer rejects it). */
add_filter('wp_mail_from', static function (string $from): string {
	if ($from !== '' && is_email($from) && ! str_ends_with(strtolower($from), '@localhost')) {
		return $from;
	}
	$admin = (string) get_option('admin_email');
	if ($admin !== '' && is_email($admin) && ! str_ends_with(strtolower($admin), '@localhost')) {
		return $admin;
	}
	return 'noreply@soul.local';
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
