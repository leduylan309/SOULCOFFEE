// App-wide event bus. Components talk through events, never by importing each other.
// Events: 'cart:change', 'cart:open', 'toast:show', 'lang:change', 'overlay:open', 'overlay:close'
import { PREFIX } from './config.js';

const target = new EventTarget();

export const bus = {
  emit(name, detail) {
    target.dispatchEvent(new CustomEvent(name, { detail }));
    document.dispatchEvent(new CustomEvent(`${PREFIX}:${name}`, { detail })); // for non-module scripts / theme code
  },
  on(name, handler) {
    const fn = (e) => handler(e.detail);
    target.addEventListener(name, fn);
    return () => target.removeEventListener(name, fn);
  }
};
