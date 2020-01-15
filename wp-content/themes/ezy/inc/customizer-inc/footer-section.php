<?php 
/*adding sections for footer options*/
    $wp_customize->add_section( 'ezy-footer-option', array(
        'priority'       => 170,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
        'title'          => __( 'Footer Option', 'ezy' )
    ) );
    /*copyright*/

    $wp_customize->add_setting( 'ezy_theme_options[ezy-footer-copyright]', array(
        'capability'        => 'edit_theme_options',
        'default'           => $defaults['ezy-footer-copyright'],
        'sanitize_callback' => 'wp_kses_post'
    ) );

    $wp_customize->add_control( 'ezy-footer-copyright', array(
        'label'     => __( 'Copyright Text', 'ezy' ),
        'section'   => 'ezy-footer-option',
        'settings'  => 'ezy_theme_options[ezy-footer-copyright]',
        'type'      => 'text',
        'priority'  => 10

    ) );



    /*copyright*/

    $wp_customize->add_setting( 'ezy_theme_options[ezy-footer-totop]', array(
        'capability'        => 'edit_theme_options',
        'default'           => $defaults['ezy-footer-totop'],
        'sanitize_callback' => 'ezy_sanitize_checkbox'
    ) );

    $wp_customize->add_control( 'ezy-footer-totop', array(
        'label'     => __( 'Go To Top Option', 'ezy' ),
        'section'   => 'ezy-footer-option',
        'settings'  => 'ezy_theme_options[ezy-footer-totop]',
        'type'      => 'checkbox',
        'priority'  => 10
    ) );