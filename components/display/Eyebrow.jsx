import React from 'react';
const TONE = { accent: 'var(--text-accent)', muted: 'var(--text-muted)', 'on-dark': 'var(--text-on-dark-accent)', ink: 'var(--text-primary)' };
export function Eyebrow({ tone = 'accent', rule = false, children, style }) {
  const ruleC = tone === 'on-dark' ? 'var(--soul-yellow)' : 'var(--soul-clay)';
  return <div style={{ display: 'flex', alignItems: 'center', gap: 14, fontFamily: 'var(--font-sans)', fontSize: 'var(--type-eyebrow)', letterSpacing: 'var(--ls-eyebrow)', textTransform: 'uppercase', fontWeight: tone === 'ink' ? 600 : 400, color: TONE[tone] || TONE.accent, ...style }}>
    {rule ? <span style={{ display: 'inline-block', width: 'var(--eyebrow-rule)', height: 2, background: ruleC, flex: 'none' }}></span> : null}<span>{children}</span></div>;
}
