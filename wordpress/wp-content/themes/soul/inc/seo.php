<?php
/**
 * Lightweight SEO: meta description + include CPTs in core sitemaps.
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('wp_head', static function (): void {
	if (is_singular()) {
		$desc = (string) get_post_meta(get_the_ID(), 'soul_seo_description', true);
		if ($desc === '') {
			$desc = has_excerpt() ? get_the_excerpt() : wp_trim_words(wp_strip_all_tags(get_post_field('post_content', get_the_ID())), 28);
		}
		if ($desc !== '') {
			printf('<meta name="description" content="%s">' . "\n", esc_attr(wp_strip_all_tags($desc)));
		}
		return;
	}
	if (is_front_page()) {
		printf(
			'<meta name="description" content="%s">' . "\n",
			esc_attr__('SOUL Fine Robusta — specialty coffee from Buôn Ma Thuột, Việt Nam.', 'soul')
		);
	}
}, 1);

add_action('add_meta_boxes', static function (): void {
	foreach (['post', 'page', 'soul_product', 'soul_space'] as $type) {
		add_meta_box('soul_seo', __('SEO', 'soul'), static function (\WP_Post $post): void {
			wp_nonce_field('soul_seo_meta', 'soul_seo_meta_nonce');
			$desc = (string) get_post_meta($post->ID, 'soul_seo_description', true);
			printf(
				'<p><label>%s<br><textarea class="widefat" rows="3" name="soul_seo_description">%s</textarea></label></p>',
				esc_html__('Meta description', 'soul'),
				esc_textarea($desc)
			);
		}, $type, 'normal', 'default');
	}
});

add_action('save_post', static function (int $post_id): void {
	if (! isset($_POST['soul_seo_meta_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['soul_seo_meta_nonce'])), 'soul_seo_meta')) {
		return;
	}
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}
	if (! current_user_can('edit_post', $post_id)) {
		return;
	}
	update_post_meta($post_id, 'soul_seo_description', sanitize_textarea_field(wp_unslash($_POST['soul_seo_description'] ?? '')));
});

/** Core XML sitemaps: add product + space. */
add_filter('wp_sitemaps_post_types', static function (array $types): array {
	$types['soul_product'] = get_post_type_object('soul_product');
	$types['soul_space']   = get_post_type_object('soul_space');
	return array_filter($types);
});

add_filter('document_title_parts', static function (array $parts): array {
	if (is_singular('soul_product')) {
		$parts['title'] = get_the_title() . ' · SOUL';
	}
	return $parts;
});
