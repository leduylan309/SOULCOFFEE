// Sticky header: mega menu on hover/focus, closes on leave / Esc / click-out; live cart count.
// <header class="l-header" data-component="header">
//   <a data-mega-trigger="shop">Sản phẩm ▾</a> … <div class="l-mega" data-mega="shop" hidden>…</div>
//   <span class="c-cart-count" data-cart-count>0</span>
import { Component } from '../core/component.js';
import { cart } from '../services/cart.js';

export default class Header extends Component {
  init() {
    this.panels = this.$$('[data-mega]');
    this.$$('[data-mega-trigger]').forEach((t) => {
      const show = () => this.show(t.dataset.megaTrigger, t);
      this.on(t, 'mouseenter', show);
      this.on(t, 'focus', show);
      this.on(t, 'click', (e) => { if (window.matchMedia('(hover: none)').matches) { e.preventDefault(); this.current ? this.hide() : show(); } });
    });
    this.$$('[data-nav-link]:not([data-mega-trigger])').forEach((a) => this.on(a, 'mouseenter', () => this.hide()));
    this.on(this.el, 'mouseleave', () => this.hide());
    this.on(document, 'keydown', (e) => { if (e.key === 'Escape') this.hide(); });
    this.on(document, 'click', (e) => { if (!this.el.contains(e.target)) this.hide(); });

    const counts = this.$$('[data-cart-count]');
    this._cleanup.push(cart.subscribe(() => counts.forEach((c) => { c.textContent = cart.count(); })));
  }

  show(name, trigger) {
    this.panels.forEach((p) => { p.hidden = p.dataset.mega !== name; });
    this.$$('[data-mega-trigger]').forEach((t) => t.setAttribute('aria-expanded', String(t === trigger)));
    this.current = name;
  }

  hide() {
    this.panels.forEach((p) => { p.hidden = true; });
    this.$$('[data-mega-trigger]').forEach((t) => t.setAttribute('aria-expanded', 'false'));
    this.current = null;
  }
}
