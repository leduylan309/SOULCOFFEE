import React from 'react';
import { LangToggle } from '../forms/LangToggle.jsx';
import { IconButton } from '../actions/IconButton.jsx';
function NavLink({ item, onEnter }) {
  const [h, setH] = React.useState(false);
  return <a href={item.href} onMouseEnter={() => { setH(true); onEnter && onEnter(item); }} onMouseLeave={() => setH(false)} onFocus={() => onEnter && onEnter(item)}
    style={{ display: 'flex', alignItems: 'center', gap: 6, height: 66, padding: '0 13px', borderBottom: '2px solid ' + (h || item.active ? 'var(--soul-yellow)' : 'transparent'), whiteSpace: 'nowrap' }}>{item.label}{item.hasMenu ? <span style={{ fontSize: 9, opacity: .55 }}>▾</span> : null}</a>;
}
export function SiteHeader({ nav = [], lang = 'vi', onLang, cartCount = 0, cartLabel = 'Giỏ hàng', searchLabel = 'Tìm kiếm', onSearch, onCart, onNavEnter, onMenu, compact = false, logoHref = '#', mega, onLeave, assetBase = '' }) {
  return <header onMouseLeave={onLeave} style={{ position: 'sticky', top: 0, zIndex: 60, background: 'var(--surface-page)', borderBottom: '1px solid var(--line-default)', color: 'var(--soul-ink)' }}>
    <nav aria-label="Main" style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', gap: 20, height: 'var(--header-h)', padding: '0 var(--gutter)' }}>
      <div style={{ display: 'flex', alignItems: 'center', gap: 'clamp(20px,2.6vw,40px)' }}>
        {compact ? <div style={{ marginLeft: -10 }}><IconButton icon="menu" label="Menu" onClick={onMenu} /></div> : null}
        <a href={logoHref} aria-label="SOUL" style={{ display: 'flex', alignItems: 'center', gap: 12 }}>
          <img src={assetBase + 'assets/logo/soul-elephant-ink.svg'} alt="" width="30" height="30" style={{ width: 30, height: 30 }} />
          <img src={assetBase + 'assets/logo/soul-wordmark-ink.svg'} alt="SOUL" style={{ height: 15, width: 'auto' }} /></a>
        {!compact ? <div style={{ display: 'flex', alignItems: 'center', fontSize: 12, letterSpacing: '.08em', fontWeight: 500, textTransform: 'uppercase' }}>{nav.map((n, i) => <NavLink key={i} item={n} onEnter={onNavEnter} />)}</div> : null}
      </div>
      <div style={{ display: 'flex', alignItems: 'center', gap: 4, fontSize: 12, letterSpacing: '.08em', fontWeight: 500 }}>
        <div style={{ marginRight: 6 }}><LangToggle value={lang} onChange={onLang} /></div>
        <IconButton icon="search" label={searchLabel} onClick={onSearch} />
        <button type="button" aria-label={cartLabel} onClick={onCart} style={{ height: 44, padding: '0 0 0 8px', background: 'none', border: 0, cursor: 'pointer', display: 'flex', alignItems: 'center', gap: 8, fontSize: 12, letterSpacing: '.08em', fontWeight: 500, textTransform: 'uppercase', color: 'inherit' }}>
          {!compact ? <span>{cartLabel}</span> : null}
          <span style={{ minWidth: 22, height: 22, padding: '0 6px', display: 'grid', placeItems: 'center', background: 'var(--soul-ink)', color: 'var(--soul-paper)', fontSize: 11, borderRadius: 'var(--radius-pill)' }}>{cartCount}</span></button>
      </div>
    </nav>
    {mega || null}
  </header>;
}
