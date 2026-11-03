// SOUL website — Home screen, composed from the design-system components.
// Content mirrors Home.html (VI). Globals: React, window.SoulDS (set by loadSoulDS).
const IMG = '../../images/';
const DATA = {
  nav: ['Trang chủ', 'Sản phẩm', 'Mùa vụ mới', 'Về Soul', 'Giải pháp cà phê', 'Cửa hàng'].map((label, i) => ({ label, href: ['#top', '#shop', '#soulful', '#story', '#solutions', '#spaces'][i], hasMenu: i === 1 })),
  roasted: [['Fine Robusta', '02-shop/Pha-thu-cong.png'], ['Pha máy', '02-shop/Espresso.jpg'], ['Pha thủ công', '02-shop/Filter.jpg'], ['Pha phin', '02-shop/Phin.jpg'], ['Cà phê ủ lạnh', '02-shop/Items-Binh-ngam-Coldbrew-3.jpg']],
  featured: [
    { id: 'lib', img: '02-featured/gb_sfr26_libe.jpg', name: 'GB-SFR-Liberica', badge: 'Mùa vụ mới 25/26', type: 'Nhân xanh · Specialty Liberica', notes: 'Vỏ cam, chanh dây, lá xá xị, gợi vị đào', meta: "M'Drak, Đắk Lắk · Natural – lên men Soul Yeast" },
    { id: 'oesp', img: '02-featured/espresso_fine_ro.jpg', name: 'Origin Espresso — Fine Robusta', badge: 'Pha máy', type: 'Cà phê rang · Fine Robusta', notes: 'Cacao, mật ong, ca-ra-men, đậm ngọt', meta: 'Buôn Ma Thuột · Robusta TR · Khô (Natural) · Rang đậm vừa' },
    { id: 'prem', img: '02-featured/premium_coffee_1st_thumbnail.jpg', name: 'Premium Coffee — Robusta', badge: 'Pha phin · Pha máy', type: 'Cà phê rang · Robusta chất lượng cao', notes: 'Chocolate, mật ong, trà đen, gu đắng đậm', meta: 'Buôn Ma Thuột · Robusta · Khô (Natural) · Rang đậm vừa' },
    { id: 'ophin', img: '02-featured/phin_finero.jpg', name: 'Origin Vietnamese Phin — Fine Robusta', badge: 'Pha phin', type: 'Cà phê rang · Fine Robusta', notes: 'Cacao, mật ong, ca-ra-men, đậm ngọt', meta: 'Buôn Ma Thuột · Robusta TR · Khô (Natural) · Rang đậm vừa' }
  ],
  album: ['03-why-soul-album/IMG_3779.png', '03-why-soul-album/SFR4.jpg', '03-why-soul-album/SFR5.jpg', '03-why-soul-album/SFR6.jpg', '03-why-soul-album/SFR7.jpg'],
  stats: [['87.21', 'điểm', 'Top 1 Robusta', 'Vietnam Coffee Producer Competition 2026', true], ['86.85', 'điểm', 'Top 3 Robusta', 'Vietnam Coffee Producer Competition 2026', true], ['86.52', 'điểm', 'Top 2 Robusta', 'Southeast Asia Green Coffee Competition 2026', true], ['500', 'ha', 'Vùng liên kết nguyên liệu tại Tây Nguyên', '', false]],
  caps: [['Q-Grader', 'Đánh giá và chấm điểm nhân xanh theo chuẩn CQI'], ['Processing', 'Sơ chế và lên men ngay tại vùng nguyên liệu'], ['SCA Roaster', 'Phát triển hồ sơ rang theo chuẩn SCA'], ['SCA Barista', 'Pha chế và đào tạo theo chuẩn SCA']],
  certs: [['Top1Ro-Soulfine.jpg', '2026', '87.21', 'Top 1 Robusta', 'Vietnam Coffee Producer Competition 2026'], ['Top3Ro-Soulfine.jpg', '2026', '86.85', 'Top 3 Robusta', 'Vietnam Coffee Producer Competition 2026'], ['Top2-Robusta-SEA-Green-2026.jpg', '2026', '86.52', 'Top 2 Robusta', 'Southeast Asia Green Coffee Competition 2026'], ['VAZ2026_85.36.jpg', '2026', '85.36', 'Hạng 10 Robusta', 'Cà phê Đặc sản Việt Nam 2026 · Vietnam Amazing Cup'], ['VAZ2026_85.25.jpg', '2026', '85.25', 'Cà phê đặc sản · Lot 01', 'Cà phê Đặc sản Việt Nam 2026'], ['cert-CPDS2025.jpg', '2025', '85.29', 'Cà phê đặc sản · Lot TR4', 'Cà phê Đặc sản Việt Nam 2025'], ['cert-CPDC2025.jpg', '2025', '83.54', 'Cà phê đặc sản · Lot Xanh lùn', 'Cà phê Đặc sản Việt Nam 2025'], [null, '2024', '86.83', 'Top 1 Fine Robusta', 'Q Certified Robusta · HQJ Coffee School']],
  soulful: [['Cay', 'Pha phin', 'Fine Robusta TR Red Honey', '04-soulful/Soulful-Cay.jpg'], ['Nồng', 'Pha máy', 'Fine Robusta TR Soul Yeast', '04-soulful/Soulful-Nong.jpg'], ['Thơm', 'Ủ lạnh', 'Fine Robusta TR Cần Wine Yeast', '04-soulful/Soulful-Thom.jpg'], ['Ngọt', 'Pha thủ công', 'Fine Robusta TR Natural Cần Wine Yeast', '04-soulful/Soulful-Ngot.jpg']],
  services: [['Nhân xanh', 'Lựa chọn nguồn cà phê theo chất lượng, mục tiêu rang và nhu cầu sản lượng.'], ['Cà phê rang', 'Phát triển lựa chọn cà phê phù hợp với menu, thiết bị và cách phục vụ.'], ['Đào tạo', 'Đào tạo kiến thức cà phê, đánh giá cảm quan, pha chế và vận hành dành cho chủ quán và đối tác kinh doanh cà phê.'], ['Workshop & Sự kiện', 'Thiết kế workshop và trải nghiệm specialty coffee dành cho doanh nghiệp, agency và các sự kiện thương hiệu.']],
  stores: [['Soul Buôn Ma Thuột', 'Soul-BMT.jpg'], ['Soul Sài Gòn', 'Soul-SG.jpg'], ['Soul Hà Nội', 'Soul-HN.jpg'], ['Soul Đà Nẵng', 'Soul-Da-Nang.jpg'], ['Soul Bà Nà', 'Soul-Ba-Na.png']],
  footer: [['Shop', ['Cà phê rang', 'Nhân xanh', 'Soulful Collection', 'Tất cả sản phẩm']], ['Khám phá', ['Câu chuyện của Soul', 'Cửa hàng']], ['Dành cho đối tác', ['Giải pháp cà phê', 'Nhân xanh', 'Mua sỉ']], ['Hỗ trợ', ['Giao hàng', 'Đổi trả', 'Câu hỏi thường gặp', 'Liên hệ']]]
};
const pad = n => String(n).padStart(2, '0');
const sec = (bg, extra) => ({ background: bg, padding: 'var(--section-y) var(--gutter)', ...extra });
const twoCol = (min = 420, gap = 'var(--block-gap)') => ({ display: 'grid', gridTemplateColumns: `repeat(auto-fit, minmax(min(100%, ${min}px), 1fr))`, gap });
const P = (txt, dark) => <p style={{ margin: 0, maxWidth: 'var(--measure-body)', fontSize: 15, lineHeight: 1.75, color: dark ? 'var(--text-on-dark-secondary)' : 'var(--text-secondary)', textWrap: 'pretty' }}>{txt}</p>;
const H2 = ({ children, size = 'var(--type-display-l)', lh = .98 }) => <h2 style={{ margin: 0, fontFamily: 'var(--font-display)', fontWeight: 400, fontSize: size, lineHeight: lh, letterSpacing: '-.03em', textWrap: 'balance' }}>{children}</h2>;

