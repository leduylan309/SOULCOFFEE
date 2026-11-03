import * as React from 'react';
/**
 * Single email field on a 2px ink underline with inline submit; shows serif thank-you.
 */
export interface NewsletterFormProps { placeholder?: string;
  submitLabel?: string;
  thanks?: string;
  onSubmit?: (email: string) => void; }
export declare function NewsletterForm(props: NewsletterFormProps): JSX.Element;
