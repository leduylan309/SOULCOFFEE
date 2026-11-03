import * as React from 'react';
/**
 * Dark seasonal card: square image, big serif flavour word, method, process, outline-dark add.
 */
export interface SoulfulCardProps { img?: string;
  alt?: string;
  word: string;
  method?: string;
  process?: string;
  addLabel?: string;
  onAdd?: () => void; }
export declare function SoulfulCard(props: SoulfulCardProps): JSX.Element;
