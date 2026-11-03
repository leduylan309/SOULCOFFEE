import * as React from 'react';
/**
 * Proof row on ink: big yellow serif numeral + unit, rank, competition, optional cert link.
 */
export interface StatRowProps { num: string;
  unit?: string;
  rank: string;
  comp?: string;
  ctaLabel?: string;
  onCta?: () => void; }
export declare function StatRow(props: StatRowProps): JSX.Element;
