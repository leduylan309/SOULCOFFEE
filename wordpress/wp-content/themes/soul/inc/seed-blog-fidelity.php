<?php
/**
 * Reseed blog categories / tags / posts from html/Blog.dc.html (VI).
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('init', 'soul_run_seed_blog_fidelity', 80);

function soul_blog_body_note(string $text = ''): string {
	$t = $text !== '' ? $text : 'Nội dung đầy đủ của bài viết sẽ được chuyển nguyên văn từ soulcoffee.vn khi triển khai.';
	return '<!-- wp:group {"className":"s-blog-note","layout":{"type":"default"}} -->
<div class="wp-block-group s-blog-note"><!-- wp:paragraph -->
<p>' . esc_html($t) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->';
}

function soul_blog_body_drip(): string {
	return '<!-- wp:paragraph -->
<p>Mỗi túi lọc chứa Fine Robusta được Soul chọn lọc và rang phù hợp để giữ lại đặc trưng rõ ràng, cân bằng và dễ thưởng thức. Dù ở nhà, văn phòng hay trên đường, Drip Bag giúp bạn có một tách cà phê Việt gọn nhẹ và gần gũi nhất.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">Cách pha</h2>
<!-- /wp:heading -->

<!-- wp:list {"className":"s-blog-steps"} -->
<ul class="s-blog-steps wp-block-list">
<li><span class="s-blog-steps__n">01</span><span class="s-blog-steps__k">Xé túi</span><span class="s-blog-steps__v">Xé túi cà phê theo đường hướng dẫn.</span></li>
<li><span class="s-blog-steps__n">02</span><span class="s-blog-steps__k">Đặt lên cốc</span><span class="s-blog-steps__v">Mở hai quai giấy và cố định túi lọc lên miệng cốc.</span></li>
<li><span class="s-blog-steps__n">03</span><span class="s-blog-steps__k">Rót nước nóng</span><span class="s-blog-steps__v">Rót từ từ: 80 ml cho dòng Phin, 120 ml cho dòng Brewing. Đảm bảo nước thấm đều.</span></li>
<li><span class="s-blog-steps__n">04</span><span class="s-blog-steps__k">Thưởng thức</span><span class="s-blog-steps__v">Khi nước đã chảy hết, nhấc túi lọc ra và thưởng thức.</span></li>
</ul>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p>Một cách pha nhanh gọn để thưởng thức cà phê Soul theo cách riêng của bạn, ở bất cứ đâu.</p>
<!-- /wp:paragraph -->';
}

/**
 * @param list<array{0:string,1:string}> $rows
 */
function soul_blog_body_facts(array $rows): string {
	$html = '<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">Thông tin lô</h2>
<!-- /wp:heading -->

<!-- wp:group {"className":"s-blog-facts","layout":{"type":"default"}} -->
<div class="wp-block-group s-blog-facts">';
	foreach ($rows as $r) {
		$html .= '<!-- wp:group {"className":"s-blog-facts__row","layout":{"type":"default"}} -->
<div class="wp-block-group s-blog-facts__row"><!-- wp:paragraph {"className":"s-blog-facts__k"} -->
<p class="s-blog-facts__k">' . esc_html($r[0]) . '</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-blog-facts__v"} -->
<p class="s-blog-facts__v">' . esc_html($r[1]) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->';
	}
	$html .= '</div>
<!-- /wp:group -->
' . soul_blog_body_note('Phần câu chuyện vùng trồng và ghi chú hương vị đầy đủ sẽ được chuyển nguyên văn từ bài gốc.');
	return $html;
}

