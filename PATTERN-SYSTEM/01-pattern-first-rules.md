# Pattern-first rules (SOUL)

Đây là **nhắc rule chung**, không phải catalog brand.

## Source of truth

Personal skill: `~/.cursor/skills/wordpress-pattern-first/SKILL.md`  
Repo rule: `.cursor/rules/wordpress-pattern-first.mdc`

## Decision tree

| Situation | Do this |
|---|---|
| Section lặp; copy/ảnh/link đổi theo trang | **Unsynced block pattern** |
| Group, Columns, Cover, Details, Buttons, Heading, List | **Core block + theme block style** |
| Hero video/overlay, Tabs, Form, CPT query, `templateLock` cứng | **Custom block** only |
| Header, footer, shell | **PHP** template part |
| Nhiều item cùng shape (products, stores, posts) | **CPT + Query Loop** (hoặc Woo/query block) |

## Hard bans

- Không `page-{slug}.php` paste full marketing HTML từ `html/*.html`
- Không 1 custom block / 1 file SCSS component
- Không marketing copy trong `wp:html` (trừ embed thật)
- Không để link prototype `.html` trong content production
- Không sync CTA/related khi copy phải khác mỗi trang
- Không ACF để “vẽ layout” mà blocks/patterns làm được

## Definition of Done

Editor tạo trang mới bằng starter + inserter patterns, đổi copy/ảnh/link, publish **không** cần dev sửa PHP/HTML.
