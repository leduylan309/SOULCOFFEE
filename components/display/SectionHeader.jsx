import React from 'react';
import { Eyebrow } from './Eyebrow.jsx';
const SIZE = { h2: ['var(--type-h2)', 'var(--lh-h2)', '-.025em'], display: ['var(--type-display-l)', 'var(--lh-display-l)', '-.03em'], xl: ['var(--type-display-xl)', 'var(--lh-display-xl)', '-.03em'] };
export function SectionHeader({ eyebrow, title, body, action, tone = 'light', size = 'h2', rule = false, divider = false, id }) {
  const dark = tone === 'dark', [fs, lh, ls] = SIZE[size] || SIZE.h2;
  const bodies = Array.isArray(body) ? body : body ? [body] : [];
  return <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(min(100%, 380px), 1fr))', gap: '20px var(--block-gap)', alignItems: 'end',
      paddingBottom: divider ? 22 : 0, borderBottom: divider ? '1px solid var(--soul-ink)' : 0, marginBottom: 'var(--head-gap)' }}>
    <div>
      {eyebrow ? <Eyebrow tone={dark ? 'on-dark' : 'accent'} rule={rule}>{eyebrow}</Eyebrow> : null}
      <h2 id={id} style={{ margin: eyebrow ? '12px 0 0' : 0, fontFamily: 'var(--font-display)', fontWeight: 400, fontSize: fs, lineHeight: lh, letterSpacing: ls, textWrap: 'balance', color: dark ? 'var(--text-on-dark)' : 'var(--text-primary)' }}>{title}</h2>
    </div>
    {(bodies.length || action) ? <div style={{ display: 'flex', flexDirection: 'column', gap: 14, alignItems: 'start' }}>
      {bodies.map((b, i) => <p key={i} style={{ margin: 0, maxWidth: 'var(--measure-body)', fontSize: 'var(--type-body)', lineHeight: 'var(--lh-body)', color: dark ? 'var(--text-on-dark-secondary)' : 'var(--text-secondary)', textWrap: 'pretty' }}>{b}</p>)}
      {action || null}
    </div> : null}
  </div>;
}
