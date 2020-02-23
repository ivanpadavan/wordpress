<?php

namespace ACA\EC;

use AC;

class Import {

	const IMPORTED_KEY = 'aca_ec_layouts_imported';

	public function register() {
		add_action( 'ac/settings/list_screen', array( $this, 'init' ) );
	}

	public function init( AC\ListScreen $list_screen ) {
		if ( ! $list_screen instanceof AC\ListScreen\Post ) {
			return;
		}

		if ( ! in_array( $list_screen->get_post_type(), array( 'tribe_events', 'tribe_venue', 'tribe_organizer' ) ) ) {
			return;
		}

		if ( $this->is_imported() ) {
			return;
		}

		add_action( 'ac/settings/after_menu', array( $this, 'display_import_layout_message' ) );

		$this->handle_request();
	}

	public function display_import_layout_message() {
		?>

		<div class="notice notice-success">
			<p>
				<?php printf( __( 'Enable our predefined column sets for %s?', 'codepress-admin-columns' ), __( 'The Events Calendar', 'the-events-calendar' ) ); ?>

				<a href="<?php echo add_query_arg( 'acp_action', 'aca_ec_import_layouts' ); ?>" class="notice__actionlink">Yes</a>
				<a href="<?php echo add_query_arg( 'acp_action', 'aca_ec_dismiss_import_layouts' ); ?>" class="notice__actionlink">No thanks</a>
			</p>
		</div>

		<?php
	}

	private function handle_request() {
		$action = filter_input( INPUT_GET, 'acp_action' );

		switch ( $action ) {
			case 'aca_ec_import_layouts':
				$this->import_layouts();

				break;
			case 'aca_ec_dismiss_import_layouts':
				$this->mark_imported();

				break;
			default:
				return;
		}

		wp_redirect( remove_query_arg( 'acp_action' ) );
		exit;
	}

	/**
	 * @return bool
	 */
	private function is_imported() {
		return (bool) get_option( self::IMPORTED_KEY );
	}

	/**
	 * @return bool
	 */
	private function mark_imported() {
		return update_option( self::IMPORTED_KEY, true );
	}

	private function import_layouts() {
		$content = file_get_contents( ac_addon_events_calendar()->get_dir() . '/export/events.json' );
		$data = json_decode( $content, true );

		foreach ( $data as $post_type => $layouts ) {
			$list_screen = AC\ListScreenFactory::create( $post_type );

			if ( ! $list_screen ) {
				continue;
			}

			$_layouts = ACP()->layouts( $list_screen );

			foreach ( $layouts as $layout ) {
				$_layout = $_layouts->create( $layout['layout'] );

				if ( $layout ) {
					$list_screen->set_layout_id( $_layout->get_id() )->store( $layout['columns'] );
				}
			}
		}

		$this->mark_imported();
	}

}