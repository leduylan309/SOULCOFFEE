(function (wp) {
  const { registerBlockType } = wp.blocks;
  const { useBlockProps, InspectorControls, MediaUpload, MediaUploadCheck } = wp.blockEditor;
  const { PanelBody, TextControl, TextareaControl, ToggleControl, SelectControl, Button } = wp.components;
  const { createElement: el, Fragment } = wp.element;

  registerBlockType('soul/add-to-cart', {
    edit: function (props) {
      const { attributes: a, setAttributes } = props;
      const blockProps = useBlockProps({
        className: a.variant === 'soulful' ? 's-home-soulful__atc' : 's-home-card__atc',
      });
      return el(
        Fragment,
        null,
        el(
          InspectorControls,
          null,
          el(
            PanelBody,
            { title: 'Sản phẩm', initialOpen: true },
            el(TextControl, {
              label: 'Nhãn nút',
              value: a.label,
              onChange: (v) => setAttributes({ label: v }),
            }),
            el(TextControl, {
              label: 'Mã / ID',
              value: a.productId,
              onChange: (v) => setAttributes({ productId: v }),
            }),
            el(TextareaControl, {
              label: 'Tên sản phẩm',
              value: a.productName,
              onChange: (v) => setAttributes({ productName: v }),
            }),
            el(TextControl, {
              label: 'Giá (VND)',
              type: 'number',
              value: a.price,
              onChange: (v) => setAttributes({ price: Number(v) || 0 }),
            }),
            el(TextControl, {
              label: 'Loại / type',
              value: a.productType,
              onChange: (v) => setAttributes({ productType: v }),
            }),
            el('p', { style: { opacity: 0.75, marginBottom: 8 } }, 'Ảnh giỏ: mặc định lấy ảnh card. Chỉ chọn nếu cần khác.'),
            el(MediaUploadCheck, null,
              el(MediaUpload, {
                onSelect: (m) => setAttributes({ imageUrl: m.url || '' }),
                allowedTypes: ['image'],
                render: ({ open }) =>
                  el(Button, { onClick: open, variant: 'secondary' }, a.imageUrl ? 'Đổi ảnh giỏ (tuỳ chọn)' : 'Ảnh giỏ (tuỳ chọn)'),
              })
            ),
            a.imageUrl
              ? el('p', { style: { marginTop: 8 } }, el('img', { src: a.imageUrl, alt: '', style: { maxWidth: '100%' } }))
              : null,
            el(ToggleControl, {
              label: 'Mở giỏ sau khi thêm',
              checked: !!a.openDrawer,
              onChange: (v) => setAttributes({ openDrawer: v }),
            }),
            el(SelectControl, {
              label: 'Kiểu nút',
              value: a.variant,
              options: [
                { label: 'Featured card', value: 'card' },
                { label: 'Soulful', value: 'soulful' },
              ],
              onChange: (v) => setAttributes({ variant: v }),
            })
          )
        ),
        el('button', { type: 'button', ...blockProps, disabled: true }, a.label || 'Thêm vào giỏ')
      );
    },
    save: function () {
      return null;
    },
  });
})(window.wp);
