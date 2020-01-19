<?php
/**
 * Dynamic css
 *
 * @since Ezy 1.0.0
 *
 * @param null
 * @return null
 *
 */
if (!function_exists('ezy_dynamic_css')) :
 function ezy_dynamic_css()
    {
   global $ezy_theme_options;
        $ezy_font_family = esc_attr( $ezy_theme_options['ezy-font-family-name'] );
        
        $custom_css = '';
        /* Typography Section */

        if (!empty($ezy_font_family)) {
            
            $custom_css .= "body { font-family: {$ezy_font_family}; }";
        }

        wp_add_inline_style('ezy-style', $custom_css);
    }
endif;
add_action('wp_enqueue_scripts', 'ezy_dynamic_css', 99);