<?php
/**
 * Phase 5 fidelity: reseed Home + marketing pages from section patterns.
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('init', 'soul_run_seed_phase5', 70);

function soul_run_seed_phase5(): void {
	if (get_option('soul_seeded_phase5_v2')) {
		return;
	}
	if (! function_exists('soul_home_full_content')) {
		return;
	}

	$pages = [
		['', 'soul_home_full_content', (int) get_option('page_on_front')],
		['our-story', 'soul_page_our_story_content', 0],
		['coffee-solutions', 'soul_page_coffee_solutions_content', 0],
		['help', 'soul_page_help_content', 0],
		['new-crop', 'soul_page_new_crop_content', 0],
	];

	foreach ($pages as [$path, $fn, $known_id]) {
		if (! function_exists($fn)) {
			continue;
		}
		$content = $fn();
		$id = $known_id;
		if (! $id && $path !== '') {
			$page = get_page_by_path($path);
			$id = $page ? (int) $page->ID : 0;
		}
		if ($id) {
			wp_update_post([
				'ID'           => $id,
				'post_content' => $content,
				'post_status'  => 'publish',
			]);
		} elseif ($path !== '') {
			wp_insert_post([
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => ucwords(str_replace('-', ' ', $path)),
				'post_name'    => $path,
				'post_content' => $content,
			]);
		}
	}

	update_option('soul_seeded_phase5_v2', 1);
}
