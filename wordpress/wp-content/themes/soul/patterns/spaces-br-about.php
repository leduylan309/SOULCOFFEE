<?php
/**
 * Title: Spaces branch — 02 About
 * Slug: soul/spaces-br-about
 * Categories: soul-layout
 * Post Types: soul_space
 */
$id   = (int) (get_the_ID() ?: ($GLOBALS['soul_space_seed_id'] ?? 0));
$lead = $id ? (string) get_the_excerpt($id) : 'Soul Buôn Ma Thuột là nơi mọi thứ bắt đầu.';
$seed_about = $GLOBALS['soul_space_seed_about'] ?? null;
if (is_array($seed_about)) {
	$paras = $seed_about;
} elseif ($id) {
	$raw = (string) get_post_field('post_content', $id);
	// When re-seeding, prefer explicit seed paras; else leave starter copy.
	$paras = [
		'Cửa hàng đầu tiên của Soul nằm ngay trên mảnh đất đã nuôi dưỡng thương hiệu từ những ngày đầu.',
		'Không gian mang nhịp riêng: nhiều cây xanh, mở, thoải mái và đủ tĩnh để thưởng thức trọn từng tách.',
	];
} else {
	$paras = [
		'Cửa hàng đầu tiên của Soul nằm ngay trên mảnh đất đã nuôi dưỡng thương hiệu từ những ngày đầu.',
		'Không gian mang nhịp riêng: nhiều cây xanh, mở, thoải mái và đủ tĩnh để thưởng thức trọn từng tách.',
	];
}
?>
<!-- wp:columns {"align":"full","className":"s-space-br-about","layout":{"type":"default"}} -->
<div class="wp-block-columns alignfull s-space-br-about"><!-- wp:column {"className":"s-space-br-about__side"} -->
<div class="wp-block-column s-space-br-about__side"><!-- wp:paragraph {"className":"s-space-eye"} -->
<p class="s-space-eye">Khám phá</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2,"className":"s-space-br-about__h2"} -->
<h2 class="wp-block-heading s-space-br-about__h2" id="ab-h">Về không gian</h2>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"s-space-br-about__main"} -->
<div class="wp-block-column s-space-br-about__main"><!-- wp:paragraph {"className":"s-space-br-about__lead"} -->
<p class="s-space-br-about__lead"><?php echo esc_html($lead); ?></p>
<!-- /wp:paragraph -->

<?php foreach ($paras as $p) : ?>
<!-- wp:paragraph {"className":"s-space-br-about__body"} -->
<p class="s-space-br-about__body"><?php echo esc_html($p); ?></p>
<!-- /wp:paragraph -->
<?php endforeach; ?>
</div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
