// Single entry point. <script type="module" src="js/main.js"></script>
// Components are lazy: only modules whose data-component appears on the page are downloaded.
import { registerMany, mount, observe } from './core/registry.js';
import { apply as applyI18n } from './core/i18n.js';
import { cart, localAdapter } from './services/cart.js';
import { bus } from './core/events.js';

registerMany({
  'modal':        () => import('./components/modal.js'),
  'header':       () => import('./components/header.js'),
  'cart-drawer':  () => import('./components/cart-drawer.js'),
  'add-to-cart':  () => import('./components/add-to-cart.js'),
  'toast':        () => import('./components/toast.js'),
  'lightbox':     () => import('./components/lightbox.js'),
  'rail':         () => import('./components/rail.js'),
  'chip-group':   () => import('./components/chip-group.js'),
  'stepper':      () => import('./components/stepper.js'),
  'form':         () => import('./components/form.js'),
  'lang-toggle':  () => import('./components/lang-toggle.js'),
  'search':       () => import('./components/search.js')
});

// Page-level scripts: <body data-page="product">
const pages = {
  home: () => import('./pages/home.js'),
  product: () => import('./pages/product.js'),
  collection: () => import('./pages/collection.js'),
  checkout: () => import('./pages/checkout.js')
};

async function boot() {
  // WP theme: always localStorage cart → REST checkout (no Haravan / no Woo).
  await cart.init(localAdapter);
  applyI18n();
  await mount();
  observe();
  const page = document.body.dataset.page;
  if (pages[page]) (await pages[page]()).default?.();
  document.documentElement.classList.add('js-ready');
  const syncCount = () => {
    document.querySelectorAll('[data-cart-count]').forEach((el) => {
      el.textContent = String(cart.count());
    });
  };
  syncCount();
  cart.subscribe(syncCount);
  bus.on('cart:change', syncCount);

  // Marketing forms (newsletter / contact) on any page.
  (await import('./pages/forms.js')).default?.();
}

document.readyState === 'loading' ? document.addEventListener('DOMContentLoaded', boot) : boot();

// Public API for inline theme snippets / debugging: window.Soul.cart.add({...})
window.Soul = { cart, mount };
