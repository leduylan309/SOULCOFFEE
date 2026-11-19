# Checklist: dựng trang mới (pattern-first)

Dùng checklist này mỗi khi tạo page trong WordPress admin — **không** tạo file PHP template mới.

---

## 1. Chuẩn bị

- [ ] Xác định loại trang: hub / guide / program / form / store / contact  
- [ ] Chọn full-page starter gần nhất trong **Spark pages** (hoặc blank)  
- [ ] Solid header? (Contact, Policy, Joe Evans, blog…) → meta `_spark_solid_header = 1` hoặc slug đã whitelist  

## 2. Skeleton section (thứ tự chuẩn)

1. **Hero** — block `sparkvn/hero` (variation `page`)  
2. **Summary / In short** — pattern `summary` (nếu cần)  
3. **Body sections** — ghép từ catalog:  
   - Layout: `split`, `split-rev`, `copy-section`, `img-pair`, `photo-strip`  
   - Content: `faq`, `two-lists`, `feat-list`, `notice`, `verdict`, `roadmap*`…  
   - Cards: `hub-grid`, `info-grid`, `q-cards`, `team-grid`…  
   - Tabs: block `sparkvn/tabs` + pattern `tab-panel-*`  
4. **Related** — pattern `related` (đổi link)  
5. **CTA band** — pattern `cta-band`  

Bỏ Related/CTA theo rule trang đặc biệt (xem UX standards).

## 3. Trong editor

- [ ] Insert pattern → **sửa copy**, không để sample text  
- [ ] Ảnh: **Replace** từ Media Library (đã sideload từ theme) — không sửa raw `src`  
- [ ] Links: permalink WP (`/about/`), không `.html`  
- [ ] 1 H2 / section; eyebrow gold nếu có  
- [ ] FAQ dùng Details + style **FAQ item**  
- [ ] Button trên nền tím → style **Gold**  
- [ ] Group xen kẽ → style **Ivory 2** hoặc **Purple**  

## 4. Dữ liệu động

| Cần | Block |
|---|---|
| Danh sách programs live | `sparkvn/query-programs` (ưu tiên hơn static `program-card*`) |
| Blog posts | `sparkvn/query-posts` |
| Store prizes | `sparkvn/query-prizes` (+ pattern `store-anchor-nav`) |
| Resources | `sparkvn/query-resources` |
| Form lead | `sparkvn/form` |

## 5. QA trước publish

- [ ] Desktop + mobile: hero, split, cards không vỡ  
- [ ] Breadcrumb không bị header che (solid header pages)  
- [ ] Form submit (nếu có) → lead lưu + email theo Settings  
- [ ] Không còn placeholder / lorem / link `.html`  
- [ ] Related trỏ đúng trang nội bộ  

## 6. Nếu thiếu pattern

1. Tái dùng pattern gần nhất + chỉnh  
2. Nếu section sẽ dùng ≥2 trang → **tạo pattern mới** (xem `01-pattern-first-rules.md` mục B)  
3. Chỉ mở custom block nếu vượt quá core + pattern  

---

## Ví dụ nhanh: trang Guide mới

```
sparkvn/hero (page)
→ summary
→ split
→ two-lists
→ notice
→ faq
→ related
→ cta-band
```

## Ví dụ nhanh: trang Hub mới

```
sparkvn/hero (page)
→ hub-grid
→ split-rev
→ testimonials (optional)
→ related
→ cta-band
```