function Hero({ DS }) {
  const { Eyebrow, Button } = DS;
  return <section id="top" style={{ ...twoCol(440, 0), minHeight: 'min(86vh, 820px)', borderBottom: '1px solid var(--line-default)' }}>
    <div style={{ display: 'flex', flexDirection: 'column', justifyContent: 'space-between', padding: 'clamp(36px,5vw,72px) var(--gutter) clamp(32px,4vw,56px)' }}>
      <Eyebrow tone="muted" rule>Buôn Ma Thuột, Việt Nam</Eyebrow>
      <div style={{ padding: 'clamp(32px,6vh,64px) 0' }}>
        <h1 style={{ margin: 0, maxWidth: '12ch', fontFamily: 'var(--font-display)', fontWeight: 400, fontSize: 'var(--type-hero)', lineHeight: .98, letterSpacing: '-.03em', textWrap: 'balance' }}>Một thế hệ mới của Robusta Việt Nam</h1>
        <p style={{ margin: '28px 0 0', maxWidth: '50ch', fontSize: 'clamp(15px,1.15vw,17px)', lineHeight: 1.7, color: 'var(--text-secondary)' }}>Soul lớn lên từ Buôn Ma Thuột, nơi Robusta đã gắn với đời sống qua nhiều thế hệ. Hôm nay, chúng tôi tiếp tục câu chuyện ấy bằng những cách tiếp cận mới về vùng nguyên liệu, sơ chế, rang và pha chế.</p>
        <div style={{ display: 'flex', flexWrap: 'wrap', gap: 12, marginTop: 36 }}><Button arrow href="#shop">Khám phá cà phê</Button><Button variant="outline" href="#story">Câu chuyện của Soul</Button></div>
      </div>
      <div style={{ display: 'flex', flexWrap: 'wrap', borderTop: '1px solid var(--ink-a16)' }}>{['Cà phê rang', 'Nhân xanh', 'Giải pháp cà phê'].map(l => <a key={l} href="#shop" style={{ flex: '1 1 140px', display: 'flex', justifyContent: 'space-between', padding: '16px 16px 0 0', fontSize: 11.5, letterSpacing: '.12em', textTransform: 'uppercase', fontWeight: 500 }}><span>{l}</span><span style={{ paddingRight: 12 }}>↗</span></a>)}</div>
    </div>
    <figure style={{ margin: 0, position: 'relative', minHeight: 420, background: 'var(--soul-ink)' }}><img src={IMG + '01-hero/SOUL2024_DSF8608_edited.jpg'} alt="Ripe Robusta cherries" style={{ position: 'absolute', inset: 0, width: '100%', height: '100%', objectFit: 'cover' }} /></figure>
  </section>;
}

