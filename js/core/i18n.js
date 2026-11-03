// Bilingual VI / EN. Static text: <span data-i18n="cart.title"></span>
// Attributes: data-i18n-attr="placeholder:search.placeholder,aria-label:search.label"
import { storage } from './storage.js';
import { bus } from './events.js';
import { $$ } from './dom.js';
import vi from '../i18n/vi.js';
import en from '../i18n/en.js';

const dicts = { vi, en };
let lang = storage.get('lang') || document.documentElement.lang || 'vi';

const lookup = (dict, path) => path.split('.').reduce((o, k) => o?.[k], dict);

/** t('cart.added', { name: 'Cay' }) → "Cay đã thêm vào giỏ" */
export function t(path, vars = {}) {
  const s = lookup(dicts[lang], path) ?? lookup(dicts.vi, path) ?? path;
  return typeof s === 'string' ? s.replace(/\{(\w+)\}/g, (_, k) => vars[k] ?? '') : s;
}

export const getLang = () => lang;

export function setLang(next, root = document) {
  if (!dicts[next]) return;
  lang = next;
  storage.set('lang', next);
  document.documentElement.lang = next;
  apply(root);
  bus.emit('lang:change', { lang: next });
}

export function apply(root = document) {
  $$('[data-i18n]', root).forEach((el) => { el.textContent = t(el.dataset.i18n); });
  $$('[data-i18n-attr]', root).forEach((el) => el.dataset.i18nAttr.split(',').forEach((pair) => {
    const [attr, path] = pair.split(':').map((s) => s.trim());
    el.setAttribute(attr, t(path));
  }));
}

export function extend(code, dict) { dicts[code] = { ...(dicts[code] || {}), ...dict }; }
