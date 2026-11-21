<?php
/**
 * Home HTML fidelity gate — checklist constants for agents / QA.
 * SoT: html/Home.html @ 1920px. One section per gate; measure before approve.
 *
 * @package Soul
 */

declare(strict_types=1);

/**
 * Checklist dimensions every Home section must pass against html/Home.html.
 *
 * @return list<string>
 */
function soul_home_fidelity_checklist(): array {
	return [
		'structure',   // DOM order, columns/cards, same-row vs stack
		'spacing',     // section pad, gaps, intentional margins @1920
		'typography',  // family, size, lh, tracking, weight, transform
		'color',       // surfaces, text, borders, opacity
		'media',       // aspect-ratio, object-fit/position, no WP image margin
		'interaction', // hover, chips aria-pressed, underline offsets
		'wp',          // kill is-layout-flex / default p-h margins in .s-home-*
		'dod',         // computed ≤1px tol + screenshot; human approve before next
	];
}

/**
 * Gate order (slug => pattern / notes).
 *
 * @return array<string, string>
 */
function soul_home_fidelity_gates(): array {
	return [
		'01-hero'       => 'soul/home-hero',
		'02-shop'       => 'soul/home-shop',
		'03-featured'   => 'soul/home-featured',
		'04-story'      => 'soul/home-story',
		'05-awards'     => 'soul/home-awards',
		'06-soulful'    => 'soul/home-soulful',
		'07-solutions'  => 'soul/home-solutions + soul/lead-form',
		'08-visit'      => 'soul/home-visit',
		'09-newsletter' => 'soul/home-newsletter (or NL pattern)',
	];
}

/**
 * New Crop gates — SoT html/New Crop.dc.html (+ Soul - Mua vu moi.html).
 *
 * @return array<string, string>
 */
function soul_newcrop_fidelity_gates(): array {
	return [
		'01-opening'    => 'soul/newcrop-opening-split (alt: opening-full)',
		'02-story'      => 'soul/newcrop-season-story',
		'03-message'    => 'soul/newcrop-message',
		'04-collection' => 'soul/newcrop-collection + flavour-tabs',
		'05-closing'    => 'soul/newcrop-closing',
	];
}
