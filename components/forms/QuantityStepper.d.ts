import * as React from 'react';
/**
 * − qty + stepper for cart lines.
 */
export interface QuantityStepperProps { value?: number;
  onDec?: () => void;
  onInc?: () => void; }
export declare function QuantityStepper(props: QuantityStepperProps): JSX.Element;
