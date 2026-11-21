<?php
/**
 * Café spaces CPT.
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('init', static function (): void {
	register_post_type('soul_space', [
		'labels' => [
			'name'          => __('Spaces', 'soul'),
			'singular_name' => __('Space', 'soul'),
		],
		'public'       => true,
		'has_archive'  => true,
		'rewrite'      => ['slug' => 'spaces', 'with_front' => false],
		'menu_icon'    => 'dashicons-store',
		'show_in_rest' => true,
		'supports'     => ['title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'],
	]);
});

/**
 * Hub archive: SoT order (menu_order) then title.
 */
add_action('pre_get_posts', static function (\WP_Query $q): void {
	if (is_admin() || ! $q->is_main_query()) {
		return;
	}
	if ($q->is_post_type_archive('soul_space')) {
		$q->set('orderby', ['menu_order' => 'ASC', 'title' => 'ASC']);
		$q->set('posts_per_page', 20);
	}
});

/**
 * @return array{city:string,region:string,address:string,hours:string,hotline:string,map_q:string,menu_url:string,gallery:string}
 */
function soul_get_space_meta(int $post_id): array {
	return [
		'city'     => (string) get_post_meta($post_id, 'soul_city', true),
		'region'   => (string) get_post_meta($post_id, 'soul_region', true),
		'address'  => (string) get_post_meta($post_id, 'soul_address', true),
		'hours'    => (string) get_post_meta($post_id, 'soul_hours', true),
		'hotline'  => (string) get_post_meta($post_id, 'soul_hotline', true),
		'map_q'    => (string) get_post_meta($post_id, 'soul_map_q', true),
		'menu_url' => (string) get_post_meta($post_id, 'soul_menu_url', true),
		'gallery'  => (string) get_post_meta($post_id, 'soul_gallery', true),
	];
}

/**
 * @return list<string>
 */
function soul_get_space_gallery_urls(int $post_id): array {
	$raw = (string) get_post_meta($post_id, 'soul_gallery', true);
	if ($raw === '') {
		return [];
	}
	$lines = preg_split('/\r\n|\r|\n/', $raw) ?: [];
	$out   = [];
	foreach ($lines as $line) {
		$url = trim($line);
		if ($url !== '' && filter_var($url, FILTER_VALIDATE_URL)) {
			$out[] = $url;
		}
	}
	return $out;
}

function soul_space_map_url(string $map_q): string {
	if ($map_q === '') {
		return '';
	}
	return 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($map_q);
}

add_action('add_meta_boxes', static function (): void {
	add_meta_box('soul_space_meta', __('Space info', 'soul'), static function (\WP_Post $post): void {
		wp_nonce_field('soul_space_meta', 'soul_space_meta_nonce');
		$m = soul_get_space_meta((int) $post->ID);
		foreach ([
			'soul_city'     => ['City (chip label)', $m['city']],
			'soul_region'   => ['Region', $m['region']],
			'soul_address'  => ['Address', $m['address']],
			'soul_hotline'  => ['Hotline', $m['hotline']],
			'soul_map_q'    => ['Map query', $m['map_q']],
			'soul_menu_url' => ['Menu URL', $m['menu_url']],
		] as $key => [$label, $val]) {
			printf(
				'<p><label>%s<br><input type="text" class="widefat" name="%s" value="%s"></label></p>',
				esc_html($label),
				esc_attr($key),
				esc_attr($val)
			);
		}
		printf(
			'<p><label>%s<br><textarea class="widefat" rows="3" name="soul_hours">%s</textarea></label></p>',
			esc_html__('Hours', 'soul'),
			esc_textarea($m['hours'])
		);
		printf(
			'<p><label>%s<br><textarea class="widefat" rows="6" name="soul_gallery">%s</textarea></label></p>',
			esc_html__('Gallery image URLs (one per line)', 'soul'),
			esc_textarea($m['gallery'])
		);
	}, 'soul_space', 'side');
});

add_action('save_post_soul_space', static function (int $post_id): void {
	if (! isset($_POST['soul_space_meta_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['soul_space_meta_nonce'])), 'soul_space_meta')) {
		return;
	}
	if (! current_user_can('edit_post', $post_id)) {
		return;
	}
	foreach (['soul_city', 'soul_region', 'soul_address', 'soul_hotline', 'soul_map_q', 'soul_menu_url'] as $key) {
		update_post_meta($post_id, $key, sanitize_text_field(wp_unslash($_POST[$key] ?? '')));
	}
	update_post_meta($post_id, 'soul_hours', sanitize_textarea_field(wp_unslash($_POST['soul_hours'] ?? '')));
	$gallery = isset($_POST['soul_gallery']) ? sanitize_textarea_field(wp_unslash($_POST['soul_gallery'])) : '';
	update_post_meta($post_id, 'soul_gallery', $gallery);
});
