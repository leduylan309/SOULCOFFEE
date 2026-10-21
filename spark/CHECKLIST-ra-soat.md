# Checklist rà soát site-v2 (24 trang)

Ký hiệu: ✅ ảnh local đã có · 🌐 ảnh hotlink từ site cũ (irp.cdn-website.com — cần tải về `assets/img/real/`) · ❌ thiếu ảnh / chỉ có text · ⬜ chưa kiểm

## 1. Ảnh theo từng trang

| Trang | Hiện có | Việc cần làm |
|---|---|---|
| index.html | ✅ 10 local, 🌐 2 (testimonial avatars) | Tải 2 avatar về local; kiểm mascots.png nét hơn |
| about.html | ✅ hero + 7 thumbnail hub | ✔ Đã thêm ảnh từng mục
| our-story.html | 🌐 8 ✅ 1 + CTA band | Tải 8 ảnh về local
| the-spark-method.html | ✅ hero, split, 3 ảnh lớp học, CTA | ✔ Đã bổ sung
| class-size.html | 🌐 3 (IMG_4896, 4878, 2105) + 1 placeholder | Tải về local; thay placeholder |
| english-support.html | 🌐 1 (IMG_4878) | Tải về local; thêm ảnh thứ 2 nếu trang cũ có |
| community.html | ✅ hero, 2 split ảnh thật | ✔ Đã bổ sung
| joe-evans.html | ✅ 2 | OK |
| programs.html | ✅ hero + 6 thumbnail chương trình | ✔ Đã bổ sung
| phonics.html | 🌐 6 (IMG_4220, 2107, 4878, 2105, 4896, 2900) | Tải về local |
| esl.html | 🌐 7 | Tải về local |
| ib-english.html | 🌐 9 | Tải về local |
| ielts-program.html | 🌐 1 (IMG_2112) ✅ 1 | Tải về local |
| tides.html | ✅ hero + split ảnh | ✔ Đã bổ sung
| assessment.html | ✅ 2 | OK |
| access.html | ✅ 3 | OK |
| ask-a-teacher.html | ✅ 2 | OK |
| teachers-corner.html | ✅ 3 | OK |
| teacher-blogs.html | ✅ 1, 🌐 1 | Tải về local |
| blog.html | ✅ 13 local, 🌐 1 + 1 placeholder | Tải về; thay placeholder |
| blog-post.html | 🌐 1 (IMG_3499) | Tải về local |
| contact.html | ✅ hero ảnh + Google Map | ✔ Đã bổ sung
| policy.html | ❌ 0 ảnh | Chấp nhận (trang text) |

**Tổng:** ~45 ảnh đang hotlink từ site cũ → nếu site cũ tắt, ảnh mất. Ưu tiên tải toàn bộ về `assets/img/real/`.

## 2. Layout / spacing (áp dụng cho mọi trang)
- [ ] Card "In short" không đè lên section kế (đã sửa 11 trang)
- [ ] Hero: H1 lớn nhất, không rớt chữ lẻ, mobile ≤ 390px không tràn
- [ ] Section heading màu tím #5D1C61, label vàng gold
- [ ] Khoảng cách giữa các section đều (`--section-y`)
- [ ] Ảnh có `object-fit:cover`, không méo; có `alt`
- [ ] Footer / nav giống nhau trên 24 trang (shell.js)
- [ ] CTA cuối trang có trên mọi trang nội dung

## 3. Typography
- [ ] Heading: AvenirNextLTPro 700–900 (fallback Nunito Sans)
- [ ] Body: Frank Ruhl Libre
- [ ] Không còn Source Serif / Hanken Grotesk sót lại
- [ ] Nút, nav, label đậm ≥ 700

## 4. Nội dung
- [ ] Breadcrumb đúng cấp (Home › About/Programs › Trang)
- [ ] Link nội bộ không 404 (kiểm 24 trang)
- [ ] `<title>` + meta description đúng từng trang
- [ ] Số điện thoại / địa chỉ / giờ mở cửa thống nhất

## 5. Kỹ thuật
- [ ] Không lỗi console
- [ ] Ảnh lớn ≤ 300KB, có `loading="lazy"` ngoài hero
- [ ] Mascots.png: thay bằng file gốc nếu có

## 6. Đã thực thi (20/10)
- Thêm ảnh thiếu: about, programs (thumbnail hub), the-spark-method, community, tides, contact (hero + map)
- CTA band: the-spark-method, our-story
- `loading="lazy"` cho 18 ảnh ngoài hero
- Sửa link hỏng trên about (ib-school-guide → ib-english, parent-guide → blog), programs (speak-clearly → contact)
- Không còn Source Serif / Hanken Grotesk

## 7. Còn tồn
- ✅ Đã tải 102 ảnh/PDF từ site cũ vào `site-v2/assets/img/cdn/` và `site-v2/assets/files/` — không còn hotlink ngoài
- ✅ Các trang Exclusive đã xây (xem mục 8)
- Mascots.png cần file gốc nét hơn

## 8. Trang Exclusive (hoàn tất)
| Trang | Trạng thái |
|---|---|
| parent-center.html | ✅ hub 4 card ảnh |
| why-academic-english-matters.html | ✅ |
| academic-roadmap.html | ✅ stepper + tabs |
| results-dashboard.html | ✅ tabs 4 metric |
| parent-success-roadmap.html | ✅ stepper Month 1 → 12+ |
| resource-library.html | ✅ 4 PDF + form 1 bước |
| ib-school-guide.html | ✅ timeline CEFR + bảng mapping |
| international-school-support-guide.html | ✅ tabs 5 trường |
| reading-age-growth-center.html | ✅ 5 bước |
| student-portal.html | ✅ nút ClassDojo |
| spark-store.html | ✅ ~60 phần thưởng theo nhóm |

Nav: "Parent's Guide" → ask-a-teacher.html; bỏ "Speak Clearly" (site cũ không có nội dung).
Còn tồn: ảnh CDN chưa tải về local; mascots.png cần file gốc.

## 9. SCSS refactor
- ✅ CSS rebuilt into `scss/` (67 partials) and compiled to `css/main.css`. Old spark/blog/site/v2.css removed.
- ✅ Components are independent: they style only their own classes and are themed through custom properties (see `scss/README.md`).
- ✅ 231 unused selectors removed. Parity checked on all pages at 1280/820/390.
