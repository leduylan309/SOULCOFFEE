import React from 'react';
function MLink({ href, children, serif = true }) {
  const [h, setH] = React.useState(false);
  return <a href={href} onMouseEnter={() => setH(true)} onMouseLeave={() => setH(false)} style={{ color: h ? 'var(--soul-clay)' : 'inherit', ...(serif ? {} : { fontFamily: 'var(--font-sans)', fontSize: 12, letterSpacing: '.12em', textTransform: 'uppercase' }) }}>{children}</a>;
}
export function MegaMenu({ columns = [], feature, inline = false }) {
  const head = { fontSize: 10.5, letterSpacing: '.18em', textTransform: 'uppercase', color: 'var(--text-muted)', paddingBottom: 14, borderBottom: '1px solid var(--line-default)', marginBottom: 14 };
  return <div role="region" style={{ position: inline ? 'relative' : 'absolute', left: 0, right: 0, top: inline ? undefined : 'var(--header-h)', background: 'var(--surface-page)', borderBottom: '1px solid var(--line-default)', boxShadow: 'var(--shadow-mega)', color: 'var(--soul-ink)' }}>
    <div style={{ display: 'grid', gridTemplateColumns: 'repeat(' + columns.length + ', 1fr)' + (feature ? ' 1.4fr' : ''), gap: 'clamp(24px,3vw,56px)', padding: '36px var(--gutter) 44px', maxWidth: 'var(--container-max)', margin: '0 auto' }}>
      {columns.map((c, i) => <div key={i}><div style={head}>{c.title}</div>
        <ul style={{ listStyle: 'none', margin: 0, padding: 0, display: 'flex', flexDirection: 'column', gap: 10, fontFamily: 'var(--font-display)', fontSize: 22, lineHeight: 1.2 }}>
          {c.items.map((it, j) => <li key={j}><MLink href={it.href || '#'}>{it.label}</MLink></li>)}
          {c.footerLink ? <li style={{ marginTop: 10, paddingTop: 14, borderTop: '1px solid var(--line-default)' }}><MLink serif={false} href={c.footerLink.href || '#'}>{c.footerLink.label} ↗</MLink></li> : null}
        </ul></div>)}
      {feature ? <a href={feature.href || '#'} style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 18, alignItems: 'end', background: 'var(--surface-inverse)', color: 'var(--text-on-dark)', padding: 18 }}>
        <img src={feature.img} alt={feature.title} style={{ width: '100%', aspectRatio: '1/1', objectFit: 'cover' }} />
        <div><div style={{ fontSize: 10.5, letterSpacing: '.18em', textTransform: 'uppercase', color: 'var(--soul-yellow)' }}>{feature.eyebrow}</div>
          <div style={{ fontFamily: 'var(--font-display)', fontSize: 24, lineHeight: 1.12, margin: '10px 0 8px' }}>{feature.title}</div>
          <div style={{ fontSize: 12, color: 'var(--paper-a75)' }}>{feature.sub}</div>
          <div style={{ fontSize: 12, marginTop: 14, letterSpacing: '.1em', textTransform: 'uppercase' }}>{feature.cta} ↗</div></div></a> : null}
    </div></div>;
}
