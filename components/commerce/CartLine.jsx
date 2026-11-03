import React from 'react';
import { QuantityStepper } from '../forms/QuantityStepper.jsx';
export function CartLine({ img, name, type, qty = 1, onInc, onDec, onRemove, removeLabel = 'Xoá' }) {
  return <div style={{ display: 'grid', gridTemplateColumns: '72px 1fr auto', gap: 14, padding: '16px 0', borderBottom: '1px solid var(--line-subtle)', alignItems: 'start' }}>
    {img ? <img src={img} alt="" style={{ width: 72, height: 72, objectFit: 'cover', background: 'var(--surface-alt)' }} /> : <div style={{ width: 72, height: 72, background: 'var(--surface-alt)' }}></div>}
    <div style={{ display: 'flex', flexDirection: 'column', gap: 4, minWidth: 0 }}>
      <div style={{ fontFamily: 'var(--font-display)', fontSize: 19, lineHeight: 1.1 }}>{name}</div>
      <div style={{ fontSize: 12, color: 'var(--text-secondary)' }}>{type}</div>
      <div style={{ marginTop: 8 }}><QuantityStepper value={qty} onInc={onInc} onDec={onDec} /></div></div>
    <button type="button" onClick={onRemove} style={{ background: 'none', border: 0, fontSize: 11, letterSpacing: '.1em', textTransform: 'uppercase', color: 'var(--text-secondary)', cursor: 'pointer', textDecoration: 'underline', textUnderlineOffset: 4 }}>{removeLabel}</button>
  </div>;
}
