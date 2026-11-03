// Product page: variant chips (weight × grind) → price + add-to-cart payload.
// Variants JSON: <script type="application/json" id="product-variants">[{"id":"…","weight":"200g","grind":"whole","price":220000}]</script>
import { $, $$ } from '../core/dom.js';
import { vnd } from '../core/format.js';

export default function product() {
  const src = $('#product-variants'); if (!src) return;
  const variants = JSON.parse(src.textContent);
  const price = $('[data-product-price]'), add = $('[data-component~="add-to-cart"]');
  const pick = () => Object.fromEntries($$('[data-component~="chip-group"]').map((g) => [g.dataset.name, g.querySelector('input[type=hidden]')?.value]));
  const update = () => {
    const sel = pick(), v = variants.find((x) => Object.entries(sel).every(([k, val]) => !val || x[k] === val));
    if (!v) return;
    if (price) price.textContent = vnd(v.price);
    if (add) { const p = JSON.parse(add.dataset.product || '{}'); add.dataset.product = JSON.stringify({ ...p, id: v.id, variantId: v.id, price: v.price, type: `${v.weight} · ${v.grind}` }); }
  };
  document.addEventListener('soul:chips:change', update);
  update();
}
