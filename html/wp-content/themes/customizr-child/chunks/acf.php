<?php
if( function_exists('acf_add_local_field_group') ):

	acf_add_local_field_group(array(
		'key' => 'group_5e3ff12132b0c',
		'title' => 'Место',
		'fields' => array(
			array(
				'key' => 'field_5e3ff16553419',
				'label' => '',
				'name' => 'place',
				'type' => 'post_object',
				'instructions' => '',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'post_type' => array(
					0 => 'xo_place',
				),
				'taxonomy' => '',
				'allow_null' => 0,
				'multiple' => 0,
				'return_format' => 'object',
				'ui' => 1,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'xo_event',
				),
			),
		),
		'menu_order' => -1,
		'position' => 'side',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
	));

	acf_add_local_field_group(array(
		'key' => 'group_5e15bc813966c',
		'title' => 'Координаты',
		'fields' => array(
			array(
				'key' => 'field_5e15c02333ae8',
				'label' => 'Координаты',
				'name' => 'coordinates',
				'type' => 'yandex',
				'instructions' => '',
				'required' => 1,
				'conditional_logic' => 0,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'xo_place',
				),
			),
		),
		'menu_order' => -1,
		'position' => 'side',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
	));

endif;
