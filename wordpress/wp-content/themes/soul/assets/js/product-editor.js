/**
 * Product editor — canvas class so body patterns match front .s-shop-story__body.
 * (Cột trái «Về sản phẩm» chỉ trên front PHP — editor chỉ cột phải.)
 */
(function () {
  function canvasDoc() {
    const iframe = document.querySelector('iframe[name="editor-canvas"]');
    return iframe?.contentDocument || null;
  }

  function mark() {
    const doc = canvasDoc();
    const wrap = doc?.querySelector('.editor-styles-wrapper') || document.querySelector('.editor-styles-wrapper');
    if (wrap) wrap.classList.add('s-shop-product-canvas');
  }

  function boot() {
    mark();
    const obs = new MutationObserver(() => mark());
    obs.observe(document.body, { childList: true, subtree: true });
    setInterval(mark, 2000);
  }

  if (window.wp?.domReady) {
    window.wp.domReady(boot);
  } else {
    document.addEventListener('DOMContentLoaded', boot);
  }
})();
