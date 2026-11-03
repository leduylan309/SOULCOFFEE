import React from 'react';
export function CertCard({ img, pdf, pdfKicker = 'CQI · Q Certified Robusta', pdfLabel = 'Xem PDF', year, score, rank, comp, onOpen }) {
  return <li style={{ listStyle: 'none', flex: '0 0 clamp(250px, 22vw, 310px)', scrollSnapAlign: 'start', display: 'flex', flexDirection: 'column', background: 'var(--surface-page)' }}>
    {img ? <button type="button" aria-label={rank} onClick={onOpen} style={{ position: 'relative', display: 'block', width: '100%', aspectRatio: '1/1', padding: 0, border: 0, background: 'var(--surface-media)', cursor: 'zoom-in' }}>
        <img src={img} alt={rank} loading="lazy" style={{ position: 'absolute', top: 18, left: 18, width: 'calc(100% - 36px)', height: 'calc(100% - 36px)', objectFit: 'contain', filter: 'var(--shadow-object)' }} /></button>
      : <a href={pdf} target="_blank" rel="noopener" style={{ aspectRatio: '1/1', display: 'flex', flexDirection: 'column', justifyContent: 'space-between', padding: 22, background: 'var(--surface-inverse)', color: 'var(--text-on-dark)' }}>
        <span style={{ fontSize: 10.5, letterSpacing: '.16em', textTransform: 'uppercase', color: 'var(--soul-yellow)' }}>{pdfKicker}</span>
        <span style={{ fontFamily: 'var(--font-display)', fontSize: 'clamp(52px,4.4vw,68px)', lineHeight: .9, letterSpacing: '-.04em', color: 'var(--soul-yellow)' }}>{score}</span>
        <span style={{ fontSize: 11.5, letterSpacing: '.12em', textTransform: 'uppercase' }}>{pdfLabel} ↗</span></a>}
    <div style={{ padding: '16px 18px 20px', display: 'flex', flexDirection: 'column', gap: 8, flex: 1 }}>
      <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'baseline', gap: 12 }}><span style={{ fontSize: 10.5, letterSpacing: '.16em', color: 'var(--text-accent)', fontWeight: 600 }}>{year}</span><span style={{ fontFamily: 'var(--font-display)', fontSize: 30, lineHeight: 1, letterSpacing: '-.02em' }}>{score}</span></div>
      <span style={{ fontFamily: 'var(--font-display)', fontSize: 21, lineHeight: 1.15, textWrap: 'balance' }}>{rank}</span>
      <span style={{ fontSize: 12.5, lineHeight: 1.5, color: 'var(--text-secondary)' }}>{comp}</span></div>
  </li>;
}
