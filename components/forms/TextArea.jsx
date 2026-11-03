import React from 'react';
const LABEL = { display: 'flex', flexDirection: 'column', gap: 6, fontSize: 11, letterSpacing: '.14em', textTransform: 'uppercase', color: 'var(--text-secondary)' };
export function TextArea({ label, required = false, name, rows = 4, value, onChange, style }) {
  return <label style={{ ...LABEL, ...style }}><span>{label}{required ? <span style={{ color: 'var(--text-accent)' }}> *</span> : null}</span>
    <textarea name={name} rows={rows} value={value} onChange={onChange} style={{ padding: '10px 0', border: 0, borderBottom: 'var(--border-field)', background: 'transparent', fontSize: 15, lineHeight: 1.6, letterSpacing: 0, textTransform: 'none', color: 'var(--text-primary)', outline: 'none', resize: 'vertical', borderRadius: 0 }}></textarea></label>;
}
