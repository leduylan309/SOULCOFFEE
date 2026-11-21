# Page fidelity checklist — section → pattern → HTML

SoT visual: `html/*.html` + `html/Soul Design System.dc.html` §12.  
SoT CSS: `html/dist/soul.css` → theme `assets/css/` (synced Wave 1).  
Method: inventory sections → unsynced patterns → page starter/seed → QA vs HTML.

**Status:** `todo` · `wip` · `done` · `skip` (Account)

Theme version: **1.7.0** · Seed: `soul_seeded_home_editable_v1`  
**CMS ↔ UI:** patterns = core blocks (editable). Custom: `soul/add-to-cart`, `soul/lead-form`. No marketing `wp:html`. Rule: `.cursor/rules/cms-ui-fidelity.mdc`.

---

## Sitemap pages

| # | URL | HTML SoT | WP surface | Status |
|---|---|---|---|---|
| 01 | `/` | `Home.html` | page + `page-home` + `home-*` + `home-sections.css` | done (fidelity pass) |
| 02 | `/products/`, `/collections/{slug}/` | `Shop.dc.html` listing | `archive-soul_product` | done |
| 03 | `/products/{slug}/` | `Shop.dc.html` PDP | `single-soul_product` | done |
| 04 | `/checkout/` | `Checkout.dc.html` | `templates/checkout.php` | done |
| 05 | `/our-story/` | `Our Story.dc.html` | `story-*` patterns | done |
| 06 | `/coffee-solutions/` | `Coffee Solutions.dc.html` | `solutions-*` patterns | done |
| 07 | `/spaces/` | `Spaces.dc.html` hub | `archive-soul_space` | done |
| 08 | `/spaces/{branch}/` | `Spaces.dc.html` branch | `single-soul_space` | done |
| 09 | `/blog/` | `Blog.dc.html` listing | `home.php` | done |
| 10 | `/blog/{slug}/` | `Blog.dc.html` article | `single.php` | done |
| 11 | `/help/` (+ anchors) | `Help.dc.html` | `help-*` patterns | done |
| 12 | `/search/` | `Search.dc.html` | `search.php` + rewrite | done |
| 13 | `/new-crop/` | `New Crop.dc.html` | `newcrop-*` patterns | done |
| 14 | 404 | `404.dc.html` | `404.php` | done |
| 15 | `/account/` | `Account.dc.html` | — | skip |
| — | Chrome | `page-chrome.card.html` | `l-header` / `l-footer` + overlays | done |

---

## Chrome (13)

| # | Section | Surface | Done |
|---|---|---|---|
| 01–02 | SiteHeader | `header.php` `.l-header` | [x] |
| 03 | MegaMenu | `data-mega="shop"` | [x] |
| 04 | MobileMenu | `#mobile-menu` | [x] |
| 05–06 | CartDrawer | `#soul-cart` | [x] |
| 07 | QuickAdd | modal JS (existing) | [x] |
| 08 | SearchOverlay | `#soul-search` | [x] |
| 09 | Toast | `.soul-toast-host` | [x] |
| 10 | Lightbox | JS (existing) | [x] |
| 11 | SectionShell | block styles + `.soul-page-shell` | [x] |
| 12 | SiteFooter | `footer.php` `.l-footer` | [x] |
| 13 | MiniFooter | checkout inherits footer | [x] |

---

## 01 Home (9) — fidelity pass vs `Home.html`

Semantic `.s-home-*` sections (not Gutenberg columns). CSS: `assets/css/home-sections.css`. JS: ATC, lightbox album, cert rail, newsletter/contact REST.

| Pattern | `id` | Done |
|---|---|---|
| `soul/home-hero` | `#top` | [x] |
| `soul/home-shop` | `#shop` | [x] |
| `soul/home-featured` | `#featured` | [x] |
| `soul/home-story` | `#story` | [x] |
| `soul/home-awards` | `#awards` | [x] |
| `soul/home-soulful` | `#soulful` | [x] |
| `soul/home-solutions` | `#solutions` | [x] |
| `soul/home-visit` | `#spaces` | [x] |
| `soul/newsletter-band` | `#newsletter` | [x] |

---

## Marketing (Story / Solutions / Help / New Crop / Spaces patterns)

| Area | Patterns | Done |
|---|---|---|
| Our Story | `story-hero` … `story-next` + newsletter | [x] |
| Solutions | `solutions-hero` … `solutions-contact` | [x] |
| Help | `help-hero` · faq · policy · contact | [x] |
| New Crop | `newcrop-*` (6) | [x] |
| Spaces hub starter | `spaces-hub-*` (+ CPT archive) | [x] |

---

## Commerce / utility templates

| Surface | Done |
|---|---|
| Shop listing + empty | [x] |
| PDP detail / quote / story / related | [x] |
| Checkout steps + cart + form + VAT + done | [x] |
| Blog listing + article nav/related | [x] |
| Search idle / results / empty | [x] |
| 404 NotFound | [x] |

---

## Account (9) — skip

Auth / dashboard — BRD F-61; checklist only.

---

## Per-page DoD

1. [x] Section counterparts for sitemap URLs (except Account)
2. [x] Page starters insertable (`soul/page-*`)
3. [x] DS CSS synced; chrome uses `.l-header` / `.l-footer`
4. [x] WP permalinks (no `.html`)
5. [x] Forms REST + honeypot; CPT commerce / no Woo

**Polish còn lại (không chặn Exit):** QuickAdd modal polish, F-72 image optimize. Home fidelity pass completed (1.6.1).
