import React from 'react';
export function QuantityStepper({ value = 1, onDec, onInc }) {
  const b = { width: 36, height: 36, background: 'none', border: 0, cursor: 'pointer', fontSize: 16, color: 'var(--soul-ink)' };
  return <div style={{ display: 'inline-flex', alignItems: 'center', border: '1px solid var(--line-control)', width: 'max-content' }}>
    <button type="button" aria-label="Decrease" onClick={onDec} style={b}>−</button>
    <span style={{ minWidth: 24, textAlign: 'center', fontSize: 13, fontWeight: 500 }}>{value}</span>
    <button type="button" aria-label="Increase" onClick={onInc} style={b}>+</button></div>;
}