function Shop({ DS, onAdd }) {
  const { SectionHeader, CollectionCard, LabelRule, CategoryTile, ProductCard, TextLink } = DS;
  return <>
    <section id="shop" style={{ padding: 'clamp(56px,7vw,96px) var(--gutter) clamp(40px,5vw,64px)' }}>
      <SectionHeader eyebrow="Cà phê của Soul" title="Khám phá các dòng cà phê của Soul" body="Từ những lô nhân xanh dành cho nhà rang đến các dòng cà phê rang cho espresso, pha lọc, phin và ủ lạnh, mỗi lựa chọn tại Soul được phát triển từ đặc tính của nguyên liệu." />
      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(min(100%, 420px), 1fr))', gap: 10 }}>
        <CollectionCard index="01" title="Cà phê rang" img={IMG + '02-shop/CA-PHE-RANG.jpg'} href="#roasted" linkLabel="Tất cả sản phẩm" />
        <CollectionCard index="02" title="Nhân xanh" tone="light" img={IMG + '02-shop/Nhan-xanh.jpg'} href="#featured" items={[{ label: 'Fine Robusta' }, { label: 'Premium Robusta' }]} />
      </div>
      <div style={{ margin: 'clamp(36px,4vw,56px) 0 16px' }}><LabelRule id="roasted">Cà phê rang</LabelRule></div>
      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(min(46%, 200px), 1fr))', gap: 10, alignItems: 'start' }}>{DATA.roasted.map(([n, i]) => <CategoryTile key={n} name={n} img={IMG + i} href="#featured" />)}</div>
    </section>
    <section id="featured" style={{ padding: 'clamp(32px,4vw,56px) var(--gutter) clamp(64px,8vw,110px)' }}>
      <SectionHeader divider eyebrow="Sản phẩm nổi bật" title="Những lựa chọn đáng chú ý từ Soul" body="Những sản phẩm được yêu thích, những lô cà phê đạt giải và những lựa chọn tiêu biểu cho cách Soul làm việc với Robusta Việt Nam." action={<TextLink>Xem tất cả cà phê</TextLink>} />
      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(min(100%, 260px), 1fr))', gap: 10 }}>{DATA.featured.map(p => <ProductCard key={p.id} {...p} img={IMG + p.img} alt={p.name} onAdd={() => onAdd({ name: p.name, type: p.type, img: IMG + p.img })} />)}</div>
    </section>
  </>;
}

