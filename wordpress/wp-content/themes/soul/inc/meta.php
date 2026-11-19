<?php
/**
 * Helpers.
 *
 * @package Soul
 */

declare(strict_types=1);

function soul_format_vnd(int $amount): string {
	return number_format($amount, 0, ',', '.') . '₫';
}

function soul_theme_img(string $relative): string {
	return SOUL_URI . '/assets/images/' . ltrim($relative, '/');
}

function soul_logo_uri(string $file): string {
	return SOUL_URI . '/assets/logo/' . ltrim($file, '/');
}
