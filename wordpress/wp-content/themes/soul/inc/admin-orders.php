<?php
/**
 * Orders admin — list ops, detail metabox, KPI/chart enqueue.
 *
 * @package Soul
 */

declare(strict_types=1);

/* ——— Labels / hide Add New ——— */

add_filter(
	'post_type_labels_soul_order',
	static function ( $labels ) {
		$labels->name          = __( 'Đơn hàng', 'soul' );
		$labels->singular_name = __( 'Đơn hàng', 'soul' );
		$labels->edit_item     = __( 'Chi tiết đơn', 'soul' );
		$labels->search_items  = __( 'Tìm đơn hàng', 'soul' );
		$labels->not_found     = __( 'Không có đơn nào.', 'soul' );
		$labels->add_new_item  = __( 'Thêm đơn', 'soul' );
		$labels->add_new       = __( 'Thêm đơn', 'soul' );
		$labels->menu_name     = __( 'Đơn hàng', 'soul' );
		return $labels;
	}
);

add_action(
	'admin_menu',
	static function (): void {
		global $submenu;
		if ( empty( $submenu['edit.php?post_type=soul_order'] ) || ! is_array( $submenu['edit.php?post_type=soul_order'] ) ) {
			return;
		}
		foreach ( $submenu['edit.php?post_type=soul_order'] as $i => $item ) {
			if ( isset( $item[2] ) && $item[2] === 'post-new.php?post_type=soul_order' ) {
				unset( $submenu['edit.php?post_type=soul_order'][ $i ] );
			}
		}
	},
	999
);

add_action(
	'admin_head',
	static function (): void {
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( ! $screen || $screen->post_type !== 'soul_order' ) {
			return;
		}
		echo '<style>.page-title-action{display:none!important}</style>';
	}
);

/* ——— Assets ——— */

add_action(
	'admin_enqueue_scripts',
	static function ( string $hook ): void {
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( ! $screen || $screen->post_type !== 'soul_order' ) {
			return;
		}
		wp_enqueue_style(
			'soul-admin-orders',
			SOUL_URI . '/assets/css/admin-orders.css',
			[],
			SOUL_VERSION
		);
		if ( in_array( $hook, [ 'post.php', 'post-new.php' ], true ) ) {
			wp_enqueue_media();
			wp_enqueue_script(
				'soul-admin-order-paperwork',
				SOUL_URI . '/assets/js/admin-order-paperwork.js',
				[ 'jquery' ],
				SOUL_VERSION,
				true
			);
			wp_localize_script(
				'soul-admin-order-paperwork',
				'soulOrderPaperwork',
				[
					'title'  => __( 'Đính kèm paperwork vào đơn', 'soul' ),
					'button' => __( 'Gắn vào đơn', 'soul' ),
					'remove' => __( 'Gỡ', 'soul' ),
				]
			);
		}
		if ( $hook === 'edit.php' ) {
			wp_enqueue_script(
				'chartjs',
				'https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js',
				[],
				'4.4.1',
				true
			);
			$stats = soul_order_revenue_stats();
			wp_add_inline_script(
				'chartjs',
				'window.soulOrderChart=' . wp_json_encode(
					[
						'labels'  => $stats['chart']['labels'],
						'revenue' => $stats['chart']['revenue'],
						'paid'    => $stats['chart']['paid'],
					]
				) . ';
document.addEventListener("DOMContentLoaded",function(){
  var el=document.getElementById("soul-order-revenue-chart");
  if(!el||!window.Chart||!window.soulOrderChart)return;
  new Chart(el,{type:"bar",data:{labels:soulOrderChart.labels,datasets:[
    {label:"Doanh thu",data:soulOrderChart.revenue,backgroundColor:"rgba(142,75,51,.75)"},
    {label:"Đã thu",data:soulOrderChart.paid,backgroundColor:"rgba(39,41,45,.35)"}
  ]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{position:"bottom"}},scales:{y:{beginAtZero:true,ticks:{callback:function(v){return new Intl.NumberFormat("vi-VN").format(v)+"₫";}}}}}});
});',
				'after'
			);
		}
	}
);

/* ——— List columns ——— */

