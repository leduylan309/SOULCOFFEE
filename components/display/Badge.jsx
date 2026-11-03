import React from 'react';
export function Badge({ tone = 'ink', children, style }) {
  const y = tone === 'yellow';
  return <span style={{ display: 'inline-block', padding: y ? '12px 16px' : '5px 9px', background: y ? 'var(--soul-yellow)' : 'var(--soul-ink)', color: y ? 'var(--soul-ink)' : 'var(--soul-paper)',
    fontFamily: 'var(--font-sans)', fontSize: y ? 11 : 'var(--type-badge)', letterSpacing: y ? '.14em' : 'var(--ls-badge)', textTransform: 'uppercase', fontWeight: 600, lineHeight: 1.3, ...style }}>{children}</span>;
}
