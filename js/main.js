// Single entry point. <script type="module" src="js/main.js"></script>
// Components are lazy: only modules whose data-component appears on the page are downloaded.
import { registerMany, mount, observe } from './core/registry.js';
import { apply as applyI18n } from './core/i18n.js';
import { cart, localAdapter, haravanAdapter } from './services/cart.js';

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
  collection: () => import('./pages/collection.js')
};

async function boot() {
  // <html data-cart="haravan"> on the live theme; default = localStorage for prototypes.
  await cart.init(document.documentElement.dataset.cart === 'haravan' ? haravanAdapter : localAdapter);
  applyI18n();
  await mount();
  observe();
  const page = document.body.dataset.page;
  if (pages[page]) (await pages[page]()).default?.();
  document.documentElement.classList.add('js-ready');
}

document.readyState === 'loading' ? document.addEventListener('DOMContentLoaded', boot) : boot();

// Public API for inline theme snippets / debugging: window.Soul.cart.add({...})
window.Soul = { cart, mount };
