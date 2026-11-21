<?php
/**
 * Reseed soul_space CPT meta/copy/images from Spaces.dc.html (VI).
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('init', 'soul_run_seed_spaces_fidelity', 79);

function soul_run_seed_spaces_fidelity(): void {
	if (get_option('soul_seeded_spaces_fidelity_v4')) {
		return;
	}

	$cdn = 'https://cdn.hstatic.net/files/1000391513/file/';

	$bn_gallery = [];
	foreach ([['07_45', 2], ['07_46', 6], ['07_46', 8], ['07_46', 4], ['07_45', 1], ['07_46', 9], ['07_46', 5], ['07_46', 7], ['07_45', 3]] as [$t, $n]) {
		$bn_gallery[] = $cdn . 'chatgpt_image_15_' . $t . '_3_thg_9__2026__' . $n . '_.png';
	}

	$hn_gallery = array_map(
		static fn(string $f): string => $cdn . $f,
		['ha_noi_3.png', 'ha_noi_5.png', 'ha_noi_4.png', 'ha_noi_6.png', 'ha_noi_2.png', 'ha_noi_1.png']
	);

	$dn_gallery = array_map(
		static fn(string $f): string => $cdn . $f,
		[
			'artboard_4_ed3bafae1f3044a2b0345f4160a642b0.png',
			'artboard_3_cc1c0a13fcfc4600bdb8fdc130e884f1.png',
			'artboard_2_485d1a01b8924b11b14208575a72fe7b.png',
			'unnamed__3_.jpeg',
			'unnamed__2_.jpeg',
			'4261acb3-6dc6-4e91-998c-fd34b684c4ab.png',
		]
	);

	$spaces = [
		'bmt' => [
			'title'    => 'Soul Buôn Ma Thuột',
			'city'     => 'Buôn Ma Thuột',
			'region'   => 'Buôn Ma Thuột · Đắk Lắk',
			'address'  => '87 Nguyễn Khuyến, P. Buôn Ma Thuột, Tỉnh Đắk Lắk',
			'hours'    => "07:00 – 20:00 · Hằng ngày",
			'hotline'  => '0969 648 148',
			'map_q'    => 'Soul Specialty Coffee 87 Nguyễn Khuyến Buôn Ma Thuột',
			'menu_url' => 'https://soulcoffee.vn/pages/soul-buon-ma-thuot',
			'image'    => '06-spaces/Soul-BMT.jpg',
			'order'    => 1,
			'lead'     => 'Soul Buôn Ma Thuột là nơi mọi thứ bắt đầu.',
			'about'    => [
				'Cửa hàng đầu tiên của Soul nằm ngay trên mảnh đất đã nuôi dưỡng thương hiệu từ những ngày đầu: gần vùng trồng cà phê, gần những con người làm ra cà phê, và gần nhất với những câu chuyện đã định hình sản phẩm Soul hôm nay.',
				'Vì vậy, đây không chỉ là nơi dừng chân uống cà phê mà là một phần nguồn cội của Soul. Không gian mang nhịp riêng: nhiều cây xanh, mở, thoải mái và đủ tĩnh để thưởng thức trọn từng tách.',
			],
			'gallery'  => [],
		],
		'hcm' => [
			'title'    => 'Soul Hồ Chí Minh',
			'city'     => 'Hồ Chí Minh',
			'region'   => 'TP. Hồ Chí Minh',
			'address'  => '386/11 Lê Văn Sỹ, P. Nhiêu Lộc, TP. Hồ Chí Minh',
			'hours'    => "07:00 – 18:00 · Hằng ngày",
			'hotline'  => '0987 592 220',
			'map_q'    => 'Soul Specialty Coffee 386/11 Lê Văn Sỹ',
			'menu_url' => $cdn . 'sg_ef0e9806e16f4475bab0136c31fe5451.pdf',
			'image'    => '06-spaces/Soul-SG.jpg',
			'order'    => 2,
			'lead'     => 'Soul Hồ Chí Minh đưa Soul vào nhịp sống thành phố.',
			'about'    => [
				'Nép mình trên đường Lê Văn Sỹ, không gian là một khoảng lặng giữa nhịp phố bên ngoài: nơi khám phá cà phê Việt, nán lại bên một tách quen, và tìm hiểu những sản phẩm cùng câu chuyện Soul mang về từ nơi khởi nguồn.',
				'Mỗi không gian Soul có tính cách riêng, nhưng điều cốt lõi vẫn vậy: cà phê Việt ở trung tâm trải nghiệm. Từ cà phê ở quầy bar đến sản phẩm trên kệ, Soul Hồ Chí Minh kể câu chuyện ấy trong một khung cảnh đô thị gần gũi.',
			],
			'gallery'  => [],
		],
		'hn' => [
			'title'    => 'Soul Hà Nội',
			'city'     => 'Hà Nội',
			'region'   => 'Hà Nội',
			'address'  => '12 Đường Thành, P. Hoàn Kiếm, Hà Nội',
			'hours'    => "Thứ 2 – Thứ 5: 07:00 – 18:00\nThứ 6 – Chủ nhật: 07:00 – 22:00",
			'hotline'  => '0902 853 500',
			'map_q'    => 'Soul Specialty Coffee 12 Đường Thành Hà Nội',
			'menu_url' => $cdn . 'hnn.pdf',
			'image'    => '06-spaces/Soul-HN.jpg',
			'order'    => 3,
			'lead'     => 'Soul Hà Nội đưa câu chuyện cà phê Việt vào lòng thủ đô.',
			'about'    => [
				'Nằm trên phố Đường Thành, không gian mang một nhịp chậm hơn giữa thành phố: nơi để dừng lại, dành thời gian bên tách cà phê, và khám phá thêm những dòng cà phê, sản phẩm Soul phát triển từ cội rễ ở các vùng trồng cà phê Việt Nam.',
				'Bầu không khí gần gũi và thân quen, mang tính cách của khu phố mà vẫn gắn với câu chuyện lớn của Soul. Từ những khoảnh khắc cà phê thường ngày đến một cái nhìn kỹ hơn về cà phê Việt, Soul Hà Nội là nơi nguồn gốc, tay nghề và nhịp phố gặp nhau.',
			],
			'gallery'  => $hn_gallery,
		],
		'bn' => [
			'title'    => 'Soul Bà Nà',
			'city'     => 'Bà Nà Hills',
			'region'   => 'Bà Nà Hills · Đà Nẵng',
			'address'  => 'Tầng 2 Kavkaz, Quảng trường Hội Tụ, Sun World Bà Nà Hills, Đà Nẵng',
			'hours'    => "09:00 – 17:00 · Hằng ngày",
			'hotline'  => '',
			'map_q'    => 'Soul Specialty Coffee - Ba Na Hills',
			'menu_url' => $cdn . 'menubn26.pdf',
			'image'    => '06-spaces/Soul-Ba-Na.png',
			'order'    => 4,
			'lead'     => 'Soul Bà Nà đưa cà phê Việt đến một trong những điểm đến đặc biệt nhất của Đà Nẵng.',
			'about'    => [
				'Nằm trên Bà Nà Hills, không gian mang khung cảnh khác hẳn các cửa hàng trong phố: núi non bao quanh, thời tiết đổi thay và bầu không khí rất riêng của vùng cao phía trên Đà Nẵng.',
				'Tại đây, du khách có thể dừng chân trên hành trình và trải nghiệm Soul qua cà phê Việt, những cách pha quen thuộc và sản phẩm mang dấu ấn Tây Nguyên. Đây là điểm giao giữa điểm đến, cảnh quan và văn hóa cà phê Soul mang theo từ nơi khởi nguồn.',
			],
			'gallery'  => $bn_gallery,
		],
		'dn' => [
			'title'    => 'Soul Đà Nẵng',
			'city'     => 'Đà Nẵng',
			'region'   => 'An Thượng · Đà Nẵng',
			'address'  => '12 An Thượng 11, P. Ngũ Hành Sơn, Đà Nẵng',
			'hours'    => "07:00 – 20:00 · Hằng ngày",
			'hotline'  => '0905 976 694',
			'map_q'    => 'Soul Specialty Coffee 12 An Thượng 11 Đà Nẵng',
			'menu_url' => $cdn . 'dn2026.pdf',
			'image'    => '06-spaces/Soul-Da-Nang.jpg',
			'order'    => 5,
			'lead'     => 'Soul Đà Nẵng đưa Soul đến gần nhịp sống thường ngày của An Thượng.',
			'about'    => [
				'Nằm giữa một trong những khu phố sôi động nhất Đà Nẵng, không gian mang nhịp thong thả của thành phố, sự hòa trộn giữa người địa phương và du khách, nơi cà phê tự nhiên trở thành một phần của ngày.',
				'Soul tiếp tục đặt cà phê Việt ở trung tâm trải nghiệm: từ những tách quen thuộc đến những dòng cà phê mời bạn nhìn kỹ hơn vào nguồn gốc, sơ chế và hương vị. Mở và dễ gần, Soul Đà Nẵng là nơi để chậm lại, gặp gỡ, làm việc hay đơn giản là dành thời gian bên cà phê theo cách của riêng bạn.',
			],
			'gallery'  => $dn_gallery,
		],
	];

	foreach ($spaces as $slug => $row) {
		$existing = get_page_by_path($slug, OBJECT, 'soul_space');

		$postarr = [
			'post_type'    => 'soul_space',
			'post_status'  => 'publish',
			'post_title'   => $row['title'],
			'post_name'    => $slug,
			'post_excerpt' => $row['lead'],
			'post_content' => '',
			'menu_order'   => (int) $row['order'],
		];

		if ($existing) {
			$postarr['ID'] = (int) $existing->ID;
			$id            = wp_update_post($postarr, true);
		} else {
			$id = wp_insert_post($postarr, true);
		}

		if (is_wp_error($id) || ! $id) {
			continue;
		}

		$id = (int) $id;
		update_post_meta($id, 'soul_city', $row['city']);
		update_post_meta($id, 'soul_region', $row['region']);
		update_post_meta($id, 'soul_address', $row['address']);
		update_post_meta($id, 'soul_hours', $row['hours']);
		update_post_meta($id, 'soul_hotline', $row['hotline']);
		update_post_meta($id, 'soul_map_q', $row['map_q']);
		update_post_meta($id, 'soul_menu_url', $row['menu_url']);
		delete_post_meta($id, 'soul_gallery');

		$path = SOUL_DIR . '/assets/images/' . $row['image'];
		if (function_exists('soul_sideload_featured') && is_readable($path)) {
			soul_sideload_featured($id, $path, $row['title']);
		}

		// Core Gallery block in content — editor Upload / Media Library (no URL meta).
		$gallery_items = [];
		foreach ($row['gallery'] as $gi => $gurl) {
			$gallery_items[] = [
				'url' => $gurl,
				'alt' => $row['title'] . ' · ' . str_pad((string) ($gi + 1), 2, '0', STR_PAD_LEFT),
			];
		}

		// Pattern-first content: Gallery = core block (Upload / Media Library).
		if (function_exists('soul_space_branch_content')) {
			$branch = soul_space_branch_content($id, $row['about'], $gallery_items);
			kses_remove_filters();
			wp_update_post([
				'ID'           => $id,
				'post_content' => $branch,
				'post_excerpt' => $row['lead'],
			]);
			kses_init_filters();
		}
	}

	flush_rewrite_rules(false);
	update_option('soul_seeded_spaces_fidelity_v1', 1);
	update_option('soul_seeded_spaces_fidelity_v2', 1);
	update_option('soul_seeded_spaces_fidelity_v3', 1);
	update_option('soul_seeded_spaces_fidelity_v4', 1);
}
