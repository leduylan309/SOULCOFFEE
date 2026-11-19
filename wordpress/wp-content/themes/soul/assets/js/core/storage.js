// Namespaced localStorage with JSON + graceful failure (Safari private mode, quota).
import { PREFIX } from './config.js';

const key = (k) => `${PREFIX}:${k}`;
export const storage = {
  get(k, fallback = null) { try { const v = localStorage.getItem(key(k)); return v === null ? fallback : JSON.parse(v); } catch { return fallback; } },
  set(k, v) { try { localStorage.setItem(key(k), JSON.stringify(v)); } catch { /* ignore */ } },
  remove(k) { try { localStorage.removeItem(key(k)); } catch { /* ignore */ } }
};
