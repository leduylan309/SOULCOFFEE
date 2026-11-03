import React from 'react';
export function LabelRule({ children, count, strong = false, actions, id }) {
  if (strong) return <div id={id} style={{ paddingTop: 'clamp(28px,3vw,40px)', borderTop: '1px solid var(--line-strong)', display: 'flex', alignItems: 'center', justifyContent: 'space-between', gap: 14, fontSize: 11, letterSpacing: '.18em', textTransform: 'uppercase', fontWeight: 600 }}>
    <span style={{ display: 'flex', gap: 10 }}><span>{children}</span>{count ? <span style={{ color: 'var(--text-accent)' }}>{count}</span> : null}</span>{actions || null}</div>;
  return <div id={id} style={{ display: 'flex', alignItems: 'center', gap: 14, fontSize: 11, letterSpacing: '.18em', textTransform: 'uppercase', color: 'var(--text-muted)' }}>
    <span>{children}</span><span style={{ flex: 1, height: 1, background: 'var(--ink-a18)' }}></span></div>;
}
