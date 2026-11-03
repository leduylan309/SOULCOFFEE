import React from 'react';
export function LangToggle({ value = 'vi', onChange, options = ['vi', 'en'] }) {
  return <div role="group" aria-label="Language" style={{ display: 'flex', border: '1px solid var(--line-control)', height: 32 }}>
    {options.map(o => { const on = o === value; return <button key={o} type="button" aria-pressed={on} onClick={() => onChange && onChange(o)}
      style={{ width: 38, height: 30, border: 0, background: on ? 'var(--soul-ink)' : 'transparent', color: on ? 'var(--soul-paper)' : 'var(--soul-ink)', fontSize: 11, letterSpacing: '.1em', fontWeight: 600, cursor: 'pointer', textTransform: 'uppercase' }}>{o}</button>; })}
  </div>;
}
