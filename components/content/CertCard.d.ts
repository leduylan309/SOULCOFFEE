import * as React from 'react';
/**
 * Certificate card for the horizontal awards rail (image on sand well or ink PDF tile).
 */
export interface CertCardProps { img?: string;
  pdf?: string;
  pdfKicker?: string;
  pdfLabel?: string;
  year: string;
  score: string;
  rank: string;
  comp?: string;
  onOpen?: () => void; }
export declare function CertCard(props: CertCardProps): JSX.Element;
