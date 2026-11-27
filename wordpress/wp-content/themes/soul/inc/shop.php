<?php
/**
 * Shop /products/ helpers — fidelity vs html/Shop.dc.html.
 *
 * @package Soul
 */

declare(strict_types=1);

/**
 * Default intros when term description is empty (SoT COLS).
 *
 * @return array<string, array{name:string,eyebrow:string,intro:string}>
 */
function soul_shop_collection_copy(): array {
	return [
		'all' => [
			'name'    => __('Tất cả sản phẩm', 'soul'),
			'eyebrow' => __('Soul Shop', 'soul'),
			'intro'   => __('Cà phê rang, nhân xanh, phụ kiện và quà tặng từ Soul, rang tại Buôn Ma Thuột.', 'soul'),
		],
		'ca-phe-rang' => [
			'name'    => __('Cà phê rang', 'soul'),
			'eyebrow' => __('Bộ sưu tập', 'soul'),
			'intro'   => __('Toàn bộ cà phê rang của Soul: bộ sưu tập mùa vụ, dòng nguyên bản, HORECA và cà phê cho từng cách pha.', 'soul'),
		],
		'soulful-flavours' => [
			'name'    => __('Soulful Collection 2026', 'soul'),
			'eyebrow' => __('Bộ sưu tập', 'soul'),
			'intro'   => __('Bộ sưu tập theo mùa: bốn cung bậc Ngọt, Nồng, Thơm, Cay từ những lô Fine Robusta và Specialty mùa vụ 25/26.', 'soul'),
		],
		'origin-collection' => [
			'name'    => __('Origin Collection', 'soul'),
			'eyebrow' => __('Bộ sưu tập', 'soul'),
			'intro'   => __('Những dòng cà phê nguyên bản của Soul: Fine Robusta Buôn Ma Thuột, Specialty Arabica và House Blend.', 'soul'),
		],
		'ca-phe-chat-luong-cao' => [
			'name'    => __('Horeca Collection', 'soul'),
			'eyebrow' => __('Bộ sưu tập', 'soul'),
			'intro'   => __('Dòng cà phê chất lượng cao, đóng gói 1 kg cho quán, nhà hàng và khách sạn.', 'soul'),
		],
		'ca-phe-pha-phin' => [
			'name'    => __('Cà phê pha phin', 'soul'),
			'eyebrow' => __('Bộ sưu tập', 'soul'),
			'intro'   => __('Rang cho phin: đậm, tròn và ngọt hậu, cho tách cà phê Việt quen thuộc.', 'soul'),
		],
		'ca-phe-pha-may' => [
			'name'    => __('Cà phê pha máy', 'soul'),
			'eyebrow' => __('Bộ sưu tập', 'soul'),
			'intro'   => __('Rang cho espresso: body dày, crema bền, cân bằng khi pha cùng sữa.', 'soul'),
		],
		'ca-phe-pha-dung-cu' => [
			'name'    => __('Cà phê pha dụng cụ', 'soul'),
			'eyebrow' => __('Bộ sưu tập', 'soul'),
			'intro'   => __('Rang sáng hơn cho pour over, để hương trái cây và độ ngọt rõ ràng.', 'soul'),
		],
		'ca-phe-u-lanh-cold-brew' => [
			'name'    => __('Cà phê ủ lạnh', 'soul'),
			'eyebrow' => __('Bộ sưu tập', 'soul'),
			'intro'   => __('Rang riêng cho ủ lạnh: mượt, ngọt và ít đắng.', 'soul'),
		],
		'ca-phe-nuoc-ngoai' => [
			'name'    => __('Cà phê nước ngoài (Arabica)', 'soul'),
			'eyebrow' => __('Bộ sưu tập', 'soul'),
			'intro'   => __('Những lô Arabica đặc sản chọn lọc từ Kenya, Colombia, Nicaragua và Ethiopia, rang bởi Soul.', 'soul'),
		],
		'phu-kien' => [
			'name'    => __('Phụ kiện', 'soul'),
			'eyebrow' => __('Bộ sưu tập', 'soul'),
			'intro'   => __('Phin, ly gốm, trà và cacao Việt để hoàn thiện góc cà phê của bạn.', 'soul'),
		],
		'hop-qua-combo' => [
			'name'    => __('Hộp quà combo', 'soul'),
			'eyebrow' => __('Bộ sưu tập', 'soul'),
			'intro'   => __('Hộp quà 2 món và 4 món kết hợp cà phê, phin và đặc sản Việt.', 'soul'),
		],
		'ca-phe-nhan-xanh' => [
			'name'    => __('Cà phê nhân xanh', 'soul'),
			'eyebrow' => __('Bộ sưu tập', 'soul'),
			'intro'   => __('Nhân xanh Fine Robusta, Robusta, Arabica và Liberica cho nhà rang. Mẫu 1 kg, 5 kg; trên 60 kg liên hệ báo giá.', 'soul'),
		],
		'fine-robusta' => [
			'name'    => __('Fine Robusta', 'soul'),
			'eyebrow' => __('Bộ sưu tập', 'soul'),
			'intro'   => __('Nhân xanh Fine Robusta TR từ Buôn Ma Thuột, sơ chế và lên men theo từng lô.', 'soul'),
		],
		'high-quality-robusta' => [
			'name'    => __('High Quality Robusta', 'soul'),
			'eyebrow' => __('Bộ sưu tập', 'soul'),
			'intro'   => __('Nhân xanh Robusta chất lượng cao cho nhà rang và sản xuất quy mô.', 'soul'),
		],
		'specialty-arabica' => [
			'name'    => __('Specialty Arabica', 'soul'),
			'eyebrow' => __('Bộ sưu tập', 'soul'),
			'intro'   => __('Nhân xanh Arabica đặc sản từ Cầu Đất, Lâm Đồng.', 'soul'),
		],
		'high-quality-arabica' => [
			'name'    => __('High Quality Arabica', 'soul'),
			'eyebrow' => __('Bộ sưu tập', 'soul'),
			'intro'   => __('Nhân xanh Arabica chất lượng cao. Danh sách lô đang được cập nhật.', 'soul'),
		],
		'liberica' => [
			'name'    => __('Liberica', 'soul'),
			'eyebrow' => __('Bộ sưu tập', 'soul'),
			'intro'   => __('Nhân xanh Liberica từ M’Drăk, Đắk Lắk.', 'soul'),
		],
		'san-pham-noi-bat' => [
			'name'    => __('Sản phẩm nổi bật', 'soul'),
			'eyebrow' => __('Bộ sưu tập', 'soul'),
			'intro'   => __('Những sản phẩm được yêu thích nhất của Soul.', 'soul'),
		],
		'san-pham-moi' => [
			'name'    => __('Sản phẩm mới', 'soul'),
			'eyebrow' => __('Bộ sưu tập', 'soul'),
			'intro'   => __('Mới nhất từ xưởng rang và mùa vụ 25/26.', 'soul'),
		],
	];
}

