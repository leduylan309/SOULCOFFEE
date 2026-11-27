<?php
/**
 * REST: account auth + dashboard (login / register / recover / profile / addresses / orders).
 * SoT: html/Account.dc.html
 *
 * @package Soul
 */

declare(strict_types=1);

/** @return array{id:int,email:string,name:string,phone:string,marketing:bool,addresses:array<int,array<string,mixed>>} */
function soul_account_user_payload(\WP_User $user): array {
	$addresses = get_user_meta($user->ID, 'soul_addresses', true);
	if (! is_array($addresses)) {
		$addresses = [];
	}
	return [
		'id'         => $user->ID,
		'email'      => $user->user_email,
		'name'       => $user->display_name ?: $user->user_login,
		'phone'      => (string) get_user_meta($user->ID, 'soul_phone', true),
		'marketing'  => (bool) get_user_meta($user->ID, 'soul_marketing', true),
		'addresses'  => array_values($addresses),
	];
}

/** Map WP soul_status → SoT numeric status. */
function soul_account_status_code(string $status): int {
	if (function_exists('soul_order_normalize_status')) {
		$status = soul_order_normalize_status($status);
	}
	return match ($status) {
		'confirmed', 'processing', 'shipping' => 2,
		'done'       => 3,
		'cancelled'  => -1,
		default      => 0, // new
	};
}

/**
 * @return array<string,mixed>|null
 */
function soul_account_serialize_order(int $post_id): ?array {
	$post = get_post($post_id);
	if (! $post || $post->post_type !== 'soul_order') {
		return null;
	}
	$customer = get_post_meta($post_id, 'soul_customer', true);
	$shipping = get_post_meta($post_id, 'soul_shipping', true);
	$items    = get_post_meta($post_id, 'soul_items', true);
	$status   = function_exists('soul_order_get_status')
		? soul_order_get_status($post_id)
		: (string) get_post_meta($post_id, 'soul_status', true);
	$code     = (string) get_post_meta($post_id, 'soul_order_code', true);
	if ($code === '') {
		$code = 'SOUL-' . $post_id;
	}
	if (! is_array($customer)) {
		$customer = [];
	}
	if (! is_array($shipping)) {
		$shipping = [];
	}
	if (! is_array($items)) {
		$items = [];
	}
	$addr_line = trim((string) ($customer['address'] ?? ''));
	$ward      = (string) ($customer['ward'] ?? '');
	$province  = (string) ($customer['province'] ?? '');
	$store     = null;
	if (($shipping['method'] ?? '') === 'pickup' && ! empty($shipping['store_name'])) {
		$store = [
			'name' => (string) $shipping['store_name'],
			'addr' => (string) ($shipping['store_addr'] ?? ''),
		];
	}
	$lines = [];
	foreach ($items as $item) {
		if (! is_array($item)) {
			continue;
		}
		$lines[] = [
			'id'      => (string) ($item['id'] ?? ''),
			'h'       => (string) ($item['id'] ?? ''),
			'name'    => (string) ($item['name'] ?? ''),
			'variant' => (string) ($item['variant'] ?? ''),
			'price'   => (int) ($item['price'] ?? 0),
			'qty'     => (int) ($item['qty'] ?? 1),
			'img'     => (string) ($item['img'] ?? ''),
		];
	}
	return [
		'id'      => $code,
		'postId'  => $post_id,
		'date'    => get_post_time('c', true, $post),
		'status'  => soul_account_status_code($status),
		'wpStatus'=> $status !== '' ? $status : 'new',
		'email'   => (string) ($customer['email'] ?? ''),
		'name'    => (string) ($customer['name'] ?? ''),
		'phone'   => (string) ($customer['phone'] ?? ''),
		'pay'     => (string) get_post_meta($post_id, 'soul_payment', true) ?: 'bank',
		'ship'    => (string) ($shipping['method'] ?? 'std'),
		'shipFee' => (int) ($shipping['fee'] ?? 0),
		'store'   => $store,
		'addr'    => [
			'address'  => $addr_line,
			'ward'     => $ward,
			'province' => $province,
		],
		'items'   => $lines,
		'sub'     => (int) get_post_meta($post_id, 'soul_subtotal', true),
		'disc'    => (int) get_post_meta($post_id, 'soul_discount', true),
		'total'   => (int) get_post_meta($post_id, 'soul_total', true),
	];
}

