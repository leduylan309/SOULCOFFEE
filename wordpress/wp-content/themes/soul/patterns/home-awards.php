<?php
/**
 * Title: Home — 03b Awards
 * Slug: soul/home-awards
 * Categories: soul-layout
 */
$stats = [
	['87.21', 'điểm', 'Top 1 Robusta', 'Vietnam Coffee Producer Competition 2026', true],
	['86.85', 'điểm', 'Top 3 Robusta', 'Vietnam Coffee Producer Competition 2026', true],
	['86.52', 'điểm', 'Top 2 Robusta', 'Southeast Asia Green Coffee Competition 2026', true],
	['500', 'ha', 'Vùng liên kết nguyên liệu', 'Tây Nguyên', false],
];
$caps = [
	['01', 'Q-Grader', 'Đánh giá và chấm điểm nhân xanh theo chuẩn CQI'],
	['02', 'Processing', 'Sơ chế và lên men ngay tại vùng nguyên liệu'],
	['03', 'SCA Roaster', 'Phát triển hồ sơ rang theo chuẩn SCA'],
	['04', 'SCA Barista', 'Pha chế và đào tạo theo chuẩn SCA'],
];
$certs = [
	['03c-awards/web/Top1Ro-Soulfine.jpg', '2026', '87.21', 'Top 1 Robusta', 'Vietnam Coffee Producer Competition 2026'],
	['03c-awards/web/Top3Ro-Soulfine.jpg', '2026', '86.85', 'Top 3 Robusta', 'Vietnam Coffee Producer Competition 2026'],
	['03c-awards/web/Top2-Robusta-SEA-Green-2026.jpg', '2026', '86.52', 'Top 2 Robusta', 'Southeast Asia Green Coffee Competition 2026'],
	['03c-awards/web/VAZ2026_85.36.jpg', '2026', '85.36', 'Hạng 10 Robusta', 'Cà phê Đặc sản Việt Nam 2026 · Vietnam Amazing Cup'],
	['03c-awards/web/VAZ2026_85.25.jpg', '2026', '85.25', 'Cà phê đặc sản · Lot 01', 'Cà phê Đặc sản Việt Nam 2026 · Vietnam Amazing Cup'],
	['03c-awards/web/cert-CPDS2025.jpg', '2025', '85.29', 'Cà phê đặc sản · Lot TR4', 'Cà phê Đặc sản Việt Nam 2025'],
	['03c-awards/web/cert-CPDC2025.jpg', '2025', '83.54', 'Cà phê đặc sản · Lot Xanh lùn', 'Cà phê Đặc sản Việt Nam 2025'],
];
$cert_count = str_pad((string) count($certs), 2, '0', STR_PAD_LEFT);
?>
<!-- wp:group {"align":"full","className":"s-home-awards is-style-surface-sand","anchor":"awards","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull s-home-awards is-style-surface-sand" id="awards"><!-- wp:columns {"className":"s-home-awards__head"} -->
<div class="wp-block-columns s-home-awards__head"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"s-home-eye s-home-eye--bar"} -->
<p class="s-home-eye s-home-eye--bar">Năng lực &amp; thành tích</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"s-home-awards__title"} -->
<h2 class="wp-block-heading s-home-awards__title">Chất lượng được ghi nhận qua từng mùa vụ</h2>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"s-home-p"} -->
<p class="s-home-p">Các lô cà phê của Soul được đánh giá bởi những hội đồng chuyên môn trong nước và khu vực, từ Buôn Ma Thuột đến Đông Nam Á.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"className":"s-home-awards__mosaic"} -->
<div class="wp-block-columns s-home-awards__mosaic"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"s-home-awards__photos js-soul-lightbox","layout":{"type":"default"}} -->
<div class="wp-block-group s-home-awards__photos js-soul-lightbox"><!-- wp:group {"className":"s-home-awards__photo s-home-awards__photo--lead","layout":{"type":"default"}} -->
<div class="wp-block-group s-home-awards__photo s-home-awards__photo--lead"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="<?php echo soul_img('03c-awards/web/award-photo-1.jpg'); ?>" alt="Soul Fine Robusta team receiving Top 1 Vietnam Robusta Coffee Producer 2026"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"s-home-awards__tag"} -->
<p class="s-home-awards__tag">Top 1 · Vietnam Robusta Coffee Producer 2026</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"s-home-awards__photo"} -->
<figure class="wp-block-image size-full s-home-awards__photo"><img src="<?php echo soul_img('03c-awards/web/VCPC2026.jpg'); ?>" alt="Soul team with trophies at Vietnam Coffee Producer Competition 2026"/></figure>
<!-- /wp:image -->

