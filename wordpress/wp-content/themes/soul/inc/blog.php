<?php
/**
 * Blog helpers — listing + single vs html/Blog.dc.html.
 *
 * @package Soul
 */

declare(strict_types=1);

/** @return list<array{slug:string,name:string,intro:string}> */
function soul_blog_categories_sot(): array {
	return [
		['slug' => 'news', 'name' => 'Tin tức', 'intro' => 'Tin mới nhất từ Soul: mùa vụ, giải thưởng, sự kiện và những dòng cà phê đặc sản vừa về.'],
		['slug' => 'soul-megazine', 'name' => 'Soul Megazine', 'intro' => 'Ấn phẩm thường niên và những bài viết dài về con người, vùng đất và hành trình Fine Robusta.'],
		['slug' => 'how-to-make-coffee', 'name' => 'Hướng dẫn pha', 'intro' => 'Công thức pha chuẩn Soul cho từng dụng cụ: phin, pour over, espresso, cold brew và túi lọc.'],
		['slug' => 'recruitment', 'name' => 'Tuyển dụng', 'intro' => 'Cùng Soul mang cà phê Việt đến gần hơn với mọi người. Các vị trí đang mở tại hệ thống cửa hàng.'],
		['slug' => 'soul-achievements', 'name' => 'Thành tựu', 'intro' => 'Giải thưởng, chứng nhận và những cột mốc Soul cùng bà con nông dân đạt được.'],
	];
}

function soul_blog_url(): string {
	return (string) (get_permalink((int) get_option('page_for_posts')) ?: home_url('/blog/'));
}

function soul_blog_date(string $ymd_or_mysql): string {
	$ts = strtotime($ymd_or_mysql);
	if (! $ts) {
		return $ymd_or_mysql;
	}
	return gmdate('d.m.Y', $ts);
}

/** @return list<string> */
function soul_blog_job_stores(): array {
	return ['Bà Nà Hills', 'Buôn Ma Thuột', 'Hà Nội', 'Đà Nẵng', 'Sài Gòn'];
}

/**
 * Primary category for a post (prefer SoT order).
 */
function soul_blog_primary_cat(int $post_id): ?\WP_Term {
	$terms = get_the_category($post_id);
	if (! $terms) {
		return null;
	}
	$order = array_column(soul_blog_categories_sot(), 'slug');
	usort(
		$terms,
		static function (\WP_Term $a, \WP_Term $b) use ($order): int {
			$ia = array_search($a->slug, $order, true);
			$ib = array_search($b->slug, $order, true);
			$ia = $ia === false ? 99 : $ia;
			$ib = $ib === false ? 99 : $ib;
			return $ia <=> $ib;
		}
	);
	return $terms[0];
}

/**
 * @return array{title:string,excerpt:string,img:string,date:string,cat:string,cat_url:string,url:string}
 */
function soul_blog_card(int $post_id, ?string $force_cat_slug = null): array {
	$cat = null;
	if ($force_cat_slug) {
		$t = get_term_by('slug', $force_cat_slug, 'category');
		$cat = $t instanceof \WP_Term ? $t : null;
	}
	if (! $cat) {
		$cat = soul_blog_primary_cat($post_id);
	}
	$img = get_the_post_thumbnail_url($post_id, 'large') ?: '';
	if ($img === '') {
		$rel = (string) get_post_meta($post_id, 'soul_cover_rel', true);
		if ($rel !== '' && function_exists('soul_img')) {
			$img = soul_img($rel);
		}
	}
	return [
		'title'   => get_the_title($post_id),
		'excerpt' => get_the_excerpt($post_id),
		'img'     => $img,
		'date'    => soul_blog_date((string) get_post_field('post_date', $post_id)),
		'cat'     => $cat ? $cat->name : '',
		'cat_url' => $cat ? get_category_link($cat) : soul_blog_url(),
		'url'     => (string) get_permalink($post_id),
	];
}

/**
 * Listing context for home / category / tag.
 *
 * @return array{
 *   q:string,page:int,pages:int,total:int,rest_total:int,
 *   is_jobs:bool,is_empty:bool,has_featured:bool,has_pages:bool,
 *   title:string,intro:string,eyebrow:string,crumb:string,has_sub_crumb:bool,
 *   grid_label:string,page_label:string,
 *   cats:list<array{label:string,count:int,url:string,active:bool}>,
 *   featured:?array,grid:list<array>,jobs:list<array>
 * }
 */