function Story({ DS, openAlbum }) {
  const { Eyebrow, Button, PhotoTile } = DS;
  return <section id="story" style={sec('var(--surface-inverse)', { color: 'var(--text-on-dark)' })}>
    <div style={{ ...twoCol(420, 'var(--block-gap-l)'), alignItems: 'start' }}>
      <div style={{ position: 'sticky', top: 100, display: 'flex', flexDirection: 'column', gap: 24 }}>
        <Eyebrow tone="on-dark" rule>Crafted by Vietnamese Soul</Eyebrow>
        <H2 size="var(--type-display-m)" lh={1}>Một thế hệ mới lớn lên cùng cà phê</H2>
        <p style={{ margin: 0, maxWidth: '52ch', fontFamily: 'var(--font-display)', fontSize: 'var(--type-lead)', lineHeight: 1.45 }}>Soul lớn lên từ Buôn Ma Thuột, giữa một vùng đất đã gắn với Robusta qua nhiều thế hệ.</p>
        {P('Chúng tôi làm việc với cà phê xuyên suốt từ vùng nguyên liệu, thu hái, sơ chế, đánh giá nhân xanh đến rang và pha chế.', true)}
        <div><Button variant="outline-dark" size="s" arrow href="#awards">Tìm hiểu về Soul</Button></div>
      </div>
      <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 10 }}>
        {DATA.album.map((a, i) => <PhotoTile key={a} img={IMG + a} alt={'Album ' + (i + 1)} ratio={i === 0 ? '16/9' : '4/5'} onClick={() => openAlbum(i)} style={{ gridColumn: i === 0 ? 'span 2' : undefined, marginTop: i === 2 || i === 4 ? 'clamp(24px,4vw,64px)' : 0 }} />)}
        <div style={{ gridColumn: 'span 2', display: 'flex', justifyContent: 'space-between', paddingTop: 8, fontSize: 10.5, letterSpacing: '.16em', textTransform: 'uppercase', color: 'var(--paper-a70)' }}><span>Album · Vùng nguyên liệu</span><span>05</span></div>
      </div>
    </div>
  </section>;
}

