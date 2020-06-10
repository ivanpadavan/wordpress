<?php

function try_set_date($date_string, $fallback) {
	if (isset($date_string)) {
		try {
			return new DateTime( $date_string );
		} catch ( Exception $e ) {}
	}
	return new DateTime( $fallback );
}

add_action('__before_loop', function() {
	global $wp_query;

	$start_date = try_set_date($_GET['from'] ?? null, 'first day of january');
	$end_date = try_set_date($_GET['to'] ?? null, 'first day of december');

	if ($start_date > $end_date) {
		$start_date = new DateTime('now');
	}

	$custom_query = array(
		'meta_query' => array(
			'relation' => 'AND',
			'event_start_date' => array ('key' => 'event_start_date', 'compare' => 'EXISTS' ),
			'event_end_date' => array( 'key' => 'event_end_date', 'compare' => 'EXISTS' ),
			array(
				'relation' => 'AND',
				array(
					array( 'key' => 'event_start_date', 'value' => date( 'Y-m-d', $start_date->getTimestamp() ), 'compare' => '>=', 'type' => 'DATE' ),
					array( 'key' => 'event_end_date', 'value' => date( 'Y-m-d', $end_date->getTimestamp() ), 'compare' => '<=', 'type' => 'DATE' ),
				)
			)
		),
	);
	$query = array_merge($wp_query->query, $custom_query);
	$wp_query = new WP_Query($query);
});

require_once get_template_directory() . DIRECTORY_SEPARATOR . 'index.php';
