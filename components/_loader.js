// Loads the SOUL component library for cards & UI kits.
// 1) uses the compiled _ds_bundle.js namespace if present; 2) otherwise compiles the .jsx sources in-browser (needs React + Babel standalone).
(function () {
  const FILES = [
    'actions/Button', 'actions/TextLink', 'actions/IconButton',
    'forms/TextField', 'forms/TextArea', 'forms/ChipToggle', 'forms/LangToggle', 'forms/QuantityStepper', 'forms/NewsletterForm',
    'display/Eyebrow', 'display/SectionHeader', 'display/Badge', 'display/LabelRule',
    'commerce/ProductCard', 'commerce/CategoryTile', 'commerce/CollectionCard', 'commerce/SoulfulCard', 'commerce/CartLine',
    'content/StatRow', 'content/CertCard', 'content/CapabilityItem', 'content/ServiceRow', 'content/StoreCard', 'content/PhotoTile',
    'navigation/SiteHeader', 'navigation/MegaMenu', 'navigation/SiteFooter', 'navigation/MobileMenu',
    'feedback/Toast', 'feedback/Lightbox', 'feedback/Drawer'
  ];
  let cache = null;
  window.loadSoulDS = function (root) {
    if (cache) return cache;
    cache = (async () => {
      let found = null;
      for (const k of Object.keys(window)) {
        try { const v = window[k]; if (v && typeof v === 'object' && v !== window && v.Button && v.SiteHeader && v.ProductCard) { found = v; break; } } catch (e) {}
      }
      if (found) return found;
      const R = {};
      const srcs = await Promise.all(FILES.map(f => fetch(root + 'components/' + f + '.jsx').then(r => r.text())));
      srcs.forEach((src, i) => {
        const imports = [...src.matchAll(/import\s*\{([^}]+)\}\s*from/g)].flatMap(m => m[1].split(',').map(s => s.trim()).filter(Boolean));
        const names = [...src.matchAll(/export function (\w+)/g)].map(m => m[1]);
        const body = src.replace(/^import .*$/mg, '').replace(/export function /g, 'function ');
        const code = '(function(__R){' + (imports.length ? 'const {' + imports.join(',') + '} = __R;' : '') + body + '\nObject.assign(__R,{' + names.join(',') + '});})';
        const out = Babel.transform(code, { presets: ['react'] }).code;
        try { (0, eval)(out)(R); } catch (e) { console.error('SoulDS: failed to load ' + FILES[i], e); }
      });
      window.SoulDS = R;
      return R;
    })();
    return cache;
  };
})();
