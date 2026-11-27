<?php
/**
 * Template Name: Order lookup
 *
 * @package Soul
 */
get_header();
$ol = [
	'intro'   => soul_t( [ 'vi' => 'Nhập email và mã đơn (SOUL-…) — không cần tài khoản.', 'en' => 'Enter email and order code (SOUL-…) — no account required.' ] ),
	'email'   => soul_t( [ 'vi' => 'Email', 'en' => 'Email' ] ),
	'code'    => soul_t( [ 'vi' => 'Mã đơn', 'en' => 'Order code' ] ),
	'submit'  => soul_t( [ 'vi' => 'Tra cứu', 'en' => 'Look up' ] ),
	'status'  => soul_t( [ 'vi' => 'Trạng thái', 'en' => 'Status' ] ),
	'total'   => soul_t( [ 'vi' => 'Tổng', 'en' => 'Total' ] ),
	'payment' => soul_t( [ 'vi' => 'Thanh toán (preference)', 'en' => 'Payment preference' ] ),
];
?>
<section class="soul-container soul-order-lookup">
	<header class="soul-page__header">
		<p class="soul-eyebrow"><?php echo esc_html( soul_t( [ 'vi' => 'Đơn hàng', 'en' => 'Orders' ] ) ); ?></p>
		<h1><?php echo esc_html( soul_t( [ 'vi' => 'Tra cứu đơn', 'en' => 'Order lookup' ] ) ); ?></h1>
		<p><?php echo esc_html( $ol['intro'] ); ?></p>
	</header>

	<form id="soul-order-lookup-form" class="soul-lead-form" novalidate>
		<label><?php echo esc_html( $ol['email'] ); ?>
			<input type="email" name="email" required autocomplete="email">
		</label>
		<label><?php echo esc_html( $ol['code'] ); ?>
			<input type="text" name="code" required placeholder="SOUL-18" autocomplete="off">
		</label>
		<p class="soul-form-msg" id="soul-lookup-msg" hidden></p>
		<button type="submit" class="soul-btn soul-btn--primary"><?php echo esc_html( $ol['submit'] ); ?></button>
	</form>

	<div id="soul-lookup-result" class="soul-lookup-result" hidden>
		<h2 id="soul-lookup-code"></h2>
		<p><?php echo esc_html( $ol['status'] ); ?>: <strong id="soul-lookup-status"></strong></p>
		<p><?php echo esc_html( $ol['total'] ); ?>: <strong id="soul-lookup-total"></strong></p>
		<p><?php echo esc_html( $ol['payment'] ); ?>: <span id="soul-lookup-payment"></span></p>
		<ul id="soul-lookup-items"></ul>
	</div>
</section>
<script type="module">
const form = document.getElementById('soul-order-lookup-form');
const result = document.getElementById('soul-lookup-result');
const msg = document.getElementById('soul-lookup-msg');
const L = (window.SoulTheme && window.SoulTheme.i18n && window.SoulTheme.i18n.orderLookup) || {};
form?.addEventListener('submit', async (e) => {
  e.preventDefault();
  if (!window.SoulTheme) return;
  msg.hidden = true; result.hidden = true;
  const fd = new FormData(form);
  try {
    const token = (await window.Soul?.getRecaptchaToken?.('order_lookup')) || '';
    const res = await fetch(window.SoulTheme.restUrl + 'order-lookup', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-WP-Nonce': window.SoulTheme.nonce },
      body: JSON.stringify({ email: fd.get('email'), code: fd.get('code'), recaptchaToken: token }),
    });
    const data = await res.json();
    if (!res.ok) throw new Error(data?.message || L.notFound || 'Not found');
    document.getElementById('soul-lookup-code').textContent = data.code;
    document.getElementById('soul-lookup-status').textContent = data.statusLabel || data.status;
    document.getElementById('soul-lookup-total').textContent = new Intl.NumberFormat('vi-VN').format(data.total) + '₫';
    document.getElementById('soul-lookup-payment').textContent = data.payment;
    const ul = document.getElementById('soul-lookup-items');
    ul.innerHTML = (data.items || []).map((i) => `<li>${i.qty}× ${i.name} · ${i.variant || ''}</li>`).join('');
    result.hidden = false;
  } catch (err) {
    msg.hidden = false;
    msg.textContent = err.message || L.error || 'Error';
  }
});
</script>
<?php
get_footer();
