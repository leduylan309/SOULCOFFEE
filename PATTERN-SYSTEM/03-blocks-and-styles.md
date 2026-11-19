# Custom blocks & block styles

## Custom blocks (9)

Path: `wordpress/wp-content/themes/sparkvn/blocks/`  
Inserter category: **Spark** (`sparkvn`)

| Block | Name | Khi dùng | Attributes chính |
|---|---|---|---|
| Hero | `sparkvn/hero` | Đầu trang (home video hoặc page image) | `variation` home/page, `eyebrow`, `title`, `lead`, `imageUrl`/`videoUrl`, CTA, chips |
| Card | `sparkvn/card` | Hub / advantage / team / testimonial / program card | `variation`, `url`, `imageUrl`, `title`, `excerpt`, `cite`… |
| Tabs | `sparkvn/tabs` | Thanh tab + panels | `variation` default/opt-tabs/school-tabs/letters, `labels` |
| Tab panel | `sparkvn/tab-panel` | 1 panel (parent = tabs) | `label`, `layout` split/copy |
| Form | `sparkvn/form` | Lead forms | `variation` assessment/contact/resource/ask-teacher |
| Query programs | `sparkvn/query-programs` | List program CPT live | `layout` |
| Query posts | `sparkvn/query-posts` | Blog grid / featured / more | `variation`, `category`, `perPage` |
| Query prizes | `sparkvn/query-prizes` | Spark Store prizes | (group via CPT) |
| Query resources | `sparkvn/query-resources` | Resource library cards | — |

### Form → email

`sparkvn/form` → `POST /wp-json/sparkvn/v1/lead` → CPT `spark_lead` + staff email (`Settings → Spark Email`).

---

## Block styles (10)

Source: `inc/block-styles.php`

| Core block | Style | Label | Mục đích |
|---|---|---|---|
| `core/group` | `ivory2` | Ivory 2 | Nền section xen kẽ |
| `core/group` | `purple` | Purple | Band tím (CTA-like) |
| `core/group` | `tight` | Tight | Padding gọn |
| `core/columns` | `split` | Split | Hàng ảnh + copy |
| `core/columns` | `split-rev` | Split reverse | Đảo chiều |
| `core/details` | `faq` | FAQ item | FAQ accordion |
| `core/button` | `gold` | Gold | CTA trên nền tím |
| `core/button` | `ghost` | Ghost | Secondary |
| `core/list` | `chips` | Chips | Chip row |
| `core/heading` | `title-hair` | Title hair | Heading có hairline |

Core block patterns mặc định của WP đã **tắt** (`remove_theme_support( 'core-block-patterns' )`).

---

## PHP shell (không phải pattern)

| Phần | File |
|---|---|
| Header | `header.php` |
| Footer | `footer.php` |
| Breadcrumb | `sparkvn_breadcrumb()` trong `inc/template-functions.php` |
| Blog index chrome | `home.php` (hero + query-posts + CTA hard-coded một phần) |
| Single post chrome | `single.php` (article-head, featured, prose, related) |

Khi dựng **page marketing**, ưu tiên pattern trong content — đừng nhân bản logic vào PHP template mới.
