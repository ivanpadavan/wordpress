<?php
/*adding sections for category section in front page*/
$wp_customize->add_section( 'ezy-feature-category', array(
    'priority'       => 160,
    'capability'     => 'edit_theme_options',
    'title'          => __( 'Top Featured Section', 'ezy' ),
    'description'    => __( 'Select Category from the dropdown.', 'ezy' )

) );

/* feature cat selection */
$wp_customize->add_setting( 'ezy_theme_options[ezy-feature-cat]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['ezy-feature-cat'],
    'sanitize_callback' => 'absint'
) );

$wp_customize->add_control(
    new Ezy_Customize_Category_Dropdown_Control(
        $wp_customize,
        'ezy_theme_options[ezy-feature-cat]',
        array(
            'label'		=> __( 'Select Category', 'ezy' ),
            'section'   => 'ezy-feature-category',
            'settings'  => 'ezy_theme_options[ezy-feature-cat]',
            'type'	  	=> 'category_dropdown',
            'priority'  => 10
        )
    )
);