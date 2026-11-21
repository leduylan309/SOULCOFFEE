<?php
/**
 * Title: Solutions — 02 Capacity
 * Slug: soul/solutions-capacity
 * Categories: soul-content
 */
$stats = [
	['20–60', 'tấn / tháng', 'Sản lượng rang: trung bình 20 tấn, tối đa 60 tấn mỗi tháng'],
	['500+', 'ha', 'Diện tích vùng trồng liên kết'],
	['1.800–2.000', 'tấn / năm', 'Tổng sản lượng nhân xanh mỗi năm'],
	['10%', 'sản lượng', 'Đạt tiêu chuẩn chất lượng cao và cà phê đặc sản'],
];
?>
<!-- wp:group {"align":"full","className":"s-sol-cap is-style-surface-ink","anchor":"capacity","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull s-sol-cap is-style-surface-ink" id="capacity"><!-- wp:columns {"className":"s-sol-head"} -->
<div class="wp-block-columns s-sol-head"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"s-sol-eye"} -->
<p class="s-sol-eye">Năng lực sản xuất</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"s-sol-h2"} -->
<h2 class="wp-block-heading s-sol-h2">Từ vùng nguyên liệu đến xưởng rang</h2>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"s-sol-p"} -->
<p class="s-sol-p">Soul liên kết vùng trồng tại Tây Nguyên và vận hành xưởng rang riêng tại Buôn Ma Thuột, đủ năng lực cung ứng ổn định cho đối tác ở nhiều quy mô.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"className":"s-sol-cap__stats"} -->
<div class="wp-block-columns s-sol-cap__stats">
<?php foreach ($stats as $s) : ?>
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"s-sol-cap__stat","layout":{"type":"default"}} -->
<div class="wp-block-group s-sol-cap__stat"><!-- wp:group {"className":"s-sol-cap__stat-top","layout":{"type":"default"}} -->
<div class="wp-block-group s-sol-cap__stat-top"><!-- wp:paragraph {"className":"s-sol-cap__num"} -->
<p class="s-sol-cap__num"><?php echo esc_html($s[0]); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-sol-cap__unit"} -->
<p class="s-sol-cap__unit"><?php echo esc_html($s[1]); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"s-sol-cap__label"} -->
<p class="s-sol-cap__label"><?php echo esc_html($s[2]); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
