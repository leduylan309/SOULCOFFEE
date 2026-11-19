# Pattern catalog (theme `soul`)

Inserter prefix: `soul/`  
Path: `wordpress/wp-content/themes/soul/patterns/`

## Pages

| File | Slug |
|---|---|
| `page-home.php` | `page-home` |
| `page-our-story.php` | `page-our-story` |
| `page-coffee-solutions.php` | `page-coffee-solutions` |
| `page-help.php` | `page-help` |
| `page-spaces-hub.php` | `page-spaces-hub` (note: hub = CPT archive) |

## Sections

| File | Slug |
|---|---|
| `hero-home.php` | `hero-home` |
| `story-split.php` | `story-split` |
| `newsletter-band.php` | `newsletter-band` |

## Seeded pages (editable in WP)

Home (full §3.6), Our Story, Coffee Solutions, Help — content from `inc/content-pages.php` via `seed-phase2`.

## CPT surfaces (templates, not patterns)

| URL | Template |
|---|---|
| `/products/` | `archive-soul_product.php` |
| `/products/{slug}/` | `single-soul_product.php` |
| `/spaces/` | `archive-soul_space.php` |
| `/spaces/{slug}/` | `single-soul_space.php` |
| `/checkout/` | `templates/checkout.php` |
