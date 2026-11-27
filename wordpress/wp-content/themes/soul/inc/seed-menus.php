<?php
/**
 * Seed Appearance → Menus with WP object links (pages / CPT archives / terms).
 *
 * @package Soul
 */

declare(strict_types=1);

/**
 * Add one nav item; returns new item ID or 0.
 *
 * @param array<string,mixed> $args wp_update_nav_menu_item args (without menu-item-status defaults).
 */
function soul_nav_menu_add_item(int $menu_id, array $args, int $parent_id = 0, int $position = 0): int {
	$args = array_merge(
		[
			'menu-item-status'   => 'publish',
			'menu-item-parent-id'=> $parent_id,
			'menu-item-position' => $position,
		],
		$args
	);
	$id = wp_update_nav_menu_item($menu_id, 0, $args);
	return (is_wp_error($id) || ! $id) ? 0 : (int) $id;
}

/** @return int Menu term ID or 0. */
function soul_nav_ensure_menu(string $name): int {
	$existing = wp_get_nav_menu_object($name);
	if ($existing) {
		return (int) $existing->term_id;
	}
	$created = wp_create_nav_menu($name);
	return is_wp_error($created) ? 0 : (int) $created;
}

/** Remove all items from a menu. */
function soul_nav_clear_menu(int $menu_id): void {
	$items = wp_get_nav_menu_items($menu_id);
	if (! is_array($items)) {
		return;
	}
	foreach ($items as $item) {
		wp_delete_post((int) $item->ID, true);
	}
}

/**
 * Resolve page ID by slug.
 */
function soul_nav_page_id(string $slug): int {
	$page = get_page_by_path($slug);
	return $page instanceof WP_Post ? (int) $page->ID : 0;
}

