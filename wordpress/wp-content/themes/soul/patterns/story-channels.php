<?php
/**
 * Title: Our Story — 06 Channels
 * Slug: soul/story-channels
 * Categories: soul-cards
 */
$sol = esc_url(home_url('/coffee-solutions/'));
$shop = esc_url(get_post_type_archive_link('soul_product') ?: home_url('/products/'));
$channels = [
	['01', 'Xuất khẩu', 'Cung cấp cà phê nhân xanh Fine Robusta và High Quality Robusta cho các nhà rang, đối tác quốc tế.', $sol . '#green'],
	['02', 'HORECA', 'Cà phê rang và giải pháp sản phẩm dành cho quán cà phê, nhà hàng, khách sạn.', $sol . '#roast'],
	['03', 'Doanh nghiệp', 'Quà tặng cà phê, workshop và các hoạt động trải nghiệm dành cho doanh nghiệp, sự kiện.', $sol . '#events'],
	['04', 'Khách hàng cá nhân', 'Các dòng cà phê đóng gói và không gian trải nghiệm Soul dành cho người yêu cà phê.', $shop],
];
?>
<!-- wp:group {"align":"full","className":"s-story-ch is-style-surface-paper","anchor":"channels","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull s-story-ch is-style-surface-paper" id="channels"><!-- wp:columns {"className":"s-story-head"} -->
<div class="wp-block-columns s-story-head"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"s-story-eye"} -->
<p class="s-story-eye">05 · Kết nối &amp; mở rộng</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"s-story-h2"} -->
<h2 class="wp-block-heading s-story-h2">Từ bản sắc địa phương đến những thị trường mới</h2>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"s-story-p"} -->
<p class="s-story-p">Song song với việc phát triển sản phẩm, Soul mở rộng hoạt động từ cung ứng cà phê nhân xanh cho nhà rang quốc tế đến các giải pháp cà phê dành cho đối tác F&amp;B, doanh nghiệp và khách hàng cá nhân. Qua từng kênh phục vụ, Soul hướng đến việc đưa cà phê Việt Nam tiếp cận nhiều thị trường và phù hợp với những nhu cầu thưởng thức khác nhau.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"className":"s-story-ch__tiles"} -->
<div class="wp-block-columns s-story-ch__tiles">
<?php foreach ($channels as $c) : ?>
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"s-story-ch__tile","layout":{"type":"default"}} -->
<div class="wp-block-group s-story-ch__tile"><!-- wp:paragraph {"className":"s-story-ch__tile-top"} -->
<p class="s-story-ch__tile-top"><a href="<?php echo esc_url($c[3]); ?>"><span><?php echo esc_html($c[0]); ?></span><span class="s-story-arrow">↗</span></a></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"s-story-ch__tile-title"} -->
<h3 class="wp-block-heading s-story-ch__tile-title"><a href="<?php echo esc_url($c[3]); ?>"><?php echo esc_html($c[1]); ?></a></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-story-ch__tile-desc"} -->
<p class="s-story-ch__tile-desc"><?php echo esc_html($c[2]); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
