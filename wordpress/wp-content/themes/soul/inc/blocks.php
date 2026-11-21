<?php
/**
 * Custom blocks: Add to cart + Lead form (admin-editable; no Custom HTML).
 *
 * @package Soul
 */

declare(strict_types=1);

add_filter('block_categories_all', static function (array $cats): array {
	$cats[] = [
		'slug'  => 'soul',
		'title' => __('SOUL', 'soul'),
	];
	return $cats;
});

add_action('init', static function (): void {
	$blocks = ['add-to-cart', 'lead-form'];
	foreach ($blocks as $dir) {
		$path = SOUL_DIR . '/blocks/' . $dir;
		if (is_readable($path . '/block.json')) {
			register_block_type($path);
		}
	}
});

/**
 * Attach DS data-* hooks to editable Group wrappers (lightbox / rail).
 *
 * @param string               $content
 * @param array<string, mixed> $block
 */
add_filter('render_block', static function (string $content, array $block): string {
	if (($block['blockName'] ?? '') !== 'core/group' || $content === '') {
		return $content;
	}
	$class = (string) ($block['attrs']['className'] ?? '');
	$attrs = '';
	if (str_contains($class, 's-home-album') || str_contains($class, 's-space-br-gallery') || str_contains($class, 'js-soul-lightbox')) {
		if (str_contains($class, 's-home-album')) {
			$label = 'Album · Vùng nguyên liệu';
		} elseif (str_contains($class, 's-space-br-gallery')) {
			$label = get_the_title() ?: 'Inside Soul';
		} else {
			$label = 'Gallery';
		}
		$attrs .= ' data-component="lightbox" data-label="' . esc_attr($label) . '"';
	}
	if (str_contains($class, 'js-soul-rail') || str_contains($class, 's-home-awards__rail-wrap')) {
		$attrs .= ' data-component="rail" data-step="0.8"';
	}
	if (str_contains($class, 'js-flavour-tabs') || str_contains($class, 's-newcrop-col')) {
		// Only mount once on the root collection group (has js-flavour-tabs).
		if (str_contains($class, 'js-flavour-tabs')) {
			$attrs .= ' data-component="flavour-tabs"';
		}
	}
	if ($attrs === '') {
		return $content;
	}
	// Layout support may prefix whitespace/newlines before the wrapper.
	return (string) preg_replace('/^(\s*)<div\b/i', '$1<div' . $attrs, $content, 1);
}, 20, 2);
