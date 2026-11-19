<?php
/**
 * Include products + spaces in front search.
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('pre_get_posts', static function (\WP_Query $q): void {
	if (is_admin() || ! $q->is_main_query() || ! $q->is_search()) {
		return;
	}
	$q->set('post_type', ['post', 'page', 'soul_product', 'soul_space']);
});
