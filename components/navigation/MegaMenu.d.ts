import * as React from 'react';
/**
 * Product mega menu under the header: serif link columns + dark Soulful feature tile.
 */
export interface MegaMenuProps { columns: {title: string;
  items: {label: string;
  href?: string}[];
  footerLink?: {label: string;
  href?: string}}[];
  feature?: {img: string;
  eyebrow: string;
  title: string;
  sub?: string;
  cta: string;
  href?: string};
  inline?: boolean; }
export declare function MegaMenu(props: MegaMenuProps): JSX.Element;