/**
 * Sidebar nav groups (SoT: Cửa hàng / Danh mục / Chọn lọc).
 * depth 0 = root, 1 = indented child.
 *
 * @return list<array{title:string,items:list<array{slug:?string,label:string,depth:int,count:int,url:string,current:bool}>}>
 */
function soul_shop_nav_groups(): array {
	$shop = get_post_type_archive_link('soul_product') ?: home_url('/products/');
	$current = is_tax('soul_collection') ? (string) get_queried_object()->slug : 'all';
	$copy = soul_shop_collection_copy();

	$tree = [
		[
			'title' => __('Cửa hàng', 'soul'),
			'items' => [
				['slug' => null, 'depth' => 0],
			],
		],
		[
			'title' => __('Danh mục', 'soul'),
			'items' => [
				['slug' => 'ca-phe-rang', 'depth' => 0],
				['slug' => 'soulful-flavours', 'depth' => 1],
				['slug' => 'origin-collection', 'depth' => 1],
				['slug' => 'ca-phe-chat-luong-cao', 'depth' => 1],
				['slug' => 'ca-phe-pha-phin', 'depth' => 1],
				['slug' => 'ca-phe-pha-may', 'depth' => 1],
				['slug' => 'ca-phe-pha-dung-cu', 'depth' => 1],
				['slug' => 'ca-phe-u-lanh-cold-brew', 'depth' => 1],
				['slug' => 'ca-phe-nuoc-ngoai', 'depth' => 1],
				['slug' => 'phu-kien', 'depth' => 0],
				['slug' => 'hop-qua-combo', 'depth' => 0],
				['slug' => 'ca-phe-nhan-xanh', 'depth' => 0],
				['slug' => 'fine-robusta', 'depth' => 1],
				['slug' => 'high-quality-robusta', 'depth' => 1],
				['slug' => 'specialty-arabica', 'depth' => 1],
				['slug' => 'high-quality-arabica', 'depth' => 1],
				['slug' => 'liberica', 'depth' => 1],
			],
		],
		// SoT groups = [0,1] only — curated (san-pham-noi-bat / moi) hidden from aside.
	];

	$out = [];
	foreach ($tree as $group) {
		$items = [];
		foreach ($group['items'] as $row) {
			$slug = $row['slug'];
			if ($slug === null) {
				$count = (int) wp_count_posts('soul_product')->publish;
				$items[] = [
					'slug'    => 'all',
					'label'   => $copy['all']['name'],
					'depth'   => 0,
					'count'   => $count,
					'url'     => $shop,
					'current' => $current === 'all',
				];
				continue;
			}
			$term = get_term_by('slug', $slug, 'soul_collection');
			if (! $term || is_wp_error($term)) {
				continue;
			}
			$label = $copy[ $slug ]['name'] ?? $term->name;
			$items[] = [
				'slug'    => $slug,
				'label'   => $label,
				'depth'   => (int) $row['depth'],
				'count'   => (int) $term->count,
				'url'     => get_term_link($term),
				'current' => $current === $slug,
			];
		}
		if ($items) {
			$out[] = [
				'title' => $group['title'],
				'items' => $items,
			];
		}
	}
	return $out;
}

