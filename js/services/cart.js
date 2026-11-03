// Cart service: one store, swappable backend adapter.
//   localAdapter   — prototype / static demo (localStorage)
//   haravanAdapter — production on Haravan (Shopify-compatible AJAX API: /cart.js, /cart/add.js, /cart/change.js)
import { createStore } from '../core/store.js';
import { storage } from '../core/storage.js';
import { bus } from '../core/events.js';

export const localAdapter = {
  async load() { return storage.get('cart', { items: [] }); },
  async save(cart) { storage.set('cart', cart); return cart; }
};

export const haravanAdapter = {
  async load() { const r = await fetch('/cart.js', { headers: { Accept: 'application/json' } }); return normalize(await r.json()); },
  async add(item) { await fetch('/cart/add.js', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ id: item.variantId || item.id, quantity: item.qty || 1 }) }); return this.load(); },
  async change(id, qty) { await fetch('/cart/change.js', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ id, quantity: qty }) }); return this.load(); }
};

function normalize(c) {
  return { items: (c.items || []).map((i) => ({ id: String(i.variant_id || i.id), name: i.title || i.product_title, type: i.variant_title || '', img: i.image, price: i.price, qty: i.quantity })) };
}

const store = createStore({ items: [], ready: false });
let adapter = localAdapter;

export const cart = {
  store,
  async init(a = localAdapter) { adapter = a; store.set({ ...(await adapter.load()), ready: true }); },
  count: () => store.get().items.reduce((n, i) => n + i.qty, 0),

  async add(item) {
    if (adapter.add) store.set({ ...(await adapter.add(item)), ready: true });
    else await commit((items) => { const f = items.find((i) => i.id === item.id); return f ? items.map((i) => (i === f ? { ...i, qty: i.qty + (item.qty || 1) } : i)) : [...items, { ...item, qty: item.qty || 1 }]; });
    bus.emit('cart:added', { item });
  },
  async setQty(id, qty) {
    qty = Math.max(0, qty);
    if (adapter.change) store.set({ ...(await adapter.change(id, qty)), ready: true });
    else await commit((items) => (qty ? items.map((i) => (i.id === id ? { ...i, qty } : i)) : items.filter((i) => i.id !== id)));
  },
  remove(id) { return this.setQty(id, 0); },
  subscribe: (fn) => store.subscribe(fn)
};

async function commit(fn) {
  const next = { items: fn(store.get().items) };
  await adapter.save?.(next);
  store.set({ ...next, ready: true });
}

store.subscribe((s) => bus.emit('cart:change', s), { immediate: false });
