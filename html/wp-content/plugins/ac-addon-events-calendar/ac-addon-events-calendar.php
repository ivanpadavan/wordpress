<?php
/*
Plugin Name:    Admin Columns Pro - Events Calendar
Version:        1.4.1
Description:    Events Calendar integration for Admin Columns
Author:         Admin Columns
Author URI:     https://admincolumns.com
Text Domain:    codepress-admin-columns
*/

use AC\Autoloader;
use ACA\EC\Dependencies;
use ACA\EC\EventsCalendar;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_admin() ) {
	return;
}

require_once __DIR__ . '/classes/Dependencies.php';

add_action( 'after_setup_theme', function () {
	$dependencies = new Dependencies( plugin_basename( __FILE__ ), '1.4.1' );
	$dependencies->requires_acp( '4.7.1' );
	$dependencies->requires_php( '5.3.6' );

	if ( ! class_exists( 'Tribe__Events__Main', false ) ) {
		$dependencies->add_missing_plugin( __( 'The Events Calendar', 'the-events-calendar' ), $dependencies->get_search_url( 'Events Calendar' ) );
	}

	if ( $dependencies->has_missing() ) {
		return;
	}

	Autoloader::instance()->register_prefix( 'ACA\EC', __DIR__ . '/classes/' );

	$addon = new EventsCalendar( __FILE__ );
	$addon->register();
} );

function ac_addon_events_calendar() {
	return new EventsCalendar( __FILE__ );
}