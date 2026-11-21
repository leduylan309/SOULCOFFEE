<?php
/**
 * Title: Our Story — 01 Hero
 * Slug: soul/story-hero
 * Categories: soul-layout
 */
$home = esc_url(home_url('/'));
$img = soul_img('03-why-soul-album/IMG_3779.png');
$chapters = [
	['01', 'Cách làm', '#philosophy'],
	['02', 'Chuyên môn', '#team'],
	['03', 'Fine Robusta', '#fine-robusta'],
	['04', 'Kết nối', '#channels'],
	['05', 'Hành trình', '#journey'],
];
?>
<!-- wp:columns {"align":"full","className":"s-story-hero","anchor":"top","layout":{"type":"default"}} -->
<div class="wp-block-columns alignfull s-story-hero" id="top"><!-- wp:column {"className":"s-story-hero__copy"} -->
<div class="wp-block-column s-story-hero__copy"><!-- wp:paragraph {"className":"s-story-hero__crumb"} -->
<p class="s-story-hero__crumb"><a href="<?php echo $home; ?>">Trang chủ</a> / Về Soul</p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"s-story-hero__body","layout":{"type":"default"}} -->
<div class="wp-block-group s-story-hero__body"><!-- wp:paragraph {"className":"s-story-eye s-story-eye--bar"} -->
<p class="s-story-eye s-story-eye--bar">01 · Soul bắt đầu từ đâu?</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"s-story-hero__title"} -->
<h1 class="wp-block-heading s-story-hero__title">Từ Buôn Ma Thuột, một hành trình cùng cà phê Việt</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-story-hero__lead"} -->
<p class="s-story-hero__lead">Ra đời năm 2018, Soul bắt đầu từ Buôn Ma Thuột, vùng đất mà Robusta đã gắn bó với đời sống và văn hóa cà phê qua nhiều thế hệ. Từ mong muốn khám phá những giá trị chưa được nhìn nhận đầy đủ của Robusta Việt Nam, Soul từng bước phát triển cách tiếp cận riêng, kết hợp kinh nghiệm bản địa với kiến thức chuyên môn và những thử nghiệm qua từng mùa vụ.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:columns {"className":"s-story-hero__chapters"} -->
<div class="wp-block-columns s-story-hero__chapters">
<?php foreach ($chapters as $c) : ?>
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph -->
<p><a href="<?php echo esc_attr($c[2]); ?>"><span class="s-story-n"><?php echo esc_html($c[0]); ?></span><span><?php echo esc_html($c[1]); ?></span></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"s-story-hero__media"} -->
<figure class="wp-block-image size-full s-story-hero__media"><img src="<?php echo esc_url($img); ?>" alt="Giàn phơi cà phê sơ chế tự nhiên tại Buôn Ma Thuột"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
