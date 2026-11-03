import * as React from 'react';
/**
 * Underline-only multiline field, same label treatment as TextField.
 */
export interface TextAreaProps { label: string;
  required?: boolean;
  name?: string;
  rows?: number;
  value?: string;
  onChange?: (e: any) => void;
  style?: React.CSSProperties; }
export declare function TextArea(props: TextAreaProps): JSX.Element;
