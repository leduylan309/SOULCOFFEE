<?php
/**
 * Footer + overlays — DS SiteFooter / drawers / search.
 *
 * @package Soul
 */
$shop = get_post_type_archive_link('soul_product') ?: home_url('/products/');
$checkout = get_permalink((int) get_option('soul_checkout_page_id')) ?: home_url('/checkout/');
$soulful = get_term_by('slug', 'soulful-flavours', 'soul_collection');
$soulful_url = ($soulful && ! is_wp_error(get_term_link($soulful))) ? get_term_link($soulful) : $shop;
$spaces = get_post_type_archive_link('soul_space') ?: home_url('/spaces/');
$blog = get_permalink((int) get_option('page_for_posts')) ?: home_url('/blog/');
?>
</main>
<footer class="l-footer soul-footer">
	<div class="l-footer__cols soul-footer__grid">
		<div>
			<img class="l-footer__logo" src="<?php echo esc_url(soul_logo_uri('soul-logo-full-yellow.svg')); ?>" alt="SOUL" width="120" height="auto">
		</div>
		<?php
		if (function_exists('soul_footer_col')) {
			soul_footer_col('footer_shop', __('Shop', 'soul'), [
				[__('Tất cả sản phẩm', 'soul'), $shop],
				[__('Soulful Collection', 'soul'), $soulful_url],
				[__('Mùa vụ mới', 'soul'), home_url('/new-crop/')],
			]);
			soul_footer_col('footer_explore', __('Khám phá', 'soul'), [
				[__('Câu chuyện của Soul', 'soul'), home_url('/our-story/')],
				[__('Cửa hàng', 'soul'), $spaces],
				[__('Blog', 'soul'), $blog],
				[soul_t(['vi' => 'Tra cứu đơn', 'en' => 'Order lookup']), home_url('/order-lookup/')],
			]);
			soul_footer_col('footer_partners', __('Đối tác', 'soul'), [
				[__('Giải pháp cà phê', 'soul'), home_url('/coffee-solutions/')],
				[__('Mua sỉ / liên hệ', 'soul'), home_url('/coffee-solutions/#contact')],
			]);
			soul_footer_col('footer_support', __('Hỗ trợ', 'soul'), [
				[__('Câu hỏi thường gặp', 'soul'), home_url('/help/')],
				[__('Giao hàng', 'soul'), home_url('/help/#shipping')],
				[__('Đổi trả', 'soul'), home_url('/help/#returns')],
				[__('Giỏ hàng / Đặt hàng', 'soul'), $checkout],
			]);
		}
		?>
	</div>
	<div class="l-footer__bar">
		<span><?php echo esc_html(function_exists('soul_contact') ? soul_contact('tagline') : 'Crafted by Vietnamese Soul. Buôn Ma Thuột, Việt Nam.'); ?></span>
		<span>© <?php echo esc_html(gmdate('Y')); ?> SOUL Fine Robusta</span>
	</div>
</footer>

<div id="soul-search" class="soul-search-overlay" data-component="modal" hidden>
	<button type="button" class="soul-search-overlay__close" data-close aria-label="<?php esc_attr_e('Đóng', 'soul'); ?>">×</button>
	<form class="soul-search-overlay__form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
		<label class="screen-reader-text" for="soul-q"><?php esc_html_e('Tìm kiếm', 'soul'); ?></label>
		<input id="soul-q" class="c-search-field c-search-field--hero" type="search" name="s" placeholder="<?php esc_attr_e('Tìm cà phê, cửa hàng, bài viết…', 'soul'); ?>" autofocus>
		<button type="submit" class="c-btn"><?php esc_html_e('Tìm', 'soul'); ?></button>
	</form>
</div>