function Awards({ DS }) {
  const { SectionHeader, PhotoTile, StatRow, LabelRule, CapabilityItem, CertCard, IconButton, Eyebrow } = DS;
  const track = React.useRef(null);
  const scroll = d => track.current && track.current.scrollBy({ left: d * track.current.clientWidth * .8, behavior: 'smooth' });
  return <section id="awards" style={sec('var(--surface-alt)', { padding: 'var(--section-y-l) var(--gutter)' })}>
    <SectionHeader eyebrow="Năng lực & thành tích" rule size="xl" title="Chất lượng được ghi nhận qua từng mùa vụ" body="Các lô cà phê của Soul được đánh giá bởi những hội đồng chuyên môn trong nước và khu vực, từ Buôn Ma Thuột đến Đông Nam Á." />
    <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(min(100%, 460px), 1fr))', gap: 10 }}>
      <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 10, alignContent: 'start' }}>
        <PhotoTile img={IMG + '03c-awards/web/award-photo-1.jpg'} ratio="3/2" position="center 40%" tag="Top 1 · Vietnam Robusta Coffee Producer 2026" style={{ gridColumn: 'span 2' }} />
        <PhotoTile img={IMG + '03c-awards/web/VCPC2026.jpg'} ratio="3/2" position="60% 60%" />
        <PhotoTile img={IMG + '03c-awards/web/award-photo-2.jpg'} ratio="3/2" position="center 55%" />
      </div>
      <div style={{ background: 'var(--surface-inverse)', padding: 'clamp(24px,3vw,44px)', display: 'flex', flexDirection: 'column' }}>
        <Eyebrow tone="on-dark">Kết quả và thành tích</Eyebrow>
        <ol style={{ margin: '10px 0 0', padding: 0, display: 'flex', flexDirection: 'column', flex: 1, justifyContent: 'space-between' }}>{DATA.stats.map(s => <StatRow key={s[2]} num={s[0]} unit={s[1]} rank={s[2]} comp={s[3]} ctaLabel={s[4] ? 'Xem chứng nhận' : undefined} />)}</ol>
      </div>
    </div>
    <div style={{ marginTop: 'clamp(56px,6vw,96px)' }}><LabelRule strong>Năng lực chuyên môn</LabelRule></div>
    <ul style={{ margin: '24px 0 0', padding: 0, display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(min(46%, 190px), 1fr))', gap: '28px clamp(24px,3vw,48px)' }}>{DATA.caps.map((c, i) => <CapabilityItem key={c[0]} n={pad(i + 1)} label={c[0]} desc={c[1]} />)}</ul>
    <div style={{ marginTop: 'clamp(56px,6vw,96px)' }}><LabelRule strong count="08" actions={<div style={{ display: 'flex', gap: 6 }}><IconButton icon="arrow-left" variant="round" label="Previous" onClick={() => scroll(-1)} /><IconButton icon="arrow-right" variant="round" label="Next" onClick={() => scroll(1)} /></div>}>Chứng nhận & giải thưởng</LabelRule></div>
    <ul ref={track} style={{ margin: '20px calc(-1 * var(--gutter)) 0', padding: '0 var(--gutter) 14px', display: 'flex', gap: 10, overflowX: 'auto', scrollSnapType: 'x mandatory', scrollPaddingLeft: 'var(--gutter)', scrollbarWidth: 'thin' }}>
      {DATA.certs.map(c => <CertCard key={c[2]} img={c[0] ? IMG + '03c-awards/web/' + c[0] : undefined} pdf={c[0] ? undefined : IMG + '03c-awards/VGC2024-Top1-Fine-Robusta-86.83.pdf'} year={c[1]} score={c[2]} rank={c[3]} comp={c[4]} />)}
    </ul>
  </section>;
}

