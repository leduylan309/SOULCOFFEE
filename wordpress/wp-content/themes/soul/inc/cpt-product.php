<?php
/**
 * Product CPT + collection taxonomy.
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('init', static function (): void {
	register_post_type('soul_product', [
		'labels' => [
			'name'          => __('Products', 'soul'),
			'singular_name' => __('Product', 'soul'),
			'add_new_item'  => __('Add Product', 'soul'),
			'edit_item'     => __('Edit Product', 'soul'),
		],
		'public'            => true,
		'has_archive'       => true,
		'show_in_nav_menus' => true,
		'rewrite'           => ['slug' => 'products', 'with_front' => false],
		'menu_icon'         => 'dashicons-carrot',
		'show_in_rest'      => true,
		'supports'     => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
		/** Editor = cột phải mô tả only (cột trái «Về sản phẩm» nằm PHP front). */
		'template'      => [
			[
				'core/paragraph',
				[
					'placeholder' => __('Chèn pattern Shop (Lead, Ảnh, Split, Slideshow…) — chỉ cột phải PDP.', 'soul'),
					'className'   => 's-shop-story__p',
				],
			],
		],
		'template_lock' => false,
	]);

	register_taxonomy('soul_collection', 'soul_product', [
		'labels' => [
			'name'          => __('Collections', 'soul'),
			'singular_name' => __('Collection', 'soul'),
		],
		'public'            => true,
		'hierarchical'      => true,
		'show_in_nav_menus' => true,
		'rewrite'           => ['slug' => 'collections', 'with_front' => false],
		'show_in_rest'      => true,
		'show_admin_column' => true,
	]);
});

/**
 * @return array{
 *   price:int,sku:string,in_stock:bool,quote_only:bool,notes:string,
 *   meta_chain:string,badge:string,
 *   variants:array<int,array{id:string,label:string,values:array<int,array{0:string,1:string,2:float}>}>
 * }
 */
function soul_get_product_meta(int $post_id): array {
	$variants_raw = (string) get_post_meta($post_id, 'soul_variants', true);
	$variants     = json_decode($variants_raw, true);
	if (! is_array($variants) || $variants === []) {
		$variants = [
			[
				'id'     => 'w',
				'label'  => 'Trọng lượng',
				'values' => [
					['200', '200 g', 1],
					['500', '500 g', 2.3],
				],
			],
			[
				'id'     => 'g',
				'label'  => 'Phân loại',
				'values' => [
					['whole', 'Nguyên hạt', 1],
					['ground', 'Xay sẵn', 1],
				],
			],
		];
	}

	return [
		'price'      => (int) get_post_meta($post_id, 'soul_price', true),
		'sku'        => (string) get_post_meta($post_id, 'soul_sku', true),
		'in_stock'   => get_post_meta($post_id, 'soul_in_stock', true) !== '0',
		'quote_only' => get_post_meta($post_id, 'soul_quote_only', true) === '1',
		'notes'      => (string) get_post_meta($post_id, 'soul_notes', true),
		'meta_chain' => (string) get_post_meta($post_id, 'soul_meta_chain', true),
		'badge'      => (string) get_post_meta($post_id, 'soul_badge', true),
		'variants'   => $variants,
	];
}

add_action('add_meta_boxes', static function (): void {
	add_meta_box('soul_product_commerce', __('Commerce', 'soul'), 'soul_render_product_metabox', 'soul_product', 'side', 'high');
});

