<?php
/**
 * Front + editor assets.
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('wp_enqueue_scripts', static function (): void {
	wp_enqueue_style(
		'soul-tokens',
		SOUL_URI . '/assets/css/soul-tokens.css',
		[],
		SOUL_VERSION
	);
	wp_enqueue_style(
		'soul-main',
		SOUL_URI . '/assets/css/soul.css',
		['soul-tokens'],
		SOUL_VERSION
	);
	wp_enqueue_style(
		'soul-home-sections',
		SOUL_URI . '/assets/css/home-sections.css',
		['soul-main', 'wp-block-library'],
		SOUL_VERSION
	);
	wp_enqueue_style(
		'soul-newcrop-sections',
		SOUL_URI . '/assets/css/newcrop-sections.css',
		['soul-home-sections'],
		SOUL_VERSION
	);
	wp_enqueue_style(
		'soul-story-sections',
		SOUL_URI . '/assets/css/story-sections.css',
		['soul-newcrop-sections'],
		SOUL_VERSION
	);
	wp_enqueue_style(
		'soul-solutions-sections',
		SOUL_URI . '/assets/css/solutions-sections.css',
		['soul-story-sections'],
		SOUL_VERSION
	);
	wp_enqueue_style(
		'soul-spaces-sections',
		SOUL_URI . '/assets/css/spaces-sections.css',
		['soul-solutions-sections'],
		SOUL_VERSION
	);
	wp_enqueue_style(
		'soul-blog-sections',
		SOUL_URI . '/assets/css/blog-sections.css',
		['soul-spaces-sections'],
		SOUL_VERSION
	);
	wp_enqueue_style(
		'soul-help-sections',
		SOUL_URI . '/assets/css/help-sections.css',
		['soul-blog-sections'],
		SOUL_VERSION
	);
	wp_enqueue_style(
		'soul-shop-sections',
		SOUL_URI . '/assets/css/shop-sections.css',
		['soul-help-sections'],
		SOUL_VERSION
	);
	wp_enqueue_style(
		'soul-checkout-sections',
		SOUL_URI . '/assets/css/checkout-sections.css',
		['soul-shop-sections'],
		SOUL_VERSION
	);
	wp_enqueue_style(
		'soul-404-sections',
		SOUL_URI . '/assets/css/404-sections.css',
		['soul-checkout-sections'],
		SOUL_VERSION
	);
	wp_enqueue_style(
		'soul-account-sections',
		SOUL_URI . '/assets/css/account-sections.css',
		['soul-404-sections'],
		SOUL_VERSION
	);
	wp_enqueue_style(
		'soul-chrome',
		SOUL_URI . '/assets/css/theme-chrome.css',
		['soul-account-sections'],
		SOUL_VERSION
	);
	// Editor styles registered in setup.php (same files) — do not re-register here.

	wp_enqueue_script(
		'soul-main',
		SOUL_URI . '/assets/js/main.js',
		[],
		SOUL_VERSION,
		['strategy' => 'defer', 'in_footer' => true]
	);

	// ES modules need type=module.
	wp_script_add_data('soul-main', 'type', 'module');

	$i18n = function_exists( 'soul_front_i18n_bag' ) ? soul_front_i18n_bag() : [
		'lang'      => 'vi',
		'added'     => 'đã thêm vào giỏ',
		'cartEmpty' => 'Giỏ hàng đang trống.',
		'checkout'  => 'Gửi đơn hàng',
	];
	$home = function_exists( 'pll_home_url' ) ? pll_home_url() : home_url( '/' );

	$checkout_id = (int) get_option( 'soul_checkout_page_id' );
	$account_id  = (int) get_option( 'soul_account_page_id' );
	if ( function_exists( 'pll_get_post' ) ) {
		if ( $checkout_id > 0 ) {
			$tr = pll_get_post( $checkout_id );
			if ( $tr ) {
				$checkout_id = (int) $tr;
			}
		}
		if ( $account_id > 0 ) {
			$tr = pll_get_post( $account_id );
			if ( $tr ) {
				$account_id = (int) $tr;
			}
		}
	}

	wp_localize_script('soul-main', 'SoulTheme', [
		'restUrl'    => esc_url_raw(rest_url('soul/v1/')),
		'nonce'      => wp_create_nonce('wp_rest'),
		'checkout'   => ( $checkout_id > 0 ? get_permalink( $checkout_id ) : '' ) ?: home_url('/checkout/'),
		'account'    => ( $account_id > 0 ? get_permalink( $account_id ) : '' ) ?: home_url('/account/'),
		'shop'       => get_post_type_archive_link('soul_product') ?: home_url('/products/'),
		'home'       => $home,
		'lang'       => function_exists( 'soul_get_lang' ) ? soul_get_lang() : 'vi',
		'currency'   => 'VND',
		'ver'        => SOUL_VERSION,
		'recaptcha'  => function_exists('soul_recaptcha_front_config') ? soul_recaptcha_front_config() : ['enabled' => false],
		'checkoutUi' => function_exists('soul_checkout_front_config') ? soul_checkout_front_config() : [
			'shippingMethods' => false,
			'paymentMethods'  => false,
			'hotline'         => function_exists('soul_contact') ? soul_contact('hotline_checkout') : '0969 648 148',
			'email'           => function_exists('soul_contact') ? soul_contact('email_contact') : 'contact@soulcoffee.vn',
			'bankName'        => 'Đang cập nhật',
			'bankAccount'     => 'Đang cập nhật',
			'bankAccountName' => 'Công ty Soul Fine Robusta',
			'freeShippingAt'  => 500000,
			'shippingStdFee'  => 30000,
			'shippingExpFee'  => 50000,
			'promoCodes'      => ['SOUL10' => 0.1],
			'pickupStores'    => [],
		],
		'i18n'       => $i18n,
	]);
});

add_filter('script_loader_tag', static function (string $tag, string $handle, string $src): string {
	if ($handle === 'soul-main') {
		return sprintf('<script type="module" src="%s" id="soul-main-js"></script>' . "\n", esc_url($src));
	}
	return $tag;
}, 10, 3);
