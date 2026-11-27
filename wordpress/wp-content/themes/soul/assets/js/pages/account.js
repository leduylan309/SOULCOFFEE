/**
 * Account — SoT html/Account.dc.html
 * Hash: #login | #register | #recover | # | #orders | #orders/{code} | #addresses | #profile
 */
import { cart } from '../services/cart.js';
import { getRecaptchaToken } from '../services/recaptcha.js';

const AUTH = ['login', 'register', 'recover'];
const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const phoneOk = (v) => /^0\d{9}$/.test(String(v || '').replace(/[\s.\-]/g, '').replace(/^\+84/, '0'));

const T = {
  vi: {
    loginTitle: 'Chào mừng trở lại',
    loginIntro: 'Đăng nhập để xem đơn hàng và thanh toán nhanh hơn.',
    registerTitle: 'Tạo tài khoản',
    registerIntro: 'Chỉ mất một phút, để Soul đồng hành cùng gu cà phê của bạn.',
    recoverTitle: 'Khôi phục mật khẩu',
    recoverIntro: 'Nhập email đã đăng ký, Soul sẽ gửi đường dẫn đặt lại mật khẩu.',
    loginTab: 'Đăng nhập',
    registerTab: 'Đăng ký',
    noAcc: 'Chưa có tài khoản?',
    hasAcc: 'Đã có tài khoản?',
    backLogin: 'Nhớ mật khẩu rồi?',
    req: 'Vui lòng điền thông tin này.',
    badEmail: 'Email chưa đúng định dạng.',
    badPhone: 'Số điện thoại gồm 10 chữ số, bắt đầu bằng 0.',
    shortPw: 'Mật khẩu cần ít nhất 8 ký tự.',
    mismatch: 'Mật khẩu nhập lại không khớp.',
    mustAgree: 'Vui lòng đồng ý để tiếp tục.',
    wrong: 'Email hoặc mật khẩu không đúng.',
    taken: 'Email này đã được đăng ký. Hãy đăng nhập.',
    recoverSent: (x) => `Nếu email ${x} đã đăng ký, đường dẫn đặt lại mật khẩu sẽ được gửi trong vài phút.`,
    needLogin: 'Vui lòng đăng nhập để tiếp tục.',
    welcome: 'Tài khoản đã được tạo. Chào mừng bạn đến với Soul!',
    loggedOut: 'Bạn đã đăng xuất.',
    overview: 'Tổng quan',
    orders: 'Đơn hàng',
    addresses: 'Sổ địa chỉ',
    profile: 'Thông tin tài khoản',
    hello: (x) => `Xin chào, ${x}`,
    lastOrder: 'Đơn gần nhất',
    noOrderYet: 'Chưa có đơn hàng',
    noOrderBody: 'Khám phá Soulful 2026 để bắt đầu.',
    defAddr: 'Địa chỉ mặc định',
    noAddr: 'Chưa có địa chỉ',
    noAddrBody: 'Thêm địa chỉ để thanh toán nhanh hơn.',
    details: 'Thông tin cá nhân',
    viewAll: 'Xem tất cả',
    shopNow: 'Mua sắm',
    manage: 'Quản lý',
    editCta: 'Chỉnh sửa',
    view: 'Xem',
    items: 'sản phẩm',
    status: ['Chờ xác nhận', 'Đã xác nhận', 'Đang giao', 'Đã nhận hàng'],
    cancelledS: 'Đã hủy',
    track: ['Đã đặt hàng', 'Đã xác nhận', 'Đang giao', 'Đã nhận hàng'],
    pay: { cod: 'Thanh toán khi nhận hàng', bank: 'Chuyển khoản ngân hàng', wallet: 'Ví điện tử / thẻ' },
    ship: { std: 'Giao tiêu chuẩn', exp: 'Giao nhanh', pickup: 'Nhận tại cửa hàng', intl: 'Quốc tế' },
    subtotal: 'Tạm tính',
    discount: 'Giảm giá',
    free: 'Miễn phí',
    total: 'Tổng cộng',
    placed: 'Ngày đặt',
    shipTo: 'Giao đến',
    pickAt: 'Nhận tại',
    payBy: 'Thanh toán',
    default: 'Mặc định',
    edit: 'Sửa',
    setDefault: 'Đặt làm mặc định',
    remove: 'Xóa',
    addAddr: 'Thêm địa chỉ',
    newAddrT: 'Địa chỉ mới',
    editAddrT: 'Sửa địa chỉ',
    saved: 'Đã lưu thay đổi.',
    pwSaved: 'Đã cập nhật mật khẩu.',
    addrSaved: 'Đã lưu địa chỉ.',
    cancelled: 'Đơn hàng đã được hủy.',
  },
  en: {
    loginTitle: 'Welcome back',
    loginIntro: 'Sign in to see your orders and check out faster.',
    registerTitle: 'Create an account',
    registerIntro: 'It takes a minute, and lets Soul follow your taste in coffee.',
    recoverTitle: 'Reset password',
    recoverIntro: 'Enter your account email and we’ll send a reset link.',
    loginTab: 'Sign in',
    registerTab: 'Register',
    noAcc: 'New to Soul?',
    hasAcc: 'Already have an account?',
    backLogin: 'Remembered it?',
    req: 'This field is required.',
    badEmail: 'Please enter a valid email.',
    badPhone: 'Phone must be 10 digits starting with 0.',
    shortPw: 'Use at least 8 characters.',
    mismatch: 'Passwords don’t match.',
    mustAgree: 'Please agree to continue.',
    wrong: 'Incorrect email or password.',
    taken: 'This email is already registered. Please sign in.',
    recoverSent: (x) => `If ${x} is registered, a reset link will arrive in a few minutes.`,
    needLogin: 'Please sign in to continue.',
    welcome: 'Your account is ready. Welcome to Soul!',
    loggedOut: 'You’ve been signed out.',
    overview: 'Overview',
    orders: 'Orders',
    addresses: 'Addresses',
    profile: 'Account details',
    hello: (x) => `Hello, ${x}`,
    lastOrder: 'Latest order',
    noOrderYet: 'No orders yet',
    noOrderBody: 'Explore Soulful 2026 to get started.',
    defAddr: 'Default address',
    noAddr: 'No address yet',
    noAddrBody: 'Add one for faster checkout.',
    details: 'Personal details',
    viewAll: 'View all',
    shopNow: 'Shop now',
    manage: 'Manage',
    editCta: 'Edit',
    view: 'View',
    items: 'items',
    status: ['Awaiting confirmation', 'Confirmed', 'Shipping', 'Delivered'],
    cancelledS: 'Cancelled',
    track: ['Placed', 'Confirmed', 'Shipping', 'Delivered'],
    pay: { cod: 'Cash on delivery', bank: 'Bank transfer', wallet: 'E-wallet / card' },
    ship: { std: 'Standard delivery', exp: 'Express delivery', pickup: 'Store pickup', intl: 'International' },
    subtotal: 'Subtotal',
    discount: 'Discount',
    free: 'Free',
    total: 'Total',
    placed: 'Placed on',
    shipTo: 'Ship to',
    pickAt: 'Pick up at',
    payBy: 'Payment',
    default: 'Default',
    edit: 'Edit',
    setDefault: 'Set as default',
    remove: 'Remove',
    addAddr: 'Add address',
    newAddrT: 'New address',
    editAddrT: 'Edit address',
    saved: 'Changes saved.',
    pwSaved: 'Password updated.',
    addrSaved: 'Address saved.',
    cancelled: 'This order has been cancelled.',
  },
};

