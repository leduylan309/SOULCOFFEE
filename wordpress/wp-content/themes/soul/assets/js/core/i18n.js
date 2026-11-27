// Language from Polylang (html[data-soul-lang] / SoulTheme.lang). Fallback dicts for data-i18n.
import { bus } from './events.js';
import { $$ } from './dom.js';
import vi from '../i18n/vi.js';
import en from '../i18n/en.js';

const dicts = { vi, en };

function detectLang() {
  const fromTheme = window.SoulTheme && window.SoulTheme.lang;
  if (fromTheme === 'vi' || fromTheme === 'en') return fromTheme;
  const html = document.documentElement.getAttribute('data-soul-lang')
    || (document.documentElement.lang || '').slice(0, 2).toLowerCase();
  return html === 'en' ? 'en' : 'vi';
}

let lang = detectLang();

const lookup = (dict, path) => path.split('.').reduce((o, k) => o?.[k], dict);

/** Prefer SoulTheme.i18n flat keys, else nested dict path. */
export function t(path, vars = {}) {
  const bag = window.SoulTheme && window.SoulTheme.i18n;
  if (bag && typeof bag[path] === 'string') {
    return bag[path].replace(/\{(\w+)\}/g, (_, k) => vars[k] ?? '');
  }
  const s = lookup(dicts[lang], path) ?? lookup(dicts.vi, path) ?? path;
  return typeof s === 'string' ? s.replace(/\{(\w+)\}/g, (_, k) => vars[k] ?? '') : s;
}

export const getLang = () => lang;

/** Polylang owns language — setLang only updates local dict apply (no storage write). */
export function setLang(next, root = document) {
  if (!dicts[next]) return;
  lang = next;
  document.documentElement.setAttribute('data-soul-lang', next);
  apply(root);
  bus.emit('lang:change', { lang: next });
}

export function apply(root = document) {
  lang = detectLang();
  $$('[data-i18n]', root).forEach((el) => { el.textContent = t(el.dataset.i18n); });
  $$('[data-i18n-attr]', root).forEach((el) => el.dataset.i18nAttr.split(',').forEach((pair) => {
    const [attr, path] = pair.split(':').map((s) => s.trim());
    el.setAttribute(attr, t(path));
  }));
}

export function extend(code, dict) { dicts[code] = { ...(dicts[code] || {}), ...dict }; }