add_action('init', static function (): void {
	if (get_option('soul_seeded_menus_v2')) {
		return;
	}
	if (! function_exists('wp_create_nav_menu')) {
		return;
	}

	$home_id      = soul_nav_page_id('home');
	$newcrop_id   = soul_nav_page_id('new-crop');
	$story_id     = soul_nav_page_id('our-story');
	$solutions_id = soul_nav_page_id('coffee-solutions');
	$help_id      = soul_nav_page_id('help');
	$lookup_id    = soul_nav_page_id('order-lookup');
	$checkout_id  = (int) get_option('soul_checkout_page_id') ?: soul_nav_page_id('checkout');
	$blog_id      = (int) get_option('page_for_posts') ?: soul_nav_page_id('blog');

	$rang    = get_term_by('slug', 'ca-phe-rang', 'soul_collection');
	$green   = get_term_by('slug', 'ca-phe-nhan-xanh', 'soul_collection');
	$soulful = get_term_by('slug', 'soulful-flavours', 'soul_collection');

	$locations = get_theme_mod('nav_menu_locations', []);
	if (! is_array($locations)) {
		$locations = [];
	}

	/* ——— Primary ——— */
	$primary_id = soul_nav_ensure_menu('soul-primary');
	if ($primary_id > 0) {
		soul_nav_clear_menu($primary_id);
		$pos = 1;

		if ($home_id > 0) {
			soul_nav_menu_add_item($primary_id, [
				'menu-item-title'     => __('Trang chủ', 'soul'),
				'menu-item-type'      => 'post_type',
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $home_id,
			], 0, $pos++);
		}

		$shop_parent = soul_nav_menu_add_item($primary_id, [
			'menu-item-title'  => __('Sản phẩm', 'soul'),
			'menu-item-type'   => 'post_type_archive',
			'menu-item-object' => 'soul_product',
		], 0, $pos++);

		$child_pos = 1;
		if ($shop_parent > 0 && $rang instanceof WP_Term) {
			soul_nav_menu_add_item($primary_id, [
				'menu-item-title'     => $rang->name,
				'menu-item-type'      => 'taxonomy',
				'menu-item-object'    => 'soul_collection',
				'menu-item-object-id' => (int) $rang->term_id,
			], $shop_parent, $child_pos++);
		}
		if ($shop_parent > 0 && $green instanceof WP_Term) {
			soul_nav_menu_add_item($primary_id, [
				'menu-item-title'     => $green->name,
				'menu-item-type'      => 'taxonomy',
				'menu-item-object'    => 'soul_collection',
				'menu-item-object-id' => (int) $green->term_id,
			], $shop_parent, $child_pos++);
		}
		if ($shop_parent > 0 && $soulful instanceof WP_Term) {
			soul_nav_menu_add_item($primary_id, [
				'menu-item-title'     => 'Soulful Collection 2026',
				'menu-item-type'      => 'taxonomy',
				'menu-item-object'    => 'soul_collection',
				'menu-item-object-id' => (int) $soulful->term_id,
			], $shop_parent, $child_pos++);
		}
		if ($shop_parent > 0) {
			soul_nav_menu_add_item($primary_id, [
				'menu-item-title'  => __('Tất cả sản phẩm', 'soul'),
				'menu-item-type'   => 'post_type_archive',
				'menu-item-object' => 'soul_product',
			], $shop_parent, $child_pos++);
		}

		if ($newcrop_id > 0) {
			soul_nav_menu_add_item($primary_id, [
				'menu-item-title'     => __('Mùa vụ mới', 'soul'),
				'menu-item-type'      => 'post_type',
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $newcrop_id,
			], 0, $pos++);
		}
		if ($story_id > 0) {
			soul_nav_menu_add_item($primary_id, [
				'menu-item-title'     => __('Về Soul', 'soul'),
				'menu-item-type'      => 'post_type',
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $story_id,
			], 0, $pos++);
		}
		if ($solutions_id > 0) {
			soul_nav_menu_add_item($primary_id, [
				'menu-item-title'     => __('Giải pháp cà phê', 'soul'),
				'menu-item-type'      => 'post_type',
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $solutions_id,
			], 0, $pos++);
		}

		soul_nav_menu_add_item($primary_id, [
			'menu-item-title'  => __('Cửa hàng', 'soul'),
			'menu-item-type'   => 'post_type_archive',
			'menu-item-object' => 'soul_space',
		], 0, $pos++);

		if ($blog_id > 0) {
			soul_nav_menu_add_item($primary_id, [
				'menu-item-title'     => __('Blog', 'soul'),
				'menu-item-type'      => 'post_type',
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $blog_id,
			], 0, $pos++);
		}

		$locations['primary'] = $primary_id;
	}

	/* ——— Footer Shop ——— */
	$fs = soul_nav_ensure_menu('soul-footer-shop');
	if ($fs > 0) {
		soul_nav_clear_menu($fs);
		$p = 1;
		soul_nav_menu_add_item($fs, [
			'menu-item-title'  => __('Tất cả sản phẩm', 'soul'),
			'menu-item-type'   => 'post_type_archive',
			'menu-item-object' => 'soul_product',
		], 0, $p++);
		if ($soulful instanceof WP_Term) {
			soul_nav_menu_add_item($fs, [
				'menu-item-title'     => __('Soulful Collection', 'soul'),
				'menu-item-type'      => 'taxonomy',
				'menu-item-object'    => 'soul_collection',
				'menu-item-object-id' => (int) $soulful->term_id,
			], 0, $p++);
		}
		if ($newcrop_id > 0) {
			soul_nav_menu_add_item($fs, [
				'menu-item-title'     => __('Mùa vụ mới', 'soul'),
				'menu-item-type'      => 'post_type',
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $newcrop_id,
			], 0, $p++);
		}
		$locations['footer_shop'] = $fs;
	}

	/* ——— Footer Explore ——— */
	$fe = soul_nav_ensure_menu('soul-footer-explore');
	if ($fe > 0) {
		soul_nav_clear_menu($fe);
		$p = 1;
		if ($story_id > 0) {
			soul_nav_menu_add_item($fe, [
				'menu-item-title'     => __('Câu chuyện của Soul', 'soul'),
				'menu-item-type'      => 'post_type',
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $story_id,
			], 0, $p++);
		}
		soul_nav_menu_add_item($fe, [
			'menu-item-title'  => __('Cửa hàng', 'soul'),
			'menu-item-type'   => 'post_type_archive',
			'menu-item-object' => 'soul_space',
		], 0, $p++);
		if ($blog_id > 0) {
			soul_nav_menu_add_item($fe, [
				'menu-item-title'     => __('Blog', 'soul'),
				'menu-item-type'      => 'post_type',
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $blog_id,
			], 0, $p++);
		}
		if ($lookup_id > 0) {
			soul_nav_menu_add_item($fe, [
				'menu-item-title'     => __('Tra cứu đơn', 'soul'),
				'menu-item-type'      => 'post_type',
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $lookup_id,
			], 0, $p++);
		}
		$locations['footer_explore'] = $fe;
	}

	/* ——— Footer Partners ——— */
	$fp = soul_nav_ensure_menu('soul-footer-partners');
	if ($fp > 0) {
		soul_nav_clear_menu($fp);
		$p = 1;
		if ($solutions_id > 0) {
			soul_nav_menu_add_item($fp, [
				'menu-item-title'     => __('Giải pháp cà phê', 'soul'),
				'menu-item-type'      => 'post_type',
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $solutions_id,
			], 0, $p++);
			// Hash fragment — custom link (WP objects cannot store #contact).
			$sol_url = get_permalink($solutions_id) ?: home_url('/coffee-solutions/');
			soul_nav_menu_add_item($fp, [
				'menu-item-title'  => __('Mua sỉ / liên hệ', 'soul'),
				'menu-item-type'   => 'custom',
				'menu-item-url'    => trailingslashit($sol_url) . '#contact',
			], 0, $p++);
		}
		$locations['footer_partners'] = $fp;
	}

	/* ——— Footer Support ——— */
	$fsup = soul_nav_ensure_menu('soul-footer-support');
	if ($fsup > 0) {
		soul_nav_clear_menu($fsup);
		$p = 1;
		if ($help_id > 0) {
			$help_url = get_permalink($help_id) ?: home_url('/help/');
			soul_nav_menu_add_item($fsup, [
				'menu-item-title'     => __('Câu hỏi thường gặp', 'soul'),
				'menu-item-type'      => 'post_type',
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $help_id,
			], 0, $p++);
			soul_nav_menu_add_item($fsup, [
				'menu-item-title' => __('Giao hàng', 'soul'),
				'menu-item-type'  => 'custom',
				'menu-item-url'   => trailingslashit($help_url) . '#shipping',
			], 0, $p++);
			soul_nav_menu_add_item($fsup, [
				'menu-item-title' => __('Đổi trả', 'soul'),
				'menu-item-type'  => 'custom',
				'menu-item-url'   => trailingslashit($help_url) . '#returns',
			], 0, $p++);
		}
		if ($checkout_id > 0) {
			soul_nav_menu_add_item($fsup, [
				'menu-item-title'     => __('Giỏ hàng / Đặt hàng', 'soul'),
				'menu-item-type'      => 'post_type',
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $checkout_id,
			], 0, $p++);
		}
		$locations['footer_support'] = $fsup;
	}

	set_theme_mod('nav_menu_locations', $locations);
	update_option('soul_seeded_menus_v2', 1, false);
	// Keep v1 flag so old seeder does not run.
	update_option('soul_seeded_menus_v1', 1, false);
}, 35);

