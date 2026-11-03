import React from 'react';
export function StoreCard({ img, alt = '', name, href }) {
  const Tag = href ? 'a' : 'div';
  return <Tag href={href} style={{ display: 'flex', flexDirection: 'column', background: 'var(--surface-alt)', color: 'var(--soul-ink)' }}>
    <div style={{ aspectRatio: '4/5', overflow: 'hidden', background: 'var(--surface-media)' }}>{img ? <img src={img} alt={alt} loading="lazy" style={{ width: '100%', height: '100%', objectFit: 'cover' }} /> : null}</div>
    <div style={{ display: 'flex', alignItems: 'center', gap: 10, padding: '14px 14px 16px' }}><span aria-hidden="true" style={{ width: 8, height: 8, borderRadius: '50%', background: 'var(--soul-clay)', flex: 'none' }}></span><span style={{ fontFamily: 'var(--font-display)', fontSize: 'clamp(19px,1.6vw,22px)', lineHeight: 1.15 }}>{name}</span></div>
  </Tag>;
}
