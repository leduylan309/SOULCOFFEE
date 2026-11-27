<?php
/**
 * Product story fidelity — body content only (right column). Unwrap frames if any.
 *
 * @package Soul
 */

declare(strict_types=1);

add_action('init', 'soul_run_seed_shop_fidelity', 81);

/** Extract inner blocks of .s-shop-story__body from a framed post_content. */
function soul_shop_unwrap_story_frame(string $raw): string {
	if (! str_contains($raw, 's-shop-story__grid') && ! str_contains($raw, 's-shop-story__aside')) {
		return $raw;
	}
	$blocks = parse_blocks($raw);
	$found  = static function (array $list) use (&$found): ?array {
		foreach ($list as $block) {
			$cls = (string) ($block['attrs']['className'] ?? '');
			if (($block['blockName'] ?? '') === 'core/group' && str_contains($cls, 's-shop-story__body')) {
				return $block['innerBlocks'] ?? [];
			}
			if (! empty($block['innerBlocks'])) {
				$hit = $found($block['innerBlocks']);
				if ($hit !== null) {
					return $hit;
				}
			}
		}
		return null;
	};
	$inner = $found($blocks);
	if ($inner === null) {
		return $raw;
	}
	return trim(serialize_blocks($inner));
}

function soul_run_seed_shop_fidelity(): void {
	if (get_option('soul_seeded_shop_story_v4')) {
		return;
	}

	$phin_img = esc_url(get_theme_file_uri('assets/images/02-featured/phin_finero.jpg'));
	$esp_img  = esc_url(get_theme_file_uri('assets/images/02-featured/espresso_fine_ro.jpg'));
	$cup_img  = esc_url(get_theme_file_uri('assets/images/03b-why-soul/web/why-cupping.jpg'));
	$farm_img = esc_url(get_theme_file_uri('assets/images/03b-why-soul/web/why-fermentation.jpg'));

	$bodies = [
		'ca-phe-fine-robusta-buon-ma-thuot-pha-phin' => <<<HTML
<!-- wp:paragraph {"className":"s-shop-story__lead is-style-shop-lead"} -->
<p class="s-shop-story__lead is-style-shop-lead">Fine Robusta Buôn Ma Thuột — rang cho phin Việt.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-shop-story__tasting is-style-shop-tasting"} -->
<p class="s-shop-story__tasting is-style-shop-tasting"><strong>Hương vị:</strong> Cacao, mật ong, ca-ra-men, đậm ngọt.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-shop-story__p"} -->
<p class="s-shop-story__p">Chọn lọc theo mùa vụ, sơ chế Natural và rang tại xưởng Soul để giữ body dày cùng hậu ngọt ổn định trên phin.</p>
<!-- /wp:paragraph -->

<!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"s-shop-story__figure is-style-shop-figure"} -->
<figure class="wp-block-image size-large s-shop-story__figure is-style-shop-figure"><img src="{$phin_img}" alt=""/><figcaption class="wp-element-caption">Origin Vietnamese Phin — Fine Robusta</figcaption></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"s-shop-story__p"} -->
<p class="s-shop-story__p">Nguyên hạt giữ hương lâu hơn nếu bạn có máy xay. Chọn xay sẵn khi pha phin hàng ngày — Soul xay theo độ mịn phù hợp.</p>
<!-- /wp:paragraph -->
HTML
		,
		'ca-phe-fine-robusta-buon-ma-thuot-pha-may'  => <<<HTML
<!-- wp:paragraph {"className":"s-shop-story__lead is-style-shop-lead"} -->
<p class="s-shop-story__lead is-style-shop-lead">Fine Robusta rang espresso — body dày, hậu ngọt ổn định.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-shop-story__p"} -->
<p class="s-shop-story__p">Profile rang cho máy: cacao và caramel rõ trên mọi shot. Giữ nguyên hạt, xay sát lúc pha.</p>
<!-- /wp:paragraph -->

<!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"s-shop-story__figure is-style-shop-figure"} -->
<figure class="wp-block-image size-large s-shop-story__figure is-style-shop-figure"><img src="{$esp_img}" alt=""/></figure>
<!-- /wp:image -->
HTML
		,
		'vietnam-specialty-liberica-natural-dak-lak'  => <<<HTML
<!-- wp:paragraph {"className":"s-shop-story__tasting is-style-shop-tasting"} -->
<p class="s-shop-story__tasting is-style-shop-tasting">Vỏ cam, chanh dây, lá xá xị, gợi vị đào</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"className":"s-shop-story__split is-style-shop-split"} -->
<div class="wp-block-columns s-shop-story__split is-style-shop-split"><!-- wp:column {"width":"58%"} -->
<div class="wp-block-column" style="flex-basis:58%"><!-- wp:heading {"level":3,"className":"s-shop-story__h"} -->
<h3 class="wp-block-heading s-shop-story__h">Rang theo cách pha</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-shop-story__p"} -->
<p class="s-shop-story__p">Profile rang được tinh chỉnh cho từng dụng cụ: phin, máy espresso, pour over hay cold brew — giữ body và độ ngọt phù hợp.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"42%"} -->
<div class="wp-block-column" style="flex-basis:42%"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"s-shop-story__figure is-style-shop-figure"} -->
<figure class="wp-block-image size-large s-shop-story__figure is-style-shop-figure"><img src="{$cup_img}" alt=""/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"className":"s-shop-story__split is-style-shop-split"} -->
<div class="wp-block-columns s-shop-story__split is-style-shop-split"><!-- wp:column {"width":"42%"} -->
<div class="wp-block-column" style="flex-basis:42%"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"s-shop-story__figure is-style-shop-figure"} -->
<figure class="wp-block-image size-large s-shop-story__figure is-style-shop-figure"><img src="{$farm_img}" alt=""/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"58%"} -->
<div class="wp-block-column" style="flex-basis:58%"><!-- wp:heading {"level":3,"className":"s-shop-story__h"} -->
<h3 class="wp-block-heading s-shop-story__h">Từ nông hộ đến tách cà</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"s-shop-story__p"} -->
<p class="s-shop-story__p">Soul làm việc trực tiếp với vùng trồng Fine Robusta, theo dõi sơ chế và rang theo từng lô để giữ ổn định hương vị trên mọi túi.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"s-shop-story__p"} -->
<p class="s-shop-story__p">Mỗi mùa vụ là một chương mới — cùng một tinh thần: cà phê Việt được kể rõ nguồn gốc.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
HTML
		,
	];

	$q = new WP_Query([
		'post_type'      => 'soul_product',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'fields'         => 'ids',
	]);

	foreach ($q->posts as $pid) {
		$pid  = (int) $pid;
		$slug = (string) get_post_field('post_name', $pid);
		$raw  = (string) get_post_field('post_content', $pid);

		if (isset($bodies[ $slug ])) {
			$content = $bodies[ $slug ];
		} else {
			$content = soul_shop_unwrap_story_frame($raw);
		}

		if ($content !== $raw) {
			wp_update_post([
				'ID'           => $pid,
				'post_content' => $content,
			]);
		}
	}

	update_option('soul_seeded_shop_story_v1', 1);
	update_option('soul_seeded_shop_story_v2', 1);
	update_option('soul_seeded_shop_story_v3', 1);
	update_option('soul_seeded_shop_story_v4', 1);
}
