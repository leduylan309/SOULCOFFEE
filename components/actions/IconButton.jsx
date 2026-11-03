import React from 'react';
const GLYPH = { 'arrow-left': '←', 'arrow-right': '→', close: '×', plus: '+', minus: '−' };
export function IconButton({ icon = 'arrow-right', label, variant = 'plain', onClick, size }) {
  const [h, setH] = React.useState(false);
  const V = {
    plain: { background: 'none', border: 0, color: 'inherit', width: size || 44, height: size || 44 },
    round: { background: h ? 'var(--soul-ink)' : 'var(--soul-paper)', color: h ? 'var(--soul-paper)' : 'var(--soul-ink)', border: 0, borderRadius: '50%', width: size || 44, height: size || 44 },
    'outline-dark': { background: 'none', border: '1px solid var(--paper-a40)', color: 'var(--soul-paper)', width: size || 48, height: size || 48 }
  };
  const content = icon === 'search'
    ? <svg width="17" height="17" viewBox="0 0 16 16" fill="none" stroke="currentColor" strokeWidth="1.5" aria-hidden="true"><circle cx="7" cy="7" r="5"></circle><path d="M11 11l4 4"></path></svg>
    : icon === 'menu' ? <span style={{ display: 'block', width: 22, height: 1.5, background: 'currentColor', boxShadow: '0 -7px 0 currentColor, 0 7px 0 currentColor' }}></span>
    : <span aria-hidden="true">{GLYPH[icon] || icon}</span>;
  return <button type="button" aria-label={label} onClick={onClick} onMouseEnter={() => setH(true)} onMouseLeave={() => setH(false)}
    style={{ display: 'grid', placeItems: 'center', padding: 0, cursor: 'pointer', fontSize: icon === 'close' ? 24 : 16, flex: 'none', ...V[variant] }}>{content}</button>;
}
