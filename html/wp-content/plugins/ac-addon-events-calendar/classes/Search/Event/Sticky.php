<?php

namespace ACA\EC\Search\Event;

use AC;
use ACP\Search\Comparison;
use ACP\Search\Operators;
use ACP\Search\Value;

class Sticky extends Comparison\Post\PostField
	implements Comparison\Values {

	public function __construct() {
		$operators = new Operators( array(
			Operators::EQ,
		) );

		parent::__construct( $operators, Value::INT );
	}

	protected function get_field() {
		return 'menu_order';
	}

	public function get_values() {
		return AC\Helper\Select\Options::create_from_array( array(
			-1 => __( 'True', 'codepress-admin-columns' ),
			0  => __( 'False', 'codepress-admin-columns' ),
		) );
	}

}