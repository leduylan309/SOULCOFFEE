// WP theme entry — DS registry + local cart + checkout/forms pages.
import { registerMany, mount, observe } from './core/registry.js';
import { apply as applyI18n } from './core/i18n.js';
import { cart, localAdapter } from './services/cart.js';
import { getRecaptchaToken, recaptchaEnabled } from './services/recaptcha.js';
import { bus } from './core/events.js';

const v = () => (window.SoulTheme && window.SoulTheme.ver) || Date.now();
const mod = (path) => () => import(`${path}?v=${v()}`);

registerMany({
  'modal':        mod('./components/modal.js'),
  'header':       mod('./components/header.js'),
  'cart-drawer':  mod('./components/cart-drawer.js'),
  'add-to-cart':  mod('./components/add-to-cart.js'),
  'toast':        mod('./components/toast.js'),
  'lightbox':     mod('./components/lightbox.js'),
  'rail':         mod('./components/rail.js'),
  'chip-group':   mod('./components/chip-group.js'),
  'flavour-tabs': mod('./components/flavour-tabs.js'),
  'stepper':      mod('./components/stepper.js'),
  'form':         mod('./components/form.js'),
  'search':       mod('./components/search.js')
});

const pages = {
  home:       mod('./pages/home.js'),
  product:    mod('./pages/product.js'),
  collection: mod('./pages/collection.js'),
  checkout:   mod('./pages/checkout.js'),
  account:    mod('./pages/account.js'),
  help:       mod('./pages/help.js')
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

window.Soul = { cart, mount, getRecaptchaToken, recaptchaEnabled };
