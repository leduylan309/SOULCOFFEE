<?php
/**
 * Product archive / collection listing.
 *
 * @package Soul
 */
get_header();
$shop = get_post_type_archive_link('soul_product');
$sort = isset($_GET['sort']) ? sanitize_key((string) $_GET['sort']) : 'feat';
$stock = isset($_GET['in_stock']) && $_GET['in_stock'] === '1';
$base = is_tax('soul_collection') ? get_term_link(get_queried_object()) : $shop;
if (is_wp_error($base)) {
	$base = $shop;
}
?>
<section class="soul-container soul-shop">
	<header class="soul-page__header">
		<p class="soul-eyebrow"><?php esc_html_e('Soul Shop', 'soul'); ?></p>
		<h1><?php
		if (is_tax('soul_collection')) {
			single_term_title();
		} else {
			esc_html_e('Tất cả sản phẩm', 'soul');
		}
		?></h1>
		<?php if (is_tax('soul_collection') && term_description()) : ?>
			<div class="soul-lead"><?php echo wp_kses_post(term_description()); ?></div>
		<?php endif; ?>
	</header>

	<?php
	$terms = get_terms(['taxonomy' => 'soul_collection', 'hide_empty' => false]);
	if (! is_wp_error($terms) && $terms) :
		?>
		<nav class="soul-chips" aria-label="<?php esc_attr_e('Collections', 'soul'); ?>">
			<a class="soul-chip<?php echo is_post_type_archive('soul_product') ? ' is-on' : ''; ?>" href="<?php echo esc_url($shop); ?>"><?php esc_html_e('Tất cả', 'soul'); ?></a>
			<?php foreach ($terms as $term) : ?>
				<a class="soul-chip<?php echo is_tax('soul_collection', $term->slug) ? ' is-on' : ''; ?>" href="<?php echo esc_url(get_term_link($term)); ?>"><?php echo esc_html($term->name); ?></a>
			<?php endforeach; ?>
		</nav>
	<?php endif; ?>

	<form class="soul-shop-toolbar" method="get" action="<?php echo esc_url($base); ?>">
		<label class="soul-toolbar-check">
			<input type="checkbox" name="in_stock" value="1" <?php checked($stock); ?> onchange="this.form.submit()">
			<?php esc_html_e('Còn hàng', 'soul'); ?>
		</label>
		<label class="soul-toolbar-sort">
			<span><?php esc_html_e('Sắp xếp', 'soul'); ?></span>
			<select name="sort" onchange="this.form.submit()">
				<option value="feat" <?php selected($sort, 'feat'); ?>><?php esc_html_e('Nổi bật', 'soul'); ?></option>
				<option value="new" <?php selected($sort, 'new'); ?>><?php esc_html_e('Mới nhất', 'soul'); ?></option>
				<option value="asc" <?php selected($sort, 'asc'); ?>><?php esc_html_e('Giá thấp → cao', 'soul'); ?></option>
				<option value="desc" <?php selected($sort, 'desc'); ?>><?php esc_html_e('Giá cao → thấp', 'soul'); ?></option>
			</select>
		</label>
	</form>

	<div class="soul-product-grid">
		<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
				<?php get_template_part('template-parts/product', 'card'); ?>
			<?php endwhile; ?>
		<?php else : ?>
			<p><?php esc_html_e('Không có sản phẩm phù hợp.', 'soul'); ?></p>
		<?php endif; ?>
	</div>
	<?php the_posts_pagination(); ?>
</section>
<?php
get_footer();
