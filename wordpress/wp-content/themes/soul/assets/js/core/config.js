// Global constants shared by every module. Mirrors scss/abstracts/_variables.scss.
export const BREAKPOINTS = { sm: 480, md: 768, nav: 1180, xl: 1440 };
export const Z = { header: 60, toast: 80, scrim: 90, drawer: 95, mobileMenu: 100, lightbox: 110 };
export const PREFIX = 'soul';                 // event + storage namespace
export const SELECTORS = {
  component: '[data-component]',
  focusable: 'a[href],button:not([disabled]),input:not([disabled]),select:not([disabled]),textarea:not([disabled]),[tabindex]:not([tabindex="-1"])'
};
export const STATE = { open: 'is-open', active: 'is-active', selected: 'is-selected', invalid: 'is-invalid', loading: 'is-loading', locked: 'is-scroll-locked' };
export const TOAST_MS = 3200;
export const reducedMotion = () => window.matchMedia('(prefers-reduced-motion: reduce)').matches;
export const isCompact = () => window.innerWidth < BREAKPOINTS.nav;