function soul_render_product_metabox(\WP_Post $post): void {
	wp_nonce_field('soul_product_meta', 'soul_product_meta_nonce');
	$m = soul_get_product_meta((int) $post->ID);
	?>
	<p><label><?php esc_html_e('Price (VND)', 'soul'); ?><br>
		<input type="number" name="soul_price" value="<?php echo esc_attr((string) $m['price']); ?>" class="widefat" min="0" step="1000"></label></p>
	<p><label><?php esc_html_e('SKU / handle', 'soul'); ?><br>
		<input type="text" name="soul_sku" value="<?php echo esc_attr($m['sku']); ?>" class="widefat"></label></p>
	<p><label><?php esc_html_e('Badge', 'soul'); ?><br>
		<input type="text" name="soul_badge" value="<?php echo esc_attr($m['badge']); ?>" class="widefat"></label></p>
	<p><label><?php esc_html_e('Tasting notes', 'soul'); ?><br>
		<input type="text" name="soul_notes" value="<?php echo esc_attr($m['notes']); ?>" class="widefat"></label></p>
	<p><label><?php esc_html_e('Meta chain', 'soul'); ?><br>
		<input type="text" name="soul_meta_chain" value="<?php echo esc_attr($m['meta_chain']); ?>" class="widefat"></label></p>
	<p><label><input type="checkbox" name="soul_in_stock" value="1" <?php checked($m['in_stock']); ?>> <?php esc_html_e('In stock', 'soul'); ?></label></p>
	<p><label><input type="checkbox" name="soul_quote_only" value="1" <?php checked($m['quote_only']); ?>> <?php esc_html_e('Quote only (green / wholesale)', 'soul'); ?></label></p>
	<p><label><?php esc_html_e('Variants JSON', 'soul'); ?><br>
		<textarea name="soul_variants" rows="8" class="widefat code"><?php echo esc_textarea(wp_json_encode($m['variants'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)); ?></textarea></label></p>
	<?php
}

add_action('save_post_soul_product', static function (int $post_id): void {
	if (! isset($_POST['soul_product_meta_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['soul_product_meta_nonce'])), 'soul_product_meta')) {
		return;
	}
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}
	if (! current_user_can('edit_post', $post_id)) {
		return;
	}

	update_post_meta($post_id, 'soul_price', (int) ($_POST['soul_price'] ?? 0));
	update_post_meta($post_id, 'soul_sku', sanitize_text_field(wp_unslash($_POST['soul_sku'] ?? '')));
	update_post_meta($post_id, 'soul_badge', sanitize_text_field(wp_unslash($_POST['soul_badge'] ?? '')));
	update_post_meta($post_id, 'soul_notes', sanitize_text_field(wp_unslash($_POST['soul_notes'] ?? '')));
	update_post_meta($post_id, 'soul_meta_chain', sanitize_text_field(wp_unslash($_POST['soul_meta_chain'] ?? '')));
	update_post_meta($post_id, 'soul_in_stock', isset($_POST['soul_in_stock']) ? '1' : '0');
	update_post_meta($post_id, 'soul_quote_only', isset($_POST['soul_quote_only']) ? '1' : '0');

	$variants = wp_unslash($_POST['soul_variants'] ?? '');
	if (is_string($variants) && $variants !== '') {
		$decoded = json_decode($variants, true);
		if (is_array($decoded)) {
			update_post_meta($post_id, 'soul_variants', wp_json_encode($decoded, JSON_UNESCAPED_UNICODE));
		}
	}
});

/** Archive filters: in_stock + sort. */
add_action('pre_get_posts', static function (\WP_Query $q): void {
	if (is_admin() || ! $q->is_main_query()) {
		return;
	}
	if (! $q->is_post_type_archive('soul_product') && ! $q->is_tax('soul_collection')) {
		return;
	}

	if (isset($_GET['in_stock']) && $_GET['in_stock'] === '1') {
		$q->set('meta_query', [
			[
				'key'     => 'soul_in_stock',
				'value'   => '0',
				'compare' => '!=',
			],
		]);
	}

	$sort = isset($_GET['sort']) ? sanitize_key((string) $_GET['sort']) : 'feat';
	switch ($sort) {
		case 'new':
			// SoT: san-pham-moi first — handled in posts_clauses.
			$q->set('soul_shop_sort', 'new');
			$q->set('orderby', 'date');
			$q->set('order', 'DESC');
			break;
		case 'asc':
			$q->set('meta_key', 'soul_price');
			$q->set('orderby', 'meta_value_num');
			$q->set('order', 'ASC');
			break;
		case 'desc':
			$q->set('meta_key', 'soul_price');
			$q->set('orderby', 'meta_value_num');
			$q->set('order', 'DESC');
			break;
		default:
			// SoT: san-pham-noi-bat first — handled in posts_clauses.
			$q->set('soul_shop_sort', 'feat');
			$q->set('orderby', 'menu_order title');
			$q->set('order', 'ASC');
	}
});

/** SoT feat/new: prioritize collection membership. */
add_filter('posts_clauses', static function (array $clauses, \WP_Query $q): array {
	$mode = $q->get('soul_shop_sort');
	if (! $mode || is_admin()) {
		return $clauses;
	}
	global $wpdb;
	$slug = $mode === 'new' ? 'san-pham-moi' : 'san-pham-noi-bat';
	$alias = 'soul_sort_' . $mode;
	$clauses['join'] .= $wpdb->prepare(
		" LEFT JOIN {$wpdb->term_relationships} {$alias}_tr ON ({$wpdb->posts}.ID = {$alias}_tr.object_id)
		  LEFT JOIN {$wpdb->term_taxonomy} {$alias}_tt ON ({$alias}_tr.term_taxonomy_id = {$alias}_tt.term_taxonomy_id AND {$alias}_tt.taxonomy = 'soul_collection')
		  LEFT JOIN {$wpdb->terms} {$alias}_t ON ({$alias}_tt.term_id = {$alias}_t.term_id AND {$alias}_t.slug = %s) ",
		$slug
	);
	$clauses['groupby'] = "{$wpdb->posts}.ID";
	$clauses['orderby'] = "MAX({$alias}_t.term_id) IS NOT NULL DESC, " . $clauses['orderby'];
	return $clauses;
}, 10, 2);
