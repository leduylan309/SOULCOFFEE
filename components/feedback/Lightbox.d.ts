import * as React from 'react';
/**
 * Near-black full-screen viewer with counter, ← → and caption.
 */
export interface LightboxProps { src: string;
  alt?: string;
  label?: string;
  counter?: string;
  caption?: string;
  onPrev?: () => void;
  onNext?: () => void;
  onClose?: () => void;
  inline?: boolean; }
export declare function Lightbox(props: LightboxProps): JSX.Element;
