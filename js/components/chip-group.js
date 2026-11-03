// Toggle chips (interests, product variants, filters). aria-pressed drives the yellow fill in CSS.
// <div data-component="chip-group" data-mode="single" data-name="weight">
//   <button class="c-chip" data-value="200g" aria-pressed="true">200 g</button> …
//   <input type="hidden" name="weight">   (auto-created if missing)
import { Component } from '../core/component.js';

export default class ChipGroup extends Component {
  static defaults = { mode: 'multi', name: '' };
  init() {
    this.chips = this.$$('.c-chip, [data-value]');
    this.input = this.$(`input[type="hidden"]`);
    if (!this.input && this.opts.name) { this.input = Object.assign(document.createElement('input'), { type: 'hidden', name: this.opts.name }); this.el.appendChild(this.input); }
    this.chips.forEach((c) => { if (!c.hasAttribute('aria-pressed')) c.setAttribute('aria-pressed', 'false'); this.on(c, 'click', () => this.toggle(c)); });
    this.sync();
  }
  toggle(chip) {
    const on = chip.getAttribute('aria-pressed') === 'true';
    if (this.opts.mode === 'single') this.chips.forEach((c) => c.setAttribute('aria-pressed', String(c === chip)));
    else chip.setAttribute('aria-pressed', String(!on));
    this.sync();
    this.emit('chips:change', { name: this.opts.name, value: this.value });
  }
  get value() {
    const v = this.chips.filter((c) => c.getAttribute('aria-pressed') === 'true').map((c) => c.dataset.value || c.textContent.trim());
    return this.opts.mode === 'single' ? v[0] || '' : v;
  }
  sync() { if (this.input) this.input.value = Array.isArray(this.value) ? this.value.join(',') : this.value; }
}
