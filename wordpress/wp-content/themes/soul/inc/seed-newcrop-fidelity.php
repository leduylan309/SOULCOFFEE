<?php
/**
 * Reseed /new-crop/ to editable SoT patterns (New Crop.dc.html).
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('init', 'soul_run_seed_newcrop_fidelity', 76);

function soul_run_seed_newcrop_fidelity(): void {
	if (get_option('soul_seeded_newcrop_editable_v2')) {
		return;
	}
	if (! function_exists('soul_page_new_crop_content')) {
		return;
	}

	$page = get_page_by_path('new-crop');
	if (! $page) {
		return;
	}

	$content = soul_page_new_crop_content();
	kses_remove_filters();
	wp_update_post([
		'ID'           => (int) $page->ID,
		'post_content' => $content,
		'post_status'  => 'publish',
		'post_title'   => 'Mùa vụ mới',
	]);
	kses_init_filters();

	update_option('soul_seeded_newcrop_editable_v2', 1);
}
