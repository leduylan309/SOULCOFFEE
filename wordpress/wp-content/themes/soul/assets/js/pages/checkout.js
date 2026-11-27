// Checkout — SoT html/Checkout.dc.html (cart / #checkout / #done/:code).
import { cart } from '../services/cart.js';
import { getRecaptchaToken } from '../services/recaptcha.js';
import { bus } from '../core/events.js';

const PROVINCES = [
  'TP. Hồ Chí Minh', 'Hà Nội', 'Đà Nẵng', 'Đắk Lắk', 'Hải Phòng', 'Cần Thơ', 'Huế',
  'An Giang', 'Bắc Ninh', 'Cà Mau', 'Cao Bằng', 'Điện Biên', 'Đồng Nai', 'Đồng Tháp',
  'Gia Lai', 'Hà Tĩnh', 'Hưng Yên', 'Khánh Hòa', 'Lai Châu', 'Lạng Sơn', 'Lào Cai',
  'Lâm Đồng', 'Nghệ An', 'Ninh Bình', 'Phú Thọ', 'Quảng Ngãi', 'Quảng Ninh', 'Quảng Trị',
  'Sơn La', 'Tây Ninh', 'Thái Nguyên', 'Thanh Hóa', 'Tuyên Quang', 'Vĩnh Long',
];
function i18nBag() {
  return (window.SoulTheme && window.SoulTheme.i18n) || {};
}
function titles() {
  const ui = i18nBag().checkoutUi || {};
  if (Array.isArray(ui.titles)) return ui.titles;
  if (ui.titles && typeof ui.titles === 'object') {
    return [ui.titles.cart, ui.titles.payment || ui.titles.review, ui.titles.success || 'OK'].filter(Boolean);
  }
  return ['Giỏ hàng', 'Thanh toán', 'Đặt hàng thành công'];
}
function trackLabels() {
  const ui = i18nBag().checkoutUi || {};
  return Array.isArray(ui.track) ? ui.track : ['Đã đặt hàng', 'Đã xác nhận', 'Đang giao', 'Đã nhận hàng'];
}

