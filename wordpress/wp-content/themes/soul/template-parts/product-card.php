<?php
/**
 * Product card — SoT Shop.dc.html listing card + quick-add.
 *
 * @package Soul
 */
$pid   = (int) get_the_ID();
$meta  = soul_get_product_meta($pid);
$img   = get_the_post_thumbnail_url($pid, 'medium_large') ?: '';
$kind  = soul_shop_product_kind($pid);
$code  = soul_shop_product_kind_code($pid);
$opts  = soul_shop_product_opts($pid);
$badge = soul_shop_product_badge($pid);
$sold  = ! $meta['in_stock'];
$quote = $meta['quote_only'] || ($code === 'gb' && $meta['price'] <= 0);
$unit  = ($code === 'gb' && ! $quote) ? __(' / kg', 'soul') : '';

$pick = soul_shop_product_pick_info($pid);
$payload = [
	'id'    => $meta['sku'] ?: (string) $pid,
	'sku'   => $meta['sku'] ?: (string) $pid,
	'name'  => get_the_title(),
	'img'   => $img,
	'price' => $meta['price'],
	'type'  => $kind,
	'kind'  => $code,
	'opts'  => $opts,
	'brew'  => $pick['brew'],
	'facts' => $pick['facts'],
];

$btn_label = $quote ? __('Liên hệ', 'soul') : ($sold ? __('Hết hàng', 'soul') : '+ ' . __('Thêm', 'soul'));
?>
<article <?php post_class('s-shop-card'); ?> data-shop-card data-name="<?php echo esc_attr(mb_strtolower(get_the_title())); ?>">
	<a class="s-shop-card__media<?php echo $sold ? ' is-sold' : ''; ?>" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
		<?php if (has_post_thumbnail()) : ?>
			<?php the_post_thumbnail('medium_large', ['loading' => 'lazy', 'alt' => '']); ?>
		<?php endif; ?>
		<?php if ($badge) : ?>
			<span class="s-shop-card__badge" style="background:<?php echo esc_attr($badge[1]); ?>;color:<?php echo esc_attr($badge[2]); ?>"><?php echo esc_html($badge[0]); ?></span>
		<?php endif; ?>
	</a>
	<p class="s-shop-card__kind"><?php echo esc_html($kind); ?></p>
	<h3 class="s-shop-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<div class="s-shop-card__foot">
		<span class="s-shop-card__price">
			<?php if ($quote) : ?>
				<?php esc_html_e('Liên hệ', 'soul'); ?>
			<?php else : ?>
				<?php echo esc_html(soul_format_vnd($meta['price'])); ?><span class="s-shop-card__unit"><?php echo esc_html($unit); ?></span>
			<?php endif; ?>
		</span>
		<?php if ($quote) : ?>
			<a class="s-shop-card__btn" href="<?php the_permalink(); ?>"><?php echo esc_html($btn_label); ?></a>
		<?php elseif ($sold) : ?>
			<button type="button" class="s-shop-card__btn" disabled aria-label="<?php esc_attr_e('Hết hàng', 'soul'); ?>"><?php echo esc_html($btn_label); ?></button>
		<?php elseif ($opts !== []) : ?>
			<button
				type="button"
				class="s-shop-card__btn"
				data-shop-quick
				data-product="<?php echo esc_attr(wp_json_encode($payload, JSON_UNESCAPED_UNICODE)); ?>"
				aria-label="<?php echo esc_attr(sprintf(/* translators: product name */ __('Thêm vào giỏ: %s', 'soul'), get_the_title())); ?>"
			><?php echo esc_html($btn_label); ?></button>
		<?php else : ?>
			<button
				type="button"
				class="s-shop-card__btn"
				data-component="add-to-cart"
				data-open-drawer="true"
				data-product="<?php echo esc_attr(wp_json_encode($payload, JSON_UNESCAPED_UNICODE)); ?>"
				aria-label="<?php echo esc_attr(sprintf(/* translators: product name */ __('Thêm vào giỏ: %s', 'soul'), get_the_title())); ?>"
			><?php echo esc_html($btn_label); ?></button>
		<?php endif; ?>
	</div>
</article>