function soul_blog_body_store_manager(): string {
	$stores = implode(', ', soul_blog_job_stores());
	$duties = [
		'Quản lý hoạt động kinh doanh, kế hoạch và KPI cửa hàng',
		'Vận hành cửa hàng theo SOP, kiểm soát chất lượng đồ uống và sản phẩm',
		'Quản lý hàng hóa, tồn kho, nhập – xuất – tồn',
		'Kiểm soát doanh thu, chi phí và ngân sách',
		'Tuyển dụng, đào tạo, xếp lịch và đánh giá nhân sự',
		'Đảm bảo tiêu chuẩn dịch vụ và trải nghiệm khách hàng',
		'Tuân thủ quy định VSATTP, PCCC và an toàn lao động',
	];
	$reqs = [
		'Tối thiểu 2 năm kinh nghiệm quản lý cửa hàng F&B',
		'Ưu tiên kinh nghiệm tại khu du lịch, trung tâm thương mại hoặc chuỗi cà phê',
		'Kỹ năng lãnh đạo, lập kế hoạch, phân tích và giải quyết vấn đề',
	];
	$list = static function (array $items): string {
		$li = '';
		foreach ($items as $t) {
			$li .= '<li>' . esc_html($t) . '</li>';
		}
		return '<!-- wp:list {"className":"s-blog-list"} -->
<ul class="s-blog-list wp-block-list">' . $li . '</ul>
<!-- /wp:list -->';
	};
	return '<!-- wp:paragraph -->
<p>Soul Specialty Coffee đang tuyển Store Manager cho các cửa hàng: ' . esc_html($stores) . '.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">Mục tiêu công việc</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Chịu trách nhiệm quản lý và điều hành toàn bộ hoạt động kinh doanh, vận hành, nhân sự, tài chính, hàng hóa và chất lượng dịch vụ của cửa hàng; hoàn thành chỉ tiêu và KPI được giao, tuân thủ quy định của Công ty.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">Nhiệm vụ chính</h2>
<!-- /wp:heading -->
' . $list($duties) . '

<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">Yêu cầu</h2>
<!-- /wp:heading -->
' . $list($reqs) . '

<!-- wp:group {"className":"s-blog-apply","layout":{"type":"default"}} -->
<div class="wp-block-group s-blog-apply"><!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"s-blog-apply__eye"} -->
<p class="s-blog-apply__eye">Ứng tuyển</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-blog-apply__text"} -->
<p class="s-blog-apply__text">Gửi CV về hcns.soulcoffee@gmail.com</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph -->
<p><a class="s-blog-apply__btn" href="mailto:hcns.soulcoffee@gmail.com?subject=Store%20Manager">Gửi CV ↗</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->';
}

function soul_blog_body_barista(): string {
	return soul_blog_body_note('Mô tả công việc chi tiết sẽ được chuyển nguyên văn từ bài gốc.') . '

<!-- wp:group {"className":"s-blog-apply","layout":{"type":"default"}} -->
<div class="wp-block-group s-blog-apply"><!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"s-blog-apply__eye"} -->
<p class="s-blog-apply__eye">Ứng tuyển</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-blog-apply__text"} -->
<p class="s-blog-apply__text">Gửi CV về hcns.soulcoffee@gmail.com</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph -->
<p><a class="s-blog-apply__btn" href="mailto:hcns.soulcoffee@gmail.com?subject=Barista">Gửi CV ↗</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->';
}

