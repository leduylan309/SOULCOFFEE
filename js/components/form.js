// Validated form (contact B2B, newsletter). Underline fields use .c-field; errors in [data-form-error].
// <form data-component="form" data-endpoint="/contact" data-success="#contact-thanks"> … </form>
// No endpoint → simulates success (prototype). Success panel can contain [data-form-reset].
import { Component } from '../core/component.js';
import { isEmail } from '../core/format.js';
import { STATE } from '../core/config.js';
import { t } from '../core/i18n.js';

export default class Form extends Component {
  static defaults = { endpoint: '', method: 'POST', success: '', errorKey: 'form.required' };
  init() {
    this.el.noValidate = true;
    this.error = this.$('[data-form-error]');
    this.successEl = this.opts.success ? document.querySelector(this.opts.success) : null;
    this.on(this.el, 'submit', (e) => this.submit(e));
    this.on(this.el, 'input', (e) => e.target.classList.remove(STATE.invalid));
    if (this.successEl) this.on(this.successEl, 'click', (e) => { if (e.target.closest('[data-form-reset]')) this.reset(); });
  }
  validate() {
    const bad = [...this.el.elements].filter((f) => f.name && ((f.required && !f.value.trim()) || (f.type === 'email' && f.value && !isEmail(f.value))));
    bad.forEach((f) => f.classList.add(STATE.invalid));
    if (this.error) { this.error.hidden = !bad.length; this.error.textContent = bad.length ? t(this.opts.errorKey) : ''; }
    bad[0]?.focus();
    return !bad.length;
  }
  async submit(e) {
    e.preventDefault();
    if (!this.validate()) return;
    const data = new FormData(this.el);
    this.el.classList.add(STATE.loading);
    try {
      if (this.opts.endpoint) { const r = await fetch(this.opts.endpoint, { method: this.opts.method, body: data }); if (!r.ok) throw new Error(r.status); }
      this.emit('form:success', Object.fromEntries(data));
      if (this.successEl) { this.el.hidden = true; this.successEl.hidden = false; }
    } catch (err) {
      this.emit('form:error', { err });
      if (this.error) { this.error.hidden = false; this.error.textContent = String(err); }
    } finally { this.el.classList.remove(STATE.loading); }
  }
  reset() { this.el.reset(); this.el.hidden = false; if (this.successEl) this.successEl.hidden = true; this.$$('[aria-pressed="true"]').forEach((c) => c.setAttribute('aria-pressed', 'false')); }
}
