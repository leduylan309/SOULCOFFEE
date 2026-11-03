// Cart drawer = Modal + renders the cart store.
// <aside id="cart" class="c-drawer" data-component="cart-drawer" data-scrim="cart-scrim" hidden>
//   <span data-cart-count></span> <div data-cart-items></div> <div data-cart-empty data-i18n="cart.empty"></div>
//   <template data-cart-line>…{{name}} {{type}} {{qty}} {{img}} {{id}}…</template>
import Modal from './modal.js';
import { cart } from '../services/cart.js';
import { esc } from '../core/dom.js';

export default class CartDrawer extends Modal {
  init() {
    super.init();
    this.list = this.$('[data-cart-items]');
    this.empty = this.$('[data-cart-empty]');
    this.tpl = this.$('template[data-cart-line]')?.innerHTML || '';
    this.listen('cart:open', () => this.open());
    this._cleanup.push(cart.subscribe((s) => this.render(s)));
    this.on(this.el, 'click', (e) => {
      const btn = e.target.closest('[data-cart-action]'); if (!btn) return;
      const id = btn.closest('[data-id]').dataset.id, item = cart.store.get().items.find((i) => i.id === id);
      if (btn.dataset.cartAction === 'inc') cart.setQty(id, item.qty + 1);
      if (btn.dataset.cartAction === 'dec') cart.setQty(id, Math.max(1, item.qty - 1));
      if (btn.dataset.cartAction === 'remove') cart.remove(id);
    });
  }

  render({ items }) {
    this.$$('[data-cart-count]').forEach((c) => { c.textContent = cart.count(); });
    if (this.empty) this.empty.hidden = items.length > 0;
    if (!this.list) return;
    this.list.innerHTML = items.map((i) => this.tpl.replace(/\{\{\s*(\w+)\s*\}\}/g, (_, k) => esc(i[k] ?? ''))).join('');
  }
}
