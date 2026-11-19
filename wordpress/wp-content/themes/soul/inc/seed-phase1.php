<?php
/**
 * Phase 1 seed: full collections (BRD §3.4) + expand catalog.
 * Runs once via option soul_seeded_phase1.
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('init', 'soul_run_seed_phase1', 30);

function soul_run_seed_phase1(): void {
	if (get_option('soul_seeded_phase1')) {
		return;
	}
	if (! did_action('after_setup_theme')) {
		return;
	}

	$collections = [
		'ca-phe-rang'              => 'Cà phê rang',
		'soulful-flavours'         => 'Soulful Collection 2026',
		'origin-collection'        => 'Origin Collection',
		'ca-phe-chat-luong-cao'    => 'Horeca Collection',
		'ca-phe-pha-phin'          => 'Cà phê pha phin',
		'ca-phe-pha-may'           => 'Cà phê pha máy',
		'ca-phe-pha-dung-cu'       => 'Cà phê pha dụng cụ',
		'ca-phe-u-lanh-cold-brew'  => 'Cà phê ủ lạnh',
		'ca-phe-nuoc-ngoai'        => 'Cà phê nước ngoài (Arabica)',
		'phu-kien'                 => 'Phụ kiện',
		'hop-qua-combo'            => 'Hộp quà combo',
		'ca-phe-nhan-xanh'         => 'Cà phê nhân xanh',
		'fine-robusta'             => 'Fine Robusta',
		'high-quality-robusta'     => 'High Quality Robusta',
		'specialty-arabica'        => 'Specialty Arabica',
		'high-quality-arabica'     => 'High Quality Arabica',
		'liberica'                 => 'Liberica',
		'san-pham-noi-bat'         => 'Sản phẩm nổi bật',
		'san-pham-moi'             => 'Sản phẩm mới',
	];

	$term_ids = [];
	foreach ($collections as $slug => $name) {
		$existing = term_exists($slug, 'soul_collection');
		if ($existing) {
			$term_ids[$slug] = (int) (is_array($existing) ? $existing['term_id'] : $existing);
			continue;
		}
		$created = wp_insert_term($name, 'soul_collection', ['slug' => $slug]);
		if (! is_wp_error($created)) {
			$term_ids[$slug] = (int) $created['term_id'];
		}
	}

	// Mark existing Liberica as quote_only + green taxonomies.
	$lib = get_page_by_path('vietnam-specialty-liberica-natural-dak-lak', OBJECT, 'soul_product');
	if ($lib) {
		update_post_meta($lib->ID, 'soul_quote_only', '1');
		$assign = array_filter([
			$term_ids['ca-phe-nhan-xanh'] ?? null,
			$term_ids['liberica'] ?? null,
			$term_ids['san-pham-noi-bat'] ?? null,
			$term_ids['san-pham-moi'] ?? null,
		]);
		if ($assign) {
			wp_set_object_terms($lib->ID, $assign, 'soul_collection');
		}
	}

	$extra = [
		[
			'title' => 'Soulful — Thơm',
			'sku'   => 'soulful2026-thom-coldbrew-can-wine-vietnam-fine-robusta',
			'price' => 200000,
			'badge' => 'Soulful 2026',
			'notes' => 'Thơm · Cần Wine Yeast',
			'meta'  => 'Fine Robusta TR Cần Wine Yeast',
			'cols'  => ['soulful-flavours', 'ca-phe-rang', 'ca-phe-u-lanh-cold-brew', 'san-pham-moi'],
			'image' => 'soulful/Soulful-Thom.jpg',
		],
		[
			'title' => 'Soulful — Ngọt',
			'sku'   => 'soulful2026-ngot-brewing-tr-can-wine-fine-robusta',
			'price' => 220000,
			'badge' => 'Soulful 2026',
			'notes' => 'Ngọt · Natural Cần Wine Yeast',
			'meta'  => 'Fine Robusta TR Natural Cần Wine Yeast',
			'cols'  => ['soulful-flavours', 'ca-phe-rang', 'ca-phe-pha-dung-cu', 'san-pham-moi'],
			'image' => 'soulful/Soulful-Ngot.jpg',
		],
		[
			'title' => 'Origin Filter — Fine Robusta',
			'sku'   => 'origin-filter-fine-robusta',
			'price' => 180000,
			'badge' => 'Pha dụng cụ',
			'notes' => 'Trái cây khô, cacao, ngọt sạch',
			'meta'  => 'Buôn Ma Thuột · Fine Robusta · Filter roast',
			'cols'  => ['ca-phe-rang', 'ca-phe-pha-dung-cu', 'origin-collection'],
			'image' => 'featured/espresso_fine_ro.jpg',
		],
		[
			'title' => 'Horeca Blend — 1 kg',
			'sku'   => 'horeca-blend-1kg',
			'price' => 320000,
			'badge' => 'Horeca',
			'notes' => 'Đậm, ổn định cho máy pha quán',
			'meta'  => 'Buôn Ma Thuột · Blend · 1 kg',
			'cols'  => ['ca-phe-rang', 'ca-phe-chat-luong-cao', 'ca-phe-pha-may'],
			'image' => 'featured/premium_coffee_1st_thumbnail.jpg',
			'pack1' => true,
		],
		[
			'title' => 'Fine Robusta TR — Green',
			'sku'   => 'fine-robusta-tr-green-sample',
			'price' => 350000,
			'badge' => 'Nhân xanh',
			'notes' => 'Mẫu 1 kg Fine Robusta TR',
			'meta'  => 'Buôn Ma Thuột · Green · Sample',
			'cols'  => ['ca-phe-nhan-xanh', 'fine-robusta'],
			'image' => 'featured/gb_sfr26_libe.jpg',
			'quote' => true,
			'pack'  => true,
		],
	];

	foreach ($extra as $p) {
		if (get_page_by_path($p['sku'], OBJECT, 'soul_product')) {
			continue;
		}
		$id = wp_insert_post([
			'post_type'    => 'soul_product',
			'post_status'  => 'publish',
			'post_title'   => $p['title'],
			'post_name'    => $p['sku'],
			'post_content' => '<!-- wp:paragraph --><p>' . esc_html($p['notes']) . '</p><!-- /wp:paragraph -->',
			'post_excerpt' => $p['meta'],
		]);
		if (is_wp_error($id) || ! $id) {
			continue;
		}
		update_post_meta($id, 'soul_price', $p['price']);
		update_post_meta($id, 'soul_sku', $p['sku']);
		update_post_meta($id, 'soul_badge', $p['badge']);
		update_post_meta($id, 'soul_notes', $p['notes']);
		update_post_meta($id, 'soul_meta_chain', $p['meta']);
		update_post_meta($id, 'soul_in_stock', '1');
		update_post_meta($id, 'soul_quote_only', ! empty($p['quote']) ? '1' : '0');

		if (! empty($p['pack'])) {
			update_post_meta($id, 'soul_variants', wp_json_encode([
				['id' => 'w', 'label' => 'Quy cách', 'values' => [['1', '1 kg', 1], ['5', '5 kg', 5]]],
			], JSON_UNESCAPED_UNICODE));
		}
		if (! empty($p['pack1'])) {
			update_post_meta($id, 'soul_variants', wp_json_encode([
				['id' => 'w', 'label' => 'Quy cách', 'values' => [['1', '1 kg', 1], ['5', '5 kg', 4.5]]],
			], JSON_UNESCAPED_UNICODE));
		}

		$assign = [];
		foreach ($p['cols'] as $slug) {
			if (isset($term_ids[$slug])) {
				$assign[] = $term_ids[$slug];
			}
		}
		if ($assign) {
			wp_set_object_terms($id, $assign, 'soul_collection');
		}

		$img_path = SOUL_DIR . '/assets/images/' . $p['image'];
		if (function_exists('soul_sideload_featured') && is_readable($img_path)) {
			soul_sideload_featured($id, $img_path, $p['title']);
		}
	}

	// Tag existing Soulful Cay/Nong + roasted into san-pham-moi / origin where useful.
	foreach (
		[
			'ca-phe-fine-robusta-buon-ma-thuot-pha-may' => ['origin-collection', 'ca-phe-pha-may'],
			'ca-phe-fine-robusta-buon-ma-thuot-pha-phin' => ['origin-collection', 'ca-phe-pha-phin'],
			'soulful2026-cay-phin-fine-ro' => ['san-pham-moi'],
			'soulful2025-nong-espresso-fine-ro-top7-vietnam-coffee-producer' => ['san-pham-moi', 'ca-phe-pha-may'],
		] as $slug => $extra_cols
	) {
		$post = get_page_by_path($slug, OBJECT, 'soul_product');
		if (! $post) {
			continue;
		}
		$ids = wp_get_post_terms($post->ID, 'soul_collection', ['fields' => 'ids']);
		if (is_wp_error($ids)) {
			$ids = [];
		}
		foreach ($extra_cols as $c) {
			if (isset($term_ids[$c])) {
				$ids[] = $term_ids[$c];
			}
		}
		wp_set_object_terms($post->ID, array_values(array_unique(array_map('intval', $ids))), 'soul_collection');
	}

	flush_rewrite_rules(false);
	update_option('soul_seeded_phase1', 1);
}
