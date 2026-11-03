import React from 'react';
const V = {
  primary: [{ background: 'var(--action-primary-bg)', color: 'var(--action-primary-fg)', border: '1px solid var(--soul-ink)' }, { background: 'var(--soul-yellow)', color: 'var(--soul-ink)', borderColor: 'var(--soul-yellow)' }],
  accent: [{ background: 'var(--soul-yellow)', color: 'var(--soul-ink)', border: '1px solid var(--soul-yellow)', fontWeight: 600 }, { background: 'var(--soul-paper)', borderColor: 'var(--soul-paper)' }],
  outline: [{ background: 'transparent', color: 'var(--soul-ink)', border: '1px solid var(--soul-ink)' }, { background: 'var(--soul-ink)', color: 'var(--soul-paper)' }],
  'outline-dark': [{ background: 'transparent', color: 'var(--soul-paper)', border: '1px solid var(--paper-a50)' }, { background: 'var(--soul-paper)', color: 'var(--soul-ink)', borderColor: 'var(--soul-paper)' }],
  'outline-dark-accent': [{ background: 'transparent', color: 'var(--soul-paper)', border: '1px solid var(--paper-a50)' }, { background: 'var(--soul-yellow)', color: 'var(--soul-ink)', borderColor: 'var(--soul-yellow)' }]
};
const S = { l: [52, 30], m: [50, 26], s: [48, 22], xs: [44, 18] };
export function Button({ variant = 'primary', size = 'm', arrow = false, href, onClick, type = 'button', fullWidth = false, disabled = false, children, style }) {
  const [h, setH] = React.useState(false);
  const [base, hov] = V[variant] || V.primary, [ht, px] = S[size] || S.m;
  const st = { display: fullWidth ? 'flex' : 'inline-flex', width: fullWidth ? '100%' : undefined, alignItems: 'center', justifyContent: 'center', gap: 10, height: ht, padding: '0 ' + px + 'px',
    fontFamily: 'var(--font-sans)', fontSize: size === 'xs' ? 11.5 : size === 's' ? 12 : 'var(--type-button)', letterSpacing: 'var(--ls-button)', textTransform: 'uppercase', fontWeight: 500,
    cursor: disabled ? 'not-allowed' : 'pointer', opacity: disabled ? .45 : 1, borderRadius: 0, textDecoration: 'none', ...base, ...(h && !disabled ? hov : {}), ...style };
  const ev = { onMouseEnter: () => setH(true), onMouseLeave: () => setH(false), style: st };
  const kids = <>{children}{arrow ? <span aria-hidden="true">↗</span> : null}</>;
  return href ? <a href={href} onClick={onClick} {...ev}>{kids}</a> : <button type={type} onClick={onClick} disabled={disabled} {...ev}>{kids}</button>;
}
