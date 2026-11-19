// − qty + stepper.
// <div class="c-stepper" data-component="stepper" data-min="1" data-max="99">
//   <button data-step="-1">−</button><input data-value value="1" inputmode="numeric"><button data-step="1">+</button>
import { Component } from '../core/component.js';

export default class Stepper extends Component {
  static defaults = { min: 1, max: 99 };
  init() {
    this.field = this.$('[data-value]');
    this.$$('[data-step]').forEach((b) => this.on(b, 'click', () => this.set(this.value + Number(b.dataset.step))));
    if (this.field.tagName === 'INPUT') this.on(this.field, 'change', () => this.set(Number(this.field.value)));
  }
  get value() { return Number(this.field.value ?? this.field.textContent) || this.opts.min; }
  set(n) {
    const v = Math.min(this.opts.max, Math.max(this.opts.min, Math.round(n) || this.opts.min));
    if (this.field.tagName === 'INPUT') this.field.value = v; else this.field.textContent = v;
    this.emit('stepper:change', { value: v });
  }
}
