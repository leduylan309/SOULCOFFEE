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

define('SOUL_VERSION', '2.0.11');
define('SOUL_DIR', get_template_directory());
define('SOUL_URI', get_template_directory_uri());

require_once SOUL_DIR . '/inc/home-fidelity-checklist.php';
require_once SOUL_DIR . '/inc/setup.php';
require_once SOUL_DIR . '/inc/i18n.php';
require_once SOUL_DIR . '/inc/enqueue.php';
require_once SOUL_DIR . '/inc/cpt-product.php';
require_once SOUL_DIR . '/inc/cpt-order.php';
require_once SOUL_DIR . '/inc/cpt-space.php';
require_once SOUL_DIR . '/inc/meta.php';
require_once SOUL_DIR . '/inc/search.php';
require_once SOUL_DIR . '/inc/seo.php';
require_once SOUL_DIR . '/inc/security.php';
require_once SOUL_DIR . '/inc/admin-orders-csv.php';
require_once SOUL_DIR . '/inc/rest-checkout.php';
require_once SOUL_DIR . '/inc/rest-forms.php';
require_once SOUL_DIR . '/inc/rest-order-lookup.php';
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
