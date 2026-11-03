# SOUL Fine Robusta — Design System

Design system for **soulcoffee.vn** (Soul Specialty Coffee / SOUL Fine Robusta), a specialty-coffee roaster and café chain from Buôn Ma Thuột, Việt Nam. It is extracted from the approved homepage redesign **`Home.html`**, which is the source of truth. All values (hex, px, tracking, line-height) are copied from that file and not rounded.

**What Soul sells / does**
- **Roasted coffee (B2C):** Fine Robusta, espresso, hand brew, phin and cold brew, plus the seasonal *Soulful Collection* (2026: Cay · Nồng · Thơm · Ngọt).
- **Green coffee (B2B):** Fine Robusta, Premium Robusta, Liberica and Arabica lots for roasters.
- **Coffee Solutions (B2B):** sourcing, roasting for HORECA, training, workshops and events.
- **Spaces:** cafés in Buôn Ma Thuột, Sài Gòn, Hà Nội, Đà Nẵng and Bà Nà.
- **Proof points:** competition awards (VCPC, SEA Green Coffee, Vietnam Amazing Cup), a team with Q-Grader and SCA roaster/barista certifications, and 500 ha of partner growing area.

## Sources
- `Home.html`: the final homepage design (formerly "SOUL Option 03 v4"). All tokens and components come from it.
- `site-hien-tai/`: crawl of the current live site (02/11/2026). Includes `soulcoffee-sitemap.md` (full sitemap, 66 products, 45 posts, issues found), `00_INDEX.md`, and 151 screenshots.
- `uploads/`: client documents. Brand identity (`SFR23 New Brand Identity.pdf`), brand communication guide, master logo, credential, homepage content VN/EN P1–P3, feedback.
- `feedback/Soul_Homepage_Content_VN_EN.txt`: approved bilingual homepage copy.

---

## Index (manifest)

| Path | What |
|---|---|
| `Soul Design System.dc.html` | Tài liệu tổng hợp: toàn bộ thông tin design trên một trang |
| `scss/` | Nguồn SCSS chuẩn 7-1 (abstracts, base, layout, components, utilities); xem `scss/README.md` |
| `js/` | JavaScript ES modules tái sử dụng (core / services / components / pages / i18n); xem `js/README.md` |
| `examples/vanilla.html` | Demo chạy thật: `dist/soul.css` + `js/main.js` |
| `dist/soul.css`, `dist/soul.min.css`, `dist/soul-tokens.css` | CSS đã biên dịch từ SCSS (Dart Sass 1.77.8) |
| `styles.css` | Global entry, made only of `@import`s. Consumers link this one file. |
| `tokens/fonts.css` | Google Fonts import (Newsreader, Be Vietnam Pro) |
| `tokens/colors.css` | Base palette, ink/paper alphas, semantic surface/text/line/action tokens |
| `tokens/typography.css` | Font families, fluid display scale, text sizes, label tracking |
| `tokens/spacing.css` | Raw spacing scale, fluid layout rhythm, fixed dimensions |
| `tokens/effects.css` | Radius, borders, shadows, motion, z-index, aspect ratios |
| `tokens/base.css` | Element resets (body, links, focus, selection, reduced motion) |
| `assets/logo/` | Elephant mark, wordmark and full lockup, each in ink, paper and yellow |
| `images/` | Production photography used by Home (large originals; see caveats) |
| `guidelines/cards/` | 20 foundation specimen cards (Colors, Type, Spacing, Radius & borders, Interaction, Brand) |
| `components/` | 31 React components in 7 groups; each has `.jsx`, `.d.ts` and `.prompt.md`, and each group has one card |
| `components/_loader.js` | Loads the compiled bundle, or compiles the JSX in the browser if the bundle is missing |
| `ui_kits/website/` | Interactive homepage built from the components |
| `SKILL.md` | Agent-skill entry point |