/**
 * Hero copy for current archive / collection view.
 *
 * @return array{name:string,eyebrow:string,intro:string,note:string,note_cta:string}
 */
function soul_shop_hero_context(): array {
	$copy = soul_shop_collection_copy();
	$note = '';
	$cta  = '';

	if (is_tax('soul_collection')) {
		$term = get_queried_object();
		$slug = $term instanceof WP_Term ? $term->slug : 'all';
		$base = $copy[ $slug ] ?? [
			'name'    => $term instanceof WP_Term ? $term->name : __('Sản phẩm', 'soul'),
			'eyebrow' => __('Bộ sưu tập', 'soul'),
			'intro'   => '',
		];
		$desc = $term instanceof WP_Term ? trim(wp_strip_all_tags(term_description($term))) : '';
		$intro = $desc !== '' ? $desc : $base['intro'];

		// SoT: note only when collection id is exact.
		if ($slug === 'ca-phe-nhan-xanh') {
			$note = __('Giá nhân xanh chưa gồm 5% VAT. Mẫu 1 kg / 5 kg; trên 60 kg vui lòng liên hệ để nhận báo giá.', 'soul');
			$cta  = __('Liên hệ báo giá', 'soul');
		} elseif ($slug === 'ca-phe-chat-luong-cao') {
			$note = __('Dòng HORECA đóng gói 1 kg. Đối tác quán, nhà hàng, khách sạn liên hệ để nhận giá sỉ và hỗ trợ setup.', 'soul');
			$cta  = __('Liên hệ báo giá', 'soul');
		}

		return [
			'name'     => $base['name'],
			'eyebrow'  => $base['eyebrow'],
			'intro'    => $intro,
			'note'     => $note,
			'note_cta' => $cta,
		];
	}

	return [
		'name'     => $copy['all']['name'],
		'eyebrow'  => $copy['all']['eyebrow'],
		'intro'    => $copy['all']['intro'],
		'note'     => '',
		'note_cta' => '',
	];
}

/**
 * Internal kind code (SoT KIND keys): sf|rs|ho|nn|gb|pk|cmb.
 */
function soul_shop_product_kind_code(int $post_id): string {
	$slugs = wp_list_pluck(get_the_terms($post_id, 'soul_collection') ?: [], 'slug');
	if (array_intersect($slugs, ['ca-phe-nhan-xanh', 'fine-robusta', 'high-quality-robusta', 'specialty-arabica', 'high-quality-arabica', 'liberica'])) {
		return 'gb';
	}
	if (in_array('soulful-flavours', $slugs, true)) {
		return 'sf';
	}
	if (in_array('ca-phe-chat-luong-cao', $slugs, true)) {
		return 'ho';
	}
	if (in_array('ca-phe-nuoc-ngoai', $slugs, true)) {
		return 'nn';
	}
	if (in_array('hop-qua-combo', $slugs, true)) {
		return 'cmb';
	}
	if (in_array('phu-kien', $slugs, true)) {
		return 'pk';
	}
	return 'rs';
}

