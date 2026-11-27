<?php
/**
 * Polylang content bootstrap — assign VI, duplicate EN pages/CPT/terms/menus.
 *
 * @package Soul
 */

declare(strict_types=1);

/**
 * Page slug => EN title override.
 *
 * @return array<string,string>
 */
function soul_pll_core_page_en_titles(): array {
	return [
		'home'             => 'Home',
		'new-crop'         => 'New Crop',
		'our-story'        => 'Our Story',
		'coffee-solutions' => 'Coffee Solutions',
		'help'             => 'Help',
		'checkout'         => 'Checkout',
		'account'          => 'Account',
		'order-lookup'     => 'Order lookup',
		'blog'             => 'Blog',
	];
}

/** Collection slug => EN name. */
function soul_pll_collection_en_names(): array {
	return [
		'ca-phe-rang'              => 'Roasted coffee',
		'ca-phe-nhan-xanh'         => 'Green beans',
		'soulful-flavours'         => 'Soulful Collection',
		'san-pham-noi-bat'         => 'Featured',
		'ca-phe-pha-may'           => 'Espresso',
		'ca-phe-pha-dung-cu'       => 'Brewing',
		'ca-phe-pha-phin'          => 'Vietnamese phin',
		'ca-phe-u-lanh-cold-brew'  => 'Cold brew',
		'fine-robusta'             => 'Fine Robusta',
		'high-quality-robusta'     => 'Premium Robusta',
	];
}

function soul_pll_assign_existing_to_vi(): void {
	if ( ! function_exists( 'soul_pll_set_post_lang' ) ) {
		return;
	}
	$types = [ 'page', 'post', 'soul_product', 'soul_space' ];
	foreach ( $types as $type ) {
		$ids = get_posts(
			[
				'post_type'      => $type,
				'post_status'    => 'any',
				'posts_per_page' => -1,
				'fields'         => 'ids',
				'no_found_rows'  => true,
			]
		);
		foreach ( $ids as $id ) {
			soul_pll_set_post_lang( (int) $id, 'vi' );
		}
	}
	$terms = get_terms(
		[
			'taxonomy'   => 'soul_collection',
			'hide_empty' => false,
			'fields'     => 'ids',
		]
	);
	if ( ! is_wp_error( $terms ) ) {
		foreach ( $terms as $tid ) {
			soul_pll_set_term_lang( (int) $tid, 'vi' );
		}
	}
}

function soul_pll_seed_en_pages(): void {
	foreach ( soul_pll_core_page_en_titles() as $slug => $en_title ) {
		$page = get_page_by_path( $slug );
		if ( ! $page && $slug === 'blog' ) {
			$blog_id = (int) get_option( 'page_for_posts' );
			$page    = $blog_id ? get_post( $blog_id ) : null;
		}
		if ( ! $page instanceof WP_Post ) {
			continue;
		}
		soul_pll_duplicate_post_to_en( (int) $page->ID, $en_title );
	}

	// Front page / posts page language settings.
	$front_id = (int) get_option( 'page_on_front' );
	$posts_id = (int) get_option( 'page_for_posts' );
	if ( $front_id > 0 && function_exists( 'pll_get_post' ) && function_exists( 'PLL' ) ) {
		$en_front = (int) pll_get_post( $front_id, 'en' );
		$en_posts = $posts_id ? (int) pll_get_post( $posts_id, 'en' ) : 0;
		$opts     = get_option( 'polylang' );
		if ( ! is_array( $opts ) ) {
			$opts = [];
		}
		// Polylang stores page_on_front per language on language objects; also set via model if available.
		if ( $en_front > 0 && function_exists( 'pll_set_post_language' ) ) {
			// Ensure translations linked (already by duplicate).
		}
		unset( $opts, $en_posts );
	}
}

function soul_pll_seed_en_collections(): void {
	$map = soul_pll_collection_en_names();
	foreach ( $map as $slug => $en_name ) {
		$term = get_term_by( 'slug', $slug, 'soul_collection' );
		if ( ! $term instanceof WP_Term ) {
			continue;
		}
		soul_pll_duplicate_term_to_en( (int) $term->term_id, 'soul_collection', $en_name );
	}
}

function soul_pll_seed_en_products_spaces(): void {
	// Featured / Soulful products + all spaces.
	$product_ids = get_posts(
		[
			'post_type'      => 'soul_product',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'fields'         => 'ids',
			'tax_query'      => [
				[
					'taxonomy' => 'soul_collection',
					'field'    => 'slug',
					'terms'    => [ 'soulful-flavours', 'san-pham-noi-bat', 'origin-collection' ],
				],
			],
		]
	);
	foreach ( $product_ids as $id ) {
		soul_pll_duplicate_post_to_en( (int) $id );
	}
	$space_ids = get_posts(
		[
			'post_type'      => 'soul_space',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'fields'         => 'ids',
		]
	);
	foreach ( $space_ids as $id ) {
		soul_pll_duplicate_post_to_en( (int) $id );
	}
}

