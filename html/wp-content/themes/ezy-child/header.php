<?php
/**
 * The header section of Ezy.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ezy
 */
    global $ezy_theme_options;
	$ezy_theme_options   = ezy_get_theme_options();
?>
<?php
	/**
	 * Hook - ezy_doctype.
	 *
	 * @hooked ezy_doctype_action - 10
	 */
	do_action( 'ezy_doctype' );
?>

<head>

<?php
	/**
	 * Hook - ezy_head.
	 *
	 * @hooked ezy_head_action - 10
	 */
	do_action( 'ezy_head' );


	wp_head(); ?>

</head>

<body <?php body_class('at-sticky-sidebar');?>>
	<div class="<?php echo  esc_attr( $ezy_site_layout ); ?>">
<?php
	/**
	 * Hook - ezy_header_start_wrapper_action.
	 *
	 * @hooked ezy_header_start_wrapper - 10
	 */
	do_action( 'ezy_header_start_wrapper_action' );


	/**
	 * Hook - ezy_skip_link.
	 *
	 * @hooked ezy_skip_link_action - 10
	 */
	do_action( 'ezy_skip_link_action' );


	/**
	 * Hook - ezy_header_section.
	 *
	 * @hooked ezy_header_section_action - 10
	 */
	do_action( 'ezy_header_section_action' );


	/**
	 * Hook - ezy_header_lower_section.
	 *
	 * @hooked ezy_header_lower_section_action - 10
	 */
	do_action( 'ezy_header_lower_section_action' );


	/**
	 * Hook - ezy_header_slider_section.
	 *
	 * @hooked ezy_header_slider_section_action - 10
	 */
	do_action( 'ezy_header_slider_section_action' );


	/**
	 * Hook - ezy_header_promo_action.
	 *
	 * @hooked ezy_header_promo_section_action - 10
	 */
	do_action( 'ezy_header_promo_section_action' );



	/**
	 * Hook - ezy_header_end_wrapper.
	 *
	 * @hooked ezy_header_end_wrapper_action - 10
	 */
	do_action( 'ezy_header_end_wrapper_action' );

?>
