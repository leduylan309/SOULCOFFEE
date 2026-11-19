<?php
/**
 * Lightweight VI/EN chrome i18n (cookie). Full content translation → Polylang later.
 *
 * @package Soul
 */

declare(strict_types=1);

function soul_get_lang(): string {
	$lang = isset($_COOKIE['soul_lang']) ? sanitize_key((string) $_COOKIE['soul_lang']) : 'vi';
	return in_array($lang, ['vi', 'en'], true) ? $lang : 'vi';
}

/**
 * @param array{vi:string,en:string}|string $pair
 */
function soul_t($pair, string $fallback = ''): string {
	if (is_string($pair)) {
		return $pair;
	}
	$lang = soul_get_lang();
	return (string) ($pair[$lang] ?? $pair['vi'] ?? $fallback);
}

function soul_chrome_strings(): array {
	return [
		'home'      => ['vi' => 'Trang chủ', 'en' => 'Home'],
		'shop'      => ['vi' => 'Sản phẩm', 'en' => 'Shop'],
		'new_crop'  => ['vi' => 'Mùa vụ mới', 'en' => 'New Crop'],
		'story'     => ['vi' => 'Về Soul', 'en' => 'Our Story'],
		'solutions' => ['vi' => 'Giải pháp cà phê', 'en' => 'Coffee Solutions'],
		'spaces'    => ['vi' => 'Cửa hàng', 'en' => 'Spaces'],
		'blog'      => ['vi' => 'Blog', 'en' => 'Blog'],
		'search'    => ['vi' => 'Tìm kiếm', 'en' => 'Search'],
		'cart'      => ['vi' => 'Giỏ hàng', 'en' => 'Cart'],
		'menu'      => ['vi' => 'Menu', 'en' => 'Menu'],
		'order_lookup' => ['vi' => 'Tra cứu đơn', 'en' => 'Order lookup'],
	];
}

add_action('init', static function (): void {
	if (! isset($_GET['soul_lang'])) {
		return;
	}
	$lang = sanitize_key((string) $_GET['soul_lang']);
	if (! in_array($lang, ['vi', 'en'], true)) {
		return;
	}
	setcookie('soul_lang', $lang, time() + YEAR_IN_SECONDS, COOKIEPATH ?: '/', COOKIE_DOMAIN, is_ssl(), true);
	$redirect = remove_query_arg('soul_lang');
	wp_safe_redirect($redirect ?: home_url('/'));
	exit;
}, 1);
