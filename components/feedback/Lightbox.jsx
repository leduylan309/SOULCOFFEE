import React from 'react';
import { IconButton } from '../actions/IconButton.jsx';
export function Lightbox({ src, alt = '', label, counter, caption, onPrev, onNext, onClose, inline = false }) {
  return <div role="dialog" aria-modal="true" aria-label={label} style={{ position: inline ? 'relative' : 'fixed', inset: inline ? undefined : 0, height: inline ? '100%' : undefined, zIndex: 110, background: 'var(--overlay-lightbox)', color: 'var(--soul-paper)', display: 'flex', flexDirection: 'column' }}>
    <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', height: 64, padding: '0 clamp(12px,3vw,32px)', fontSize: 11, letterSpacing: '.16em', textTransform: 'uppercase', flex: 'none' }}>
      <span>{label}{counter ? ' · ' + counter : ''}</span><IconButton icon="close" label="Close" onClick={onClose} /></div>
    <div style={{ flex: 1, minHeight: 0, display: 'grid', gridTemplateColumns: '56px 1fr 56px', alignItems: 'center', gap: 8, padding: '0 clamp(8px,2vw,24px) 24px' }}>
      <IconButton icon="arrow-left" label="Previous" variant="outline-dark" onClick={onPrev} />
      <img src={src} alt={alt} style={{ width: '100%', height: '100%', minHeight: 0, objectFit: 'contain' }} />
      <IconButton icon="arrow-right" label="Next" variant="outline-dark" onClick={onNext} /></div>
    {caption ? <div style={{ padding: '0 16px 22px', textAlign: 'center', fontSize: 13, letterSpacing: '.04em', color: 'var(--paper-a85)' }}>{caption}</div> : null}
  </div>;
}
