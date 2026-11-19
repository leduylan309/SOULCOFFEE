// <button class="c-btn c-btn--outline" data-component="add-to-cart"
//         data-product='{"id":"oesp","name":"Origin Espresso","type":"Pha máy","img":"…","price":200000}'>
import { Component } from '../core/component.js';
import { cart } from '../services/cart.js';
import { STATE } from '../core/config.js';

export default class AddToCart extends Component {
  static defaults = { product: null, openDrawer: false };
  init() {
    this.on(this.el, 'click', async (e) => {
      e.preventDefault();
      if (!this.opts.product) return console.warn('[soul] add-to-cart needs data-product');
      this.el.classList.add(STATE.loading); this.el.disabled = true;
      try {
        // Re-read data-product in case PDP JS updated price/variant after mount.
        let product = this.opts.product;
        try { product = JSON.parse(this.el.getAttribute('data-product') || '{}'); } catch { /* keep */ }
        await cart.add({ ...product, qty: this.qty() });
        if (this.opts.openDrawer) this.emit('cart:open');
      }
      finally { this.el.classList.remove(STATE.loading); this.el.disabled = false; }
    });
  }
  // Optional linked stepper: data-qty-from="#qty-input"
  qty() { const src = this.opts.qtyFrom && document.querySelector(this.opts.qtyFrom); return src ? Number(src.value) || 1 : 1; }
}
