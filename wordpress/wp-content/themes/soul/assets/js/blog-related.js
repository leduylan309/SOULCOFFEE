/**
 * Document panel: pick up to 3 related posts.
 * Empty → front uses latest in same category (see soul_blog_related).
 */
(function (wp) {
  if (!wp || !wp.plugins || !wp.element || !wp.data || !wp.components || !wp.apiFetch) {
    return;
  }

  var el = wp.element.createElement;
  var Fragment = wp.element.Fragment;
  var useState = wp.element.useState;
  var useEffect = wp.element.useEffect;
  var useMemo = wp.element.useMemo;
  var registerPlugin = wp.plugins.registerPlugin;
  var useSelect = wp.data.useSelect;
  var useEntityProp = wp.coreData.useEntityProp;
  var FormTokenField = wp.components.FormTokenField;
  var Spinner = wp.components.Spinner;
  var apiFetch = wp.apiFetch;
  var __ = wp.i18n.__;

  var Panel =
    (wp.editor && wp.editor.PluginDocumentSettingPanel) ||
    (wp.editPost && wp.editPost.PluginDocumentSettingPanel);
  if (!Panel) {
    return;
  }

  var LIMIT = 3;

  function decodeEntities(str) {
    if (!str) return '';
    var t = document.createElement('textarea');
    t.innerHTML = str;
    return t.value;
  }

  function RelatedPanel() {
    var postType = useSelect(function (select) {
      var ed = select('core/editor');
      return ed && ed.getCurrentPostType ? ed.getCurrentPostType() : null;
    }, []);

    var postId = useSelect(function (select) {
      var ed = select('core/editor');
      return ed && ed.getCurrentPostId ? ed.getCurrentPostId() : 0;
    }, []);

    var metaPair = useEntityProp('postType', 'post', 'meta');
    var meta = metaPair[0] || {};
    var setMeta = metaPair[1];

    var relatedIds = useMemo(function () {
      var raw = meta && meta.soul_related_posts;
      if (!Array.isArray(raw)) return [];
      return raw.map(Number).filter(function (id) {
        return id > 0 && id !== postId;
      }).slice(0, LIMIT);
    }, [meta, postId]);

    var mapState = useState({});
    var idToTitle = mapState[0];
    var setIdToTitle = mapState[1];

    var suggestionsState = useState([]);
    var suggestions = suggestionsState[0];
    var setSuggestions = suggestionsState[1];

    var loadingState = useState(false);
    var loading = loadingState[0];
    var setLoading = loadingState[1];

    useEffect(
      function () {
        if (!relatedIds.length) return;
        var missing = relatedIds.filter(function (id) {
          return !idToTitle[id];
        });
        if (!missing.length) return;
        var cancelled = false;
        Promise.all(
          missing.map(function (id) {
            return apiFetch({ path: '/wp/v2/posts/' + id + '?_fields=id,title' }).then(
              function (p) {
                return { id: p.id, title: decodeEntities((p.title && p.title.rendered) || '#' + p.id) };
              },
              function () {
                return { id: id, title: '#' + id };
              }
            );
          })
        ).then(function (rows) {
          if (cancelled) return;
          setIdToTitle(function (prev) {
            var next = Object.assign({}, prev);
            rows.forEach(function (r) {
              next[r.id] = r.title;
            });
            return next;
          });
        });
        return function () {
          cancelled = true;
        };
      },
      [relatedIds.join(',')]
    );

    if (postType !== 'post') {
      return null;
    }

    var tokens = relatedIds.map(function (id) {
      return idToTitle[id] || '#' + id;
    });

    function titleToId(title) {
      var t = String(title);
      var found = Object.keys(idToTitle).find(function (id) {
        return idToTitle[id] === t;
      });
      if (found) return Number(found);
      var m = t.match(/^#(\d+)$/);
      return m ? Number(m[1]) : 0;
    }

    function onChange(nextTokens) {
      var nextIds = [];
      var nextMap = Object.assign({}, idToTitle);
      (nextTokens || []).forEach(function (token) {
        if (nextIds.length >= LIMIT) return;
        var id = titleToId(token);
        if (!id || id === postId || nextIds.indexOf(id) !== -1) return;
        nextIds.push(id);
        if (!nextMap[id]) nextMap[id] = token;
      });
      setIdToTitle(nextMap);
      setMeta(
        Object.assign({}, meta, {
          soul_related_posts: nextIds,
        })
      );
    }

    function onInputChange(value) {
      var q = String(value || '').trim();
      if (q.length < 2) {
        setSuggestions([]);
        return;
      }
      setLoading(true);
      apiFetch({
        path:
          '/wp/v2/posts?search=' +
          encodeURIComponent(q) +
          '&per_page=12&status=publish&_fields=id,title',
      })
        .then(function (posts) {
          var map = Object.assign({}, idToTitle);
          var titles = [];
          (posts || []).forEach(function (p) {
            if (p.id === postId) return;
            var title = decodeEntities((p.title && p.title.rendered) || '#' + p.id);
            map[p.id] = title;
            titles.push(title);
          });
          setIdToTitle(map);
          setSuggestions(titles);
        })
        .catch(function () {
          setSuggestions([]);
        })
        .finally(function () {
          setLoading(false);
        });
    }

    return el(
      Panel,
      {
        name: 'soul-related-posts',
        title: __('Bài viết liên quan', 'soul'),
        className: 'soul-related-posts-panel',
      },
      el(
        Fragment,
        null,
        el('p', { className: 'description', style: { marginTop: 0 } },
          __('Chọn tối đa 3 bài. Để trống → lấy bài mới nhất cùng chuyên mục.', 'soul')
        ),
        el(FormTokenField, {
          label: __('Tìm & chọn bài', 'soul'),
          value: tokens,
          suggestions: suggestions,
          onChange: onChange,
          onInputChange: onInputChange,
          maxLength: LIMIT,
          __experimentalExpandOnFocus: true,
          tokenizeOnSpace: false,
        }),
        loading ? el(Spinner, null) : null
      )
    );
  }

  registerPlugin('soul-related-posts', {
    render: RelatedPanel,
    icon: 'admin-links',
  });
})(window.wp);
