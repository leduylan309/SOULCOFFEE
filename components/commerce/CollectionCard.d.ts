import * as React from 'react';
/**
 * Large 16:10 entry card for a product family (Cà phê rang / Nhân xanh).
 */
export interface CollectionCardProps { index?: string;
  title: string;
  img?: string;
  alt?: string;
  href?: string;
  tone?: 'dark'|'light';
  linkLabel?: string;
  items?: {label: string;
  href?: string}[]; }
export declare function CollectionCard(props: CollectionCardProps): JSX.Element;
