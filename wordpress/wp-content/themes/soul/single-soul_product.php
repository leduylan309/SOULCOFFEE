<?php
/**
 * Single product — SoT html/Shop.dc.html (isProduct).
 *
 * @package Soul
 */
get_header();

while (have_posts()) :
	the_post();
	$pid       = (int) get_the_ID();
	$meta      = soul_get_product_meta($pid);
	$code      = soul_shop_product_kind_code($pid);
	$kind      = soul_shop_product_kind($pid);
	$opts      = soul_shop_product_opts($pid);
	$badge     = soul_shop_product_badge($pid);
	$img       = get_the_post_thumbnail_url($pid, 'large') ?: '';
	$shop      = get_post_type_archive_link('soul_product') ?: home_url('/products/');
	$solutions = home_url('/coffee-solutions/#contact');
	$sold      = ! $meta['in_stock'];
	$quote     = $meta['quote_only'];
	$terms     = get_the_terms($pid, 'soul_collection') ?: [];
	$col       = null;
	$prefer    = ['ca-phe-pha-phin', 'ca-phe-pha-may', 'ca-phe-pha-dung-cu', 'ca-phe-u-lanh-cold-brew', 'soulful-flavours', 'origin-collection', 'ca-phe-nhan-xanh'];
	foreach ($prefer as $slug) {
		foreach ($terms as $t) {
			if ($t->slug === $slug) {
				$col = $t;
				break 2;
			}
		}
	}
	if (! $col) {
		foreach ($terms as $t) {
			if (! in_array($t->slug, ['san-pham-moi', 'san-pham-noi-bat', 'all', 'ca-phe-rang'], true)) {
				$col = $t;
				break;
			}
		}
	}
	if (! $col && $terms) {
		$col = $terms[0];
	}
	$col_name = $col ? $col->name : __('Sản phẩm', 'soul');
	$col_url  = $col ? get_term_link($col) : $shop;
	if (is_wp_error($col_url)) {
		$col_url = $shop;
	}

	$specs = soul_shop_product_specs($pid);

	$gb_terms = [
		__('Tỷ lệ chín 100% · độ ẩm < 13%', 'soul'),
		__('Hạt đen ≤ 0,5% · vỡ, tạp chất 0%', 'soul'),
		__('Mẫu 1 kg, 5 kg · trên 60 kg liên hệ báo giá', 'soul'),
		sprintf(
			/* translators: 1: email, 2: hotline */
			__('Email %1$s · Zalo/WhatsApp %2$s', 'soul'),
			function_exists('soul_contact') ? soul_contact('email_finerobusta') : 'finerobusta@soulcoffee.vn',
			function_exists('soul_contact') ? soul_contact('hotline_b2b') : '0908 267 710'
		),
	];

	$brew_map = [
		'ca-phe-pha-phin'         => ['huong-dan-pha-mot-ca-phe-phin-chuan-soul', __('Hướng dẫn pha phin', 'soul')],
		'ca-phe-pha-may'          => ['huong-dan-pha-espresso-chuan-soul', __('Hướng dẫn pha espresso', 'soul')],
		'ca-phe-pha-dung-cu'      => ['huong-dan-pha-pour-over-chuan-soul', __('Hướng dẫn pha pour over', 'soul')],
		'ca-phe-u-lanh-cold-brew' => ['huong-dan-pha-cold-brew-chuan-soul', __('Hướng dẫn pha cold brew', 'soul')],
	];
	$brew = null;
	foreach ($terms as $t) {
		if (isset($brew_map[ $t->slug ])) {
			$brew = $brew_map[ $t->slug ];
			break;
		}
	}
	$brew_url = '';
	if ($brew) {
		$brew_posts = get_posts([
			'name'           => $brew[0],
			'post_type'      => 'post',
			'posts_per_page' => 1,
			'post_status'    => 'publish',
		]);
		$brew_url = $brew_posts ? get_permalink($brew_posts[0]) : home_url('/blog/');
	}

	$payload = [
		'id'    => $meta['sku'] ?: (string) $pid,
		'sku'   => $meta['sku'] ?: (string) $pid,
		'name'  => get_the_title(),
		'img'   => $img,
		'price' => $meta['price'],
		'type'  => $kind,
		'kind'  => $code,
		'opts'  => $opts,
	];

	$price_note = $code === 'gb'
		? __('Chưa gồm 5% VAT', 'soul')
		: __('Đã gồm VAT', 'soul');
	?>
	<section class="s-shop-pdp" id="top" aria-labelledby="pd-h" data-screen-label="01 Sản phẩm · Chi tiết"
		data-base-price="<?php echo esc_attr((string) $meta['price']); ?>"
		data-product-kind="<?php echo esc_attr($code); ?>"
		data-quote="<?php echo $quote ? '1' : '0'; ?>"
		data-sold="<?php echo $sold ? '1' : '0'; ?>">
		<nav class="s-shop-crumb" aria-label="<?php esc_attr_e('Breadcrumb', 'soul'); ?>">
			<a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Trang chủ', 'soul'); ?></a>
			<span class="s-shop-crumb__sep" aria-hidden="true">/</span>
			<a href="<?php echo esc_url($shop); ?>"><?php esc_html_e('Sản phẩm', 'soul'); ?></a>
			<span class="s-shop-crumb__sep" aria-hidden="true">/</span>
			<a class="s-shop-crumb__cur" href="<?php echo esc_url($col_url); ?>"><?php echo esc_html($col_name); ?></a>
		</nav>

		<div class="s-shop-pdp__grid">
			<div class="s-shop-pdp__gallery">
				<div class="s-shop-pdp__main">
					<?php if ($img) : ?>
						<img src="<?php echo esc_url($img); ?>" alt="<?php the_title_attribute(); ?>" data-pdp-main>
					<?php endif; ?>
					<?php if ($badge) : ?>
						<span class="s-shop-pdp__badge" style="background:<?php echo esc_attr($badge[1]); ?>;color:<?php echo esc_attr($badge[2]); ?>"><?php echo esc_html($badge[0]); ?></span>
					<?php endif; ?>
				</div>
				<?php if ($img) : ?>
					<ul class="s-shop-pdp__thumbs" hidden>
						<li><button type="button" class="s-shop-pdp__thumb is-on" aria-pressed="true"><img src="<?php echo esc_url($img); ?>" alt=""></button></li>
					</ul>
				<?php endif; ?>
			</div>

			<div class="s-shop-pdp__info">
				<div class="s-shop-pdp__intro">
					<p class="s-shop-pdp__meta">
						<span class="s-shop-pdp__meta-kind"><?php echo esc_html($kind); ?></span>
						<?php if ($code === 'gb') : ?>
							<span class="s-shop-pdp__meta-crop"><?php esc_html_e('New crop 25/26', 'soul'); ?></span>
						<?php endif; ?>
					</p>
					<h1 class="s-shop-pdp__title" id="pd-h"><?php the_title(); ?></h1>
					<div class="s-shop-pdp__price-row">
						<span class="s-shop-pdp__price" data-pdp-price><?php echo $quote ? esc_html__('Liên hệ', 'soul') : esc_html(soul_format_vnd($meta['price'])); ?></span>
						<span class="s-shop-pdp__price-note" data-pdp-note><?php echo esc_html($price_note); ?></span>
					</div>
				</div>

				<div class="s-shop-pdp__opts" data-pdp-opts>
					<?php foreach ($opts as $group) : ?>
						<fieldset class="s-shop-pdp__set" data-opt-id="<?php echo esc_attr($group['id']); ?>">
							<legend><?php echo esc_html($group['label']); ?></legend>
							<div class="s-shop-pdp__chips">
								<?php foreach ($group['values'] as $i => $val) : ?>
									<button
										type="button"
										class="s-shop-pdp__chip<?php echo $i === 0 ? ' is-on' : ''; ?>"
										data-vid="<?php echo esc_attr($val[0]); ?>"
										data-mult="<?php echo esc_attr((string) $val[2]); ?>"
										data-label="<?php echo esc_attr($val[1]); ?>"
										aria-pressed="<?php echo $i === 0 ? 'true' : 'false'; ?>"
									><?php echo esc_html($val[1]); ?></button>
								<?php endforeach; ?>
							</div>
						</fieldset>
					<?php endforeach; ?>
				</div>

				<?php if ($sold) : ?>
					<div class="s-shop-pdp__sold">
						<span><?php esc_html_e('Lô này đã hết. Để lại thông tin để được báo khi có mùa vụ mới.', 'soul'); ?></span>
						<a href="<?php echo esc_url($solutions); ?>"><?php esc_html_e('Báo cho tôi', 'soul'); ?> ↗</a>
					</div>
				<?php else : ?>
					<div class="s-shop-pdp__buy" data-pdp-buy>
						<div class="s-shop-pdp__qty" role="group" aria-label="<?php esc_attr_e('Số lượng', 'soul'); ?>">
							<button type="button" data-pdp-dec aria-label="−">−</button>
							<span data-pdp-qty aria-live="polite">1</span>
							<button type="button" data-pdp-inc aria-label="+">+</button>
						</div>
						<button type="button" class="s-shop-pdp__atc" data-pdp-atc data-product="<?php echo esc_attr(wp_json_encode($payload, JSON_UNESCAPED_UNICODE)); ?>">
							<?php esc_html_e('Thêm vào giỏ', 'soul'); ?>
						</button>
						<a class="s-shop-pdp__buynow" href="<?php echo esc_url(get_permalink((int) get_option('soul_checkout_page_id')) ?: home_url('/checkout/')); ?>" data-pdp-buynow>
							<?php esc_html_e('Mua ngay', 'soul'); ?>
						</a>
						<a class="s-shop-pdp__quote" href="<?php echo esc_url($solutions); ?>" data-pdp-quote hidden>
							<?php esc_html_e('Liên hệ báo giá', 'soul'); ?> ↗
						</a>
					</div>
				<?php endif; ?>

				<dl class="s-shop-pdp__specs">
					<?php foreach ($specs as $row) : ?>
						<div class="s-shop-pdp__spec">
							<dt><?php echo esc_html($row[0]); ?></dt>
							<dd><?php echo esc_html($row[1]); ?></dd>
						</div>
					<?php endforeach; ?>
				</dl>

				<?php if ($brew && $brew_url) : ?>
					<a class="s-shop-pdp__brew" href="<?php echo esc_url($brew_url); ?>">
						<span>
							<span class="s-shop-pdp__brew-k"><?php esc_html_e('Hướng dẫn pha', 'soul'); ?></span>
							<?php echo esc_html($brew[1]); ?>
						</span>
						<span aria-hidden="true">↗</span>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<?php
	$story_text = trim(wp_strip_all_tags((string) get_post_field('post_content', $pid)));
	$has_story  = $story_text !== '' && $story_text !== trim($meta['notes']);
	?>
	<section class="s-shop-story" aria-labelledby="ds-h" data-screen-label="02 Sản phẩm · Mô tả">
		<div class="s-shop-story__grid">
			<div class="s-shop-story__aside">
				<p class="s-shop-story__eye"><?php esc_html_e('Về sản phẩm', 'soul'); ?></p>
				<h2 class="s-shop-story__title" id="ds-h"><?php the_title(); ?></h2>
			</div>
			<div class="s-shop-story__body">
				<?php if ($has_story) : ?>
					<?php the_content(); ?>
				<?php else : ?>
					<div class="s-shop-story__pending">
						<?php esc_html_e('Câu chuyện sản phẩm song ngữ sẽ được chuyển nguyên văn từ trang hiện tại khi triển khai.', 'soul'); ?>
					</div>
				<?php endif; ?>
				<?php if ($code === 'gb') : ?>
					<ul class="s-shop-story__terms">
						<?php foreach ($gb_terms as $tm) : ?>
							<li><span aria-hidden="true">—</span><span><?php echo esc_html($tm); ?></span></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<?php
	$related = new WP_Query([
		'post_type'      => 'soul_product',
		'posts_per_page' => 4,
		'post__not_in'   => [$pid],
		'tax_query'      => $col ? [
			[
				'taxonomy' => 'soul_collection',
				'field'    => 'term_id',
				'terms'    => [$col->term_id],
			],
		] : [],
	]);
	if ($related->have_posts()) :
		?>
		<section class="s-shop-related" aria-labelledby="rl-h" data-screen-label="03 Sản phẩm · Liên quan">
			<div class="s-shop-related__head">
				<h2 class="s-shop-related__title" id="rl-h"><?php esc_html_e('Sản phẩm liên quan', 'soul'); ?></h2>
				<a class="s-shop-related__more" href="<?php echo esc_url($col_url); ?>"><?php echo esc_html($col_name); ?> ↗</a>
			</div>
			<ul class="s-shop-related__grid">
				<?php
				while ($related->have_posts()) :
					$related->the_post();
					$r_meta = soul_get_product_meta(get_the_ID());
					$r_kind = soul_shop_product_kind((int) get_the_ID());
					$r_quote = $r_meta['quote_only'];
					?>
					<li>
						<a class="s-shop-related__card" href="<?php the_permalink(); ?>">
							<span class="s-shop-related__media">
								<?php if (has_post_thumbnail()) : ?>
									<?php the_post_thumbnail('medium_large', ['loading' => 'lazy', 'alt' => '']); ?>
								<?php endif; ?>
							</span>
							<span class="s-shop-related__kind"><?php echo esc_html($r_kind); ?></span>
							<span class="s-shop-related__name"><?php the_title(); ?></span>
							<span class="s-shop-related__price">
								<?php echo $r_quote || $r_meta['price'] <= 0 ? esc_html__('Liên hệ', 'soul') : esc_html(soul_format_vnd($r_meta['price'])); ?>
							</span>
						</a>
					</li>
				<?php endwhile; ?>
			</ul>
		</section>
		<?php
		wp_reset_postdata();
	endif;
endwhile;

get_footer();
