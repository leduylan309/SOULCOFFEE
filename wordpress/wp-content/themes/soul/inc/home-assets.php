<?php
/**
 * Home fidelity asset helpers.
 *
 * @package Soul
 */

declare(strict_types=1);

function soul_img(string $rel): string {
	return esc_url(SOUL_URI . '/assets/images/' . ltrim($rel, '/'));
}

function soul_home_shop_url(): string {
	return esc_url(get_post_type_archive_link('soul_product') ?: home_url('/products/'));
}

function soul_home_term_url(string $slug): string {
	$t = get_term_by('slug', $slug, 'soul_collection');
	if ($t && ! is_wp_error(get_term_link($t))) {
		return esc_url(get_term_link($t));
	}
	return soul_home_shop_url();
}
