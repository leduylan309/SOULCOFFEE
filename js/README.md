# JS — SOUL Fine Robusta

Plain ES modules with no framework, no build step, and no dependencies. One entry file, `js/main.js`, loads only the components that the page actually uses.

```
js/
├── main.js                 # entry: registers components, boots cart + i18n, mounts, page hook
├── core/                   # framework-agnostic utilities (no UI)
│   ├── config.js           # breakpoints, z-index, state classes (mirrors SCSS)
│   ├── dom.js              # $, $$, on, delegate, readData, html, esc, debounce
│   ├── events.js           # bus.emit / bus.on (+ mirrored `soul:*` DOM events)
│   ├── store.js            # createStore(): get / set / update / subscribe
│   ├── storage.js          # namespaced localStorage (soul:*)
│   ├── format.js           # pad2, counter, vnd, metaChain, isEmail, isPhoneVN
│   ├── i18n.js             # t(), setLang(), data-i18n / data-i18n-attr
│   ├── component.js        # Component base class (options, listeners, emit, destroy)
│   ├── registry.js         # register / mount / unmount / observe (lazy import)
│   └── overlay.js          # modal stack: [hidden], scroll lock, focus trap, Esc, restore focus
├── services/               # data, no DOM
│   ├── cart.js             # cart store + localAdapter / haravanAdapter
│   └── search.js           # diacritic-insensitive product search
├── components/             # one behaviour per file, `export default class extends Component`
│   ├── modal.js            # generic dialog (mobile menu, any popup)
│   ├── cart-drawer.js      # extends Modal, renders cart via <template>
│   ├── search.js           # extends Modal, live results via <template>
│   ├── header.js           # mega menu + live cart count
│   ├── add-to-cart.js      # data-product JSON → cart.add → toast
│   ├── toast.js            # toast host + toast() helper
│   ├── lightbox.js         # gallery → one shared viewer
│   ├── rail.js             # horizontal carousel prev/next
│   ├── chip-group.js       # single/multi toggle chips → hidden input
│   ├── stepper.js          # − qty +
│   ├── form.js             # validation, async submit, success swap
│   └── lang-toggle.js      # VI / EN
├── pages/                  # page-only glue (body[data-page])
│   ├── home.js · product.js · collection.js
└── i18n/
    ├── vi.js · en.js
```

## Usage
```html
<link rel="stylesheet" href="dist/soul.css">
<script type="module" src="js/main.js"></script>

<body data-page="product">
  <div data-component="rail" data-step="0.8">…</div>
  <button data-component="add-to-cart" data-product='{"id":"cay","name":"Soulful — Cay"}'>Thêm vào giỏ</button>
  <button data-open="mobile-menu">Menu</button>
  <div id="mobile-menu" data-component="modal" hidden>… <button data-close>×</button></div>
  <div data-component="toast"></div>
```
- A single element can carry several components: `data-component="rail lightbox"`.
- Options come from `data-*` attributes and are type-converted automatically (`data-step="0.8"` becomes the number `0.8`, `data-product='{…}'` becomes an object).
- Content injected later (AJAX, Haravan sections) mounts automatically through `observe()`.
- Live example: `examples/vanilla.html`.

## Rules for reuse
1. **Components never import each other.** They communicate through `bus` events (`cart:added`, `cart:open`, `toast:show`, `lang:change`, …) or `soul:*` DOM events.
2. **No markup or styles in JS.** JS only toggles `hidden`, `aria-*` and `is-*` classes; CSS (SCSS) owns the appearance. Repeated markup lives in a `<template>` inside the HTML.
3. **Every modal layer goes through `core/overlay.js`**, which gives consistent focus trapping, Esc, scroll lock and focus restore.
4. **Data goes through `services/`.** Swap adapters to change backends: `<html data-cart="haravan">` turns on the Haravan AJAX cart API.
5. **Text goes through `i18n`.** Never hard-code VI/EN strings inside a component.
6. **`pages/` is only for logic that exists on that one page.** If it shows up on two pages, move it to `components/`.

## Adding a component
```js
// js/components/accordion.js
import { Component } from '../core/component.js';
export default class Accordion extends Component {
  static defaults = { single: true };
  init() { this.$$('[data-acc-toggle]').forEach((b) => this.on(b, 'click', () => this.toggle(b))); }
  toggle(b) { const p = b.nextElementSibling; p.hidden = !p.hidden; b.setAttribute('aria-expanded', String(!p.hidden)); this.emit('accordion:toggle', { open: !p.hidden }); }
}
```
Then register it in `main.js`: `'accordion': () => import('./components/accordion.js')`.

## Haravan theme
Copy `dist/soul.css` and `js/` into `assets/`, then load `{{ 'main.js' | asset_url }}` with `type="module"`. Set `data-cart="haravan"` on `<html>`. Search can read `/search?view=json` through `data-endpoint`.