function soul_blog_listing_context(): array {
	$per     = 9;
	$page    = max(1, (int) get_query_var('paged') ?: (int) get_query_var('page') ?: 1);
	$q       = sanitize_text_field(wp_unslash($_GET['q'] ?? ''));
	$blog    = soul_blog_url();
	$ctx_slug = is_category() ? (string) get_queried_object()->slug : '';
	$tag_slug = is_tag() ? (string) get_queried_object()->slug : '';

	$args = [
		'post_type'              => 'post',
		'post_status'            => 'publish',
		'posts_per_page'         => -1,
		'orderby'                => 'date',
		'order'                  => 'DESC',
		'ignore_sticky_posts'    => true,
		'no_found_rows'          => true,
		'update_post_meta_cache' => true,
		'update_post_term_cache' => true,
	];
	if ($ctx_slug !== '') {
		$args['category_name'] = $ctx_slug;
	}
	if ($tag_slug !== '') {
		$args['tag'] = $tag_slug;
	}
	if ($q !== '') {
		$args['s'] = $q;
	}

	$query = new WP_Query($args);
	$ids   = wp_list_pluck($query->posts, 'ID');
	wp_reset_postdata();

	$is_jobs = $ctx_slug === 'recruitment' && $q === '';
	$featured_id = null;
	$rest_ids    = $ids;

	if (! $is_jobs && $q === '' && count($ids) > 3) {
		$featured_id = (int) $ids[0];
		$rest_ids    = array_slice($ids, 1);
	}

	$rest_total = count($rest_ids);
	$pages      = max(1, (int) ceil($rest_total / $per));
	$page       = min($page, $pages);
	$slice      = array_slice($rest_ids, ($page - 1) * $per, $per);

	$sot_cats = soul_blog_categories_sot();
	$all_count = (int) wp_count_posts('post')->publish;
	$cats = [
		[
			'label'  => __('Tất cả', 'soul'),
			'count'  => $all_count,
			'url'    => $blog,
			'active' => ! is_category() && ! is_tag(),
		],
	];
	foreach ($sot_cats as $row) {
		$term = get_term_by('slug', $row['slug'], 'category');
		$count = $term instanceof \WP_Term ? (int) $term->count : 0;
		$cats[] = [
			'label'  => $term instanceof \WP_Term ? $term->name : $row['name'],
			'count'  => $count,
			'url'    => $term instanceof \WP_Term ? get_category_link($term) : $blog,
			'active' => is_category($row['slug']),
		];
	}

	$title   = __('Câu chuyện từ Soul', 'soul');
	$intro   = __('Mùa vụ, giải thưởng, công thức pha và những người làm nên Fine Robusta Việt Nam, kể từ Buôn Ma Thuột.', 'soul');
	$eyebrow = __('Soul Journal', 'soul');
	$crumb   = 'Blog';
	$has_sub = false;

	if (is_category()) {
		$term    = get_queried_object();
		$title   = $term instanceof \WP_Term ? $term->name : $title;
		$crumb   = $title;
		$has_sub = true;
		$desc    = $term instanceof \WP_Term ? term_description($term) : '';
		$intro   = $desc !== '' ? wp_strip_all_tags($desc) : $intro;
		foreach ($sot_cats as $row) {
			if ($row['slug'] === $ctx_slug) {
				if ($intro === '' || $desc === '') {
					$intro = $row['intro'];
				}
				break;
			}
		}
	} elseif (is_tag()) {
		$term    = get_queried_object();
		$title   = '#' . ($term instanceof \WP_Term ? $term->slug : $tag_slug);
		$crumb   = $title;
		$has_sub = true;
		$eyebrow = __('Bài viết gắn thẻ', 'soul');
		$intro   = __('Tất cả bài viết có chung chủ đề này, từ mọi chuyên mục.', 'soul');
	}

	$featured = null;
	if ($featured_id && $page === 1) {
		$featured = soul_blog_card($featured_id, $ctx_slug !== '' ? $ctx_slug : null);
	}

	$grid = [];
	foreach ($slice as $pid) {
		$grid[] = soul_blog_card((int) $pid, $ctx_slug !== '' ? $ctx_slug : null);
	}

	$jobs = [];
	if ($is_jobs) {
		$where = implode(' · ', soul_blog_job_stores());
		foreach ($ids as $pid) {
			$c = soul_blog_card((int) $pid, 'recruitment');
			$role = preg_replace('/^(Tuyển dụng|Hiring):\s*/u', '', $c['title']) ?: $c['title'];
			$jobs[] = [
				'role'  => $role,
				'type'  => __('Toàn thời gian', 'soul'),
				'where' => $where,
				'date'  => $c['date'],
				'url'   => $c['url'],
			];
		}
	}

	$pad = static fn(int $n): string => str_pad((string) $n, 2, '0', STR_PAD_LEFT);

	return [
		'q'             => $q,
		'page'          => $page,
		'pages'         => $pages,
		'total'         => count($ids),
		'rest_total'    => $rest_total,
		'is_jobs'       => $is_jobs,
		'is_empty'      => count($ids) === 0,
		'has_featured'  => $featured !== null,
		'has_pages'     => ! $is_jobs && $pages > 1,
		'title'         => $title,
		'intro'         => $intro,
		'eyebrow'       => $eyebrow,
		'crumb'         => $crumb,
		'has_sub_crumb' => $has_sub,
		'grid_label'    => count($ids) . ' ' . __('bài viết', 'soul'),
		'page_label'    => __('Trang', 'soul') . ' ' . $pad($page) . ' / ' . $pad($pages),
		'cats'          => $cats,
		'featured'      => $featured,
		'grid'          => $grid,
		'jobs'          => $jobs,
		'blog_url'      => $blog,
	];
}

