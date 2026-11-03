import React from 'react';
export function ServiceRow({ n, title, body }) {
  return <li style={{ listStyle: 'none', display: 'grid', gridTemplateColumns: '44px 1fr', gap: 12, padding: '20px 0 22px', borderBottom: '1px solid var(--ink-a18)' }}>
    <span style={{ fontSize: 11, letterSpacing: '.16em', color: 'var(--text-accent)', paddingTop: 6 }}>{n}</span>
    <div><h3 style={{ margin: '0 0 6px', fontFamily: 'var(--font-display)', fontWeight: 400, fontSize: 'var(--type-h3)', lineHeight: 1.1 }}>{title}</h3>
      <p style={{ margin: 0, maxWidth: '48ch', fontSize: 14, lineHeight: 1.6, color: 'var(--text-secondary)' }}>{body}</p></div></li>;
}
