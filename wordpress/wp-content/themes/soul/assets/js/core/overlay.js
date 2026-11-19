// Shared behaviour for every modal layer (drawer, lightbox, mobile menu, search):
// open/close via [hidden], scroll lock, focus trap, Esc, restore focus, one layer stack.
import { SELECTORS, STATE } from './config.js';
import { $$, on } from './dom.js';
import { bus } from './events.js';

const stack = [];
let removeKey = null;

function onKey(e) {
  const top = stack[stack.length - 1];
  if (!top) return;
  if (e.key === 'Escape') { e.preventDefault(); close(top.el); return; }
  if (e.key !== 'Tab') return;
  const f = $$(SELECTORS.focusable, top.el).filter((n) => n.offsetParent !== null);
  if (!f.length) return;
  const first = f[0], last = f[f.length - 1];
  if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
  else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
}

export function open(el, { scrim, onClose, initialFocus } = {}) {
  if (stack.some((s) => s.el === el)) return;
  stack.push({ el, scrim, onClose, returnTo: document.activeElement });
  el.hidden = false; if (scrim) scrim.hidden = false;
  el.classList.add(STATE.open);
  document.documentElement.classList.add(STATE.locked);
  if (!removeKey) removeKey = on(document, 'keydown', onKey);
  (initialFocus ? el.querySelector(initialFocus) : el.querySelector(SELECTORS.focusable))?.focus({ preventScroll: true });
  bus.emit('overlay:open', { el });
}

export function close(el) {
  const i = stack.findIndex((s) => s.el === el);
  if (i < 0) return;
  const [s] = stack.splice(i, 1);
  el.hidden = true; if (s.scrim) s.scrim.hidden = true;
  el.classList.remove(STATE.open);
  if (!stack.length) { document.documentElement.classList.remove(STATE.locked); removeKey?.(); removeKey = null; }
  s.returnTo?.focus?.({ preventScroll: true });
  s.onClose?.();
  bus.emit('overlay:close', { el });
}

export const isOpen = (el) => stack.some((s) => s.el === el);
export const toggle = (el, opts) => (isOpen(el) ? close(el) : open(el, opts));
