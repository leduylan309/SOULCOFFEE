import React from 'react';
import { TextLink } from '../actions/TextLink.jsx';
export function CollectionCard({ index, title, img, alt = '', href = '#', tone = 'dark', linkLabel, items }) {
  const dark = tone === 'dark';
  return <article style={{ display: 'flex', flexDirection: 'column', background: dark ? 'var(--surface-inverse)' : 'var(--surface-alt)', color: dark ? 'var(--text-on-dark)' : 'var(--text-primary)' }}>
    <a href={href} style={{ display: 'block', aspectRatio: '16/10', overflow: 'hidden', background: 'var(--surface-media)' }}>{img ? <img src={img} alt={alt} loading="lazy" style={{ width: '100%', height: '100%', objectFit: 'cover' }} /> : null}</a>
    <div style={{ padding: '20px 22px 22px', display: 'flex', flexWrap: 'wrap', flexDirection: items ? 'column' : 'row', justifyContent: 'space-between', alignItems: items ? 'stretch' : 'end', gap: 14 }}>
      <div><div style={{ fontSize: 10.5, letterSpacing: '.18em', textTransform: 'uppercase', color: dark ? 'var(--soul-yellow)' : 'var(--text-accent)' }}>{index}</div>
        <h3 style={{ margin: '6px 0 0', fontFamily: 'var(--font-display)', fontWeight: 400, fontSize: 'var(--type-h3-xl)', lineHeight: 1 }}>{title}</h3></div>
      {items ? <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '0 18px' }}>{items.map((it, i) => <a key={i} href={it.href || href} style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', padding: '10px 0', borderTop: '1px solid var(--line-strong)', fontFamily: 'var(--font-display)', fontSize: 21, lineHeight: 1.15 }}><span>{it.label}</span><span aria-hidden="true" style={{ fontFamily: 'var(--font-sans)', fontSize: 12 }}>↗</span></a>)}</div>
        : linkLabel ? <TextLink href={href} tone={dark ? 'dark' : 'light'} arrow="↓">{linkLabel}</TextLink> : null}
    </div>
  </article>;
}
