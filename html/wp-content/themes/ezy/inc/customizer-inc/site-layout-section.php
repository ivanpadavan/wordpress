<?php
/*adding sections for category selection for promo section in homepage*/
$wp_customize->add_section( 'ezy-site-layout', array(
    'priority'       => 160,
    'capability'     => 'edit_theme_options',
    'title'          => __( 'Blog Options', 'ezy' )
) );
/* feature cat selection */
$wp_customize->add_setting( 'ezy_theme_options[ezy-layout]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['ezy-layout'],
    'sanitize_callback' => 'ezy_sanitize_select'
) );

$choices = ezy_sidebar_layout();
$wp_customize->add_control('ezy_theme_options[ezy-layout]',
            array(
            'choices'   => $choices,
            'label'		=> __( 'Select Sidebar Layout', 'ezy'),
            'section'   => 'ezy-site-layout',
            'settings'  => 'ezy_theme_options[ezy-layout]',
            'type'	  	=> 'select',
            'priority'  => 10
         )
    );

/* Read More Option */
$wp_customize->add_setting( 'ezy_theme_options[ezy-read-more-text]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['ezy-read-more-text'],
    'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control('ezy_theme_options[ezy-read-more-text]',
            array(
            'label'       => __( 'Read More Text', 'ezy'),
            'description' => __('Continue Reading >> default text change section', 'ezy'),
            'section'     => 'ezy-site-layout',
            'settings'    => 'ezy_theme_options[ezy-read-more-text]',
            'type'        => 'text',
            'priority'    => 10
         )
    );

/* Filter category in blog post */
$wp_customize->add_setting( 'ezy_theme_options[ezy-exclude-slider-category]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['ezy-exclude-slider-category'],
    'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control('ezy_theme_options[ezy-exclude-slider-category]',
            array(
            'label'       => __( 'Exclude Category in Slider', 'ezy'),
            'description' => __('Exclude category by Id. Example, 1, 25, 35', 'ezy'),
            'section'     => 'ezy-site-layout',
            'settings'    => 'ezy_theme_options[ezy-exclude-slider-category]',
            'type'        => 'text',
            'priority'    => 10
         )
    );


/* Sticky Sidebar Option */
$wp_customize->add_setting( 'ezy_theme_options[ezy-sticky-sidebar-option]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['ezy-sticky-sidebar-option'],
    'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control('ezy_theme_options[ezy-sticky-sidebar-option]',
            array(
            'label'       => __( 'Enable/Disable Sticky Sidebar', 'ezy'),
            'description' => __('Checked to enable sticky sidebar', 'ezy'),
            'section'     => 'ezy-site-layout',
            'settings'    => 'ezy_theme_options[ezy-sticky-sidebar-option]',
            'type'        => 'checkbox',
            'priority'    => 10
         )
    );

/* Pagination Options */
$choices = ezy_pagination_option();
$wp_customize->add_setting( 'ezy_theme_options[ezy-blog-pagination-type-options]', array(
    'capability'        => 'edit_theme_options',
    'default'           => $defaults['ezy-blog-pagination-type-options'],
    'sanitize_callback' => 'ezy_sanitize_select'
) );

$wp_customize->add_control('ezy_theme_options[ezy-blog-pagination-type-options]',
            array(
            'choices'     => $choices,
            'label'       => __( 'Pagination Type', 'ezy'),
            'description' => __('Select Pagination Type From Below', 'ezy'),
            'section'     => 'ezy-site-layout',
            'settings'    => 'ezy_theme_options[ezy-blog-pagination-type-options]',
            'type'        => 'select',
            'priority'    => 10
         )
    );