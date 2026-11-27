// PDP: variant chips → price / ATC / quote (SoT Shop.dc.html isProduct).
import { cart } from '../services/cart.js';
import { bus } from '../core/events.js';

function vnd(n) {
  return Math.round(n).toLocaleString('vi-VN') + '₫';
}
function roundPrice(base, mult) {
  return Math.round((base * mult) / 5000) * 5000;
}

export default function product() {
  const root = document.querySelector('.s-shop-pdp');
  if (!root || root.dataset.sold === '1') return;

  const base = Number(root.dataset.basePrice) || 0;
  const kind = root.dataset.kind || root.dataset.productKind || '';
  let qty = 1;

  const priceEl = root.querySelector('[data-pdp-price]');
  const noteEl = root.querySelector('[data-pdp-note]');
  const qtyEl = root.querySelector('[data-pdp-qty]');
  const atc = root.querySelector('[data-pdp-atc]');
  const buyNow = root.querySelector('[data-pdp-buynow]');
  const quoteBtn = root.querySelector('[data-pdp-quote]');
  const buyRow = root.querySelector('[data-pdp-buy]');

  const selected = () =>
    [...root.querySelectorAll('.s-shop-pdp__set')].map((set) => {
      const on = set.querySelector('.s-shop-pdp__chip.is-on') || set.querySelector('.s-shop-pdp__chip');
      return {
        id: set.dataset.optId,
        vid: on?.dataset.vid || '',
        mult: Number(on?.dataset.mult || 1),
        label: on?.dataset.label || on?.textContent || '',
      };
    });

  const sync = () => {
    const chosen = selected();
    const mult = chosen.reduce((a, c) => a * (c.mult || 1), 1);
    const isBulk = mult === 0 || root.dataset.quote === '1';
    const price = isBulk ? 0 : roundPrice(base, chosen.length ? mult : 1);

    if (isBulk) {
      if (priceEl) priceEl.textContent = 'Liên hệ';
      if (noteEl) noteEl.textContent = kind === 'gb' ? '> 60 kg · liên hệ báo giá' : noteEl.textContent;
      if (atc) atc.hidden = true;
      if (buyNow) buyNow.hidden = true;
      if (quoteBtn) quoteBtn.hidden = false;
      const qtyWrap = root.querySelector('.s-shop-pdp__qty');
      if (qtyWrap) qtyWrap.hidden = true;
    } else {
      if (priceEl) priceEl.textContent = vnd(price);
      if (noteEl) noteEl.textContent = kind === 'gb' ? 'Chưa gồm 5% VAT' : 'Đã gồm VAT';
      if (atc) {
        atc.hidden = false;
        atc.textContent = `Thêm vào giỏ · ${vnd(price * qty)}`;
      }
      if (buyNow) buyNow.hidden = false;
      if (quoteBtn) quoteBtn.hidden = true;
      const qtyWrap = root.querySelector('.s-shop-pdp__qty');
      if (qtyWrap) qtyWrap.hidden = false;
    }
    if (qtyEl) qtyEl.textContent = String(qty);
    return { chosen, isBulk, price };
  };

  root.querySelectorAll('.s-shop-pdp__chip').forEach((chip) => {
    chip.addEventListener('click', () => {
      const set = chip.closest('.s-shop-pdp__set');
      set.querySelectorAll('.s-shop-pdp__chip').forEach((c) => {
        c.classList.toggle('is-on', c === chip);
        c.setAttribute('aria-pressed', c === chip ? 'true' : 'false');
      });
      sync();
    });
  });

  root.querySelector('[data-pdp-inc]')?.addEventListener('click', () => {
    qty += 1;
    sync();
  });
  root.querySelector('[data-pdp-dec]')?.addEventListener('click', () => {
    qty = Math.max(1, qty - 1);
    sync();
  });

  const add = async (goCheckout) => {
    const { chosen, isBulk, price } = sync();
    if (isBulk || !atc) return;
    let product = {};
    try {
      product = JSON.parse(atc.getAttribute('data-product') || '{}');
    } catch {
      return;
    }
    const key = `${product.id}|${chosen.map((c) => c.vid).join('|') || 'default'}`;
    await cart.add({
      id: key,
      sku: product.sku || product.id,
      name: product.name,
      img: product.img,
      price,
      qty,
      type: chosen.map((c) => c.label).join(' · ') || '—',
      variant: chosen.map((c) => c.label).join(' · ') || '—',
    });
    if (goCheckout && buyNow?.href) {
      location.href = buyNow.href;
      return;
    }
    bus.emit('cart:open');
  };

  atc?.addEventListener('click', (e) => {
    e.preventDefault();
    add(false);
  });
  buyNow?.addEventListener('click', (e) => {
    e.preventDefault();
    add(true);
  });

  sync();
  initStorySlides();
}

/** PDP story gallery → slideshow (pattern soul/product-story-slides). */
function initStorySlides() {
  document.querySelectorAll('.s-shop-story__body .s-shop-story__slides, .s-shop-story__body .is-style-shop-slides').forEach((root) => {
    if (root.dataset.slidesReady) return;
    const figures = [...root.querySelectorAll(':scope > .wp-block-image, :scope > figure')];
    if (figures.length < 2) return;
    root.dataset.slidesReady = '1';

    const viewport = document.createElement('div');
    viewport.className = 's-shop-story__slides__viewport';
    const track = document.createElement('div');
    track.className = 's-shop-story__slides__track';
    figures.forEach((fig) => track.appendChild(fig));
    viewport.appendChild(track);

    const nav = document.createElement('div');
    nav.className = 's-shop-story__slides__nav';
    nav.innerHTML =
      '<button type="button" class="s-shop-story__slides__btn" data-dir="-1" aria-label="Trước">‹</button>' +
      '<button type="button" class="s-shop-story__slides__btn" data-dir="1" aria-label="Sau">›</button>';

    const dots = document.createElement('div');
    dots.className = 's-shop-story__slides__dots';
    figures.forEach((_, i) => {
      const b = document.createElement('button');
      b.type = 'button';
      b.className = 's-shop-story__slides__dot' + (i === 0 ? ' is-on' : '');
      b.setAttribute('aria-label', `Ảnh ${i + 1}`);
      b.dataset.i = String(i);
      dots.appendChild(b);
    });

    root.innerHTML = '';
    root.appendChild(viewport);
    root.appendChild(nav);
    root.appendChild(dots);

    let i = 0;
    const go = (n) => {
      i = (n + figures.length) % figures.length;
      track.style.transform = `translateX(-${i * 100}%)`;
      dots.querySelectorAll('.s-shop-story__slides__dot').forEach((d, di) => {
        d.classList.toggle('is-on', di === i);
      });
    };
    nav.addEventListener('click', (e) => {
      const btn = e.target.closest('[data-dir]');
      if (!btn) return;
      go(i + Number(btn.dataset.dir));
    });
    dots.addEventListener('click', (e) => {
      const d = e.target.closest('[data-i]');
      if (!d) return;
      go(Number(d.dataset.i));
    });
  });
}