add_filter(
	'manage_soul_order_posts_columns',
	static function ( array $cols ): array {
		return [
			'cb'              => $cols['cb'] ?? '',
			'soul_code'       => __( 'Mã đơn', 'soul' ),
			'soul_customer'   => __( 'Khách', 'soul' ),
			'soul_payment'    => __( 'Thanh toán', 'soul' ),
			'soul_ship'       => __( 'Giao hàng', 'soul' ),
			'soul_status'     => __( 'Trạng thái', 'soul' ),
			'soul_pay_status' => __( 'Thu tiền', 'soul' ),
			'soul_files'      => __( 'File', 'soul' ),
			'soul_total'      => __( 'Tổng', 'soul' ),
			'date'            => __( 'Ngày', 'soul' ),
		];
	}
);

add_action(
	'manage_soul_order_posts_custom_column',
	static function ( string $col, int $post_id ): void {
		switch ( $col ) {
			case 'soul_code':
				$code = (string) get_post_meta( $post_id, 'soul_order_code', true );
				$url  = get_edit_post_link( $post_id, 'raw' );
				printf(
					'<strong><a href="%s">%s</a></strong>',
					esc_url( (string) $url ),
					esc_html( $code !== '' ? $code : ( 'SOUL-' . $post_id ) )
				);
				break;
			case 'soul_customer':
				$c = get_post_meta( $post_id, 'soul_customer', true );
				if ( ! is_array( $c ) ) {
					$c = [];
				}
				$name  = (string) ( $c['name'] ?? '' );
				$phone = (string) ( $c['phone'] ?? '' );
				$email = (string) ( $c['email'] ?? '' );
				echo '<div class="soul-order-cust">';
				echo '<strong>' . esc_html( $name ) . '</strong>';
				if ( $phone !== '' ) {
					echo '<br><a href="tel:' . esc_attr( preg_replace( '/\s+/', '', $phone ) ?? '' ) . '">' . esc_html( $phone ) . '</a>';
				}
				if ( $email !== '' ) {
					echo '<br><a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>';
				}
				echo '</div>';
				break;
			case 'soul_payment':
				echo esc_html( soul_order_payment_label( (string) get_post_meta( $post_id, 'soul_payment', true ) ) );
				break;
			case 'soul_ship':
				$ship = get_post_meta( $post_id, 'soul_shipping', true );
				$method = is_array( $ship ) ? (string) ( $ship['method'] ?? '' ) : '';
				echo esc_html( soul_order_shipping_label( $method ) );
				break;
			case 'soul_status':
				soul_order_badge( 'status', soul_order_get_status( $post_id ) );
				break;
			case 'soul_pay_status':
				soul_order_badge( 'pay', soul_order_get_payment_status( $post_id ) );
				break;
			case 'soul_files':
				$n = count( soul_order_get_paperwork( $post_id ) );
				if ( $n > 0 ) {
					printf(
						'<span class="soul-file-count" title="%s">📎 %d</span>',
						esc_attr__( 'Paperwork đính kèm', 'soul' ),
						$n
					);
				} else {
					echo '<span class="description">—</span>';
				}
				break;
			case 'soul_total':
				echo esc_html( soul_format_money( (int) get_post_meta( $post_id, 'soul_total', true ) ) );
				break;
		}
	},
	10,
	2
);

add_filter(
	'manage_edit-soul_order_sortable_columns',
	static function ( array $cols ): array {
		$cols['soul_total']  = 'soul_total';
		$cols['soul_status'] = 'soul_status';
		$cols['soul_code']   = 'soul_order_code';
		return $cols;
	}
);

add_filter(
	'post_row_actions',
	static function ( array $actions, WP_Post $post ): array {
		if ( $post->post_type !== 'soul_order' ) {
			return $actions;
		}
		unset( $actions['inline hide-if-no-js'] );
		$edit = get_edit_post_link( $post->ID, 'raw' );
		if ( $edit ) {
			$actions['edit'] = sprintf(
				'<a href="%s">%s</a>',
				esc_url( $edit ),
				esc_html__( 'Xem / Sửa', 'soul' )
			);
		}
		return $actions;
	},
	10,
	2
);

/* ——— Filters ——— */

