<?php

namespace ACA\EC\Search\Venue;

use AC;
use ACP\Search\Comparison\Meta;
use ACP\Search\Comparison\Values;
use ACP\Search\Operators;

class Country extends Meta

	implements Values {

	/** @var array */
	private $options;

	public function __construct( $meta_key, $meta_type, array $options ) {
		$this->options = $options;

		$operators = new Operators( array(
			Operators::EQ,
			Operators::NEQ,
			Operators::IS_EMPTY,
			Operators::NOT_IS_EMPTY,
		) );

		parent::__construct( $operators, $meta_key, $meta_type );
	}

	public function get_values() {
		return AC\Helper\Select\Options::create_from_array( $this->options );
	}

}