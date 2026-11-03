import * as React from 'react';
/**
 * Underline-only text input with tracked uppercase label.
 */
export interface TextFieldProps { label: string;
  required?: boolean;
  type?: string;
  name?: string;
  value?: string;
  onChange?: (e: any) => void;
  autoComplete?: string;
  style?: React.CSSProperties; }
export declare function TextField(props: TextFieldProps): JSX.Element;
