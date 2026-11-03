import * as React from 'react';
/**
 * Small tracked uppercase kicker above every section title.
 */
export interface EyebrowProps { tone?: 'accent'|'muted'|'on-dark'|'ink';
  rule?: boolean;
  children: React.ReactNode;
  style?: React.CSSProperties; }
export declare function Eyebrow(props: EyebrowProps): JSX.Element;
