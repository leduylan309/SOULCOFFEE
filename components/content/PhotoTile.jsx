import React from 'react';
export function PhotoTile({ img, alt = '', ratio = '4/5', tag, position = 'center', onClick, style }) {
  return <button type="button" aria-label={alt} onClick={onClick} style={{ position: 'relative', padding: 0, border: 0, background: 'var(--soul-ink-deep)', cursor: 'zoom-in', aspectRatio: ratio, overflow: 'hidden', display: 'block', width: '100%', ...style }}>
    <img src={img} alt={alt} loading="lazy" style={{ width: '100%', height: '100%', objectFit: 'cover', objectPosition: position }} />
    {tag ? <span style={{ position: 'absolute', left: 0, bottom: 0, padding: '12px 16px', background: 'var(--soul-yellow)', color: 'var(--soul-ink)', fontSize: 11, letterSpacing: '.14em', textTransform: 'uppercase', fontWeight: 600, textAlign: 'left' }}>{tag}</span> : null}
  </button>;
}
