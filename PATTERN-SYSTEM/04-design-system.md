# Design system (tokens + components)

Source of truth (live): `wordpress/wp-content/themes/sparkvn/sass/`  
Compile: `npx sass sass/main.scss css/main.css`  
Prototype song song: `html/scss/` (nhiều file giống; theme đã diverge ~22 file cho Gutenberg)

---

## Tokens (`sass/base/_tokens.scss`)

### Color

| Token | Hex |
|---|---|
| `--purple` | `#5D1C61` |
| `--purple-700` | `#4A1750` |
| `--purple-900` | `#320D37` |
| `--purple-tint` | `#F3EAF4` |
| `--purple-line` | `#E4D2E6` |
| `--ivory` | `#FBF7F0` |
| `--ivory-2` | `#F5EDE0` |
| `--paper` | `#FFFFFF` |
| `--ink` | `#2B2530` |
| `--ink-soft` | `#6A6470` |
| `--ink-faint` | `#938D9B` |
| `--gold` / `--accent` | `#AF863A` |
| `--gold-soft` | `#C7A659` |
| `--gold-tint` | `#F4ECDC` |
| `--line` | `#E9E0D1` |
| `--line-strong` | `#DBCDB4` |

### Type (tên token bị đảo)

| Token | Face | Dùng cho |
|---|---|---|
| `--font-serif` | Avenir Next → Nunito Sans | Headings / UI |
| `--font-sans` | Frank Ruhl Libre → Georgia | Body |

### Layout

| Token | Value |
|---|---|
| `--container` | `1180px` |
| `--gutter` | `clamp(20px, 5vw, 48px)` |
| `--section-y` | `clamp(72px, 9vw, 132px)` |
| `--r-sm / --r / --r-lg` | `8 / 14 / 22` |

Breakpoints (desktop-first): sm 620 / md 760 / lg 860 / xl 960 / xxl 1180.

---

## Component API (bắt buộc)

1. File component chỉ style **root class của nó**.  
2. Parent chỉ được **định vị** child (margin / width / order) — không tô màu lại.  
3. Đổi appearance từ ngoài = set **public custom properties**.  
4. Surface tối (`.bg-purple`, `.hero`, `.cta-band`) chỉ set biến — không rule màu con cháu.

### Public properties thường dùng

| Target | Props |
|---|---|
| Headings | `--heading-color`, `--subheading-color` |
| `.lead` | `--lead-color`, `--lead-size`, `--lead-lh`, `--lead-weight` |
| `.eyebrow` | `--eyebrow-color` |
| `.chip` | `--chip-bg`, `--chip-fg`, `--chip-border`… |
| `.btn-primary` | `--btn-bg`, `--btn-fg`, `--btn-border`, `--btn-hover-bg` |
| `.btn-ghost` | `--btn-ghost-fg`, `--btn-ghost-border`… |
| `.container` | `--container-max` |
| `.brand` | `--brand-h`, `--logo-white`, `--logo-purple` |
| `.split-media` | `--split-img-ratio`, `--split-img-maxh` |

Chi tiết: `wordpress/wp-content/themes/sparkvn/sass/README.md`

---

## Component roots → pattern / block

| SCSS root | CMS thường dùng |
|---|---|
| `.hero` | Block `sparkvn/hero` |
| `.split` | Pattern `split` / Columns style `split` |
| `.copy` | Pattern `copy-section` |
| `.summary` | Pattern `summary` |
| `.faq-*` | Pattern `faq` + Details style `faq` |
| `.cta-band` | Pattern `cta-band` + Group style `purple` |
| `.related` | Pattern `related` |
| `.hub-grid` / `.hub-card` | Pattern `hub-grid` + block `card` |
| `.adv-grid` | Pattern `advantage-cards` |
| `.prog-feature` / `.pf` | Pattern `program-card*` **hoặc** block `query-programs` |
| `.form-card` | Block `sparkvn/form` |
| `.roadmap` | Pattern `roadmap` / `roadmap-vertical` |
| `.tabs` | Block `sparkvn/tabs` |
| `.profile` / `.option-card` | Chưa có pattern riêng — đang nằm trong page markup |
| `.article-wrap` / `.prose` | PHP `single.php` |
| `.post-grid` | Block `query-posts` + `home.php` |

---

## UX standards ngắn

Từ `html/UX-UI-STANDARDS.md`:

- 1 H2 / section  
- Ảnh content `object-fit: cover`, max height ~460 desktop  
- Split: copy max ~60ch  
- FAQ = native `details`  
- Trang content kết thúc Related + CTA (trừ ngoại lệ Home / Exclusive / Teachers / Contact / single post)  
- Hit target ≥ 44px  

---

## Editor styles

| File | Role |
|---|---|
| `css/main.css` | Full design system trong editor iframe |
| `css/editor.css` | Canvas + inserter + tabs/split fixes |
| `css/editor-post.css` | Mirror `.prose` cho post |
| `css/editor-page.css` | Ẩn title field (title nằm trong hero) |
