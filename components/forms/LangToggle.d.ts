import * as React from 'react';
/**
 * VI / EN segmented switch in the header.
 */
export interface LangToggleProps { value?: string;
  onChange?: (v: string) => void;
  options?: string[]; }
export declare function LangToggle(props: LangToggleProps): JSX.Element;
