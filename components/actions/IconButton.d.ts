import * as React from 'react';
/**
 * 44px icon-only button: search, menu, close, carousel arrows.
 */
export interface IconButtonProps { icon?: 'arrow-left'|'arrow-right'|'close'|'search'|'menu'|'plus'|'minus';
  label: string;
  variant?: 'plain'|'round'|'outline-dark';
  onClick?: () => void;
  size?: number; }
export declare function IconButton(props: IconButtonProps): JSX.Element;
