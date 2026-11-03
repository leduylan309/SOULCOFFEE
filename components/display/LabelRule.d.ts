import * as React from 'react';
/**
 * Sub-section label followed by a hairline, or a strong divider row with count + actions.
 */
export interface LabelRuleProps { children: React.ReactNode;
  count?: string;
  strong?: boolean;
  actions?: React.ReactNode;
  id?: string; }
export declare function LabelRule(props: LabelRuleProps): JSX.Element;
