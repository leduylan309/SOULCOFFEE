import * as React from 'react';
/**
 * Underlined uppercase text link with ↗ / ↓ arrow — secondary CTAs inside sections and cards.
 */
export interface TextLinkProps { href?: string;
  onClick?: () => void;
  tone?: 'light'|'dark';
  arrow?: string|null;
  size?: number;
  children: React.ReactNode; }
export declare function TextLink(props: TextLinkProps): JSX.Element;
