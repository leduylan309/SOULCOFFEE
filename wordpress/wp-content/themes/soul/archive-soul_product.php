<?php
/**
 * Product archive / collection listing — SoT html/Shop.dc.html (isList).
 *
 * @package Soul
 */
get_header();

$shop = get_post_type_archive_link('soul_product') ?: home_url('/products/');
$sort = isset($_GET['sort']) ? sanitize_key((string) $_GET['sort']) : 'feat';
$stock = isset($_GET['in_stock']) && $_GET['in_stock'] === '1';
$q = isset($_GET['q']) ? sanitize_text_field(wp_unslash((string) $_GET['q'])) : '';
$base = is_tax('soul_collection') ? get_term_link(get_queried_object()) : $shop;
if (is_wp_error($base)) {
	$base = $shop;
}
$hero = soul_shop_hero_context();
$groups = soul_shop_nav_groups();
$found = (int) $GLOBALS['wp_query']->found_posts;
$solutions = home_url('/coffee-solutions/#contact');
$is_sub = is_tax('soul_collection');
?>
<section class="s-shop-hero" id="top" aria-labelledby="sh-h" data-screen-label="01 Shop · Hero">
	<nav class="s-shop-crumb" aria-label="<?php esc_attr_e('Breadcrumb', 'soul'); ?>">
		<a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Trang chủ', 'soul'); ?></a>
		<span class="s-shop-crumb__sep" aria-hidden="true">/</span>
		<?php if ($is_sub) : ?>
			<a href="<?php echo esc_url($shop); ?>"><?php esc_html_e('Sản phẩm', 'soul'); ?></a>
			<span class="s-shop-crumb__sep" aria-hidden="true">/</span>
		<?php endif; ?>
		<span class="s-shop-crumb__cur"><?php echo esc_html($hero['name']); ?></span>
	</nav>
	<div class="s-shop-hero__grid">
		<div>
			<p class="s-shop-eye"><?php echo esc_html($hero['eyebrow']); ?></p>
			<h1 class="s-shop-hero__title" id="sh-h"><?php echo esc_html($hero['name']); ?></h1>
		</div>
		<p class="s-shop-hero__intro"><?php echo esc_html($hero['intro']); ?></p>
	</div>
</section>

<section class="s-shop-list" aria-label="<?php echo esc_attr($hero['name']); ?>" data-screen-label="02 Shop · Danh sách">
	<aside class="s-shop-aside" aria-label="<?php esc_attr_e('Danh mục', 'soul'); ?>">
		<div class="s-shop-aside__sticky">
			<?php foreach ($groups as $group) : ?>
				<nav class="s-shop-nav" aria-label="<?php echo esc_attr($group['title']); ?>">
					<div class="s-shop-nav__title"><?php echo esc_html($group['title']); ?></div>
					<ul class="s-shop-nav__list">
						<?php foreach ($group['items'] as $item) : ?>
							<li>
								<a
									class="s-shop-nav__link<?php echo $item['current'] ? ' is-current' : ''; ?><?php echo $item['depth'] > 0 ? ' is-child' : ''; ?>"
									href="<?php echo esc_url($item['url']); ?>"
									<?php echo $item['current'] ? ' aria-current="page"' : ''; ?>
								>
									<span class="s-shop-nav__label"><?php echo esc_html($item['label']); ?></span>
									<span class="s-shop-nav__count"><?php echo esc_html((string) $item['count']); ?></span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</nav>
			<?php endforeach; ?>
		</div>
	</aside>

	<div class="s-shop-main">
		<form class="s-shop-toolbar" method="get" action="<?php echo esc_url($base); ?>">
			<label class="s-shop-search">
				<span class="s-shop-search__ico" aria-hidden="true">
					<svg width="15" height="15" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="7" cy="7" r="5"></circle><path d="M11 11l4 4"></path></svg>
				</span>
				<input id="shop-q" type="search" name="q" value="<?php echo esc_attr($q); ?>" placeholder="<?php esc_attr_e('Tìm sản phẩm', 'soul'); ?>" aria-label="<?php esc_attr_e('Tìm sản phẩm', 'soul'); ?>">
			</label>
			<div class="s-shop-toolbar__meta">
				<span class="s-shop-toolbar__count"><?php echo esc_html(sprintf(/* translators: %d product count */ _n('%d sản phẩm', '%d sản phẩm', $found, 'soul'), $found)); ?></span>
				<label class="s-shop-toolbar__stock">
					<input type="checkbox" name="in_stock" value="1" <?php checked($stock); ?> onchange="this.form.submit()">
					<?php esc_html_e('Còn hàng', 'soul'); ?>
				</label>
				<label class="s-shop-toolbar__sort">
					<span><?php esc_html_e('Sắp xếp', 'soul'); ?></span>
					<select name="sort" onchange="this.form.submit()">
						<option value="feat" <?php selected($sort, 'feat'); ?>><?php esc_html_e('Nổi bật', 'soul'); ?></option>
						<option value="new" <?php selected($sort, 'new'); ?>><?php esc_html_e('Mới nhất', 'soul'); ?></option>
						<option value="asc" <?php selected($sort, 'asc'); ?>><?php esc_html_e('Giá tăng dần', 'soul'); ?></option>
						<option value="desc" <?php selected($sort, 'desc'); ?>><?php esc_html_e('Giá giảm dần', 'soul'); ?></option>
					</select>
				</label>
			</div>
		</form>

		<?php if ($hero['note'] !== '') : ?>
			<div class="s-shop-note">
				<p class="s-shop-note__text"><?php echo esc_html($hero['note']); ?></p>
				<a class="s-shop-note__cta" href="<?php echo esc_url($solutions); ?>"><?php echo esc_html($hero['note_cta']); ?> ↗</a>
			</div>
		<?php endif; ?>

		<?php if (have_posts()) : ?>
			<ul class="s-shop-grid">
				<?php
				while (have_posts()) :
					the_post();
					echo '<li>';
					get_template_part('template-parts/product', 'card');
					echo '</li>';
				endwhile;
				?>
			</ul>
			<?php
			$pages = paginate_links([
				'type'      => 'array',
				'prev_text' => '←',
				'next_text' => '→',
			]);
			if (is_array($pages) && $pages !== []) :
				?>
				<nav class="s-shop-pages" aria-label="<?php esc_attr_e('Phân trang', 'soul'); ?>">
					<?php foreach ($pages as $link) : ?>
						<?php echo wp_kses_post($link); ?>
					<?php endforeach; ?>
				</nav>
			<?php endif; ?>
		<?php else : ?>
			<div class="s-shop-empty">
				<p class="s-shop-empty__title"><?php esc_html_e('Không có sản phẩm phù hợp.', 'soul'); ?></p>
				<a class="s-shop-empty__btn" href="<?php echo esc_url($shop); ?>"><?php esc_html_e('Xóa bộ lọc', 'soul'); ?></a>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
