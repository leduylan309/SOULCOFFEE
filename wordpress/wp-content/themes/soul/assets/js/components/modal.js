// Generic modal layer. Reused by mobile menu, search, cart drawer (subclass), any dialog.
// <div id="mobile-menu" data-component="modal" hidden> … <button data-close>×</button></div>
// Trigger anywhere: <button data-open="mobile-menu">
import { Component } from '../core/component.js';
import { delegate } from '../core/dom.js';
import * as overlay from '../core/overlay.js';

export default class Modal extends Component {
  static defaults = { scrim: '', initialFocus: '' };

  init() {
    this.el.hidden = true;
    this.scrim = this.opts.scrim ? document.getElementById(this.opts.scrim) : null;
    if (this.scrim) this.on(this.scrim, 'click', () => this.close());
    this._cleanup.push(delegate(document, 'click', `[data-open="${this.el.id}"]`, (e) => { e.preventDefault(); this.open(); }));
    this.on(this.el, 'click', (e) => { if (e.target.closest('[data-close]')) this.close(); });
  }

  open() { overlay.open(this.el, { scrim: this.scrim, initialFocus: this.opts.initialFocus, onClose: () => this.onClose?.() }); this.onOpen?.(); this.emit('modal:open', { id: this.el.id }); }
  close() { overlay.close(this.el); }
  toggle() { overlay.isOpen(this.el) ? this.close() : this.open(); }
}
