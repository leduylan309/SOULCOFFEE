import React from 'react';
export function Toast({ message, actionLabel, onAction, inline = false }) {
  return <div role="status" style={{ position: inline ? 'relative' : 'fixed', left: inline ? undefined : '50%', bottom: inline ? undefined : 22, transform: inline ? undefined : 'translateX(-50%)', zIndex: 80, background: 'var(--soul-ink)', color: 'var(--soul-paper)', padding: '12px 18px', fontSize: 12.5, letterSpacing: '.04em', display: 'inline-flex', gap: 14, alignItems: 'center', boxShadow: 'var(--shadow-toast)', maxWidth: 'calc(100vw - 32px)' }}>
    <span>{message}</span>{actionLabel ? <button type="button" onClick={onAction} style={{ background: 'none', border: 0, color: 'var(--soul-yellow)', fontSize: 12, letterSpacing: '.1em', textTransform: 'uppercase', cursor: 'pointer', fontWeight: 600, whiteSpace: 'nowrap' }}>{actionLabel}</button> : null}</div>;
}
