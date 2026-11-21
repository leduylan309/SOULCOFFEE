<?php
/**
 * Spaces hub — fidelity vs html/Spaces.dc.html (hub view).
 *
 * @package Soul
 */
get_header();

$home = home_url('/');
$logo = SOUL_URI . '/assets/logo/soul-logo-full-yellow.svg';

$spaces = [];
if (have_posts()) {
	while (have_posts()) {
		the_post();
		$id = (int) get_the_ID();
		$m  = soul_get_space_meta($id);
		$spaces[] = [
			'id'      => $id,
			'title'   => get_the_title(),
			'url'     => get_permalink(),
			'city'    => $m['city'] !== '' ? $m['city'] : get_the_title(),
			'region'  => $m['region'],
			'address' => $m['address'],
			'hours'   => $m['hours'],
			'hotline' => $m['hotline'],
			'map'     => soul_space_map_url($m['map_q']),
			'lead'    => get_the_excerpt(),
			'thumb'   => get_the_post_thumbnail_url($id, 'large') ?: '',
			'alt'     => get_the_title(),
		];
	}
	rewind_posts();
}
$total = count($spaces);
?>
<main class="s-space-hub">
	<section class="s-space-hub-hero" id="top" data-section="spaces-hub-hero" aria-labelledby="hub-h">
		<nav class="s-space-crumb" aria-label="<?php esc_attr_e('Breadcrumb', 'soul'); ?>">
			<a href="<?php echo esc_url($home); ?>"><?php esc_html_e('Trang chủ', 'soul'); ?></a>
			<span class="s-space-crumb__sep" aria-hidden="true">/</span>
			<span><?php esc_html_e('Cửa hàng', 'soul'); ?></span>
		</nav>
		<div class="s-space-hub-hero__grid">
			<div>
				<p class="s-space-eye s-space-eye--bar">Soul Specialty Coffee</p>
				<h1 class="s-space-hub-hero__title" id="hub-h"><?php esc_html_e('Tìm Soul khắp Việt Nam', 'soul'); ?></h1>
			</div>
			<p class="s-space-hub-hero__intro"><?php esc_html_e('Năm không gian, mỗi nơi một nhịp riêng: từ vùng nguyên liệu Buôn Ma Thuột đến Sài Gòn, Hà Nội, Đà Nẵng và Bà Nà. Cùng chung một điều: cà phê Việt ở trung tâm trải nghiệm.', 'soul'); ?></p>
		</div>
		<?php if ($spaces) : ?>
			<ul class="s-space-hub-hero__chips">
				<?php foreach ($spaces as $i => $s) : ?>
					<li>
						<a href="<?php echo esc_url($s['url']); ?>">
							<span class="s-space-n"><?php echo esc_html(str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT)); ?></span>
							<?php echo esc_html($s['city']); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</section>

	<section class="s-space-hub-list" data-section="spaces-hub-list" aria-label="<?php esc_attr_e('Cửa hàng', 'soul'); ?>">
		<?php foreach ($spaces as $i => $s) :
			$n     = str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT);
			$flip  = $i % 2 === 1;
			$paper = $i % 2 === 1;
			$card_class = 's-space-hub-card' . ($flip ? ' s-space-hub-card--flip' : '') . ($paper ? ' s-space-hub-card--paper' : '');
			?>
			<article class="<?php echo esc_attr($card_class); ?>">
				<a class="s-space-hub-card__media" href="<?php echo esc_url($s['url']); ?>" aria-label="<?php echo esc_attr($s['title']); ?>">
					<?php if ($s['thumb']) : ?>
						<img src="<?php echo esc_url($s['thumb']); ?>" alt="<?php echo esc_attr($s['alt']); ?>" loading="lazy" />
					<?php endif; ?>
				</a>
				<div class="s-space-hub-card__copy">
					<div class="s-space-hub-card__meta">
						<span><?php echo esc_html($n . ' / ' . str_pad((string) $total, 2, '0', STR_PAD_LEFT)); ?></span>
						<span class="s-space-muted"><?php echo esc_html($s['region']); ?></span>
					</div>
					<h2 class="s-space-hub-card__title"><?php echo esc_html($s['title']); ?></h2>
					<?php if ($s['lead'] !== '') : ?>
						<p class="s-space-hub-card__lead"><?php echo esc_html($s['lead']); ?></p>
					<?php endif; ?>
					<dl class="s-space-hub-card__facts">
						<?php if ($s['address'] !== '') : ?>
							<div class="s-space-hub-card__fact">
								<dt><?php esc_html_e('Địa chỉ', 'soul'); ?></dt>
								<dd><?php echo esc_html($s['address']); ?></dd>
							</div>
						<?php endif; ?>
						<?php if ($s['hours'] !== '') : ?>
							<div class="s-space-hub-card__fact">
								<dt><?php esc_html_e('Giờ mở cửa', 'soul'); ?></dt>
								<dd><?php echo esc_html($s['hours']); ?></dd>
							</div>
						<?php endif; ?>
						<?php if ($s['hotline'] !== '') : ?>
							<div class="s-space-hub-card__fact">
								<dt><?php esc_html_e('Hotline', 'soul'); ?></dt>
								<dd><?php echo esc_html($s['hotline']); ?></dd>
							</div>
						<?php endif; ?>
					</dl>
					<div class="s-space-hub-card__actions">
						<a class="s-space-btn--ink" href="<?php echo esc_url($s['url']); ?>"><?php esc_html_e('Khám phá không gian', 'soul'); ?> ↗</a>
						<?php if ($s['map'] !== '') : ?>
							<a class="s-space-btn--ghost" href="<?php echo esc_url($s['map']); ?>" target="_blank" rel="noopener"><?php esc_html_e('Chỉ đường', 'soul'); ?></a>
						<?php endif; ?>
					</div>
				</div>
			</article>
		<?php endforeach; ?>
	</section>

	<section class="s-space-hub-close" data-section="spaces-hub-close">
		<img class="s-space-hub-close__logo" src="<?php echo esc_url($logo); ?>" alt="" width="88" height="88" />
		<p class="s-space-hub-close__quote"><?php esc_html_e('Crafted with love & passion', 'soul'); ?></p>
		<p class="s-space-hub-close__tag">Crafted by Vietnamese Soul</p>
	</section>
</main>
<?php
get_footer();
