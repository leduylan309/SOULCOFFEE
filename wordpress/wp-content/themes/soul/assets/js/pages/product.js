// PDP: variant chips with data-multiplier → live price + ATC payload (id|variants, type label).
import { $, $$ } from '../core/dom.js';

function money(n) {
  return new Intl.NumberFormat('vi-VN').format(Math.round(n / 5000) * 5000) + '₫';
}

export default function product() {
  const root = $('.soul-pdp');
  if (!root) return;

  const priceEl = root.querySelector('[data-base-price]');
  const addBtn = root.querySelector('[data-component~="add-to-cart"]');
  const qtyInput = root.querySelector('[data-component~="stepper"] input, [data-component~="stepper"] [data-value]');
  if (!priceEl || !addBtn) return;

  const base = Number(priceEl.getAttribute('data-base-price')) || 0;

  const selected = () => {
    const groups = {};
    root.querySelectorAll('.soul-variant').forEach((fs) => {
      const on = fs.querySelector('.soul-chip.is-on, .soul-chip[aria-pressed="true"]');
      if (!on) return;
      const gid = on.getAttribute('data-variant-group') || 'v';
      groups[gid] = {
        id: on.getAttribute('data-variant-id') || '',
        label: on.textContent.trim(),
        mult: Number(on.getAttribute('data-multiplier')) || 1,
      };
    });
    return groups;
  };

  const update = () => {
    const sel = selected();
    const mult = Object.values(sel).reduce((a, v) => a * (v.mult || 1), 1);
    const price = Math.round((base * mult) / 5000) * 5000;
    priceEl.textContent = money(price);

    const labels = Object.values(sel).map((v) => v.label).filter(Boolean);
    const ids = Object.values(sel).map((v) => v.id).filter(Boolean);
    let payload = {};
    try {
      payload = JSON.parse(addBtn.getAttribute('data-product') || '{}');
    } catch {
      payload = {};
    }
    const sku = payload.sku || payload.id || '';
    const lineId = ids.length ? sku + '|' + ids.join('|') : sku;
    addBtn.setAttribute(
      'data-product',
      JSON.stringify({
        ...payload,
        id: lineId,
        sku,
        price,
        variant: labels.join(' · '),
        type: labels.join(' · ') || payload.type || '',
      })
    );
    if (qtyInput) {
      addBtn.setAttribute('data-qty-from', qtyInput.id ? '#' + qtyInput.id : '');
    }
  };

  root.querySelectorAll('.soul-variant .soul-chip').forEach((chip) => {
    chip.addEventListener('click', () => {
      const fs = chip.closest('.soul-variant');
      fs.querySelectorAll('.soul-chip').forEach((c) => {
        c.classList.remove('is-on');
        c.setAttribute('aria-pressed', 'false');
      });
      chip.classList.add('is-on');
      chip.setAttribute('aria-pressed', 'true');
      update();
    });
  });

  // Link ATC qty to stepper
  if (qtyInput && !qtyInput.id) qtyInput.id = 'soul-pdp-qty';
  if (qtyInput) addBtn.setAttribute('data-qty-from', '#' + qtyInput.id);

  update();
}
