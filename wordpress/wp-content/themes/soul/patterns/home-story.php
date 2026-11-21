<?php
/**
 * Title: Home — 03 Story + Album
 * Slug: soul/home-story
 * Categories: soul-layout
 */
$story = esc_url(home_url('/our-story/'));
$album = [
	['03-why-soul-album/IMG_3779.png', 'Soul team member tending natural-process coffee on raised drying beds', 's-home-album__shot s-home-album__shot--lead'],
	['03-why-soul-album/SFR4.jpg', 'Robusta branches heavy with ripe cherries', 's-home-album__shot s-home-album__shot--tile'],
	['03-why-soul-album/SFR5.jpg', 'Freshly picked cherries being washed and floated', 's-home-album__shot s-home-album__shot--tile s-home-album__shot--offset'],
	['03-why-soul-album/SFR6.jpg', 'Ripe cherries resting in a sack before fermentation', 's-home-album__shot s-home-album__shot--tile'],
	['03-why-soul-album/SFR7.jpg', 'Cherries sealed in a bag for anaerobic fermentation', 's-home-album__shot s-home-album__shot--tile s-home-album__shot--offset'],
];
?>
<!-- wp:group {"align":"full","className":"s-home-story is-style-surface-ink","anchor":"story","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull s-home-story is-style-surface-ink" id="story"><!-- wp:columns {"className":"s-home-story__grid"} -->
<div class="wp-block-columns s-home-story__grid"><!-- wp:column {"width":"42%","className":"s-home-story__copy"} -->
<div class="wp-block-column s-home-story__copy" style="flex-basis:42%"><!-- wp:paragraph {"className":"s-home-story__eye"} -->
<p class="s-home-story__eye">Crafted by Vietnamese Soul</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"s-home-story__title"} -->
<h2 class="wp-block-heading s-home-story__title">Một thế hệ mới lớn lên cùng cà phê</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-home-story__lead"} -->
<p class="s-home-story__lead">Soul lớn lên từ Buôn Ma Thuột, giữa một vùng đất đã gắn với Robusta qua nhiều thế hệ.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-home-story__p"} -->
<p class="s-home-story__p">Chúng tôi làm việc với cà phê xuyên suốt từ vùng nguyên liệu, thu hái, sơ chế, đánh giá nhân xanh đến rang và pha chế. Nhờ những kiến thức và phương pháp tiếp cận mới, chúng tôi có thêm nhiều cách để nhìn sâu hơn vào những điều vốn đã rất quen thuộc. Mỗi mùa vụ vì vậy không chỉ mang đến những lô cà phê mới, mà còn mở ra thêm những cách để hiểu Robusta Việt Nam rõ hơn.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-home-story__p"} -->
<p class="s-home-story__p">Soul tập trung vào những gì giống cà phê này có thể thể hiện khi nguyên liệu, quá trình sau thu hoạch và kỹ thuật rang được chăm chút kỹ hơn. Từ đó, chúng tôi tiếp tục thử nghiệm các hướng sơ chế và lên men mới, trong đó có men rượu cần, men rượu nếp và những nguyên liệu bản địa gắn với Tây Nguyên.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline-dark"} -->
<div class="wp-block-button is-style-outline-dark"><a class="wp-block-button__link wp-element-button" href="<?php echo $story; ?>">Tìm hiểu về Soul ↗</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"58%"} -->
<div class="wp-block-column" style="flex-basis:58%"><!-- wp:group {"className":"s-home-album js-soul-lightbox","layout":{"type":"default"}} -->
<div class="wp-block-group s-home-album js-soul-lightbox">
<?php foreach ($album as $a) : ?>
<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"<?php echo esc_attr($a[2]); ?>"} -->
<figure class="wp-block-image size-full <?php echo esc_attr($a[2]); ?>"><img src="<?php echo soul_img($a[0]); ?>" alt="<?php echo esc_attr($a[1]); ?>"/></figure>
<!-- /wp:image -->
<?php endforeach; ?>

<!-- wp:paragraph {"className":"s-home-album__meta"} -->
<p class="s-home-album__meta"><span>Album · Vùng nguyên liệu</span><span>05</span></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
