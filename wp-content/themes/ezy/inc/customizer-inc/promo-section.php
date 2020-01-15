<?php
/*adding sections for category section in front page*/
$wp_customize->add_section( 'ezy-promo-category', array(
    'priority'       => 160,
    'capability'     => 'edit_theme_options',
    'title'          => __( 'Promo Section', 'ezy' ),
    'description'    => __( 'Recommended image for Promo section is 360*261', 'ezy' )

) );

/* feature cat selection */
$wp_customize->add_setting( 'ezy_theme_options[ezy-promo-cat]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['ezy-promo-cat'],
    'sanitize_callback' => 'absint'
) );

$wp_customize->add_control(
    new Ezy_Customize_Category_Dropdown_Control(
        $wp_customize,
        'ezy_theme_options[ezy-promo-cat]',
        array(
            'label'		=> __( 'Select Category', 'ezy' ),
            'section'   => 'ezy-promo-category',
            'settings'  => 'ezy_theme_options[ezy-promo-cat]',
            'type'	  	=> 'category_dropdown',
            'priority'  => 10
        )
    )
);

