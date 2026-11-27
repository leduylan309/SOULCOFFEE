<?php
/**
 * Product CPT editor — story body canvas matches front .s-shop-story.
 *
 * @package Soul
 */

declare(strict_types=1);

/** Restrict product story patterns to soul_product; keep page patterns off products. */
add_action('init', static function (): void {
	if (! class_exists('WP_Block_Patterns_Registry')) {
		return;
	}
	$registry = WP_Block_Patterns_Registry::get_instance();
	foreach ($registry->get_all_registered() as $pattern) {
		$name = (string) ($pattern['name'] ?? '');
		if ($name === '' || ! str_starts_with($name, 'soul/product-')) {
			continue;
		}
		$types = $pattern['postTypes'] ?? [];
		if (is_array($types) && in_array('soul_product', $types, true)) {
			continue;
		}
		unregister_block_pattern($name);
		$pattern['postTypes'] = ['soul_product'];
		unset($pattern['name']);
		register_block_pattern($name, $pattern);
	}
}, 31);

add_action('enqueue_block_editor_assets', static function (): void {
	$screen = function_exists('get_current_screen') ? get_current_screen() : null;
	if (! $screen || $screen->post_type !== 'soul_product') {
		return;
	}
	wp_enqueue_script(
		'soul-product-editor',
		SOUL_URI . '/assets/js/product-editor.js',
		['wp-dom-ready', 'wp-data', 'wp-edit-post'],
		SOUL_VERSION,
		true
	);
});
