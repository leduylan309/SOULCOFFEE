/**
 * Mark post editor canvas so article body styles match the front.
 */
(function (wp) {
  if (!wp || !wp.data || !wp.domReady) return;

  var select = wp.data.select;
  var subscribe = wp.data.subscribe;

  function canvasRoot() {
    var iframe = document.querySelector('iframe[name="editor-canvas"]');
    if (iframe && iframe.contentDocument) {
      return iframe.contentDocument.querySelector('.editor-styles-wrapper');
    }
    return document.querySelector('.editor-styles-wrapper');
  }

  function sync() {
    var type = null;
    try {
      type = select('core/editor') && select('core/editor').getCurrentPostType
        ? select('core/editor').getCurrentPostType()
        : null;
    } catch (e) {
      type = null;
    }
    var root = canvasRoot();
    if (!root) return;
    root.classList.toggle('s-blog-article-canvas', type === 'post');
  }

  wp.domReady(function () {
    sync();
    subscribe(sync);
    // Iframe canvas mounts async.
    var n = 0;
    var t = setInterval(function () {
      sync();
      if (++n > 40) clearInterval(t);
    }, 250);
  });
})(window.wp);
