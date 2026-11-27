<?php
/**
 * Polylang integration — CPT/tax, switcher, strings, content helpers.
 *
 * @package Soul
 */

declare(strict_types=1);

/** Whether Polylang is ready with languages. */
function soul_pll_ready(): bool {
	return function_exists( 'pll_languages_list' )
		&& function_exists( 'pll_current_language' )
		&& pll_languages_list() !== [];
}

/**
 * Register CPT / taxonomies for translation; exclude orders.
 *
 * @param array<string,mixed> $post_types
 * @return array<string,mixed>
 */
function soul_pll_post_types( array $post_types ): array {
	$post_types['soul_product'] = 'soul_product';
	$post_types['soul_space']   = 'soul_space';
	unset( $post_types['soul_order'] );
	return $post_types;
}

/**
 * @param array<string,mixed> $taxonomies
 * @return array<string,mixed>
 */
function soul_pll_taxonomies( array $taxonomies ): array {
	$taxonomies['soul_collection'] = 'soul_collection';
	return $taxonomies;
}

add_filter( 'pll_get_post_types', 'soul_pll_post_types', 10, 1 );
add_filter( 'pll_get_taxonomies', 'soul_pll_taxonomies', 10, 1 );

/**
 * Render VI|EN switcher matching existing chrome classes.
 *
 * @param array<string,string> $args class_wrap, class_btn, class_on
 */
function soul_pll_language_switcher( array $args = [] ): void {
	$defaults = [
		'class_wrap' => 'soul-lang c-lang',
		'class_btn'  => 'soul-lang__btn',
		'class_on'   => 'is-on',
	];
	$args = array_merge( $defaults, $args );

	if ( ! soul_pll_ready() || ! function_exists( 'pll_the_languages' ) ) {
		echo '<div class="' . esc_attr( $args['class_wrap'] ) . '" role="group" aria-label="Language">';
		echo '<span class="' . esc_attr( $args['class_btn'] . ' ' . $args['class_on'] ) . '">VI</span>';
		echo '</div>';
		return;
	}

	$langs = pll_the_languages(
		[
			'raw'                  => 1,
			'hide_if_empty'        => 0,
			'hide_current'         => 0,
			'display_names_as'     => 'slug',
			'hide_if_no_translation'=> 0,
		]
	);
	if ( ! is_array( $langs ) || $langs === [] ) {
		return;
	}

	echo '<div class="' . esc_attr( $args['class_wrap'] ) . '" role="group" aria-label="Language">';
	foreach ( $langs as $lang ) {
		$slug    = strtoupper( (string) ( $lang['slug'] ?? '' ) );
		$url     = (string) ( $lang['url'] ?? '#' );
		$current = ! empty( $lang['current_lang'] );
		$cls     = $args['class_btn'] . ( $current ? ' ' . $args['class_on'] : '' );
		printf(
			'<a class="%s" href="%s" hreflang="%s" lang="%s"%s>%s</a>',
			esc_attr( $cls ),
			esc_url( $url ),
			esc_attr( (string) ( $lang['locale'] ?? $lang['slug'] ?? '' ) ),
			esc_attr( (string) ( $lang['slug'] ?? '' ) ),
			$current ? ' aria-current="true"' : '',
			esc_html( $slug )
		);
	}
	echo '</div>';
}

/** Register theme chrome strings for Polylang String translations. */
function soul_pll_register_strings(): void {
	if ( ! function_exists( 'pll_register_string' ) ) {
		return;
	}
	$group = 'SOUL Chrome';
	foreach ( soul_chrome_strings() as $key => $pair ) {
		if ( ! is_array( $pair ) ) {
			continue;
		}
		$vi = (string) ( $pair['vi'] ?? '' );
		if ( $vi === '' ) {
			continue;
		}
		pll_register_string( 'soul_chrome_' . $key, $vi, $group, false );
	}

	$extra = [
		'soul_close'         => 'Đóng',
		'soul_view_cart'     => 'Xem giỏ',
		'soul_cart_empty'    => 'Giỏ hàng đang trống.',
		'soul_buy_coffee'    => 'Mua cà phê',
		'soul_search_ph'     => 'Tìm cà phê, cửa hàng, bài viết…',
		'soul_search_btn'    => 'Tìm',
		'soul_added'         => 'đã thêm vào giỏ',
		'soul_submit_order'  => 'Gửi đơn hàng',
		'soul_order_lookup'  => 'Tra cứu đơn',
		'soul_help'          => 'Hỗ trợ',
		'soul_account'       => 'Tài khoản',
		'soul_not_found'     => 'Không tìm thấy trang',
		'soul_404_title'     => 'Tách này chưa được pha.',
		'soul_404_body'      => 'Trang bạn tìm có thể đã chuyển chỗ hoặc chưa tồn tại. Thử tìm kiếm hoặc chọn một lối đi bên dưới.',
		'soul_keep_going'    => 'Đi tiếp',
		'soul_contact'       => 'Liên hệ',
	];
	foreach ( $extra as $name => $string ) {
		pll_register_string( $name, $string, $group, false );
	}
}

