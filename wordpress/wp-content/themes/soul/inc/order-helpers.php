<?php
/**
 * Order helpers — statuses, labels, money, normalize.
 *
 * @package Soul
 */

declare(strict_types=1);

/**
 * Fulfillment statuses (ops). Legacy `processing` maps to `confirmed`.
 *
 * @return array<string,string> slug => label
 */
function soul_order_statuses(): array {
	return [
		'new'       => __( 'Chờ xác nhận', 'soul' ),
		'confirmed' => __( 'Đã xác nhận', 'soul' ),
		'shipping'  => __( 'Đang giao', 'soul' ),
		'done'      => __( 'Hoàn tất', 'soul' ),
		'cancelled' => __( 'Đã huỷ', 'soul' ),
	];
}

/**
 * @return array<string,string>
 */
function soul_order_payment_statuses(): array {
	return [
		'unpaid' => __( 'Chưa thanh toán', 'soul' ),
		'paid'   => __( 'Đã thanh toán', 'soul' ),
	];
}

/**
 * @return array<string,string>
 */
function soul_order_payment_methods(): array {
	return [
		'cod'     => __( 'COD', 'soul' ),
		'bank'    => __( 'Chuyển khoản', 'soul' ),
		'wallet'  => __( 'Ví điện tử', 'soul' ),
		'contact' => __( 'Liên hệ', 'soul' ),
	];
}

/**
 * @return array<string,string>
 */
function soul_order_shipping_methods(): array {
	return [
		'std'     => __( 'Giao tiêu chuẩn', 'soul' ),
		'exp'     => __( 'Giao nhanh', 'soul' ),
		'pickup'  => __( 'Nhận tại cửa hàng', 'soul' ),
		'intl'    => __( 'Quốc tế', 'soul' ),
		'arrange' => __( 'Thoả thuận', 'soul' ),
	];
}

/** Normalize stored status (processing → confirmed). */
function soul_order_normalize_status( string $status ): string {
	$status = strtolower( trim( $status ) );
	if ( $status === 'processing' ) {
		return 'confirmed';
	}
	$allowed = array_keys( soul_order_statuses() );
	return in_array( $status, $allowed, true ) ? $status : 'new';
}

function soul_order_status_label( string $status ): string {
	$status = soul_order_normalize_status( $status );
	$map    = soul_order_statuses();
	return $map[ $status ] ?? $status;
}

function soul_order_payment_status_label( string $status ): string {
	$status = strtolower( trim( $status ) );
	$map    = soul_order_payment_statuses();
	return $map[ $status ] ?? $map['unpaid'];
}

function soul_order_payment_label( string $method ): string {
	$map = soul_order_payment_methods();
	return $map[ $method ] ?? $method;
}

function soul_order_shipping_label( string $method ): string {
	$map = soul_order_shipping_methods();
	return $map[ $method ] ?? $method;
}

function soul_format_money( int $amount ): string {
	return number_format( $amount, 0, ',', '.' ) . '₫';
}

function soul_order_get_status( int $post_id ): string {
	return soul_order_normalize_status( (string) get_post_meta( $post_id, 'soul_status', true ) );
}

function soul_order_get_payment_status( int $post_id ): string {
	$raw = strtolower( trim( (string) get_post_meta( $post_id, 'soul_payment_status', true ) ) );
	return $raw === 'paid' ? 'paid' : 'unpaid';
}

/**
 * Echo a status/payment badge.
 */
function soul_order_badge( string $kind, string $value ): void {
	if ( $kind === 'status' ) {
		$value = soul_order_normalize_status( $value );
		$label = soul_order_status_label( $value );
		printf(
			'<span class="soul-badge soul-badge--status soul-badge--%s">%s</span>',
			esc_attr( $value ),
			esc_html( $label )
		);
		return;
	}
	$value = $value === 'paid' ? 'paid' : 'unpaid';
	printf(
		'<span class="soul-badge soul-badge--pay soul-badge--%s">%s</span>',
		esc_attr( $value ),
		esc_html( soul_order_payment_status_label( $value ) )
	);
}