function lang() {
  const fromTheme = window.SoulTheme && window.SoulTheme.lang;
  if (fromTheme === 'en' || fromTheme === 'vi') return fromTheme;
  const html = document.documentElement.getAttribute('data-soul-lang') || '';
  if (html === 'en' || html === 'vi') return html;
  return document.body.classList.contains('soul-lang-en') ? 'en' : 'vi';
}

function t() {
  // Prefer localized bag from PHP when present; keep large T map as fallback.
  const bag = window.SoulTheme && window.SoulTheme.i18n && window.SoulTheme.i18n.account;
  const base = T[lang()] || T.vi;
  return bag ? { ...base, ...bag } : base;
}

function cfg() {
  return window.SoulTheme || {};
}

function adoptNonce(data) {
  if (data?.nonce && window.SoulTheme) window.SoulTheme.nonce = data.nonce;
}

function rest(path, opts = {}) {
  const base = (cfg().restUrl || '/wp-json/soul/v1/').replace(/\/?$/, '/');
  const url = base + path.replace(/^\//, '');
  const headers = {
    'Content-Type': 'application/json',
    'X-WP-Nonce': cfg().nonce || '',
    ...(opts.headers || {}),
  };
  return fetch(url, { credentials: 'same-origin', ...opts, headers }).then(async (r) => {
    const data = await r.json().catch(() => ({}));
    if (!r.ok) {
      const msg = data?.message || data?.code || 'Error';
      const err = new Error(typeof msg === 'string' ? msg : 'Error');
      err.status = r.status;
      err.data = data;
      throw err;
    }
    adoptNonce(data);
    return data;
  });
}

function vnd(n) {
  return Number(n || 0).toLocaleString('vi-VN') + '₫';
}

function fmt(iso) {
  const d = new Date(iso);
  if (Number.isNaN(d.getTime())) return '';
  return [d.getDate(), d.getMonth() + 1, d.getFullYear()].map((n) => String(n).padStart(2, '0')).join('.');
}

function parseHash(hash) {
  const h = (hash || '').replace(/^#/, '');
  if (AUTH.includes(h)) return { kind: h };
  if (h === 'orders' || h === 'addresses' || h === 'profile') return { kind: h };
  const m = h.match(/^orders\/(.+)$/);
  if (m) return { kind: 'order', id: decodeURIComponent(m[1]) };
  return { kind: 'overview' };
}

function clearErrors(form) {
  form.querySelectorAll('[data-err-for]').forEach((el) => {
    el.hidden = true;
    el.textContent = '';
  });
  form.querySelectorAll('.is-invalid').forEach((el) => el.classList.remove('is-invalid'));
  const alert = form.querySelector('[data-acc-form-err]');
  if (alert) {
    alert.hidden = true;
    alert.textContent = '';
  }
}

function showErr(form, key, msg) {
  const field = form.querySelector(`[name="${key}"]`);
  if (field) field.classList.add('is-invalid');
  const err = form.querySelector(`[data-err-for="${key}"]`);
  if (err) {
    err.textContent = msg;
    err.hidden = false;
  }
}

function showNotice(el, text, tone) {
  if (!el) return;
  el.textContent = text;
  el.hidden = !text;
  el.classList.toggle('is-ok', tone === 'ok');
  el.classList.toggle('is-info', tone !== 'ok');
}

function statusLabel(st, tt) {
  if (st < 0) return tt.cancelledS;
  return tt.status[st] || tt.status[0];
}

function statusBadge(st) {
  if (st < 0) return 's-acc-badge s-acc-badge--cancel';
  if (st === 3) return 's-acc-badge s-acc-badge--done';
  return 's-acc-badge s-acc-badge--wait';
}

function firstName(name, email) {
  const parts = String(name || '').trim().split(/\s+/).filter(Boolean);
  return parts.length ? parts[parts.length - 1] : email;
}

function addrText(a) {
  return `${a.phone}\n${a.address}\n${a.ward}, ${a.province}`;
}

export default function initAccount() {
  const root = document.querySelector('[data-acc-root]');
  if (!root) return;

  const shop = root.dataset.shop || cfg().shop || '/products/';
  const checkout = root.dataset.checkout || cfg().checkout || '/checkout/';
  const authView = root.querySelector('[data-acc-view="auth"]');
  const dashView = root.querySelector('[data-acc-view="dash"]');
  const noticeAuth = root.querySelector('[data-acc-notice]');
  const noticeDash = root.querySelector('[data-acc-dash-notice]');

  let user = null;
  let orders = [];
  let editingAddr = null; // null | 'new' | id
  let currentOrderId = null;
  let pendingNotice = null;

  function go(h, notice) {
    const next = h ? '#' + h : location.pathname + location.search;
    history.replaceState(null, '', h ? '#' + h : location.pathname + location.search);
    if (notice !== undefined) pendingNotice = notice;
    route();
    window.scrollTo(0, 0);
    void next;
  }

  function setLoggedUI(logged) {
    root.dataset.logged = logged ? '1' : '0';
    if (authView) authView.hidden = !!logged;
    if (dashView) dashView.hidden = !logged;
  }

  function applyAuthChrome(kind) {
    const tt = t();
    const tabs = root.querySelector('[data-acc-tabs]');
    if (tabs) tabs.hidden = kind === 'recover';
    root.querySelectorAll('[data-acc-tab]').forEach((tab) => {
      const on = tab.getAttribute('data-acc-tab') === kind;
      tab.classList.toggle('is-on', on);
      tab.setAttribute('aria-selected', on ? 'true' : 'false');
    });
    const titles = {
      login: [tt.loginTitle, tt.loginIntro],
      register: [tt.registerTitle, tt.registerIntro],
      recover: [tt.recoverTitle, tt.recoverIntro],
    };
    const [title, intro] = titles[kind] || titles.login;
    const h = root.querySelector('[data-acc-auth-title]');
    const p = root.querySelector('[data-acc-auth-intro]');
    if (h) h.textContent = title;
    if (p) p.textContent = intro;
    root.querySelectorAll('[data-acc-form]').forEach((f) => {
      f.hidden = f.getAttribute('data-acc-form') !== kind;
    });
    const altText = root.querySelector('[data-acc-alt-text]');
    const altLink = root.querySelector('[data-acc-alt-link]');
    if (altText && altLink) {
      if (kind === 'login') {
        altText.textContent = tt.noAcc;
        altLink.textContent = tt.registerTab;
        altLink.href = '#register';
      } else if (kind === 'register') {
        altText.textContent = tt.hasAcc;
        altLink.textContent = tt.loginTab;
        altLink.href = '#login';
      } else {
        altText.textContent = tt.backLogin;
        altLink.textContent = tt.loginTab;
        altLink.href = '#login';
      }
    }
  }

  function setSide(active) {
    root.querySelectorAll('[data-acc-nav]').forEach((a) => {
      const on = a.getAttribute('data-acc-nav') === active;
      a.classList.toggle('is-on', on);
      if (on) a.setAttribute('aria-current', 'page');
      else a.removeAttribute('aria-current');
    });
    const oc = root.querySelector('[data-acc-nav-count="orders"]');
    const ac = root.querySelector('[data-acc-nav-count="addresses"]');
    if (oc) oc.textContent = String(orders.length);
    if (ac) ac.textContent = String((user?.addresses || []).length);
  }

  function setHero(kind, orderId) {
    const tt = t();
    const crumb = root.querySelector('[data-acc-crumb]');
    const title = root.querySelector('[data-acc-dash-title]');
    const email = root.querySelector('[data-acc-email]');
    const map = {
      overview: tt.overview,
      orders: tt.orders,
      order: tt.orders,
      addresses: tt.addresses,
      profile: tt.profile,
    };
    if (crumb) crumb.textContent = map[kind] || tt.overview;
    if (email && user) email.textContent = user.email;
    if (title) {
      if (kind === 'overview') title.textContent = tt.hello(firstName(user?.name, user?.email));
      else if (kind === 'order') title.textContent = '#' + orderId;
      else title.textContent = map[kind] || tt.overview;
    }
  }

  function showPanel(name) {
    root.querySelectorAll('[data-acc-panel]').forEach((p) => {
      p.hidden = p.getAttribute('data-acc-panel') !== name;
    });
  }

  function renderOverview() {
    const tt = t();
    const box = root.querySelector('[data-acc-cards]');
    if (!box || !user) return;
    const lo = orders[0];
    const addrs = user.addresses || [];
    const defA = addrs.find((a) => a.def) || addrs[0];
    const cards = [];
    if (lo) {
      cards.push({
        ink: true,
        k: tt.lastOrder,
        title: '#' + lo.id,
        body: `${fmt(lo.date)} · ${vnd(lo.total)}\n${statusLabel(lo.status, tt)}`,
        cta: tt.viewAll,
        href: '#orders',
      });
    } else {
      cards.push({
        ink: true,
        k: tt.lastOrder,
        title: tt.noOrderYet,
        body: tt.noOrderBody,
        cta: tt.shopNow,
        href: shop,
      });
    }
    if (defA) {
      cards.push({
        ink: false,
        k: tt.defAddr,
        title: defA.name,
        body: addrText(defA),
        cta: tt.manage,
        href: '#addresses',
      });
    } else {
      cards.push({
        ink: false,
        k: tt.defAddr,
        title: tt.noAddr,
        body: tt.noAddrBody,
        cta: tt.addAddr,
        href: '#addresses',
      });
    }
    cards.push({
      ink: false,
      k: tt.details,
      title: user.name,
      body: `${user.email}\n${user.phone}`,
      cta: tt.editCta,
      href: '#profile',
    });
    box.innerHTML = cards
      .map(
        (c) => `<a class="s-acc-card ${c.ink ? 's-acc-card--ink' : 's-acc-card--sand'}" href="${c.href}">
        <span class="s-acc-card__k">${c.k}</span>
        <span class="s-acc-card__title">${c.title}</span>
        <span class="s-acc-card__body">${c.body}</span>
        <span class="s-acc-card__cta">${c.cta} ↗</span>
      </a>`
      )
      .join('');
  }

  function renderOrders() {
    const tt = t();
    const empty = root.querySelector('[data-acc-orders-empty]');
    const list = root.querySelector('[data-acc-orders]');
    if (!list) return;
    if (empty) empty.hidden = orders.length > 0;
    list.hidden = orders.length === 0;
    list.innerHTML = orders
      .map((o) => {
        const count = o.items.reduce((a, x) => a + (x.qty || 1), 0);
        const thumbs = o.items
          .slice(0, 3)
          .map((x) => `<img src="${x.img || ''}" alt="" width="52" height="52">`)
          .join('');
        return `<li class="s-acc-orders__row">
          <div class="s-acc-orders__thumbs">${thumbs}</div>
          <div class="s-acc-orders__meta">
            <a href="#orders/${encodeURIComponent(o.id)}">#${o.id}</a>
            <span>${fmt(o.date)} · ${count} ${tt.items}</span>
          </div>
          <span class="${statusBadge(o.status)}">${statusLabel(o.status, tt)}</span>
          <span class="s-acc-orders__total">${vnd(o.total)}</span>
          <a class="s-acc-btn s-acc-btn--sm" href="#orders/${encodeURIComponent(o.id)}">${tt.view}</a>
        </li>`;
      })
      .join('');
  }

  function renderOrder(id) {
    const tt = t();
    const o = orders.find((x) => x.id === id);
    currentOrderId = o ? o.id : null;
    if (!o) {
      go('orders');
      return;
    }
    const cancelBtn = root.querySelector('[data-acc-cancel]');
    const cancelled = root.querySelector('[data-acc-order-cancelled]');
    if (cancelBtn) cancelBtn.hidden = o.status !== 0;
    if (cancelled) cancelled.hidden = o.status >= 0;

    const track = root.querySelector('[data-acc-track]');
    if (track) {
      track.hidden = o.status < 0;
      track.innerHTML = tt.track
        .map((label, i) => {
          const on = o.status >= 0 && i <= o.status;
          return `<li class="${on ? 'is-on' : ''}"><span class="s-acc-track__n">${String(i + 1).padStart(2, '0')}</span><span class="s-acc-track__l">${label}</span></li>`;
        })
        .join('');
    }

    const blocks = root.querySelector('[data-acc-blocks]');
    if (blocks) {
      const shipLabel = tt.ship[o.ship] || o.ship;
      const b = [
        { k: tt.placed, v: `${fmt(o.date)}\n${shipLabel}` },
        o.store
          ? { k: tt.pickAt, v: `${o.store.name}\n${o.store.addr}` }
          : {
              k: tt.shipTo,
              v: `${o.name} · ${o.phone}\n${o.addr?.address || ''}\n${o.addr?.ward || ''}, ${o.addr?.province || ''}`,
            },
        { k: tt.payBy, v: tt.pay[o.pay] || o.pay },
      ];
      blocks.innerHTML = b
        .map((x) => `<div class="s-acc-block"><span class="s-acc-block__k">${x.k}</span><span class="s-acc-block__v">${x.v}</span></div>`)
        .join('');
    }

    const items = root.querySelector('[data-acc-items]');
    if (items) {
      items.innerHTML = o.items
        .map(
          (x) => `<li>
          <img src="${x.img || ''}" alt="" width="72" height="72">
          <span><a class="s-acc-items__name" href="${shop}">${x.name}</a><span class="s-acc-items__meta">${x.variant} · ${vnd(x.price)} × ${x.qty}</span></span>
          <span class="s-acc-items__price">${vnd(x.price * x.qty)}</span>
        </li>`
        )
        .join('');
    }

    const totals = root.querySelector('[data-acc-totals]');
    if (totals) {
      const shipFee = o.shipFee ? vnd(o.shipFee) : tt.free;
      const shipLabel = tt.ship[o.ship] || o.ship;
      let html = `<div><dt>${tt.subtotal}</dt><dd>${vnd(o.sub)}</dd></div>`;
      if (o.disc) html += `<div><dt>${tt.discount}</dt><dd>−${vnd(o.disc)}</dd></div>`;
      html += `<div><dt>${shipLabel}</dt><dd>${shipFee}</dd></div>`;
      html += `<div class="s-acc-totals__grand"><dt>${tt.total}</dt><dd>${vnd(o.total)}</dd></div>`;
      totals.innerHTML = html;
    }
  }

  function renderAddresses() {
    const tt = t();
    const wrap = root.querySelector('[data-acc-addrs]');
    const form = root.querySelector('[data-acc-addr-form]');
    if (!wrap) return;
    const addrs = user?.addresses || [];
    if (editingAddr) {
      wrap.hidden = true;
      if (form) {
        form.hidden = false;
        const cur = editingAddr === 'new' ? null : addrs.find((a) => a.id === editingAddr);
        const title = form.querySelector('[data-acc-addr-title]');
        if (title) title.textContent = cur ? tt.editAddrT : tt.newAddrT;
        form.name.value = cur?.name || user?.name || '';
        form.phone.value = cur?.phone || user?.phone || '';
        form.address.value = cur?.address || '';
        form.ward.value = cur?.ward || '';
        form.province.value = cur?.province || '';
        form.def.checked = cur ? !!cur.def : addrs.length === 0;
        form.dataset.editId = cur?.id || '';
        clearErrors(form);
      }
      return;
    }
    wrap.hidden = false;
    if (form) form.hidden = true;
    wrap.innerHTML =
      addrs
        .map(
          (a) => `<div class="s-acc-addr ${a.def ? 'is-def' : ''}" data-addr-id="${a.id}">
        <div class="s-acc-addr__top">
          <span class="s-acc-addr__name">${a.name}</span>
          ${a.def ? `<span class="s-acc-addr__def">${tt.default}</span>` : ''}
        </div>
        <span class="s-acc-addr__text">${addrText(a)}</span>
        <div class="s-acc-addr__acts">
          <button type="button" data-addr-edit="${a.id}">${tt.edit}</button>
          ${!a.def ? `<button type="button" data-addr-def="${a.id}">${tt.setDefault}</button>` : ''}
          <button type="button" class="is-danger" data-addr-del="${a.id}">${tt.remove}</button>
        </div>
      </div>`
        )
        .join('') +
      `<button type="button" class="s-acc-addr-add" data-addr-new>+ ${tt.addAddr}</button>`;
  }

  function fillProfile() {
    const form = root.querySelector('[data-acc-profile-form]');
    if (!form || !user) return;
    form.name.value = user.name || '';
    form.phone.value = user.phone || '';
    form.email.value = user.email || '';
    form.marketing.checked = !!user.marketing;
    clearErrors(form);
  }

  function route() {
    let r = parseHash(location.hash);
    const tt = t();

    if (!user && !AUTH.includes(r.kind)) {
      r = { kind: 'login' };
      if (!pendingNotice) pendingNotice = { text: tt.needLogin, tone: 'info' };
      history.replaceState(null, '', '#login');
    }
    if (user && AUTH.includes(r.kind)) {
      r = { kind: 'overview' };
      history.replaceState(null, '', location.pathname + location.search);
    }

    setLoggedUI(!!user);

    if (AUTH.includes(r.kind)) {
      applyAuthChrome(r.kind);
      if (pendingNotice) {
        showNotice(noticeAuth, pendingNotice.text, pendingNotice.tone);
        pendingNotice = null;
      } else {
        showNotice(noticeAuth, '', 'info');
      }
      return;
    }

    const side = r.kind === 'order' ? 'orders' : r.kind;
    setSide(side);
    setHero(r.kind, r.id);
    showPanel(r.kind === 'order' ? 'order' : r.kind);

    if (pendingNotice) {
      showNotice(noticeDash, pendingNotice.text, pendingNotice.tone);
      pendingNotice = null;
    }

    if (r.kind === 'overview') renderOverview();
    if (r.kind === 'orders') renderOrders();
    if (r.kind === 'order') renderOrder(r.id);
    if (r.kind === 'addresses') renderAddresses();
    if (r.kind === 'profile') fillProfile();
  }

  async function refreshMe() {
    const data = await rest('auth/me');
    if (data.loggedIn && data.user) {
      user = data.user;
      orders = data.orders || [];
    } else {
      user = null;
      orders = [];
    }
  }

  // —— Auth forms ——
  root.querySelector('[data-acc-form="login"]')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const form = e.currentTarget;
    const tt = t();
    clearErrors(form);
    const email = form.email.value.trim();
    const password = form.password.value;
    let bad = false;
    if (!email) {
      showErr(form, 'email', tt.req);
      bad = true;
    } else if (!EMAIL_RE.test(email)) {
      showErr(form, 'email', tt.badEmail);
      bad = true;
    }
    if (!password) {
      showErr(form, 'password', tt.req);
      bad = true;
    }
    if (bad) return;
    try {
      const recaptchaToken = await getRecaptchaToken('login');
      const data = await rest('auth/login', {
        method: 'POST',
        body: JSON.stringify({ email, password, recaptchaToken }),
      });
      user = data.user;
      orders = data.orders || [];
      go('', null);
    } catch (err) {
      const alert = form.querySelector('[data-acc-form-err]');
      if (alert) {
        alert.textContent = err.status === 400 || err.status === 403 ? err.message || tt.wrong : tt.wrong;
        alert.hidden = false;
      }
    }
  });

  root.querySelector('[data-acc-form="register"]')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const form = e.currentTarget;
    const tt = t();
    clearErrors(form);
    const name = form.name.value.trim();
    const email = form.email.value.trim();
    const phone = form.phone.value.trim();
    const password = form.password.value;
    const password2 = form.password2.value;
    let bad = false;
    if (!name) {
      showErr(form, 'name', tt.req);
      bad = true;
    }
    if (!email) {
      showErr(form, 'email', tt.req);
      bad = true;
    } else if (!EMAIL_RE.test(email)) {
      showErr(form, 'email', tt.badEmail);
      bad = true;
    }
    if (!phone) {
      showErr(form, 'phone', tt.req);
      bad = true;
    } else if (!phoneOk(phone)) {
      showErr(form, 'phone', tt.badPhone);
      bad = true;
    }
    if (password.length < 8) {
      showErr(form, 'password', tt.shortPw);
      bad = true;
    }
    if (password2 !== password || !password2) {
      showErr(form, 'password2', tt.mismatch);
      bad = true;
    }
    if (!form.agree.checked) {
      showErr(form, 'agree', tt.mustAgree);
      bad = true;
    }
    if (bad) return;
    try {
      const recaptchaToken = await getRecaptchaToken('register');
      const data = await rest('auth/register', {
        method: 'POST',
        body: JSON.stringify({
          name,
          email,
          phone,
          password,
          marketing: !!form.marketing.checked,
          recaptchaToken,
        }),
      });
      user = data.user;
      orders = [];
      go('', { text: tt.welcome, tone: 'ok' });
    } catch (err) {
      const alert = form.querySelector('[data-acc-form-err]');
      const msg = err.status === 409 ? tt.taken : err.message || tt.taken;
      if (alert) {
        alert.textContent = msg;
        alert.hidden = false;
      }
    }
  });

  root.querySelector('[data-acc-form="recover"]')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const form = e.currentTarget;
    const tt = t();
    clearErrors(form);
    const email = form.email.value.trim();
    if (!email) {
      showErr(form, 'email', tt.req);
      return;
    }
    if (!EMAIL_RE.test(email)) {
      showErr(form, 'email', tt.badEmail);
      return;
    }
    try {
      const recaptchaToken = await getRecaptchaToken('recover');
      await rest('auth/recover', { method: 'POST', body: JSON.stringify({ email, recaptchaToken }) });
      showNotice(noticeAuth, tt.recoverSent(email), 'ok');
    } catch (err) {
      if (err.status === 400 || err.status === 403) {
        showNotice(noticeAuth, err.message || tt.recoverSent(email), 'info');
      } else {
        showNotice(noticeAuth, tt.recoverSent(email), 'ok');
      }
    }
  });

  root.querySelector('[data-acc-logout]')?.addEventListener('click', async () => {
    const tt = t();
    try {
      await rest('auth/logout', { method: 'POST', body: '{}' });
    } catch (_) {}
    user = null;
    orders = [];
    go('login', { text: tt.loggedOut, tone: 'info' });
  });

  // Side nav / hash links
  root.addEventListener('click', (e) => {
    const goto = e.target.closest('[data-acc-goto]');
    if (goto) {
      e.preventDefault();
      go(goto.getAttribute('data-acc-goto'));
      return;
    }
    const nav = e.target.closest('[data-acc-nav]');
    if (nav) {
      e.preventDefault();
      const k = nav.getAttribute('data-acc-nav');
      go(k === 'overview' ? '' : k);
      return;
    }
    const tab = e.target.closest('[data-acc-tab]');
    if (tab) {
      e.preventDefault();
      go(tab.getAttribute('data-acc-tab'));
      return;
    }
    const alt = e.target.closest('[data-acc-alt-link]');
    if (alt) {
      e.preventDefault();
      go((alt.getAttribute('href') || '#login').replace(/^#/, ''));
      return;
    }
    if (e.target.closest('[data-addr-new]')) {
      editingAddr = 'new';
      renderAddresses();
      return;
    }
    const edit = e.target.closest('[data-addr-edit]');
    if (edit) {
      editingAddr = edit.getAttribute('data-addr-edit');
      renderAddresses();
      return;
    }
    const del = e.target.closest('[data-addr-del]');
    if (del) {
      const id = del.getAttribute('data-addr-del');
      rest(`account/addresses/${encodeURIComponent(id)}`, { method: 'DELETE' }).then((data) => {
        if (user) user.addresses = data.addresses || [];
        renderAddresses();
        setSide('addresses');
      });
      return;
    }
    const def = e.target.closest('[data-addr-def]');
    if (def) {
      const id = def.getAttribute('data-addr-def');
      rest(`account/addresses/${encodeURIComponent(id)}`, {
        method: 'POST',
        body: JSON.stringify({ makeDefault: true }),
      }).then((data) => {
        if (user) user.addresses = data.addresses || [];
        renderAddresses();
      });
    }
  });

  root.querySelector('[data-acc-addr-cancel]')?.addEventListener('click', () => {
    editingAddr = null;
    renderAddresses();
  });

  root.querySelector('[data-acc-addr-form]')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const form = e.currentTarget;
    const tt = t();
    clearErrors(form);
    const payload = {
      name: form.name.value.trim(),
      phone: form.phone.value.trim(),
      address: form.address.value.trim(),
      ward: form.ward.value.trim(),
      province: form.province.value,
      def: !!form.def.checked,
    };
    if (form.dataset.editId) payload.id = form.dataset.editId;
    let bad = false;
    ['name', 'address', 'ward', 'province', 'phone'].forEach((k) => {
      if (!payload[k]) {
        showErr(form, k, tt.req);
        bad = true;
      }
    });
    if (payload.phone && !phoneOk(payload.phone)) {
      showErr(form, 'phone', tt.badPhone);
      bad = true;
    }
    if (bad) return;
    try {
      const data = await rest('account/addresses', {
        method: 'POST',
        body: JSON.stringify(payload),
      });
      if (user) user.addresses = data.addresses || [];
      editingAddr = null;
      pendingNotice = { text: tt.addrSaved, tone: 'ok' };
      renderAddresses();
      showNotice(noticeDash, tt.addrSaved, 'ok');
      setSide('addresses');
    } catch (err) {
      showErr(form, 'address', err.message || tt.req);
    }
  });

  root.querySelector('[data-acc-profile-form]')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const form = e.currentTarget;
    const tt = t();
    clearErrors(form);
    const name = form.name.value.trim();
    const phone = form.phone.value.trim();
    let bad = false;
    if (!name) {
      showErr(form, 'name', tt.req);
      bad = true;
    }
    if (!phoneOk(phone)) {
      showErr(form, 'phone', tt.badPhone);
      bad = true;
    }
    if (bad) return;
    const data = await rest('account/profile', {
      method: 'POST',
      body: JSON.stringify({ name, phone, marketing: !!form.marketing.checked }),
    });
    user = data.user;
    showNotice(noticeDash, tt.saved, 'ok');
    setHero('profile');
  });

  root.querySelector('[data-acc-pw-form]')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const form = e.currentTarget;
    const tt = t();
    clearErrors(form);
    const current = form.current.value;
    const password = form.password.value;
    const password2 = form.password2.value;
    let bad = false;
    if (!current) {
      showErr(form, 'current', tt.req);
      bad = true;
    }
    if (password.length < 8) {
      showErr(form, 'password', tt.shortPw);
      bad = true;
    }
    if (password2 !== password || !password2) {
      showErr(form, 'password2', tt.mismatch);
      bad = true;
    }
    if (bad) return;
    try {
      await rest('account/password', {
        method: 'POST',
        body: JSON.stringify({ current, password }),
      });
      form.reset();
      showNotice(noticeDash, tt.pwSaved, 'ok');
    } catch (err) {
      const alert = form.querySelector('[data-acc-form-err]');
      if (alert) {
        alert.textContent = err.message || tt.wrong;
        alert.hidden = false;
      }
    }
  });

  root.querySelector('[data-acc-cancel]')?.addEventListener('click', async () => {
    if (!currentOrderId) return;
    const data = await rest(`account/orders/${encodeURIComponent(currentOrderId)}/cancel`, {
      method: 'POST',
      body: '{}',
    });
    if (data.order) {
      orders = orders.map((o) => (o.id === data.order.id ? data.order : o));
      renderOrder(currentOrderId);
      showNotice(noticeDash, t().cancelled, 'info');
    }
  });

  root.querySelector('[data-acc-reorder]')?.addEventListener('click', async () => {
    const o = orders.find((x) => x.id === currentOrderId);
    if (!o) return;
    for (const item of o.items) {
      try {
        await cart.add({
          id: item.id || item.h,
          name: item.name,
          variant: item.variant,
          price: item.price,
          qty: item.qty,
          img: item.img,
        });
      } catch (_) {
        /* adapter shape may vary */
      }
    }
    location.href = checkout;
  });

  window.addEventListener('hashchange', () => {
    editingAddr = null;
    route();
  });

  refreshMe()
    .then(() => {
      // After login cookie, refresh nonce if possible via localized SoulTheme — keep as-is.
      route();
    })
    .catch(() => {
      user = null;
      route();
    });
}