/**
 * @return list<array<string,mixed>>
 */
function soul_account_orders_for_email(string $email): array {
	$email = strtolower(trim($email));
	if ($email === '' || ! is_email($email)) {
		return [];
	}
	$q = new \WP_Query([
		'post_type'      => 'soul_order',
		'post_status'    => 'publish',
		'posts_per_page' => 50,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'fields'         => 'ids',
		'no_found_rows'  => true,
	]);
	$out = [];
	foreach ($q->posts as $pid) {
		$customer = get_post_meta((int) $pid, 'soul_customer', true);
		$ce       = is_array($customer) ? strtolower((string) ($customer['email'] ?? '')) : '';
		if ($ce !== $email) {
			continue;
		}
		$row = soul_account_serialize_order((int) $pid);
		if ($row) {
			$out[] = $row;
		}
	}
	return $out;
}

/**
 * @param array<string,mixed> $data
 * @return array{ok:bool,address:array<string,mixed>}|WP_Error
 */
function soul_account_save_address(int $user_id, array $data, ?string $edit_id): array|\WP_Error {
	$name     = sanitize_text_field((string) ($data['name'] ?? ''));
	$phone    = sanitize_text_field((string) ($data['phone'] ?? ''));
	$address  = sanitize_text_field((string) ($data['address'] ?? ''));
	$ward     = sanitize_text_field((string) ($data['ward'] ?? ''));
	$province = sanitize_text_field((string) ($data['province'] ?? ''));
	$def      = ! empty($data['def']);

	if ($name === '' || $address === '' || $ward === '' || $province === '') {
		return new \WP_Error('soul_addr_required', __('Please fill all address fields.', 'soul'), ['status' => 400]);
	}
	$digits = preg_replace('/[\s.\-]/', '', $phone) ?? '';
	$digits = preg_replace('/^\+84/', '0', $digits) ?? $digits;
	if (! preg_match('/^0\d{9}$/', $digits)) {
		return new \WP_Error('soul_bad_phone', __('Phone must be 10 digits starting with 0.', 'soul'), ['status' => 400]);
	}

	$list = get_user_meta($user_id, 'soul_addresses', true);
	if (! is_array($list)) {
		$list = [];
	}
	$id  = $edit_id ?: ('a' . wp_generate_password(8, false));
	$rec = [
		'id'       => $id,
		'name'     => $name,
		'phone'    => $digits,
		'address'  => $address,
		'ward'     => $ward,
		'province' => $province,
		'def'      => $def || $list === [],
	];
	$found = false;
	foreach ($list as $i => $row) {
		if (! is_array($row)) {
			continue;
		}
		if ((string) ($row['id'] ?? '') === $id) {
			$list[ $i ] = $rec;
			$found       = true;
		}
	}
	if (! $found) {
		$list[] = $rec;
	}
	if ($rec['def']) {
		foreach ($list as $i => $row) {
			if (! is_array($row)) {
				continue;
			}
			$list[ $i ]['def'] = ((string) ($row['id'] ?? '') === $id);
		}
	} elseif (! array_filter($list, static fn($r) => is_array($r) && ! empty($r['def']))) {
		if (isset($list[0]) && is_array($list[0])) {
			$list[0]['def'] = true;
		}
	}
	update_user_meta($user_id, 'soul_addresses', array_values($list));
	return ['ok' => true, 'address' => $rec];
}

/**
 * Public auth routes must not fail with rest_cookie_invalid_nonce
 * when the browser holds a stale logged-in cookie + page nonce mismatch.
 */
add_filter('rest_authentication_errors', static function ($result) {
	if (! is_wp_error($result) || $result->get_error_code() !== 'rest_cookie_invalid_nonce') {
		return $result;
	}
	$route = '';
	if (isset($GLOBALS['wp']->query_vars['rest_route'])) {
		$route = (string) $GLOBALS['wp']->query_vars['rest_route'];
	}
	if ($route === '' && isset($_SERVER['REQUEST_URI'])) {
		$route = (string) wp_unslash($_SERVER['REQUEST_URI']);
	}
	$public = [
		'/soul/v1/auth/login',
		'/soul/v1/auth/register',
		'/soul/v1/auth/recover',
		'/soul/v1/auth/logout',
		'/soul/v1/auth/me',
	];
	foreach ($public as $path) {
		if (str_contains($route, $path)) {
			return true; // allow request; handlers re-check auth as needed
		}
	}
	return $result;
}, 101); // After rest_cookie_check_errors (100).

