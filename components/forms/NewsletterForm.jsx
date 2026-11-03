import React from 'react';
export function NewsletterForm({ placeholder = 'Email của bạn', submitLabel = 'Đăng ký', thanks = 'Cảm ơn bạn đã đăng ký.', onSubmit }) {
  const [v, setV] = React.useState(''), [sent, setSent] = React.useState(false);
  if (sent) return <div role="status" style={{ fontFamily: 'var(--font-display)', fontSize: 26, lineHeight: 1.25, paddingBottom: 8 }}>{thanks}</div>;
  const submit = (e) => { e.preventDefault(); if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.trim())) { setSent(true); onSubmit && onSubmit(v); } };
  return <form onSubmit={submit} style={{ display: 'flex', borderBottom: 'var(--border-emphasis)' }}>
    <input type="email" required aria-label={placeholder} value={v} onChange={e => setV(e.target.value)} placeholder={placeholder} style={{ flex: 1, minWidth: 0, height: 56, background: 'none', border: 0, fontSize: 17, color: 'var(--soul-ink)', outline: 'none' }} />
    <button type="submit" style={{ height: 56, padding: '0 4px 0 18px', background: 'none', border: 0, fontSize: 12.5, letterSpacing: '.14em', textTransform: 'uppercase', fontWeight: 600, cursor: 'pointer', color: 'var(--soul-ink)' }}>{submitLabel} ↗</button>
  </form>;
}
