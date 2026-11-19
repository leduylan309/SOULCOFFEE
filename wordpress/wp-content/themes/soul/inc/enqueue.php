<?php
/**
 * Front + editor assets.
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('wp_enqueue_scripts', static function (): void {
	wp_enqueue_style(
		'soul-main',
		SOUL_URI . '/assets/css/soul.css',
		[],
		SOUL_VERSION
	);
	wp_enqueue_style(
		'soul-chrome',
		SOUL_URI . '/assets/css/theme-chrome.css',
		['soul-main'],
		SOUL_VERSION
	);

	wp_enqueue_script(
		'soul-main',
		SOUL_URI . '/assets/js/main.js',
		[],
		SOUL_VERSION,
		['strategy' => 'defer', 'in_footer' => true]
	);

	// ES modules need type=module.
	wp_script_add_data('soul-main', 'type', 'module');

	wp_localize_script('soul-main', 'SoulTheme', [
		'restUrl'   => esc_url_raw(rest_url('soul/v1/')),
		'nonce'     => wp_create_nonce('wp_rest'),
		'checkout'  => get_permalink((int) get_option('soul_checkout_page_id')) ?: home_url('/checkout/'),
		'shop'      => get_post_type_archive_link('soul_product') ?: home_url('/products/'),
		'home'      => home_url('/'),
		'currency'  => 'VND',
		'i18n'      => [
			'added'     => __('đã thêm vào giỏ', 'soul'),
			'cartEmpty' => __('Giỏ hàng đang trống.', 'soul'),
			'checkout'  => __('Gửi đơn hàng', 'soul'),
		],
	]);
});

add_filter('script_loader_tag', static function (string $tag, string $handle, string $src): string {
	if ($handle === 'soul-main') {
		return sprintf('<script type="module" src="%s" id="soul-main-js"></script>' . "\n", esc_url($src));
	}
	return $tag;
}, 10, 3);
