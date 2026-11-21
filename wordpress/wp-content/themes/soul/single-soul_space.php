<?php
/**
 * Single space / branch — fidelity vs html/Spaces.dc.html (branch view).
 *
 * @package Soul
 */
get_header();

while (have_posts()) :
	the_post();
	$id      = (int) get_the_ID();
	$m       = soul_get_space_meta($id);
	$map     = soul_space_map_url($m['map_q']);
	$menu    = $m['menu_url'];
	$city    = $m['city'] !== '' ? $m['city'] : get_the_title();
	$lead    = get_the_excerpt();
	$gallery = soul_get_space_gallery_urls($id);
	$thumb   = get_the_post_thumbnail_url($id, 'large') ?: '';
	$home    = home_url('/');
	$hub     = get_post_type_archive_link('soul_space') ?: home_url('/spaces/');
	$name    = get_the_title();

	$others = get_posts([
		'post_type'      => 'soul_space',
		'posts_per_page' => 20,
		'post__not_in'   => [$id],
		'orderby'        => ['menu_order' => 'ASC', 'title' => 'ASC'],
		'post_status'    => 'publish',
	]);
	?>
	<main class="s-space-br">
		<section class="s-space-br-hero" id="top" data-section="space-br-hero" aria-labelledby="br-h">
			<div class="s-space-br-hero__copy">
				<nav class="s-space-crumb" aria-label="<?php esc_attr_e('Breadcrumb', 'soul'); ?>">
					<a href="<?php echo esc_url($home); ?>"><?php esc_html_e('Trang chủ', 'soul'); ?></a>
					<span class="s-space-crumb__sep" aria-hidden="true">/</span>
					<a href="<?php echo esc_url($hub); ?>"><?php esc_html_e('Cửa hàng', 'soul'); ?></a>
					<span class="s-space-crumb__sep" aria-hidden="true">/</span>
					<span><?php echo esc_html($city); ?></span>
				</nav>
				<div>
					<p class="s-space-eye s-space-eye--bar">Soul Space · <?php echo esc_html($m['region']); ?></p>
					<h1 class="s-space-br-hero__title" id="br-h"><?php echo esc_html($name); ?></h1>
				</div>
				<div class="s-space-br-hero__panel">
					<p class="s-space-br-hero__panel-label">Specialty Coffee</p>
					<dl class="s-space-br-hero__facts">
						<?php if ($m['address'] !== '') : ?>
							<div class="s-space-br-hero__fact">
								<dt><?php esc_html_e('Địa chỉ', 'soul'); ?></dt>
								<dd><?php echo esc_html($m['address']); ?></dd>
							</div>
						<?php endif; ?>
						<?php if ($m['hours'] !== '') : ?>
							<div class="s-space-br-hero__fact">
								<dt><?php esc_html_e('Giờ mở cửa', 'soul'); ?></dt>
								<dd><?php echo esc_html($m['hours']); ?></dd>
							</div>
						<?php endif; ?>
						<?php if ($m['hotline'] !== '') : ?>
							<div class="s-space-br-hero__fact">
								<dt><?php esc_html_e('Hotline', 'soul'); ?></dt>
								<dd><?php echo esc_html($m['hotline']); ?></dd>
							</div>
						<?php endif; ?>
					</dl>
					<div class="s-space-br-hero__actions">
						<?php if ($menu !== '') : ?>
							<a class="s-space-btn--ink" href="<?php echo esc_url($menu); ?>" target="_blank" rel="noopener"><?php esc_html_e('Xem menu', 'soul'); ?> ↗</a>
						<?php endif; ?>
						<?php if ($map !== '') : ?>
							<a class="s-space-btn--ghost" href="<?php echo esc_url($map); ?>" target="_blank" rel="noopener"><?php esc_html_e('Chỉ đường', 'soul'); ?></a>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<figure class="s-space-br-hero__media">
				<?php if ($thumb) : ?>
					<img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($name); ?>" loading="eager" />
				<?php endif; ?>
			</figure>
		</section>

		<section class="s-space-br-about" data-section="space-br-about" aria-labelledby="ab-h">
			<div class="s-space-br-about__grid">
				<div>
					<p class="s-space-eye"><?php esc_html_e('Khám phá', 'soul'); ?></p>
					<h2 class="s-space-br-about__h2" id="ab-h"><?php esc_html_e('Về không gian', 'soul'); ?></h2>
				</div>
				<div>
					<?php if ($lead !== '') : ?>
						<p class="s-space-br-about__lead"><?php echo esc_html($lead); ?></p>
					<?php endif; ?>
					<?php
					$content = get_the_content();
					$content = apply_filters('the_content', $content);
					$content = str_replace(']]>', ']]&gt;', $content);
					// Normalize WP paragraphs to about body class.
					$content = preg_replace('/<p(\s[^>]*)?>/', '<p class="s-space-br-about__body"$1>', $content) ?? $content;
					echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>
				</div>
			</div>
		</section>

		<section
			class="s-space-br-gallery"
			data-section="space-br-gallery"
			data-component="lightbox"
			data-label="<?php echo esc_attr($name); ?>"
			aria-labelledby="gl-h"
		>
			<div class="s-space-br-gallery__head">
				<div>
					<p class="s-space-eye s-space-eye--yellow">Inside Soul</p>
					<h2 class="s-space-br-gallery__h2" id="gl-h"><?php echo esc_html(sprintf(/* translators: space name */ __('Bên trong %s', 'soul'), $name)); ?></h2>
				</div>
				<p class="s-space-br-gallery__count"><?php echo esc_html(str_pad((string) count($gallery), 2, '0', STR_PAD_LEFT)); ?> <?php esc_html_e('ảnh', 'soul'); ?></p>
			</div>
			<?php if ($gallery) : ?>
				<ul class="s-space-br-gallery__grid">
					<?php foreach ($gallery as $gi => $gurl) :
						$gal_label = $name . ' · ' . str_pad((string) ($gi + 1), 2, '0', STR_PAD_LEFT);
						?>
						<li>
							<button
								type="button"
								class="s-space-br-gallery__item"
								data-lightbox-item
								data-src="<?php echo esc_url($gurl); ?>"
								aria-label="<?php echo esc_attr($gal_label); ?>"
							>
								<img src="<?php echo esc_url($gurl); ?>" alt="<?php echo esc_attr($gal_label); ?>" loading="lazy" />
							</button>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php else : ?>
				<div class="s-space-br-gallery__empty"><?php esc_html_e('Bộ ảnh không gian đang được cập nhật.', 'soul'); ?></div>
			<?php endif; ?>
		</section>

		<section class="s-space-br-others" data-section="space-br-others" aria-labelledby="ot-h">
			<div class="s-space-br-others__head">
				<h2 class="s-space-br-others__h2" id="ot-h"><?php esc_html_e('Các không gian khác', 'soul'); ?></h2>
				<a class="s-space-br-others__all" href="<?php echo esc_url($hub); ?>"><?php esc_html_e('Tất cả cửa hàng', 'soul'); ?> ↗</a>
			</div>
			<?php if ($others) : ?>
				<ul class="s-space-br-others__grid">
					<?php foreach ($others as $o) :
						$om   = soul_get_space_meta((int) $o->ID);
						$othumb = get_the_post_thumbnail_url($o->ID, 'medium_large') ?: '';
						?>
						<li>
							<a href="<?php echo esc_url(get_permalink($o)); ?>">
								<span class="s-space-br-others__media">
									<?php if ($othumb) : ?>
										<img src="<?php echo esc_url($othumb); ?>" alt="<?php echo esc_attr($o->post_title); ?>" loading="lazy" />
									<?php endif; ?>
								</span>
								<span class="s-space-br-others__cap">
									<span class="s-space-br-others__name"><?php echo esc_html($o->post_title); ?></span>
									<span class="s-space-br-others__meta"><?php echo esc_html($om['region']); ?></span>
								</span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</section>
	</main>
	<?php
endwhile;

get_footer();
