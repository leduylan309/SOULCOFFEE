<?php
/**
 * Title: Our Story — 04 Team capability
 * Slug: soul/story-team
 * Categories: soul-content
 */
$img = soul_img('03b-why-soul/web/why-cupping.jpg');
$caps = [
	['01', 'Q-Grader', 'CQI · SCA', 'Quản lý chất lượng cà phê nhân'],
	['02', 'Processing', 'Certificate', 'Thực hiện và quản lý chất lượng chế biến'],
	['03', 'SCA Roaster', 'SCA', 'Trình độ rang và quản lý chất lượng cà phê rang'],
	['04', 'SCA Barista', 'SCA', 'Quy trình và chất lượng pha chế'],
];
?>
<!-- wp:group {"align":"full","className":"s-story-team is-style-surface-sand","anchor":"team","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull s-story-team is-style-surface-sand" id="team"><!-- wp:columns {"className":"s-story-head"} -->
<div class="wp-block-columns s-story-head"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"s-story-eye"} -->
<p class="s-story-eye">03 · Năng lực chuyên môn</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"s-story-h2"} -->
<h2 class="wp-block-heading s-story-h2">Chuyên môn từ sự học hỏi không ngừng</h2>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"s-story-p"} -->
<p class="s-story-p">Đội ngũ Soul liên tục học hỏi và nâng cao năng lực thông qua các chương trình đào tạo chuyên môn trong lĩnh vực đánh giá cảm quan, sơ chế, rang và pha chế cà phê.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"className":"s-story-team__pair"} -->
<div class="wp-block-columns s-story-team__pair"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"s-story-team__shot"} -->
<figure class="wp-block-image size-full s-story-team__shot"><img src="<?php echo esc_url($img); ?>" alt="Cà phê xay trong bát cupping để đánh giá cảm quan"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"s-story-team__caps","layout":{"type":"default"}} -->
<div class="wp-block-group s-story-team__caps">
<?php foreach ($caps as $c) : ?>
<!-- wp:group {"className":"s-story-team__cap","layout":{"type":"default"}} -->
<div class="wp-block-group s-story-team__cap"><!-- wp:group {"className":"s-story-team__cap-top","layout":{"type":"default"}} -->
<div class="wp-block-group s-story-team__cap-top"><!-- wp:paragraph -->
<p><?php echo esc_html($c[0]); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-story-muted"} -->
<p class="s-story-muted"><?php echo esc_html($c[2]); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:heading {"level":3,"className":"s-story-team__cap-label"} -->
<h3 class="wp-block-heading s-story-team__cap-label"><?php echo esc_html($c[1]); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-story-team__cap-desc"} -->
<p class="s-story-team__cap-desc"><?php echo esc_html($c[3]); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"className":"s-story-team__prod"} -->
<div class="wp-block-columns s-story-team__prod"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3,"className":"s-story-team__prod-title"} -->
<h3 class="wp-block-heading s-story-team__prod-title">Từ vùng nguyên liệu đến sản xuất</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-story-team__prod-body"} -->
<p class="s-story-team__prod-body">Soul hiện hợp tác cùng mạng lưới vùng trồng liên kết khoảng 500 ha, với năng lực rang xay trung bình khoảng 20 tấn mỗi tháng. Quy mô sản xuất giúp chúng tôi có điều kiện phát triển các dòng cà phê khác nhau, nhưng sự nhất quán về chất lượng, nguồn gốc rõ ràng và đặc trưng riêng của mỗi loại hạt vẫn luôn là những ưu tiên quan trọng.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:columns {"className":"s-story-team__stats"} -->
<div class="wp-block-columns s-story-team__stats"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"s-story-team__stat","layout":{"type":"default"}} -->
<div class="wp-block-group s-story-team__stat"><!-- wp:group {"className":"s-story-team__stat-top","layout":{"type":"default"}} -->
<div class="wp-block-group s-story-team__stat-top"><!-- wp:paragraph {"className":"s-story-team__stat-num"} -->
<p class="s-story-team__stat-num">~500</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-story-team__stat-unit"} -->
<p class="s-story-team__stat-unit">ha</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"s-story-team__stat-label"} -->
<p class="s-story-team__stat-label">Mạng lưới vùng trồng liên kết</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"s-story-team__stat","layout":{"type":"default"}} -->
<div class="wp-block-group s-story-team__stat"><!-- wp:group {"className":"s-story-team__stat-top","layout":{"type":"default"}} -->
<div class="wp-block-group s-story-team__stat-top"><!-- wp:paragraph {"className":"s-story-team__stat-num"} -->
<p class="s-story-team__stat-num">~20</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-story-team__stat-unit"} -->
<p class="s-story-team__stat-unit">tấn / tháng</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"s-story-team__stat-label"} -->
<p class="s-story-team__stat-label">Năng lực rang xay trung bình</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
