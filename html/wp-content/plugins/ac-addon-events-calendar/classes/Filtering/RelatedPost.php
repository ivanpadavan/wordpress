<?php

namespace ACA\EC\Filtering;

use ACP;

class RelatedPost extends ACP\Filtering\Model\Meta {

	public function get_filtering_data() {
		$values = $this->get_meta_values();

		return array(
			'empty_option' => true,
			'options'      => acp_filtering()->helper()->get_post_titles( $values ),
		);
	}

}