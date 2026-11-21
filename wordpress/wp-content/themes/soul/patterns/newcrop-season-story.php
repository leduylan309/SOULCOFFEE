<?php
/**
 * Title: New Crop — 02 Season story
 * Slug: soul/newcrop-season-story
 * Categories: soul-content
 */
$rows = [
	['01', 'Vùng trồng', 'Câu chuyện tập trung tại Cư Bao, khu vực Buôn Hồ, Đắk Lắk, ở độ cao khoảng 700 m. Với các giống TR4, TR9 và TR11, việc đi sâu vào một vùng nguyên liệu giúp Soul hiểu rõ hơn điều kiện phát triển của cây và chất lượng đầu vào.'],
	['02', 'Canh tác', 'Soul hướng đến việc cải tạo đất, sử dụng phân bón hữu cơ và trùn quế, từng bước xây dựng cách canh tác bền vững hơn. Khả năng tận dụng phụ phẩm đang được tìm hiểu, chưa phải một hệ thống tuần hoàn hoàn chỉnh.'],
	['03', 'Con người & chế biến', 'Người nông dân và đội ngũ sản xuất trực tiếp chăm sóc, xử lý và kiểm soát nguyên liệu. Bên cạnh phương pháp Natural, Soul thử nghiệm các nguồn tạo men từ chanh dây, cơm rượu nếp trắng, gừng và rượu nếp cẩm. Hương vị thành phẩm sẽ được xác nhận sau cupping.'],
];
$band = soul_img('03-why-soul-album/SFR5.jpg');
$side = soul_img('03-why-soul-album/SFR6.jpg');
?>
<!-- wp:group {"align":"full","className":"s-newcrop-story is-style-surface-sand","anchor":"story","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull s-newcrop-story is-style-surface-sand" id="story"><!-- wp:columns {"className":"s-newcrop-story__head"} -->
<div class="wp-block-columns s-newcrop-story__head"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"s-newcrop-eye"} -->
<p class="s-newcrop-eye">02 / Câu chuyện mùa vụ</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"s-newcrop-story__title"} -->
<h2 class="wp-block-heading s-newcrop-story__title">Từ vùng đất đến bàn tay người làm.</h2>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"s-newcrop-story__lead"} -->
<p class="s-newcrop-story__lead">Ở mùa vụ 2027, Soul không bắt đầu lại từ đầu. Tụi mình chọn hiểu sâu hơn về vùng trồng, chăm chút từng công đoạn và tiếp tục những thử nghiệm có kiểm soát để hoàn thiện chất lượng cà phê.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:group {"className":"s-newcrop-story__band","layout":{"type":"default"}} -->
<div class="wp-block-group s-newcrop-story__band"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"s-newcrop-story__band-media"} -->
<figure class="wp-block-image size-full s-newcrop-story__band-media"><img src="<?php echo esc_url($band); ?>" alt="Toàn cảnh vùng trồng cà phê Cư Bao"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"s-newcrop-story__cap"} -->
<p class="s-newcrop-story__cap">Cư Bao, Buôn Hồ · ~700 m</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:columns {"className":"s-newcrop-story__lower"} -->
<div class="wp-block-columns s-newcrop-story__lower"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"s-newcrop-story__rows","layout":{"type":"default"}} -->
<div class="wp-block-group s-newcrop-story__rows">
<?php foreach ($rows as $r) : ?>
<!-- wp:group {"className":"s-newcrop-story__row","layout":{"type":"default"}} -->
<div class="wp-block-group s-newcrop-story__row"><!-- wp:paragraph {"className":"s-newcrop-story__n"} -->
<p class="s-newcrop-story__n"><?php echo esc_html($r[0]); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"s-newcrop-story__row-title"} -->
<h3 class="wp-block-heading s-newcrop-story__row-title"><?php echo esc_html($r[1]); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-newcrop-story__row-body"} -->
<p class="s-newcrop-story__row-body"><?php echo esc_html($r[2]); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"s-newcrop-story__side","layout":{"type":"default"}} -->
<div class="wp-block-group s-newcrop-story__side"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"s-newcrop-story__side-media"} -->
<figure class="wp-block-image size-full s-newcrop-story__side-media"><img src="<?php echo esc_url($side); ?>" alt="Người nông dân thu hái quả cà phê chín"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"s-newcrop-story__side-cap"} -->
<p class="s-newcrop-story__side-cap">Thu hái &amp; sơ chế tại vùng nguyên liệu</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
