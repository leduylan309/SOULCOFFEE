<?php
/**
 * Phase 3: blog categories + sample posts + blog page + order-lookup page.
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('init', 'soul_run_seed_phase3', 50);

function soul_run_seed_phase3(): void {
	if (get_option('soul_seeded_phase3')) {
		return;
	}

	$cats = [
		'news'                 => 'News',
		'soul-magazine'        => 'Soul Magazine',
		'how-to-make-coffee'   => 'How to make coffee',
		'recruitment'          => 'Recruitment',
		'soul-achievements'    => 'Soul Achievements',
	];
	$term_ids = [];
	foreach ($cats as $slug => $name) {
		$ex = term_exists($slug, 'category');
		if ($ex) {
			$term_ids[$slug] = (int) (is_array($ex) ? $ex['term_id'] : $ex);
			continue;
		}
		$created = wp_insert_term($name, 'category', ['slug' => $slug]);
		if (! is_wp_error($created)) {
			$term_ids[$slug] = (int) $created['term_id'];
		}
	}

	$posts = [
		[
			'title'   => 'Top 1 Robusta — Vietnam Coffee Producer Competition 2026',
			'slug'    => 'top1-robusta-vcpc-2026',
			'cat'     => 'soul-achievements',
			'excerpt' => '87.21 điểm · hành trình Fine Robusta được ghi nhận.',
			'body'    => 'Soul tiếp tục tập trung vào chất lượng Robusta từ nhân xanh đến tách — kết quả giải thưởng là một điểm mốc, không phải điểm dừng.',
		],
		[
			'title'   => 'Cách pha phin Fine Robusta tại nhà',
			'slug'    => 'pha-phin-fine-robusta',
			'cat'     => 'how-to-make-coffee',
			'excerpt' => 'Tỷ lệ, nhiệt độ và nhịp đổ nước cho tách phin đậm ngọt.',
			'body'    => 'Dùng 20–25g cho phin size phổ biến, nước 92–96°C, đổ hai lần. Nghe barista tại cửa hàng Soul nếu bạn muốn tinh chỉnh.',
		],
		[
			'title'   => 'Soulful Collection 2026: Cay · Nồng · Thơm · Ngọt',
			'slug'    => 'soulful-2026-intro',
			'cat'     => 'soul-magazine',
			'excerpt' => 'Bốn tính cách hương vị từ nghiên cứu sơ chế mùa vụ.',
			'body'    => 'Soulful là nơi nghiên cứu nguyên liệu và lên men trở thành sản phẩm cụ thể — gắn với những vùng đất khác nhau của Tây Nguyên.',
		],
		[
			'title'   => 'Soul đang tìm Barista — Buôn Ma Thuột',
			'slug'    => 'tuyen-dung-barista-bmt',
			'cat'     => 'recruitment',
			'excerpt' => 'Yêu thích cà phê Việt và muốn học cùng đội ngũ Q-Grader / SCA.',
			'body'    => 'Gửi CV qua form liên hệ Help hoặc email admin. Soul ưu tiên người ham học và giao tiếp tốt với khách.',
		],
		[
			'title'   => 'Mùa vụ mới tại vùng liên kết',
			'slug'    => 'mua-vu-moi-vung-lien-ket',
			'cat'     => 'news',
			'excerpt' => 'Cập nhật thu hoạch và sơ chế tại Tây Nguyên.',
			'body'    => 'Mỗi mùa vụ mang đến lô mới và thêm cách hiểu Robusta Việt Nam rõ hơn — theo dõi newsletter để nhận cập nhật.',
		],
	];

	foreach ($posts as $p) {
		if (get_page_by_path($p['slug'], OBJECT, 'post')) {
			continue;
		}
		$id = wp_insert_post([
			'post_type'    => 'post',
			'post_status'  => 'publish',
			'post_title'   => $p['title'],
			'post_name'    => $p['slug'],
			'post_excerpt' => $p['excerpt'],
			'post_content' => '<!-- wp:paragraph --><p>' . esc_html($p['body']) . '</p><!-- /wp:paragraph -->',
		]);
		if (! is_wp_error($id) && $id && isset($term_ids[$p['cat']])) {
			wp_set_post_terms($id, [$term_ids[$p['cat']]], 'category');
		}
	}

	// Blog page as posts index.
	$blog = get_page_by_path('blog');
	if (! $blog) {
		$blog_id = wp_insert_post([
			'post_type'   => 'page',
			'post_status' => 'publish',
			'post_title'  => 'Blog',
			'post_name'   => 'blog',
			'post_content'=> '',
		]);
	} else {
		$blog_id = (int) $blog->ID;
	}
	if ($blog_id && ! is_wp_error($blog_id)) {
		update_option('show_on_front', 'page');
		$home_id = (int) get_option('soul_home_page_id');
		if ($home_id) {
			update_option('page_on_front', $home_id);
		}
		update_option('page_for_posts', $blog_id);
	}

	// Order lookup page.
	if (! get_page_by_path('order-lookup')) {
		$oid = wp_insert_post([
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => 'Order lookup',
			'post_name'    => 'order-lookup',
			'post_content' => '',
		]);
		if ($oid && ! is_wp_error($oid)) {
			update_post_meta($oid, '_wp_page_template', 'templates/order-lookup.php');
			update_option('soul_order_lookup_page_id', $oid);
		}
	}

	flush_rewrite_rules(false);
	update_option('soul_seeded_phase3', 1);
}
