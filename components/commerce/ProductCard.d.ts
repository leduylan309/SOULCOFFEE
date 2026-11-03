import * as React from 'react';
/**
 * Sand product card: square packshot + badge, type, serif name, italic notes, meta, outline add button.
 * @startingPoint section="Commerce" subtitle="Product card with add-to-cart" viewport="700x520"
 */
export interface ProductCardProps { img?: string;
  alt?: string;
  badge?: string;
  type?: string;
  name: string;
  notes?: string;
  meta?: string;
  addLabel?: string;
  onAdd?: () => void; }
export declare function ProductCard(props: ProductCardProps): JSX.Element;
