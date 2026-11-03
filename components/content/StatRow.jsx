import React from 'react';
export function StatRow({ num, unit, rank, comp, ctaLabel, onCta }) {
  const [h, setH] = React.useState(false);
  return <li style={{ listStyle: 'none', display: 'grid', gridTemplateColumns: 'minmax(0,1fr) auto', gap: '8px 16px', alignItems: 'end', padding: '18px 0', color: 'var(--text-on-dark)' }}>
    <div style={{ display: 'flex', alignItems: 'baseline', gap: 10 }}><span style={{ fontFamily: 'var(--font-display)', fontSize: 'var(--type-numeral)', lineHeight: .9, letterSpacing: '-.035em', color: 'var(--soul-yellow)' }}>{num}</span><span style={{ fontSize: 12, letterSpacing: '.12em', textTransform: 'uppercase', color: 'var(--soul-yellow)' }}>{unit}</span></div>
    {ctaLabel ? <button type="button" onClick={onCta} onMouseEnter={() => setH(true)} onMouseLeave={() => setH(false)} style={{ height: 36, padding: 0, border: 0, background: 'transparent', color: h ? 'var(--soul-yellow)' : 'var(--soul-paper)', fontSize: 10.5, letterSpacing: '.12em', textTransform: 'uppercase', cursor: 'pointer', whiteSpace: 'nowrap', textDecoration: 'underline', textUnderlineOffset: 5, textDecorationColor: 'var(--paper-a40)' }}>{ctaLabel} ↗</button> : <span></span>}
    <div style={{ gridColumn: '1 / -1', display: 'flex', flexWrap: 'wrap', gap: '2px 10px', alignItems: 'baseline' }}><span style={{ fontFamily: 'var(--font-display)', fontSize: 21, lineHeight: 1.2 }}>{rank}</span>{comp ? <span style={{ fontSize: 12.5, lineHeight: 1.5, color: 'var(--paper-a75)' }}>{comp}</span> : null}</div>
  </li>;
}