/**
 * Clone primary + footer menus to EN and register nav locations for EN.
 */
function soul_pll_seed_en_menus(): void {
	if ( ! function_exists( 'pll_languages_list' ) ) {
		return;
	}
	$locations = get_theme_mod( 'nav_menu_locations', [] );
	if ( ! is_array( $locations ) ) {
		$locations = [];
	}

	$pairs = [
		'primary'         => [ 'soul-primary', 'soul-primary-en', 'Primary EN' ],
		'footer_shop'     => [ 'soul-footer-shop', 'soul-footer-shop-en', 'Footer Shop EN' ],
		'footer_explore'  => [ 'soul-footer-explore', 'soul-footer-explore-en', 'Footer Explore EN' ],
		'footer_partners' => [ 'soul-footer-partners', 'soul-footer-partners-en', 'Footer Partners EN' ],
		'footer_support'  => [ 'soul-footer-support', 'soul-footer-support-en', 'Footer Support EN' ],
	];

	$title_map = [
		'Trang chủ'           => 'Home',
		'Sản phẩm'            => 'Shop',
		'Mùa vụ mới'          => 'New Crop',
		'Về Soul'             => 'Our Story',
		'Giải pháp cà phê'    => 'Coffee Solutions',
		'Cửa hàng'            => 'Spaces',
		'Blog'                => 'Blog',
		'Cà phê rang'         => 'Roasted coffee',
		'Nhân xanh'           => 'Green beans',
		'Tất cả sản phẩm'     => 'All products',
		'Xem tất cả cà phê ↗' => 'View all coffee ↗',
		'Soulful Collection 2026' => 'Soulful Collection 2026',
		'Fine Robusta'        => 'Fine Robusta',
		'Pha máy'             => 'Espresso',
		'Pha thủ công'        => 'Brewing',
		'Pha phin'            => 'Vietnamese phin',
		'Cà phê ủ lạnh'       => 'Cold brew',
		'Premium Robusta'     => 'Premium Robusta',
		'Soulful Collection'  => 'Soulful Collection',
		'Câu chuyện của Soul' => 'Our Story',
		'Tra cứu đơn'         => 'Order lookup',
		'Mua sỉ / liên hệ'    => 'Wholesale / contact',
		'Câu hỏi thường gặp'  => 'FAQ',
		'Giao hàng'           => 'Shipping',
		'Đổi trả'             => 'Returns',
		'Giỏ hàng / Đặt hàng' => 'Cart / Checkout',
	];

	$theme = get_option( 'stylesheet' );
	$nav_menus = [];
	$opts = get_option( 'polylang' );
	if ( is_array( $opts ) && isset( $opts['nav_menus'][ $theme ] ) ) {
		$nav_menus = $opts['nav_menus'][ $theme ];
	}

	foreach ( $pairs as $location => $meta ) {
		[ $vi_slug, $en_slug, $en_name ] = $meta;
		$vi_menu = wp_get_nav_menu_object( $vi_slug );
		if ( ! $vi_menu ) {
			continue;
		}
		$en_id = 0;
		$existing = wp_get_nav_menu_object( $en_slug );
		if ( $existing ) {
			$en_id = (int) $existing->term_id;
			soul_nav_clear_menu( $en_id );
		} else {
			$created = wp_create_nav_menu( $en_name );
			if ( is_wp_error( $created ) ) {
				continue;
			}
			$en_id = (int) $created;
			// Rename slug via term update.
			wp_update_term(
				$en_id,
				'nav_menu',
				[ 'slug' => $en_slug ]
			);
		}

		$items = wp_get_nav_menu_items( (int) $vi_menu->term_id );
		if ( ! is_array( $items ) ) {
			continue;
		}
		// Parents before children so id_map resolves.
		$by_id = [];
		foreach ( $items as $item ) {
			$by_id[ (int) $item->ID ] = $item;
		}
		$sorted = [];
		$seen   = [];
		$visit  = static function ( int $id ) use ( &$visit, &$sorted, &$seen, $by_id ): void {
			if ( isset( $seen[ $id ] ) || ! isset( $by_id[ $id ] ) ) {
				return;
			}
			$seen[ $id ] = true;
			$parent = (int) $by_id[ $id ]->menu_item_parent;
			if ( $parent > 0 ) {
				$visit( $parent );
			}
			$sorted[] = $by_id[ $id ];
		};
		foreach ( array_keys( $by_id ) as $id ) {
			$visit( (int) $id );
		}
		$items = $sorted;

		$id_map = []; // old item id => new item id
		foreach ( $items as $item ) {
			$parent_new = ! empty( $item->menu_item_parent ) && isset( $id_map[ (int) $item->menu_item_parent ] )
				? $id_map[ (int) $item->menu_item_parent ]
				: 0;
			$title = (string) $item->title;
			if ( isset( $title_map[ $title ] ) ) {
				$title = $title_map[ $title ];
			}
			$args = [
				'menu-item-title'  => $title,
				'menu-item-status' => 'publish',
				'menu-item-position' => (int) $item->menu_order,
				'menu-item-parent-id' => $parent_new,
			];
			$classes = empty( $item->classes ) ? [] : array_filter( (array) $item->classes );
			if ( $classes !== [] ) {
				$args['menu-item-classes'] = implode( ' ', $classes );
			}

			// Point object items to EN translation when available.
			$type = (string) $item->type;
			if ( $type === 'post_type' || $type === 'post_type_archive' || $type === 'taxonomy' ) {
				$args['menu-item-type']   = $type;
				$args['menu-item-object'] = (string) $item->object;
				$obj_id = (int) $item->object_id;
				if ( $type === 'taxonomy' && $obj_id && function_exists( 'pll_get_term' ) ) {
					$en_term = pll_get_term( $obj_id, 'en' );
					$args['menu-item-object-id'] = $en_term ? (int) $en_term : $obj_id;
				} elseif ( $type === 'post_type' && $obj_id && function_exists( 'pll_get_post' ) ) {
					$en_post = pll_get_post( $obj_id, 'en' );
					$args['menu-item-object-id'] = $en_post ? (int) $en_post : $obj_id;
				} elseif ( $type === 'post_type_archive' ) {
					$args['menu-item-object'] = (string) $item->object;
				} else {
					$args['menu-item-object-id'] = $obj_id;
				}
			} else {
				$url = (string) $item->url;
				if ( function_exists( 'pll_home_url' ) && str_starts_with( $url, home_url( '/' ) ) ) {
					// Prefer EN home-prefixed custom URLs when possible.
					$url = str_replace( untrailingslashit( home_url( '/' ) ), untrailingslashit( pll_home_url( 'en' ) ), $url );
				}
				$args['menu-item-type'] = 'custom';
				$args['menu-item-url']  = $url;
			}

			$new_item = wp_update_nav_menu_item( $en_id, 0, $args );
			if ( ! is_wp_error( $new_item ) && $new_item ) {
				$id_map[ (int) $item->ID ] = (int) $new_item;
				// Copy mega feature meta.
				if ( in_array( 'mega-feature', $classes, true ) && function_exists( 'soul_mega_feature_meta' ) ) {
					$meta = soul_mega_feature_meta( (int) $item->ID );
					if ( function_exists( 'soul_mega_feature_save_meta' ) ) {
						$meta['eyebrow'] = 'New crop';
						$meta['cta']     = 'Explore Soulful 2026';
						soul_mega_feature_save_meta( (int) $new_item, $meta );
					}
				}
			}
		}

		$nav_menus[ $location ]['vi'] = (int) $vi_menu->term_id;
		$nav_menus[ $location ]['en'] = $en_id;
		// Keep default theme location on VI.
		$locations[ $location ] = (int) $vi_menu->term_id;
	}

	set_theme_mod( 'nav_menu_locations', $locations );
	if ( ! is_array( $opts ) ) {
		$opts = [];
	}
	$opts['nav_menus'][ $theme ] = $nav_menus;
	update_option( 'polylang', $opts );
}

add_action(
	'init',
	static function (): void {
		if ( get_option( 'soul_pll_content_v1' ) ) {
			return;
		}
		if ( ! function_exists( 'pll_set_post_language' ) || ! function_exists( 'pll_languages_list' ) ) {
			return;
		}
		if ( pll_languages_list() === [] ) {
			return;
		}
		soul_pll_ensure_languages();
		soul_pll_assign_existing_to_vi();
		soul_pll_seed_en_collections();
		soul_pll_seed_en_pages();
		soul_pll_seed_en_products_spaces();
		if ( function_exists( 'soul_nav_clear_menu' ) ) {
			soul_pll_seed_en_menus();
		}
		update_option( 'soul_pll_content_v1', 1, false );
		flush_rewrite_rules( false );
	},
	50
);
