<?php
/**
 * Blog listing — fidelity vs html/Blog.dc.html (list view).
 *
 * @package Soul
 */
get_header();

$ctx  = soul_blog_listing_context();
$home = home_url('/');
$base = $ctx['blog_url'];
if (is_category() || is_tag()) {
	$base = get_term_link(get_queried_object());
	if (is_wp_error($base)) {
		$base = $ctx['blog_url'];
	}
}
$page_link = static function (int $n) use ($base): string {
	if ($n <= 1) {
		$url = $base;
	} else {
		$url = trailingslashit($base) . 'page/' . $n . '/';
	}
	$q = sanitize_text_field(wp_unslash($_GET['q'] ?? ''));
	if ($q !== '') {
		$url = add_query_arg('q', $q, $url);
	}
	return $url;
};
?>
<main class="s-blog">
	<section class="s-blog-hero" id="top" data-section="blog-hero" aria-labelledby="bl-h">
		<nav class="s-blog-crumb" aria-label="<?php esc_attr_e('Breadcrumb', 'soul'); ?>">
			<a href="<?php echo esc_url($home); ?>"><?php esc_html_e('Trang chủ', 'soul'); ?></a>
			<span class="s-blog-crumb__sep" aria-hidden="true">/</span>
			<?php if ($ctx['has_sub_crumb']) : ?>
				<a href="<?php echo esc_url($ctx['blog_url']); ?>">Blog</a>
				<span class="s-blog-crumb__sep" aria-hidden="true">/</span>
			<?php endif; ?>
			<span class="s-blog-crumb__cur"><?php echo esc_html($ctx['crumb']); ?></span>
		</nav>
		<div class="s-blog-hero__grid">
			<div>
				<p class="s-blog-eye"><?php echo esc_html($ctx['eyebrow']); ?></p>
				<h1 class="s-blog-hero__title" id="bl-h"><?php echo esc_html($ctx['title']); ?></h1>
			</div>
			<p class="s-blog-hero__intro"><?php echo esc_html($ctx['intro']); ?></p>
		</div>
		<div class="s-blog-hero__tools">
			<div class="s-blog-tabs" role="tablist" aria-label="<?php esc_attr_e('Chuyên mục', 'soul'); ?>">
				<?php foreach ($ctx['cats'] as $c) : ?>
					<a class="s-blog-tab<?php echo $c['active'] ? ' is-on' : ''; ?>" href="<?php echo esc_url($c['url']); ?>" role="tab" aria-selected="<?php echo $c['active'] ? 'true' : 'false'; ?>">
						<?php echo esc_html($c['label']); ?>
						<span class="s-blog-tab__n"><?php echo esc_html((string) $c['count']); ?></span>
					</a>
				<?php endforeach; ?>
			</div>
			<form class="s-blog-search" role="search" method="get" action="<?php echo esc_url(is_category() || is_tag() ? (string) $base : $ctx['blog_url']); ?>">
				<span class="s-blog-search__ico" aria-hidden="true">
					<svg width="15" height="15" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="7" cy="7" r="5"></circle><path d="M11 11l4 4"></path></svg>
				</span>
				<label class="screen-reader-text" for="s-blog-q"><?php esc_html_e('Tìm bài viết', 'soul'); ?></label>
				<input class="s-blog-search__input" id="s-blog-q" type="search" name="q" value="<?php echo esc_attr($ctx['q']); ?>" placeholder="<?php esc_attr_e('Tìm bài viết', 'soul'); ?>" />
			</form>
		</div>
	</section>

	<?php if ($ctx['has_featured'] && $ctx['featured']) :
		$f = $ctx['featured'];
		?>
		<section class="s-blog-feat" data-section="blog-featured" aria-label="<?php esc_attr_e('Bài nổi bật', 'soul'); ?>">
			<article class="s-blog-feat__card">
				<a class="s-blog-feat__media" href="<?php echo esc_url($f['url']); ?>" aria-label="<?php echo esc_attr($f['title']); ?>">
					<?php if ($f['img'] !== '') : ?>
						<img src="<?php echo esc_url($f['img']); ?>" alt="" />
					<?php endif; ?>
				</a>
				<div class="s-blog-feat__body">
					<div class="s-blog-feat__meta">
						<span class="s-blog-feat__meta-cat"><?php esc_html_e('Mới nhất', 'soul'); ?> · <?php echo esc_html($f['cat']); ?></span>
						<span class="s-blog-feat__meta-date"><?php echo esc_html($f['date']); ?></span>
					</div>
					<h2 class="s-blog-feat__title"><a href="<?php echo esc_url($f['url']); ?>"><?php echo esc_html($f['title']); ?></a></h2>
					<p class="s-blog-feat__ex"><?php echo esc_html($f['excerpt']); ?></p>
					<div class="s-blog-feat__cta">
						<a class="s-blog-feat__btn" href="<?php echo esc_url($f['url']); ?>"><?php esc_html_e('Đọc bài', 'soul'); ?> ↗</a>
					</div>
				</div>
			</article>
		</section>
	<?php endif; ?>

	<?php if ($ctx['is_jobs']) : ?>
		<section class="s-blog-jobs" data-section="blog-jobs" aria-label="<?php esc_attr_e('Vị trí đang tuyển', 'soul'); ?>">
			<ul class="s-blog-jobs__list">
				<?php foreach ($ctx['jobs'] as $j) : ?>
					<li class="s-blog-jobs__item">
						<div>
							<div class="s-blog-jobs__type"><?php echo esc_html($j['type']); ?></div>
							<a class="s-blog-jobs__role" href="<?php echo esc_url($j['url']); ?>"><?php echo esc_html($j['role']); ?></a>
						</div>
						<div class="s-blog-jobs__where"><?php echo esc_html($j['where']); ?></div>
						<div class="s-blog-jobs__end">
							<span class="s-blog-jobs__date"><?php echo esc_html($j['date']); ?></span>
							<a class="s-blog-jobs__btn" href="<?php echo esc_url($j['url']); ?>"><?php esc_html_e('Xem chi tiết', 'soul'); ?> ↗</a>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</section>
	<?php elseif ($ctx['grid']) : ?>
		<section class="s-blog-grid" data-section="blog-grid" aria-label="<?php esc_attr_e('Tất cả bài viết', 'soul'); ?>">
			<div class="s-blog-grid__head">
				<span><?php echo esc_html($ctx['grid_label']); ?></span>
				<span><?php echo esc_html($ctx['page_label']); ?></span>
			</div>
			<ul class="s-blog-grid__list">
				<?php foreach ($ctx['grid'] as $p) : ?>
					<li>
						<article class="s-blog-card">
							<a class="s-blog-card__media" href="<?php echo esc_url($p['url']); ?>" aria-label="<?php echo esc_attr($p['title']); ?>">
								<?php if ($p['img'] !== '') : ?>
									<img src="<?php echo esc_url($p['img']); ?>" alt="" loading="lazy" />
								<?php endif; ?>
							</a>
							<div class="s-blog-card__meta">
								<a class="s-blog-card__cat" href="<?php echo esc_url($p['cat_url']); ?>"><?php echo esc_html($p['cat']); ?></a>
								<span class="s-blog-card__date"><?php echo esc_html($p['date']); ?></span>
							</div>
							<h3 class="s-blog-card__title"><a href="<?php echo esc_url($p['url']); ?>"><?php echo esc_html($p['title']); ?></a></h3>
							<p class="s-blog-card__ex"><?php echo esc_html($p['excerpt']); ?></p>
						</article>
					</li>
				<?php endforeach; ?>
			</ul>
			<?php if ($ctx['has_pages']) : ?>
				<nav class="s-blog-pager" aria-label="<?php esc_attr_e('Phân trang', 'soul'); ?>">
					<?php if ($ctx['page'] <= 1) : ?>
						<span class="s-blog-pager__disabled" aria-disabled="true">←</span>
					<?php else : ?>
						<a href="<?php echo esc_url($page_link($ctx['page'] - 1)); ?>" aria-label="<?php esc_attr_e('Trang trước', 'soul'); ?>">←</a>
					<?php endif; ?>
					<?php for ($i = 1; $i <= $ctx['pages']; $i++) : ?>
						<a class="s-blog-pager__num<?php echo $i === $ctx['page'] ? ' is-on' : ''; ?>" href="<?php echo esc_url($page_link($i)); ?>"<?php echo $i === $ctx['page'] ? ' aria-current="page"' : ''; ?>><?php echo esc_html((string) $i); ?></a>
					<?php endfor; ?>
					<?php if ($ctx['page'] >= $ctx['pages']) : ?>
						<span class="s-blog-pager__disabled" aria-disabled="true">→</span>
					<?php else : ?>
						<a href="<?php echo esc_url($page_link($ctx['page'] + 1)); ?>" aria-label="<?php esc_attr_e('Trang sau', 'soul'); ?>">→</a>
					<?php endif; ?>
				</nav>
			<?php endif; ?>
		</section>
	<?php elseif ($ctx['is_empty']) : ?>
		<section class="s-blog-empty" data-section="blog-empty">
			<div class="s-blog-empty__box">
				<p><?php esc_html_e('Không tìm thấy bài viết phù hợp.', 'soul'); ?></p>
				<a class="s-blog-empty__btn" href="<?php echo esc_url(remove_query_arg('q')); ?>"><?php esc_html_e('Xóa tìm kiếm', 'soul'); ?></a>
			</div>
		</section>
	<?php endif; ?>
</main>
<?php
get_footer();
