import * as React from 'react';
/**
 * Right-side paper drawer with scrim (cart).
 */
export interface DrawerProps { title: string;
  count?: number;
  onClose?: () => void;
  children?: React.ReactNode;
  footer?: React.ReactNode;
  inline?: boolean;
  width?: string; }
export declare function Drawer(props: DrawerProps): JSX.Element;
