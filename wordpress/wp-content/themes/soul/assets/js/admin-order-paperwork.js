/**
 * Admin-only paperwork picker for soul_order (Media Library).
 */
(function ($) {
  'use strict';

  function readIds($input) {
    var raw = ($input.val() || '').trim();
    if (!raw) return [];
    return raw.split(',').map(function (v) { return parseInt(v, 10); }).filter(function (n) { return n > 0; });
  }

  function writeIds($input, ids) {
    var uniq = [];
    ids.forEach(function (id) {
      if (uniq.indexOf(id) === -1) uniq.push(id);
    });
    $input.val(uniq.join(','));
  }

  function ensureList($list) {
    $list.find('.soul-paperwork-empty').remove();
  }

  function maybeEmpty($list) {
    if ($list.children('li[data-id]').length === 0) {
      $list.html('<li class="soul-paperwork-empty description">Chưa có file đính kèm.</li>');
    }
  }

  function addRow($list, att) {
    ensureList($list);
    if ($list.find('li[data-id="' + att.id + '"]').length) return;
    var type = (att.mime || '').indexOf('pdf') !== -1 ? 'PDF'
      : (att.mime || '').indexOf('image/') === 0 ? 'Ảnh'
      : 'FILE';
    var $li = $('<li/>').attr('data-id', att.id);
    $li.append($('<span class="soul-paperwork-type"/>').text(type));
    $li.append($('<a/>').attr({ href: att.url, target: '_blank', rel: 'noopener noreferrer' }).text(att.title || ('#' + att.id)));
    $li.append(' ');
    $li.append(
      $('<button type="button" class="button-link-delete soul-paperwork-remove" data-soul-paperwork-remove/>')
        .text((window.soulOrderPaperwork && soulOrderPaperwork.remove) || 'Gỡ')
    );
    $list.append($li);
  }

  $(function () {
    var $input = $('#soul_paperwork_ids');
    var $list = $('[data-soul-paperwork-list]');
    var $btn = $('#soul-paperwork-add');
    if (!$input.length || !$btn.length || typeof wp === 'undefined' || !wp.media) return;

    var frame;
    $btn.on('click', function (e) {
      e.preventDefault();
      if (frame) {
        frame.open();
        return;
      }
      frame = wp.media({
        title: (soulOrderPaperwork && soulOrderPaperwork.title) || 'Paperwork',
        button: { text: (soulOrderPaperwork && soulOrderPaperwork.button) || 'Attach' },
        multiple: true
      });
      frame.on('select', function () {
        var selection = frame.state().get('selection');
        var ids = readIds($input);
        selection.each(function (att) {
          var j = att.toJSON();
          if (!j || !j.id) return;
          ids.push(j.id);
          addRow($list, {
            id: j.id,
            title: j.filename || j.title || ('#' + j.id),
            url: j.url,
            mime: j.mime || ''
          });
        });
        writeIds($input, ids);
      });
      frame.open();
    });

    $list.on('click', '[data-soul-paperwork-remove]', function (e) {
      e.preventDefault();
      var $li = $(this).closest('li[data-id]');
      var id = parseInt($li.attr('data-id'), 10);
      $li.remove();
      writeIds($input, readIds($input).filter(function (n) { return n !== id; }));
      maybeEmpty($list);
    });
  });
})(jQuery);