add_action(
	'restrict_manage_posts',
	static function ( string $post_type ): void {
		if ( $post_type !== 'soul_order' ) {
			return;
		}
		$status = isset( $_GET['soul_status_filter'] ) ? sanitize_text_field( wp_unslash( (string) $_GET['soul_status_filter'] ) ) : '';
		$pay    = isset( $_GET['soul_payment_filter'] ) ? sanitize_text_field( wp_unslash( (string) $_GET['soul_payment_filter'] ) ) : '';
		$pstat  = isset( $_GET['soul_pay_status_filter'] ) ? sanitize_text_field( wp_unslash( (string) $_GET['soul_pay_status_filter'] ) ) : '';
		$from   = isset( $_GET['soul_date_from'] ) ? sanitize_text_field( wp_unslash( (string) $_GET['soul_date_from'] ) ) : '';
		$to     = isset( $_GET['soul_date_to'] ) ? sanitize_text_field( wp_unslash( (string) $_GET['soul_date_to'] ) ) : '';

		echo '<select name="soul_status_filter"><option value="">' . esc_html__( 'Mọi trạng thái', 'soul' ) . '</option>';
		foreach ( soul_order_statuses() as $slug => $label ) {
			printf( '<option value="%s"%s>%s</option>', esc_attr( $slug ), selected( $status, $slug, false ), esc_html( $label ) );
		}
		echo '</select>';

		echo '<select name="soul_payment_filter"><option value="">' . esc_html__( 'Mọi PTTT', 'soul' ) . '</option>';
		foreach ( soul_order_payment_methods() as $slug => $label ) {
			printf( '<option value="%s"%s>%s</option>', esc_attr( $slug ), selected( $pay, $slug, false ), esc_html( $label ) );
		}
		echo '</select>';

		echo '<select name="soul_pay_status_filter"><option value="">' . esc_html__( 'Thu tiền: tất cả', 'soul' ) . '</option>';
		foreach ( soul_order_payment_statuses() as $slug => $label ) {
			printf( '<option value="%s"%s>%s</option>', esc_attr( $slug ), selected( $pstat, $slug, false ), esc_html( $label ) );
		}
		echo '</select>';

		printf(
			'<input type="date" name="soul_date_from" value="%s" title="%s">',
			esc_attr( $from ),
			esc_attr__( 'Từ ngày', 'soul' )
		);
		printf(
			'<input type="date" name="soul_date_to" value="%s" title="%s">',
			esc_attr( $to ),
			esc_attr__( 'Đến ngày', 'soul' )
		);
	}
);

add_action(
	'pre_get_posts',
	static function ( WP_Query $query ): void {
		if ( ! is_admin() || ! $query->is_main_query() ) {
			return;
		}
		if ( ( $query->get( 'post_type' ) ?: '' ) !== 'soul_order' ) {
			return;
		}

		$meta_query = [];

		$status = isset( $_GET['soul_status_filter'] ) ? sanitize_text_field( wp_unslash( (string) $_GET['soul_status_filter'] ) ) : '';
		if ( $status === '' && isset( $_GET['soul_status_view'] ) ) {
			$status = sanitize_text_field( wp_unslash( (string) $_GET['soul_status_view'] ) );
		}
		if ( $status !== '' ) {
			if ( $status === 'confirmed' ) {
				$meta_query[] = [
					'relation' => 'OR',
					[
						'key'   => 'soul_status',
						'value' => 'confirmed',
					],
					[
						'key'   => 'soul_status',
						'value' => 'processing',
					],
				];
			} else {
				$meta_query[] = [
					'key'   => 'soul_status',
					'value' => $status,
				];
			}
		}

		$pay = isset( $_GET['soul_payment_filter'] ) ? sanitize_text_field( wp_unslash( (string) $_GET['soul_payment_filter'] ) ) : '';
		if ( $pay !== '' ) {
			$meta_query[] = [
				'key'   => 'soul_payment',
				'value' => $pay,
			];
		}

		$pstat = isset( $_GET['soul_pay_status_filter'] ) ? sanitize_text_field( wp_unslash( (string) $_GET['soul_pay_status_filter'] ) ) : '';
		if ( $pstat === 'paid' ) {
			$meta_query[] = [
				'key'   => 'soul_payment_status',
				'value' => 'paid',
			];
		} elseif ( $pstat === 'unpaid' ) {
			$meta_query[] = [
				'relation' => 'OR',
				[
					'key'   => 'soul_payment_status',
					'value' => 'unpaid',
				],
				[
					'key'     => 'soul_payment_status',
					'compare' => 'NOT EXISTS',
				],
			];
		}

		if ( $meta_query !== [] ) {
			if ( count( $meta_query ) > 1 ) {
				$meta_query['relation'] = 'AND';
			}
			$query->set( 'meta_query', $meta_query );
		}

		$from = isset( $_GET['soul_date_from'] ) ? sanitize_text_field( wp_unslash( (string) $_GET['soul_date_from'] ) ) : '';
		$to   = isset( $_GET['soul_date_to'] ) ? sanitize_text_field( wp_unslash( (string) $_GET['soul_date_to'] ) ) : '';
		$dq   = [];
		if ( $from !== '' ) {
			$dq['after'] = $from;
		}
		if ( $to !== '' ) {
			$dq['before'] = $to . ' 23:59:59';
		}
		if ( $dq !== [] ) {
			$dq['inclusive'] = true;
			$query->set( 'date_query', [ $dq ] );
		}

		$orderby = $query->get( 'orderby' );
		if ( $orderby === 'soul_total' ) {
			$query->set( 'meta_key', 'soul_total' );
			$query->set( 'orderby', 'meta_value_num' );
		} elseif ( $orderby === 'soul_status' ) {
			$query->set( 'meta_key', 'soul_status' );
			$query->set( 'orderby', 'meta_value' );
		} elseif ( $orderby === 'soul_order_code' ) {
			$query->set( 'meta_key', 'soul_order_code' );
			$query->set( 'orderby', 'meta_value' );
		}
	}
);

