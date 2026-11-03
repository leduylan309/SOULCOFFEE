// Product search. Source = inline JSON (<script type="application/json" id="soul-products">) or Haravan endpoint.
import { $ } from '../core/dom.js';

let cache = null;

export async function loadIndex({ endpoint } = {}) {
  if (cache) return cache;
  const inline = $('#soul-products');
  if (inline) cache = JSON.parse(inline.textContent);
  else if (endpoint) cache = await (await fetch(endpoint)).json();
  else cache = [];
  return cache;
}

const fold = (s = '') => s.normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/đ/g, 'd').replace(/Đ/g, 'D').toLowerCase();

/** Diacritic-insensitive: "pha phin" matches "Pha phin", "nong" matches "Nồng". */
export async function search(query, opts) {
  const list = await loadIndex(opts);
  const q = fold(query.trim());
  if (!q) return list;
  return list.filter((p) => fold(`${p.name} ${p.type || ''} ${p.tags || ''}`).includes(q));
}
