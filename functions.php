<?php

/**
 * Twenty Sixteen Child Theme functions and definitions
 */

if ( !function_exists( 'twentyseventeen_child_styles' ) ) :
/**
 * Add parent theme stylesheet
 */
function twentyseventeen_child_styles() {
    wp_enqueue_style( 'twentyseventeen-parent-style', get_template_directory_uri() . '/style.css' );
}
endif;
add_action( 'wp_enqueue_scripts', 'twentyseventeen_child_styles' );

/**
 * Start adding some theme options
 */

if ( !function_exists( 'twentyseventeen_child_kirki' ) ) :
/**
 * Add our Kirki fields
 * 
 * For the sake of making this tutorial easier, we will use this function
 * hooked on action hook "init"
 * 
 * In real development, you should use https://github.com/aristath/kirki-helpers
 */
function twentyseventeen_child_kirki() {
    
    if ( !class_exists( 'Kirki' ) ) {
        return;
    }

    // Add configuration
    Kirki::add_config( 'twentyseventeen_child_config', array(
        'capability'    => 'edit_theme_options',
        'option_type'   => 'theme_mod',
    ) );

    // Add our panel for sections
    Kirki::add_panel( 'twentyseventeen_child_panel_id', array(
        'priority'    => 10,
        'title'       => esc_html__( 'My Panel Title', 'twentyseventeen_child' ),
        'description' => esc_html__( 'My Panel Description', 'twentyseventeen_child' )
    ) );

    /**
     * Add demo color control with css output and live preview
     */

    // Add our first section
    Kirki::add_section( 'twentyseventeen_child_section_id', array(
        'title'          => esc_html__( 'My Section Title', 'twentyseventeen_child' ),
        'description'    => esc_html__( 'My Section Description', 'twentyseventeen_child' ),
        'panel'          => 'twentyseventeen_child_panel_id', // Not typically needed.
        'priority'       => 10,
        'capability'     => 'edit_theme_options'
    ) );

    // Add our field to change menu items color
    Kirki::add_field( 'twentyseventeen_child_config', array(
        'type'        => 'color',
        'settings'    => 'twentyseventeen_child_color',
        'label'       => __( 'This is the label for color control', 'twentyseventeen_child' ),
        'section'     => 'twentyseventeen_child_section_id',
        'default'     => '#0088CC',
        'priority'    => 10,
        'choices'     => array(
            'alpha' => true,
        ),
        'transport' => 'postMessage',
        'js_vars'   => array(
            array(
                'element'  => '.main-navigation a',
                'function' => 'css',
                'property' => 'color',
            ),
        ),
        'output' => array(
            array(
                'element'  => '.main-navigation a',
                'property' => 'color',
            ),
        ),
    ) );
    
    /**
     * Override Twenty Seventeen footer copyright
     */

    // Add our footer section
    Kirki::add_section( 'twentyseventeen_child_footer_id', array(
        'title'          => esc_html__( 'My Footer Section', 'twentyseventeen_child' ),
        'description'    => esc_html__( 'My Footer Section Description', 'twentyseventeen_child' ),
        'panel'          => 'twentyseventeen_child_panel_id', // Not typically needed.
        'priority'       => 10,
        'capability'     => 'edit_theme_options'
    ) );

    Kirki::add_field( 'twentyseventeen_child_config', array(
        'type'     => 'textarea',
        'settings' => 'twentyseventeen_child_footer_text',
        'label'    => esc_html__( 'Text Control', 'twentyseventeen_child' ),
        'section'  => 'twentyseventeen_child_footer_id',
        'default'  => esc_attr__( 'This is a defualt copyright text', 'my_textdomain' ),
        'priority' => 10,
        'partial_refresh' => array(
            'twentyseventeen_footer_copyright' => array(
                'selector'        => '.site-info',
                'render_callback' => 'twentyseventeen_child_footer_copyright',
            ),
        ),
        'sanitize_callback' => 'wp_kses_post' // Optional
    ) );

}
endif;
add_action( 'init', 'twentyseventeen_child_kirki' );


/**
 * Add footer copyright function
 */

if ( !function_exists( 'twentyseventeen_child_footer_copyright' ) ) :
/**
 * Enable to control copyright text in footer
 */
function twentyseventeen_child_footer_copyright() {
    return wp_kses_post( get_theme_mod( 'twentyseventeen_child_footer_text', __( 'This is a defualt copyright text', 'my_textdomain' ) ) );
    
}
endif;
