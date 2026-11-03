import React from 'react';
import { Button } from '../actions/Button.jsx';
export function SoulfulCard({ img, alt = '', word, method, process, addLabel = 'Thêm vào giỏ', onAdd }) {
  return <article style={{ display: 'flex', flexDirection: 'column', background: 'var(--surface-inverse-raised)', color: 'var(--text-on-dark)', height: '100%' }}>
    {img ? <img src={img} alt={alt} loading="lazy" style={{ width: '100%', aspectRatio: '1/1', objectFit: 'cover' }} /> : <div style={{ aspectRatio: '1/1', background: 'var(--soul-ink)' }}></div>}
    <div style={{ padding: '18px 18px 20px', display: 'flex', flexDirection: 'column', gap: 10, flex: 1 }}>
      <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'baseline', gap: 12 }}>
        <h3 style={{ margin: 0, fontFamily: 'var(--font-display)', fontWeight: 400, fontSize: 40, lineHeight: 1, letterSpacing: '-.02em' }}>{word}</h3>
        <span style={{ fontSize: 10.5, letterSpacing: '.14em', textTransform: 'uppercase', color: 'var(--soul-yellow)', textAlign: 'right' }}>{method}</span></div>
      <div style={{ fontSize: 12.5, lineHeight: 1.5, color: 'var(--paper-a75)' }}>{process}</div>
      <div style={{ marginTop: 'auto' }}><Button variant="outline-dark-accent" size="xs" fullWidth onClick={onAdd}>{addLabel}</Button></div>
    </div>
  </article>;
}
