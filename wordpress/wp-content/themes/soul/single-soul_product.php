<?php
/**
 * Single product.
 *
 * @package Soul
 */
get_header();
while (have_posts()) :
	the_post();
	$meta      = soul_get_product_meta(get_the_ID());
	$img       = get_the_post_thumbnail_url(get_the_ID(), 'large') ?: '';
	$solutions = home_url('/coffee-solutions/#contact');
	$payload   = [
		'id'    => $meta['sku'] ?: (string) get_the_ID(),
		'sku'   => $meta['sku'] ?: (string) get_the_ID(),
		'name'  => get_the_title(),
		'img'   => $img,
		'price' => $meta['price'],
		'type'  => $meta['badge'],
	];
	?>
	<article <?php post_class('soul-container soul-pdp soul-page-shell'); ?> data-section="pdp-detail<?php echo $meta['quote_only'] ? '-quote' : ''; ?>">
		<div class="soul-pdp__grid">
			<div class="soul-pdp__gallery">
				<?php if (has_post_thumbnail()) : ?>
					<?php the_post_thumbnail('large', ['class' => 'soul-pdp__img']); ?>
				<?php else : ?>
					<div class="soul-media-well" aria-hidden="true"></div>
				<?php endif; ?>
			</div>
			<div class="soul-pdp__info">
				<?php if ($meta['badge']) : ?>
					<p class="soul-eyebrow"><?php echo esc_html($meta['badge']); ?></p>
				<?php endif; ?>
				<h1><?php the_title(); ?></h1>
				<?php if ($meta['notes']) : ?>
					<p class="is-style-tasting-notes soul-notes"><?php echo esc_html($meta['notes']); ?></p>
				<?php endif; ?>
				<?php if ($meta['meta_chain']) : ?>
					<p class="soul-meta-chain"><?php echo esc_html($meta['meta_chain']); ?></p>
				<?php endif; ?>

				<?php if ($meta['quote_only']) : ?>
					<p class="soul-price"><?php echo esc_html(soul_format_vnd($meta['price'])); ?> <span class="soul-muted"><?php esc_html_e('(mẫu / tham khảo)', 'soul'); ?></span></p>
					<p><a class="soul-btn soul-btn--primary" href="<?php echo esc_url($solutions); ?>"><?php esc_html_e('Liên hệ báo giá ↗', 'soul'); ?></a></p>
				<?php elseif ($meta['in_stock']) : ?>
					<p class="soul-price" data-base-price="<?php echo esc_attr((string) $meta['price']); ?>" data-product-price><?php echo esc_html(soul_format_vnd($meta['price'])); ?></p>
					<div class="soul-variants">
						<?php foreach ($meta['variants'] as $group) : ?>
							<fieldset class="soul-variant">
								<legend><?php echo esc_html($group['label'] ?? ''); ?></legend>
								<div class="soul-chips" data-component="chip-group" data-mode="single" data-name="<?php echo esc_attr($group['id'] ?? 'v'); ?>">
									<?php foreach (($group['values'] ?? []) as $i => $val) : ?>
										<button
											type="button"
											class="soul-chip c-chip<?php echo $i === 0 ? ' is-on' : ''; ?>"
											data-value="<?php echo esc_attr($val[0]); ?>"
											data-variant-group="<?php echo esc_attr($group['id']); ?>"
											data-variant-id="<?php echo esc_attr($val[0]); ?>"
											data-multiplier="<?php echo esc_attr((string) $val[2]); ?>"
											aria-pressed="<?php echo $i === 0 ? 'true' : 'false'; ?>"
										><?php echo esc_html($val[1]); ?></button>
									<?php endforeach; ?>
								</div>
							</fieldset>
						<?php endforeach; ?>
					</div>
					<div class="soul-pdp__actions">
						<div data-component="stepper" class="soul-stepper" data-min="1" data-max="99">
							<button type="button" data-step="-1" aria-label="-">−</button>
							<input id="soul-pdp-qty" data-value type="number" name="qty" value="1" min="1" readonly>
							<button type="button" data-step="1" aria-label="+">+</button>
						</div>
						<button
							type="button"
							class="soul-btn soul-btn--primary"
							data-component="add-to-cart"
							data-open-drawer="true"
							data-qty-from="#soul-pdp-qty"
							data-product="<?php echo esc_attr(wp_json_encode($payload, JSON_UNESCAPED_UNICODE)); ?>"
						><?php esc_html_e('Thêm vào giỏ', 'soul'); ?></button>
					</div>
				<?php else : ?>
					<p class="soul-soldout"><?php esc_html_e('Hết hàng', 'soul'); ?></p>
				<?php endif; ?>

				<div class="entry-content soul-content" data-section="pdp-story"><?php the_content(); ?></div>
			</div>
		</div>

		<?php
		$related = new WP_Query([
			'post_type'      => 'soul_product',
			'posts_per_page' => 4,
			'post__not_in'   => [get_the_ID()],
			'tax_query'      => [
				[
					'taxonomy' => 'soul_collection',
					'field'    => 'term_id',
					'terms'    => wp_get_post_terms(get_the_ID(), 'soul_collection', ['fields' => 'ids']),
				],
			],
		]);
		if ($related->have_posts()) :
			?>
			<section class="soul-related" data-section="pdp-related">
				<h2><?php esc_html_e('Sản phẩm liên quan', 'soul'); ?></h2>
				<div class="soul-product-grid">
					<?php
					while ($related->have_posts()) :
						$related->the_post();
						get_template_part('template-parts/product', 'card');
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</section>
		<?php endif; ?>
	</article>
	<?php
endwhile;
get_footer();
