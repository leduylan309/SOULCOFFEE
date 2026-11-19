<?php
/**
 * Footer + overlays.
 *
 * @package Soul
 */
$shop = get_post_type_archive_link('soul_product') ?: home_url('/products/');
$checkout = get_permalink((int) get_option('soul_checkout_page_id')) ?: home_url('/checkout/');
?>
</main>
<footer class="soul-footer">
	<div class="soul-footer__grid">
		<div>
			<p class="soul-footer__label"><?php esc_html_e('Shop', 'soul'); ?></p>
			<ul>
				<li><a href="<?php echo esc_url($shop); ?>"><?php esc_html_e('Tất cả sản phẩm', 'soul'); ?></a></li>
				<li><a href="<?php
					$soulful = get_term_by('slug', 'soulful-flavours', 'soul_collection');
					echo esc_url($soulful ? get_term_link($soulful) : $shop);
				?>"><?php esc_html_e('Soulful Collection', 'soul'); ?></a></li>
			</ul>
		</div>
		<div>
			<p class="soul-footer__label"><?php esc_html_e('Khám phá', 'soul'); ?></p>
			<ul>
				<li><a href="<?php echo esc_url(home_url('/our-story/')); ?>"><?php esc_html_e('Câu chuyện của Soul', 'soul'); ?></a></li>
				<li><a href="<?php echo esc_url(get_post_type_archive_link('soul_space') ?: home_url('/spaces/')); ?>"><?php esc_html_e('Cửa hàng', 'soul'); ?></a></li>
				<li><a href="<?php echo esc_url(get_permalink((int) get_option('page_for_posts')) ?: home_url('/blog/')); ?>"><?php esc_html_e('Blog', 'soul'); ?></a></li>
				<li><a href="<?php echo esc_url(home_url('/order-lookup/')); ?>"><?php echo esc_html(soul_t(['vi' => 'Tra cứu đơn', 'en' => 'Order lookup'])); ?></a></li>
			</ul>
		</div>
		<div>
			<p class="soul-footer__label"><?php esc_html_e('Đối tác', 'soul'); ?></p>
			<ul>
				<li><a href="<?php echo esc_url(home_url('/coffee-solutions/')); ?>"><?php esc_html_e('Giải pháp cà phê', 'soul'); ?></a></li>
			</ul>
		</div>
		<div>
			<p class="soul-footer__label"><?php esc_html_e('Hỗ trợ', 'soul'); ?></p>
			<ul>
				<li><a href="<?php echo esc_url(home_url('/help/')); ?>"><?php esc_html_e('Câu hỏi thường gặp', 'soul'); ?></a></li>
				<li><a href="<?php echo esc_url($checkout); ?>"><?php esc_html_e('Giỏ hàng / Đặt hàng', 'soul'); ?></a></li>
			</ul>
		</div>
	</div>
	<p class="soul-footer__tag"><?php esc_html_e('Crafted by Vietnamese Soul. Buôn Ma Thuột, Việt Nam.', 'soul'); ?></p>
</footer>

<div id="soul-search" class="soul-search-overlay" data-component="modal" hidden>
	<button type="button" class="soul-search-overlay__close" data-close aria-label="<?php esc_attr_e('Đóng', 'soul'); ?>">×</button>
	<form class="soul-search-overlay__form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
		<label class="screen-reader-text" for="soul-q"><?php esc_html_e('Tìm kiếm', 'soul'); ?></label>
		<input id="soul-q" type="search" name="s" placeholder="<?php esc_attr_e('Tìm cà phê, cửa hàng, bài viết…', 'soul'); ?>" autofocus>
		<button type="submit" class="soul-btn soul-btn--primary"><?php esc_html_e('Tìm', 'soul'); ?></button>
	</form>
</div>

<div id="mobile-menu" class="soul-mobile-menu" data-component="modal" hidden>
	<button type="button" data-close aria-label="<?php esc_attr_e('Đóng', 'soul'); ?>">×</button>
	<nav aria-label="<?php esc_attr_e('Mobile', 'soul'); ?>">
		<a href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html(soul_t(['vi' => 'Trang chủ', 'en' => 'Home'])); ?></a>
		<a href="<?php echo esc_url($shop); ?>"><?php echo esc_html(soul_t(['vi' => 'Sản phẩm', 'en' => 'Shop'])); ?></a>
		<a href="<?php echo esc_url(get_permalink((int) get_option('page_for_posts')) ?: home_url('/blog/')); ?>"><?php esc_html_e('Blog', 'soul'); ?></a>
		<a href="<?php echo esc_url($checkout); ?>"><?php echo esc_html(soul_t(['vi' => 'Đặt hàng', 'en' => 'Checkout'])); ?></a>
		<a href="<?php echo esc_url(home_url('/order-lookup/')); ?>"><?php echo esc_html(soul_t(['vi' => 'Tra cứu đơn', 'en' => 'Order lookup'])); ?></a>
	</nav>
</div>

<aside id="soul-cart" class="soul-drawer" data-component="cart-drawer" data-scrim="soul-cart-scrim" hidden>
	<header class="soul-drawer__head">
		<strong><?php esc_html_e('Giỏ hàng', 'soul'); ?> (<span data-cart-count>0</span>)</strong>
		<button type="button" data-close aria-label="<?php esc_attr_e('Đóng', 'soul'); ?>">×</button>
	</header>
	<div data-cart-empty class="soul-drawer__empty"><?php esc_html_e('Giỏ hàng đang trống.', 'soul'); ?></div>
	<div data-cart-items class="soul-drawer__items"></div>
	<template data-cart-line>
		<div class="soul-cart-line" data-id="{{id}}">
			<img src="{{img}}" alt="">
			<div>
				<div>{{name}}</div>
				<div class="soul-meta-chain">{{type}}</div>
				<div class="soul-cart-line__qty">
					<button type="button" data-cart-action="dec">−</button>
					<span>{{qty}}</span>
					<button type="button" data-cart-action="inc">+</button>
					<button type="button" data-cart-action="remove"><?php esc_html_e('Xoá', 'soul'); ?></button>
				</div>
			</div>
		</div>
	</template>
	<footer class="soul-drawer__foot">
		<p class="soul-muted"><?php esc_html_e('Không thanh toán online — gửi đơn để Soul xác nhận.', 'soul'); ?></p>
		<a class="soul-btn soul-btn--primary" href="<?php echo esc_url($checkout); ?>"><?php esc_html_e('Gửi đơn hàng', 'soul'); ?></a>
	</footer>
</aside>
<div class="soul-scrim" id="soul-cart-scrim" hidden></div>

<div data-component="toast" class="soul-toast-host"></div>
<?php wp_footer(); ?>
</body>
</html>
