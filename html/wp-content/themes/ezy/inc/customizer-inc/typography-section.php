<?php 
/*adding sections for Typography Option*/
    $wp_customize->add_section( 'ezy-typography-option', array(

        'priority'       => 170,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
        'title'          => __( 'Typography Option', 'ezy' )
    ) );

    /*Typography Option For URL*/
    $wp_customize->add_setting( 'ezy_theme_options[ezy-font-family-url]', array(
        'capability'        => 'edit_theme_options',
        'default'           => $defaults['ezy-font-family-url'],
        'sanitize_callback' => 'esc_url_raw'
    ) );

    $wp_customize->add_control( 'ezy-font-family-url', array(
        'label'       => __( 'Font Family URL Text', 'ezy' ),
        'section'     => 'ezy-typography-option',
        'settings'    => 'ezy_theme_options[ezy-font-family-url]',
        'type'        => 'url',
        'priority'    => 10,
        'description' => sprintf('%1$s <a href="%2$s" target="_blank">%3$s</a> %4$s',
                __( 'Insert', 'ezy' ),
                esc_url('https://www.google.com/fonts'),
                __('Enter Google Font URL' , 'ezy'),
                __('to add google Font.' ,'ezy')
                ),
    ) );

    /*Font Family Name*/
    $wp_customize->add_setting( 'ezy_theme_options[ezy-font-family-name]', array(
        'capability'        => 'edit_theme_options',
        'default'           => $defaults['ezy-font-family-name'],
        'sanitize_callback' => 'sanitize_text_field'
    ) );

    $wp_customize->add_control( 'ezy-font-family-name', array(
        'label'       => __( 'Font Family Name', 'ezy' ),
        'section'     => 'ezy-typography-option',
        'settings'    => 'ezy_theme_options[ezy-font-family-name]',
        'type'        => 'text',
        'priority'    => 10,
        'description' => __( 'Insert Google Font Family Name.', 'ezy' ),
    ) );