### Components
- **actions/**: `Button`, `TextLink`, `IconButton`
- **display/**: `Eyebrow`, `SectionHeader`, `Badge`, `LabelRule`
- **forms/**: `TextField`, `TextArea`, `ChipToggle`, `LangToggle`, `QuantityStepper`, `NewsletterForm`
- **commerce/**: `ProductCard`, `CategoryTile`, `CollectionCard`, `SoulfulCard`, `CartLine`
- **content/**: `StatRow`, `CertCard`, `CapabilityItem`, `ServiceRow`, `StoreCard`, `PhotoTile`
- **navigation/**: `SiteHeader`, `MegaMenu`, `SiteFooter`, `MobileMenu`
- **feedback/**: `Toast`, `Lightbox`, `Drawer`

Every component exists in `Home.html`; none were invented. *Intentional additions:* `IconButton` and `Badge` are pulled out as standalone components even though Home only uses them inline, because they repeat in several places.

---

## CONTENT FUNDAMENTALS

**Languages.** The site is fully bilingual: Vietnamese first, with English as an equal version (VI/EN toggle in the header). Vietnamese copy is written natively, not translated, and keeps full diacritics everywhere, including product words in English copy (*Cay, Nồng, Thơm, Ngọt*, *rượu cần*, *Buôn Ma Thuột*).

**Voice.** Calm, knowledgeable and grounded; the voice of a producer, not a seller. Soul speaks as **"chúng tôi" / "we"** and addresses the reader as **"bạn" / "you"**. It explains *why* and *how* (origin → processing → roasting → cup) and never hypes.
- ✅ "Soul tập trung vào những gì giống cà phê này có thể thể hiện khi nguyên liệu, quá trình sau thu hoạch và kỹ thuật rang được chăm chút kỹ hơn."
- ✅ "Nếu tò mò về hạt đang được phục vụ… đừng ngại hỏi Barista nhé." (warm, conversational on the café side)
- ❌ Superlatives without proof ("tốt nhất", "số 1 Việt Nam"). Claims always come with a number and a source: *"87.21 điểm · Top 1 Robusta · Vietnam Coffee Producer Competition 2026"*.

**Casing.**
- Titles use sentence case: "Khám phá các dòng cà phê của Soul", "Visit Soul".
- Eyebrows, nav, buttons, badges and footer meta are UPPERCASE through CSS. Write them in sentence case in the source; the styling uppercases them.
- Brand names keep their own casing: **SOUL** (logo/legal), **Soul** (in running text), **Fine Robusta**, **Soulful Collection 2026**, **Q-Grader**, **SCA Roaster**.

**Copy patterns.**
- **Titles** are short and poetic, under about 10 words: "Từ bản địa, thành bản sắc", "Một thế hệ mới của Robusta Việt Nam".
- **Body** is one or two paragraphs per section, capped at about 54 characters per line.
- **CTAs** are a verb plus an object, with a ↗ arrow for navigation ("Khám phá cà phê ↗", "Xem chứng nhận ↗"). Use ↓ for links that jump within the page.
- **Product meta** is a middle-dot chain: `Buôn Ma Thuột · Robusta TR · Khô (Natural) · Rang đậm vừa`.
- **Tasting notes** are set in Newsreader italic, comma-separated, lower case after the first word: *Cacao, mật ong, ca-ra-men, đậm ngọt*.
- **Numbering** uses two digits (`01`, `02`) for lists, steps and counters (`03 / 05`).
- **No emoji, ever.** The only symbols used as icons are the arrows ↗ ↓ ← →, the × close mark, the ▾ menu caret and the · separator.

---

## VISUAL FOUNDATIONS

**Overall feel.** Editorial and warm, like a printed coffee journal: off-white paper, near-black ink, serif headlines, and one bright Soul yellow used sparingly. Corners are square, there are no gradients, and documentary photography does the emotional work.

**Colour.**
- Ink `#27292D` on Paper `#F4EFE5` is the base pairing.
- Sand `#EAE3D5` is used for alternate sections and light cards.
- Ink and Ink-deep `#1E1F22` are used for dark sections and cards on dark.
- **Soul Yellow `#FFD35B`** is the one accent. Its uses:
  - hover fill on buttons and tiles
  - focus ring and text selection
  - numerals and eyebrows on dark grounds
  - the newsletter band
  - award tags and selected chips
- **Clay `#8E4B33`** is used for eyebrows on light grounds, list numbering, required asterisks, error text, link hover and store dots.
- Secondary text is Stone 700 `#514B42`; muted text and placeholders are Stone 500 `#7C7365`.
- Text on dark grounds is paper at 80%, 75% or 70% alpha. Never go below 70%.
- Lines are always ink at 12–30% alpha; solid ink marks an emphasis line.

**Section rhythm.** Backgrounds alternate paper → sand → ink and never repeat dark-dark. The yellow band appears once per page, right before the ink footer. Home runs: paper (hero, shop, featured) → ink (story) → sand (awards) → ink (Soulful) → sand (solutions) → paper (visit) → yellow (newsletter) → ink (footer).

**Type.**
- **Newsreader 400** (serif) is used for every heading, product name, list item in menus, lead paragraph and big numeral. Tracking is tight (−.02 to −.035em) and line-height is .9–1.12. Italic is only for tasting notes. Never bold.
- **Be Vietnam Pro** (400/500/600) is used for body text (15/1.7) and all UI labels.
- Labels are 10.5–12.5px, UPPERCASE, tracked .08em (nav) to .18em (eyebrow).
- Display sizes are fluid `clamp()` values, from 100px (hero) down to 23px (card title).

**Layout.**
- Full-bleed sections with side padding of `clamp(16px,4vw,64px)` and vertical padding of `clamp(56px,7vw,110px)`.
- Two-column section headers (title left, body right, bottom-aligned) built with `repeat(auto-fit, minmax(min(100%,380–420px),1fr))`, so they reflow to one column without media queries.
- **Tiles always sit on a tight 10px gutter**; this is a signature of the system. Text and media columns are separated by `clamp(28px,4vw,64px)`.
- The header is sticky at 66px. The story text column is sticky at `top: 100px`. No other fixed elements apart from overlays.

**Imagery.** Warm, natural-light documentary photos:
- Origin: cherries, drying beds, fermentation sacks.
- Process: roasting, cupping.
- Product in use: phin, espresso, cold brew.
- People: the team, award ceremonies.

There are no filters, no duotone and no grain overlays. Photos are cropped with `object-fit: cover` into fixed ratios: 16:10 (collection), 4:5 (tiles, stores), 1:1 (product, Soulful), 3:2 (awards), 16:9 (album lead). Packshots sit on a white well. Certificates sit `contain` on a sand-deep well with a soft drop shadow. Empty image wells use Sand-deep `#E2DACB`.

**Corners and borders.** Radius is **0 everywhere**. Exceptions: the 22px cart-count pill (11px radius), round 44px carousel arrows, and the 8px store dot. Borders are hairlines; buttons and fields use 1px solid ink; the newsletter field uses a 2px ink underline. Form fields are **underline-only** (bottom border, no box).

**Cards.** Flat colour blocks with no border, shadow or radius: sand on paper, paper on sand, ink-deep on ink. The structure is the media on top, then 14–22px padding, then text. Card actions sit at the bottom (`margin-top: auto`).

**Shadows.** Only floating layers get a shadow: the mega menu, cart drawer, toast, and certificate objects (filter). Cards never do. There are no inner shadows.

**Hover and press.**
- Hover is an **instant colour swap** (no transitions).
  - Primary button: ink → yellow.
  - Outline button: transparent → ink fill.
  - Category tile: sand → yellow.
  - Links: → clay on light, → yellow on dark.
  - Nav: 2px yellow underline.
  - Underlined text links: the underline goes from 30% to 100% ink.
- There is no press state, no shrink and no opacity fade.
- Focus is a 2px yellow outline with a 3px offset.
- Disabled is 45% opacity.

**Motion.** Essentially none. The only animation is smooth scroll (with a `scroll-padding-top` of 72px) and smooth horizontal scrolling of the certificate rail. `prefers-reduced-motion` is respected. Overlays appear instantly.

**Transparency and blur.** No blur anywhere. Transparency is used only for:
- scrims: ink at 45% behind the drawer and search
- the lightbox backdrop: `rgba(20,21,23,.94)`
- alpha text and lines on dark grounds

**Overlays.** The cart drawer slides in from the right (440px wide; full width and starting 12vh down on mobile). Search drops down full width from the top. The lightbox is full screen and near-black. The mobile menu is a full-screen paper sheet with large serif rows.

---

## ICONOGRAPHY

- **No icon font and no icon library.** The site deliberately uses **typographic glyphs** set in the UI font: ↗ (go / external / CTA), ↓ (jump within the page), ← → (carousel and lightbox), × (close), ▾ (menu caret), − + (stepper), and · (meta separator).
- **The only inline SVG is the search magnifier**: 16×16, 1.5px stroke, `currentColor`. It lives in `IconButton icon="search"`. The hamburger is drawn with a CSS box-shadow (three 1.5px bars).
- **Dots:** an 8px clay circle marks store locations.
- **Logos:** `assets/logo/` contains three marks (elephant, wordmark, full lockup with the "Fine Robusta" text) in ink, paper and yellow.
  - Header: 30px elephant plus a 15px wordmark, with a 12px gap.
  - Footer: the full lockup in yellow at 120px wide.
  - Mobile menu: the wordmark only.
- **No emoji** and no illustrations. If a new icon is genuinely needed, use a Unicode glyph first. Otherwise draw a 1.5px-stroke SVG on a 16px grid in `currentColor`, matching the magnifier. Flag any such addition.

---

## Page patterns for inner pages (guidance)

The pages below are defined in `site-hien-tai/soulcoffee-sitemap.md` but not designed yet. Build them from these parts:

| Page | Compose from |
|---|---|
| Collection (`/collections/*`) | `SectionHeader` (divider) + `LabelRule` filters as `ChipToggle`s + `ProductCard` grid (minmax 260, gap 10) |
| Product (`/products/*`) | Two-column layout: square gallery of `PhotoTile`s on the left; on the right, an `Eyebrow` with the category, a serif name, italic notes, a meta chain, `ChipToggle` variants (200 g / 500 g × whole bean / ground), a `QuantityStepper`, and a primary `Button`. Related products in a `ProductCard` row. |
| Our Story | Ink story block + timeline as `ServiceRow` (n = year) + `CapabilityItem` certifications |
| Coffee Solution (B2B) | Solutions section of Home + `StatRow` capacity numbers (20–60 t/month, 500 ha) + contact form |
| Space hub / branch | `SectionHeader` + `StoreCard` grid; on branch pages, an info list (address, hours, hotline), a menu PDF link and a `PhotoTile` gallery with `Lightbox` |
| Blog list / article | `CategoryTile` (3:2) cards with date as `Eyebrow`; article body at Newsreader lead + 15/1.7 body, max 64ch |

---

## Build checklist (status)
- [x] Audit Home.html; extract colour, type, spacing, radius, borders, shadows, motion and z-index
- [x] Write tokens with base and semantic layers; `styles.css` contains only `@import`s
- [x] Logo variants (3 marks × 3 colours) from the brand SVGs
- [x] 20 foundation cards
- [x] 31 components, each with `.jsx` + `.d.ts` + `.prompt.md`, plus 7 group cards
- [x] Website UI kit (interactive Home: mega menu, cart drawer, toast, lightbox, mobile menu, contact form, newsletter)
- [x] Content, visual and iconography guidelines, plus the inner-page map
- [x] SKILL.md
- [ ] Web-optimised images (the originals are 5–11 MB each and slow the pages down)
- [ ] Hi-fi designs for the inner pages (next task)
