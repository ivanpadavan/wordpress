<?php
if ( function_exists('nimble_register_location') ) {
	nimble_register_location('__before_pills');
}

add_filter( 'tc_breadcrumb_trail' , function($args) {
	global $wp_query;
	if (is_singular('xo_event')) {
		unset($args[1]);
	}
	return $args;
}, 50);