add_action( 'init', 'soul_pll_register_strings', 20 );

/**
 * Translate a registered string; fallback to EN pair from chrome map or raw.
 */
function soul_pll__( string $vi_string, string $en_fallback = '' ): string {
	if ( function_exists( 'pll__' ) ) {
		$out = pll__( $vi_string );
		if ( is_string( $out ) && $out !== '' ) {
			// If still VI while on EN and we have fallback, use fallback when pll has no translation yet.
			if ( soul_get_lang() === 'en' && $out === $vi_string && $en_fallback !== '' ) {
				return $en_fallback;
			}
			return $out;
		}
	}
	return soul_get_lang() === 'en' && $en_fallback !== '' ? $en_fallback : $vi_string;
}

/**
 * One-shot: ensure VI/EN exist + settings (idempotent).
 */
function soul_pll_ensure_languages(): void {
	if ( ! function_exists( 'PLL' ) ) {
		return;
	}
	$pll = PLL();
	if ( ! $pll || ! isset( $pll->model ) ) {
		return;
	}
	$list = function_exists( 'pll_languages_list' ) ? pll_languages_list() : [];
	if ( ! in_array( 'vi', $list, true ) ) {
		$pll->model->add_language(
			[
				'name'   => 'Tiếng Việt',
				'slug'   => 'vi',
				'locale' => 'vi',
				'rtl'    => 0,
				'flag'   => 'vn',
			]
		);
	}
	if ( ! in_array( 'en', $list, true ) ) {
		$pll->model->add_language(
			[
				'name'   => 'English',
				'slug'   => 'en',
				'locale' => 'en_US',
				'rtl'    => 0,
				'flag'   => 'us',
			]
		);
	}
	$opts = get_option( 'polylang' );
	if ( ! is_array( $opts ) ) {
		$opts = [];
	}
	$opts['default_lang']  = 'vi';
	$opts['force_lang']    = 1;
	$opts['hide_default']  = 1;
	$opts['rewrite']       = 1;
	$opts['browser']       = 0;
	$opts['media_support'] = 0;
	$opts['redirect_lang'] = 0;
	$opts['post_types']    = array_values(
		array_unique(
			array_merge(
				(array) ( $opts['post_types'] ?? [] ),
				[ 'soul_product', 'soul_space' ]
			)
		)
	);
	$opts['taxonomies'] = array_values(
		array_unique(
			array_merge(
				(array) ( $opts['taxonomies'] ?? [] ),
				[ 'soul_collection' ]
			)
		)
	);
	// Remove orders if present.
	$opts['post_types'] = array_values(
		array_filter(
			$opts['post_types'],
			static fn( $t ) => $t !== 'soul_order'
		)
	);
	update_option( 'polylang', $opts );
	if ( method_exists( $pll->model, 'clean_languages_cache' ) ) {
		$pll->model->clean_languages_cache();
	}
}

add_action(
	'init',
	static function (): void {
		if ( get_option( 'soul_pll_bootstrapped_v1' ) ) {
			return;
		}
		if ( ! function_exists( 'PLL' ) ) {
			return;
		}
		soul_pll_ensure_languages();
		update_option( 'soul_pll_bootstrapped_v1', 1, false );
	},
	5
);

/**
 * Assign language to a post if missing.
 */
function soul_pll_set_post_lang( int $post_id, string $lang = 'vi' ): void {
	if ( $post_id <= 0 || ! function_exists( 'pll_set_post_language' ) ) {
		return;
	}
	$current = function_exists( 'pll_get_post_language' ) ? pll_get_post_language( $post_id ) : false;
	if ( ! $current ) {
		pll_set_post_language( $post_id, $lang );
	}
}

