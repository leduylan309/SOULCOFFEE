import * as React from 'react';
/**
 * Full-screen paper menu: large serif nav rows + two product groups.
 */
export interface MobileMenuProps { nav?: {label: string;
  href: string}[];
  groups?: {title: string;
  items: {label: string;
  href?: string}[]}[];
  onClose?: () => void;
  closeLabel?: string;
  inline?: boolean;
  assetBase?: string; }
export declare function MobileMenu(props: MobileMenuProps): JSX.Element;
