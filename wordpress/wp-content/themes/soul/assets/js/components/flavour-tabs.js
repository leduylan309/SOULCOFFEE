// New Crop flavour tabs — SoT #collection. Markup stays Gutenberg-valid;
// data-component is injected via render_block on .js-flavour-tabs.
import { Component } from '../core/component.js';

export default class FlavourTabs extends Component {
  init() {
    this.tabs = this.$$('.s-newcrop-col__tabs .wp-block-button__link, .s-newcrop-col__tab .wp-block-button__link');
    this.panels = this.$$('.s-newcrop-col__panel');
    this.tabs.forEach((tab) => this.on(tab, 'click', (e) => {
      e.preventDefault();
      const id = (tab.getAttribute('href') || '').replace(/^#/, '');
      if (id) this.activate(id);
    }));
  }

  activate(id) {
    this.tabs.forEach((tab) => {
      const on = (tab.getAttribute('href') || '') === `#${id}`;
      tab.setAttribute('aria-selected', String(on));
      tab.closest('.wp-block-button')?.classList.toggle('is-active', on);
    });
    this.panels.forEach((panel) => {
      panel.classList.toggle('is-active', panel.id === id);
    });
  }
}