/* ——— Views ——— */

add_filter(
	'views_edit-soul_order',
	static function ( array $views ): array {
		$base = admin_url( 'edit.php?post_type=soul_order' );
		$cur  = isset( $_GET['soul_status_view'] ) ? sanitize_text_field( wp_unslash( (string) $_GET['soul_status_view'] ) ) : '';
		$counts = [];
		foreach ( array_keys( soul_order_statuses() ) as $slug ) {
			$counts[ $slug ] = 0;
		}
		$q = new WP_Query(
			[
				'post_type'      => 'soul_order',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'fields'         => 'ids',
				'no_found_rows'  => true,
			]
		);
		foreach ( $q->posts as $pid ) {
			$st = soul_order_get_status( (int) $pid );
			if ( isset( $counts[ $st ] ) ) {
				$counts[ $st ]++;
			}
		}
		$all = array_sum( $counts );
		$out = [
			'all' => sprintf(
				'<a href="%s"%s>%s <span class="count">(%d)</span></a>',
				esc_url( $base ),
				$cur === '' ? ' class="current"' : '',
				esc_html__( 'Tất cả', 'soul' ),
				$all
			),
		];
		foreach ( soul_order_statuses() as $slug => $label ) {
			$url = add_query_arg( 'soul_status_view', $slug, $base );
			$out[ $slug ] = sprintf(
				'<a href="%s"%s>%s <span class="count">(%d)</span></a>',
				esc_url( $url ),
				$cur === $slug ? ' class="current"' : '',
				esc_html( $label ),
				(int) ( $counts[ $slug ] ?? 0 )
			);
		}
		return $out;
	}
);

/* ——— Bulk ——— */

add_filter(
	'bulk_actions-edit-soul_order',
	static function ( array $actions ): array {
		unset( $actions['edit'] );
		foreach ( soul_order_statuses() as $slug => $label ) {
			$actions[ 'soul_set_' . $slug ] = sprintf( __( 'Đặt trạng thái: %s', 'soul' ), $label );
		}
		$actions['soul_mark_paid']   = __( 'Đánh dấu đã thanh toán', 'soul' );
		$actions['soul_mark_unpaid'] = __( 'Đánh dấu chưa thanh toán', 'soul' );
		return $actions;
	}
);

add_filter(
	'handle_bulk_actions-edit-soul_order',
	static function ( string $redirect, string $action, array $post_ids ): string {
		if ( str_starts_with( $action, 'soul_set_' ) ) {
			$status = substr( $action, strlen( 'soul_set_' ) );
			if ( isset( soul_order_statuses()[ $status ] ) ) {
				foreach ( $post_ids as $pid ) {
					$pid = (int) $pid;
					$old = soul_order_get_status( $pid );
					update_post_meta( $pid, 'soul_status', $status );
					soul_order_maybe_email_status_change( $pid, $old, $status );
				}
				$redirect = add_query_arg( 'soul_bulk_status', $status, $redirect );
			}
		} elseif ( $action === 'soul_mark_paid' || $action === 'soul_mark_unpaid' ) {
			$val = $action === 'soul_mark_paid' ? 'paid' : 'unpaid';
			foreach ( $post_ids as $pid ) {
				update_post_meta( (int) $pid, 'soul_payment_status', $val );
			}
			$redirect = add_query_arg( 'soul_bulk_pay', $val, $redirect );
		}
		return $redirect;
	},
	10,
	3
);

