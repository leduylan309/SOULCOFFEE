# Compose a new page (SOUL)

Dùng khi theme + patterns đã ship. Hiện tại: checklist mục tiêu.

## Steps

1. Pages → Add New (blank hoặc insert full-page starter: Home / Our Story / Solutions / Spaces / Help / Guide)
2. Inserter → category theme (Pages / Layout / Cards / Content / CTAs / Forms)
3. Một pattern = một section; sắp xếp theo rhythm paper/sand/ink
4. Đổi copy, ảnh, link trong editor (VI trước; EN qua multilingual plugin khi có)
5. Dynamic: Query Loop / Woo / form blocks — không paste HTML prototype
6. Preview desktop + mobile; publish

## Page recipes

### Marketing / guide
Hero → Split / copy → Summary or pillars → FAQ → Related → Newsletter

### Our Story–like
Hero → Manifesto → Philosophy → Team → Fine Robusta → Channels → Journey → Newsletter

### B2B Solutions
Hero → Capacity stats → Service rows → Partners → Contact form

### Spaces
Hub: Hero → Store card grid  
Branch: Hero → About → Gallery → Other stores

### Help
Hero → FAQ (`details`) hoặc policy body → Contact

## Không làm

- Tạo `page-{slug}.php` copy từ `html/*.html`
- Nhúng Custom HTML cho cả section marketing
- Để link `Shop.dc.html` / `Home.html` trong content
- Sync pattern mà copy phải khác mỗi trang