add_action('rest_api_init', static function (): void {
	$public = '__return_true';
	$auth   = static function (): bool {
		return is_user_logged_in();
	};

	register_rest_route('soul/v1', '/auth/me', [
		'methods'             => 'GET',
		'permission_callback' => $public,
		'callback'            => static function () {
			if (! is_user_logged_in()) {
				return ['ok' => true, 'loggedIn' => false, 'user' => null, 'orders' => []];
			}
			$user = wp_get_current_user();
			return [
				'ok'       => true,
				'loggedIn' => true,
				'user'     => soul_account_user_payload($user),
				'orders'   => soul_account_orders_for_email($user->user_email),
			];
		},
	]);

	register_rest_route('soul/v1', '/auth/login', [
		'methods'             => 'POST',
		'permission_callback' => $public,
		'callback'            => static function (\WP_REST_Request $request) {
			$data  = $request->get_json_params();
			$data  = is_array($data) ? $data : [];
			$email = strtolower(sanitize_email((string) ($data['email'] ?? '')));
			$pw    = (string) ($data['password'] ?? '');
			if (! is_email($email) || $pw === '') {
				return new \WP_Error('soul_login_invalid', __('Incorrect email or password.', 'soul'), ['status' => 400]);
			}
			$user = get_user_by('email', $email);
			if (! $user) {
				return new \WP_Error('soul_login_invalid', __('Incorrect email or password.', 'soul'), ['status' => 401]);
			}
			$signon = wp_signon(
				[
					'user_login'    => $user->user_login,
					'user_password' => $pw,
					'remember'      => true,
				],
				is_ssl()
			);
			if (is_wp_error($signon)) {
				return new \WP_Error('soul_login_invalid', __('Incorrect email or password.', 'soul'), ['status' => 401]);
			}
			wp_set_current_user($signon->ID);
			return [
				'ok'       => true,
				'loggedIn' => true,
				'nonce'    => wp_create_nonce('wp_rest'),
				'user'     => soul_account_user_payload($signon),
				'orders'   => soul_account_orders_for_email($signon->user_email),
			];
		},
	]);

	register_rest_route('soul/v1', '/auth/register', [
		'methods'             => 'POST',
		'permission_callback' => $public,
		'callback'            => static function (\WP_REST_Request $request) {
			$data  = $request->get_json_params();
			$data  = is_array($data) ? $data : [];
			$name  = sanitize_text_field((string) ($data['name'] ?? ''));
			$email = strtolower(sanitize_email((string) ($data['email'] ?? '')));
			$phone = sanitize_text_field((string) ($data['phone'] ?? ''));
			$pw    = (string) ($data['password'] ?? '');
			$mkt   = ! empty($data['marketing']);

			if ($name === '' || ! is_email($email) || strlen($pw) < 8) {
				return new \WP_Error('soul_register_invalid', __('Please check your details.', 'soul'), ['status' => 400]);
			}
			$digits = preg_replace('/[\s.\-]/', '', $phone) ?? '';
			$digits = preg_replace('/^\+84/', '0', $digits) ?? $digits;
			if (! preg_match('/^0\d{9}$/', $digits)) {
				return new \WP_Error('soul_bad_phone', __('Phone must be 10 digits starting with 0.', 'soul'), ['status' => 400]);
			}
			if (email_exists($email) || username_exists($email)) {
				return new \WP_Error('soul_email_taken', __('This email is already registered. Please sign in.', 'soul'), ['status' => 409]);
			}

			$user_id = wp_create_user($email, $pw, $email);
			if (is_wp_error($user_id)) {
				return $user_id;
			}
			wp_update_user([
				'ID'           => $user_id,
				'display_name' => $name,
				'first_name'   => $name,
				'role'         => 'subscriber',
			]);
			update_user_meta($user_id, 'soul_phone', $digits);
			update_user_meta($user_id, 'soul_marketing', $mkt ? 1 : 0);
			update_user_meta($user_id, 'soul_addresses', []);

			$signon = wp_signon(
				[
					'user_login'    => $email,
					'user_password' => $pw,
					'remember'      => true,
				],
				is_ssl()
			);
			if (is_wp_error($signon)) {
				$user = get_user_by('id', $user_id);
				if ($user) {
					wp_set_current_user($user_id);
					wp_set_auth_cookie($user_id, true, is_ssl());
					$signon = $user;
				} else {
					return $signon;
				}
			} else {
				wp_set_current_user($signon->ID);
			}

			$u = $signon instanceof \WP_User ? $signon : wp_get_current_user();
			return [
				'ok'       => true,
				'loggedIn' => true,
				'nonce'    => wp_create_nonce('wp_rest'),
				'user'     => soul_account_user_payload($u),
				'orders'   => [],
			];
		},
	]);

	register_rest_route('soul/v1', '/auth/recover', [
		'methods'             => 'POST',
		'permission_callback' => $public,
		'callback'            => static function (\WP_REST_Request $request) {
			$data  = $request->get_json_params();
			$data  = is_array($data) ? $data : [];
			$email = strtolower(sanitize_email((string) ($data['email'] ?? '')));
			// Always OK (no email enumeration); send if exists.
			if (is_email($email)) {
				$u = get_user_by('email', $email);
				if ($u) {
					retrieve_password($u->user_login);
				}
			}
			return [
				'ok'      => true,
				'message' => sprintf(
					/* translators: %s: email */
					__('If %s is registered, a reset link will arrive in a few minutes.', 'soul'),
					$email
				),
			];
		},
	]);

	register_rest_route('soul/v1', '/auth/logout', [
		'methods'             => 'POST',
		'permission_callback' => $public,
		'callback'            => static function () {
			wp_logout();
			return ['ok' => true, 'loggedIn' => false];
		},
	]);

	register_rest_route('soul/v1', '/account/profile', [
		'methods'             => 'POST',
		'permission_callback' => $auth,
		'callback'            => static function (\WP_REST_Request $request) {
			$data  = $request->get_json_params();
			$data  = is_array($data) ? $data : [];
			$user  = wp_get_current_user();
			$name  = sanitize_text_field((string) ($data['name'] ?? ''));
			$phone = sanitize_text_field((string) ($data['phone'] ?? ''));
			$mkt   = ! empty($data['marketing']);
			if ($name === '') {
				return new \WP_Error('soul_name_required', __('This field is required.', 'soul'), ['status' => 400]);
			}
			$digits = preg_replace('/[\s.\-]/', '', $phone) ?? '';
			$digits = preg_replace('/^\+84/', '0', $digits) ?? $digits;
			if (! preg_match('/^0\d{9}$/', $digits)) {
				return new \WP_Error('soul_bad_phone', __('Phone must be 10 digits starting with 0.', 'soul'), ['status' => 400]);
			}
			wp_update_user([
				'ID'           => $user->ID,
				'display_name' => $name,
				'first_name'   => $name,
				'nickname'     => $name,
			]);
			update_user_meta($user->ID, 'soul_phone', $digits);
			update_user_meta($user->ID, 'soul_marketing', $mkt ? 1 : 0);
			clean_user_cache($user->ID);
			$fresh = get_userdata($user->ID);
			return ['ok' => true, 'user' => soul_account_user_payload($fresh instanceof \WP_User ? $fresh : $user)];
		},
	]);

	register_rest_route('soul/v1', '/account/password', [
		'methods'             => 'POST',
		'permission_callback' => $auth,
		'callback'            => static function (\WP_REST_Request $request) {
			$data = $request->get_json_params();
			$data = is_array($data) ? $data : [];
			$user = wp_get_current_user();
			$cur  = (string) ($data['current'] ?? '');
			$npw  = (string) ($data['password'] ?? '');
			if (! wp_check_password($cur, $user->user_pass, $user->ID)) {
				return new \WP_Error('soul_bad_cur', __('Current password is incorrect.', 'soul'), ['status' => 400]);
			}
			if (strlen($npw) < 8) {
				return new \WP_Error('soul_short_pw', __('Use at least 8 characters.', 'soul'), ['status' => 400]);
			}
			wp_set_password($npw, $user->ID);
			// Keep session alive.
			wp_set_auth_cookie($user->ID, true, is_ssl());
			wp_set_current_user($user->ID);
			return ['ok' => true];
		},
	]);

	register_rest_route('soul/v1', '/account/addresses', [
		[
			'methods'             => 'GET',
			'permission_callback' => $auth,
			'callback'            => static function () {
				$user = wp_get_current_user();
				$payload = soul_account_user_payload($user);
				return ['ok' => true, 'addresses' => $payload['addresses']];
			},
		],
		[
			'methods'             => 'POST',
			'permission_callback' => $auth,
			'callback'            => static function (\WP_REST_Request $request) {
				$data = $request->get_json_params();
				$data = is_array($data) ? $data : [];
				$user = wp_get_current_user();
				$edit = isset($data['id']) ? sanitize_text_field((string) $data['id']) : null;
				$res  = soul_account_save_address($user->ID, $data, $edit ?: null);
				if (is_wp_error($res)) {
					return $res;
				}
				return [
					'ok'        => true,
					'address'   => $res['address'],
					'addresses' => soul_account_user_payload(wp_get_current_user())['addresses'],
				];
			},
		],
	]);

	register_rest_route('soul/v1', '/account/addresses/(?P<id>[a-zA-Z0-9_-]+)', [
		[
			'methods'             => 'DELETE',
			'permission_callback' => $auth,
			'callback'            => static function (\WP_REST_Request $request) {
				$user = wp_get_current_user();
				$id   = sanitize_text_field((string) $request['id']);
				$list = get_user_meta($user->ID, 'soul_addresses', true);
				if (! is_array($list)) {
					$list = [];
				}
				$was_def = false;
				$next    = [];
				foreach ($list as $row) {
					if (! is_array($row)) {
						continue;
					}
					if ((string) ($row['id'] ?? '') === $id) {
						$was_def = ! empty($row['def']);
						continue;
					}
					$next[] = $row;
				}
				if ($was_def && isset($next[0]) && is_array($next[0])) {
					$next[0]['def'] = true;
				}
				update_user_meta($user->ID, 'soul_addresses', array_values($next));
				return ['ok' => true, 'addresses' => array_values($next)];
			},
		],
		[
			'methods'             => 'POST',
			'permission_callback' => $auth,
			'callback'            => static function (\WP_REST_Request $request) {
				// Set default.
				$user = wp_get_current_user();
				$id   = sanitize_text_field((string) $request['id']);
				$data = $request->get_json_params();
				$data = is_array($data) ? $data : [];
				if (empty($data['makeDefault'])) {
					return new \WP_Error('soul_noop', __('Nothing to do.', 'soul'), ['status' => 400]);
				}
				$list = get_user_meta($user->ID, 'soul_addresses', true);
				if (! is_array($list)) {
					$list = [];
				}
				$ok = false;
				foreach ($list as $i => $row) {
					if (! is_array($row)) {
						continue;
					}
					$match           = ((string) ($row['id'] ?? '') === $id);
					$list[ $i ]['def'] = $match;
					if ($match) {
						$ok = true;
					}
				}
				if (! $ok) {
					return new \WP_Error('soul_not_found', __('Address not found.', 'soul'), ['status' => 404]);
				}
				update_user_meta($user->ID, 'soul_addresses', array_values($list));
				return ['ok' => true, 'addresses' => array_values($list)];
			},
		],
	]);

	register_rest_route('soul/v1', '/account/orders/(?P<code>[A-Za-z0-9\-]+)/cancel', [
		'methods'             => 'POST',
		'permission_callback' => $auth,
		'callback'            => static function (\WP_REST_Request $request) {
			$user  = wp_get_current_user();
			$code  = sanitize_text_field((string) $request['code']);
			$orders = soul_account_orders_for_email($user->user_email);
			$found  = null;
			foreach ($orders as $o) {
				if (($o['id'] ?? '') === $code) {
					$found = $o;
					break;
				}
			}
			if (! $found) {
				return new \WP_Error('soul_order_missing', __('Order not found.', 'soul'), ['status' => 404]);
			}
			if ((int) ($found['status'] ?? -1) !== 0) {
				return new \WP_Error('soul_cannot_cancel', __('This order can no longer be cancelled.', 'soul'), ['status' => 400]);
			}
			update_post_meta((int) $found['postId'], 'soul_status', 'cancelled');
			$row = soul_account_serialize_order((int) $found['postId']);
			return ['ok' => true, 'order' => $row];
		},
	]);
});
