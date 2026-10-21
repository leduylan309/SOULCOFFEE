# Spark v2 — UX/UI Standards (áp dụng cho mọi section)

## A. Hình ảnh
1. Ảnh nội dung luôn có tỉ lệ cố định (4:3 ngang, 3:4 chân dung, 1:1 avatar/team) + `object-fit:cover`; cao tối đa 460px desktop, 320px mobile.
2. Hero dùng ảnh ngang ≥1600×900, không dùng strip/ảnh crop sát mặt. `object-position` ưu tiên 42% từ trên.
3. Ảnh chưa tải có nền ivory + icon placeholder — không để ô trống trắng.
4. Trong tabs, ảnh ≤400px cao và giữ grid 2 cột (ảnh | nội dung).

## B. Cân bằng ảnh – chữ (split)
5. Hai cột ảnh/chữ canh **top** (align-items:start); ảnh sticky khi chữ dài hơn.
6. Nội dung > ~6 đoạn không được đặt cạnh 1 ảnh nhỏ → tách thành card grid + "Read full bio" (progressive disclosure), hoặc ảnh dạng strip ở trên.
7. Chữ trong split tối đa 60ch/dòng (`.copy` max 720px).

## C. Grid & căn chỉnh
8. Container 1200px, gutter 24px; mọi section dùng `.container` — không tràn ngang (`overflow-x:clip`).
9. Card trong grid cao bằng nhau (flex column, CTA đẩy xuống đáy `margin-top:auto`).
10. Thumbnail trong hub-row canh top với tiêu đề.

## D. Typography & hierarchy
11. H1 hero 54–70px/900; H2 section tím #5D1C61; eyebrow vàng uppercase .74rem.
12. Mỗi section chỉ 1 H2; H3 ≤1.5rem; label/heading font Avenir, body Frank Ruhl Libre.
13. Không hard-break trong tiêu đề; dùng `text-wrap:balance`.

## E. Khoảng cách
14. Section padding `--section-y`; card padding 22–30px; gap grid 18–28px.
15. Card không chạm nền section kế (summary-wrap có padding đều).

## F. Tương tác
16. Hit target ≥44px (summary/tab/button).
17. Tabs: tab đầu active, panel giữ layout; FAQ: 1 details mở không ảnh hưởng chiều cao các card khác.
18. Mỗi trang nội dung kết bằng CTA band tím + Related pages.

## G. Form
19. Tiêu đề form đúng mục đích ("Book a Free Assessment", không phải newsletter); nhãn bắt buộc có *; checkbox đặt cạnh nhãn.
