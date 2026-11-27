(function (wp) {
  const { registerBlockType } = wp.blocks;
  const { useBlockProps, InspectorControls, RichText } = wp.blockEditor;
  const { PanelBody, SelectControl, TextControl } = wp.components;
  const { createElement: el, Fragment } = wp.element;

  registerBlockType('soul/lead-form', {
    edit: function (props) {
      const { attributes: a, setAttributes } = props;
      const isNl = a.kind === 'newsletter';
      const isHelp = a.kind === 'help';
      const blockProps = useBlockProps({
        className: isNl
          ? 's-home-nl__form soul-lead-form'
          : isHelp
            ? 's-help-form soul-lead-form'
            : 's-home-form soul-lead-form',
      });
      return el(
        Fragment,
        null,
        el(
          InspectorControls,
          null,
          el(
            PanelBody,
            { title: 'Form', initialOpen: true },
            el(SelectControl, {
              label: 'Loại form',
              value: a.kind,
              options: [
                { label: 'Newsletter', value: 'newsletter' },
                { label: 'Liên hệ B2B', value: 'contact' },
                { label: 'Hỗ trợ (Help)', value: 'help' },
              ],
              onChange: (v) => setAttributes({ kind: v }),
            }),
            !isNl
              ? el(TextControl, {
                  label: 'Tiêu đề form',
                  value: a.title,
                  onChange: (v) => setAttributes({ title: v }),
                })
              : null,
            !isNl && !isHelp
              ? el(TextControl, {
                  label: 'Source (tracking)',
                  value: a.source,
                  onChange: (v) => setAttributes({ source: v }),
                })
              : null,
            el(TextControl, {
              label: 'Nhãn nút gửi',
              value: a.submitLabel,
              placeholder: isNl ? 'Đăng ký ↗' : 'Gửi thông tin',
              onChange: (v) => setAttributes({ submitLabel: v }),
            }),
            isNl
              ? el(TextControl, {
                  label: 'Placeholder email',
                  value: a.emailPlaceholder,
                  onChange: (v) => setAttributes({ emailPlaceholder: v }),
                })
              : null
          )
        ),
        el(
          'div',
          blockProps,
          !isNl
            ? el(RichText, {
                tagName: 'h3',
                value: a.title,
                onChange: (v) => setAttributes({ title: v }),
                placeholder: 'Tiêu đề form',
              })
            : null,
          el(
            'p',
            { style: { opacity: 0.7, fontSize: 13 } },
            isNl
              ? 'Newsletter: email + honeypot (front). Admin chỉ chỉnh nhãn/placeholder.'
              : isHelp
                ? 'Form hỗ trợ: chủ đề, tên, liên hệ, mã đơn, nội dung.'
                : 'Form liên hệ đầy đủ trên front. Chỉnh tiêu đề & source ở đây.'
          )
        )
      );
    },
    save: function () {
      return null;
    },
  });
})(window.wp);
