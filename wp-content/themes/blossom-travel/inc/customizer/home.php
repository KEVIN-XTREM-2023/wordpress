<?php
/**
 * Front Page Settings
 *
 * @package Blossom_Travel
 */

function blossom_travel_customize_register_frontpage( $wp_customize ) {
	
    /** Front Page Settings */
    $wp_customize->add_panel( 
        'frontpage_settings',
         array(
            'priority'    => 40,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'Front Page Settings', 'blossom-travel' ),
            'description' => __( 'Static Home Page settings.', 'blossom-travel' ),
            'active_callback' => 'blossom_travel_is_active_page',
        ) 
    );

    /** Blog Section */
    $wp_customize->add_section(
        'blog_section',
        array(
            'title'    => __( 'Blog Section', 'blossom-travel' ),
            'priority' => 45,
            'panel'    => 'frontpage_settings',
        )
    );

    /** Blog Options */
    $wp_customize->add_setting(
        'ed_blog_section',
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_travel_sanitize_checkbox'
        )
    );

    $wp_customize->add_control(
        new Blossom_Travel_Toggle_Control(
            $wp_customize,
            'ed_blog_section',
            array(
                'label'       => __( 'Enable Blog Section', 'blossom-travel' ),
                'description' => __( 'Enable to show blog section.', 'blossom-travel' ),
                'section'     => 'blog_section',
            )            
        )
    );

    /** Blog title */
    $wp_customize->add_setting(
        'blog_section_title',
        array(
            'default'           => __( 'Explore all New Trending Stories', 'blossom-travel' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'blog_section_title',
        array(
            'section' => 'blog_section',
            'label'   => __( 'Blog Title', 'blossom-travel' ),
            'type'    => 'text',
        )
    );

    // Selective refresh for blog title.
    $wp_customize->selective_refresh->add_partial( 'blog_section_title', array(
        'selector'            => '.trending-stories-section h2.section-title',
        'render_callback'     => 'blossom_travel_get_blog_section_title',
    ) );
    
    /** View All Label */
    $wp_customize->add_setting(
        'blog_view_all',
        array(
            'default'           => __( 'View More', 'blossom-travel' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'blog_view_all',
        array(
            'label'           => __( 'View All Label', 'blossom-travel' ),
            'section'         => 'blog_section',
            'type'            => 'text',
            'active_callback' => 'blossom_travel_blog_view_all_ac'
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'blog_view_all', array(
        'selector' => '.trending-stories-section .button-wrap .btn-readmore',
        'render_callback' => 'blossom_travel_get_blog_view_all_btn',
    ) ); 
    /** Blog Section Ends */

    /** Instagram Settings */
    $wp_customize->add_section(
        'instagram_section',
        array(
            'title'    => __( 'Instagram Section', 'blossom-travel' ),
            'priority' => 80,
            'panel'    => 'frontpage_settings',
        )
    );
    
    /** Enable Instagram Section */
    $wp_customize->add_setting( 
        'ed_instagram', 
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_travel_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Travel_Toggle_Control( 
            $wp_customize,
            'ed_instagram',
            array(
                'section'     => 'instagram_section',
                'label'       => __( 'Enable Instagram Section', 'blossom-travel' ),
                'description' => __( 'Enable to show Instagram Section', 'blossom-travel' ),
            )
        )
    );

    /** instagram title */
    $wp_customize->add_setting(
        'instagram_title',
        array(
            'default'           => __( 'Instagram', 'blossom-travel' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'instagram_title',
        array(
            'section'         => 'instagram_section',
            'label'           => __( 'Section Title', 'blossom-travel' ),
            'type'            => 'text',
            'active_callback' => 'blossom_travel_instagram_ac',
        )
    );

    // Selective refresh for blog title.
    $wp_customize->selective_refresh->add_partial( 'instagram_title', array(
        'selector'            => '.instagram-section h2.section-title',
        'render_callback'     => 'blossom_travel_get_instagram_title',
    ) );

    $wp_customize->add_setting( 
        'instagram_shortcode', 
        array(
            'default'           => '[instagram-feed]',
            'sanitize_callback' => 'sanitize_text_field'
        )
    );
    
    $wp_customize->add_control(
        'instagram_shortcode',
        array(
            'section'         => 'instagram_section',
            'label'           => __( 'Shortcode', 'blossom-travel' ),
            'type'            => 'text',
            'description'     => __( 'Add shortcode for your instagram profile below:', 'blossom-travel' ),
            'active_callback' => 'blossom_travel_instagram_ac',
        )
    );
}
add_action( 'customize_register', 'blossom_travel_customize_register_frontpage' );