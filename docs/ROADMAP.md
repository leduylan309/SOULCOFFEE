# SOUL — Roadmap thực thi (bám BRD)

Nguồn yêu cầu: [`BRD.md`](BRD.md).  
**Không** bắt đầu feature ngoài phase đang mở trừ khi cập nhật BRD trước.

---

## Nguyên tắc

1. `wordpress/wp-content/themes/soul` = nơi code.
2. `html/` = tham chiếu local (gitignore).
3. Pattern-first; không WooCommerce; không payment gateway.
4. Mỗi phase kết thúc bằng checklist acceptance trong BRD.

---

## Phase 0 — Baseline (đã xong / ổn định)

- [x] Docker `soul` + permalinks
- [x] Theme activate
- [x] F-01…F-04, F-10, F-20, F-22…F-28, F-70 (bản tối thiểu)
- [x] BRD + PROJECT.md + PATTERN-SYSTEM cập nhật hướng no-Woo

**Exit:** Site mở được Home / Products / Checkout; tạo đơn test OK.

---

## Phase 1 — Catalog & checkout UX hoàn thiện _(BRD đã duyệt)_

**Features:** F-11 (đủ collections), F-12–F-13 polish, F-14 quote-only, F-15 filters, F-16 seed mở rộng, F-21 cart drawer, F-72 ảnh mẫu tối ưu.

**Deliverables**

- [x] Đủ taxonomy §3.4 (`seed-phase1.php`)
- [x] PDP variant multipliers → giá + related
- [x] Cart drawer header
- [x] Filters in-stock / sort
- [x] Quote-only green CTA
- [x] Seed mở rộng (~11 SP; một số collection trống có chủ đích — phụ kiện/Arabica…)
- [ ] F-72 web-optimize toàn bộ ảnh (còn dùng ảnh theme copy)

**Exit:** Listing + PDP + drawer + order capture OK — đạt cho Phase 1 (ảnh optimize chuyển Phase 2 nếu cần).

---

## Phase 2 — Marketing sitemap _(xong baseline)_

**Features:** F-30 đủ Home §3.6, F-31 Our Story, F-32 Solutions, F-33 Spaces, F-34 Help (copy khớp BRD), F-36 404, F-50–F-53 forms + Mailpit, patterns catalog sync.

**Deliverables**

- [x] Home full sections + forms embed
- [x] Pages: Our Story, Coffee Solutions, Help (payment copy = no gateway)
- [x] CPT `soul_space` + 5 chi nhánh + archive/single
- [x] REST newsletter/contact + CPT leads + Mailpit SMTP khi DEBUG
- [x] 404 shortcuts + search
- [x] Pattern catalog sync cơ bản

**Exit:** Sitemap marketing + Help + forms hoạt động — đạt.

---

## Phase 3 — Blog, search, i18n _(xong baseline)_

**Features:** F-40 Blog, F-41–F-42 Search, F-60 VI/EN, F-62 order lookup, N-03 SEO.

**Deliverables**

- [x] Blog page + 5 categories + sample posts
- [x] Search results (post/page/product/space) + header overlay
- [x] VI/EN chrome toggle (cookie) — full content Polylang = Phase 4+
- [x] Order lookup page + REST
- [x] N-03 SEO lightweight (meta + core sitemap) — chuyển/hoàn tất ở Phase 4

**Exit:** Nội dung + tìm kiếm + song ngữ chrome cơ bản — đạt.

---

## Phase 4 — Ops & harden _(xong baseline)_

**Features:** F-29 VAT meta, F-71 CSV, N-01–N-04 harden, F-35 New Crop.

**Deliverables**

- [x] F-29 VAT checkbox + company/MST/email/address trên checkout → `soul_vat` meta
- [x] F-71 Export CSV từ admin list `soul_order`
- [x] N-03 Meta description + SEO box + core XML sitemap (product/space)
- [x] N-01/N-04 Skip link, focus-visible, Esc overlays; honeypot + REST throttle
- [x] F-35 `/new-crop/` seed + page pattern

**Exit:** Vận hành admin ổn; sẵn sàng content freeze — đạt.

---

## Backlog có chủ đích trì hoãn

| Item | Lý do |
|---|---|
| F-61 Full Account | Không cần cho order capture v1 |
| Payment gateway | Ngoài scope BRD |
| WooCommerce | Ngoài scope BRD |
| Haravan adapter trong theme | Live cũ; WP là target |

---

## Cách mở phase mới

1. Đánh dấu phase trước Exit đạt.
2. Nếu đổi scope (ví dụ bật gateway) → **sửa BRD trước**, rồi roadmap.
3. Cập nhật `PATTERN-SYSTEM/06-gaps-checklist.md` theo phase.