add_action(
	'admin_notices',
	static function (): void {
		if ( ! empty( $_GET['soul_bulk_status'] ) ) {
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Đã cập nhật trạng thái đơn.', 'soul' ) . '</p></div>';
		}
		if ( ! empty( $_GET['soul_bulk_pay'] ) ) {
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Đã cập nhật trạng thái thanh toán.', 'soul' ) . '</p></div>';
		}
	}
);

/* ——— KPI + chart: full-width row under filters (inside tablenav, CSS breaks line) ——— */

add_action(
	'manage_posts_extra_tablenav',
	static function ( string $which ): void {
		if ( $which !== 'top' ) {
			return;
		}
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( ! $screen || $screen->id !== 'edit-soul_order' ) {
			return;
		}
		$stats = soul_order_revenue_stats();
		?>
		<div class="soul-order-ops-banner">
			<div class="soul-order-kpis">
				<?php
				$cards = [
					[ __( 'Hôm nay', 'soul' ), $stats['today'] ],
					[ __( '7 ngày', 'soul' ), $stats['d7'] ],
					[ __( '30 ngày', 'soul' ), $stats['d30'] ],
				];
				foreach ( $cards as [ $title, $row ] ) :
					?>
					<div class="soul-order-kpi">
						<div class="soul-order-kpi__label"><?php echo esc_html( $title ); ?></div>
						<div class="soul-order-kpi__count"><?php echo esc_html( (string) $row['count'] ); ?> <?php esc_html_e( 'đơn', 'soul' ); ?></div>
						<div class="soul-order-kpi__rev"><?php echo esc_html( soul_format_money( (int) $row['revenue'] ) ); ?></div>
						<div class="soul-order-kpi__paid"><?php esc_html_e( 'Đã thu', 'soul' ); ?>: <?php echo esc_html( soul_format_money( (int) $row['paid'] ) ); ?></div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="soul-order-chart-wrap">
				<canvas id="soul-order-revenue-chart" height="120" aria-label="<?php esc_attr_e( 'Biểu đồ doanh thu 30 ngày', 'soul' ); ?>"></canvas>
			</div>
		</div>
		<?php
	}
);

/* ——— Detail metabox ——— */

add_action(
	'add_meta_boxes',
	static function (): void {
		remove_meta_box( 'soul_order_detail', 'soul_order', 'normal' );
		add_meta_box(
			'soul_order_detail',
			__( 'Chi tiết đơn hàng', 'soul' ),
			'soul_render_order_metabox',
			'soul_order',
			'normal',
			'high'
		);
		remove_meta_box( 'slugdiv', 'soul_order', 'normal' );
	},
	20
);

add_action(
	'admin_head-post.php',
	static function (): void {
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( ! $screen || $screen->post_type !== 'soul_order' ) {
			return;
		}
		echo '<style>
		#edit-slug-box,#minor-publishing-actions,#misc-publishing-actions .misc-pub-visibility,#misc-publishing-actions .misc-pub-post-status{display:none!important}
		#post-body-content{display:none}
		</style>';
	}
);

/**
 * Ops detail metabox.
 */