<div id="mobile-menu" class="soul-mobile-menu c-mobile-menu" data-component="modal" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e('Menu', 'soul'); ?>" hidden>
	<div class="soul-mobile-menu__head">
		<img src="<?php echo esc_url(soul_logo_uri('soul-wordmark-ink.svg')); ?>" alt="SOUL" height="15" width="auto">
		<button type="button" class="c-icon-btn soul-mobile-menu__close" data-close aria-label="<?php esc_attr_e('Đóng', 'soul'); ?>">×</button>
	</div>
	<nav class="soul-mobile-menu__nav" aria-label="<?php esc_attr_e('Mobile', 'soul'); ?>">
		<?php if (has_nav_menu('primary')) : ?>
			<?php
			wp_nav_menu([
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'soul-mobile-menu__list',
				'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
				'depth'          => 3,
				'fallback_cb'    => false,
				'walker'         => class_exists('Soul_Mobile_Walker') ? new Soul_Mobile_Walker() : null,
			]);
			?>
			<ul class="soul-mobile-menu__list soul-mobile-menu__list--extra">
				<li><a href="<?php echo esc_url(home_url('/account/')); ?>"><?php echo esc_html(soul_t(['vi' => 'Tài khoản', 'en' => 'Account'])); ?></a></li>
				<li><a href="<?php echo esc_url(home_url('/help/')); ?>"><?php echo esc_html(soul_t(['vi' => 'Hỗ trợ', 'en' => 'Help'])); ?></a></li>
				<li><a href="<?php echo esc_url(home_url('/order-lookup/')); ?>"><?php echo esc_html(soul_t(['vi' => 'Tra cứu đơn', 'en' => 'Order lookup'])); ?></a></li>
			</ul>
		<?php else : ?>
			<a href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html(soul_t(['vi' => 'Trang chủ', 'en' => 'Home'])); ?></a>
			<a href="<?php echo esc_url($shop); ?>"><?php echo esc_html(soul_t(['vi' => 'Sản phẩm', 'en' => 'Shop'])); ?></a>
			<a href="<?php echo esc_url(home_url('/new-crop/')); ?>"><?php echo esc_html(soul_t(['vi' => 'Mùa vụ mới', 'en' => 'New Crop'])); ?></a>
			<a href="<?php echo esc_url(home_url('/our-story/')); ?>"><?php echo esc_html(soul_t(['vi' => 'Về Soul', 'en' => 'Our Story'])); ?></a>
			<a href="<?php echo esc_url(home_url('/coffee-solutions/')); ?>"><?php echo esc_html(soul_t(['vi' => 'Giải pháp cà phê', 'en' => 'Coffee Solutions'])); ?></a>
			<a href="<?php echo esc_url($spaces); ?>"><?php echo esc_html(soul_t(['vi' => 'Cửa hàng', 'en' => 'Spaces'])); ?></a>
			<a href="<?php echo esc_url($blog); ?>"><?php esc_html_e('Blog', 'soul'); ?></a>
			<a href="<?php echo esc_url(home_url('/account/')); ?>"><?php echo esc_html(soul_t(['vi' => 'Tài khoản', 'en' => 'Account'])); ?></a>
			<a href="<?php echo esc_url(home_url('/help/')); ?>"><?php echo esc_html(soul_t(['vi' => 'Hỗ trợ', 'en' => 'Help'])); ?></a>
			<a href="<?php echo esc_url(home_url('/order-lookup/')); ?>"><?php echo esc_html(soul_t(['vi' => 'Tra cứu đơn', 'en' => 'Order lookup'])); ?></a>
		<?php endif; ?>
	</nav>
</div>

<aside id="soul-cart" class="soul-drawer" data-component="cart-drawer" data-scrim="soul-cart-scrim" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e('Giỏ hàng', 'soul'); ?>" hidden>
	<header class="soul-drawer__head">
		<div class="soul-drawer__title">
			<?php esc_html_e('Giỏ hàng', 'soul'); ?>
			<span class="soul-drawer__count">(<span data-cart-count>0</span>)</span>
		</div>
		<button type="button" class="soul-drawer__close" data-close aria-label="<?php esc_attr_e('Đóng', 'soul'); ?>">×</button>
	</header>
	<div class="soul-drawer__body">
		<div data-cart-empty class="soul-drawer__empty">
			<p class="soul-drawer__empty-title"><?php esc_html_e('Giỏ hàng đang trống.', 'soul'); ?></p>
			<a class="soul-drawer__empty-link" href="<?php echo esc_url($shop); ?>" data-close><?php esc_html_e('Mua cà phê', 'soul'); ?> ↗</a>
		</div>
		<div data-cart-items class="soul-drawer__items"></div>
		<template data-cart-line>
			<div class="soul-cart-line" data-id="{{id}}">
				<img class="soul-cart-line__img" src="{{img}}" alt="">
				<div class="soul-cart-line__info">
					<div class="soul-cart-line__name">{{name}}</div>
					<div class="soul-cart-line__type">{{type}}</div>
					<div class="soul-cart-line__stepper" role="group" aria-label="<?php esc_attr_e('Số lượng', 'soul'); ?>">
						<button type="button" data-cart-action="dec" aria-label="−">−</button>
						<span>{{qty}}</span>
						<button type="button" data-cart-action="inc" aria-label="+">+</button>
					</div>
				</div>
				<button type="button" class="soul-cart-line__remove" data-cart-action="remove"><?php esc_html_e('Xoá', 'soul'); ?></button>
			</div>
		</template>
	</div>
	<footer class="soul-drawer__foot">
		<p class="soul-drawer__note"><?php echo esc_html(function_exists('soul_contact') ? soul_contact('cart_note') : 'Không thanh toán online — gửi đơn để Soul xác nhận.'); ?></p>
		<a class="soul-drawer__cta" href="<?php echo esc_url($checkout); ?>#checkout"><?php esc_html_e('Gửi đơn hàng', 'soul'); ?></a>
		<a class="soul-drawer__view" href="<?php echo esc_url($checkout); ?>"><?php esc_html_e('Xem giỏ', 'soul'); ?></a>
	</footer>
</aside>
<div class="soul-scrim" id="soul-cart-scrim" hidden></div>

<div data-component="toast" class="soul-toast-host"></div>
<?php wp_footer(); ?>
</body>
</html>
