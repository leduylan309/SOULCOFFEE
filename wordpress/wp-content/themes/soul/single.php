<?php
/**
 * Single post — fidelity vs html/Blog.dc.html (article view).
 *
 * @package Soul
 */
get_header();

while (have_posts()) :
	the_post();
	$id      = (int) get_the_ID();
	$cat     = soul_blog_primary_cat($id);
	$cat_name = $cat ? $cat->name : '';
	$cat_url  = $cat ? get_category_link($cat) : soul_blog_url();
	$raw      = (string) get_post_field('post_content', $id);
	$rendered = apply_filters('the_content', $raw);
	$toc      = soul_blog_toc($rendered);
	$mins     = soul_blog_mins($raw, (string) get_the_excerpt());
	$tags     = get_the_tags($id) ?: [];
	$adj      = soul_blog_adjacent($id);
	$related  = soul_blog_related($id, 3);
	$home     = home_url('/');
	$blog     = soul_blog_url();
	$cover = get_the_post_thumbnail_url($id, 'full') ?: '';
	if ($cover === '') {
		$rel = (string) get_post_meta($id, 'soul_cover_rel', true);
		if ($rel !== '' && function_exists('soul_img')) {
			$cover = soul_img($rel);
		}
	}
	?>
<article <?php post_class('s-blog-post'); ?> aria-labelledby="po-h">
	<header class="s-blog-post__head" id="top" data-section="blog-post-head">
		<nav class="s-blog-crumb" aria-label="<?php esc_attr_e('Breadcrumb', 'soul'); ?>">
			<a href="<?php echo esc_url($home); ?>"><?php esc_html_e('Trang chủ', 'soul'); ?></a>
			<span class="s-blog-crumb__sep" aria-hidden="true">/</span>
			<a href="<?php echo esc_url($blog); ?>">Blog</a>
			<span class="s-blog-crumb__sep" aria-hidden="true">/</span>
			<a class="s-blog-crumb__cur" href="<?php echo esc_url($cat_url); ?>"><?php echo esc_html($cat_name); ?></a>
		</nav>
		<div class="s-blog-post__center">
			<?php if ($cat_name !== '') : ?>
				<a class="s-blog-post__chip" href="<?php echo esc_url($cat_url); ?>"><?php echo esc_html($cat_name); ?></a>
			<?php endif; ?>
			<h1 class="s-blog-post__title" id="po-h"><?php the_title(); ?></h1>
			<div class="s-blog-post__byline">
				<span><?php esc_html_e('Người viết', 'soul'); ?> <strong>SOUL</strong></span>
				<span><?php echo esc_html(soul_blog_date((string) get_the_date('Y-m-d'))); ?></span>
				<span><?php echo esc_html((string) $mins); ?> <?php esc_html_e('phút đọc', 'soul'); ?></span>
			</div>
		</div>
	</header>

	<?php if ($cover !== '') : ?>
		<figure class="s-blog-post__cover" data-section="blog-post-cover">
			<img src="<?php echo esc_url($cover); ?>" alt="<?php the_title_attribute(); ?>" />
		</figure>
	<?php endif; ?>

	<div class="s-blog-post__layout" data-section="blog-post-body">
		<aside class="s-blog-post__aside">
			<div class="s-blog-post__sticky">
				<?php if (count($toc) > 1) : ?>
					<nav class="s-blog-toc" aria-label="<?php esc_attr_e('Nội dung bài viết', 'soul'); ?>">
						<div class="s-blog-toc__label"><?php esc_html_e('Nội dung bài viết', 'soul'); ?></div>
						<ol class="s-blog-toc__list">
							<?php foreach ($toc as $h) : ?>
								<li>
									<a href="#<?php echo esc_attr($h['id']); ?>">
										<span class="s-blog-toc__n"><?php echo esc_html($h['n']); ?></span>
										<?php echo esc_html($h['text']); ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ol>
					</nav>
				<?php endif; ?>
				<?php if ($tags) : ?>
					<div class="s-blog-tags">
						<div class="s-blog-tags__label">Tags</div>
						<div class="s-blog-tags__list">
							<?php foreach ($tags as $tg) : ?>
								<a href="<?php echo esc_url(get_tag_link($tg)); ?>">#<?php echo esc_html($tg->slug); ?></a>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</aside>

		<div class="s-blog-post__body">
			<?php if (has_excerpt()) : ?>
				<p class="s-blog-post__dek"><?php echo esc_html(get_the_excerpt()); ?></p>
			<?php endif; ?>
			<div class="entry-content"><?php echo $rendered; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — filtered content ?></div>
		</div>
	</div>

	<?php if ($adj) : ?>
		<nav class="s-blog-adj" data-section="blog-post-nav" aria-label="<?php esc_attr_e('Điều hướng bài viết', 'soul'); ?>">
			<?php foreach ($adj as $a) : ?>
				<a class="s-blog-adj--<?php echo esc_attr($a['align']); ?>" href="<?php echo esc_url($a['url']); ?>">
					<span class="s-blog-adj__label"><?php echo esc_html($a['label']); ?></span>
					<span class="s-blog-adj__title"><?php echo esc_html($a['title']); ?></span>
				</a>
			<?php endforeach; ?>
		</nav>
	<?php endif; ?>

	<?php if ($related) : ?>
		<section class="s-blog-related" data-section="blog-post-related" aria-labelledby="rl-h">
			<div class="s-blog-related__head">
				<h2 class="s-blog-related__title" id="rl-h"><?php esc_html_e('Thêm từ', 'soul'); ?> <?php echo esc_html($cat_name); ?></h2>
				<a class="s-blog-related__all" href="<?php echo esc_url($cat_url); ?>"><?php esc_html_e('Xem tất cả', 'soul'); ?> ↗</a>
			</div>
			<ul class="s-blog-grid__list">
				<?php foreach ($related as $p) : ?>
					<li>
						<article class="s-blog-card">
							<a class="s-blog-card__media" href="<?php echo esc_url($p['url']); ?>" aria-label="<?php echo esc_attr($p['title']); ?>">
								<?php if ($p['img'] !== '') : ?>
									<img src="<?php echo esc_url($p['img']); ?>" alt="" loading="lazy" />
								<?php endif; ?>
							</a>
							<div class="s-blog-card__meta">
								<span class="s-blog-card__cat"><?php echo esc_html($p['cat']); ?></span>
								<span class="s-blog-card__date"><?php echo esc_html($p['date']); ?></span>
							</div>
							<h3 class="s-blog-card__title"><a href="<?php echo esc_url($p['url']); ?>"><?php echo esc_html($p['title']); ?></a></h3>
						</article>
					</li>
				<?php endforeach; ?>
			</ul>
		</section>
	<?php endif; ?>
</article>
	<?php
endwhile;

get_footer();