function soul_render_order_metabox( WP_Post $post ): void {
	$customer = get_post_meta( $post->ID, 'soul_customer', true );
	$shipping = get_post_meta( $post->ID, 'soul_shipping', true );
	$items    = get_post_meta( $post->ID, 'soul_items', true );
	$vat      = get_post_meta( $post->ID, 'soul_vat', true );
	$status   = soul_order_get_status( $post->ID );
	$pay_st   = soul_order_get_payment_status( $post->ID );
	$payment  = (string) get_post_meta( $post->ID, 'soul_payment', true );
	$subtotal = (int) get_post_meta( $post->ID, 'soul_subtotal', true );
	$discount = (int) get_post_meta( $post->ID, 'soul_discount', true );
	$promo    = (string) get_post_meta( $post->ID, 'soul_code', true );
	$total    = (int) get_post_meta( $post->ID, 'soul_total', true );
	$code     = (string) get_post_meta( $post->ID, 'soul_order_code', true );
	$tracking = (string) get_post_meta( $post->ID, 'soul_tracking', true );
	$notes    = (string) get_post_meta( $post->ID, 'soul_admin_notes', true );

	if ( ! is_array( $customer ) ) {
		$customer = [];
	}
	if ( ! is_array( $shipping ) ) {
		$shipping = [];
	}
	if ( ! is_array( $items ) ) {
		$items = [];
	}
	if ( ! is_array( $vat ) ) {
		$vat = [];
	}

	$ship_fee = (int) ( $shipping['fee'] ?? 0 );
	if ( $subtotal <= 0 ) {
		foreach ( $items as $line ) {
			$subtotal += (int) ( $line['price'] ?? 0 ) * max( 1, (int) ( $line['qty'] ?? 1 ) );
		}
	}

	wp_nonce_field( 'soul_order_meta', 'soul_order_meta_nonce' );
	?>
	<div class="soul-order-admin">
		<div class="soul-order-admin__header">
			<div>
				<div class="soul-order-admin__code"><?php echo esc_html( $code ); ?></div>
				<div class="soul-order-admin__total"><?php echo esc_html( soul_format_money( $total ) ); ?></div>
			</div>
			<div class="soul-order-admin__actions">
				<label><?php esc_html_e( 'Trạng thái', 'soul' ); ?>
					<select name="soul_status">
						<?php foreach ( soul_order_statuses() as $slug => $label ) : ?>
							<option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $status, $slug ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
				</label>
				<label><?php esc_html_e( 'Thu tiền', 'soul' ); ?>
					<select name="soul_payment_status">
						<?php foreach ( soul_order_payment_statuses() as $slug => $label ) : ?>
							<option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $pay_st, $slug ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
				</label>
			</div>
		</div>

		<div class="soul-order-admin__grid">
			<section class="soul-order-card">
				<h3><?php esc_html_e( 'Khách hàng', 'soul' ); ?></h3>
				<p><strong><?php echo esc_html( (string) ( $customer['name'] ?? '' ) ); ?></strong></p>
				<p>
					<?php if ( ! empty( $customer['email'] ) ) : ?>
						<a href="mailto:<?php echo esc_attr( (string) $customer['email'] ); ?>"><?php echo esc_html( (string) $customer['email'] ); ?></a>
					<?php endif; ?>
					<?php if ( ! empty( $customer['phone'] ) ) : ?>
						· <a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', (string) $customer['phone'] ) ?? '' ); ?>"><?php echo esc_html( (string) $customer['phone'] ); ?></a>
					<?php endif; ?>
				</p>
				<p><?php echo esc_html( (string) ( $customer['address'] ?? '' ) ); ?></p>
				<p class="description">
					<?php
					$geo = array_filter(
						[
							(string) ( $customer['ward'] ?? '' ),
							(string) ( $customer['province'] ?? '' ),
							(string) ( $customer['city'] ?? '' ),
							(string) ( $customer['country'] ?? '' ),
						]
					);
					echo esc_html( implode( ' · ', $geo ) );
					?>
				</p>
				<?php if ( ! empty( $customer['note'] ) ) : ?>
					<p><em><?php esc_html_e( 'Ghi chú khách:', 'soul' ); ?></em> <?php echo esc_html( (string) $customer['note'] ); ?></p>
				<?php endif; ?>
			</section>

			<section class="soul-order-card">
				<h3><?php esc_html_e( 'Giao hàng', 'soul' ); ?></h3>
				<p><?php echo esc_html( soul_order_shipping_label( (string) ( $shipping['method'] ?? '' ) ) ); ?></p>
				<p><?php esc_html_e( 'Phí ship', 'soul' ); ?>: <strong><?php echo esc_html( soul_format_money( $ship_fee ) ); ?></strong></p>
				<?php if ( ( $shipping['method'] ?? '' ) === 'pickup' ) : ?>
					<p><?php echo esc_html( (string) ( $shipping['store_name'] ?? '' ) ); ?></p>
					<p class="description"><?php echo esc_html( (string) ( $shipping['store_addr'] ?? '' ) ); ?></p>
				<?php endif; ?>
				<p>
					<label for="soul_tracking"><?php esc_html_e( 'Mã vận đơn / ghi chú giao', 'soul' ); ?></label><br>
					<input type="text" class="widefat" id="soul_tracking" name="soul_tracking" value="<?php echo esc_attr( $tracking ); ?>">
				</p>
			</section>

			<section class="soul-order-card">
				<h3><?php esc_html_e( 'Thanh toán', 'soul' ); ?></h3>
				<p><?php echo esc_html( soul_order_payment_label( $payment ) ); ?> · <?php soul_order_badge( 'pay', $pay_st ); ?></p>
				<?php if ( $promo !== '' ) : ?>
					<p><?php esc_html_e( 'Mã giảm', 'soul' ); ?>: <code><?php echo esc_html( $promo ); ?></code></p>
				<?php endif; ?>
				<?php if ( $payment === 'bank' && function_exists( 'soul_checkout_settings' ) ) : ?>
					<?php $ck = soul_checkout_settings(); ?>
					<p class="description">
						<?php
						echo esc_html(
							trim(
								$ck['bank_name'] . ' · ' . $ck['bank_account'] . ' · ' . $ck['bank_account_name']
							)
						);
						?>
					</p>
				<?php endif; ?>
			</section>

			<?php if ( ! empty( $vat['needed'] ) ) : ?>
				<section class="soul-order-card">
					<h3><?php esc_html_e( 'Xuất hoá đơn VAT', 'soul' ); ?></h3>
					<p><?php echo esc_html( (string) ( $vat['company'] ?? '' ) ); ?></p>
					<p>MST: <?php echo esc_html( (string) ( $vat['tax_id'] ?? '' ) ); ?></p>
					<p><?php echo esc_html( (string) ( $vat['email'] ?? '' ) ); ?></p>
					<p><?php echo esc_html( (string) ( $vat['address'] ?? '' ) ); ?></p>
					<?php if ( ! empty( $vat['buyer'] ) ) : ?>
						<p><?php esc_html_e( 'Người mua', 'soul' ); ?>: <?php echo esc_html( (string) $vat['buyer'] ); ?></p>
					<?php endif; ?>
				</section>
			<?php endif; ?>
		</div>

		<section class="soul-order-card soul-order-card--wide">
			<h3><?php esc_html_e( 'Sản phẩm', 'soul' ); ?></h3>
			<table class="widefat striped soul-order-lines">
				<thead>
					<tr>
						<th></th>
						<th><?php esc_html_e( 'Sản phẩm', 'soul' ); ?></th>
						<th><?php esc_html_e( 'SL', 'soul' ); ?></th>
						<th><?php esc_html_e( 'Đơn giá', 'soul' ); ?></th>
						<th><?php esc_html_e( 'Thành tiền', 'soul' ); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ( $items as $line ) : ?>
					<?php
					$qty  = max( 1, (int) ( $line['qty'] ?? 1 ) );
					$unit = (int) ( $line['price'] ?? 0 );
					$img  = (string) ( $line['img'] ?? '' );
					?>
					<tr>
						<td class="soul-order-lines__img">
							<?php if ( $img !== '' ) : ?>
								<img src="<?php echo esc_url( $img ); ?>" alt="" width="48" height="48">
							<?php endif; ?>
						</td>
						<td>
							<strong><?php echo esc_html( (string) ( $line['name'] ?? '' ) ); ?></strong>
							<?php if ( ! empty( $line['variant'] ) ) : ?>
								<br><span class="description"><?php echo esc_html( (string) $line['variant'] ); ?></span>
							<?php endif; ?>
						</td>
						<td><?php echo esc_html( (string) $qty ); ?></td>
						<td><?php echo esc_html( soul_format_money( $unit ) ); ?></td>
						<td><?php echo esc_html( soul_format_money( $unit * $qty ) ); ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<table class="soul-order-totals">
				<tr><th><?php esc_html_e( 'Tạm tính', 'soul' ); ?></th><td><?php echo esc_html( soul_format_money( $subtotal ) ); ?></td></tr>
				<?php if ( $discount > 0 ) : ?>
					<tr><th><?php esc_html_e( 'Giảm giá', 'soul' ); ?></th><td>−<?php echo esc_html( soul_format_money( $discount ) ); ?></td></tr>
				<?php endif; ?>
				<tr><th><?php esc_html_e( 'Phí giao hàng', 'soul' ); ?></th><td><?php echo esc_html( soul_format_money( $ship_fee ) ); ?></td></tr>
				<tr class="soul-order-totals__grand"><th><?php esc_html_e( 'Tổng cộng', 'soul' ); ?></th><td><?php echo esc_html( soul_format_money( $total ) ); ?></td></tr>
			</table>
		</section>

		<section class="soul-order-card soul-order-card--wide" id="soul-order-paperwork">
			<h3><?php esc_html_e( 'Paperwork / đính kèm', 'soul' ); ?></h3>
			<p class="description"><?php esc_html_e( 'Chỉ admin tải lên (PDF, ảnh biên lai, hợp đồng…). Khách không upload từ checkout.', 'soul' ); ?></p>
			<?php
			$files = soul_order_get_paperwork( $post->ID );
			$file_ids = array_map( static fn( $f ) => (int) $f['id'], $files );
			?>
			<ul class="soul-paperwork-list" data-soul-paperwork-list>
				<?php if ( $files === [] ) : ?>
					<li class="soul-paperwork-empty description"><?php esc_html_e( 'Chưa có file đính kèm.', 'soul' ); ?></li>
				<?php else : ?>
					<?php foreach ( $files as $file ) : ?>
						<li data-id="<?php echo esc_attr( (string) $file['id'] ); ?>">
							<span class="soul-paperwork-type"><?php echo esc_html( soul_order_paperwork_type_label( $file['mime'], $file['url'] ) ); ?></span>
							<a href="<?php echo esc_url( $file['url'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $file['title'] ); ?></a>
							<?php if ( $file['added_at'] !== '' ) : ?>
								<span class="description"><?php echo esc_html( $file['added_at'] ); ?></span>
							<?php endif; ?>
							<button type="button" class="button-link-delete soul-paperwork-remove" data-soul-paperwork-remove><?php esc_html_e( 'Gỡ', 'soul' ); ?></button>
						</li>
					<?php endforeach; ?>
				<?php endif; ?>
			</ul>
			<p>
				<button type="button" class="button" id="soul-paperwork-add"><?php esc_html_e( 'Thêm file từ Media', 'soul' ); ?></button>
			</p>
			<input type="hidden" name="soul_paperwork_ids" id="soul_paperwork_ids" value="<?php echo esc_attr( implode( ',', $file_ids ) ); ?>">
		</section>

		<section class="soul-order-card soul-order-card--wide">
			<h3><?php esc_html_e( 'Ghi chú nội bộ', 'soul' ); ?></h3>
			<?php if ( $notes !== '' ) : ?>
				<pre class="soul-order-notes"><?php echo esc_html( $notes ); ?></pre>
			<?php endif; ?>
			<p>
				<label for="soul_admin_note_new"><?php esc_html_e( 'Thêm ghi chú', 'soul' ); ?></label><br>
				<textarea class="widefat" rows="3" id="soul_admin_note_new" name="soul_admin_note_new" placeholder="<?php esc_attr_e( 'Ghi chú sẽ được thêm vào lịch sử…', 'soul' ); ?>"></textarea>
			</p>
		</section>
	</div>
	<?php
}

