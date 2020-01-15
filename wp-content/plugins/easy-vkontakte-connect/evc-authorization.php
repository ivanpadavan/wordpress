<?php

function evc_auth_login_url( $redirect_url = false, $echo = false ) {
	add_filter( 'evc_share_vk_login_url_scope', 'evc_auth_login_url_scope' );
	if ( ! $echo ) {
		$url = evc_share_vk_login_url( $redirect_url, $echo );
	} else {
		evc_share_vk_login_url( $redirect_url, $echo );
	}
	remove_filter( 'evc_share_vk_login_url_scope', 'evc_auth_login_url_scope' );

	if ( isset( $url ) ) {
		return $url;
	}
}

function evc_auth_login_url_scope( $scope ) {
	return apply_filters( 'evc_auth_login_url_scope_filter', $scope );
}


function evc_auth_login_url_scope_clear( $scope ) {
	return '';
}

add_filter( 'evc_auth_login_url_scope_filter', 'evc_auth_login_url_scope_clear' );

// !!!
add_action( 'init', 'evc_auth_authorization' );
function evc_auth_authorization() {

	//if ( ! is_admin() && false !== ( $token = evc_auth_get_token() ) ) { //!!!
	if ( ( ! is_admin() || ( is_admin() && ! isset( $_GET['page'] ) ) ) && false !== ( $token = evc_auth_get_token() ) ) { //!!!
		evc_auth_user_authorize( $token['user_id'], $token );
		$redirect = remove_query_arg( array( 'code' ), $_SERVER['REQUEST_URI'] );
		//print__r($token);
		//exit;
		wp_redirect( site_url( $redirect ) );
		exit;
	}
}

function evc_auth_get_token() {
	//return evc_share_get_token();
	$options = get_option( 'evc_vk_api_widgets' );

	if ( ( ! is_admin() || ( is_admin() && ! isset( $_GET['page'] ) ) ) && isset( $_GET['code'] ) && ! empty( $_GET['code'] ) ) {

		$_SERVER['REQUEST_URI'] = remove_query_arg( array( 'code' ), $_SERVER['REQUEST_URI'] );

		$params = array(
			'client_id'     => trim( $options['site_app_id'] ),
			//'redirect_uri'  => site_url( $_SERVER['REQUEST_URI'] ),
			//'redirect_uri'  => home_url( $_SERVER['REQUEST_URI'] ),
			'redirect_uri'  => set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ),
			'client_secret' => $options['site_app_secret'],
			'code'          => $_GET['code']
		);
		$query  = http_build_query( $params );

		$data = wp_remote_get( EVC_TOKEN_URL . '?' . $query );

		if ( is_wp_error( $data ) ) {
			//print__r($data); //
			//exit;
			return false;
		}

		$resp = json_decode( $data['body'], true );
		if ( isset( $resp['error'] ) ) {
			return false;
		}

		return $resp;
	}

	return false;
}

function evc_auth_user_authorize( $user_vk_id, $token ) {
	$user_wp_id = evc_get_wpid_by_vkid( $user_vk_id, 'user' );

	if ( is_user_logged_in() && ! empty( $user_wp_id ) && ! empty( $user_wp_id[ $user_vk_id ] ) ) {
		evc_add_log( 'evc_auth_user_authorize: Пользователь с VK ID ' . $user_vk_id . ' уже существует. Нужно отвязать ВК аккаунт от ВордПресс пользователя ' . admin_url( 'user-edit.php?user_id=' . $user_wp_id[ $user_vk_id ] ) . ', либо удалить его с сайта.' );
	}

	// Если пользователь с vk_item_id еще не существует на сайте
	if ( ! $user_wp_id ) {

		$user_vk_data = evc_vkapi_get_users( array( 'user_ids' => $user_vk_id ) );
		if ( ! $user_vk_data || ! isset( $user_vk_data[0] ) ) {
			return false;
		}

		if ( is_user_logged_in() ) {
			global $user_ID;
			//Если пользователь зарегистрирован - добавляем данные ВК
			$user_wp_id = evc_update_user( $user_ID, $user_vk_data[0] );

			if ( is_wp_error( $user_wp_id ) ) {
				evc_add_log( 'evc_auth_user_authorize: WP ERROR. ' . $user_wp_id->get_error_code() . ' ' . $user_wp_id->get_error_message() );
			}

		} else {
			if ( ! empty( $token['email'] ) ) {
				$user_vk_data[0]['user_email'] = $token['email'];
			}

			$user_wp_id = evc_add_user( $user_vk_data[0] );
		}

	} else {
		$user_wp_id = $user_wp_id[ $user_vk_id ];
	}

	if ( ! $user_wp_id ) {
		evc_add_log( 'evc_auth_user_authorize: Не удалось установить id пользователя.' );

		return false;
	}

	// Если пользователь незарегистрирован - ставим куку
	if ( ! is_user_logged_in() ) {
		wp_set_auth_cookie( $user_wp_id, true );
	}

	evc_refresh_vk_img_all();

	return $user_wp_id;
}


// WooCommerce
if ( class_exists( 'WooCommerce' ) ) {
	add_action( 'woocommerce_login_form_start', 'evc_auth_register_form' );
}

add_action( 'login_form', 'evc_auth_register_form' );
//add_action( 'register_form', 'evc_auth_register_form' );
function evc_auth_register_form() {
	$options = get_option( 'evc_widget_auth' );

	if ( isset( $options['tvc_auth_button'] ) && $options['tvc_auth_button'] ) {

		$login_url = evc_auth_login_url();
		ob_start();
		?>
		<p class="evc-auth-button">&nbsp;<input type="button" name="evc_vk_login" id="evc_vk_login" class="button button-primary button-large" value="Войти через ВКонтакте" onclick="location.href='<?php echo $login_url; ?>'"/>
		</p>
		<br class="clear"/>
		<?php

		$out = ob_get_clean();
		$out = apply_filters( 'evc_auth_register_form', $out, $login_url );

		echo $out;
	}
}

