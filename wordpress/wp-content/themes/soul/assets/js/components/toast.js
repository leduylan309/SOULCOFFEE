// Toast host. Mount once: <div data-component="toast"></div>
// Shows on bus 'toast:show' { message, action, event } and automatically on 'cart:added'.
import { Component } from '../core/component.js';
import { html, esc } from '../core/dom.js';
import { bus } from '../core/events.js';
import { TOAST_MS } from '../core/config.js';
import { t } from '../core/i18n.js';

export default class Toast extends Component {
  init() {
    this.listen('toast:show', (d) => this.show(d));
    this.listen('cart:added', ({ item }) => this.show({ message: t('cart.added', { name: item.name }), action: t('cart.view'), event: 'cart:open' }));
  }
  show({ message, action, event }) {
    this.node?.remove(); clearTimeout(this.timer);
    this.node = html(`<div class="c-toast" role="status"><span>${esc(message)}</span>${action ? `<button type="button">${esc(action)}</button>` : ''}</div>`);
    this.node.querySelector('button')?.addEventListener('click', () => { if (event) bus.emit(event); this.hide(); });
    this.el.appendChild(this.node);
    this.timer = setTimeout(() => this.hide(), TOAST_MS);
  }
  hide() { this.node?.remove(); this.node = null; }
  teardown() { this.hide(); }
}

/** Imperative helper for any module: toast('Đã lưu') */
export const toast = (message, opts = {}) => bus.emit('toast:show', { message, ...opts });