/**
 * Append an admin note line (immutable history).
 */
function soul_order_append_admin_note( int $post_id, string $note ): void {
	$note = trim( $note );
	if ( $note === '' ) {
		return;
	}
	$user = wp_get_current_user();
	$who  = $user instanceof WP_User && $user->ID > 0 ? $user->display_name : 'system';
	$line = sprintf( '[%s · %s] %s', wp_date( 'Y-m-d H:i' ), $who, $note );
	$prev = (string) get_post_meta( $post_id, 'soul_admin_notes', true );
	$next = $prev === '' ? $line : $prev . "\n" . $line;
	update_post_meta( $post_id, 'soul_admin_notes', $next );
}

/**
 * Optionally email admin when status changes.
 */
function soul_order_maybe_email_status_change( int $post_id, string $old, string $new ): void {
	if ( $old === $new ) {
		return;
	}
	$settings = function_exists( 'soul_checkout_settings' ) ? soul_checkout_settings() : [];
	if ( empty( $settings['email_on_status_change'] ) ) {
		return;
	}
	$code = (string) get_post_meta( $post_id, 'soul_order_code', true );
	$to   = get_option( 'admin_email' );
	$subj = sprintf( '[SOUL] %s → %s', $code, soul_order_status_label( $new ) );
	$body = sprintf(
		"%s\n%s → %s\n%s",
		$code,
		soul_order_status_label( $old ),
		soul_order_status_label( $new ),
		admin_url( 'post.php?post=' . $post_id . '&action=edit' )
	);
	wp_mail( (string) $to, $subj, $body );
}

/**
 * Admin paperwork attachments for an order.
 *
 * @return list<array{id:int,title:string,url:string,mime:string,added_at:string,added_by:int}>
 */
function soul_order_get_paperwork( int $post_id ): array {
	$raw = get_post_meta( $post_id, 'soul_paperwork', true );
	if ( ! is_array( $raw ) ) {
		return [];
	}
	$out = [];
	foreach ( $raw as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$id = (int) ( $row['id'] ?? 0 );
		if ( $id <= 0 || get_post_type( $id ) !== 'attachment' ) {
			continue;
		}
		$url = wp_get_attachment_url( $id );
		if ( ! is_string( $url ) || $url === '' ) {
			continue;
		}
		$out[] = [
			'id'       => $id,
			'title'    => (string) ( $row['title'] ?? get_the_title( $id ) ),
			'url'      => $url,
			'mime'     => (string) ( get_post_mime_type( $id ) ?: ( $row['mime'] ?? '' ) ),
			'added_at' => (string) ( $row['added_at'] ?? '' ),
			'added_by' => (int) ( $row['added_by'] ?? 0 ),
		];
	}
	return $out;
}

/**
 * Save paperwork list from attachment IDs (admin only).
 *
 * @param list<int|string> $ids
 */
function soul_order_save_paperwork( int $post_id, array $ids ): void {
	$prev_map = [];
	foreach ( soul_order_get_paperwork( $post_id ) as $row ) {
		$prev_map[ $row['id'] ] = $row;
	}
	$user_id = get_current_user_id();
	$now     = wp_date( 'Y-m-d H:i' );
	$out     = [];
	$seen    = [];
	foreach ( $ids as $id ) {
		$id = (int) $id;
		if ( $id <= 0 || isset( $seen[ $id ] ) || get_post_type( $id ) !== 'attachment' ) {
			continue;
		}
		$seen[ $id ] = true;
		if ( isset( $prev_map[ $id ] ) ) {
			$out[] = $prev_map[ $id ];
		} else {
			$out[] = [
				'id'       => $id,
				'title'    => (string) get_the_title( $id ),
				'mime'     => (string) ( get_post_mime_type( $id ) ?: '' ),
				'added_at' => $now,
				'added_by' => $user_id,
			];
			// Organize under the order in Media Library.
			wp_update_post(
				[
					'ID'          => $id,
					'post_parent' => $post_id,
				]
			);
		}
	}
	update_post_meta( $post_id, 'soul_paperwork', $out );
}

