<?php
/**
 * Header / mobile walkers — WP object menus + nested dropdowns.
 *
 * @package Soul
 */

declare(strict_types=1);

class Soul_Primary_Walker extends Walker_Nav_Menu {
	/** @param mixed $args */
	public function start_lvl( &$output, $depth = 0, $args = null ): void {
		$output .= '<ul class="l-nav-dropdown">';
	}

	/** @param mixed $args */
	public function end_lvl( &$output, $depth = 0, $args = null ): void {
		$output .= '</ul>';
	}

	/**
	 * @param mixed $item
	 * @param mixed $args
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ): void {
		$classes = empty($item->classes) ? [] : (array) $item->classes;
		$has_children = in_array('menu-item-has-children', $classes, true);

		$shop = get_post_type_archive_link('soul_product') ?: home_url('/products/');
		$url  = (string) $item->url;
		$title = (string) $item->title;
		$is_shop = $depth === 0 && (
			(string) $item->type === 'post_type_archive' && (string) $item->object === 'soul_product'
			|| untrailingslashit($url) === untrailingslashit($shop)
			|| str_contains(mb_strtolower($title), 'sản phẩm')
		);
		/* Mega panel only when shop parent actually has menu children. */
		$use_mega = $is_shop && $has_children;

		$li_class = 'l-nav-item';
		if ($has_children) {
			$li_class .= ' l-nav-item--has-children';
		}
		if ($use_mega) {
			$li_class .= ' l-nav-item--mega';
		}
		if (! empty($item->current) || ! empty($item->current_item_ancestor)) {
			$li_class .= ' is-current';
		}

		$output .= '<li class="' . esc_attr($li_class) . '">';

		if ($depth === 0) {
			$attrs = ' class="l-header__link"';
			$label = esc_html($title);
			if ($use_mega || $has_children) {
				$attrs .= ' aria-haspopup="true" aria-expanded="false"';
				$label .= ' <span aria-hidden="true">▾</span>';
			}
			if ($use_mega) {
				$attrs .= ' data-mega-trigger="shop"';
			}
			$output .= sprintf('<a href="%s"%s>%s</a>', esc_url($url), $attrs, $label);
		} else {
			$output .= sprintf(
				'<a class="l-nav-dropdown__link" href="%s">%s</a>',
				esc_url($url),
				esc_html($title)
			);
		}
	}

	/**
	 * @param mixed $item
	 * @param mixed $args
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ): void {
		$output .= '</li>';
	}
}

/**
 * Primary “Sản phẩm” mega tree from Appearance → Menus.
 *
 * @return array{parent: ?object, children: list<object>}
 */
function soul_primary_mega_tree(): array {
	$empty = [ 'parent' => null, 'children' => [] ];
	$locations = get_nav_menu_locations();
	if ( empty( $locations['primary'] ) ) {
		return $empty;
	}
	$items = wp_get_nav_menu_items( (int) $locations['primary'] );
	if ( ! is_array( $items ) || $items === [] ) {
		return $empty;
	}

	$shop = get_post_type_archive_link( 'soul_product' ) ?: home_url( '/products/' );
	$parent = null;
	foreach ( $items as $item ) {
		if ( (int) $item->menu_item_parent !== 0 ) {
			continue;
		}
		$url   = (string) $item->url;
		$title = (string) $item->title;
		$is_shop = (
			( (string) $item->type === 'post_type_archive' && (string) $item->object === 'soul_product' )
			|| untrailingslashit( $url ) === untrailingslashit( $shop )
			|| str_contains( mb_strtolower( $title ), 'sản phẩm' )
		);
		if ( $is_shop ) {
			$parent = $item;
			break;
		}
	}
	if ( ! $parent ) {
		return $empty;
	}

	$children = array_values(
		array_filter(
			$items,
			static fn( $item ) => (int) $item->menu_item_parent === (int) $parent->ID
		)
	);
	usort( $children, static fn( $a, $b ) => (int) $a->menu_order <=> (int) $b->menu_order );

	foreach ( $children as $child ) {
		$grand = array_values(
			array_filter(
				$items,
				static fn( $item ) => (int) $item->menu_item_parent === (int) $child->ID
			)
		);
		usort( $grand, static fn( $a, $b ) => (int) $a->menu_order <=> (int) $b->menu_order );
		$child->soul_children = $grand;
	}

	return [ 'parent' => $parent, 'children' => $children ];
}

/** Whether a menu item carries a given CSS class. */
function soul_menu_item_has_class( object $item, string $class ): bool {
	$classes = empty( $item->classes ) ? [] : (array) $item->classes;
	return in_array( $class, $classes, true );
}

