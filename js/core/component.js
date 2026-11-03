// Base class for every UI component.
// - Options = static defaults ← data-* attributes ← constructor opts
// - this.on() registers listeners that destroy() removes automatically
// - this.emit() fires a DOM CustomEvent (bubbles) AND a bus event
import { $, $$, on, readData } from './dom.js';
import { bus } from './events.js';
import { PREFIX } from './config.js';

export class Component {
  static defaults = {};

  constructor(el, opts = {}) {
    this.el = el;
    this.opts = { ...this.constructor.defaults, ...readData(el), ...opts };
    this._cleanup = [];
    this.init?.();
  }

  $(sel) { return $(sel, this.el); }
  $$(sel) { return $$(sel, this.el); }

  on(target, type, handler, opts) { this._cleanup.push(on(target, type, handler, opts)); }
  listen(event, handler) { this._cleanup.push(bus.on(event, handler)); }

  emit(name, detail) {
    this.el.dispatchEvent(new CustomEvent(`${PREFIX}:${name}`, { bubbles: true, detail }));
    bus.emit(name, detail);
  }

  destroy() { this._cleanup.splice(0).forEach((fn) => fn()); this.teardown?.(); }
}
