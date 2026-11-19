# Pattern-first rules (local pointer)

**Source of truth (all WordPress projects):**  
`~/.cursor/skills/wordpress-pattern-first/SKILL.md`

Folder `PATTERN-SYSTEM/` chỉ lưu **inventory của theme trong repo này**. Không fork rule theo brand.

## Decision tree

| Situation | Do |
|---|---|
| Section lặp, copy/ảnh/link đổi theo trang | Unsynced pattern |
| Group / Columns / Cover / Details / Buttons / Heading / List | Core + block style |
| Hero video/overlay, Tabs, Form, CPT query, `templateLock` | Custom block |
| Header, footer, breadcrumb | PHP |
| Nhiều item cùng khung dữ liệu | CPT + query block |

## Hard bans

- Không `page-{slug}.php` paste full HTML marketing  
- Không 1 custom block cho mỗi file SCSS  
- Không `wp:html` cho copy marketing (trừ embed thật)  
- Không để link prototype `.html` trong content  
- Không sync CTA/Related khi copy khác từng trang  
- Không ACF để dựng layout mà block/pattern làm được  

## Khi thêm section mới

1. Tái dùng ≥2 trang → component + **pattern** cùng changeset  
2. Ưu tiên core + style  
3. Custom block chỉ khi skill cho phép  
4. Cập nhật `02-pattern-catalog.md` / `03-blocks-and-styles.md`  

Xem thêm: skill `reference.md`.
