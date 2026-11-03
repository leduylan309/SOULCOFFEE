import * as React from 'react';
/**
 * Ink footer: yellow logo, 4 link columns, tagline + copyright bar.
 */
export interface SiteFooterProps { columns?: {title: string;
  links: {label: string;
  href?: string}[]}[];
  tagline?: string;
  copyright?: string;
  assetBase?: string; }
export declare function SiteFooter(props: SiteFooterProps): JSX.Element;
