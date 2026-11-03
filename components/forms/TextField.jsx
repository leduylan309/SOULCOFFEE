import React from 'react';
const LABEL = { display: 'flex', flexDirection: 'column', gap: 6, fontSize: 11, letterSpacing: '.14em', textTransform: 'uppercase', color: 'var(--text-secondary)' };
const FIELD = { height: 'var(--field-h)', padding: 0, border: 0, borderBottom: 'var(--border-field)', background: 'transparent', fontSize: 15, letterSpacing: 0, textTransform: 'none', color: 'var(--text-primary)', outline: 'none', borderRadius: 0 };
export function TextField({ label, required = false, type = 'text', name, value, onChange, autoComplete, style }) {
  return <label style={{ ...LABEL, ...style }}><span>{label}{required ? <span style={{ color: 'var(--text-accent)' }}> *</span> : null}</span>
    <input type={type} name={name} value={value} onChange={onChange} autoComplete={autoComplete} style={FIELD} /></label>;
}
