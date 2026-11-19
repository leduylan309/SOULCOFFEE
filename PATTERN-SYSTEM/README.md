# Pattern System Kit — SOUL Fine Robusta

Catalog **của repo này**. Không thay thế rule chung.

- **Rule bắt buộc mọi dự án WP:** skill  
  `~/.cursor/skills/wordpress-pattern-first/`  
  (agent phải đọc skill khi làm theme / Gutenberg / patterns)

- **Folder này:** inventory patterns, blocks, tokens, checklist dựng trang, gap — cập nhật khi theme thay đổi.

Theme đang chạy: [`wordpress/wp-content/themes/soul/`](../wordpress/wp-content/themes/soul/).  
`html/` = prototype local (gitignore). Commerce: CPT sản phẩm + đơn hàng — **không WooCommerce**.

## Đọc

| File | Nội dung |
|---|---|
| [01-pattern-first-rules.md](01-pattern-first-rules.md) | Nhắc rule chung (trỏ skill) |
| [02-pattern-catalog.md](02-pattern-catalog.md) | Catalog patterns dự kiến từ HTML |
| [03-blocks-and-styles.md](03-blocks-and-styles.md) | Custom blocks + block styles dự kiến |
| [04-design-system.md](04-design-system.md) | Tokens / components Soul |
| [05-compose-new-page.md](05-compose-new-page.md) | Checklist editor |
| [06-gaps-checklist.md](06-gaps-checklist.md) | Gap linh hoạt hiện tại |
| [index.json](index.json) | Index máy |

## Rule vàng

```
Repeated section + đổi copy  → unsynced pattern
Group/Columns/Details/Button → core + block style
Hero video / Tabs / Form / CPT query → custom block only
Header / footer / breadcrumb → PHP
Cấm: page-*.php HTML clone, 1 block / 1 SCSS file, wp:html cho marketing copy
```

Chi tiết: skill `wordpress-pattern-first`.  
Yêu cầu sản phẩm: [`docs/BRD.md`](../docs/BRD.md) · Plan: [`docs/ROADMAP.md`](../docs/ROADMAP.md) · Index: [`docs/PROJECT.md`](../docs/PROJECT.md).