const money = (n) => new Intl.NumberFormat('vi-VN').format(Math.max(0, Math.round(n))) + '₫';
const esc = (s) => String(s ?? '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

function checkoutUi() {
  const root = document.querySelector('[data-ck-root]');
  const cfg = window.SoulTheme?.checkoutUi || {};
  const shipOn =
    root?.dataset.shipMethods != null ? root.dataset.shipMethods === '1' : !!cfg.shippingMethods;
  const payOn =
    root?.dataset.payMethods != null ? root.dataset.payMethods === '1' : !!cfg.paymentMethods;
  const stores = cfg.pickupStores && typeof cfg.pickupStores === 'object' ? cfg.pickupStores : {};
  const codes = cfg.promoCodes && typeof cfg.promoCodes === 'object' ? cfg.promoCodes : { SOUL10: 0.1 };
  return {
    shippingMethods: !!shipOn,
    paymentMethods: !!payOn,
    hotline: root?.dataset.hotline || cfg.hotline || '0969 648 148',
    email: root?.dataset.ckEmail || cfg.email || 'contact@soulcoffee.vn',
    bankName: cfg.bankName || 'Đang cập nhật',
    bankAccount: cfg.bankAccount || 'Đang cập nhật',
    bankAccountName: cfg.bankAccountName || 'Công ty Soul Fine Robusta',
    freeShippingAt: Number(cfg.freeShippingAt) || 500000,
    shippingStdFee: Number(cfg.shippingStdFee) || 30000,
    shippingExpFee: Number(cfg.shippingExpFee) || 50000,
    promoCodes: codes,
    pickupStores: stores,
  };
}

function parseRoute() {
  const h = (location.hash || '').replace(/^#/, '');
  if (h === 'checkout') return { kind: 'checkout' };
  const m = h.match(/^done\/(.+)$/);
  if (m) return { kind: 'done', id: decodeURIComponent(m[1]) };
  return { kind: 'cart' };
}

function go(hash) {
  const next = hash ? '#' + hash : location.pathname + location.search;
  history.replaceState(null, '', hash ? '#' + hash : location.pathname + location.search);
  window.scrollTo(0, 0);
  bus.emit('ck:route', parseRoute());
  void next;
}

function items() {
  return cart.store.get().items || [];
}

function totals(state) {
  const list = items();
  const sub = list.reduce((a, i) => a + (i.price || 0) * (i.qty || 1), 0);
  const ui = checkoutUi();
  const rate = state.applied && ui.promoCodes[state.applied] ? ui.promoCodes[state.applied] : 0;
  const disc = rate ? Math.round((sub * rate) / 1000) * 1000 : 0;
  const ship =
    !ui.shippingMethods || state.ship === 'arrange' || state.ship === 'pickup' || state.ship === 'intl'
      ? 0
      : state.ship === 'exp'
        ? ui.shippingExpFee
        : sub - disc >= ui.freeShippingAt
          ? 0
          : ui.shippingStdFee;
  return { sub, disc, ship, total: sub - disc + ship };
}

export default function bootCheckout() {
  const root = document.querySelector('[data-ck-root]');
  if (!root) return;

  const firstStore = Object.keys(checkoutUi().pickupStores || {})[0] || 'hcm';
  const state = {
    ship: 'arrange',
    store: firstStore,
    pay: 'contact',
    applied: null,
    codeMsg: '',
    lastOrder: null,
  };

  const $ = (sel, el = root) => el.querySelector(sel);
  const $$ = (sel, el = root) => [...el.querySelectorAll(sel)];

  // Provinces
  const prov = $('[data-ck-province]');
  if (prov && prov.options.length <= 1) {
    PROVINCES.forEach((p) => {
      const o = document.createElement('option');
      o.value = p;
      o.textContent = p;
      prov.appendChild(o);
    });
  }

  function setView(kind, empty) {
    const map = {
      cart: empty ? 'cart-empty' : 'cart',
      checkout: 'checkout',
      done: 'done',
      missing: 'missing',
    };
    const view = map[kind] || 'cart';
    $$('[data-ck-view]').forEach((el) => {
      el.hidden = el.getAttribute('data-ck-view') !== view;
    });
  }

  function setSteps(idx) {
    $$('[data-ck-steps] [data-step]').forEach((li) => {
      const n = Number(li.dataset.step);
      li.classList.toggle('is-current', n === idx);
      li.classList.toggle('is-done', n < idx);
      li.setAttribute('aria-current', n === idx ? 'step' : 'false');
      const badge = li.querySelector('[data-step-n]');
      if (badge) badge.textContent = n < idx ? '✓' : String(n + 1);
    });
    const TITLES = titles();
    const title = TITLES[idx] || TITLES[0];
    const tEl = $('[data-ck-title]');
    const cEl = $('[data-ck-crumb]');
    if (tEl) tEl.textContent = title;
    if (cEl) cEl.textContent = title;
  }

  function applyCommerceModes() {
    const ui = checkoutUi();
    const shipMethods = $('[data-ck-ship-methods]');
    const shipNotice = $('[data-ck-ship-notice]');
    const payMethods = $('[data-ck-pay-methods]');
    const payNotice = $('[data-ck-pay-notice]');
    if (shipMethods) shipMethods.hidden = !ui.shippingMethods;
    if (shipNotice) shipNotice.hidden = ui.shippingMethods;
    if (payMethods) payMethods.hidden = !ui.paymentMethods;
    if (payNotice) payNotice.hidden = ui.paymentMethods;

    if (!ui.shippingMethods) {
      state.ship = 'arrange';
    } else if (state.ship === 'arrange') {
      state.ship = 'std';
    }
    if (!ui.paymentMethods) {
      state.pay = 'contact';
    } else if (state.pay === 'contact') {
      state.pay = 'bank';
    }

    const shipInput = $('[data-ck-ship-input]');
    const payInput = $('[data-ck-pay-input]');
    if (shipInput) shipInput.value = state.ship;
    if (payInput) payInput.value = state.pay;

    const cartShip = $('[data-ck-cart-ship]');
    if (cartShip) cartShip.textContent = ui.shippingMethods ? 'Tính ở bước sau' : 'Soul liên hệ xác nhận';
  }

  function syncShipUI() {
    applyCommerceModes();
    const ui = checkoutUi();
    $$('[data-ck-ships] [data-ship]').forEach((btn) => {
      const on = btn.dataset.ship === state.ship;
      btn.classList.toggle('is-on', on);
      btn.setAttribute('aria-checked', on ? 'true' : 'false');
    });
    $$('[data-ck-pays] [data-pay]').forEach((btn) => {
      const on = btn.dataset.pay === state.pay;
      btn.classList.toggle('is-on', on);
      btn.setAttribute('aria-checked', on ? 'true' : 'false');
    });
    const shipInput = $('[data-ck-ship-input]');
    if (shipInput) shipInput.value = state.ship;
    const payInput = $('[data-ck-pay-input]');
    if (payInput) payInput.value = state.pay;

    const pickup = ui.shippingMethods && state.ship === 'pickup';
    const intl = ui.shippingMethods && state.ship === 'intl';
    const stores = $('[data-ck-stores]');
    const addr = $('[data-ck-addr]');
    const vn = $('[data-ck-vn-addr]');
    const intlEl = $('[data-ck-intl-addr]');
    if (stores) stores.hidden = !pickup;
    if (addr) addr.hidden = pickup;
    if (vn) vn.hidden = intl || pickup;
    if (intlEl) intlEl.hidden = !intl || pickup;

    const tt = totals(state);
    const freeAt = ui.freeShippingAt;
    const free = tt.sub - tt.disc >= freeAt;
    const stdFee = $('[data-ck-std-fee]');
    const stdSub = $('[data-ck-std-sub]');
    if (stdFee) stdFee.textContent = free ? 'Miễn phí' : money(ui.shippingStdFee);
    if (stdSub) stdSub.textContent = `2–4 ngày làm việc · miễn phí từ ${money(freeAt)}`;
  }

  function renderCart() {
    const list = items();
    const tt = totals(state);
    const ui = checkoutUi();
    const freeAt = ui.freeShippingAt;
    const freeNet = tt.sub - tt.disc;
    const freeOk = freeNet >= freeAt;

    $('[data-ck-count-label]') && ($('[data-ck-count-label]').textContent = `${cart.count()} sản phẩm`);
    $('[data-ck-subtotal]') && ($('[data-ck-subtotal]').textContent = money(tt.sub));
    $('[data-ck-est]') && ($('[data-ck-est]').textContent = money(tt.sub));
    const freeMsg = $('[data-ck-free-msg]');
    if (freeMsg) {
      freeMsg.textContent = freeOk
        ? 'Đơn hàng được miễn phí giao hàng tiêu chuẩn.'
        : `Mua thêm ${money(freeAt - freeNet)} để được miễn phí giao hàng tiêu chuẩn.`;
    }
    const bar = $('[data-ck-free-bar]');
    if (bar) bar.style.width = Math.min(100, Math.round((freeNet / freeAt) * 100)) + '%';

    const ul = $('[data-ck-lines]');
    if (!ul) return;
    ul.innerHTML = list
      .map((i) => {
        const line = (i.price || 0) * (i.qty || 1);
        const href = i.url || (window.SoulTheme?.shop || '/products/');
        return `<li class="s-ck-line" data-id="${esc(i.id)}">
          <a class="s-ck-line__media" href="${esc(href)}">${i.img ? `<img src="${esc(i.img)}" alt="">` : ''}</a>
          <div class="s-ck-line__body">
            <div class="s-ck-line__info">
              <a class="s-ck-line__name" href="${esc(href)}">${esc(i.name || '')}</a>
              <span class="s-ck-line__meta">${esc(i.variant || i.type || '')}</span>
              <span class="s-ck-line__unit">${money(i.price || 0)} / sản phẩm</span>
            </div>
            <div class="s-ck-line__ops">
              <span class="s-ck-line__total">${money(line)}</span>
              <div class="s-ck-stepper" role="group" aria-label="Số lượng">
                <button type="button" data-ck-dec aria-label="−">−</button>
                <span>${i.qty || 1}</span>
                <button type="button" data-ck-inc aria-label="+">+</button>
              </div>
              <button type="button" class="s-ck-line__remove" data-ck-remove>Xóa</button>
            </div>
          </div>
        </li>`;
      })
      .join('');
  }

  function renderMini(targetSel) {
    const el = $(targetSel);
    if (!el) return;
    el.innerHTML = items()
      .map((i) => {
        const line = (i.price || 0) * (i.qty || 1);
        return `<li class="s-ck-mini__row">
          <span class="s-ck-mini__thumb">${i.img ? `<img src="${esc(i.img)}" alt="">` : ''}<span class="s-ck-mini__qty">${i.qty || 1}</span></span>
          <span class="s-ck-mini__meta"><span class="s-ck-mini__name">${esc(i.name || '')}</span><span class="s-ck-mini__var">${esc(i.variant || i.type || '')}</span></span>
          <span class="s-ck-mini__price">${money(line)}</span>
        </li>`;
      })
      .join('');
  }

  function renderPaySummary() {
    const tt = totals(state);
    const ui = checkoutUi();
    const intl = state.ship === 'intl';
    renderMini('[data-ck-mini]');
    const dl = $('[data-ck-lines]');
    if (dl) {
      const shipLabel = !ui.shippingMethods
        ? 'Soul liên hệ xác nhận'
        : intl
          ? 'Báo phí qua email'
          : tt.ship
            ? money(tt.ship)
            : 'Miễn phí';
      const rows = [
        ['Tạm tính', money(tt.sub)],
        ...(tt.disc ? [['Giảm giá (' + state.applied + ')', '−' + money(tt.disc)]] : []),
        ['Giao hàng', shipLabel],
      ];
      dl.innerHTML = rows.map(([k, v]) => `<div><dt>${esc(k)}</dt><dd>${esc(v)}</dd></div>`).join('');
    }
    $('[data-ck-total]') && ($('[data-ck-total]').textContent = money(tt.total));
    const place = $('[data-ck-place]');
    if (place) place.textContent = 'Đặt hàng · ' + money(tt.total);

    const msg = $('[data-ck-code-msg]');
    if (msg) {
      msg.hidden = !state.codeMsg;
      msg.textContent = state.codeMsg;
      msg.classList.toggle('is-ok', !!state.applied);
      msg.classList.toggle('is-bad', !state.applied && !!state.codeMsg);
    }
  }

  function clearFieldErrors() {
    $$('.s-ck-field').forEach((f) => f.classList.remove('is-invalid'));
    $$('[data-err-for]').forEach((e) => {
      e.hidden = true;
      e.textContent = '';
    });
  }

  function showErr(key, text) {
    const span = $(`[data-err-for="${key}"]`);
    if (!span) return;
    span.hidden = false;
    span.textContent = text;
    span.closest('.s-ck-field')?.classList.add('is-invalid');
  }

  function validate(fd) {
    const errs = {};
    const email = String(fd.get('email') || '').trim();
    const phoneRaw = String(fd.get('phone') || '').replace(/[\s.\-()]/g, '');
    const name = String(fd.get('name') || '').trim();
    const ui = checkoutUi();
    const ship = ui.shippingMethods ? state.ship : 'arrange';
    if (!email) errs.email = 'Vui lòng điền thông tin này.';
    else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) errs.email = 'Email chưa đúng định dạng.';
    const ph = phoneRaw.replace(/^\+84/, '0');
    if (!phoneRaw) errs.phone = 'Vui lòng điền thông tin này.';
    else if (ship === 'intl' ? !/^\+?\d{7,15}$/.test(phoneRaw) : !/^0\d{9}$/.test(ph)) {
      errs.phone = ship === 'intl' ? 'Số điện thoại kèm mã quốc gia, ví dụ +1 202 555 0100.' : 'Số điện thoại gồm 10 chữ số, bắt đầu bằng 0.';
    }
    if (!name) errs.name = 'Vui lòng điền thông tin này.';
    if (ship === 'intl') {
      if (!String(fd.get('address') || '').trim()) errs.address = 'Vui lòng điền thông tin này.';
      if (!String(fd.get('country') || '').trim()) errs.country = 'Vui lòng điền thông tin này.';
      if (!String(fd.get('city') || '').trim()) errs.city = 'Vui lòng điền thông tin này.';
    } else if (ship !== 'pickup') {
      // arrange (methods off) + std/exp still need VN address
      if (!String(fd.get('address') || '').trim()) errs.address = 'Vui lòng điền thông tin này.';
      if (!String(fd.get('province') || '').trim()) errs.province = 'Vui lòng điền thông tin này.';
      if (!String(fd.get('ward') || '').trim()) errs.ward = 'Vui lòng điền thông tin này.';
    }
    if (fd.get('vat_needed')) {
      if (!String(fd.get('vat_company') || '').trim()) errs.vat_company = 'Vui lòng điền thông tin này.';
      if (!String(fd.get('vat_tax_id') || '').trim()) errs.vat_tax_id = 'Vui lòng điền thông tin này.';
      if (!String(fd.get('vat_address') || '').trim()) errs.vat_address = 'Vui lòng điền thông tin này.';
      const ve = String(fd.get('vat_email') || '').trim();
      if (!ve) errs.vat_email = 'Vui lòng điền thông tin này.';
      else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(ve)) errs.vat_email = 'Email chưa đúng định dạng.';
    }
    return errs;
  }

  function renderDone(order) {
    if (!order) {
      setView('missing');
      return;
    }
    setView('done');
    const code = order.orderCode || order.id || '';
    const codeEl = document.getElementById('soul-order-code');
    if (codeEl) codeEl.textContent = code;
    const first = (order.name || '').trim().split(/\s+/).slice(-1)[0] || '';
    $('[data-ck-thanks]') && ($('[data-ck-thanks]').textContent = `Cảm ơn ${first}, Soul đã nhận đơn hàng của bạn.`);
    const ui = checkoutUi();
    let body = `Xác nhận đơn hàng đã được gửi tới ${order.email || ''}. Soul sẽ gọi xác nhận trong giờ làm việc và rang, đóng gói đơn của bạn trong vòng 24 giờ.`;
    if (order.storeName) body += ` Soul sẽ nhắn tin khi đơn sẵn sàng tại ${order.storeName}.`;
    if (order.shipping === 'intl') body += ' Soul sẽ gửi email báo phí và thời gian giao hàng quốc tế để bạn xác nhận trước khi thanh toán.';
    if (order.shipping === 'arrange' || order.payment === 'contact') {
      body += ` Soul sẽ liên hệ qua hotline ${ui.hotline} hoặc ${ui.email} để sắp xếp giao hàng và thanh toán.`;
    }
    $('[data-ck-done-body]') && ($('[data-ck-done-body]').textContent = body);

    const bank = $('[data-ck-bank]');
    if (bank) {
      bank.hidden = order.payment !== 'bank';
      const rows = $('[data-ck-bank-rows]');
      if (rows) {
        rows.innerHTML = [
          ['Ngân hàng', ui.bankName],
          ['Số tài khoản', ui.bankAccount],
          ['Chủ tài khoản', ui.bankAccountName],
          ['Nội dung', code],
        ]
          .map(([k, v]) => `<div><dt>${esc(k)}</dt><dd>${esc(v)}</dd></div>`)
          .join('');
      }
    }

    const contactBox = $('[data-ck-done-contact]');
    const contactBody = $('[data-ck-done-contact-body]');
    if (contactBox) {
      const showContact = order.payment === 'contact' || order.shipping === 'arrange';
      contactBox.hidden = !showContact;
      if (contactBody && showContact) {
        contactBody.textContent = `Hotline ${ui.hotline} · ${ui.email}. Admin sẽ liên hệ theo thông tin bạn đã gửi.`;
      }
    }

    const blocks = $('[data-ck-blocks]');
    if (blocks) {
      const shipLabel =
        {
          std: 'Giao hàng tiêu chuẩn',
          exp: 'Giao hàng nhanh',
          pickup: 'Nhận tại cửa hàng',
          intl: 'International Delivery',
          arrange: 'Soul liên hệ sắp xếp giao hàng',
        }[order.shipping] || '';
      const payLabel =
        {
          bank: 'Chuyển khoản ngân hàng',
          wallet: 'Ví điện tử / thẻ',
          cod: 'COD',
          contact: 'Soul liên hệ hướng dẫn thanh toán',
        }[order.payment] || order.payment;
      const addr =
        order.shipping === 'pickup'
          ? `${order.storeName || ''}\n${order.storeAddr || ''}`
          : order.shipping === 'intl'
            ? `${order.address || ''}\n${order.city || ''}, ${order.country || ''}`
            : `${order.address || ''}\n${order.ward || ''}, ${order.province || ''}`;
      blocks.innerHTML = [
        ['Liên hệ', `${order.name}\n${order.phone}\n${order.email}`],
        [order.shipping === 'pickup' ? 'Nhận tại' : 'Giao đến', addr],
        ['Thanh toán', payLabel + (shipLabel ? `\n${shipLabel}` : '')],
      ]
        .map(([k, v]) => `<div class="s-ck-block"><span class="s-ck-block__k">${esc(k)}</span><span class="s-ck-block__v">${esc(v)}</span></div>`)
        .join('');
    }

    const track = $('[data-ck-track]');
    if (track) {
      const TRACK = trackLabels();
      track.innerHTML = TRACK.map(
        (label, i) =>
          `<li class="${i === 0 ? 'is-on' : ''}"><span class="s-ck-track__n">${String(i + 1).padStart(2, '0')}</span><span class="s-ck-track__label">${esc(label)}</span></li>`
      ).join('');
    }

    const mini = $('[data-ck-done-mini]');
    if (mini) {
      mini.innerHTML = (order.items || [])
        .map((i) => {
          const line = (i.price || 0) * (i.qty || 1);
          return `<li class="s-ck-mini__row">
            <span class="s-ck-mini__thumb">${i.img ? `<img src="${esc(i.img)}" alt="">` : ''}<span class="s-ck-mini__qty">${i.qty || 1}</span></span>
            <span class="s-ck-mini__meta"><span class="s-ck-mini__name">${esc(i.name || '')}</span><span class="s-ck-mini__var">${esc(i.variant || '')}</span></span>
            <span class="s-ck-mini__price">${money(line)}</span>
          </li>`;
        })
        .join('');
    }
    const dl = $('[data-ck-done-lines]');
    if (dl) {
      const shipName =
        {
          std: 'Giao hàng tiêu chuẩn',
          exp: 'Giao hàng nhanh',
          pickup: 'Nhận tại cửa hàng',
          intl: 'International Delivery',
          arrange: 'Giao hàng',
        }[order.shipping] || 'Giao hàng';
      const shipVal =
        order.shipping === 'intl'
          ? 'Báo phí qua email'
          : order.shipping === 'arrange'
            ? 'Soul liên hệ xác nhận'
            : order.shipFee
              ? money(order.shipFee)
              : 'Miễn phí';
      const rows = [
        ['Tạm tính', money(order.sub || 0)],
        ...(order.disc ? [['Giảm giá', '−' + money(order.disc)]] : []),
        [shipName, shipVal],
      ];
      dl.innerHTML = rows.map(([k, v]) => `<div><dt>${esc(k)}</dt><dd>${esc(v)}</dd></div>`).join('');
    }
    $('[data-ck-done-total]') && ($('[data-ck-done-total]').textContent = money(order.total || 0));
  }

  function paint() {
    const route = parseRoute();
    const list = items();

    if (route.kind === 'done') {
      setSteps(2);
      const ord = state.lastOrder && (state.lastOrder.orderCode === route.id || String(state.lastOrder.orderId) === route.id)
        ? state.lastOrder
        : null;
      if (ord) renderDone(ord);
      else setView('missing');
      return;
    }

    if (route.kind === 'checkout') {
      if (!list.length) {
        go('');
        return;
      }
      setSteps(1);
      setView('checkout');
      syncShipUI();
      renderPaySummary();
      return;
    }

    setSteps(0);
    setView('cart', list.length === 0);
    if (list.length) {
      renderCart();
      syncShipUI();
    }
  }

  // Events
  $('[data-ck-clear]')?.addEventListener('click', async () => {
    for (const i of [...items()]) await cart.remove(i.id);
  });

  $('[data-ck-lines]')?.addEventListener('click', async (e) => {
    const row = e.target.closest('[data-id]');
    if (!row) return;
    const id = row.dataset.id;
    const item = items().find((x) => x.id === id);
    if (!item) return;
    if (e.target.closest('[data-ck-inc]')) await cart.setQty(id, (item.qty || 1) + 1);
    if (e.target.closest('[data-ck-dec]')) await cart.setQty(id, Math.max(0, (item.qty || 1) - 1));
    if (e.target.closest('[data-ck-remove]')) await cart.remove(id);
  });

  $('[data-ck-go-checkout]')?.addEventListener('click', (e) => {
    e.preventDefault();
    go('checkout');
    paint();
  });
  $$('[data-ck-go-cart], .s-ck-submit .s-ck-back').forEach((a) => {
    a.addEventListener('click', (e) => {
      e.preventDefault();
      go('');
      paint();
    });
  });

  $('[data-ck-ships]')?.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-ship]');
    if (!btn) return;
    state.ship = btn.dataset.ship;
    syncShipUI();
    renderPaySummary();
  });
  $('[data-ck-stores]')?.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-store]');
    if (!btn) return;
    state.store = btn.dataset.store;
    $$('[data-ck-stores] [data-store]').forEach((b) => {
      const on = b === btn;
      b.classList.toggle('is-on', on);
      b.setAttribute('aria-checked', on ? 'true' : 'false');
    });
    const inp = $('[data-ck-store-input]');
    if (inp) inp.value = state.store;
  });
  $('[data-ck-pays]')?.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-pay]');
    if (!btn) return;
    state.pay = btn.dataset.pay;
    $$('[data-ck-pays] [data-pay]').forEach((b) => {
      const on = b === btn;
      b.classList.toggle('is-on', on);
      b.setAttribute('aria-checked', on ? 'true' : 'false');
    });
    const inp = $('[data-ck-pay-input]');
    if (inp) inp.value = state.pay;
  });

  document.getElementById('soul-vat-needed')?.addEventListener('change', (e) => {
    const box = document.getElementById('soul-vat-fields');
    if (box) box.hidden = !e.target.checked;
  });

  $('[data-ck-apply]')?.addEventListener('click', () => {
    const raw = ($('[data-ck-code]')?.value || '').trim().toUpperCase();
    const codes = checkoutUi().promoCodes;
    if (codes[raw]) {
      state.applied = raw;
      state.codeMsg = `Đã áp dụng mã ${raw}.`;
    } else {
      state.applied = null;
      state.codeMsg = 'Mã không hợp lệ hoặc đã hết hạn.';
    }
    renderPaySummary();
  });

  const form = document.getElementById('soul-checkout-form');
  form?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const list = items();
    const errBox = document.getElementById('soul-form-error');
    if (!list.length) {
      go('');
      paint();
      return;
    }
    const fd = new FormData(form);
    clearFieldErrors();
    const errs = validate(fd);
    if (Object.keys(errs).length) {
      Object.entries(errs).forEach(([k, v]) => showErr(k, v));
      if (errBox) {
        errBox.hidden = false;
        errBox.textContent = 'Vui lòng kiểm tra các trường được đánh dấu.';
      }
      const first = Object.keys(errs)[0];
      $(`[data-err-for="${first}"]`)?.closest('.s-ck-field')?.querySelector('input, select')?.focus();
      return;
    }
    if (errBox) errBox.hidden = true;

    applyCommerceModes();
    const tt = totals(state);
    const store = checkoutUi().pickupStores[state.store];
    const payload = {
      name: String(fd.get('name') || '').trim(),
      email: String(fd.get('email') || '').trim(),
      phone: String(fd.get('phone') || '').trim(),
      address: String(fd.get('address') || '').trim(),
      province: String(fd.get('province') || '').trim(),
      ward: String(fd.get('ward') || '').trim(),
      city: String(fd.get('city') || '').trim(),
      country: String(fd.get('country') || '').trim(),
      note: String(fd.get('note') || ''),
      shipping: state.ship,
      store: state.ship === 'pickup' ? state.store : '',
      store_name: state.ship === 'pickup' ? store?.name || '' : '',
      store_addr: state.ship === 'pickup' ? store?.addr || '' : '',
      payment: state.pay,
      website: fd.get('website') || '',
      recaptchaToken: await getRecaptchaToken('checkout'),
      vat_needed: !!fd.get('vat_needed'),
      vat_company: fd.get('vat_company') || '',
      vat_tax_id: fd.get('vat_tax_id') || '',
      vat_email: fd.get('vat_email') || '',
      vat_address: fd.get('vat_address') || '',
      vat_buyer: fd.get('vat_buyer') || '',
      code: state.applied || '',
      subtotal: tt.sub,
      discount: tt.disc,
      shipping_fee: tt.ship,
      total: tt.total,
      items: list.map((i) => ({
        id: i.id,
        name: i.name,
        variant: i.variant || i.type || '',
        price: i.price || 0,
        qty: i.qty || 1,
        img: i.img || '',
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

      state.lastOrder = {
        ...payload,
        orderId: data.orderId,
        orderCode: data.orderCode || ('SOUL-' + data.orderId),
        storeName: payload.store_name,
        storeAddr: payload.store_addr,
        disc: tt.disc,
        shipFee: tt.ship,
        sub: tt.sub,
        total: tt.total,
      };
      try {
        sessionStorage.setItem('soul-last-order', JSON.stringify(state.lastOrder));
      } catch (_) { /* ignore */ }

      for (const i of [...list]) await cart.remove(i.id);
      state.applied = null;
      state.codeMsg = '';
      go('done/' + encodeURIComponent(state.lastOrder.orderCode));
      paint();
    } catch (ex) {
      if (errBox) {
        errBox.hidden = false;
        errBox.textContent = ex.message || 'Lỗi gửi đơn.';
      }
    } finally {
      if (btn) btn.disabled = false;
    }
  });

  window.addEventListener('hashchange', paint);
  cart.subscribe(paint);
  bus.on('cart:change', paint);

  try {
    const cached = JSON.parse(sessionStorage.getItem('soul-last-order') || 'null');
    if (cached) state.lastOrder = cached;
  } catch (_) { /* ignore */ }

  paint();
}
