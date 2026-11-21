<?php
/**
 * Title: Solutions — 05 Contact
 * Slug: soul/solutions-contact
 * Categories: soul-connect
 */
$contacts = [
	['Hotline Soul Specialty Coffee', '0987 592 220', 'tel:0987592220'],
	['Soul Fine Robusta', '0908 267 710', 'tel:0908267710'],
	['Email', 'contact@soulcoffee.vn', 'mailto:contact@soulcoffee.vn'],
	['Zalo', 'soulspecialtycoffee', 'https://zalo.me/soulspecialtycoffee'],
];
?>
<!-- wp:group {"align":"full","className":"s-sol-ct is-style-surface-paper","anchor":"contact","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull s-sol-ct is-style-surface-paper" id="contact"><!-- wp:columns {"className":"s-sol-ct__grid"} -->
<div class="wp-block-columns s-sol-ct__grid"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"s-sol-ct__copy","layout":{"type":"default"}} -->
<div class="wp-block-group s-sol-ct__copy"><!-- wp:paragraph {"className":"s-sol-eye s-sol-eye--bar"} -->
<p class="s-sol-eye s-sol-eye--bar">Liên hệ hợp tác</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"s-sol-ct__title"} -->
<h2 class="wp-block-heading s-sol-ct__title">Bắt đầu cùng Soul</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-sol-ct__body"} -->
<p class="s-sol-ct__body">Cho chúng tôi biết bạn đang tìm kiếm điều gì. Đội ngũ Soul sẽ liên hệ lại để tư vấn và gửi mẫu phù hợp.</p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"s-sol-ct__contacts","layout":{"type":"default"}} -->
<div class="wp-block-group s-sol-ct__contacts">
<?php foreach ($contacts as $c) : ?>
<!-- wp:paragraph {"className":"s-sol-ct__row"} -->
<p class="s-sol-ct__row"><a href="<?php echo esc_url($c[2]); ?>"><span><span class="s-sol-ct__k"><?php echo esc_html($c[0]); ?></span><span class="s-sol-ct__v"><?php echo esc_html($c[1]); ?></span></span><span class="s-sol-arrow" aria-hidden="true">↗</span></a></p>
<!-- /wp:paragraph -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"s-sol-ct__form-wrap","layout":{"type":"default"}} -->
<div class="wp-block-group s-sol-ct__form-wrap"><!-- wp:soul/lead-form {"kind":"contact","title":"Form liên hệ","source":"solutions","submitLabel":"Gửi thông tin"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
