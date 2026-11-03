import React from 'react';
function FLink({ href, children }) {
  const [h, setH] = React.useState(false);
  return <a href={href} onMouseEnter={() => setH(true)} onMouseLeave={() => setH(false)} style={{ color: h ? 'var(--soul-yellow)' : 'var(--paper-a85)' }}>{children}</a>;
}
export function SiteFooter({ columns = [], tagline = 'Crafted by Vietnamese Soul. Buôn Ma Thuột, Việt Nam.', copyright = '© 2026 SOUL Fine Robusta', assetBase = '' }) {
  return <footer style={{ background: 'var(--surface-inverse)', color: 'var(--text-on-dark)', padding: 'clamp(48px,6vw,80px) var(--gutter) 32px' }}>
    <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(min(100%, 170px), 1fr))', gap: '36px 28px' }}>
      <div><img src={assetBase + 'assets/logo/soul-logo-full-yellow.svg'} alt="SOUL Fine Robusta" style={{ width: 120, height: 'auto' }} /></div>
      {columns.map((c, i) => <div key={i}><div style={{ fontSize: 10.5, letterSpacing: '.18em', textTransform: 'uppercase', color: 'var(--soul-yellow)', marginBottom: 14 }}>{c.title}</div>
        <ul style={{ listStyle: 'none', margin: 0, padding: 0, display: 'flex', flexDirection: 'column', gap: 9, fontSize: 13.5 }}>{c.links.map((l, j) => <li key={j}><FLink href={l.href || '#'}>{l.label}</FLink></li>)}</ul></div>)}
    </div>
    <div style={{ display: 'flex', flexWrap: 'wrap', justifyContent: 'space-between', gap: '12px 24px', marginTop: 'clamp(40px,5vw,64px)', paddingTop: 20, borderTop: '1px solid var(--line-on-dark)', fontSize: 11, letterSpacing: '.12em', textTransform: 'uppercase', color: 'var(--paper-a70)' }}>
      <span>{tagline}</span><span>{copyright}</span></div>
  </footer>;
}
