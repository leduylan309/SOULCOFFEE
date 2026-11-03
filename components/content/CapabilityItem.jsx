import React from 'react';
export function CapabilityItem({ n, label, desc }) {
  return <li style={{ listStyle: 'none', display: 'flex', flexDirection: 'column', gap: 8 }}>
    <span style={{ fontSize: 10.5, letterSpacing: '.16em', color: 'var(--text-accent)' }}>{n}</span>
    <span style={{ fontFamily: 'var(--font-display)', fontSize: 'var(--type-h3-l)', lineHeight: 1, letterSpacing: '-.02em' }}>{label}</span>
    <span style={{ fontSize: 13.5, lineHeight: 1.55, color: 'var(--text-secondary)', textWrap: 'pretty' }}>{desc}</span></li>;
}
