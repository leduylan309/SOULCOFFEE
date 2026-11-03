import React from 'react';
export function ChipToggle({ pressed = false, onClick, children }) {
  return <button type="button" aria-pressed={pressed} onClick={onClick} style={{ height: 'var(--chip-h)', padding: '0 14px', border: '1px solid var(--soul-ink)', background: pressed ? 'var(--soul-yellow)' : 'transparent', color: 'var(--soul-ink)', fontSize: 13, fontWeight: 500, cursor: 'pointer', borderRadius: 0 }}>{children}</button>;
}
