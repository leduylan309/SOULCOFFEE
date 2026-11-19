# Blocks & styles — theme `soul`

## Custom blocks

Chưa ship custom block. Forms checkout dùng page template + REST `soul/v1/checkout`.

## Block styles (registered)

| Core | Styles |
|---|---|
| `core/button` | primary, outline, yellow |
| `core/group` | surface-paper, surface-sand, surface-ink, surface-yellow |
| `core/columns` | section-header, tight-10 |
| `core/details` | faq |
| `core/paragraph` | lead, tasting-notes, meta-chain |
| `core/image` | ratio-1-1, ratio-4-5, ratio-16-10 |

## PHP / CPT

| Type | Role |
|---|---|
| `soul_product` | Listing sản phẩm |
| `soul_collection` | Taxonomy collections |
| `soul_order` | Lưu đơn (COD/bank text, không payment gateway) |

## JS

`assets/js/` — localStorage cart only (không Haravan, không Woo).
