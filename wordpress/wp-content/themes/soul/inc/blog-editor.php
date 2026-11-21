<?php
/**
 * Blog article CMS ↔ UI: default template, patterns hint, editor canvas class.
 *
 * @package Soul
 */

declare(strict_types=1);

/** Default starter blocks for new posts (unlocked). */
add_action('init', static function (): void {
	$obj = get_post_type_object('post');
	if (! $obj) {
		return;
	}
	$obj->template = [
		[
			'core/paragraph',
			[
				'placeholder' => __('Đoạn mở đầu — kể câu chuyện…', 'soul'),
			],
		],
		[
			'core/heading',
			[
				'level'       => 2,
				'placeholder' => __('Tiêu đề mục', 'soul'),
			],
		],
		[
			'core/paragraph',
			[
				'placeholder' => __('Nội dung mục…', 'soul'),
			],
		],
	];
}, 20);

/** Side guide: Featured Image + Excerpt + patterns (no Custom HTML). */
add_action('add_meta_boxes', static function (): void {
	add_meta_box(
		'soul_blog_cms_guide',
		__('Đăng bài Soul', 'soul'),
		static function (): void {
			echo '<ol style="margin:0;padding-left:1.2em;line-height:1.55;font-size:13px;">';
			echo '<li>' . esc_html__('Tiêu đề → H1 trên trang.', 'soul') . '</li>';
			echo '<li><strong>' . esc_html__('Ảnh đại diện', 'soul') . '</strong> → ' . esc_html__('ảnh bìa (Upload / Thư viện).', 'soul') . '</li>';
			echo '<li><strong>' . esc_html__('Đoạn trích', 'soul') . '</strong> → ' . esc_html__('dòng lead dưới tiêu đề.', 'soul') . '</li>';
			echo '<li>' . esc_html__('Chuyên mục + Tags → chip / sidebar.', 'soul') . '</li>';
			echo '<li>' . esc_html__('Nội dung: Patterns → SOUL Content (Note, Steps, Facts, Apply, List).', 'soul') . '</li>';
			echo '</ol>';
			echo '<p class="description" style="margin-top:10px;">' . esc_html__('Không dùng Custom HTML. Đổi ảnh card listing cũng bằng Ảnh đại diện.', 'soul') . '</p>';
		},
		'post',
		'side',
		'high'
	);
});

/** Editor assets: canvas class + article-only bridge. */
add_action('enqueue_block_editor_assets', static function (): void {
	$screen = function_exists('get_current_screen') ? get_current_screen() : null;
	if (! $screen || $screen->post_type !== 'post') {
		return;
	}
	wp_enqueue_script(
		'soul-blog-editor',
		SOUL_URI . '/assets/js/blog-editor.js',
		['wp-data', 'wp-dom-ready', 'wp-edit-post'],
		SOUL_VERSION,
		true
	);
});

/** Pattern category for article body pieces. */
add_action('init', static function (): void {
	register_block_pattern_category('soul-blog', [
		'label' => __('SOUL Blog Article', 'soul'),
	]);
}, 9);

/**
 * Marketing page patterns → pages only (not post editor).
 * Blog article patterns keep Post Types: post.
 */
add_action('init', static function (): void {
	if (! class_exists('WP_Block_Patterns_Registry')) {
		return;
	}
	$registry = WP_Block_Patterns_Registry::get_instance();
	$page_only_prefixes = [
		'soul/home-',
		'soul/page-',
		'soul/story-',
		'soul/solutions-',
		'soul/newcrop-',
		'soul/help-',
		'soul/spaces-hub',
		'soul/newsletter-band',
		'soul/hero-home',
		'soul/story-split',
		'soul/not-found',
	];
	foreach ($registry->get_all_registered() as $pattern) {
		$name = (string) ($pattern['name'] ?? '');
		if ($name === '' || ! str_starts_with($name, 'soul/')) {
			continue;
		}
		if (str_starts_with($name, 'soul/blog-article') || str_starts_with($name, 'soul/spaces-br')) {
			continue;
		}
		$match = false;
		foreach ($page_only_prefixes as $prefix) {
			if ($name === $prefix || str_starts_with($name, $prefix)) {
				$match = true;
				break;
			}
		}
		if (! $match) {
			continue;
		}
		$types = $pattern['postTypes'] ?? [];
		if (is_array($types) && $types !== [] && ! in_array('post', $types, true)) {
			continue;
		}
		unregister_block_pattern($name);
		$pattern['postTypes'] = ['page'];
		unset($pattern['name']);
		register_block_pattern($name, $pattern);
	}
}, 30);

/** Ensure custom block editor scripts wait on wp.* packages (asset.php fallback). */
add_action('enqueue_block_editor_assets', static function (): void {
	foreach (['soul-lead-form-editor-script', 'soul-add-to-cart-editor-script'] as $handle) {
		if (! wp_script_is($handle, 'registered')) {
			continue;
		}
		$script = wp_scripts()->query($handle);
		if (! $script) {
			continue;
		}
		foreach (['wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components'] as $dep) {
			if (! in_array($dep, $script->deps, true)) {
				$script->deps[] = $dep;
			}
		}
	}
}, 5);
