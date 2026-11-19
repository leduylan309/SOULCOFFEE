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
Admin: `admin` / `admin`

## Hiện trạng vs BRD

Xem BRD §10 và Roadmap Phase 0.  
**Thực thi tiếp theo = Phase 1** trong [`ROADMAP.md`](ROADMAP.md) — chỉ sau khi BRD được duyệt.