add_action( 'login_form_register', 'evc_auth_login_init' );
add_action( 'login_form_login', 'evc_auth_login_init' );
function evc_auth_login_init() {
	if ( is_user_logged_in() ) {
		wp_redirect( site_url() );
		exit;
	}
}


/* VK LINKING | UNLINKING */

function evc_init_vk_unlink() {
	global $user_ID;

	if ( is_user_logged_in() && isset( $_GET['vk_unlink'] ) ) {

		evc_vk_unlink( $user_ID );

		$redirect = remove_query_arg( array( 'vk_unlink' ), $_SERVER['REQUEST_URI'] );
		//print__r($redirect);
		wp_redirect( site_url( $redirect ) );
		exit;
	}
}

add_action( 'init', 'evc_init_vk_unlink' );


function evc_vk_unlink( $user_id = '' ) {
	if ( empty( $user_id ) ) {
		return false;
	}

	$vk_item_id = get_user_meta( $user_id, 'vk_item_id', true );

	if ( ! empty( $vk_item_id ) ) {

		// Update Userdata
		if ( ! function_exists( 'wp_update_user' ) ) {
			require_once( ABSPATH . WPINC . '/registration.php' );
		}

		// Удаляем ссылку на профиль ВК
		$udata   = array(
			'ID'       => $user_id,
			'user_url' => ''
		);
		$user_id = wp_update_user( $udata );

		$metas = array( 'photo_medium', 'photo_big', 'vk_item_id' );

		// WooCommerce
		if ( class_exists( 'WooCommerce' ) ) {
			// Удаляем billing_email
			$metas = array_merge( $metas, array( 'billing_email' ) );
		}

		foreach ( $metas as $meta ) {
			delete_user_meta( $user_id, $meta );
		}
	}
}


function evc_personal_options( $profileuser ) {
	$options = get_option( 'evc_widget_auth' );

	if ( ! isset( $options['evc_vk_link_button'] ) || $options['evc_vk_link_button']) {

		ob_start();
		?>
		<tr class="evc-vk-link-wrap">
			<th scope="row">
				<label for="evc-vk-link"><?php _e( 'Аккаунт ВК' ); ?></label>
			</th>
			<td>
				<button id="evc-vk-link" type="button" class="button evc-vk-link-button" onclick="%onclick%">%button%</button>
				<p class="description">%description%</p>
			</td>
		</tr>
		<?php
		$content = ob_get_clean();
		$out     = do_shortcode( '[vk_link user_id=' . $profileuser->ID . ']' . $content . '[/vk_link]' );

		echo $out;
	}
}

add_action( 'personal_options', 'evc_personal_options' );


add_shortcode( 'vk_link', 'evc_vk_link_shortcode' );
function evc_vk_link_shortcode( $atts = array(), $content = '' ) {
	global $user_ID;
	$out = '';

	if ( ! is_user_logged_in() ) {
		return $out;
	}

	$args['%title%'] = ! isset( $atts['title'] ) ? 'Привязать аккаунт ВКонтакте' : $atts['title'];

	if ( empty( $atts['user_id'] ) ) {
		$atts['user_id'] = $user_ID;
	}

	$vk_item_id = get_user_meta( $atts['user_id'], 'vk_item_id', true );
	if ( empty( $vk_item_id ) ) {

		$args['%onclick%'] = "location.href='" . evc_auth_login_url() . "'";

		$args['%button%']      = ! isset( $atts['vk_link_button'] ) ? 'Привязать аккаунт ВКонтакте' : $atts['vk_link_button'];
		$args['%description%'] = ! isset( $atts['vk_link_descr'] ) ? 'Данными из ВКонтакте будут заменены опции: Имя, Фамилия, Отображать как, Аватар. В опции "Сайт" будет указана ссылка на профиль ВКонтакте.
		<br>После этого вы сможете авторизоваться на сайте в один клик, нажав кнопку "Войти через ВКонтакте".' : $atts['vk_link_descr'];
	} else {

		$redirect          = add_query_arg( array( 'vk_unlink' => '' ), $_SERVER['REQUEST_URI'] );
		$args['%onclick%'] = "location.href='" . $redirect . "'";

		$args['%button%']      = ! isset( $atts['vk_unlink_button'] ) ? 'Отвязать аккаунт ВКонтакте' : $atts['vk_unlink_button'];
		$args['%description%'] = ! isset( $atts['vk_unlink_descr'] ) ? 'Будут очищены опции: Аватар, Сайт.
		<br>После этого вы <b>не сможете</b> авторизоваться на сайте в один клик, нажав кнопку "Войти через ВКонтакте".' : $atts['vk_unlink_descr'];
	}

	ob_start();
	?>
	<div class="evc-vk-link-wrap">
		<?php if ( ! empty( $args['%title%'] ) ) { ?>
			<h5 class="evc-vk-link-title">
				%title%
			</h5>
		<?php } ?>
		<div>
			<button id="evc-vk-link" type="button" class="evc-vk-link-button" onclick="%onclick%">%button%</button>
			<?php if ( ! empty( $args['%description%'] ) ) { ?>
				<p class="evc-vk-link-description">%description%</p>
			<?php } ?>
		</div>
	</div>

	<?php
	$out = ob_get_clean();

	if ( empty( $content ) ) {
		$content = $out;
	}

	$out = str_replace( array_keys( $args ), array_values( $args ), $content );

	return $out;
}