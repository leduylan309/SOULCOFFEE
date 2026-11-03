# SCSS — SOUL Fine Robusta

Uses the 7-1 pattern with Dart Sass modules (`@use` / `@forward`, no `@import` between partials).

```
scss/
├── abstracts/            # no CSS output: tokens + tooling
│   ├── _variables.scss   # every design token as Sass maps (source of truth)
│   ├── _functions.scss   # color(), ink(), paper(), token(), space(), z()
│   ├── _mixins.scss      # up()/down(), display(), text(), label(), auto-grid(), section(), ratio(), hover
│   └── _index.scss       # @forward all three
├── base/
│   ├── _fonts.scss       # Google Fonts import
│   ├── _root.scss        # emits :root CSS custom properties from the maps
│   ├── _reset.scss       # element resets, focus, selection, reduced motion
│   └── _typography.scss  # .t-hero, .t-h2, .t-body, .t-eyebrow … utilities
├── layout/               # .l-*  section, section-head, grids, rail, header, mega, footer
├── components/           # .c-*  BEM: button/link/icon-btn, eyebrow/badge/label-rule,
│                         #       forms, cards (product/tile/collection/soulful/store/cert),
│                         #       content (stat/capability/service/photo), overlays
├── utilities/            # .u-*  helpers (last, so they win)
├── main.scss             # full build
└── tokens-only.scss      # :root variables + reset only
```

## Build
```bash
npm i -D sass
npx sass scss/main.scss dist/soul.css --no-source-map
npx sass scss/main.scss dist/soul.min.css --style=compressed --no-source-map
npx sass scss/tokens-only.scss dist/soul-tokens.css --no-source-map
```
Pre-built output is in `dist/` (compiled with Dart Sass 1.77.8).

## Naming
- `l-` layout · `c-` component · `u-` utility · `t-` type · `is-` state (`is-selected`, `is-disabled`)
- BEM: `.c-card__title`, `.c-btn--outline`
- Hover and focus-visible share one mixin and swap colours instantly, with no transitions.

## Using tokens in a new partial
```scss
@use '../abstracts' as *;

.c-example {
  @include section(var(--surface-alt));
  &__title { @include display('h2'); }
  &__kicker { @include label('eyebrow'); color: var(--text-accent); }
  border-top: 1px solid ink(14);
  @include down(nav) { padding-inline: 16px; }
}
```

## Relation to `tokens/*.css`
`tokens/*.css` + `styles.css` are the token layer for the design-system tool, the React components and the DC files. They hold the same values as `abstracts/_variables.scss`. When a value changes, edit `_variables.scss`, rebuild, and mirror the change in `tokens/`.