/**
 * Extract H2 headings from post content for TOC.
 *
 * @return list<array{n:string,text:string,id:string}>
 */
function soul_blog_toc(string $content): array {
	if ($content === '' || ! preg_match_all('/<h2\b[^>]*>(.*?)<\/h2>/is', $content, $m)) {
		return [];
	}
	$out = [];
	foreach ($m[1] as $i => $html) {
		$text = trim(wp_strip_all_tags($html));
		if ($text === '') {
			continue;
		}
		$id = 's' . ($i + 1);
		if (preg_match('/\bid=["\']([^"\']+)["\']/', $m[0][$i], $im)) {
			$id = $im[1];
		}
		$out[] = [
			'n'    => str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT),
			'text' => $text,
			'id'   => $id,
		];
	}
	return $out;
}

/** Estimated minutes to read. */
function soul_blog_mins(string $content, string $excerpt = ''): int {
	$words = str_word_count(wp_strip_all_tags($excerpt . ' ' . $content));
	return max(1, (int) round($words / 200));
}

/**
 * Prev / next within primary category (older ← / newer →).
 *
 * @return list<array{label:string,title:string,url:string,align:string}>
 */
function soul_blog_adjacent(int $post_id): array {
	$cat = soul_blog_primary_cat($post_id);
	if (! $cat) {
		return [];
	}
	$q = new WP_Query([
		'post_type'              => 'post',
		'posts_per_page'         => -1,
		'category_name'          => $cat->slug,
		'orderby'                => 'date',
		'order'                  => 'DESC',
		'fields'                 => 'ids',
		'no_found_rows'          => true,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false,
	]);
	$ids = $q->posts;
	$idx = array_search($post_id, $ids, true);
	if ($idx === false) {
		return [];
	}
	$out = [];
	// Older = next in DESC list (higher index).
	if (isset($ids[$idx + 1])) {
		$out[] = [
			'label' => __('← Bài trước', 'soul'),
			'title' => get_the_title((int) $ids[$idx + 1]),
			'url'   => (string) get_permalink((int) $ids[$idx + 1]),
			'align' => 'left',
		];
	}
	if ($idx > 0) {
		$out[] = [
			'label' => __('Bài sau →', 'soul'),
			'title' => get_the_title((int) $ids[$idx - 1]),
			'url'   => (string) get_permalink((int) $ids[$idx - 1]),
			'align' => 'right',
		];
	}
	return $out;
}

/**
 * @return list<array{title:string,excerpt:string,img:string,date:string,cat:string,cat_url:string,url:string}>
 */
function soul_blog_related(int $post_id, int $limit = 3): array {
	$cat = soul_blog_primary_cat($post_id);
	$ids = [];
	if ($cat) {
		$q = new WP_Query([
			'post_type'      => 'post',
			'posts_per_page' => $limit,
			'post__not_in'   => [$post_id],
			'category_name'  => $cat->slug,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'fields'         => 'ids',
		]);
		$ids = $q->posts;
	}
	if (count($ids) < $limit) {
		$tags = wp_get_post_tags($post_id, ['fields' => 'ids']);
		if ($tags) {
			$q2 = new WP_Query([
				'post_type'      => 'post',
				'posts_per_page' => $limit - count($ids),
				'post__not_in'   => array_merge([$post_id], $ids),
				'tag__in'        => $tags,
				'fields'         => 'ids',
			]);
			$ids = array_merge($ids, $q2->posts);
		}
	}
	$out = [];
	foreach (array_slice($ids, 0, $limit) as $pid) {
		$out[] = soul_blog_card((int) $pid, $cat ? $cat->slug : null);
	}
	return $out;
}

/** Ensure H2 in content have ids for TOC anchors. */
add_filter('the_content', static function (string $content): string {
	if (! is_singular('post') || $content === '') {
		return $content;
	}
	$n = 0;
	return (string) preg_replace_callback(
		'/<h2(\b[^>]*)>(.*?)<\/h2>/is',
		static function (array $m) use (&$n): string {
			++$n;
			$attrs = $m[1];
			if (preg_match('/\bid=/i', $attrs)) {
				return $m[0];
			}
			return '<h2' . $attrs . ' id="s' . $n . '">' . $m[2] . '</h2>';
		},
		$content
	);
}, 12);