/**
 * Assign language to a term if missing.
 */
function soul_pll_set_term_lang( int $term_id, string $lang = 'vi' ): void {
	if ( $term_id <= 0 || ! function_exists( 'pll_set_term_language' ) ) {
		return;
	}
	$current = function_exists( 'pll_get_term_language' ) ? pll_get_term_language( $term_id ) : false;
	if ( ! $current ) {
		pll_set_term_language( $term_id, $lang );
	}
}

/**
 * Link VI ↔ EN post translations.
 *
 * @param array<string,int> $translations slug => post_id
 */
function soul_pll_save_post_translations( array $translations ): void {
	if ( ! function_exists( 'pll_save_post_translations' ) ) {
		return;
	}
	pll_save_post_translations( $translations );
}

/**
 * Duplicate a post as EN translation (content copy; editor can refine).
 *
 * @return int New post ID or 0
 */
function soul_pll_duplicate_post_to_en( int $source_id, string $en_title = '' ): int {
	if ( $source_id <= 0 || ! function_exists( 'pll_set_post_language' ) ) {
		return 0;
	}
	soul_pll_set_post_lang( $source_id, 'vi' );
	$existing = function_exists( 'pll_get_post' ) ? pll_get_post( $source_id, 'en' ) : 0;
	if ( $existing ) {
		return (int) $existing;
	}

	$src = get_post( $source_id );
	if ( ! $src instanceof WP_Post ) {
		return 0;
	}

	$new_id = wp_insert_post(
		[
			'post_type'    => $src->post_type,
			'post_status'  => $src->post_status,
			'post_title'   => $en_title !== '' ? $en_title : $src->post_title,
			'post_name'    => $src->post_name . '-en',
			'post_content' => $src->post_content,
			'post_excerpt' => $src->post_excerpt,
			'post_parent'  => 0,
			'menu_order'   => $src->menu_order,
			'meta_input'   => [],
		],
		true
	);
	if ( is_wp_error( $new_id ) || ! $new_id ) {
		return 0;
	}
	$new_id = (int) $new_id;

	// Copy post meta (skip PLL internals).
	$all_meta = get_post_meta( $source_id );
	if ( is_array( $all_meta ) ) {
		foreach ( $all_meta as $key => $values ) {
			if ( ! is_string( $key ) || str_starts_with( $key, '_pll_' ) || $key === '_edit_lock' || $key === '_edit_last' ) {
				continue;
			}
			foreach ( (array) $values as $val ) {
				add_post_meta( $new_id, $key, maybe_unserialize( $val ) );
			}
		}
	}

	// Featured image.
	$thumb = get_post_thumbnail_id( $source_id );
	if ( $thumb ) {
		set_post_thumbnail( $new_id, (int) $thumb );
	}

	pll_set_post_language( $new_id, 'en' );
	soul_pll_save_post_translations(
		[
			'vi' => $source_id,
			'en' => $new_id,
		]
	);

	return $new_id;
}

/**
 * Duplicate a term as EN translation.
 *
 * @return int New term ID or 0
 */
function soul_pll_duplicate_term_to_en( int $term_id, string $taxonomy, string $en_name = '' ): int {
	if ( $term_id <= 0 || ! function_exists( 'pll_set_term_language' ) ) {
		return 0;
	}
	soul_pll_set_term_lang( $term_id, 'vi' );
	$existing = function_exists( 'pll_get_term' ) ? pll_get_term( $term_id, 'en' ) : 0;
	if ( $existing ) {
		return (int) $existing;
	}
	$term = get_term( $term_id, $taxonomy );
	if ( ! $term instanceof WP_Term ) {
		return 0;
	}
	$name = $en_name !== '' ? $en_name : $term->name;
	$slug = $term->slug . '-en';
	$created = wp_insert_term(
		$name,
		$taxonomy,
		[
			'slug'        => $slug,
			'description' => $term->description,
			'parent'      => 0,
		]
	);
	if ( is_wp_error( $created ) || empty( $created['term_id'] ) ) {
		return 0;
	}
	$new_id = (int) $created['term_id'];
	pll_set_term_language( $new_id, 'en' );
	if ( function_exists( 'pll_save_term_translations' ) ) {
		pll_save_term_translations(
			[
				'vi' => $term_id,
				'en' => $new_id,
			]
		);
	}
	return $new_id;
}
