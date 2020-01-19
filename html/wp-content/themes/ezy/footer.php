<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ezy
 */
  	/**
	 * Hook - ezy_container_closing_action.
	 *
	 * @hooked ezy_container_closing_action - 10
	 */
	do_action( 'ezy_container_closing_action' );


  	/**
	 * Hook - ezy_site_footer_start_action.
	 *
	 * @hooked ezy_site_footer_start_action - 10
	 */
	do_action( 'ezy_site_footer_start_action' );


	/**
	 * Hook - ezy_site_footer_widget_action.
	 *
	 * @hooked ezy_site_footer_widget_action - 10
	 */
	do_action( 'ezy_site_footer_widget_action' );

	/**
	 * Hook - ezy_footer_site_info_action.
	 *
	 * @hooked ezy_footer_site_info_action - 10
	 */
	do_action( 'ezy_footer_site_info_action' );

	/**
	 * Hook - ezy_footer_closing_action.
	 *
	 * @hooked ezy_footer_closing - 10
	 */
	do_action( 'ezy_footer_closing_action' );


    wp_footer(); ?>
</div>

</body>
</html>