add_action(
	'save_post_soul_order',
	static function ( int $post_id ): void {
		if ( ! isset( $_POST['soul_order_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( (string) $_POST['soul_order_meta_nonce'] ) ), 'soul_order_meta' ) ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		$old = soul_order_get_status( $post_id );
		$raw = sanitize_text_field( wp_unslash( (string) ( $_POST['soul_status'] ?? 'new' ) ) );
		$new = soul_order_normalize_status( $raw );
		// Accept legacy processing from old forms.
		if ( $raw === 'processing' ) {
			$new = 'confirmed';
		}
		if ( isset( soul_order_statuses()[ $new ] ) ) {
			update_post_meta( $post_id, 'soul_status', $new );
			soul_order_maybe_email_status_change( $post_id, $old, $new );
		}

		$pay_st = sanitize_text_field( wp_unslash( (string) ( $_POST['soul_payment_status'] ?? 'unpaid' ) ) );
		update_post_meta( $post_id, 'soul_payment_status', $pay_st === 'paid' ? 'paid' : 'unpaid' );

		if ( isset( $_POST['soul_tracking'] ) ) {
			update_post_meta( $post_id, 'soul_tracking', sanitize_text_field( wp_unslash( (string) $_POST['soul_tracking'] ) ) );
		}

		if ( ! empty( $_POST['soul_admin_note_new'] ) ) {
			soul_order_append_admin_note( $post_id, sanitize_textarea_field( wp_unslash( (string) $_POST['soul_admin_note_new'] ) ) );
		}

		if ( isset( $_POST['soul_paperwork_ids'] ) ) {
			$raw_ids = sanitize_text_field( wp_unslash( (string) $_POST['soul_paperwork_ids'] ) );
			$ids     = [];
			if ( $raw_ids !== '' ) {
				$parts = preg_split( '/\s*,\s*/', $raw_ids );
				$ids   = is_array( $parts ) ? $parts : [];
			}
			soul_order_save_paperwork( $post_id, $ids );
		}
	},
	20
);
