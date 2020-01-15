<?php
/**
 * ezy Theme Customizer.
 *
 * @package ezy
 */
/**
 * Sanitizing the select callback example
 *
 * @since ezy 1.0.0
 *
 * @see sanitize_key()https://developer.wordpress.org/reference/functions/sanitize_key/
 * @see $wp_customize->get_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/get_control/
 *
 * @param $input
 * @param $setting
 * @return sanitized output
 *
 */
if ( !function_exists('ezy_sanitize_select') ) :
   
    function ezy_sanitize_select( $input, $setting ) {

        // Ensure input is a slug.
        $input = sanitize_key( $input );

        // Get list of choices from the control associated with the setting.
        $choices = $setting->manager->get_control( $setting->id )->choices;

        // If the input is a valid key, return it; otherwise, return the default.
        return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
    }
endif;

/**
 * Sanitize checkbox field
 *
 *  @since Ezy 1.0.0
 */
if (!function_exists('ezy_sanitize_checkbox')) :
    function ezy_sanitize_checkbox($checked)
    {
        // Boolean check.
        return ((isset($checked) && true == $checked) ? true : false);
    }
endif;


/**
 * Sidebar layout options
 *
 * @since ezy 1.0.0
 *
 * @param null
 * @return array $ezy_sidebar_layout
 *
 */
if ( !function_exists('ezy_sidebar_layout') ) :
   
    function ezy_sidebar_layout() {
        $ezy_sidebar_layout =  array(
            'right-sidebar' => __( 'Right Sidebar', 'ezy'),
            'left-sidebar'  => __( 'Left Sidebar' , 'ezy'),
            'no-sidebar'    => __( 'No Sidebar', 'ezy')
        );
        return apply_filters( 'ezy_sidebar_layout', $ezy_sidebar_layout );
    }
endif;

/**
 * Pagination options
 *
 * @since ezy 1.0.0
 *
 * @param null
 * @return array $ezy_pagination_option
 *
 */
if ( !function_exists('ezy_pagination_option') ) :
   
    function ezy_pagination_option() {
      
        $ezy_pagination_option =  array(
            'default'  => __( 'Default Pagination', 'ezy'),
            'numeric'  => __( 'Numeric Pagination' , 'ezy')
        );
      
        return apply_filters( 'ezy_pagination_option', $ezy_pagination_option );
    }
endif;

/**
 *  Default Theme options
 *
 * @since ezy 1.0.0
 *
 * @param null
 * @return array $ezy_theme_layout
 *
 */
if ( !function_exists('ezy_default_theme_options') ) :
    function ezy_default_theme_options() {

        $default_theme_options = array(
            /*feature section options*/
            'ezy-feature-cat'                  => 0,
            'ezy-promo-cat'                    => 0,
            'ezy-footer-copyright'             => esc_html__('&copy; All Right Reserved','ezy'),
            'ezy-layout'                       => 'right-sidebar',
            'ezy-font-family-url'              => esc_url('//fonts.googleapis.com/css?family=Open+Sans:300,400', 'ezy'),
            'ezy-font-family-name'             => esc_html__('Open Sans, sans-serif','ezy'),          
            'ezy-footer-totop'                 => 1,
            'ezy-read-more-text'               => esc_html__('Continue Reading','ezy'),
            'ezy-header-social'                => 0,
            'ezy-header-search'                => 0,
            'ezy-sticky-sidebar-option'        => 1,
            'ezy-exclude-slider-category'      => '',
            'ezy-blog-pagination-type-options' => 'default',
);
        return apply_filters( 'ezy_default_theme_options', $default_theme_options );
    }
endif;


/**
     * Load Update to Pro section
     */
     require get_template_directory() . '/inc/customizer-pro/class-customize.php';


/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function ezy_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'refresh';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'refresh';
    $wp_customize->get_setting( 'custom_logo' )->transport      = 'refresh';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    /*defaults options*/
    $defaults = ezy_get_theme_options();
       
    /**
     * Load customizer custom-controls
     */
    require get_template_directory() . '/inc/customizer-inc/custom-controls.php';

    /**
     * Load customizer feature section
     */
    require get_template_directory() . '/inc/customizer-inc/feature-section.php';

     /**
     * Load customizer feature section
     */
    require get_template_directory() . '/inc/customizer-inc/promo-section.php';
    
    
    /**
     * Load customizer Design Layout section
     */
    require get_template_directory() . '/inc/customizer-inc/site-layout-section.php';

    /**
     * Load customizer Typography
     */
    require get_template_directory() . '/inc/customizer-inc/typography-section.php';

    /**
     * Load customizer custom-controls
     */
    require get_template_directory() . '/inc/customizer-inc/footer-section.php';
	
	   /**
     * Load customizer custom-controls
     */
    require get_template_directory() . '/inc/customizer-inc/header-section.php';

}
add_action( 'customize_register', 'ezy_customize_register' );

/**
 * Load dynamic css file
*/
require get_template_directory() . '/inc/dynamic-css.php';


/**
 *  Get theme options
 *
 * @since ezy 1.0.0
 *
 * @param null
 * @return array ezy_theme_options
 *
 */
if ( !function_exists('ezy_get_theme_options') ) :
    function ezy_get_theme_options() {

        $ezy_default_theme_options = ezy_default_theme_options();
        

     $ezy_get_theme_options     = get_theme_mod( 'ezy_theme_options');
        
        if( is_array( $ezy_get_theme_options ))
        {
            return array_merge( $ezy_default_theme_options, $ezy_get_theme_options );
        }

        else
        {
            
            return $ezy_default_theme_options;
        }

    }
endif;

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function ezy_customize_preview_js() {
	
    wp_enqueue_script( 'ezy-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151216', true );
}
add_action( 'customize_preview_init', 'ezy_customize_preview_js' );