/** Echo SoT feature card for a mega-feature menu item. */
function soul_render_mega_feature_card( object $item ): void {
	$meta     = function_exists( 'soul_mega_feature_meta' ) ? soul_mega_feature_meta( (int) $item->ID ) : [
		'image_url' => '',
		'eyebrow'   => '',
		'tagline'   => '',
		'cta'       => '',
	];
	$url      = (string) $item->url;
	$title    = (string) $item->title;
	$eyebrow  = $meta['eyebrow'] !== '' ? $meta['eyebrow'] : __( 'Mùa vụ mới', 'soul' );
	$tagline  = $meta['tagline'];
	$cta      = $meta['cta'] !== '' ? $meta['cta'] : __( 'Khám phá', 'soul' );
	$image    = $meta['image_url'];

	echo '<a class="l-mega__feature-card" href="' . esc_url( $url ) . '">';
	if ( $image !== '' ) {
		printf(
			'<img class="l-mega__feature-img" src="%s" alt="%s" width="320" height="320" loading="lazy" decoding="async">',
			esc_url( $image ),
			esc_attr( $title )
		);
	}
	echo '<div class="l-mega__feature-copy">';
	echo '<div class="l-mega__feature-eyebrow">' . esc_html( $eyebrow ) . '</div>';
	echo '<div class="l-mega__feature-title">' . esc_html( $title ) . '</div>';
	if ( $tagline !== '' ) {
		echo '<div class="l-mega__feature-tagline">' . esc_html( $tagline ) . '</div>';
	}
	echo '<div class="l-mega__feature-cta">' . esc_html( $cta ) . ' ↗</div>';
	echo '</div></a>';
}

/** Echo shop mega panel built from primary menu children (or nothing if empty). */
function soul_render_shop_mega(): void {
	$tree = soul_primary_mega_tree();
	if ( $tree['children'] === [] ) {
		return;
	}

	$has_nested = false;
	$has_feature = false;
	foreach ( $tree['children'] as $child ) {
		if ( ! empty( $child->soul_children ) ) {
			$has_nested = true;
		}
		if ( soul_menu_item_has_class( $child, 'mega-feature' ) ) {
			$has_feature = true;
		}
	}
	$use_cols = $has_nested || $has_feature;

	$label = $tree['parent'] ? (string) $tree['parent']->title : __( 'Sản phẩm', 'soul' );
	echo '<div class="l-mega" data-mega="shop" hidden role="region" aria-label="' . esc_attr( $label ) . '">';
	$inner_class = $use_cols ? 'l-mega__inner l-mega__inner--menu' : 'l-mega__inner l-mega__inner--menu l-mega__inner--flat';
	echo '<div class="' . esc_attr( $inner_class ) . '">';

	if ( $use_cols ) {
		foreach ( $tree['children'] as $col ) {
			if ( soul_menu_item_has_class( $col, 'mega-feature' ) ) {
				echo '<div class="l-mega__feature">';
				soul_render_mega_feature_card( $col );
				echo '</div>';
				continue;
			}

			echo '<div class="l-mega__col">';
			echo '<div class="l-mega__head">' . esc_html( (string) $col->title ) . '</div>';
			echo '<ul class="l-mega__list">';
			$kids = ! empty( $col->soul_children ) ? $col->soul_children : [];
			if ( $kids === [] ) {
				printf(
					'<li><a href="%s">%s</a></li>',
					esc_url( (string) $col->url ),
					esc_html( (string) $col->title )
				);
			} else {
				foreach ( $kids as $g ) {
					$li_class = soul_menu_item_has_class( $g, 'mega-cta' ) ? ' class="l-mega__cta"' : '';
					printf(
						'<li%s><a href="%s">%s</a></li>',
						$li_class,
						esc_url( (string) $g->url ),
						esc_html( (string) $g->title )
					);
				}
			}
			echo '</ul></div>';
		}
	} else {
		echo '<div class="l-mega__flat">';
		echo '<ul class="l-mega__list l-mega__list--flat">';
		foreach ( $tree['children'] as $c ) {
			if ( soul_menu_item_has_class( $c, 'mega-feature' ) ) {
				continue;
			}
			printf(
				'<li><a href="%s">%s</a></li>',
				esc_url( (string) $c->url ),
				esc_html( (string) $c->title )
			);
		}
		echo '</ul></div>';
	}

	echo '</div></div>';
}

/** Mobile drawer — nested list. */
class Soul_Mobile_Walker extends Walker_Nav_Menu {
	/** @param mixed $args */
	public function start_lvl( &$output, $depth = 0, $args = null ): void {
		$output .= '<ul class="soul-mobile-menu__sub">';
	}

	/** @param mixed $args */
	public function end_lvl( &$output, $depth = 0, $args = null ): void {
		$output .= '</ul>';
	}

	/**
	 * @param mixed $item
	 * @param mixed $args
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ): void {
		$classes = empty($item->classes) ? [] : (array) $item->classes;
		$has_children = in_array('menu-item-has-children', $classes, true);
		$li = 'soul-mobile-menu__item';
		if ($has_children) {
			$li .= ' soul-mobile-menu__item--parent';
		}
		$output .= '<li class="' . esc_attr($li) . '">';
		$output .= sprintf(
			'<a href="%s">%s</a>',
			esc_url((string) $item->url),
			esc_html((string) $item->title)
		);
	}

	/**
	 * @param mixed $item
	 * @param mixed $args
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ): void {
		$output .= '</li>';
	}
}
