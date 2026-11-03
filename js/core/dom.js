// Tiny DOM helpers — no dependencies.
export const $ = (sel, root = document) => root.querySelector(sel);
export const $$ = (sel, root = document) => [...root.querySelectorAll(sel)];

/** Add a listener and return its remover. */
export function on(target, type, handler, opts) {
  target.addEventListener(type, handler, opts);
  return () => target.removeEventListener(type, handler, opts);
}

/** Delegated listener: on(document, 'click', '[data-add-to-cart]', fn) */
export function delegate(root, type, selector, handler, opts) {
  return on(root, type, (e) => {
    const match = e.target.closest(selector);
    if (match && root.contains(match)) handler(e, match);
  }, opts);
}

/** Read data-* options with JSON / number / boolean coercion. data-foo-bar="1" → { fooBar: 1 } */
export function readData(el, skip = ['component']) {
  const out = {};
  for (const [k, raw] of Object.entries(el.dataset)) {
    if (skip.includes(k)) continue;
    if (raw === '' || raw === 'true') out[k] = true;
    else if (raw === 'false') out[k] = false;
    else if (!isNaN(raw) && raw.trim() !== '') out[k] = Number(raw);
    else if (/^[[{]/.test(raw)) { try { out[k] = JSON.parse(raw); } catch { out[k] = raw; } }
    else out[k] = raw;
  }
  return out;
}

/** Build an element from an HTML string (single root). */
export function html(str) {
  const t = document.createElement('template');
  t.innerHTML = str.trim();
  return t.content.firstElementChild;
}

/** Escape text for safe interpolation in html``. */
export const esc = (s = '') => String(s).replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

export const debounce = (fn, ms = 150) => { let t; return (...a) => { clearTimeout(t); t = setTimeout(() => fn(...a), ms); }; };
