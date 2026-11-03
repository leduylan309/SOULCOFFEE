import * as React from 'react';
/**
 * Square uppercase CTA; ink→yellow hover. Use for every primary/secondary action.
 * @startingPoint section="Actions" subtitle="Square CTA buttons" viewport="700x260"
 */
export interface ButtonProps { variant?: 'primary'|'accent'|'outline'|'outline-dark'|'outline-dark-accent';
  size?: 'l'|'m'|'s'|'xs';
  arrow?: boolean;
  href?: string;
  onClick?: () => void;
  type?: 'button'|'submit';
  fullWidth?: boolean;
  disabled?: boolean;
  children: React.ReactNode;
  style?: React.CSSProperties; }
export declare function Button(props: ButtonProps): JSX.Element;
