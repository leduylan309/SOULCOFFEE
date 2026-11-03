import * as React from 'react';
/**
 * Ink toast bottom-centre with yellow action ('Xem giỏ').
 */
export interface ToastProps { message: string;
  actionLabel?: string;
  onAction?: () => void;
  inline?: boolean; }
export declare function Toast(props: ToastProps): JSX.Element;
