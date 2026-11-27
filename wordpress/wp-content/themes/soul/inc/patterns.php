<?php
/**
 * Pattern categories + hide noisy core patterns.
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('init', static function (): void {
	$cats = [
		'soul-pages'   => __('SOUL Pages', 'soul'),
		'soul-layout'  => __('SOUL Layout', 'soul'),
		'soul-cards'   => __('SOUL Cards', 'soul'),
		'soul-blog'    => __('SOUL Blog Article', 'soul'),
		'soul-shop'    => __('SOUL Shop Product', 'soul'),
		'soul-content' => __('SOUL Content', 'soul'),
		'soul-cta'     => __('SOUL CTAs', 'soul'),
		'soul-connect' => __('SOUL Connect', 'soul'),
	];
	foreach ($cats as $slug => $label) {
		register_block_pattern_category($slug, ['label' => $label]);
	}
});

add_action('init', static function (): void {
	remove_theme_support('core-block-patterns');
}, 9);
