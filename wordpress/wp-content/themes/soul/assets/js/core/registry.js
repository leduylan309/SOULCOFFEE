// Declarative, lazy component registry.
// Markup:  <div data-component="rail lightbox" data-step="0.8">…</div>
// Each name maps to a loader; the module is only fetched if the page uses it.
import { $$ } from './dom.js';

const loaders = new Map();
const instances = new WeakMap();

/** register('rail', () => import('../components/rail.js')) — module must `export default` a Component class. */
export function register(name, loader) { loaders.set(name, loader); }
export function registerMany(map) { Object.entries(map).forEach(([n, l]) => register(n, l)); }

export async function mount(root = document) {
  const els = root.matches?.('[data-component]') ? [root, ...$$('[data-component]', root)] : $$('[data-component]', root);
  await Promise.all(els.flatMap((el) => el.dataset.component.split(/\s+/).filter(Boolean).map(async (name) => {
    const map = instances.get(el) || {};
    if (map[name]) return map[name];
    const loader = loaders.get(name);
    if (!loader) { console.warn(`[soul] unknown component "${name}"`, el); return; }
    const Cls = (await loader()).default;
    map[name] = new Cls(el);
    instances.set(el, map);
    return map[name];
  })));
}

export function unmount(root = document) {
  const els = root.matches?.('[data-component]') ? [root, ...$$('[data-component]', root)] : $$('[data-component]', root);
  els.forEach((el) => { const map = instances.get(el); if (!map) return; Object.values(map).forEach((c) => c.destroy()); instances.delete(el); });
}

/** Get a mounted instance: getInstance(el, 'rail') */
export const getInstance = (el, name) => instances.get(el)?.[name];

/** Auto-mount content injected later (AJAX sections, Haravan section rendering). */
export function observe(root = document.body) {
  const mo = new MutationObserver((records) => records.forEach((r) => r.addedNodes.forEach((n) => n.nodeType === 1 && mount(n))));
  mo.observe(root, { childList: true, subtree: true });
  return () => mo.disconnect();
}
