<?php
/**
 * Mega-feature custom fields on Appearance → Menus items.
 *
 * Meta keys (on nav_menu_item post):
 * - _soul_mega_image     attachment ID (preferred)
 * - _soul_mega_image_url fallback / theme asset URL
 * - _soul_mega_eyebrow
 * - _soul_mega_tagline
 * - _soul_mega_cta
 *
 * @package Soul
 */

declare(strict_types=1);

/**
 * @return array{image_id:int,image_url:string,eyebrow:string,tagline:string,cta:string}
 */
function soul_mega_feature_meta( int $item_id ): array {
	$image_id  = (int) get_post_meta( $item_id, '_soul_mega_image', true );
	$image_url = (string) get_post_meta( $item_id, '_soul_mega_image_url', true );
	if ( $image_id > 0 ) {
		$from_att = wp_get_attachment_image_url( $image_id, 'medium_large' );
		if ( is_string( $from_att ) && $from_att !== '' ) {
			$image_url = $from_att;
		}
	}

	return [
		'image_id'  => $image_id,
		'image_url' => $image_url,
		'eyebrow'   => (string) get_post_meta( $item_id, '_soul_mega_eyebrow', true ),
		'tagline'   => (string) get_post_meta( $item_id, '_soul_mega_tagline', true ),
		'cta'       => (string) get_post_meta( $item_id, '_soul_mega_cta', true ),
	];
}

/** Persist mega-feature meta on a menu item (seed + admin). */
function soul_mega_feature_save_meta( int $item_id, array $data ): void {
	if ( $item_id <= 0 ) {
		return;
	}
	if ( array_key_exists( 'image_id', $data ) ) {
		update_post_meta( $item_id, '_soul_mega_image', (int) $data['image_id'] );
	}
	if ( array_key_exists( 'image_url', $data ) ) {
		update_post_meta( $item_id, '_soul_mega_image_url', esc_url_raw( (string) $data['image_url'] ) );
	}
	if ( array_key_exists( 'eyebrow', $data ) ) {
		update_post_meta( $item_id, '_soul_mega_eyebrow', sanitize_text_field( (string) $data['eyebrow'] ) );
	}
	if ( array_key_exists( 'tagline', $data ) ) {
		update_post_meta( $item_id, '_soul_mega_tagline', sanitize_text_field( (string) $data['tagline'] ) );
	}
	if ( array_key_exists( 'cta', $data ) ) {
		update_post_meta( $item_id, '_soul_mega_cta', sanitize_text_field( (string) $data['cta'] ) );
	}
}