/**
 * Human label for mime / extension.
 */
function soul_order_paperwork_type_label( string $mime, string $url = '' ): string {
	if ( str_contains( $mime, 'pdf' ) ) {
		return 'PDF';
	}
	if ( str_starts_with( $mime, 'image/' ) ) {
		return 'Ảnh';
	}
	if ( str_contains( $mime, 'word' ) || str_contains( $mime, 'document' ) ) {
		return 'DOC';
	}
	if ( str_contains( $mime, 'sheet' ) || str_contains( $mime, 'excel' ) ) {
		return 'XLS';
	}
	$ext = strtoupper( pathinfo( wp_parse_url( $url, PHP_URL_PATH ) ?: '', PATHINFO_EXTENSION ) );
	return $ext !== '' ? $ext : 'FILE';
}

/**
 * Revenue stats for KPI / chart.
 *
 * @return array{today:array{count:int,revenue:int,paid:int},d7:array{count:int,revenue:int,paid:int},d30:array{count:int,revenue:int,paid:int},chart:array{labels:list<string>,revenue:list<int>,paid:list<int>}}
 */
function soul_order_revenue_stats(): array {
	$empty = [ 'count' => 0, 'revenue' => 0, 'paid' => 0 ];
	$out   = [
		'today' => $empty,
		'd7'    => $empty,
		'd30'   => $empty,
		'chart' => [
			'labels'  => [],
			'revenue' => [],
			'paid'    => [],
		],
	];

	$q = new WP_Query(
		[
			'post_type'      => 'soul_order',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'date_query'     => [
				[
					'after'     => wp_date( 'Y-m-d', strtotime( '-29 days' ) ),
					'inclusive' => true,
				],
			],
			'fields'         => 'ids',
			'no_found_rows'  => true,
		]
	);

	$by_day = [];
	for ( $i = 29; $i >= 0; $i-- ) {
		$key            = wp_date( 'Y-m-d', strtotime( '-' . $i . ' days' ) );
		$by_day[ $key ] = [ 'revenue' => 0, 'paid' => 0 ];
		$out['chart']['labels'][] = wp_date( 'd/m', strtotime( $key ) );
	}

	$today = wp_date( 'Y-m-d' );
	$d7    = wp_date( 'Y-m-d', strtotime( '-6 days' ) );

	foreach ( $q->posts as $pid ) {
		$pid    = (int) $pid;
		$status = soul_order_get_status( $pid );
		if ( $status === 'cancelled' ) {
			continue;
		}
		$total  = (int) get_post_meta( $pid, 'soul_total', true );
		$paid   = soul_order_get_payment_status( $pid ) === 'paid';
		$day    = get_the_date( 'Y-m-d', $pid );
		if ( isset( $by_day[ $day ] ) ) {
			$by_day[ $day ]['revenue'] += $total;
			if ( $paid ) {
				$by_day[ $day ]['paid'] += $total;
			}
		}
		$bucket = null;
		if ( $day === $today ) {
			$bucket = 'today';
		}
		if ( $day >= $d7 ) {
			$out['d7']['count']++;
			$out['d7']['revenue'] += $total;
			if ( $paid ) {
				$out['d7']['paid'] += $total;
			}
		}
		$out['d30']['count']++;
		$out['d30']['revenue'] += $total;
		if ( $paid ) {
			$out['d30']['paid'] += $total;
		}
		if ( $bucket === 'today' ) {
			$out['today']['count']++;
			$out['today']['revenue'] += $total;
			if ( $paid ) {
				$out['today']['paid'] += $total;
			}
		}
	}

	foreach ( $by_day as $row ) {
		$out['chart']['revenue'][] = $row['revenue'];
		$out['chart']['paid'][]    = $row['paid'];
	}

	return $out;
}
