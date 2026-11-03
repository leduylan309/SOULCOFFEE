import React from 'react';
export function TextLink({ href, onClick, tone = 'light', arrow = '↗', size = 12, children }) {
  const [h, setH] = React.useState(false);
  const dark = tone === 'dark';
  const st = { display: 'inline-flex', gap: 6, alignItems: 'center', background: 'none', border: 0, padding: 0, cursor: 'pointer', fontFamily: 'var(--font-sans)', fontSize: size, letterSpacing: 'var(--ls-link)', textTransform: 'uppercase', fontWeight: 500,
    color: dark ? (h ? 'var(--soul-yellow)' : 'var(--soul-paper)') : 'var(--soul-ink)', textDecoration: 'underline', textUnderlineOffset: 6,
    textDecorationColor: dark ? 'var(--paper-a40)' : (h ? 'var(--soul-ink)' : 'var(--ink-a30)') };
  const Tag = href ? 'a' : 'button';
  return <Tag href={href} type={href ? undefined : 'button'} onClick={onClick} style={st} onMouseEnter={() => setH(true)} onMouseLeave={() => setH(false)}>{children}{arrow ? <span aria-hidden="true">{arrow}</span> : null}</Tag>;
}
