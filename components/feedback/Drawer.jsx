import React from 'react';
import { IconButton } from '../actions/IconButton.jsx';
export function Drawer({ title, count, onClose, children, footer, inline = false, width = 'min(440px, 100%)' }) {
  const px = 'clamp(16px,2vw,28px)';
  return <>
    {!inline ? <div onClick={onClose} style={{ position: 'fixed', inset: 0, zIndex: 90, background: 'var(--overlay-scrim)' }}></div> : null}
    <aside role="dialog" aria-modal={!inline} aria-label={title} style={{ position: inline ? 'relative' : 'fixed', zIndex: 95, top: 0, right: 0, bottom: 0, height: inline ? '100%' : undefined, width, background: 'var(--surface-page)', color: 'var(--soul-ink)', display: 'flex', flexDirection: 'column', boxShadow: 'var(--shadow-drawer)' }}>
      <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', padding: '18px ' + px, borderBottom: '1px solid var(--line-subtle)' }}>
        <div style={{ fontFamily: 'var(--font-display)', fontSize: 26 }}>{title} {count !== undefined ? <span style={{ fontSize: 14, fontFamily: 'var(--font-sans)', color: 'var(--text-muted)' }}>({count})</span> : null}</div>
        <IconButton icon="close" label="Close" onClick={onClose} /></div>
      <div style={{ flex: 1, overflowY: 'auto', padding: '8px ' + px }}>{children}</div>
      {footer ? <div style={{ padding: '18px ' + px + ' 24px', borderTop: '1px solid var(--line-subtle)', display: 'flex', flexDirection: 'column', gap: 12 }}>{footer}</div> : null}
    </aside></>;
}
