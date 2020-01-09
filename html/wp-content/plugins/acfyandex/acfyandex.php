<?php
/*
Plugin Name: ACF:Yandex
Plugin URI: http://programmist.ek96.ru/wp-acfyandex/
Description: Расширение для плагина Advanced Custom Fields. Добавляет возможности вставить карту Yandex
Version: 1.7
Author: Simonov Dmitry
Author URI: http://programmist.ek96.ru
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/license-list.html#GPLCompatibleLicenses
Text Domain: acfyandex
Domain Path: /lang
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
define( 'acfyandex_truepage', 'acfyandex' );
define( 'acfyandex_nameoption', 'acfyandex_data' );


class acfyandex_plugin {

	public function __construct() {
		$this->settings = array(
			'version' => '1',
			'url'     => plugin_dir_url( __FILE__ ),
			'path'    => plugin_dir_path( __FILE__ )
		);
		add_action( 'acf/include_field_types', array( $this, 'include_field_types' ) ); // v5
		add_action( 'admin_init', [ $this, 'startSession' ], 1 );
		add_action( 'admin_menu', [ $this, 'pluginmenu' ] );
		add_action( 'admin_init', [ $this, 'option_settings' ] );
		add_action( 'init', [ $this, 'plugininit' ], 1 );
		add_action( 'plugins_loaded', [ $this, 'pluginloaded' ] );

	}

	public function plugininit() {
		add_action( 'wp_enqueue_scripts', [ $this, 'acfyandex_scriptsinit' ] );
	}

	public function pluginloaded() {
		load_plugin_textdomain( 'acfyandex', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	}

	public function pluginmenu() {
		if ( current_user_can( 'manage_options' ) ) {
			add_options_page( 'Параметры', __( 'ACF:Yandex', 'acfyandex' ), 'manage_options', acfyandex_truepage, [
				'acfyandex_plugin',
				'formsetup'
			] );
		}
	}

	private function update_formdate( $date_update ) {
		if ( ( ! isset( $date_update ) ) || ( ! is_array( $date_update ) ) ) {
			return false;
		}

		return update_option( 'acfyandex_data', acfyandex_plugin::validate_settings( $date_update ) );
	}

	public function formsetup() {
		if ( ! current_user_can( 'manage_options' ) ) {
			exit();
		}
		if ( ! empty( $_POST ) && wp_verify_nonce( $_POST['acfyandex_wpnonce'], 'acfyandex_action_update' ) && check_admin_referer( 'acfyandex_action_update', 'acfyandex_wpnonce' ) ) {
			if ( acfyandex_plugin::update_formdate( $_POST['acfyandex_data'] ) ) {
				acfyandex_plugin::plugin_notice_ok();
			} else {
				acfyandex_plugin::plugin_notice_error();
			}
		}
		?>
      <div class="wrap">
      <h2><?= __( 'ACF:Yandex [Settings]', 'acfyandex' ) ?></h2>
      <form method="post" enctype="multipart/form-data">
		  <?php
		  $referer = wp_get_referer();
		  do_settings_sections( acfyandex_truepage );
		  wp_nonce_field( 'acfyandex_action_update', 'acfyandex_wpnonce' );
		  ?>
        <p class="submit">
			<?php submit_button(); ?>
        </p>
      </form>
      </div><?php
	}


	public function plugin_notice_ok() {
		?>
      <div class="notice notice-success is-dismissible"><p><?= __( 'Settings updated!', 'acfyandex' ) ?></p>
      </div><?php }

	public function plugin_notice_error() {
		?>
      <div class="notice notice-error is-dismissible"><p><?= __( 'Error! Could not update data.', 'acfyandex' ) ?></p>
      </div><?php }

	public function option_settings() {
		register_setting( 'acfyandex_options', 'acfyandex_options', [ 'acfyandex_plugin', 'validate_settings' ] );
		add_settings_section( 'acfyandex_section_map', __( 'Yandex map', 'acfyandex' ), '', acfyandex_truepage );
		$true_field_params = array(
			'type'      => 'text',
			// тип
			'id'        => 'acfyandex_data_apikey',
			'desc'      => __( 'This key is optional. For high loads or frequent failures, we recommend that you obtain the API key of this service.<BR><a href = "https://yandex.ru/legal/maps_api/">Terms of Use for the Yandex Card API Service </a><BR><a href = "https://developer.tech.yandex.ru/services/"> Get API Key </a> (click Connect API and select Static API Yandex.Cards, registration is required)', 'acfyandex' ),
			// описание
			'label_for' => 'acfyandex_data_apikey'
		);
		add_settings_field( 'acfyandex_text_field', __( 'JavaScript API и HTTP Geocoder', 'acfyandex' ), [
			'acfyandex_plugin',
			'option_display_settings'
		], acfyandex_truepage, 'acfyandex_section_map', $true_field_params );
		$true_field_params = array(
			'type'      => 'select',
			'id'        => 'acfyandex_data_zoom',
			'vals'      => array( 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19 ),
			'label_for' => 'acfyandex_data_zoom'
		);
		add_settings_field( 'acfyandex_select_field', __( 'Zoom by default', 'acfyandex' ), [
			'acfyandex_plugin',
			'option_display_settings'
		], acfyandex_truepage, 'acfyandex_section_map', $true_field_params );

	}


	public function validate_settings( $input ) {

		foreach ( $input as $k => $v ) {
			switch ( trim( strtolower( $k ) ) ) {
				case 'acfyandex_data_zoom':
					$v = (int) sanitize_text_field( $v );
					if ( $v < 0 ) {
						$v = 0;
					}
					if ( $v > 19 ) {
						$v = 19;
					}
					$valid_input[ $k ] = $v;
					break;
				default:
					$valid_input[ $k ] = sanitize_text_field( $v );
					break;
			}
			$valid_input[ $k ] = trim( $v );
		}

		return $valid_input;
	}


	public function option_display_settings( $args ) {
		extract( $args );
		$o = get_option( acfyandex_nameoption );
		switch ( $type ) {
			case 'text':
				$o[ $id ] = esc_attr( stripslashes( $o[ $id ] ) );
				echo "<input class='regular-text' type='text' id='$id' name='" . acfyandex_nameoption . "[$id]' value='$o[$id]' />";
				echo ( $desc != '' ) ? "<br /><span class='description'>$desc</span>" : "";
				break;
			case 'textarea':
				$o[ $id ] = esc_attr( stripslashes( $o[ $id ] ) );
				echo "<textarea class='code large-text' cols='50' rows='10' type='text' id='$id' name='" . acfyandex_nameoption . "[$id]'>$o[$id]</textarea>";
				echo ( $desc != '' ) ? "<br /><span class='description'>$desc</span>" : "";
				break;
			case 'checkbox':
				$checked = ( $o[ $id ] == 'on' ) ? " checked='checked'" : '';
				echo "<label><input type='checkbox' id='$id' name='" . acfyandex_nameoption . "[$id]' $checked /> ";
				echo ( $desc != '' ) ? $desc : "";
				echo "</label>";
				break;
			case 'select':
				echo "<select id='$id' name='" . acfyandex_nameoption . "[$id]'>";
				foreach ( $vals as $v => $l ) {
					$selected = ( $o[ $id ] == $v ) ? "selected='selected'" : '';
					echo "<option value='$v' $selected>$l</option>";
				}
				echo ( $desc != '' ) ? $desc : "";
				echo "</select>";
				break;
			case 'radio':
				echo "<fieldset>";
				foreach ( $vals as $v => $l ) {
					$checked = ( $o[ $id ] == $v ) ? "checked='checked'" : '';
					echo "<label><input type='radio' name='" . acfyandex_nameoption . "[$id]' value='$v' $checked />$l</label><br />";
				}
				echo "</fieldset>";
				break;
		}
	}

	public function startSession() {
		//if(current_user_can('manage_options'))
		if ( ! is_plugin_active( 'advanced-custom-fields/acf.php' ) ) {
			add_action( 'admin_notices', [ 'acfyandex_plugin', 'message_admin_error' ] );
		}
		if ( ! session_id() ) {
			session_start();
		}
		add_action( 'admin_enqueue_scripts', [ $this, 'acfyandex_scriptsinit' ] );
	}

	public function include_field_types( $version = false ) {
		if ( ! $version ) {
			$version = 5;
		}

		require( dirname( __FILE__ ) . '/fields/acfyandex_common.php' );
		require( dirname( __FILE__ ) . '/fields/acfyandex_version' . $version . '.php' );

		new acfyandex_version( $this->settings );
		//add_action( 'admin_enqueue_scripts', ['acfyandex_plugin','acfyandex_scriptsinit']);
	}

	public function acfyandex_scriptsinit() {
		$values  = get_option( 'acfyandex_data' );
		$api_key = array_key_exists( 'acfyandex_data_apikey', $values ) ? $values['acfyandex_data_apikey'] : '';
		wp_enqueue_script( 'acfyandex-key', "//api-maps.yandex.ru/2.1/?apikey={$api_key}&lang=ru_RU" );
	}

	public function group_value( $atts ) {
		$arr = [];
		foreach ( $atts as $key => $value ) {
			$arr_pref = explode( "_", $key );
			$pref     = $arr_pref[0];
			unset( $arr_pref[0] );
			$newkey = implode( "_", $arr_pref );
			if ( strlen( trim( $newkey ) ) > 0 ) {
				if ( strlen( trim( $pref ) ) > 0 ) {
					$arr[ $pref ][ $newkey ] = $value;
				} else {
					$arr[ '_' . $newkey ] = $value;
				}
			} else {
				$arr[ $pref ] = $value;
			}
		}

		return $arr;
	}
}

new acfyandex_plugin;
