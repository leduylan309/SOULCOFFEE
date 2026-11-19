// Horizontal scroll rail with prev/next (certificates, related products).
// <div data-component="rail" data-step="0.8">
//   <button data-rail-prev>←</button><button data-rail-next>→</button>
//   <ul class="l-rail" data-rail-track>…</ul>
import { Component } from '../core/component.js';
import { reducedMotion } from '../core/config.js';
import { debounce } from '../core/dom.js';

export default class Rail extends Component {
  static defaults = { step: 0.8 };
  init() {
    this.track = this.$('[data-rail-track]');
    this.prev = this.$('[data-rail-prev]');
    this.next = this.$('[data-rail-next]');
    this.prev && this.on(this.prev, 'click', () => this.scroll(-1));
    this.next && this.on(this.next, 'click', () => this.scroll(1));
    const sync = debounce(() => this.sync(), 60);
    this.on(this.track, 'scroll', sync, { passive: true });
    this.on(window, 'resize', sync);
    this.sync();
  }
  scroll(dir) { this.track.scrollBy({ left: dir * this.track.clientWidth * this.opts.step, behavior: reducedMotion() ? 'auto' : 'smooth' }); }
  sync() {
    const { scrollLeft, scrollWidth, clientWidth } = this.track;
    if (this.prev) this.prev.disabled = scrollLeft <= 2;
    if (this.next) this.next.disabled = scrollLeft + clientWidth >= scrollWidth - 2;
  }
}
