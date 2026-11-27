<?php
/**
 * @var array $attributes
 */

$kind  = (string) ($attributes['kind'] ?? 'newsletter');
$title = (string) ($attributes['title'] ?? __('Form liên hệ', 'soul'));
$source = (string) ($attributes['source'] ?? 'home-b2b');
$submit = (string) ($attributes['submitLabel'] ?? '');
$ph = (string) ($attributes['emailPlaceholder'] ?? __('Email của bạn', 'soul'));

if ($kind === 'newsletter') {
	$submit = $submit !== '' ? $submit : __('Đăng ký ↗', 'soul');
	$wrap = get_block_wrapper_attributes(['class' => 'soul-lead-form s-home-nl__form']);
	?>
	<form <?php echo $wrap; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> data-soul-form="newsletter">
		<label class="screen-reader-text" for="nl-email"><?php echo esc_html($ph); ?></label>
		<input id="nl-email" type="email" name="email" required placeholder="<?php echo esc_attr($ph); ?>">
		<p class="soul-hp" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></p>
		<button type="submit"><?php echo esc_html($submit); ?></button>
		<p class="soul-form-msg" hidden></p>
	</form>
	<?php
	return;
}

if ($kind === 'help' || $source === 'help') {
	$submit = $submit !== '' ? $submit : __('Gửi lời nhắn', 'soul');
	$title  = $title !== '' && $title !== __('Form liên hệ', 'soul') ? $title : __('Để lại lời nhắn', 'soul');
	$wrap   = get_block_wrapper_attributes(['class' => 's-help-form soul-lead-form']);
	$topics = [
		'order'   => __('Đơn hàng & giao hàng', 'soul'),
		'product' => __('Sản phẩm & cách pha', 'soul'),
		'b2b'     => __('Hợp tác / mua sỉ', 'soul'),
		'other'   => __('Khác', 'soul'),
	];
	?>
	<form <?php echo $wrap; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> data-soul-form="contact" data-source="help" novalidate>
		<h2><?php echo esc_html($title); ?></h2>
		<label>
			<span><?php esc_html_e('Chủ đề', 'soul'); ?></span>
			<select name="topic">
				<?php foreach ($topics as $val => $label) : ?>
					<option value="<?php echo esc_attr((string) $val); ?>"><?php echo esc_html($label); ?></option>
				<?php endforeach; ?>
			</select>
		</label>
		<label>
			<span><?php esc_html_e('Họ và tên', 'soul'); ?> <span class="req">*</span></span>
			<input type="text" name="name" required autocomplete="name">
		</label>
		<label>
			<span><?php esc_html_e('Email hoặc số điện thoại', 'soul'); ?> <span class="req">*</span></span>
			<input type="text" name="email" required autocomplete="email">
		</label>
		<label>
			<span><?php esc_html_e('Mã đơn hàng (nếu có)', 'soul'); ?></span>
			<input type="text" name="order" autocomplete="off">
		</label>
		<label>
			<span><?php esc_html_e('Nội dung', 'soul'); ?> <span class="req">*</span></span>
			<textarea name="message" rows="5" required></textarea>
		</label>
		<p class="soul-hp" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></p>
		<button type="submit"><?php echo esc_html($submit); ?></button>
		<p class="s-help-form__note"><?php esc_html_e('Soul phản hồi trong 1 ngày làm việc (T2–T7).', 'soul'); ?></p>
		<p class="soul-form-msg" hidden></p>
	</form>
	<?php
	return;
}

$submit = $submit !== '' ? $submit : __('Gửi thông tin', 'soul');
$interests = $source === 'solutions'
	? ['Nhân xanh', 'Cà phê rang', 'Đào tạo', 'Workshop & sự kiện', 'Quà tặng doanh nghiệp']
	: ['Nhân xanh', 'Cà phê rang', 'Đào tạo', 'Phát triển menu & quầy bar'];
$wrap = get_block_wrapper_attributes(['class' => 's-home-form']);
// Avoid duplicate id=contact when section already anchors #contact (Coffee Solutions).
$form_wrap_id = $source === 'solutions' ? 'solutions-form' : 'contact';
?>
<div <?php echo $wrap; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> id="<?php echo esc_attr($form_wrap_id); ?>">
	<h3><?php echo esc_html($title); ?></h3>
	<form class="soul-lead-form s-home-form__grid" data-soul-form="contact" data-source="<?php echo esc_attr($source); ?>" novalidate>
		<label><span><?php esc_html_e('Họ tên', 'soul'); ?> <span class="req">*</span></span><input type="text" name="name" required autocomplete="name"></label>
		<label><span><?php esc_html_e('Tên doanh nghiệp', 'soul'); ?></span><input type="text" name="business" autocomplete="organization"></label>
		<label><span><?php esc_html_e('Email', 'soul'); ?> <span class="req">*</span></span><input type="email" name="email" required autocomplete="email"></label>
		<label><span><?php esc_html_e('Số điện thoại', 'soul'); ?></span><input type="tel" name="phone" autocomplete="tel"></label>
		<fieldset class="s-home-form__full" style="margin:0;padding:0;border:0">
			<legend class="s-home-form__legend"><?php esc_html_e('Quan tâm đến', 'soul'); ?></legend>
			<div class="s-home-form__chips" data-component="chip-group" data-mode="multi" data-name="topic">
				<?php foreach ($interests as $it) : ?>
				<button type="button" data-value="<?php echo esc_attr($it); ?>" aria-pressed="false"><?php echo esc_html($it); ?></button>
				<?php endforeach; ?>
				<input type="hidden" name="topic" value="">
			</div>
		</fieldset>
		<label class="s-home-form__full"><span><?php esc_html_e('Nội dung cần trao đổi', 'soul'); ?></span><textarea name="message" rows="4"></textarea></label>
		<p class="soul-hp" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></p>
		<div class="s-home-form__actions">
			<button type="submit" class="s-home-form__submit"><?php echo esc_html($submit); ?></button>
			<p class="soul-form-msg" hidden></p>
		</div>
	</form>
</div>
