// Collection page: client-side filter of the product grid by chip-group values.
// Cards carry data-tags="pha-phin fine-robusta"; chips carry data-value="pha-phin".
import { $$ } from '../core/dom.js';

export default function collection() {
  document.addEventListener('soul:chips:change', (e) => {
    if (e.detail.name !== 'filter') return;
    const on = [].concat(e.detail.value).filter(Boolean);
    $$('[data-tags]').forEach((card) => { card.hidden = on.length > 0 && !on.some((tag) => card.dataset.tags.split(' ').includes(tag)); });
  });
}