/**
 * Kind label for product card (SoT KIND).
 */
function soul_shop_product_kind(int $post_id): string {
	$map = [
		'sf'  => __('Soulful 2026', 'soul'),
		'rs'  => __('Cà phê rang', 'soul'),
		'ho'  => __('HORECA · 1 kg', 'soul'),
		'nn'  => __('Cà phê nước ngoài', 'soul'),
		'gb'  => __('Nhân xanh', 'soul'),
		'pk'  => __('Phụ kiện', 'soul'),
		'cmb' => __('Hộp quà', 'soul'),
	];
	$code = soul_shop_product_kind_code($post_id);
	return $map[ $code ] ?? __('Cà phê rang', 'soul');
}

/**
 * Status badge for card/PDP (SoT badge()) — not commerce meta badge.
 *
 * @return array{0:string,1:string,2:string}|null [label, bg, fg]
 */
function soul_shop_product_badge(int $post_id): ?array {
	$meta  = soul_get_product_meta($post_id);
	$slugs = wp_list_pluck(get_the_terms($post_id, 'soul_collection') ?: [], 'slug');
	if (! $meta['in_stock']) {
		return [__('Hết hàng', 'soul'), '#27292D', '#F4EFE5'];
	}
	$b = mb_strtolower($meta['badge']);
	// New crop flag (SoT flags 'n').
	if (str_contains($b, 'new crop') || str_contains($b, 'mùa vụ mới') || str_contains($b, '25/26')) {
		return [__('New crop 25/26', 'soul'), '#FFD35B', '#27292D'];
	}
	// Best seller flag (SoT flags 'b').
	if (str_contains($b, 'best')) {
		return [__('Best Seller', 'soul'), '#8E4B33', '#F4EFE5'];
	}
	// Membership in san-pham-moi (SoT).
	if (in_array('san-pham-moi', $slugs, true)) {
		return [__('Mới', 'soul'), '#F4EFE5', '#27292D'];
	}
	return null;
}

/**
 * Gutenberg paragraph blocks for PDP story (pattern soul/product-story).
 *
 * @param list<string> $paras
 */
function soul_shop_story_blocks(array $paras): string {
	$out = '';
	foreach ($paras as $p) {
		$p = trim((string) $p);
		if ($p === '') {
			continue;
		}
		$out .= '<!-- wp:paragraph {"className":"s-shop-story__p"} -->' . "\n";
		$out .= '<p class="s-shop-story__p">' . esc_html($p) . '</p>' . "\n";
		$out .= '<!-- /wp:paragraph -->' . "\n\n";
	}
	return trim($out);
}

/**
 * Parse meta_chain "A · B · C · D" into labeled rows.
 *
 * @return list<array{0:string,1:string}>
 */
function soul_shop_parse_meta_chain(string $chain): array {
	$parts = array_values(array_filter(array_map('trim', explode('·', $chain))));
	$facts = [];
	if (count($parts) >= 4) {
		$roast   = preg_replace('/^Rang\s+/iu', '', $parts[3]) ?: $parts[3];
		$facts[] = [__('Vùng trồng', 'soul'), $parts[0]];
		$facts[] = [__('Giống', 'soul'), $parts[1]];
		$facts[] = [__('Sơ chế', 'soul'), $parts[2]];
		$facts[] = [__('Mức rang', 'soul'), mb_strtoupper(mb_substr($roast, 0, 1)) . mb_substr($roast, 1)];
	} elseif (count($parts) === 3) {
		$facts[] = [__('Vùng trồng', 'soul'), $parts[0]];
		$facts[] = [__('Giống', 'soul'), $parts[1]];
		$facts[] = [__('Sơ chế', 'soul'), $parts[2]];
	} elseif (count($parts) === 2) {
		$facts[] = [__('Vùng trồng', 'soul'), $parts[0]];
		$facts[] = [__('Sơ chế', 'soul'), $parts[1]];
	} elseif (count($parts) === 1) {
		$facts[] = [__('Nguồn gốc', 'soul'), $parts[0]];
	}
	return $facts;
}

/**
 * Compact product facts for quick-add picker (brew + meta chain + notes).
 *
 * @return array{brew:?string,facts:list<array{0:string,1:string}>}
 */
