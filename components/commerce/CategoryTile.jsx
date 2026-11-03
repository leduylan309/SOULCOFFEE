import React from 'react';
export function CategoryTile({ img, alt = '', name, href = '#', ratio = '4/5' }) {
  const [h, setH] = React.useState(false);
  return <a href={href} onMouseEnter={() => setH(true)} onMouseLeave={() => setH(false)} style={{ display: 'flex', flexDirection: 'column', background: h ? 'var(--soul-yellow)' : 'var(--surface-alt)', color: 'var(--soul-ink)' }}>
    <span style={{ display: 'block', aspectRatio: ratio, overflow: 'hidden', background: 'var(--surface-media)' }}>{img ? <img src={img} alt={alt} loading="lazy" style={{ width: '100%', height: '100%', objectFit: 'cover' }} /> : null}</span>
    <span style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', gap: 8, padding: '14px 14px 16px' }}><span style={{ fontFamily: 'var(--font-display)', fontSize: 'var(--type-tile)', lineHeight: 1.1 }}>{name}</span><span aria-hidden="true" style={{ fontSize: 12 }}>↗</span></span>
  </a>;
}
