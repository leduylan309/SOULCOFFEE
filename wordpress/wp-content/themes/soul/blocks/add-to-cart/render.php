<?php
/**
 * @var array $attributes
 */

$label   = (string) ($attributes['label'] ?? __('Thêm vào giỏ', 'soul'));
$id      = (string) ($attributes['productId'] ?? '');
$name    = (string) ($attributes['productName'] ?? '');
$price   = (int) ($attributes['price'] ?? 0);
$img     = (string) ($attributes['imageUrl'] ?? '');
$type    = (string) ($attributes['productType'] ?? '');
$open    = ! empty($attributes['openDrawer']);
$variant = (string) ($attributes['variant'] ?? 'card');
$class   = $variant === 'soulful' ? 's-home-soulful__atc' : 's-home-card__atc';

$payload = wp_json_encode([
	'id'    => $id !== '' ? $id : sanitize_title($name),
	'sku'   => $id !== '' ? $id : sanitize_title($name),
	'name'  => $name,
	'img'   => $img,
	'price' => $price,
	'type'  => $type,
], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT);
?>
<button
	type="button"
	class="<?php echo esc_attr($class); ?>"
	data-component="add-to-cart"
	data-open-drawer="<?php echo $open ? 'true' : 'false'; ?>"
	data-product="<?php echo esc_attr((string) $payload); ?>"
><?php echo esc_html($label); ?></button>
