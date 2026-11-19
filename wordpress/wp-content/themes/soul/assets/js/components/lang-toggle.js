// VI / EN switch. <div class="c-lang" data-component="lang-toggle"><button data-lang="vi">VI</button><button data-lang="en">EN</button></div>
import { Component } from '../core/component.js';
import { getLang, setLang } from '../core/i18n.js';

export default class LangToggle extends Component {
  init() {
    this.btns = this.$$('[data-lang]');
    this.btns.forEach((b) => this.on(b, 'click', () => setLang(b.dataset.lang)));
    this.listen('lang:change', () => this.sync());
    this.sync();
  }
  sync() { const l = getLang(); this.btns.forEach((b) => b.setAttribute('aria-pressed', String(b.dataset.lang === l))); }
}
