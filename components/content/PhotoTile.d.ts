import * as React from 'react';
/**
 * Zoomable photo button for albums & award galleries; optional yellow tag.
 */
export interface PhotoTileProps { img: string;
  alt?: string;
  ratio?: string;
  tag?: string;
  position?: string;
  onClick?: () => void;
  style?: React.CSSProperties; }
export declare function PhotoTile(props: PhotoTileProps): JSX.Element;
