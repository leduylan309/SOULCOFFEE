<?php
/**
 * Reseed /coffee-solutions/ to editable SoT patterns (Coffee Solutions.dc.html).
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('init', 'soul_run_seed_solutions_fidelity', 78);

function soul_run_seed_solutions_fidelity(): void {
	if (get_option('soul_seeded_solutions_editable_v1')) {
		return;
	}
	if (! function_exists('soul_page_coffee_solutions_content')) {
		return;
	}

	$page = get_page_by_path('coffee-solutions');
	if (! $page) {
		return;
	}

	$content = soul_page_coffee_solutions_content();
	kses_remove_filters();
	wp_update_post([
		'ID'           => (int) $page->ID,
		'post_content' => $content,
		'post_status'  => 'publish',
		'post_title'   => 'Giải pháp cà phê',
	]);
	kses_init_filters();

	update_option('soul_seeded_solutions_editable_v1', 1);
}
