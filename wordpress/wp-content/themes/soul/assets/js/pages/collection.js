// Shop listing: live search + quick-add variant picker (SoT Shop.dc.html).
import { $$ } from '../core/dom.js';
import { cart } from '../services/cart.js';
import { bus } from '../core/events.js';

function vnd(n) {
  return Math.round(n).toLocaleString('vi-VN') + '₫';
}

function roundPrice(base, mult) {
  return Math.round((base * mult) / 5000) * 5000;
}

function esc(s) {
  return String(s ?? '')
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');
}

function mountPicker() {
  let root = document.getElementById('s-shop-pick');
  if (root) return root;
  root = document.createElement('div');
  root.id = 's-shop-pick';
  root.className = 's-shop-pick';
  root.hidden = true;
  root.innerHTML = `
    <button type="button" class="s-shop-pick__scrim" data-pick-close aria-label="Đóng"></button>
    <div class="s-shop-pick__dialog" role="dialog" aria-modal="true" aria-labelledby="s-shop-pick-title">
      <div class="s-shop-pick__media">
        <img class="s-shop-pick__img" alt="" />
      </div>
      <div class="s-shop-pick__body">
        <div class="s-shop-pick__top">
          <span class="s-shop-pick__kind"></span>
          <button type="button" class="s-shop-pick__x" data-pick-close aria-label="Đóng">×</button>
        </div>
        <h2 class="s-shop-pick__title" id="s-shop-pick-title"></h2>
        <div class="s-shop-pick__info" hidden></div>
        <div class="s-shop-pick__opts"></div>
        <button type="button" class="s-shop-pick__add"></button>
        <a class="s-shop-pick__details" href="#">Xem chi tiết sản phẩm</a>
      </div>
    </div>`;
  document.body.appendChild(root);
  return root;
}

function openPicker(product, cardHref) {
  const root = mountPicker();
  const opts = (product.opts || [])
    .map((g) => ({ ...g, values: (g.values || []).filter((v) => Number(v[2]) > 0) }))
    .filter((g) => g.values.length);
  if (!opts.length) return false;

  const sel = {};
  opts.forEach((g) => {
    sel[g.id] = g.values[0][0];
  });

  const img = root.querySelector('.s-shop-pick__img');
  const kind = root.querySelector('.s-shop-pick__kind');
  const title = root.querySelector('.s-shop-pick__title');
  const infoEl = root.querySelector('.s-shop-pick__info');
  const optsEl = root.querySelector('.s-shop-pick__opts');
  const addBtn = root.querySelector('.s-shop-pick__add');
  const details = root.querySelector('.s-shop-pick__details');

  img.src = product.img || '';
  kind.textContent = product.type || '';
  title.textContent = product.name || '';
  details.href = cardHref || '#';

  const facts = Array.isArray(product.facts) ? product.facts : [];
  const brew = product.brew || '';
  if (brew || facts.length) {
    infoEl.hidden = false;
    infoEl.innerHTML = `
      ${brew ? `<span class="s-shop-pick__brew">${esc(brew)}</span>` : ''}
      ${
        facts.length
          ? `<dl class="s-shop-pick__facts">${facts
              .map(
                (row) =>
                  `<div class="s-shop-pick__fact"><dt>${esc(row[0])}</dt><dd>${esc(row[1])}</dd></div>`
              )
              .join('')}</dl>`
          : ''
      }`;
  } else {
    infoEl.hidden = true;
    infoEl.innerHTML = '';
  }

  const render = () => {
    const chosen = opts.map((g) => g.values.find((v) => v[0] === sel[g.id]) || g.values[0]);
    const mult = chosen.reduce((a, v) => a * Number(v[2]), 1);
    const price = roundPrice(Number(product.price) || 0, mult);
    optsEl.innerHTML = opts
      .map(
        (g) => `<fieldset class="s-shop-pick__set">
        <legend>${g.label}</legend>
        <div class="s-shop-pick__chips">
          ${g.values
            .map((v) => {
              const on = sel[g.id] === v[0];
              return `<button type="button" class="s-shop-pick__chip${on ? ' is-on' : ''}" data-gid="${g.id}" data-vid="${v[0]}" aria-pressed="${on}">${v[1]}</button>`;
            })
            .join('')}
        </div>
      </fieldset>`
      )
      .join('');
    addBtn.textContent = `Thêm vào giỏ · ${vnd(price)}`;
    addBtn.onclick = async () => {
      const key = `${product.id}|${chosen.map((v) => v[0]).join('|')}`;
      await cart.add({
        id: key,
        sku: product.sku || product.id,
        name: product.name,
        img: product.img,
        price,
        qty: 1,
        type: chosen.map((v) => v[1]).join(' · '),
        variant: chosen.map((v) => v[1]).join(' · '),
      });
      root.hidden = true;
      document.documentElement.classList.remove('is-scroll-locked');
      bus.emit('cart:open');
    };
  };

  optsEl.onclick = (e) => {
    const btn = e.target.closest('[data-gid]');
    if (!btn) return;
    sel[btn.dataset.gid] = btn.dataset.vid;
    render();
  };

  const close = () => {
    root.hidden = true;
    document.documentElement.classList.remove('is-scroll-locked');
  };
  root.querySelectorAll('[data-pick-close]').forEach((el) => {
    el.onclick = close;
  });

  render();
  root.hidden = false;
  document.documentElement.classList.add('is-scroll-locked');
  return true;
}

export default function collection() {
  const input = document.getElementById('shop-q');
  const countEl = document.querySelector('.s-shop-toolbar__count');
  const cards = () => $$('[data-shop-card]');

  const applySearch = () => {
    const q = (input?.value || '').trim().toLowerCase();
    let n = 0;
    cards().forEach((card) => {
      const name = (card.dataset.name || '').toLowerCase();
      const show = !q || name.includes(q);
      card.closest('li').hidden = !show;
      if (show) n += 1;
    });
    if (countEl) countEl.textContent = `${n} sản phẩm`;
  };

  if (input) {
    input.addEventListener('input', applySearch);
  }

  document.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-shop-quick]');
    if (!btn) return;
    e.preventDefault();
    let product;
    try {
      product = JSON.parse(btn.getAttribute('data-product') || '{}');
    } catch {
      return;
    }
    const href = btn.closest('.s-shop-card')?.querySelector('.s-shop-card__title a')?.href;
    openPicker(product, href);
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      const root = document.getElementById('s-shop-pick');
      if (root && !root.hidden) {
        root.hidden = true;
        document.documentElement.classList.remove('is-scroll-locked');
      }
    }
  });
}
