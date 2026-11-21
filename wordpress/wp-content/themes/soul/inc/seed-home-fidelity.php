<?php
/**
 * Force-update front page to editable core-block Home patterns.
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('init', 'soul_run_seed_home_fidelity', 75);

function soul_run_seed_home_fidelity(): void {
	if (get_option('soul_seeded_home_editable_v7')) {
		return;
	}
	if (! function_exists('soul_home_full_content')) {
		return;
	}

	$id = (int) get_option('page_on_front');
	if (! $id) {
		$page = get_page_by_path('home');
		$id = $page ? (int) $page->ID : 0;
	}
	if (! $id) {
		return;
	}

	$content = soul_home_full_content();
	kses_remove_filters();
	wp_update_post([
		'ID'           => $id,
		'post_content' => $content,
		'post_status'  => 'publish',
	]);
	kses_init_filters();

	update_option('soul_seeded_home_editable_v7', 1);
}
