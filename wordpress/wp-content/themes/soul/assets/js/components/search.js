// Search overlay = Modal + live results.
// <div id="search" data-component="search" data-initial-focus="[data-search-input]" hidden>
//   <input data-search-input> <div data-search-results></div> <div data-search-empty hidden></div>
//   <template data-search-item><a href="{{url}}">…{{name}} {{type}} {{img}}</a></template>
import Modal from './modal.js';
import { search } from '../services/search.js';
import { debounce, esc } from '../core/dom.js';

export default class Search extends Modal {
  static defaults = { ...Modal.defaults, endpoint: '' };
  init() {
    super.init();
    this.input = this.$('[data-search-input]');
    this.out = this.$('[data-search-results]');
    this.empty = this.$('[data-search-empty]');
    this.tpl = this.$('template[data-search-item]')?.innerHTML || '';
    this.on(this.input, 'input', debounce(() => this.run(), 120));
  }
  onOpen() { this.run(); }
  async run() {
    const q = this.input.value;
    const list = await search(q, { endpoint: this.opts.endpoint });
    this.out.innerHTML = list.map((p) => this.tpl.replace(/\{\{\s*(\w+)\s*\}\}/g, (_, k) => esc(p[k] ?? ''))).join('');
    if (this.empty) this.empty.hidden = !(q.trim() && !list.length);
  }
}