<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"s-home-awards__photo"} -->
<figure class="wp-block-image size-full s-home-awards__photo"><img src="<?php echo soul_img('03c-awards/web/award-photo-2.jpg'); ?>" alt="Award winners at Southeast Asia Green Coffee Competition 2024"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"s-home-awards__results","layout":{"type":"default"}} -->
<div class="wp-block-group s-home-awards__results"><!-- wp:paragraph {"className":"s-home-awards__results-label"} -->
<p class="s-home-awards__results-label">Kết quả và thành tích</p>
<!-- /wp:paragraph -->

<?php foreach ($stats as $st) : ?>
<!-- wp:group {"className":"s-home-awards__stat","layout":{"type":"default"}} -->
<div class="wp-block-group s-home-awards__stat"><!-- wp:paragraph {"className":"s-home-awards__num"} -->
<p class="s-home-awards__num"><?php echo esc_html($st[0]); ?> <span class="s-home-awards__unit"><?php echo esc_html($st[1]); ?></span></p>
<!-- /wp:paragraph -->

<?php if ($st[4]) : ?>
<!-- wp:paragraph {"className":"s-home-awards__view"} -->
<p class="s-home-awards__view"><a href="#awards-certs">Xem chứng nhận ↗</a></p>
<!-- /wp:paragraph -->
<?php endif; ?>

<!-- wp:paragraph {"className":"s-home-awards__rank"} -->
<p class="s-home-awards__rank"><span class="s-home-awards__rank-name"><?php echo esc_html($st[2]); ?></span> <span class="s-home-awards__rank-comp"><?php echo esc_html($st[3]); ?></span></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:paragraph {"className":"s-home-awards__section-label"} -->
<p class="s-home-awards__section-label">Năng lực chuyên môn</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"className":"s-home-awards__caps"} -->
<div class="wp-block-columns s-home-awards__caps">
<?php foreach ($caps as $c) : ?>
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"s-home-awards__cap-n"} -->
<p class="s-home-awards__cap-n"><?php echo esc_html($c[0]); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"s-home-awards__cap-label"} -->
<h3 class="wp-block-heading s-home-awards__cap-label"><?php echo esc_html($c[1]); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-home-awards__cap-desc"} -->
<p class="s-home-awards__cap-desc"><?php echo esc_html($c[2]); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns -->

<!-- wp:group {"className":"s-home-awards__rail-wrap js-soul-rail js-soul-lightbox","anchor":"awards-certs","layout":{"type":"default"}} -->
<div class="wp-block-group s-home-awards__rail-wrap js-soul-rail js-soul-lightbox" id="awards-certs"><!-- wp:group {"className":"s-home-awards__rail-head","layout":{"type":"default"}} -->
<div class="wp-block-group s-home-awards__rail-head"><!-- wp:paragraph -->
<p>Chứng nhận &amp; giải thưởng <span class="s-home-awards__rail-count"><?php echo esc_html($cert_count); ?></span></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"s-home-awards__rail-nav"} -->
<div class="wp-block-buttons s-home-awards__rail-nav"><!-- wp:button {"className":"is-style-rail-nav"} -->
<div class="wp-block-button is-style-rail-nav"><a class="wp-block-button__link wp-element-button" href="#awards-certs">←</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-rail-nav"} -->
<div class="wp-block-button is-style-rail-nav"><a class="wp-block-button__link wp-element-button" href="#awards-certs">→</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"s-home-awards__rail","layout":{"type":"default"}} -->
<div class="wp-block-group s-home-awards__rail">
<?php foreach ($certs as $ce) : ?>
<!-- wp:group {"className":"s-home-awards__cert","layout":{"type":"default"}} -->
<div class="wp-block-group s-home-awards__cert"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"s-home-awards__cert-media"} -->
<figure class="wp-block-image size-full s-home-awards__cert-media"><img src="<?php echo soul_img($ce[0]); ?>" alt="<?php echo esc_attr($ce[3] . ' · ' . $ce[2]); ?>"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"s-home-awards__cert-body","layout":{"type":"default"}} -->
<div class="wp-block-group s-home-awards__cert-body"><!-- wp:group {"className":"s-home-awards__cert-top","layout":{"type":"default"}} -->
<div class="wp-block-group s-home-awards__cert-top"><!-- wp:paragraph {"className":"s-home-awards__cert-year"} -->
<p class="s-home-awards__cert-year"><?php echo esc_html($ce[1]); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-home-awards__cert-score"} -->
<p class="s-home-awards__cert-score"><?php echo esc_html($ce[2]); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:heading {"level":3,"className":"s-home-awards__cert-rank"} -->
<h3 class="wp-block-heading s-home-awards__cert-rank"><?php echo esc_html($ce[3]); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-home-awards__cert-comp"} -->
<p class="s-home-awards__cert-comp"><?php echo esc_html($ce[4]); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
