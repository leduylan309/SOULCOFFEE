// Gallery → shared full-screen lightbox. One viewer DOM for the whole page.
// <div data-component="lightbox" data-label="Album · Vùng nguyên liệu">
//   <button data-lightbox-item data-src="big.jpg" data-caption="…"><img src="thumb.jpg" alt="…"></button> …
import { Component } from '../core/component.js';
import { html, esc } from '../core/dom.js';
import { counter } from '../core/format.js';
import * as overlay from '../core/overlay.js';
import { t } from '../core/i18n.js';

let viewer = null;
function getViewer() {
  if (viewer) return viewer;
  viewer = html(`<div class="c-lightbox" role="dialog" aria-modal="true" hidden>
    <div class="c-lightbox__bar"><span data-lb-label></span><button type="button" class="c-icon-btn" data-lb="close" aria-label="${esc(t('common.close'))}">×</button></div>
    <div class="c-lightbox__stage"><button type="button" class="c-icon-btn c-icon-btn--outline-dark" data-lb="prev" aria-label="${esc(t('common.prev'))}">←</button><img data-lb-img alt=""><button type="button" class="c-icon-btn c-icon-btn--outline-dark" data-lb="next" aria-label="${esc(t('common.next'))}">→</button></div>
    <div class="c-lightbox__caption" data-lb-caption></div></div>`);
  document.body.appendChild(viewer);
  return viewer;
}

export default class Lightbox extends Component {
  static defaults = { label: '' };
  init() {
    // Prefer explicit items; else editable core Image blocks inside the gallery group.
    this.items = this.$$('[data-lightbox-item]');
    if (!this.items.length) this.items = this.$$('.wp-block-image, figure');
    this.items.forEach((it, i) => this.on(it, 'click', (e) => { e.preventDefault(); this.open(i); }));
  }
  open(i) {
    const v = getViewer();
    this.index = i;
    this._v = [
      ['click', (e) => { const a = e.target.closest('[data-lb]')?.dataset.lb; if (a === 'close') this.close(); if (a === 'prev') this.step(-1); if (a === 'next') this.step(1); }],
      ['keydown', (e) => { if (e.key === 'ArrowRight') this.step(1); if (e.key === 'ArrowLeft') this.step(-1); }]
    ];
    this._v.forEach(([type, fn]) => (type === 'keydown' ? document : v).addEventListener(type, fn));
    this.render();
    overlay.open(v, { onClose: () => this._v.forEach(([type, fn]) => (type === 'keydown' ? document : v).removeEventListener(type, fn)) });
  }
  close() { overlay.close(getViewer()); }
  step(d) { this.index = (this.index + d + this.items.length) % this.items.length; this.render(); }
  render() {
    const v = getViewer(), it = this.items[this.index], img = it.querySelector('img');
    v.querySelector('[data-lb-img]').src = it.dataset.src || img?.src || '';
    v.querySelector('[data-lb-img]').alt = img?.alt || '';
    v.querySelector('[data-lb-label]').textContent = `${this.opts.label} · ${counter(this.index, this.items.length)}`;
    const cap = v.querySelector('[data-lb-caption]'); cap.textContent = it.dataset.caption || ''; cap.hidden = !it.dataset.caption;
  }
}
