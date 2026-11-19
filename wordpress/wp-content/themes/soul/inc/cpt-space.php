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
		'supports'     => ['title', 'editor', 'thumbnail', 'excerpt'],
	]);
});

/**
 * @return array{region:string,address:string,hours:string,hotline:string,map_q:string}
 */
function soul_get_space_meta(int $post_id): array {
	return [
		'region'  => (string) get_post_meta($post_id, 'soul_region', true),
		'address' => (string) get_post_meta($post_id, 'soul_address', true),
		'hours'   => (string) get_post_meta($post_id, 'soul_hours', true),
		'hotline' => (string) get_post_meta($post_id, 'soul_hotline', true),
		'map_q'   => (string) get_post_meta($post_id, 'soul_map_q', true),
	];
}

add_action('add_meta_boxes', static function (): void {
	add_meta_box('soul_space_meta', __('Space info', 'soul'), static function (\WP_Post $post): void {
		wp_nonce_field('soul_space_meta', 'soul_space_meta_nonce');
		$m = soul_get_space_meta((int) $post->ID);
		foreach ([
			'soul_region'  => ['Region', $m['region']],
			'soul_address' => ['Address', $m['address']],
			'soul_hours'   => ['Hours', $m['hours']],
			'soul_hotline' => ['Hotline', $m['hotline']],
			'soul_map_q'   => ['Map query', $m['map_q']],
		] as $key => [$label, $val]) {
			printf(
				'<p><label>%s<br><input type="text" class="widefat" name="%s" value="%s"></label></p>',
				esc_html($label),
				esc_attr($key),
				esc_attr($val)
			);
		}
	}, 'soul_space', 'side');
});

add_action('save_post_soul_space', static function (int $post_id): void {
	if (! isset($_POST['soul_space_meta_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['soul_space_meta_nonce'])), 'soul_space_meta')) {
		return;
	}
	if (! current_user_can('edit_post', $post_id)) {
		return;
	}
	foreach (['soul_region', 'soul_address', 'soul_hours', 'soul_hotline', 'soul_map_q'] as $key) {
		update_post_meta($post_id, $key, sanitize_text_field(wp_unslash($_POST[$key] ?? '')));
	}
});
