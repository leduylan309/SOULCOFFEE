import React from 'react';
import { Button } from '../actions/Button.jsx';
export function ProductCard({ img, alt = '', badge, type, name, notes, meta, addLabel = 'Thêm vào giỏ', onAdd }) {
  return <article style={{ display: 'flex', flexDirection: 'column', background: 'var(--surface-alt)', height: '100%' }}>
    <div style={{ position: 'relative', aspectRatio: '1/1', overflow: 'hidden', background: 'var(--surface-packshot)' }}>
      {img ? <img src={img} alt={alt} loading="lazy" style={{ width: '100%', height: '100%', objectFit: 'cover' }} /> : null}
      {badge ? <span style={{ position: 'absolute', left: 12, top: 12, padding: '5px 9px', background: 'var(--soul-ink)', color: 'var(--soul-paper)', fontSize: 10, letterSpacing: '.16em', textTransform: 'uppercase', fontWeight: 600 }}>{badge}</span> : null}
    </div>
    <div style={{ padding: '16px 16px 18px', display: 'flex', flexDirection: 'column', gap: 8, flex: 1 }}>
      {type ? <div style={{ fontSize: 10.5, letterSpacing: '.14em', textTransform: 'uppercase', color: 'var(--text-muted)' }}>{type}</div> : null}
      <h3 style={{ margin: 0, fontFamily: 'var(--font-display)', fontWeight: 400, fontSize: 23, lineHeight: 1.12 }}>{name}</h3>
      {notes ? <div style={{ fontFamily: 'var(--font-display)', fontStyle: 'italic', fontSize: 15.5, lineHeight: 1.45, color: 'var(--text-secondary)' }}>{notes}</div> : null}
      {meta ? <div style={{ fontSize: 12, lineHeight: 1.55, color: 'var(--text-secondary)' }}>{meta}</div> : null}
      <div style={{ marginTop: 'auto', paddingTop: 4 }}><Button variant="outline" size="xs" fullWidth onClick={onAdd} style={{ height: 46, fontSize: 12 }}>{addLabel}</Button></div>
    </div>
  </article>;
}
