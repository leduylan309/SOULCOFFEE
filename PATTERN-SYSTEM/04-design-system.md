# Design system — SOUL Fine Robusta

Source of truth (prototype): [`html/`](../html/) — updated Nov 2026 (`Soul Design System.dc.html` v1.0).  
- Tokens: `html/tokens/*.css` · `html/dist/soul-tokens.css`  
- SCSS: `html/scss/` → `html/dist/soul.css` / `soul.min.css`  
- Spec: `html/readme.md`, `html/Soul Design System.dc.html` (§12 = 93 sections / 12 pages + chrome)  
- Section cards: `html/components/sections/page-*.card.html`  
- Components (React specimens): `html/components/`  
- Vanilla runtime: `html/js/`

Theme mirror: `wordpress/wp-content/themes/soul/assets/css/soul.css` + `soul-tokens.css` (+ `theme-chrome.css` WP overlays). Sync from `html/dist/` when DS updates.

---

## Colour

| Token | Hex | Role |
|---|---|---|
| `--ink` | `#27292D` | Text / primary button |
| `--ink-deep` | `#1E1F22` | Dark cards |
| `--paper` | `#F4EFE5` | Base ground |
| `--sand` | `#EAE3D5` | Alternate sections / light cards |
| `--sand-deep` | `#E2DACB` | Empty image wells |
| `--yellow` / accent | `#FFD35B` | Hover, focus, newsletter, awards |
| `--clay` | `#8E4B33` | Eyebrow light, errors, link hover |
| Stone 700 | `#514B42` | Secondary text |
| Stone 500 | `#7C7365` | Muted / placeholder |

Section rhythm: paper → sand → ink; yellow band **một lần** trước footer ink. Không dark-dark liên tiếp.

---

## Type

| Face | Use |
|---|---|
| **Newsreader 400** | Headings, product names, menus, lead, big numerals; italic = tasting notes only |
| **Be Vietnam Pro** 400/500/600 | Body 15/1.7, UI labels |

Labels: 10.5–12.5px, UPPERCASE via CSS, tracking ~.08–.18em.  
Display: fluid `clamp()`, hero ~100px → card ~23px. Never bold Newsreader.

---

## Layout & chrome

- Side pad `clamp(16px,4vw,64px)`; section Y `clamp(56px,7vw,110px)`
- Tile gutter **10px** (signature)
- Sticky header **66px**; story column sticky `top: 100px`
- Radius **0** (exceptions: cart pill, carousel arrows, store dot)
- Cards: flat colour, no shadow; shadows only overlays (mega, drawer, toast, certs)

---

## Motion & interaction

- Hover = instant colour swap (no transition)
- Focus = 2px yellow outline, 3px offset
- Almost no animation; respect `prefers-reduced-motion`
- Icons: typographic glyphs ↗ ↓ ← → × ▾ · ; search SVG only

---

## Component groups (`html/components/`)

actions · display · forms · commerce · content · navigation · feedback — 31 specimens extracted from Home.  
SCSS component API: file owns root class; parents position only; appearance via public custom properties.