add_action(
	'wp_nav_menu_item_custom_fields',
	static function ( $item_id, $item ): void {
		$item_id = (int) $item_id;
		$meta    = soul_mega_feature_meta( $item_id );
		$classes = empty( $item->classes ) ? [] : (array) $item->classes;
		$hint    = in_array( 'mega-feature', $classes, true )
			? __( 'Đang dùng cho cột feature mega (class mega-feature).', 'soul' )
			: __( 'Gắn CSS class “mega-feature” trên item để hiện card feature trong mega Sản phẩm.', 'soul' );
		?>
		<p class="description description-wide soul-mega-fields">
			<strong><?php esc_html_e( 'SOUL mega feature', 'soul' ); ?></strong><br>
			<span class="description"><?php echo esc_html( $hint ); ?></span>
		</p>
		<p class="field-soul-mega-image description description-wide">
			<label for="edit-menu-item-soul-mega-image-<?php echo esc_attr( (string) $item_id ); ?>">
				<?php esc_html_e( 'Feature image URL', 'soul' ); ?><br>
				<input type="url" id="edit-menu-item-soul-mega-image-<?php echo esc_attr( (string) $item_id ); ?>"
					class="widefat code"
					name="menu-item-soul-mega-image-url[<?php echo esc_attr( (string) $item_id ); ?>]"
					value="<?php echo esc_attr( $meta['image_url'] ); ?>">
			</label>
		</p>
		<p class="field-soul-mega-image-id description description-wide">
			<label for="edit-menu-item-soul-mega-image-id-<?php echo esc_attr( (string) $item_id ); ?>">
				<?php esc_html_e( 'Feature image attachment ID (optional)', 'soul' ); ?><br>
				<input type="number" min="0" step="1"
					id="edit-menu-item-soul-mega-image-id-<?php echo esc_attr( (string) $item_id ); ?>"
					class="widefat"
					name="menu-item-soul-mega-image[<?php echo esc_attr( (string) $item_id ); ?>]"
					value="<?php echo esc_attr( (string) $meta['image_id'] ); ?>">
			</label>
		</p>
		<p class="field-soul-mega-eyebrow description description-wide">
			<label for="edit-menu-item-soul-mega-eyebrow-<?php echo esc_attr( (string) $item_id ); ?>">
				<?php esc_html_e( 'Eyebrow', 'soul' ); ?><br>
				<input type="text" id="edit-menu-item-soul-mega-eyebrow-<?php echo esc_attr( (string) $item_id ); ?>"
					class="widefat"
					name="menu-item-soul-mega-eyebrow[<?php echo esc_attr( (string) $item_id ); ?>]"
					value="<?php echo esc_attr( $meta['eyebrow'] ); ?>"
					placeholder="<?php esc_attr_e( 'Mùa vụ mới', 'soul' ); ?>">
			</label>
		</p>
		<p class="field-soul-mega-tagline description description-wide">
			<label for="edit-menu-item-soul-mega-tagline-<?php echo esc_attr( (string) $item_id ); ?>">
				<?php esc_html_e( 'Tagline', 'soul' ); ?><br>
				<input type="text" id="edit-menu-item-soul-mega-tagline-<?php echo esc_attr( (string) $item_id ); ?>"
					class="widefat"
					name="menu-item-soul-mega-tagline[<?php echo esc_attr( (string) $item_id ); ?>]"
					value="<?php echo esc_attr( $meta['tagline'] ); ?>"
					placeholder="Cay · Nồng · Thơm · Ngọt">
			</label>
		</p>
		<p class="field-soul-mega-cta description description-wide">
			<label for="edit-menu-item-soul-mega-cta-<?php echo esc_attr( (string) $item_id ); ?>">
				<?php esc_html_e( 'CTA label', 'soul' ); ?><br>
				<input type="text" id="edit-menu-item-soul-mega-cta-<?php echo esc_attr( (string) $item_id ); ?>"
					class="widefat"
					name="menu-item-soul-mega-cta[<?php echo esc_attr( (string) $item_id ); ?>]"
					value="<?php echo esc_attr( $meta['cta'] ); ?>"
					placeholder="<?php esc_attr_e( 'Khám phá Soulful 2026', 'soul' ); ?>">
			</label>
		</p>
		<?php
	},
	10,
	2
);

add_action(
	'wp_update_nav_menu_item',
	static function ( int $menu_id, int $menu_item_db_id ): void {
		unset( $menu_id );
		// phpcs:ignore WordPress.Security.NonceVerification.Missing -- core menu save already verified.
		$image_id = isset( $_POST['menu-item-soul-mega-image'][ $menu_item_db_id ] )
			? (int) $_POST['menu-item-soul-mega-image'][ $menu_item_db_id ]
			: null;
		// phpcs:ignore WordPress.Security.NonceVerification.Missing
		$image_url = isset( $_POST['menu-item-soul-mega-image-url'][ $menu_item_db_id ] )
			? (string) wp_unslash( $_POST['menu-item-soul-mega-image-url'][ $menu_item_db_id ] )
			: null;
		// phpcs:ignore WordPress.Security.NonceVerification.Missing
		$eyebrow = isset( $_POST['menu-item-soul-mega-eyebrow'][ $menu_item_db_id ] )
			? (string) wp_unslash( $_POST['menu-item-soul-mega-eyebrow'][ $menu_item_db_id ] )
			: null;
		// phpcs:ignore WordPress.Security.NonceVerification.Missing
		$tagline = isset( $_POST['menu-item-soul-mega-tagline'][ $menu_item_db_id ] )
			? (string) wp_unslash( $_POST['menu-item-soul-mega-tagline'][ $menu_item_db_id ] )
			: null;
		// phpcs:ignore WordPress.Security.NonceVerification.Missing
		$cta = isset( $_POST['menu-item-soul-mega-cta'][ $menu_item_db_id ] )
			? (string) wp_unslash( $_POST['menu-item-soul-mega-cta'][ $menu_item_db_id ] )
			: null;

		$data = [];
		if ( $image_id !== null ) {
			$data['image_id'] = $image_id;
		}
		if ( $image_url !== null ) {
			$data['image_url'] = $image_url;
		}
		if ( $eyebrow !== null ) {
			$data['eyebrow'] = $eyebrow;
		}
		if ( $tagline !== null ) {
			$data['tagline'] = $tagline;
		}
		if ( $cta !== null ) {
			$data['cta'] = $cta;
		}
		if ( $data !== [] ) {
			soul_mega_feature_save_meta( $menu_item_db_id, $data );
		}
	},
	10,
	2
);