/**
 * @return WP_Term|null
 */
function soul_nav_collection_term( string $slug ): ?WP_Term {
	$term = get_term_by( 'slug', $slug, 'soul_collection' );
	return $term instanceof WP_Term ? $term : null;
}

/**
 * Delete a menu item and all descendants (by nav meta parent).
 */
function soul_nav_delete_branch( int $item_id ): void {
	$children = get_posts(
		[
			'post_type'      => 'nav_menu_item',
			'posts_per_page' => -1,
			'post_status'    => 'any',
			'meta_key'       => '_menu_item_menu_item_parent',
			'meta_value'     => (string) $item_id,
			'fields'         => 'ids',
		]
	);
	if ( is_array( $children ) ) {
		foreach ( $children as $child_id ) {
			soul_nav_delete_branch( (int) $child_id );
		}
	}
	wp_delete_post( $item_id, true );
}

/**
 * Rebuild only the Sản phẩm mega branch to match SoT (nested cols + feature meta).
 */
function soul_seed_primary_shop_mega_v3(): void {
	$locations = get_nav_menu_locations();
	if ( empty( $locations['primary'] ) ) {
		return;
	}
	$menu_id = (int) $locations['primary'];
	$items   = wp_get_nav_menu_items( $menu_id );
	if ( ! is_array( $items ) ) {
		return;
	}

	$shop_url = get_post_type_archive_link( 'soul_product' ) ?: home_url( '/products/' );
	$shop     = null;
	foreach ( $items as $item ) {
		if ( (int) $item->menu_item_parent !== 0 ) {
			continue;
		}
		$is_shop = (
			( (string) $item->type === 'post_type_archive' && (string) $item->object === 'soul_product' )
			|| untrailingslashit( (string) $item->url ) === untrailingslashit( $shop_url )
			|| str_contains( mb_strtolower( (string) $item->title ), 'sản phẩm' )
		);
		if ( $is_shop ) {
			$shop = $item;
			break;
		}
	}
	if ( ! $shop ) {
		return;
	}

	// Remove existing children of shop (and their descendants).
	foreach ( $items as $item ) {
		if ( (int) $item->menu_item_parent === (int) $shop->ID ) {
			soul_nav_delete_branch( (int) $item->ID );
		}
	}

	$rang    = soul_nav_collection_term( 'ca-phe-rang' );
	$green   = soul_nav_collection_term( 'ca-phe-nhan-xanh' );
	$soulful = soul_nav_collection_term( 'soulful-flavours' );
	$col_pos = 1;

	$rang_id = 0;
	if ( $rang ) {
		$rang_id = soul_nav_menu_add_item(
			$menu_id,
			[
				'menu-item-title'     => $rang->name,
				'menu-item-type'      => 'taxonomy',
				'menu-item-object'    => 'soul_collection',
				'menu-item-object-id' => (int) $rang->term_id,
			],
			(int) $shop->ID,
			$col_pos++
		);
	}

	$roasted = [
		[ 'Fine Robusta', 'san-pham-noi-bat' ],
		[ 'Pha máy', 'ca-phe-pha-may' ],
		[ 'Pha thủ công', 'ca-phe-pha-dung-cu' ],
		[ 'Pha phin', 'ca-phe-pha-phin' ],
		[ 'Cà phê ủ lạnh', 'ca-phe-u-lanh-cold-brew' ],
	];
	$gpos = 1;
	if ( $rang_id > 0 ) {
		foreach ( $roasted as $row ) {
			$term = soul_nav_collection_term( $row[1] );
			if ( ! $term ) {
				continue;
			}
			soul_nav_menu_add_item(
				$menu_id,
				[
					'menu-item-title'     => $row[0],
					'menu-item-type'      => 'taxonomy',
					'menu-item-object'    => 'soul_collection',
					'menu-item-object-id' => (int) $term->term_id,
				],
				$rang_id,
				$gpos++
			);
		}
	}

	$green_id = 0;
	if ( $green ) {
		$green_id = soul_nav_menu_add_item(
			$menu_id,
			[
				'menu-item-title'     => $green->name,
				'menu-item-type'      => 'taxonomy',
				'menu-item-object'    => 'soul_collection',
				'menu-item-object-id' => (int) $green->term_id,
			],
			(int) $shop->ID,
			$col_pos++
		);
	}
	$gpos = 1;
	if ( $green_id > 0 ) {
		$green_children = [
			[ 'Fine Robusta', 'fine-robusta' ],
			[ 'Premium Robusta', 'high-quality-robusta' ],
		];
		foreach ( $green_children as $row ) {
			$term = soul_nav_collection_term( $row[1] );
			if ( ! $term ) {
				continue;
			}
			soul_nav_menu_add_item(
				$menu_id,
				[
					'menu-item-title'     => $row[0],
					'menu-item-type'      => 'taxonomy',
					'menu-item-object'    => 'soul_collection',
					'menu-item-object-id' => (int) $term->term_id,
				],
				$green_id,
				$gpos++
			);
		}
		soul_nav_menu_add_item(
			$menu_id,
			[
				'menu-item-title'  => __( 'Xem tất cả cà phê', 'soul' ) . ' ↗',
				'menu-item-type'   => 'post_type_archive',
				'menu-item-object' => 'soul_product',
				'menu-item-classes'=> 'mega-cta',
			],
			$green_id,
			$gpos++
		);
	}

	if ( $soulful ) {
		$feat_id = soul_nav_menu_add_item(
			$menu_id,
			[
				'menu-item-title'     => 'Soulful Collection 2026',
				'menu-item-type'      => 'taxonomy',
				'menu-item-object'    => 'soul_collection',
				'menu-item-object-id' => (int) $soulful->term_id,
				'menu-item-classes'   => 'mega-feature',
			],
			(int) $shop->ID,
			$col_pos++
		);
		if ( $feat_id > 0 && function_exists( 'soul_mega_feature_save_meta' ) ) {
			soul_mega_feature_save_meta(
				$feat_id,
				[
					'image_id'  => 0,
					'image_url' => SOUL_URI . '/assets/images/04-soulful/Soulful_vuong.png',
					'eyebrow'   => __( 'Mùa vụ mới', 'soul' ),
					'tagline'   => 'Cay · Nồng · Thơm · Ngọt',
					'cta'       => __( 'Khám phá Soulful 2026', 'soul' ),
				]
			);
		}
	}
}

add_action(
	'init',
	static function (): void {
		if ( get_option( 'soul_seeded_menus_v3' ) ) {
			return;
		}
		if ( ! get_option( 'soul_seeded_menus_v2' ) ) {
			return;
		}
		if ( ! function_exists( 'wp_create_nav_menu' ) ) {
			return;
		}
		soul_seed_primary_shop_mega_v3();
		update_option( 'soul_seeded_menus_v3', 1, false );
	},
	36
);
