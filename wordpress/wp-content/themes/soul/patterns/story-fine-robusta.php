<?php
/**
 * Title: Our Story — 05 Fine Robusta
 * Slug: soul/story-fine-robusta
 * Categories: soul-content
 */
$col = esc_url(home_url('/collections/soulful-flavours/'));
$chips = [
	['Men rượu cần', true],
	['Men rượu nếp', true],
	['Men bia thủ công', true],
	['Chanh leo', false],
	['Khóm mật', false],
	['Tiêu sọ', false],
];
?>
<!-- wp:group {"align":"full","className":"s-story-fr is-style-surface-ink","anchor":"fine-robusta","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull s-story-fr is-style-surface-ink" id="fine-robusta"><!-- wp:columns {"className":"s-story-fr__grid"} -->
<div class="wp-block-columns s-story-fr__grid"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"s-story-fr__copy","layout":{"type":"default"}} -->
<div class="wp-block-group s-story-fr__copy"><!-- wp:paragraph {"className":"s-story-eye s-story-eye--bar s-story-eye--yellow"} -->
<p class="s-story-eye s-story-eye--bar s-story-eye--yellow">04 · Một vị thế mới</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"s-story-fr__title"} -->
<h2 class="wp-block-heading s-story-fr__title">Robusta trong một thế giới đang thay đổi</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-story-fr__lead"} -->
<p class="s-story-fr__lead">Biến đổi khí hậu đang làm thay đổi ngành cà phê thế giới. Nhiệt độ tăng, thời tiết thất thường và những thách thức trong canh tác Arabica khiến thị trường ngày càng quan tâm đến tiềm năng của Robusta, không chỉ về khả năng cung ứng mà còn ở chất lượng hương vị.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-story-fr__body"} -->
<p class="s-story-fr__body">Trong bối cảnh đó, Soul chọn tiếp tục khám phá tiềm năng Fine Robusta Buôn Ma Thuột thông qua các phương pháp sơ chế, lên men và thử nghiệm với nguyên liệu bản địa như men rượu cần, trái cây Tây Nguyên, tạo nên những sắc thái hương vị mang dấu ấn vùng miền. Tinh thần ấy được thể hiện trong từng bộ sưu tập mùa vụ, từ chất lượng hạt cà phê đến thiết kế bao bì, cùng định hướng minh bạch nguồn gốc và phát triển chuỗi cung ứng có trách nhiệm.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-story-fr__ing-label"} -->
<p class="s-story-fr__ing-label">Chất liệu lên men bản địa</p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"s-story-fr__chips","layout":{"type":"default"}} -->
<div class="wp-block-group s-story-fr__chips">
<?php foreach ($chips as $chip) : ?>
<!-- wp:paragraph {"className":"s-story-fr__chip<?php echo $chip[1] ? '' : ' s-story-fr__chip--paper'; ?>"} -->
<p class="s-story-fr__chip<?php echo $chip[1] ? '' : ' s-story-fr__chip--paper'; ?>"><?php echo esc_html($chip[0]); ?></p>
<!-- /wp:paragraph -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"s-story-fr__mosaic","layout":{"type":"default"}} -->
<div class="wp-block-group s-story-fr__mosaic"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"s-story-fr__wide"} -->
<figure class="wp-block-image size-full s-story-fr__wide"><img src="<?php echo esc_url(soul_img('03b-why-soul/web/why-fermentation.jpg')); ?>" alt="Quả cà phê được ủ kín để lên men"/></figure>
<!-- /wp:image -->

<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"s-story-fr__tall"} -->
<figure class="wp-block-image size-full s-story-fr__tall"><img src="<?php echo esc_url(soul_img('02-shop/Pha-thu-cong.png')); ?>" alt="Rót Fine Robusta từ bình thủy tinh vào ly thưởng thức"/></figure>
<!-- /wp:image -->

<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"s-story-fr__tall s-story-fr__tall--offset"} -->
<figure class="wp-block-image size-full s-story-fr__tall s-story-fr__tall--offset"><img src="<?php echo esc_url(soul_img('03-why-soul-album/SFR7.jpg')); ?>" alt="Quả cà phê trong túi lên men yếm khí"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"s-story-fr__caprow","layout":{"type":"default"}} -->
<div class="wp-block-group s-story-fr__caprow"><!-- wp:paragraph -->
<p>Sơ chế &amp; lên men tại vùng nguyên liệu</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="<?php echo $col; ?>">Soulful Collection 2026 ↗</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
