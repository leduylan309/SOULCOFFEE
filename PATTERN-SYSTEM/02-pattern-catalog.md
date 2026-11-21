# Pattern catalog (theme `soul`)

Inserter prefix: `soul/`  
Path: `wordpress/wp-content/themes/soul/patterns/` (~45 files)  
Fidelity tracker: [`docs/PAGE-FIDELITY-CHECKLIST.md`](../docs/PAGE-FIDELITY-CHECKLIST.md)

## Page starters

| Slug |
|---|
| `page-home` · `page-our-story` · `page-coffee-solutions` · `page-help` · `page-spaces-hub` · `page-new-crop` |

## Home sections (fidelity pass — semantic HTML + `home-sections.css`)

`home-hero` · `home-shop` · `home-featured` · `home-story` · `home-awards` · `home-soulful` · `home-solutions` · `home-visit` · `newsletter-band`

SoT: `html/Home.html`. Patterns = **editable** Group/Columns/Image/Buttons + className `s-home-*`.  
Custom blocks: `soul/add-to-cart`, `soul/lead-form`. Compose via `page-home` / `soul_home_full_content()`.

## Marketing sections

| Prefix | Count |
|---|---|
| `story-*` | 8 + newsletter |
| `solutions-*` | 5 |
| `help-*` | 5 |
| `newcrop-*` | 6 |
| `spaces-hub-*` | 3 |
| `not-found` | 1 |

## Legacy

`hero-home` · `story-split` — prefer page-specific patterns above.

## CPT / template surfaces

| URL | Template |
|---|---|
| `/products/` | `archive-soul_product.php` |
| `/products/{slug}/` | `single-soul_product.php` |
| `/spaces/` | `archive-soul_space.php` |
| `/spaces/{slug}/` | `single-soul_space.php` |
| `/checkout/` | `templates/checkout.php` |
| `/search/` | `search.php` (+ rewrite) |
| `/blog/` | `home.php` |
| 404 | `404.php` |
