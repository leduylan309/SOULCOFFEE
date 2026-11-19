# Pattern catalog (62)

Source: `wordpress/wp-content/themes/sparkvn/patterns/`  
Inserter slug prefix: `sparkvn/`

Patterns là **unsynced sample** — insert rồi sửa copy/ảnh. Không phải empty skeleton.

---

## Spark pages (10) — full-page starters

| File | Slug | Dùng cho |
|---|---|---|
| `page-home.php` | `page-home` | Home |
| `page-hub.php` | `page-hub` | About hub |
| `page-our-story.php` | `page-our-story` | Our Story |
| `page-joe-evans.php` | `page-joe-evans` | Joe Evans (solid header) |
| `page-english-support.php` | `page-english-support` | English Support |
| `page-class-size.php` | `page-class-size` | Class Size |
| `page-guide.php` | `page-guide` | Guide starter (≈ Class Size) |
| `page-program.php` | `page-program` | Program CPT starter (Phonics) |
| `page-programs.php` | `page-programs` | Programs hub |
| `page-form.php` | `page-form` | Assessment / form page |

---

## Spark layout (11)

| File | Slug | Section |
|---|---|---|
| `split.php` | `split` | Image + copy |
| `split-rev.php` | `split-rev` | Split đảo chiều + two lists |
| `split-tall.php` | `split-tall` | Portrait split |
| `copy-section.php` | `copy-section` | Long-form `.copy` |
| `sec-head.php` | `sec-head` | Section heading centered |
| `img-pair.php` | `img-pair` | Hai ảnh cạnh nhau |
| `photo-strip.php` | `photo-strip` | Dải ảnh ngang |
| `tab-panel-split.php` | `tab-panel-split` | Nội dung 1 tab (split) |
| `tab-panel-copy.php` | `tab-panel-copy` | Nội dung 1 tab (copy) |
| `tabs-levels.php` | `tabs-levels` | Tabs levels chương trình |

---

## Spark cards (16)

| File | Slug | Section |
|---|---|---|
| `hub-grid.php` | `hub-grid` | About hub cards |
| `info-grid.php` | `info-grid` | Info cards |
| `advantage-cards.php` | `advantage-cards` | Home advantages |
| `program-feature.php` | `program-feature` | 6 program teasers |
| `program-detail.php` | `program-detail` | Home program detail |
| `program-card.php` | `program-card` | 1 teaser generic |
| `program-card-phonics.php` | `program-card-phonics` | Phonics teaser |
| `program-card-esl.php` | `program-card-esl` | ESL teaser |
| `program-card-ib-english.php` | `program-card-ib-english` | IB English teaser |
| `program-card-tides.php` | `program-card-tides` | Tides teaser |
| `program-card-ielts.php` | `program-card-ielts` | IELTS teaser |
| `program-card-speak-clearly.php` | `program-card-speak-clearly` | Speak Clearly teaser |
| `pathway.php` | `pathway` | Learning pathway |
| `testimonials.php` | `testimonials` | Parent quotes |
| `team-grid.php` | `team-grid` | Team |
| `q-cards.php` | `q-cards` | Question cards |

---

## Spark content (17)

| File | Slug | Section |
|---|---|---|
| `summary.php` | `summary` | In short |
| `two-lists.php` | `two-lists` | Paired lists |
| `feat-list.php` | `feat-list` | Feature rows |
| `faq.php` | `faq` | FAQ (`core/details`) |
| `notice.php` | `notice` | Parent notice |
| `flag-list.php` | `flag-list` | Watch-out flags |
| `table.php` | `table` | Mapping table |
| `cefr.php` | `cefr` | CEFR levels |
| `verdict.php` | `verdict` | Minus / Yes / Plus |
| `pillars.php` | `pillars` | Numbered pillars |
| `scorecard.php` | `scorecard` | Scorecard |
| `steps.php` | `steps` | Numbered steps |
| `step-grid.php` | `step-grid` | 2-col skill steps |
| `roadmap.php` | `roadmap` | Horizontal roadmap |
| `roadmap-vertical.php` | `roadmap-vertical` | Parent timeline |
| `roadmap-step.php` | `roadmap-step` | 1 timeline row |
| `chips.php` | `chips` | Chip list |

---

## Spark CTAs (4)

| File | Slug | Section |
|---|---|---|
| `cta-band.php` | `cta-band` | Purple assessment band |
| `related.php` | `related` | Related pills |
| `inline-cta.php` | `inline-cta` | Inline prompt |
| `promo-band.php` | `promo-band` | Home promo |

---

## Spark forms / connect (5)

| File | Slug | Section |
|---|---|---|
| `form-split.php` | `form-split` | Assessment form + copy |
| `contact-list.php` | `contact-list` | Contact + map |
| `map-card.php` | `map-card` | Map iframe |
| `portal-card.php` | `portal-card` | Student portal |
| `store-anchor-nav.php` | `store-anchor-nav` | Store + `query-prizes` |

---

## Gợi ý ghép nhanh theo loại trang

| Loại trang | Pattern stack gợi ý |
|---|---|
| Marketing / guide | `page-guide` hoặc Hero → Split → Summary → FAQ → Related → CTA |
| Hub (About-like) | Hero → Hub grid → Split → Related → CTA |
| Program detail | `page-program` → Summary → Tabs levels → FAQ → Related → CTA |
| Form | `page-form` / Form split |
| Store | Hero → Store anchor nav |
| Contact | Contact list (+ solid header meta) |
