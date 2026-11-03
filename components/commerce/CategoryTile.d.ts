import * as React from 'react';
/**
 * 4:5 photo tile + serif name + ↗; whole tile turns yellow on hover.
 */
export interface CategoryTileProps { img?: string;
  alt?: string;
  name: string;
  href?: string;
  ratio?: string; }
export declare function CategoryTile(props: CategoryTileProps): JSX.Element;
