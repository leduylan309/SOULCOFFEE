<?php
/**
 * One-time seed: sample products, collections, checkout page, menus.
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('after_switch_theme', 'soul_run_seed');

function soul_run_seed(): void {
	if (get_option('soul_seeded_v1')) {
		return;
	}

	$collections = [
		'ca-phe-rang'         => 'Cà phê rang',
		'ca-phe-nhan-xanh'    => 'Nhân xanh',
		'soulful-flavours'    => 'Soulful Collection',
		'ca-phe-pha-may'      => 'Pha máy',
		'ca-phe-pha-phin'     => 'Pha phin',
		'san-pham-noi-bat'    => 'Sản phẩm nổi bật',
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

	$products = [
		[
			'title'  => 'Origin Espresso — Fine Robusta',
			'sku'    => 'ca-phe-fine-robusta-buon-ma-thuot-pha-may',
			'price'  => 170000,
			'badge'  => 'Pha máy',
			'notes'  => 'Cacao, mật ong, ca-ra-men, đậm ngọt',
			'meta'   => 'Buôn Ma Thuột · Robusta TR · Khô (Natural) · Rang đậm vừa',
			'cols'   => ['ca-phe-rang', 'ca-phe-pha-may', 'san-pham-noi-bat'],
			'image'  => 'featured/espresso_fine_ro.jpg',
		],
		[
			'title'  => 'Origin Vietnamese Phin — Fine Robusta',
			'sku'    => 'ca-phe-fine-robusta-buon-ma-thuot-pha-phin',
			'price'  => 170000,
			'badge'  => 'Pha phin',
			'notes'  => 'Cacao, mật ong, ca-ra-men, đậm ngọt',
			'meta'   => 'Buôn Ma Thuột · Robusta TR · Khô (Natural) · Rang đậm vừa',
			'cols'   => ['ca-phe-rang', 'ca-phe-pha-phin', 'san-pham-noi-bat'],
			'image'  => 'featured/phin_finero.jpg',
		],
		[
			'title'  => 'Premium Coffee — Robusta',
			'sku'    => 'ca-phe-chat-luong-cao-arabica-robusta-pha-may-pha-phin',
			'price'  => 250000,
			'badge'  => 'Pha phin · Pha máy',
			'notes'  => 'Chocolate, mật ong, trà đen, gu đắng đậm',
			'meta'   => 'Buôn Ma Thuột · Robusta · Khô (Natural) · Rang đậm vừa',
			'cols'   => ['ca-phe-rang', 'san-pham-noi-bat'],
			'image'  => 'featured/premium_coffee_1st_thumbnail.jpg',
		],
		[
			'title'  => 'GB-SFR-Liberica',
			'sku'    => 'vietnam-specialty-liberica-natural-dak-lak',
			'price'  => 450000,
			'badge'  => 'Mùa vụ mới 25/26',
			'notes'  => 'Vỏ cam, chanh dây, lá xá xị, gợi vị đào',
			'meta'   => "M'Drak, Đắk Lắk · Natural – lên men Soul Yeast",
			'cols'   => ['ca-phe-nhan-xanh', 'san-pham-noi-bat'],
			'image'  => 'featured/gb_sfr26_libe.jpg',
			'pack'   => true,
		],
		[
			'title'  => 'Soulful — Cay',
			'sku'    => 'soulful2026-cay-phin-fine-ro',
			'price'  => 200000,
			'badge'  => 'Soulful 2026',
			'notes'  => 'Cay, honey process',
			'meta'   => 'Fine Robusta TR Red Honey',
			'cols'   => ['soulful-flavours', 'ca-phe-rang'],
			'image'  => 'soulful/Soulful-Cay.jpg',
		],
		[
			'title'  => 'Soulful — Nồng',
			'sku'    => 'soulful2025-nong-espresso-fine-ro-top7-vietnam-coffee-producer',
			'price'  => 200000,
			'badge'  => 'Soulful 2026',
			'notes'  => 'Nồng, Soul Yeast',
			'meta'   => 'Fine Robusta TR Soul Yeast',
			'cols'   => ['soulful-flavours', 'ca-phe-rang'],
			'image'  => 'soulful/Soulful-Nong.jpg',
		],
	];

	foreach ($products as $p) {
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

		if (! empty($p['pack'])) {
			update_post_meta($id, 'soul_variants', wp_json_encode([
				['id' => 'w', 'label' => 'Quy cách', 'values' => [['1', '1 kg', 1], ['5', '5 kg', 5]]],
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
		if (is_readable($img_path)) {
			soul_sideload_featured($id, $img_path, $p['title']);
		}
	}

	// Checkout page
	$checkout_id = (int) get_option('soul_checkout_page_id');
	if (! $checkout_id || ! get_post($checkout_id)) {
		$checkout_id = wp_insert_post([
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => 'Checkout',
			'post_name'    => 'checkout',
			'post_content' => '',
			'page_template'=> 'templates/checkout.php',
		]);
		if ($checkout_id && ! is_wp_error($checkout_id)) {
			update_post_meta($checkout_id, '_wp_page_template', 'templates/checkout.php');
			update_option('soul_checkout_page_id', $checkout_id);
		}
	}

	// Home page from pattern content
	$home_id = (int) get_option('soul_home_page_id');
	if (! $home_id || ! get_post($home_id)) {
		$home_id = wp_insert_post([
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => 'Home',
			'post_name'    => 'home',
			'post_content' => soul_home_seed_content(),
		]);
		if ($home_id && ! is_wp_error($home_id)) {
			update_option('soul_home_page_id', $home_id);
			update_option('show_on_front', 'page');
			update_option('page_on_front', $home_id);
		}
	}

	flush_rewrite_rules();
	update_option('soul_seeded_v1', 1);
}

function soul_sideload_featured(int $post_id, string $file, string $title): void {
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$tmp = wp_tempnam(basename($file));
	if (! $tmp) {
		return;
	}
	copy($file, $tmp);
	$file_array = [
		'name'     => basename($file),
		'tmp_name' => $tmp,
	];
	$id = media_handle_sideload($file_array, $post_id, $title);
	if (! is_wp_error($id)) {
		set_post_thumbnail($post_id, $id);
	} else {
		@unlink($tmp);
	}
}

function soul_home_seed_content(): string {
	$shop = esc_url(get_post_type_archive_link('soul_product') ?: home_url('/products/'));
	return <<<HTML
<!-- wp:group {"align":"full","className":"is-style-surface-paper soul-hero","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-paper soul-hero"><!-- wp:paragraph {"className":"soul-eyebrow"} -->
<p class="soul-eyebrow">Buôn Ma Thuột, Việt Nam</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"fontSize":"hero"} -->
<h1 class="wp-block-heading has-hero-font-size">Một thế hệ mới của Robusta Việt Nam</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"is-style-lead","fontSize":"lead"} -->
<p class="is-style-lead has-lead-font-size">Soul lớn lên từ Buôn Ma Thuột. Chúng tôi tiếp tục câu chuyện Robusta bằng vùng nguyên liệu, sơ chế, rang và pha chế.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-primary"} -->
<div class="wp-block-button is-style-primary"><a class="wp-block-button__link wp-element-button" href="{$shop}">Khám phá cà phê ↗</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#story">Câu chuyện của Soul</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"is-style-surface-sand","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-sand"><!-- wp:heading -->
<h2 class="wp-block-heading">Khám phá các dòng cà phê của Soul</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><a href="{$shop}">Xem tất cả sản phẩm ↗</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"is-style-surface-ink","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-ink" id="story"><!-- wp:paragraph {"className":"soul-eyebrow"} -->
<p class="soul-eyebrow">Crafted by Vietnamese Soul</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Một thế hệ mới lớn lên cùng cà phê</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Soul làm việc với cà phê từ vùng nguyên liệu đến tách — sơ chế, đánh giá nhân xanh, rang và pha chế.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"is-style-surface-yellow","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-surface-yellow"><!-- wp:heading -->
<h2 class="wp-block-heading">Theo dõi những gì sắp diễn ra tại Soul</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Đăng ký nhận cập nhật mùa vụ và câu chuyện từ vùng nguyên liệu.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
HTML;
}
