// Formatting helpers used by templates and components.
export const pad2 = (n) => String(n).padStart(2, '0');                       // 3 → "03"
export const counter = (i, total) => `${pad2(i + 1)} / ${pad2(total)}`;       // "03 / 05"
export const vnd = (n) => new Intl.NumberFormat('vi-VN').format(n) + '₫';    // 220000 → "220.000₫"
export const metaChain = (...parts) => parts.filter(Boolean).join(' · ');    // "Buôn Ma Thuột · Robusta TR"
export const isEmail = (v = '') => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.trim());
export const isPhoneVN = (v = '') => /^(0|\+84)\d{9,10}$/.test(v.replace(/[\s.]/g, ''));