function Soulful({ DS, onAdd }) {
  const { Eyebrow, Button, SoulfulCard } = DS;
  return <section id="soulful" style={sec('var(--surface-inverse)', { color: 'var(--text-on-dark)' })}>
    <div style={{ ...twoCol(420, 'clamp(32px,5vw,80px)'), alignItems: 'center' }}>
      <div style={{ display: 'flex', flexDirection: 'column', gap: 22 }}>
        <Eyebrow tone="on-dark">New crop: Soulful Collection 2026</Eyebrow>
        <H2>Từ bản địa, thành bản sắc</H2>
        {P('Soulful là bộ sưu tập nơi Soul đưa những nghiên cứu về nguyên liệu, sơ chế, lên men và rang vào từng sản phẩm cụ thể.', true)}
        {P('Với mùa vụ 2026, Soulful được thể hiện qua bốn tính cách hương vị: Cay, Nồng, Thơm và Ngọt.', true)}
        <div><Button variant="accent" arrow href="#soulful-cards">Khám phá Soulful 2026</Button></div>
      </div>
      <img src={IMG + '04-soulful/Soulful_vuong.png'} alt="Soulful Collection 2026" style={{ width: '100%', aspectRatio: '1/1', objectFit: 'cover' }} />
    </div>
    <div id="soulful-cards" style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(min(100%, 240px), 1fr))', gap: 10, marginTop: 'clamp(40px,5vw,72px)' }}>
      {DATA.soulful.map(s => <SoulfulCard key={s[0]} word={s[0]} method={s[1]} process={s[2]} img={IMG + s[3]} onAdd={() => onAdd({ name: 'Soulful — ' + s[0], type: s[1] + ' · ' + s[2], img: IMG + s[3] })} />)}
    </div>
  </section>;
}

function Solutions({ DS }) {
  const { Eyebrow, ServiceRow, TextField, TextArea, ChipToggle, Button } = DS;
  const [picked, setPicked] = React.useState([]), [sent, setSent] = React.useState(false);
  return <section id="solutions" style={sec('var(--surface-alt)')}>
    <div style={{ ...twoCol(380), alignItems: 'end' }}>
      <div style={{ display: 'flex', flexDirection: 'column', gap: 18 }}><Eyebrow>Coffee Solutions</Eyebrow><H2 size="clamp(36px,4.6vw,68px)" lh={1}>Giải pháp cà phê cho đối tác</H2>{P('Soul làm việc cùng nhà rang, quán cà phê và doanh nghiệp từ lựa chọn nguyên liệu đến phát triển sản phẩm, đào tạo và vận hành.')}</div>
      <div style={{ display: 'grid', gridTemplateColumns: '2fr 3fr', gap: 10 }}><img src={IMG + '05-solutions/1789033571781_bag-sewing.jpg'} alt="" style={{ width: '100%', aspectRatio: '3/4', objectFit: 'cover' }} /><img src={IMG + '05-solutions/DSCF9134_edited.jpg'} alt="" style={{ width: '100%', height: '100%', objectFit: 'cover' }} /></div>
    </div>
    <div style={{ ...twoCol(380), marginTop: 'clamp(40px,5vw,72px)', alignItems: 'start' }}>
      <ol style={{ margin: 0, padding: 0, borderTop: '1px solid var(--soul-ink)' }}>{DATA.services.map((s, i) => <ServiceRow key={s[0]} n={pad(i + 1)} title={s[0]} body={s[1]} />)}</ol>
      <div id="contact" style={{ background: 'var(--surface-page)', padding: 'var(--panel-pad)' }}>
        <h3 style={{ margin: '0 0 22px', fontFamily: 'var(--font-display)', fontWeight: 400, fontSize: 'clamp(26px,2.4vw,34px)', lineHeight: 1.1 }}>Form liên hệ</h3>
        {sent ? <div style={{ fontFamily: 'var(--font-display)', fontSize: 24, lineHeight: 1.3, padding: '28px 0' }}>Cảm ơn bạn. Soul đã nhận thông tin và sẽ liên hệ lại sớm.</div> :
        <form onSubmit={e => { e.preventDefault(); setSent(true); }} style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(min(100%, 220px), 1fr))', gap: '18px 20px' }}>
          <TextField label="Họ tên" required /><TextField label="Tên doanh nghiệp" /><TextField label="Email" type="email" required /><TextField label="Số điện thoại" type="tel" />
          <fieldset style={{ gridColumn: '1 / -1', margin: 0, padding: 0, border: 0 }}><legend style={{ padding: 0, marginBottom: 10, fontSize: 11, letterSpacing: '.14em', textTransform: 'uppercase', color: 'var(--text-secondary)' }}>Quan tâm đến</legend>
            <div style={{ display: 'flex', flexWrap: 'wrap', gap: 8 }}>{['Nhân xanh', 'Cà phê rang', 'Đào tạo', 'Phát triển menu & quầy bar'].map((t, i) => <ChipToggle key={t} pressed={picked.includes(i)} onClick={() => setPicked(picked.includes(i) ? picked.filter(x => x !== i) : [...picked, i])}>{t}</ChipToggle>)}</div></fieldset>
          <TextArea label="Nội dung cần trao đổi" style={{ gridColumn: '1 / -1' }} />
          <div style={{ gridColumn: '1 / -1' }}><Button type="submit" size="l" style={{ fontWeight: 600 }}>Gửi thông tin</Button></div>
        </form>}
      </div>
    </div>
  </section>;
}