function soul_run_seed_blog_fidelity(): void {
	if (get_option('soul_seeded_blog_fidelity_v2')) {
		return;
	}
	if (! function_exists('soul_blog_categories_sot')) {
		return;
	}

	// Remove WP default + phase3 samples that fight SoT date order.
	foreach (['hello-world', 'top1-robusta-vcpc-2026', 'pha-phin-fine-robusta', 'soulful-2026-intro', 'tuyen-dung-barista-bmt', 'mua-vu-moi-vung-lien-ket'] as $junk) {
		$p = get_page_by_path($junk, OBJECT, 'post');
		if ($p) {
			wp_delete_post((int) $p->ID, true);
		}
	}

	$tag_map = [
		'fr' => 'vietnam-fine-robusta',
		'aw' => 'awards',
		'nc' => 'new-crop',
		'br' => 'brewing',
		'sp' => 'specialty',
		'ev' => 'events',
		'so' => 'soulful',
		'dl' => 'dak-lak',
		'ca' => 'careers',
	];
	foreach ($tag_map as $slug) {
		if (! term_exists($slug, 'post_tag')) {
			wp_insert_term($slug, 'post_tag', ['slug' => $slug]);
		}
	}

	$term_ids = [];
	foreach (soul_blog_categories_sot() as $row) {
		$ex = term_exists($row['slug'], 'category');
		if ($ex) {
			$tid = (int) (is_array($ex) ? $ex['term_id'] : $ex);
			wp_update_term($tid, 'category', [
				'name'        => $row['name'],
				'description' => $row['intro'],
				'slug'        => $row['slug'],
			]);
		} else {
			$created = wp_insert_term($row['name'], 'category', [
				'slug'        => $row['slug'],
				'description' => $row['intro'],
			]);
			$tid = is_wp_error($created) ? 0 : (int) $created['term_id'];
		}
		if ($tid) {
			$term_ids[$row['slug']] = $tid;
		}
	}
	// Alias old phase3 slug.
	$old = term_exists('soul-magazine', 'category');
	if ($old && isset($term_ids['soul-megazine'])) {
		$old_id = (int) (is_array($old) ? $old['term_id'] : $old);
		$posts  = get_posts(['post_type' => 'post', 'numberposts' => -1, 'category' => $old_id, 'fields' => 'ids']);
		foreach ($posts as $pid) {
			wp_set_post_terms((int) $pid, [$term_ids['soul-megazine']], 'category', true);
		}
	}

	$bodies = [
		'drip'      => soul_blog_body_drip(),
		'kenya'     => soul_blog_body_facts([['Vùng trồng', 'Kirinyaga, Kenya'], ['Độ cao', '1.650 masl'], ['Giống', 'SL28, SL34, Ruiru 11'], ['Sơ chế', 'Washed']]),
		'colombia'  => soul_blog_body_facts([['Vùng trồng', 'San Agustín, Huila, Colombia'], ['Độ cao', '1.800 masl'], ['Giống', 'Sidra'], ['Sơ chế', 'Anaerobic Washed'], ['Hương vị', 'Gừng, cam quýt, hương hoa']]),
		'nicaragua' => soul_blog_body_facts([['Vùng trồng', 'Jinotega, Nicaragua'], ['Độ cao', '1.250 masl'], ['Giống', 'Bourbon'], ['Sơ chế', 'Funky Natural'], ['Hương vị', 'Rượu trái cây nhiệt đới, cherry, nho khô']]),
		'ethiopia'  => soul_blog_body_facts([['Vùng trồng', 'Idido, Yirgacheffe, Ethiopia'], ['Độ cao', '1.940 – 1.985 masl'], ['Giống', 'Heirlooms'], ['Sơ chế', 'Oro yeast · 3 ngày']]),
		'sm'        => soul_blog_body_store_manager(),
		'ba'        => soul_blog_body_barista(),
	];

	// [slug, date, cats, title, img, tags, excerpt, bodyKey]
	$posts = [
		['coffee-drip-bag', '2026-08-17', 'how-to-make-coffee', 'Hướng dẫn pha cà phê túi lọc chuẩn Soul', '02-shop/Pha-thu-cong.png', 'br', 'Chỉ cần một chiếc cốc và nước nóng, bạn đã có một tách Fine Robusta thơm ngon trong vài phút, ở bất cứ đâu.', 'drip'],
		['huong-dan-pha-pour-over-liberica-chuan-soul', '2026-07-03', 'how-to-make-coffee', 'Hướng dẫn pha Pour Over Liberica chuẩn Soul', '02-featured/gb_sfr26_libe.jpg', 'br,sp', 'Công thức pour over giúp Liberica bộc lộ tầng hương trái cây chín và độ ngọt đặc trưng.', ''],
		['soul-fine-robusta-dat-top-1-va-top-3-robusta-tai-vietnam-coffee-producer-competition-2026', '2026-06-29', 'news', 'Soul Fine Robusta đạt Top 1 & Top 3 Robusta tại Vietnam Coffee Producer Competition 2026', '03c-awards/web/VCPC2026.jpg', 'aw,fr', 'Thêm một mùa thi đáng nhớ: hai mẫu Fine Robusta của Soul cùng góp mặt trong nhóm dẫn đầu hạng mục Robusta.', ''],
		['soul-fine-robusta-2026-issue-new-crop-26-journey', '2026-04-23', 'soul-megazine', "2026 Issue: New Crop'26 Journey", '04-soulful/Soulful_vuong.png', 'nc,so', 'Ấn phẩm 2026 theo chân mùa vụ mới, từ vườn cà đến bộ sưu tập Soulful Collection ’26.', ''],
		['kenya-karimikui', '2026-03-27', 'news', 'Kenya Karimikui: biểu hiện trọn vẹn của Kirinyaga', '04-soulful/Soulful-Thom.jpg', 'sp', 'Lô cà phê sơ chế ướt từ vùng cao Kirinyaga, với giống SL28, SL34 và Ruiru 11.', 'kenya'],
		['colombia-sidra-finca-lumbrera', '2026-03-27', 'news', 'Colombia Sidra – Finca Lumbrera: tầng hương bản sắc miền Nam Huila', '04-soulful/Soulful-Cay.jpg', 'sp', 'Giống Sidra ở độ cao 1.800 m, sơ chế Anaerobic Washed cho hương gừng, cam quýt và hoa.', 'colombia'],
		['nicaragua-mierisch-bourbon-los-placeres-funky', '2026-03-27', 'news', 'Nicaragua Mierisch Bourbon: dấu ấn đậm từ Funky Natural', '04-soulful/Soulful-Nong.jpg', 'sp', 'Bourbon từ Jinotega với phương pháp Funky Natural: rượu trái cây nhiệt đới, cherry và nho khô.', 'nicaragua'],
		['ethiopia-oro-yeast-idido-dau-an-huong-vi-tu-vung-cao-yirgacheffe', '2026-03-27', 'news', 'Ethiopia Oro Yeast Idido: dấu ấn hương vị từ vùng cao Yirgacheffe', '04-soulful/Soulful-Ngot.jpg', 'sp', 'Giống bản địa ở độ cao gần 2.000 m, lên men với men Oro trong ba ngày.', 'ethiopia'],
		['soul-first-sip-khi-mot-hat-ca-phe-mo-ra-nhieu-cach-ke-chuyen', '2026-03-27', 'news', 'Soul First Sip: khi một hạt cà phê mở ra nhiều cách kể chuyện', '02-featured/espresso_fine_ro.jpg', 'fr', 'Khám phá Fine Robusta qua ba cách chạm: cold brew, phin và milk base.', ''],
		['soul-fine-robusta-toa-dam-dinh-huong-phat-trien-fine-robusta-viet-nam', '2025-11-18', 'news', 'Tọa đàm định hướng phát triển Fine Robusta Việt Nam', '03b-why-soul/web/why-cupping.jpg', 'fr,ev', 'Nhà sản xuất, chuyên gia và đối tác cùng bàn về chất lượng, tiêu chuẩn và con đường đưa Fine Robusta đi xa hơn.', ''],
		['soul-fine-robusta-vinh-du-dat-top-1-liberica-top-10-robusta-tai-sout', '2025-10-10', 'news', 'Soul Fine Robusta đạt Top 1 Liberica & Top 10 Robusta tại SEAGCC 2025', '03c-awards/web/award-photo-1.jpg', 'aw', 'Tại cuộc thi cà phê nhân xanh Đông Nam Á, Soul dẫn đầu hạng mục Liberica.', ''],
		['soul-fine-robusta-ban-sac-moi-tu-giong-ca-tr', '2025-09-24', 'news', 'Bản sắc mới từ giống cà TR', '03b-why-soul/web/why-fine-robusta.jpg', 'fr', 'Giống cà TR và những gì nó mở ra cho hương vị Robusta Việt Nam.', ''],
		['soul-fine-robusta-vinh-du-dat-top-1-top-7-20-tai-vietnam-coffee-pro', '2025-07-15', 'news,soul-achievements', 'Soul Fine Robusta đạt Top 1, 7 & 20 tại Vietnam Coffee Producer Competition 2025', '03c-awards/web/Top1Ro-Soulfine.jpg', 'aw,fr', 'Ba mẫu cà phê của Soul cùng góp mặt trên bảng xếp hạng nhà sản xuất cà phê Việt Nam 2025.', ''],
		['soul-fine-robusta-top-5-cuoc-thi-ca-phe-dac-san-viet-nam-vietnam-a', '2025-05-11', 'news,soul-achievements', 'Soul Fine Robusta lọt Top 5 Vietnam Amazing Cup 2025', '03c-awards/web/cert-CPDS2025.jpg', 'aw', 'Fine Robusta của Soul vào nhóm năm mẫu cao điểm nhất tại cuộc thi cà phê đặc sản Việt Nam.', ''],
		['mua-vu-ca-phe-new-crop-2025-nhung-cau-chuyen-moi-tu-hat-ca-quen-thu', '2025-05-08', 'news', 'Mùa vụ New Crop 2025: những câu chuyện mới từ hạt cà quen thuộc', '03-why-soul-album/SFR5.jpg', 'nc,fr', 'Mùa thu hoạch 2025 mang đến những lô Fine Robusta mới cùng những thử nghiệm sơ chế.', ''],
		['soul-fine-robusta-2025-issue-new-crop-25-journey', '2025-04-24', 'news,soul-megazine', "2025 Issue: New Crop'25 Journey", '03-why-soul-album/SFR6.jpg', 'nc,so', 'Ấn phẩm 2025 ghi lại hành trình mùa vụ, từ vườn cà Buôn Ma Thuột đến tách cà phê.', ''],
		['soul-recap-tasting-cupping-soul-fine-robusta-new-crop-24-25', '2025-03-21', 'news', 'Soul Recap: Tasting & Cupping New Crop 24/25', '03-why-soul-album/SFR7.jpg', 'nc,ev', 'Nhìn lại buổi thử nếm và cupping các lô Fine Robusta mùa vụ 24/25.', ''],
		['tri-thuc-trong-va-che-bien-ca-phe-dak-lak-chinh-thuc-duoc-ghi-danh-vao', '2025-03-12', 'news', 'Tri thức trồng và chế biến cà phê Đắk Lắk được ghi danh Di sản văn hóa phi vật thể quốc gia', '03-why-soul-album/IMG_3779.png', 'dl', 'Một cột mốc cho vùng đất cà phê: tri thức canh tác và chế biến của Đắk Lắk chính thức được công nhận.', ''],
		['khoi-dong-chuoi-workshop-fine-robusta-le-hoi-ca-phe-buon-ma-thuot-20', '2025-03-02', 'news', 'Khởi động chuỗi Workshop Fine Robusta tại Lễ hội Cà phê Buôn Ma Thuột 2025', '05-solutions/DSCF9134_edited.jpg', 'ev,fr', 'Chuỗi workshop chia sẻ về Fine Robusta, từ sơ chế đến pha chế, dành cho cộng đồng yêu cà phê.', ''],
		['soul-fine-robusta-dong-hanh-cung-le-hoi-ca-phe-buon-ma-thuot-2025', '2025-02-17', 'news', 'Soul Fine Robusta đồng hành cùng Lễ hội Cà phê Buôn Ma Thuột 2025', '06-spaces/Soul-BMT.jpg', 'ev,dl', 'Soul góp mặt tại lễ hội cà phê lớn nhất Tây Nguyên, nơi thương hiệu bắt đầu.', ''],
		['tong-ket-hanh-trinh-uom-hat-hy-vong-dong-hanh-cung-ba-con-tay-ngu', '2025-01-10', 'soul-achievements', 'Tổng kết hành trình “Ươm hạt hy vọng” cùng bà con Tây Nguyên', '03b-why-soul/web/why-fermentation.jpg', 'dl', 'Nhìn lại chặng đường đồng hành cùng bà con nông dân Tây Nguyên trong chương trình “Ươm hạt hy vọng”.', ''],
		['huong-dan-pha-espresso-chuan-soul', '2025-01-02', 'how-to-make-coffee', 'Hướng dẫn pha Espresso chuẩn Soul', '02-shop/Espresso.jpg', 'br', 'Thông số và các bước để chiết xuất một shot Fine Robusta cân bằng, đậm vị.', ''],
		['huong-dan-pha-pour-over-chuan-soul', '2025-01-02', 'how-to-make-coffee', 'Hướng dẫn pha Pour Over Fine Robusta chuẩn Soul', '02-shop/Filter.jpg', 'br,fr', 'Pour over giúp Fine Robusta bộc lộ sự sạch, ngọt và tầng hương rõ ràng.', ''],
		['huong-dan-pha-cold-brew-chuan-soul', '2025-01-02', 'how-to-make-coffee', 'Hướng dẫn pha Cold Brew chuẩn Soul', '02-shop/Items-Binh-ngam-Coldbrew-3.jpg', 'br', 'Ủ lạnh chậm rãi cho một ly cà phê mượt, ngọt và ít đắng.', ''],
		['wrapped-up-2024', '2024-12-31', 'news', 'Wrapped up 2024', '01-hero/SOUL2024_DSF8608_edited.jpg', 'fr', 'Một năm nhìn lại: những mùa vụ, giải thưởng và người bạn đồng hành của Soul.', ''],
		['issue-2024-it-s-the-holiday-season', '2024-12-24', 'soul-megazine', '2024 Issue: It’s the holiday season', '02-shop/CA-PHE-RANG.jpg', 'so', 'Ấn phẩm mùa lễ hội 2024 với những gợi ý quà tặng cà phê Việt.', ''],
		['bao-dak-lak-robusta-viet-nam-doi-moi-de-vuon-tam', '2024-09-20', 'soul-achievements', 'Báo Đắk Lắk: Robusta Việt Nam đổi mới để vươn tầm', '03c-awards/web/cert-CPDC2025.jpg', 'dl,fr', 'Báo Đắk Lắk viết về hành trình nâng chất Robusta Việt và vai trò của Soul.', ''],
		['hang-5-trong-top-10-60-mau-tu-6-quoc-gia-tai-seagcc', '2024-09-20', 'soul-achievements', 'Hạng 5 trong Top 10 trên 60 mẫu từ 6 quốc gia tại SEAGCC', '03c-awards/web/award-photo-2.jpg', 'aw', 'Fine Robusta của Soul xếp hạng 5 tại cuộc thi cà phê nhân xanh Đông Nam Á.', ''],
		['fundraising-edition', '2024-08-07', 'news', 'Fundraising Edition', '04-soulful/Soulful_Cover-ngang.jpg', 'so', 'Phiên bản đặc biệt gây quỹ, mỗi túi cà phê góp phần cho cộng đồng.', ''],
		['tam-hon-ly-ca-phe-ngon-bat-dau-tu-nhung-hat-giong-nho-be', '2024-05-06', 'soul-megazine', 'Tâm hồn ly cà phê ngon bắt đầu từ những hạt giống nhỏ bé', '02-shop/Nhan-xanh.jpg', 'fr', 'Câu chuyện về giống cây, vườn ươm và sự kiên nhẫn đằng sau một ly cà phê ngon.', ''],
		['mua-vu-ca-phe-new-crop-2024-soulful-fine-robusta-vietnam', '2024-04-10', 'news', 'Mùa vụ New Crop 2024 – Soulful Fine Robusta Vietnam', '03-why-soul-album/SFR4.jpg', 'nc,so', 'Mùa vụ 2024 và những dòng Soulful Fine Robusta đầu tiên của năm.', ''],
		['crafted-by-vietnamese-soul-made-with-vietnamese-ingredients-by-the', '2023-12-10', 'soul-megazine', 'Crafted by Vietnamese Soul', '02-featured/phin_finero.jpg', 'fr', 'Làm từ nguyên liệu Việt, bởi người Việt: tinh thần đứng sau mỗi sản phẩm Soul.', ''],
		['huong-dan-pha-mot-ca-phe-phin-chuan-soul', '2023-06-19', 'how-to-make-coffee', 'Hướng dẫn pha cà phê phin chuẩn Soul', '02-shop/Phin.jpg', 'br', 'Cách pha phin truyền thống với Fine Robusta: chậm, đậm và tròn vị.', ''],
		['soul-specialty-coffee-roastery-the-fine-robusta-vietnam-journey-from', '2023-05-20', 'soul-megazine', 'Soul Roastery: hành trình Fine Robusta từ local đến global', '05-solutions/1789033571781_bag-sewing.jpg', 'fr', 'Từ xưởng rang ở Buôn Ma Thuột, Fine Robusta Việt bắt đầu bước ra thế giới.', ''],
		['buon-ma-thuot-huong-cao-nguyen-con-mai-tham-duom-tren-doi-moi', '2023-04-15', 'soul-megazine', 'Buôn Ma Thuột – hương cao nguyên còn mãi thắm đượm trên đôi môi', '06-spaces/Soul-BMT.jpg', 'dl', 'Một lá thư tình gửi Buôn Ma Thuột, thủ phủ cà phê và quê nhà của Soul.', ''],
		['hanh-trinh-4-nam-theo-duoi-fine-robusta-ca-phe-dac-san-viet', '2022-08-10', 'soul-megazine', 'Hành trình 4 năm theo đuổi Fine Robusta – cà phê đặc sản Việt', '03-why-soul-album/SFR4.jpg', 'fr', 'Bốn năm đầu tiên của Soul: thử, sai và tin vào tiềm năng của Robusta Việt.', ''],
		['holiday-special-mua-ket-noi-mua-nhan-gui-yeu-thuong', '2022-12-24', 'news', 'Holiday Special: mùa kết nối, mùa nhận gửi yêu thương', '02-featured/premium_coffee_1st_thumbnail.jpg', 'so', 'Những hộp quà cà phê cho mùa lễ, để gửi trao yêu thương.', ''],
		['tuyen-dung-vi-tri-truong-cua-hang-soul-specialty-coffee', '2026-07-08', 'recruitment', 'Tuyển dụng: Store Manager – Cửa hàng trưởng', '06-spaces/Soul-HN.jpg', 'ca', 'Soul Specialty Coffee tìm Cửa hàng trưởng cho hệ thống cửa hàng trên toàn quốc.', 'sm'],
		['tuyen-dung-vi-tri-barista', '2026-07-08', 'recruitment', 'Tuyển dụng: Barista Full-time', '06-spaces/Soul-SG.jpg', 'ca', 'Gia nhập đội ngũ quầy bar Soul, nơi mỗi tách cà phê kể một câu chuyện Việt.', 'ba'],
	];

	kses_remove_filters();
	foreach ($posts as $row) {
		[$slug, $date, $cats, $title, $img, $tags, $excerpt, $body_key] = $row;
		$existing = get_page_by_path($slug, OBJECT, 'post');
		$content  = ($body_key !== '' && isset($bodies[$body_key])) ? $bodies[$body_key] : soul_blog_body_note();
		$postarr  = [
			'post_type'    => 'post',
			'post_status'  => 'publish',
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_excerpt' => $excerpt,
			'post_content' => $content,
			'post_date'    => $date . ' 10:00:00',
			'post_date_gmt'=> get_gmt_from_date($date . ' 10:00:00'),
		];
		if ($existing) {
			$postarr['ID'] = (int) $existing->ID;
			$id = wp_update_post($postarr, true);
		} else {
			$id = wp_insert_post($postarr, true);
		}
		if (is_wp_error($id) || ! $id) {
			continue;
		}
		$id = (int) $id;

		$cat_ids = [];
		foreach (explode(',', $cats) as $cslug) {
			$cslug = trim($cslug);
			if (isset($term_ids[$cslug])) {
				$cat_ids[] = $term_ids[$cslug];
			}
		}
		if ($cat_ids) {
			wp_set_post_terms($id, $cat_ids, 'category');
		}

		$tag_slugs = [];
		foreach (explode(',', $tags) as $tk) {
			$tk = trim($tk);
			if (isset($tag_map[$tk])) {
				$tag_slugs[] = $tag_map[$tk];
			}
		}
		if ($tag_slugs) {
			wp_set_post_terms($id, $tag_slugs, 'post_tag');
		}

		// Theme asset path until editor sets Featured Image (Upload / Media Library).
		update_post_meta($id, 'soul_cover_rel', $img);
	}
	kses_init_filters();

	$blog = get_page_by_path('blog');
	if (! $blog) {
		$blog_id = wp_insert_post([
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => 'Blog',
			'post_name'    => 'blog',
			'post_content' => '',
		]);
	} else {
		$blog_id = (int) $blog->ID;
	}
	if ($blog_id && ! is_wp_error($blog_id)) {
		update_option('page_for_posts', $blog_id);
	}

	flush_rewrite_rules(false);
	update_option('soul_seeded_blog_fidelity_v1', 1);
	update_option('soul_seeded_blog_fidelity_v2', 1);
}
