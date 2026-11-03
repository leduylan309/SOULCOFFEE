import * as React from 'react';
/**
 * 40px square toggle chip; pressed fills yellow. Multi-select interests.
 */
export interface ChipToggleProps { pressed?: boolean;
  onClick?: () => void;
  children: React.ReactNode; }
export declare function ChipToggle(props: ChipToggleProps): JSX.Element;
