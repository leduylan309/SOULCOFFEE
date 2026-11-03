import * as React from 'react';
/**
 * Sticky 66px header: logo lockup, uppercase nav with yellow underline hover, VI/EN, search, cart count.
 * @startingPoint section="Navigation" subtitle="Sticky header" viewport="1200x80"
 */
export interface SiteHeaderProps { nav?: {label: string;
  href: string;
  hasMenu?: boolean;
  active?: boolean}[];
  lang?: string;
  onLang?: (v: string) => void;
  cartCount?: number;
  cartLabel?: string;
  searchLabel?: string;
  onSearch?: () => void;
  onCart?: () => void;
  onNavEnter?: (item: any) => void;
  onMenu?: () => void;
  compact?: boolean;
  logoHref?: string;
  mega?: React.ReactNode;
  onLeave?: () => void;
  assetBase?: string; }
export declare function SiteHeader(props: SiteHeaderProps): JSX.Element;
