<?php
/**
 * Phase 2: marketing pages + spaces CPT seed.
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('init', 'soul_run_seed_phase2', 40);

function soul_run_seed_phase2(): void {
	if (get_option('soul_seeded_phase2')) {
		return;
	}
	if (! function_exists('soul_home_full_content')) {
		return;
	}

	// Update Home content to full BRD §3.6 stack.
	$home_id = (int) get_option('soul_home_page_id');
	if ($home_id && get_post($home_id)) {
		wp_update_post([
			'ID'           => $home_id,
			'post_content' => soul_home_full_content(),
		]);
	}

	$pages = [
		'our-story'         => ['Our Story', 'soul_page_our_story_content'],
		'coffee-solutions'  => ['Coffee Solutions', 'soul_page_solutions_content'],
		'help'              => ['Help', 'soul_page_help_content'],
	];

	foreach ($pages as $slug => [$title, $fn]) {
		$existing = get_page_by_path($slug);
		$content  = $fn();
		if ($existing) {
			wp_update_post([
				'ID'           => $existing->ID,
				'post_content' => $content,
				'post_status'  => 'publish',
			]);
			continue;
		}
		wp_insert_post([
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_content' => $content,
		]);
	}

	$spaces = [
		'bmt' => [
			'Soul Buôn Ma Thuột',
			'Tây Nguyên',
			'87 Nguyễn Khuyến, Buôn Ma Thuột',
			'07:00 – 22:00',
			'',
			'Soul Specialty Coffee 87 Nguyễn Khuyến Buôn Ma Thuột',
			'spaces/Soul-BMT.jpg',
			'Không gian gốc — gần vùng cà phê, gần câu chuyện Soul.',
		],
		'hcm' => [
			'Soul Sài Gòn',
			'Hồ Chí Minh',
			'Lê Văn Sỹ, TP.HCM',
			'07:30 – 22:00',
			'',
			'Soul Specialty Coffee Lê Văn Sỹ',
			'spaces/Soul-SG.jpg',
			'Góc yên trong phố — cà phê Việt và sản phẩm từ nguồn gốc Soul.',
		],
		'hn' => [
			'Soul Hà Nội',
			'Hà Nội',
			'Đường Thành, Hà Nội',
			'07:30 – 22:00',
			'',
			'Soul Specialty Coffee Đường Thành',
			'spaces/Soul-HN.jpg',
			'Nhịp chậm trong phố cổ — nơi nguồn gốc và thành phố gặp nhau.',
		],
		'dn' => [
			'Soul Đà Nẵng',
			'Đà Nẵng',
			'Đà Nẵng',
			'07:30 – 22:00',
			'',
			'Soul Specialty Coffee Đà Nẵng',
			'spaces/Soul-Da-Nang.jpg',
			'Cà phê Việt giữa nhịp sống duyên hải.',
		],
		'bn' => [
			'Soul Bà Nà',
			'Bà Nà Hills',
			'Bà Nà Hills, Đà Nẵng',
			'Theo giờ khu du lịch',
			'',
			'Soul Specialty Coffee Bà Nà',
			'spaces/Soul-Ba-Na.png',
			'Giữa núi và thời tiết cao nguyên — dừng chân với cà phê Soul.',
		],
	];

	foreach ($spaces as $slug => $row) {
		[$title, $region, $address, $hours, $hotline, $map, $image, $excerpt] = $row;
		if (get_page_by_path($slug, OBJECT, 'soul_space')) {
			continue;
		}
		$id = wp_insert_post([
			'post_type'    => 'soul_space',
			'post_status'  => 'publish',
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_excerpt' => $excerpt,
			'post_content' => '<!-- wp:paragraph --><p>' . esc_html($excerpt) . '</p><!-- /wp:paragraph -->',
		]);
		if (is_wp_error($id) || ! $id) {
			continue;
		}
		update_post_meta($id, 'soul_region', $region);
		update_post_meta($id, 'soul_address', $address);
		update_post_meta($id, 'soul_hours', $hours);
		update_post_meta($id, 'soul_hotline', $hotline);
		update_post_meta($id, 'soul_map_q', $map);
		$path = SOUL_DIR . '/assets/images/' . $image;
		if (function_exists('soul_sideload_featured') && is_readable($path)) {
			soul_sideload_featured($id, $path, $title);
		}
	}

	flush_rewrite_rules(false);
	update_option('soul_seeded_phase2', 1);
}
