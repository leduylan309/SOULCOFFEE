import * as React from 'react';
/**
 * Square label chip pinned to imagery (product badge, award tag).
 */
export interface BadgeProps { tone?: 'ink'|'yellow';
  children: React.ReactNode;
  style?: React.CSSProperties; }
export declare function Badge(props: BadgeProps): JSX.Element;
