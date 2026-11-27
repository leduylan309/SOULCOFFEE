<?php
/**
 * SOUL Settings — top-level admin hub (Contact / Commerce / Security).
 *
 * @package Soul
 */

declare(strict_types=1);

/** Parent slug for SOUL Settings. */
function soul_settings_parent_slug(): string {
	return 'soul-settings';
}

/**
 * Tab nav HTML for SOUL Settings subpages.
 *
 * @param string $current Current page slug (soul-settings | soul-settings-commerce | soul-settings-security).
 */
function soul_settings_tabs(string $current): void {
	$tabs = [
		'soul-settings'          => __('Contact', 'soul'),
		'soul-settings-commerce' => __('Commerce', 'soul'),
		'soul-settings-security' => __('Security', 'soul'),
	];
	echo '<h2 class="nav-tab-wrapper" style="margin-bottom:16px;">';
	foreach ($tabs as $slug => $label) {
		$url   = admin_url('admin.php?page=' . $slug);
		$class = 'nav-tab' . ($slug === $current ? ' nav-tab-active' : '');
		printf(
			'<a href="%s" class="%s">%s</a>',
			esc_url($url),
			esc_attr($class),
			esc_html($label)
		);
	}
	echo '</h2>';
}

add_action('admin_menu', static function (): void {
	add_menu_page(
		__('SOUL Settings', 'soul'),
		__('SOUL Settings', 'soul'),
		'manage_options',
		'soul-settings',
		'soul_contact_render_settings_page',
		'dashicons-coffee',
		58
	);

	add_submenu_page(
		'soul-settings',
		__('Contact', 'soul'),
		__('Contact', 'soul'),
		'manage_options',
		'soul-settings',
		'soul_contact_render_settings_page'
	);

	add_submenu_page(
		'soul-settings',
		__('Commerce', 'soul'),
		__('Commerce', 'soul'),
		'manage_options',
		'soul-settings-commerce',
		'soul_checkout_render_settings_page'
	);

	add_submenu_page(
		'soul-settings',
		__('Security', 'soul'),
		__('Security', 'soul'),
		'manage_options',
		'soul-settings-security',
		'soul_recaptcha_render_settings_page'
	);
}, 5);

/** Redirect legacy Settings → SOUL * pages into the hub. */
add_action('admin_init', static function (): void {
	if (! is_admin() || ! isset($_GET['page'])) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return;
	}
	$page = sanitize_key((string) wp_unslash($_GET['page'])); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$map  = [
		'soul-checkout'  => 'soul-settings-commerce',
		'soul-recaptcha' => 'soul-settings-security',
	];
	if (isset($map[ $page ])) {
		wp_safe_redirect(admin_url('admin.php?page=' . $map[ $page ]));
		exit;
	}
});
