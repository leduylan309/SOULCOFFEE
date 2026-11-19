// Checkout page: render cart + POST /soul/v1/checkout (no online payment).
import { cart } from '../services/cart.js';
import { bus } from '../core/events.js';

function money(n) {
  return new Intl.NumberFormat('vi-VN').format(n) + '₫';
}

function linesRoot() {
  return document.getElementById('soul-cart-lines');
}

function render() {
  const root = linesRoot();
  const empty = document.getElementById('soul-cart-empty');
  const sub = document.getElementById('soul-subtotal');
  if (!root) return;
  const items = cart.store.get().items || [];
  root.innerHTML = '';
  if (!items.length) {
    if (empty) empty.hidden = false;
    if (sub) sub.textContent = money(0);
    return;
  }
  if (empty) empty.hidden = true;
  let total = 0;
  for (const item of items) {
    total += (item.price || 0) * (item.qty || 1);
    const row = document.createElement('div');
    row.className = 'soul-cart-line';
    row.innerHTML = `
      ${item.img ? `<img src="${item.img}" alt="">` : '<span class="soul-media-well"></span>'}
      <div>
        <div>${item.name || ''}</div>
        <div class="soul-meta-chain">${item.variant || item.type || ''}</div>
        <div>${money(item.price || 0)} × ${item.qty || 1}</div>
      </div>
      <button type="button" data-remove="${item.id}">×</button>`;
    root.appendChild(row);
  }
  if (sub) sub.textContent = money(total);
  root.querySelectorAll('[data-remove]').forEach((btn) => {
    btn.addEventListener('click', () => cart.remove(btn.getAttribute('data-remove')));
  });
}

export default function bootCheckout() {
  render();
  cart.subscribe(render);
  bus.on('cart:change', render);

  const form = document.getElementById('soul-checkout-form');
  const err = document.getElementById('soul-form-error');
  const done = document.getElementById('soul-checkout-done');
  if (!form || !window.SoulTheme) return;

  const vatToggle = document.getElementById('soul-vat-needed');
  const vatFields = document.getElementById('soul-vat-fields');
  vatToggle?.addEventListener('change', () => {
    if (vatFields) vatFields.hidden = !vatToggle.checked;
  });

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const items = cart.store.get().items || [];
    if (!items.length) {
      if (err) {
        err.hidden = false;
        err.textContent = 'Giỏ hàng đang trống.';
      }
      return;
    }
    const fd = new FormData(form);
    const payload = {
      name: fd.get('name'),
      email: fd.get('email'),
      phone: fd.get('phone'),
      address: fd.get('address'),
      note: fd.get('note'),
      payment: fd.get('payment') || 'cod',
      website: fd.get('website') || '',
      vat_needed: !!fd.get('vat_needed'),
      vat_company: fd.get('vat_company') || '',
      vat_tax_id: fd.get('vat_tax_id') || '',
      vat_email: fd.get('vat_email') || '',
      vat_address: fd.get('vat_address') || '',
      items: items.map((i) => ({
        id: i.id,
        name: i.name,
        variant: i.variant || i.type || '',
        price: i.price || 0,
        qty: i.qty || 1,
      })),
    };

    const btn = document.getElementById('soul-submit');
    if (btn) btn.disabled = true;
    try {
      const res = await fetch(window.SoulTheme.restUrl + 'checkout', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-WP-Nonce': window.SoulTheme.nonce,
        },
        body: JSON.stringify(payload),
      });
      const data = await res.json();
      if (!res.ok) throw new Error(data?.message || 'Không gửi được đơn.');
      // clear cart
      for (const i of [...items]) await cart.remove(i.id);
      form.hidden = true;
      if (done) {
        done.hidden = false;
        const code = document.getElementById('soul-order-code');
        if (code) code.textContent = data.orderCode || data.orderId;
      }
    } catch (ex) {
      if (err) {
        err.hidden = false;
        err.textContent = ex.message || 'Lỗi gửi đơn.';
      }
    } finally {
      if (btn) btn.disabled = false;
    }
  });
}
