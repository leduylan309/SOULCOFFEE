# Gaps — để trang linh hoạt hơn

Audit hiện trạng (theme `sparkvn`): mạnh khi **sửa trang đã seed**; yếu hơn khi **ghép trang mới từ khung trống**.

---

## Đã có (nền tảng ổn)

- [x] 62 unsynced patterns + 6 categories  
- [x] 9 custom blocks đúng chỗ (hero/tabs/form/queries)  
- [x] 10 block styles trên core  
- [x] Tokens + component API SCSS  
- [x] Rule docs: `docs/RULES.md`, `docs/STRUCTURE.md`  
- [x] Seed 27 pages từ HTML → Gutenberg  

---

## Gap ưu tiên

### P1 — Full-page starters thiếu

Chỉ ~10/`page-*` trong khi sitemap seed ~27 pages. Thiếu starter cho (ví dụ):

- Contact, Policy, Community, Exclusive  
- Parent Center / Academic Roadmap / Results / Parent Success  
- Resource Library, Spark Store, Student Portal  
- Teachers Corner / Ask a Teacher / Teacher Blogs  
- The Spark Method, IB School Guide, Reading Age Growth  

**Action:** thêm `page-*` patterns (hoặc generic `page-guide` / `page-hub` variants đủ dùng) — không cần 1:1 mọi slug nếu starter generic cover được.

### P2 — Programs hub static vs live

- Block `sparkvn/query-programs` đã có  
- Seed / pattern `page-programs` vẫn dùng **static** `program-card*`  

**Action:** chuyển Programs hub sang `query-programs` để editor không phải nhân bản card.

### P3 — Section chưa thành pattern

| SCSS / HTML | Gap |
|---|---|
| `.profile` / profile grid | Chỉ trong English Support markup |
| `.option-card` | Trong tabs, chưa pattern riêng |
| Blog list / article chrome | Hard-code `home.php` / `single.php` |
| Page-specific `sass/sections/*` | Nhiều layout chưa nâng lên component + pattern |

### P4 — Pattern “bẩn” sample

Một số pattern nhúng block lạ (form trong `info-grid`, tabs trong `photo-strip`, card trong `sec-head`).  

**Action:** dọn sample → chỉ markup đúng mục đích section.

### P5 — Docs drift

`docs/STRUCTURE.md` catalog pattern **thiếu** nhiều file thực tế (`page-programs`, `roadmap-vertical`, `program-card*`, …).  

**Action:** coi folder `PATTERN-SYSTEM/` là catalog sống; sync lại STRUCTURE khi ổn định.

### P6 — theme.json chưa đủ token

Thiếu palette: `purple-line`, `ink-faint`, `gold-tint`, `line-strong`. Không có `fontSizes` presets.

---

## Definition of Done — “flexible page creation”

Editor có thể:

1. Tạo page trống hoặc từ starter  
2. Insert mọi section marketing từ inserter (không cần FTP/HTML)  
3. Đổi copy/ảnh/link trong block editor  
4. Dùng query blocks cho dữ liệu CPT  
5. Publish mà không nhờ dev  

Khi còn phải sửa PHP template hoặc paste HTML raw → gap chưa đóng.

---

## Backlog gợi ý (thứ tự)

1. Dọn pattern samples lệch mục đích  
2. Programs hub → `query-programs`  
3. Pattern `profile-grid`, `option-cards`  
4. Thêm 4–6 full-page starters generic (hub / guide / form / store / teachers / parent)  
5. Sync `docs/STRUCTURE.md` với catalog này  
6. Bổ sung `theme.json` palette còn thiếu  
