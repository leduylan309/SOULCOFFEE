// Minimal observable store: get / set / update / subscribe.
export function createStore(initial) {
  let state = initial;
  const subs = new Set();
  return {
    get: () => state,
    set(next) { state = typeof next === 'function' ? next(state) : next; subs.forEach((fn) => fn(state)); },
    update(patch) { this.set({ ...state, ...patch }); },
    subscribe(fn, { immediate = true } = {}) { subs.add(fn); if (immediate) fn(state); return () => subs.delete(fn); }
  };
}
