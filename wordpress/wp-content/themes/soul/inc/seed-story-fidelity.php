<?php
/**
 * Reseed /our-story/ to editable SoT patterns (Our Story.dc.html).
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('init', 'soul_run_seed_story_fidelity', 77);

function soul_run_seed_story_fidelity(): void {
	if (get_option('soul_seeded_story_editable_v1')) {
		return;
	}
	if (! function_exists('soul_page_our_story_content')) {
		return;
	}

	$page = get_page_by_path('our-story');
	if (! $page) {
		return;
	}

	$content = soul_page_our_story_content();
	kses_remove_filters();
	wp_update_post([
		'ID'           => (int) $page->ID,
		'post_content' => $content,
		'post_status'  => 'publish',
		'post_title'   => 'Về Soul',
	]);
	kses_init_filters();

	update_option('soul_seeded_story_editable_v1', 1);
}
