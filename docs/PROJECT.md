# SOUL Fine Robusta — Project index

| Tài liệu | Vai trò |
|---|---|
| **[`BRD.md`](BRD.md)** | **Nguồn yêu cầu** — sitemap, features, data, DoD |
| **[`ROADMAP.md`](ROADMAP.md)** | Plan thực thi theo phase (bám BRD) |
| [`../PATTERN-SYSTEM/`](../PATTERN-SYSTEM/) | Catalog patterns / gaps kỹ thuật theme |
| `html/` (local, gitignore) | Prototype UI — không commit |

---

## Stack (tóm tắt)

| | |
|---|---|
| Chạy & build | `wordpress/` · theme `soul` |
| Commerce | CPT product + order · **không Woo** · **không payment gateway** |
| UI reference | `html/` local only |
| Rules | `wordpress-pattern-first` |

## Docker

```bash
docker compose up -d
```

WP http://localhost:8082 · PMA :8083 · Mailpit :8125 · MySQL :3307  
Admin: `admin` / `souladmin`  
SOUL Settings (admin hub): **Contact** · **Commerce** · **Security**  
Nav: Appearance → Menus — object links (Page / Products archive / Spaces archive / Collections); nest under **Sản phẩm** for dropdown (mega on desktop). Hash anchors (`#shipping`…) may stay Custom Link.

### i18n — Polylang

Plugin **Polylang Free**: default `vi` (no prefix) · English `/en/`.  
Header VI|EN = `pll_the_languages` (không cookie `soul_lang`).  
Dịch: pages / posts / `soul_product` / `soul_space` / `soul_collection` / menus. **Không** dịch `soul_order`.  
Theme UI: `soul_t()` + `SoulTheme.i18n` theo `pll_current_language()`.

### Orders (Đơn hàng) — vận hành

Admin list/detail cho CPT `soul_order` (không Woo).

| Field | Values |
|---|---|
| `soul_status` | `new` → `confirmed` → `shipping` → `done` \| `cancelled` (legacy `processing` = `confirmed`) |
| `soul_payment_status` | `unpaid` \| `paid` (tách khỏi fulfillment) |
| Ops meta | `soul_tracking`, `soul_admin_notes`, `soul_paperwork` (attachment IDs — admin only) |

List: filter status/PTTT/thu tiền/ngày, views, bulk, KPI + chart 30 ngày, CSV theo filter.  
Detail: khách/geo, shipping, VAT, lines + totals, tracking, notes, **paperwork** (Media Library PDF/ảnh — chỉ admin upload).  
Toggle email khi đổi status: **SOUL Settings → Commerce**.

## Hiện trạng vs BRD

Xem BRD §10 và Roadmap Phase 0.  
**Thực thi tiếp theo = Phase 1** trong [`ROADMAP.md`](ROADMAP.md) — chỉ sau khi BRD được duyệt.
