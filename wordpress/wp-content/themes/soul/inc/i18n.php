<?php
/**
 * Site language via Polylang (fallback VI when plugin inactive).
 *
 * @package Soul
 */

declare(strict_types=1);

/** Current language slug: vi | en. */
function soul_get_lang(): string {
	if ( function_exists( 'pll_current_language' ) ) {
		$lang = pll_current_language( 'slug' );
		if ( is_string( $lang ) && in_array( $lang, [ 'vi', 'en' ], true ) ) {
			return $lang;
		}
	}
	// Admin / REST without PLL context.
	if ( function_exists( 'pll_default_language' ) ) {
		$def = pll_default_language( 'slug' );
		if ( is_string( $def ) && $def !== '' ) {
			return in_array( $def, [ 'vi', 'en' ], true ) ? $def : 'vi';
		}
	}
	return 'vi';
}

/**
 * Pick VI/EN pair — prefers Polylang string translation of VI source.
 *
 * @param array{vi?:string,en?:string}|string $pair
 */
function soul_t( $pair, string $fallback = '' ): string {
	if ( is_string( $pair ) ) {
		return $pair;
	}
	if ( ! is_array( $pair ) ) {
		return $fallback;
	}
	$vi = (string) ( $pair['vi'] ?? $fallback );
	$en = (string) ( $pair['en'] ?? $vi );
	if ( function_exists( 'soul_pll__' ) ) {
		return soul_pll__( $vi, $en );
	}
	return soul_get_lang() === 'en' ? $en : $vi;
}

/**
 * @return array<string,array{vi:string,en:string}>
 */
function soul_chrome_strings(): array {
	return [
		'home'         => [ 'vi' => 'Trang chủ', 'en' => 'Home' ],
		'shop'         => [ 'vi' => 'Sản phẩm', 'en' => 'Shop' ],
		'new_crop'     => [ 'vi' => 'Mùa vụ mới', 'en' => 'New Crop' ],
		'story'        => [ 'vi' => 'Về Soul', 'en' => 'Our Story' ],
		'solutions'    => [ 'vi' => 'Giải pháp cà phê', 'en' => 'Coffee Solutions' ],
		'spaces'       => [ 'vi' => 'Cửa hàng', 'en' => 'Spaces' ],
		'blog'         => [ 'vi' => 'Blog', 'en' => 'Blog' ],
		'search'       => [ 'vi' => 'Tìm kiếm', 'en' => 'Search' ],
		'account'      => [ 'vi' => 'Tài khoản', 'en' => 'Account' ],
		'cart'         => [ 'vi' => 'Giỏ hàng', 'en' => 'Cart' ],
		'menu'         => [ 'vi' => 'Menu', 'en' => 'Menu' ],
		'order_lookup' => [ 'vi' => 'Tra cứu đơn', 'en' => 'Order lookup' ],
	];
}

/**
 * Front JS i18n bag (checkout / cart / account / common).
 *
 * @return array<string,mixed>
 */
function soul_front_i18n_bag(): array {
	$lang = soul_get_lang();
	$is_en = $lang === 'en';

	$bag = [
		'lang'      => $lang,
		'added'     => soul_t( [ 'vi' => 'đã thêm vào giỏ', 'en' => 'added to cart' ] ),
		'cartEmpty' => soul_t( [ 'vi' => 'Giỏ hàng đang trống.', 'en' => 'Your cart is empty.' ] ),
		'checkout'  => soul_t( [ 'vi' => 'Gửi đơn hàng', 'en' => 'Place order' ] ),
		'close'     => soul_t( [ 'vi' => 'Đóng', 'en' => 'Close' ] ),
		'viewCart'  => soul_t( [ 'vi' => 'Xem giỏ', 'en' => 'View cart' ] ),
		'search'    => soul_t( [ 'vi' => 'Tìm', 'en' => 'Search' ] ),
		'searchPh'  => soul_t( [ 'vi' => 'Tìm cà phê, cửa hàng, bài viết…', 'en' => 'Search coffee, stores, articles…' ] ),
		'buyCoffee' => soul_t( [ 'vi' => 'Mua cà phê', 'en' => 'Shop coffee' ] ),
		'remove'    => soul_t( [ 'vi' => 'Xoá', 'en' => 'Remove' ] ),
		'qty'       => soul_t( [ 'vi' => 'Số lượng', 'en' => 'Quantity' ] ),
	];

	// Checkout UI — titles[0..2] for cart / pay / done screens; track for progress.
	$bag['checkoutUi'] = [
		'titles' => $is_en
			? [ 'Your cart', 'Checkout', 'Order placed' ]
			: [ 'Giỏ hàng', 'Thanh toán', 'Đặt hàng thành công' ],
		'track' => $is_en
			? [ 'Ordered', 'Confirmed', 'Shipping', 'Delivered' ]
			: [ 'Đã đặt hàng', 'Đã xác nhận', 'Đang giao', 'Đã nhận hàng' ],
		'errors' => $is_en
			? [
				'empty'   => 'Cart is empty.',
				'required'=> 'Please fill required fields.',
				'fail'    => 'Could not place order. Try again.',
			]
			: [
				'empty'   => 'Giỏ hàng đang trống.',
				'required'=> 'Vui lòng điền đủ thông tin bắt buộc.',
				'fail'    => 'Không gửi được đơn. Thử lại.',
			],
		'success' => $is_en
			? 'Thank you. Your order code is {code}.'
			: 'Cảm ơn bạn. Mã đơn của bạn là {code}.',
	];

	// Account SPA strings (subset; full set via account page localize).
	$bag['account'] = $is_en
		? [
			'login'    => 'Sign in',
			'register' => 'Create account',
			'logout'   => 'Sign out',
			'orders'   => 'Orders',
			'empty'    => 'No orders yet.',
			'cancel'   => 'Cancel order',
			'saved'    => 'Saved.',
			'error'    => 'Something went wrong.',
		]
		: [
			'login'    => 'Đăng nhập',
			'register' => 'Tạo tài khoản',
			'logout'   => 'Đăng xuất',
			'orders'   => 'Đơn hàng',
			'empty'    => 'Chưa có đơn hàng.',
			'cancel'   => 'Huỷ đơn',
			'saved'    => 'Đã lưu.',
			'error'    => 'Đã có lỗi xảy ra.',
		];

	$bag['orderLookup'] = $is_en
		? [
			'title'   => 'Order lookup',
			'eyebrow' => 'Orders',
			'notFound'=> 'Order not found.',
			'error'   => 'Lookup failed.',
			'submit'  => 'Look up',
		]
		: [
			'title'   => 'Tra cứu đơn',
			'eyebrow' => 'Đơn hàng',
			'notFound'=> 'Không tìm thấy đơn.',
			'error'   => 'Lỗi tra cứu.',
			'submit'  => 'Tra cứu',
		];

	return $bag;
}
