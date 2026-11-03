import * as React from 'react';
/**
 * Cart drawer row: 72px thumb, serif name, type, stepper, remove link.
 */
export interface CartLineProps { img?: string;
  name: string;
  type?: string;
  qty?: number;
  onInc?: () => void;
  onDec?: () => void;
  onRemove?: () => void;
  removeLabel?: string; }
export declare function CartLine(props: CartLineProps): JSX.Element;
