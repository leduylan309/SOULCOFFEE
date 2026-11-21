<?php
/**
 * Gutenberg HTML for marketing pages (seeded, then editable).
 *
 * @package Soul
 */

declare(strict_types=1);

function soul_url_shop(): string {
	return esc_url(get_post_type_archive_link('soul_product') ?: home_url('/products/'));
}

function soul_url_soulful(): string {
	$t = get_term_by('slug', 'soulful-flavours', 'soul_collection');
	return esc_url($t ? get_term_link($t) : soul_url_shop());
}

function soul_url_spaces(): string {
	return esc_url(get_post_type_archive_link('soul_space') ?: home_url('/spaces/'));
}

/**
 * Compose page content from theme pattern files (PHP patterns rendered once).
 *
 * @param list<string> $slugs Pattern slugs without soul/ prefix file stem.
 */
function soul_compose_patterns(array $slugs): string {
	$out = '';
	foreach ($slugs as $slug) {
		$file = SOUL_DIR . '/patterns/' . $slug . '.php';
		if (! is_readable($file)) {
			continue;
		}
		ob_start();
		include $file;
		$chunk = (string) ob_get_clean();
		// Strip pattern file docblock headers already closed before markup.
		$out .= trim($chunk) . "\n\n";
	}
	return $out;
}

function soul_home_full_content(): string {
	return soul_compose_patterns([
		'home-hero',
		'home-shop',
		'home-featured',
		'home-story',
		'home-awards',
		'home-soulful',
		'home-solutions',
		'home-visit',
		'newsletter-band',
	]);
}

function soul_page_our_story_content(): string {
	return soul_compose_patterns([
		'story-hero',
		'story-manifesto',
		'story-how',
		'story-team',
		'story-fine-robusta',
		'story-channels',
		'story-timeline',
		'story-next',
		'newsletter-band',
	]);
}

function soul_page_solutions_content(): string {
	return soul_compose_patterns([
		'solutions-hero',
		'solutions-capacity',
		'solutions-services',
		'solutions-partners',
		'solutions-contact',
	]);
}

/** Alias for seed / catalog naming. */
function soul_page_coffee_solutions_content(): string {
	return soul_page_solutions_content();
}

function soul_page_help_content(): string {
	return soul_compose_patterns([
		'help-hero',
		'help-faq',
		'help-policy',
		'help-contact',
	]);
}

function soul_page_new_crop_content(): string {
	// SoT default hero = split (New Crop.dc.html heroSplit). Full-bleed pattern stays available to swap in editor.
	return soul_compose_patterns([
		'newcrop-opening-split',
		'newcrop-season-story',
		'newcrop-message',
		'newcrop-collection',
		'newcrop-closing',
	]);
}
