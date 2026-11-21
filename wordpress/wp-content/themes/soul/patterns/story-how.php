<?php
/**
 * Title: Our Story — 03 Philosophy
 * Slug: soul/story-how
 * Categories: soul-content
 */
$img = soul_img('03-why-soul-album/SFR4.jpg');
$rows = [
	['01', 'Hiểu từ vùng nguyên liệu', 'Tìm hiểu đặc điểm vùng trồng, điều kiện canh tác và sự thay đổi của nguyên liệu qua từng mùa vụ.'],
	['02', 'Chú trọng từng công đoạn', 'Từ thu hoạch, sơ chế đến rang xay, mỗi công đoạn đều được thực hiện và kiểm soát dựa trên những yêu cầu chất lượng cụ thể.'],
	['03', 'Kết nối cùng nông hộ', 'Kết hợp kinh nghiệm canh tác tại địa phương với kiến thức chuyên môn, cùng trao đổi và cải thiện chất lượng qua từng mùa vụ.'],
	['04', 'Lấy trải nghiệm làm điểm đến', 'Chất lượng không chỉ được đánh giá trong quá trình sản xuất mà còn qua hương vị, sự ổn định và trải nghiệm thực tế của người uống.'],
];
?>
<!-- wp:group {"align":"full","className":"s-story-ph is-style-surface-paper","anchor":"philosophy","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull s-story-ph is-style-surface-paper" id="philosophy"><!-- wp:columns {"className":"s-story-ph__grid"} -->
<div class="wp-block-columns s-story-ph__grid"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"s-story-ph__sticky","layout":{"type":"default"}} -->
<div class="wp-block-group s-story-ph__sticky"><!-- wp:paragraph {"className":"s-story-eye"} -->
<p class="s-story-eye">Cách tiếp cận</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"s-story-ph__title"} -->
<h2 class="wp-block-heading s-story-ph__title">Không có một công thức chung cho mọi hạt cà phê</h2>
<!-- /wp:heading -->

<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"s-story-ph__media"} -->
<figure class="wp-block-image size-full s-story-ph__media"><img src="<?php echo esc_url($img); ?>" alt="Cành Robusta trĩu quả chín tại vườn"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"s-story-ph__lead"} -->
<p class="s-story-ph__lead">Mỗi vùng trồng, mỗi mùa vụ đều có những đặc điểm riêng. Với Soul, làm cà phê là quá trình liên tục quan sát, tìm hiểu và điều chỉnh, để mỗi lựa chọn đều phù hợp với đặc tính nguyên liệu và chất lượng mà chúng tôi hướng đến.</p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"s-story-ph__rows","layout":{"type":"default"}} -->
<div class="wp-block-group s-story-ph__rows">
<?php foreach ($rows as $r) : ?>
<!-- wp:group {"className":"s-story-ph__row","layout":{"type":"default"}} -->
<div class="wp-block-group s-story-ph__row"><!-- wp:paragraph {"className":"s-story-ph__n"} -->
<p class="s-story-ph__n"><?php echo esc_html($r[0]); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":3,"className":"s-story-ph__row-title"} -->
<h3 class="wp-block-heading s-story-ph__row-title"><?php echo esc_html($r[1]); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-story-ph__row-body"} -->
<p class="s-story-ph__row-body"><?php echo esc_html($r[2]); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
