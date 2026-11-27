<?php
/**
 * Seed Account page (SoT html/Account.dc.html).
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('init', static function (): void {
	if (get_option('soul_seeded_account_v1')) {
		return;
	}
	soul_seed_account_page();
	update_option('soul_seeded_account_v1', 1);
}, 40);

/**
 * Ensure /account/ exists with Account template.
 */
function soul_seed_account_page(): void {
	$account_id = (int) get_option('soul_account_page_id');
	if ($account_id && get_post($account_id)) {
		update_post_meta($account_id, '_wp_page_template', 'templates/account.php');
		return;
	}

	$existing = get_page_by_path('account');
	if ($existing) {
		$account_id = (int) $existing->ID;
		update_post_meta($account_id, '_wp_page_template', 'templates/account.php');
		update_option('soul_account_page_id', $account_id);
		return;
	}

	$account_id = wp_insert_post([
		'post_type'     => 'page',
		'post_status'   => 'publish',
		'post_title'    => 'Account',
		'post_name'     => 'account',
		'post_content'  => '',
		'page_template' => 'templates/account.php',
	]);
	if ($account_id && ! is_wp_error($account_id)) {
		update_post_meta($account_id, '_wp_page_template', 'templates/account.php');
		update_option('soul_account_page_id', $account_id);
	}
}
