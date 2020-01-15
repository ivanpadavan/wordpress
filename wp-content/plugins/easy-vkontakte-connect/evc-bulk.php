<?php

function evc_bulk_admin_init() {
	global $evc_bulk;

	$evc_bulk = new WP_Settings_API_Class2;

	$tabs = array(
		'evc_bulk'           => array(
			'id'            => 'evc_bulk',
			'name'          => 'evc_bulk',
			'title'         => __( 'Массовые операции', 'evc' ),
			'desc'          => __( '', 'evc' ),
			'submit_button' => false,
			'sections'      => array(

				'evc_export_section' => array(
					'id'    => 'evc_export_section',
					'name'  => 'evc_export_section',
					'title' => __( 'Массовые операции', 'evc' ),
					'desc'  => __( 'Массовые операции с записями в группах ВКонтакте.', 'evc' ),
				),
			)
		),
	);
	$tabs = apply_filters( 'evc_bulk_tabs', $tabs, $tabs );


	$fields = array(
		'evc_export_section'         => array(
			array(
				'name'    => 'action',
				'label'   => __( 'Действие', 'evc' ),
				'desc'    => __( '<small>Доступно в <a href = "javascript:void(0);" class = "get-evc-pro">PRO версии</a>.</small><br>Действия с записями.', 'evc' ),
				'type'    => 'radio',
				'default' => 'export',
				'options' => array(
					'delete'      => __( 'Удаление записей из ВК', 'evc' ),
					'delete_videos'      => __( 'Удаление видеозаписей из ВК', 'evc' ),
				)
			),
			array(
				'name' => 'evc_updated',
				'desc' => __( '<small>Доступно в <a href = "javascript:void(0);" class = "get-evc-pro">PRO версии</a>.</small>
			<br>Удалить записи, опубликованные ранее указанной даты (в формате <code>' . gmdate( 'Y-m-d H:i:s', current_time( 'timestamp' ) ) . '</code>).', 'evc' ),
				'type' => 'text'
			),
			array(
				'name' => 'export',
				'desc' => __( '<small>Доступно в <a href = "javascript:void(0);" class = "get-evc-pro">PRO версии</a>.</small><br><br>', 'evc' ) .
				          get_submit_button( __( 'Начать', 'evc' ), 'primary', 'evc_reaction_button', false, 'disabled' ) . '&nbsp;&nbsp;' . '&nbsp;&nbsp;' .
				          get_submit_button( __( 'Остановить', 'evc' ), 'secondary', 'evc_reaction_stop_button', false, 'disabled' ) . '&nbsp;&nbsp;' . '&nbsp;&nbsp;' .
				          '<span id="evc_reaction_ajax[spinner]" style="float:none !important; margin: 0 5px !important;" class="spinner"></span>
				           <span id="evc_reaction_msg"></span>',
				'type' => 'html'
			)

		),

	);
	$fields = apply_filters( 'evc_bulk_fields', $fields, $fields );

	//set sections and fields
	$evc_bulk->set_option_name( 'evc_bulk' );
	$evc_bulk->set_sections( $tabs );
	$evc_bulk->set_fields( $fields );

	//initialize them
	$evc_bulk->admin_init();
}

//add_action( 'admin_init', 'evc_bulk_admin_init' );

// Register the plugin page
function evc_bulk_admin_menu() {
	global $evc_bulk_page;

	$evc_bulk_page = add_submenu_page( 'evc', 'Действия', 'Действия', 'activate_plugins', 'evc-bulk', 'evc_bulk_page' );
}

//add_action( 'admin_menu', 'evc_bulk_admin_menu', 50.01 );


// Display the plugin settings options page
function evc_bulk_page() {
	global $evc_bulk;

	?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"><br/></div>
		<h2><?php _e( 'Массовые действия с записями', 'evc' ); ?></h2>

		<div id="col-container">
			<div id="col-right" class="evc">
				<div class="evc-box">
					<?php evc_ad(); ?>
				</div>
			</div>
			<div id="col-left" class="evc">
				<?php
				settings_errors();
				$evc_bulk->show_navigation();
				$evc_bulk->show_forms();
				?>
			</div>
		</div>
	</div>
	<?php
}