function soul_shop_product_pick_info(int $post_id): array {
	$meta  = soul_get_product_meta($post_id);
	$slugs = wp_list_pluck(get_the_terms($post_id, 'soul_collection') ?: [], 'slug');
	$brew_map = [
		'ca-phe-pha-may'          => __('Pha máy', 'soul'),
		'ca-phe-pha-phin'         => __('Pha phin', 'soul'),
		'ca-phe-pha-dung-cu'      => __('Pha dụng cụ', 'soul'),
		'ca-phe-u-lanh-cold-brew' => __('Cold brew', 'soul'),
	];
	$brew = null;
	foreach ($brew_map as $slug => $label) {
		if (in_array($slug, $slugs, true)) {
			$brew = $label;
			break;
		}
	}
	if (! $brew && $meta['badge'] !== '') {
		$b = $meta['badge'];
		if (preg_match('/^pha\s/iu', $b) || stripos($b, 'Cold') !== false) {
			$brew = $b;
		}
	}

	$facts = soul_shop_parse_meta_chain($meta['meta_chain']);
	if ($meta['notes'] !== '') {
		$facts[] = [__('Hương vị', 'soul'), $meta['notes']];
	}

	return [
		'brew'  => $brew,
		'facts' => $facts,
	];
}

/**
 * PDP specs list (SoT pd.specs) — structured rows for front.
 *
 * @return list<array{0:string,1:string}>
 */
function soul_shop_product_specs(int $post_id): array {
	$meta = soul_get_product_meta($post_id);
	$code = soul_shop_product_kind_code($post_id);
	$kind = soul_shop_product_kind($post_id);
	$is_cof = in_array($code, ['sf', 'rs', 'ho', 'nn', 'gb'], true);

	$specs = [
		[__('Loại', 'soul'), $kind],
	];
	foreach (soul_shop_parse_meta_chain($meta['meta_chain']) as $row) {
		$specs[] = $row;
	}
	if ($is_cof) {
		$specs[] = [__('Độ cao vùng trồng', 'soul'), __('Đang cập nhật', 'soul')];
		$specs[] = [__('Mùa vụ', 'soul'), '25/26'];
	}
	if ($meta['notes'] !== '') {
		$specs[] = [__('Hương vị', 'soul'), $meta['notes']];
	}
	if ($is_cof && $code !== 'nn') {
		$specs[] = [__('Farmer / Nhà sản xuất', 'soul'), 'Soul Fine Robusta'];
	}
	return $specs;
}

/**
 * Quick-add / PDP option groups (SoT opts()).
 *
 * @return list<array{id:string,label:string,values:list<array{0:string,1:string,2:float}>}>
 */
function soul_shop_product_opts(int $post_id): array {
	$code = soul_shop_product_kind_code($post_id);
	if ($code === 'gb') {
		return [
			[
				'id'     => 'w',
				'label'  => __('Quy cách', 'soul'),
				'values' => [
					['1', '1 kg', 1.0],
					['5', '5 kg', 5.0],
					['60', __('> 60 kg · liên hệ báo giá', 'soul'), 0.0],
				],
			],
		];
	}
	if (in_array($code, ['sf', 'rs', 'nn'], true)) {
		return [
			[
				'id'     => 'w',
				'label'  => __('Trọng lượng', 'soul'),
				'values' => [
					['200', '200 g', 1.0],
					['500', '500 g', 2.3],
				],
			],
			[
				'id'     => 'g',
				'label'  => __('Phân loại', 'soul'),
				'values' => [
					['whole', __('Nguyên hạt', 'soul'), 1.0],
					['ground', __('Xay sẵn', 'soul'), 1.0],
				],
			],
		];
	}
	return [];
}

/**
 * Round price like SoT: Math.round(price * mult / 5000) * 5000.
 */
function soul_shop_round_price(int $base, float $mult): int {
	return (int) (round(($base * $mult) / 5000) * 5000);
}

/** Archive search + 12 per page (SoT PER). */
add_action('pre_get_posts', static function (WP_Query $q): void {
	if (is_admin() || ! $q->is_main_query()) {
		return;
	}
	if (! $q->is_post_type_archive('soul_product') && ! $q->is_tax('soul_collection')) {
		return;
	}
	$q->set('posts_per_page', 12);
	$s = isset($_GET['q']) ? sanitize_text_field(wp_unslash((string) $_GET['q'])) : '';
	if ($s !== '') {
		$q->set('s', $s);
	}
}, 5);
