import * as React from 'react';
/**
 * Two-column section header: eyebrow + serif title left, body + action right, bottom-aligned.
 * @startingPoint section="Layout" subtitle="Eyebrow + title + body" viewport="700x260"
 */
export interface SectionHeaderProps { eyebrow?: string;
  title: React.ReactNode;
  body?: string|string[];
  action?: React.ReactNode;
  tone?: 'light'|'dark';
  size?: 'h2'|'display'|'xl';
  rule?: boolean;
  divider?: boolean;
  id?: string; }
export declare function SectionHeader(props: SectionHeaderProps): JSX.Element;
