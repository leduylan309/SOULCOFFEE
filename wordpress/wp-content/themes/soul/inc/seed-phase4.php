<?php
/**
 * Phase 4: New Crop landing + ensure order-lookup template.
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('init', 'soul_run_seed_phase4', 60);

function soul_run_seed_phase4(): void {
	if (get_option('soul_seeded_phase4')) {
		return;
	}

	$soulful = get_term_by('slug', 'soulful-flavours', 'soul_collection');
	$soulful_url = esc_url($soulful ? get_term_link($soulful) : (get_post_type_archive_link('soul_product') ?: home_url('/products/')));
	if (is_wp_error($soulful_url)) {
		$soulful_url = esc_url(home_url('/products/'));
	}

	$content = <<<HTML
<!-- wp:group {"align":"full","className":"is-style-surface-ink","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-ink"><!-- wp:paragraph {"className":"soul-eyebrow"} -->
<p class="soul-eyebrow">New crop 2026</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1,"fontSize":"hero"} -->
<h1 class="wp-block-heading has-hero-font-size">Mùa vụ mới · Soulful Collection</h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"is-style-lead"} -->
<p class="is-style-lead">Cay · Nồng · Thơm · Ngọt — bốn tính cách hương vị từ nghiên cứu sơ chế và lên men bản địa tại Tây Nguyên.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-yellow"} -->
<div class="wp-block-button is-style-yellow"><a class="wp-block-button__link wp-element-button" href="{$soulful_url}">Khám phá Soulful ↗</a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/products/">Tất cả sản phẩm</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"is-style-surface-sand","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-sand"><!-- wp:heading -->
<h2 class="wp-block-heading">Đi sâu vào một vùng đất</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Mỗi lô Soulful gắn với khác biệt về vùng nguyên liệu, cách sơ chế và hướng phát triển hương vị — không phải biến thể marketing.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
HTML;

	$page = get_page_by_path('new-crop');
	if ($page) {
		wp_update_post(['ID' => $page->ID, 'post_content' => $content, 'post_status' => 'publish']);
	} else {
		wp_insert_post([
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => 'New Crop',
			'post_name'    => 'new-crop',
			'post_content' => $content,
		]);
	}

	update_option('soul_seeded_phase4', 1);
}
