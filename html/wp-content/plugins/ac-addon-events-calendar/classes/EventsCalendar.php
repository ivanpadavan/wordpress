<?php

namespace ACA\EC;

use AC;
use ACA\EC\ListScreen;

final class EventsCalendar extends AC\Plugin {

	/**
	 * @var string
	 */
	protected $file;

	public function __construct( $file ) {
		$this->file = $file;
	}

	public function register() {
		add_action( 'ac/list_screen_groups', array( $this, 'register_list_screen_groups' ) );
		add_action( 'ac/list_screens', array( $this, 'register_list_screens' ) );
		add_action( 'ac/column_groups', array( $this, 'register_column_groups' ) );
		add_action( 'ac/admin_scripts', array( $this, 'admin_scripts' ) );

		new TableScreen();

		$import_layouts = new Import();
		$import_layouts->register();
	}

	protected function get_file() {
		return $this->file;
	}

	protected function get_version_key() {
		return 'aca_events_calendar';
	}

	public function admin_scripts() {
		wp_enqueue_style( 'aca-ec-admin', $this->get_url() . 'assets/css/admin.css', array(), $this->get_version() );
	}

	/**
	 * @param AC\Groups $groups
	 */
	public function register_list_screen_groups( $groups ) {
		$groups->register_group( 'events-calendar', 'Events Calendar', 7 );
	}

	/**
	 * @param AC\AdminColumns $ac
	 */
	public function register_list_screens( AC\AdminColumns $ac ) {
		$ac->register_list_screen( new ListScreen\Event() )
		   ->register_list_screen( new ListScreen\Venue() )
		   ->register_list_screen( new ListScreen\Organizer() );
	}

	/**
	 * @param AC\Groups $groups
	 */
	public function register_column_groups( $groups ) {
		$groups->register_group( 'events_calendar', __( 'The Events Calendar', 'the-events-calendar' ), 11 );
		$groups->register_group( 'events_calendar_fields', __( 'The Events Calendar', 'the-events-calendar' ) . ' - ' . __( 'Additional Fields', 'tribe-events-calendar-pro' ), 11 );
	}

}