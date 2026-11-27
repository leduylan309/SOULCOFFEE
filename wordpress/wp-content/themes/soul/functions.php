<?php
/**
 * SOUL Fine Robusta theme bootstrap.
 *
 * @package Soul
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
	exit;
}

define('SOUL_VERSION', '2.3.0');
define('SOUL_DIR', get_template_directory());
define('SOUL_URI', get_template_directory_uri());

require_once SOUL_DIR . '/inc/home-fidelity-checklist.php';
require_once SOUL_DIR . '/inc/setup.php';
require_once SOUL_DIR . '/inc/nav-mega-fields.php';
require_once SOUL_DIR . '/inc/nav-walker.php';
require_once SOUL_DIR . '/inc/i18n.php';
require_once SOUL_DIR . '/inc/polylang.php';
require_once SOUL_DIR . '/inc/seed-polylang.php';
require_once SOUL_DIR . '/inc/enqueue.php';
require_once SOUL_DIR . '/inc/cpt-product.php';
require_once SOUL_DIR . '/inc/product-editor.php';
require_once SOUL_DIR . '/inc/shop.php';
require_once SOUL_DIR . '/inc/order-helpers.php';
require_once SOUL_DIR . '/inc/cpt-order.php';
require_once SOUL_DIR . '/inc/admin-orders.php';
require_once SOUL_DIR . '/inc/cpt-space.php';
require_once SOUL_DIR . '/inc/blog.php';
require_once SOUL_DIR . '/inc/blog-editor.php';
require_once SOUL_DIR . '/inc/meta.php';
require_once SOUL_DIR . '/inc/search.php';
require_once SOUL_DIR . '/inc/seo.php';
require_once SOUL_DIR . '/inc/contact-settings.php';
require_once SOUL_DIR . '/inc/recaptcha.php';
require_once SOUL_DIR . '/inc/checkout-settings.php';
require_once SOUL_DIR . '/inc/settings.php';
require_once SOUL_DIR . '/inc/seed-menus.php';
require_once SOUL_DIR . '/inc/security.php';
require_once SOUL_DIR . '/inc/admin-orders-csv.php';
require_once SOUL_DIR . '/inc/rest-checkout.php';
require_once SOUL_DIR . '/inc/rest-forms.php';
require_once SOUL_DIR . '/inc/rest-order-lookup.php';
require_once SOUL_DIR . '/inc/rest-auth.php';
require_once SOUL_DIR . '/inc/home-assets.php';
require_once SOUL_DIR . '/inc/content-pages.php';
require_once SOUL_DIR . '/inc/patterns.php';
require_once SOUL_DIR . '/inc/block-styles.php';
require_once SOUL_DIR . '/inc/blocks.php';
require_once SOUL_DIR . '/inc/seed.php';
require_once SOUL_DIR . '/inc/seed-phase1.php';
require_once SOUL_DIR . '/inc/seed-phase2.php';
require_once SOUL_DIR . '/inc/seed-phase3.php';
require_once SOUL_DIR . '/inc/seed-phase4.php';
require_once SOUL_DIR . '/inc/seed-phase5.php';
require_once SOUL_DIR . '/inc/seed-home-fidelity.php';
require_once SOUL_DIR . '/inc/seed-newcrop-fidelity.php';
require_once SOUL_DIR . '/inc/seed-story-fidelity.php';
require_once SOUL_DIR . '/inc/seed-solutions-fidelity.php';
require_once SOUL_DIR . '/inc/seed-spaces-fidelity.php';
require_once SOUL_DIR . '/inc/seed-blog-fidelity.php';
require_once SOUL_DIR . '/inc/seed-shop-fidelity.php';
require_once SOUL_DIR . '/inc/seed-account.php';
