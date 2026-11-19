<?php
/**
 * Template Name: Order lookup
 *
 * @package Soul
 */
get_header();
?>
<section class="soul-container soul-order-lookup">
	<header class="soul-page__header">
		<p class="soul-eyebrow"><?php echo esc_html(soul_t(['vi' => 'Đơn hàng', 'en' => 'Orders'])); ?></p>
		<h1><?php echo esc_html(soul_t(['vi' => 'Tra cứu đơn', 'en' => 'Order lookup'])); ?></h1>
		<p><?php esc_html_e('Nhập email và mã đơn (SOUL-…) — không cần tài khoản.', 'soul'); ?></p>
	</header>

	<form id="soul-order-lookup-form" class="soul-lead-form" novalidate>
		<label><?php esc_html_e('Email', 'soul'); ?>
			<input type="email" name="email" required autocomplete="email">
		</label>
		<label><?php esc_html_e('Mã đơn', 'soul'); ?>
			<input type="text" name="code" required placeholder="SOUL-18" autocomplete="off">
		</label>
		<p class="soul-form-msg" id="soul-lookup-msg" hidden></p>
		<button type="submit" class="soul-btn soul-btn--primary"><?php esc_html_e('Tra cứu', 'soul'); ?></button>
	</form>

	<div id="soul-lookup-result" class="soul-lookup-result" hidden>
		<h2 id="soul-lookup-code"></h2>
		<p><?php esc_html_e('Trạng thái', 'soul'); ?>: <strong id="soul-lookup-status"></strong></p>
		<p><?php esc_html_e('Tổng', 'soul'); ?>: <strong id="soul-lookup-total"></strong></p>
		<p><?php esc_html_e('Thanh toán (preference)', 'soul'); ?>: <span id="soul-lookup-payment"></span></p>
		<ul id="soul-lookup-items"></ul>
	</div>
</section>
<script type="module">
const form = document.getElementById('soul-order-lookup-form');
const result = document.getElementById('soul-lookup-result');
const msg = document.getElementById('soul-lookup-msg');
form?.addEventListener('submit', async (e) => {
  e.preventDefault();
  if (!window.SoulTheme) return;
  msg.hidden = true; result.hidden = true;
  const fd = new FormData(form);
  try {
    const res = await fetch(window.SoulTheme.restUrl + 'order-lookup', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-WP-Nonce': window.SoulTheme.nonce },
      body: JSON.stringify({ email: fd.get('email'), code: fd.get('code') }),
    });
    const data = await res.json();
    if (!res.ok) throw new Error(data?.message || 'Không tìm thấy.');
    document.getElementById('soul-lookup-code').textContent = data.code;
    document.getElementById('soul-lookup-status').textContent = data.status;
    document.getElementById('soul-lookup-total').textContent = new Intl.NumberFormat('vi-VN').format(data.total) + '₫';
    document.getElementById('soul-lookup-payment').textContent = data.payment;
    const ul = document.getElementById('soul-lookup-items');
    ul.innerHTML = (data.items || []).map((i) => `<li>${i.qty}× ${i.name} · ${i.variant || ''}</li>`).join('');
    result.hidden = false;
  } catch (err) {
    msg.hidden = false;
    msg.textContent = err.message || 'Lỗi tra cứu.';
  }
});
</script>
<?php
get_footer();
