<?php 
/*adding sections for footer options*/
    $wp_customize->add_section( 'ezy-header-option', array(
        'priority'       => 150,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
        'title'          => __( 'Header Option', 'ezy' )
    ) );
    /*Search Option*/
    $wp_customize->add_setting( 'ezy_theme_options[ezy-header-search]', array(
        'capability'        => 'edit_theme_options',
        'default'           => $defaults['ezy-header-search'],
        'sanitize_callback' => 'ezy_sanitize_checkbox'
    ) );
    $wp_customize->add_control( 'ezy-header-search', array(
        'label'       => __( 'Enable/Disable Search in Header', 'ezy' ),
        'description' => __('Enable Header Top Section First Above', 'ezy'),
        'section'     => 'ezy-header-option',
        'settings'    => 'ezy_theme_options[ezy-header-search]',
        'type'        => 'checkbox',
        'priority'    => 10
    ) );

    /*Social Options */
    $wp_customize->add_setting( 'ezy_theme_options[ezy-header-social]', array(
        'capability'        => 'edit_theme_options',
        'default'           => $defaults['ezy-header-social'],
        'sanitize_callback' => 'ezy_sanitize_checkbox'
    ) );
    $wp_customize->add_control( 'ezy-header-social', array(
        'label'     => __( 'Enable/Disable Social in Header', 'ezy' ),
        'section'   => 'ezy-header-option',
        'settings'  => 'ezy_theme_options[ezy-header-social]',
        'type'      => 'checkbox',
        'priority'  => 10
    ) );