function Visit({ DS }) {
  const { SectionHeader, Button, StoreCard } = DS;
  return <section id="spaces" style={sec('transparent')}>
    <SectionHeader eyebrow="Cửa hàng" title="Ghé Soul" size="display" body={['Bạn có thể ghé bất kỳ cửa hàng nào của Soul để thưởng thức cà phê theo nhiều cách khác nhau, từ cà phê pha máy đến các phương pháp pha thủ công.', 'Mỗi ngày, quầy bar có thể mang đến những lựa chọn cà phê khác nhau. Đừng ngại hỏi Barista nhé.']} action={<Button variant="outline" size="s" arrow>Khám phá cửa hàng</Button>} />
    <ul style={{ margin: 0, padding: 0, listStyle: 'none', display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(min(46%, 210px), 1fr))', gap: 10 }}>{DATA.stores.map(s => <li key={s[0]}><StoreCard name={s[0]} img={IMG + '06-spaces/' + s[1]} /></li>)}</ul>
  </section>;
}

function Newsletter({ DS }) {
  const { Eyebrow, NewsletterForm } = DS;
  return <section id="newsletter" style={{ ...sec('var(--surface-highlight)', { padding: 'var(--section-y-s) var(--gutter)' }), ...twoCol(380), alignItems: 'end' }}>
    <div><Eyebrow tone="ink">Newsletter</Eyebrow><h2 style={{ margin: '12px 0 16px', fontFamily: 'var(--font-display)', fontWeight: 400, fontSize: 'var(--type-h2-compact)', lineHeight: 1.02, letterSpacing: '-.025em' }}>Theo dõi những gì sắp diễn ra tại Soul</h2>
      <p style={{ margin: 0, maxWidth: '54ch', fontSize: 15, lineHeight: 1.7 }}>Cà phê mới, thông tin mùa vụ, câu chuyện từ vùng nguyên liệu, kiến thức chuyên môn và các hoạt động mới.</p></div>
    <NewsletterForm />
  </section>;
}

window.HomeScreen = function HomeScreen() {
  const DS = window.SoulDS;
  const { SiteHeader, MegaMenu, SiteFooter, MobileMenu, Drawer, CartLine, Button, Toast, Lightbox } = DS;
  const [w, setW] = React.useState(window.innerWidth);
  const [lang, setLang] = React.useState('vi'), [mega, setMega] = React.useState(false), [mobile, setMobile] = React.useState(false);
  const [cart, setCart] = React.useState([]), [cartOpen, setCartOpen] = React.useState(false), [toast, setToast] = React.useState(''), [album, setAlbum] = React.useState(null);
  React.useEffect(() => { const r = () => setW(window.innerWidth); window.addEventListener('resize', r); const k = e => { if (e.key === 'Escape') { setAlbum(null); setCartOpen(false); setMega(false); } }; window.addEventListener('keydown', k); return () => { window.removeEventListener('resize', r); window.removeEventListener('keydown', k); }; }, []);
  const compact = w < 1180;
  const add = item => { setCart(c => { const i = c.findIndex(x => x.name === item.name); if (i >= 0) return c.map((x, j) => j === i ? { ...x, qty: x.qty + 1 } : x); return [...c, { ...item, qty: 1 }]; }); setToast(item.name + ' đã thêm vào giỏ'); clearTimeout(window.__soulT); window.__soulT = setTimeout(() => setToast(''), 3200); };
  const count = cart.reduce((a, c) => a + c.qty, 0);
  const megaEl = mega && !compact ? <MegaMenu columns={[{ title: 'Cà phê rang', items: DATA.roasted.map(r => ({ label: r[0], href: '#roasted' })) }, { title: 'Nhân xanh', items: [{ label: 'Fine Robusta' }, { label: 'Premium Robusta' }], footerLink: { label: 'Xem tất cả cà phê', href: '#featured' } }]} feature={{ img: IMG + '04-soulful/Soulful_vuong.png', eyebrow: 'Mùa vụ mới', title: 'Soulful Collection 2026', sub: 'Cay · Nồng · Thơm · Ngọt', cta: 'Khám phá Soulful 2026', href: '#soulful' }} /> : null;
  return <div style={{ minHeight: '100vh', background: 'var(--surface-page)', color: 'var(--text-primary)' }}>
    <SiteHeader assetBase="../../" nav={DATA.nav} lang={lang} onLang={setLang} cartCount={count} compact={compact} onMenu={() => setMobile(true)} onCart={() => setCartOpen(true)} onNavEnter={it => setMega(!!it.hasMenu)} onLeave={() => setMega(false)} mega={megaEl} />
    <main>
      <Hero DS={DS} /><Shop DS={DS} onAdd={add} /><Story DS={DS} openAlbum={setAlbum} /><Awards DS={DS} /><Soulful DS={DS} onAdd={add} /><Solutions DS={DS} /><Visit DS={DS} /><Newsletter DS={DS} />
    </main>
    <SiteFooter assetBase="../../" columns={DATA.footer.map(([t, l]) => ({ title: t, links: l.map(x => ({ label: x })) }))} />
    {cartOpen ? <Drawer title="Giỏ hàng" count={count} onClose={() => setCartOpen(false)} footer={<><div style={{ fontSize: 12, color: 'var(--text-secondary)' }}>Giá và phí giao hàng được tính ở bước thanh toán.</div><Button size="l" fullWidth style={{ fontWeight: 600 }}>Thanh toán</Button></>}>
      {cart.length === 0 ? <div style={{ padding: '48px 0', textAlign: 'center', fontFamily: 'var(--font-display)', fontSize: 22 }}>Giỏ hàng đang trống.</div> :
        cart.map(c => <CartLine key={c.name} {...c} onInc={() => setCart(cs => cs.map(x => x.name === c.name ? { ...x, qty: x.qty + 1 } : x))} onDec={() => setCart(cs => cs.map(x => x.name === c.name ? { ...x, qty: Math.max(1, x.qty - 1) } : x))} onRemove={() => setCart(cs => cs.filter(x => x.name !== c.name))} />)}
    </Drawer> : null}
    {toast ? <Toast message={toast} actionLabel="Xem giỏ" onAction={() => { setCartOpen(true); setToast(''); }} /> : null}
    {album !== null ? <Lightbox src={IMG + DATA.album[album]} label="Album · Vùng nguyên liệu" counter={pad(album + 1) + ' / 05'} onClose={() => setAlbum(null)} onPrev={() => setAlbum((album + 4) % 5)} onNext={() => setAlbum((album + 1) % 5)} /> : null}
    {mobile ? <MobileMenu assetBase="../../" nav={DATA.nav} groups={[{ title: 'Cà phê rang', items: DATA.roasted.map(r => ({ label: r[0], href: '#roasted' })) }, { title: 'Nhân xanh', items: [{ label: 'Fine Robusta' }, { label: 'Premium Robusta' }] }]} onClose={() => setMobile(false)} /> : null}
  </div>;
};
