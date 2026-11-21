// WP theme entry — DS registry + local cart + checkout/forms pages.
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
  'flavour-tabs': () => import('./components/flavour-tabs.js'),
  'stepper':      () => import('./components/stepper.js'),
  'form':         () => import('./components/form.js'),
  'lang-toggle':  () => import('./components/lang-toggle.js'),
  'search':       () => import('./components/search.js')
});

const pages = {
  home: () => import('./pages/home.js'),
  product: () => import('./pages/product.js'),
  collection: () => import('./pages/collection.js'),
  checkout: () => import('./pages/checkout.js')
};

async function boot() {
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

  (await import('./pages/forms.js')).default?.();

  // Space gallery: keep "NN ảnh" in sync with Media Library images in the block.
  document.querySelectorAll('.s-space-br-gallery').forEach((g) => {
    const n = g.querySelectorAll('.wp-block-gallery .wp-block-image, .wp-block-gallery .blocks-gallery-item').length;
    const el = g.querySelector('[data-gallery-count]');
    if (el) el.textContent = String(n).padStart(2, '0') + ' ảnh';
  });

  // Partners: keep count in sync with Gallery logos.
  document.querySelectorAll('.s-sol-pt').forEach((g) => {
    const n = g.querySelectorAll('.wp-block-gallery .wp-block-image, .wp-block-gallery .blocks-gallery-item').length;
    const el = g.querySelector('[data-partners-count]');
    if (el && n) el.textContent = n + ' đối tác';
  });
}

document.readyState === 'loading' ? document.addEventListener('DOMContentLoaded', boot) : boot();

window.Soul = { cart, mount };
