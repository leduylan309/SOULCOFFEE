import React from 'react';
import { IconButton } from '../actions/IconButton.jsx';
export function MobileMenu({ nav = [], groups = [], onClose, closeLabel = 'Đóng', inline = false, assetBase = '' }) {
  const row = '1px solid var(--line-default)';
  return <div role="dialog" aria-modal="true" style={{ position: inline ? 'relative' : 'fixed', inset: inline ? undefined : 0, height: inline ? '100%' : undefined, zIndex: 100, background: 'var(--surface-page)', display: 'flex', flexDirection: 'column', overflowY: 'auto', color: 'var(--soul-ink)' }}>
    <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', height: 66, padding: '0 16px', borderBottom: row, flex: 'none' }}>
      <img src={assetBase + 'assets/logo/soul-wordmark-ink.svg'} alt="SOUL" style={{ height: 15 }} /><IconButton icon="close" label={closeLabel} onClick={onClose} /></div>
    <nav style={{ padding: '8px 16px 32px', display: 'flex', flexDirection: 'column' }}>
      {nav.map((n, i) => <a key={i} href={n.href} onClick={onClose} style={{ display: 'flex', alignItems: 'center', minHeight: 60, borderBottom: row, fontFamily: 'var(--font-display)', fontSize: 28 }}>{n.label}</a>)}
      {groups.length ? <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 16, padding: '20px 0', borderBottom: row }}>{groups.map((g, i) => <div key={i}>
        <div style={{ fontSize: 10.5, letterSpacing: '.18em', textTransform: 'uppercase', color: 'var(--text-muted)', marginBottom: 10 }}>{g.title}</div>
        <ul style={{ listStyle: 'none', margin: 0, padding: 0, display: 'flex', flexDirection: 'column', gap: 12, fontSize: 15 }}>{g.items.map((it, j) => <li key={j}><a href={it.href || '#'} onClick={onClose}>{it.label}</a></li>)}</ul></div>)}</div> : null}
    </nav></div>;
}
