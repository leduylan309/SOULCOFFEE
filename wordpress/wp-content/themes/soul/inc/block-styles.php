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
		['core/image', 'blog-figure', __('Blog figure', 'soul')],
		['core/quote', 'blog-quote', __('Blog quote', 'soul')],
		['core/group', 'blog-tip', __('Blog tip', 'soul')],
		['core/group', 'blog-cta', __('Blog product CTA', 'soul')],
		['core/group', 'blog-award', __('Blog award', 'soul')],
		['core/paragraph', 'blog-lead', __('Blog lead', 'soul')],
		['core/paragraph', 'blog-tasting', __('Blog tasting notes', 'soul')],
		['core/columns', 'blog-gallery', __('Blog gallery 2-up', 'soul')],
		['core/separator', 'blog-divider', __('Blog divider', 'soul')],
		/* Shop product story (PDP §02) — front + editor via .s-shop-story__* */
		['core/paragraph', 'shop-lead', __('Shop lead', 'soul')],
		['core/paragraph', 'shop-tasting', __('Shop tasting notes', 'soul')],
		['core/image', 'shop-figure', __('Shop figure', 'soul')],
		['core/columns', 'shop-split', __('Shop split media', 'soul')],
		['core/columns', 'shop-gallery', __('Shop gallery', 'soul')],
		['core/gallery', 'shop-slides', __('Shop slideshow', 'soul')],
		['core/quote', 'shop-quote', __('Shop quote', 'soul')],
		['core/group', 'shop-note', __('Shop note', 'soul')],
		['core/group', 'shop-facts', __('Shop facts', 'soul')],
		['core/group', 'shop-cta', __('Shop brew CTA', 'soul')],
		['core/list', 'shop-list', __('Shop dash list', 'soul')],
		['core/separator', 'shop-divider', __('Shop divider', 'soul')],
		['core/embed', 'shop-video', __('Shop video', 'soul')],
	];

	foreach ($styles as [$block, $name, $label]) {
		register_block_style($block, [
			'name'  => $name,
			'label' => $label,
		]);
	}
});
