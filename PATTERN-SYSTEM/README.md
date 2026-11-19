# Pattern System Kit (per-project inventory)

Đây **không** phải rule riêng Spark.

- **Rule bắt buộc cho mọi dự án WordPress:** personal skill  
  `~/.cursor/skills/wordpress-pattern-first/`  
  (agent phải đọc skill đó khi làm WP theme / Gutenberg / patterns)

- **Folder này:** catalog **của repo hiện tại** — patterns, blocks, tokens đang có, checklist dựng trang, gap.

## Đọc

| File | Nội dung |
|---|---|
| [01-pattern-first-rules.md](01-pattern-first-rules.md) | Nhắc rule chung (trỏ về skill) |
| [02-pattern-catalog.md](02-pattern-catalog.md) | Catalog patterns **trong theme này** |
| [03-blocks-and-styles.md](03-blocks-and-styles.md) | Blocks + styles **trong theme này** |
| [04-design-system.md](04-design-system.md) | Tokens / components **trong theme này** |
| [05-compose-new-page.md](05-compose-new-page.md) | Checklist editor cho theme này |
| [06-gaps-checklist.md](06-gaps-checklist.md) | Gap linh hoạt của theme này |
| [index.json](index.json) | Index máy |

## Rule vàng (mọi WP project)

```
Repeated section + đổi copy  → unsynced pattern
Group/Columns/Details/Button → core + block style
Hero video / Tabs / Form / CPT query → custom block only
Header / footer / breadcrumb → PHP
Cấm: page-*.php HTML clone, 1 block / 1 SCSS file, wp:html cho marketing copy
```

Chi tiết đầy đủ: skill `wordpress-pattern-first`.
