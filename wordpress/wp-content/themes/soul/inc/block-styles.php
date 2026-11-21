<?php
/**
 * Core block styles.
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('init', static function (): void {
	$styles = [
		['core/button', 'primary', __('Primary ink', 'soul')],
		['core/button', 'outline', __('Outline', 'soul')],
		['core/button', 'outline-dark', __('Outline on ink', 'soul')],
		['core/button', 'yellow', __('Yellow fill', 'soul')],
		['core/button', 'rail-nav', __('Rail nav', 'soul')],
		['core/group', 'home-section', __('Home section shell', 'soul')],
		['core/group', 'surface-paper', __('Surface paper', 'soul')],
		['core/group', 'surface-sand', __('Surface sand', 'soul')],
		['core/group', 'surface-ink', __('Surface ink', 'soul')],
		['core/group', 'surface-yellow', __('Surface yellow', 'soul')],
		['core/columns', 'section-header', __('Section header', 'soul')],
		['core/columns', 'tight-10', __('Tight 10px gutter', 'soul')],
		['core/details', 'faq', __('FAQ', 'soul')],
		['core/paragraph', 'lead', __('Lead', 'soul')],
		['core/paragraph', 'tasting-notes', __('Tasting notes', 'soul')],
		['core/paragraph', 'meta-chain', __('Meta chain', 'soul')],
		['core/image', 'ratio-1-1', __('Ratio 1:1', 'soul')],
		['core/image', 'ratio-4-5', __('Ratio 4:5', 'soul')],
		['core/image', 'ratio-16-10', __('Ratio 16:10', 'soul')],
		['core/group', 'blog-note', __('Blog note', 'soul')],
		['core/group', 'blog-facts', __('Blog lot facts', 'soul')],
		['core/group', 'blog-apply', __('Blog apply CTA', 'soul')],
		['core/list', 'blog-list', __('Blog dash list', 'soul')],
		['core/list', 'blog-steps', __('Blog steps grid', 'soul')],
	];

	foreach ($styles as [$block, $name, $label]) {
		register_block_style($block, [
			'name'  => $name,
			'label' => $label,
		]);
	}
});
