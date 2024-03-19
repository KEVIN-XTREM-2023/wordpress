<?php
/**
 * Blossom Travel Theme Customizer
 *
 * @package Blossom_Travel
 */

/**
 * Requiring customizer panels & sections
*/
$blossom_travel_panels     = array( 'info', 'site', 'appearance', 'layout', 'slider', 'home', 'blog', 'general', 'footer' );

foreach( $blossom_travel_panels as $p ){
    require get_template_directory() . '/inc/customizer/' . $p . '.php';
}

/**
 * Sanitization Functions
*/
require get_template_directory() . '/inc/customizer/sanitization-functions.php';

/**
 * Active Callbacks
*/
require get_template_directory() . '/inc/customizer/active-callback.php';

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function blossom_travel_customize_preview_js() {
	wp_enqueue_script( 'blossom-travel-customizer', get_template_directory_uri() . '/inc/js/customizer.js', array( 'customize-preview' ), BLOSSOM_TRAVEL_THEME_VERSION, true );
}
add_action( 'customize_preview_init', 'blossom_travel_customize_preview_js' );

function blossom_travel_customize_script(){
    $array = array(
        'home'    => get_permalink( get_option( 'page_on_front' ) ),
        'flushFonts'        => wp_create_nonce( 'blossom-travel-local-fonts-flush' ),
    );
    wp_enqueue_style( 'blossom-travel-customize', get_template_directory_uri() . '/inc/css/customize.css', array(), BLOSSOM_TRAVEL_THEME_VERSION );
    wp_enqueue_script( 'blossom-travel-customize', get_template_directory_uri() . '/inc/js/customize.js', array( 'jquery', 'customize-controls' ), BLOSSOM_TRAVEL_THEME_VERSION, true );
    wp_localize_script( 'blossom-travel-customize', 'blossom_travel_cdata', $array );

    wp_localize_script( 'blossom-travel-repeater', 'blossom_travel_customize',
		array(
			'nonce' => wp_create_nonce( 'blossom_travel_customize_nonce' )
		)
	);
}
add_action( 'customize_controls_enqueue_scripts', 'blossom_travel_customize_script' );

/**
 * Reset font folder
 *
 * @access public
 * @return void
 */
function blossom_travel_ajax_delete_fonts_folder() {
    // Check request.
    if ( ! check_ajax_referer( 'blossom-travel-local-fonts-flush', 'nonce', false ) ) {
        wp_send_json_error( 'invalid_nonce' );
    }
    if ( ! current_user_can( 'edit_theme_options' ) ) {
        wp_send_json_error( 'invalid_permissions' );
    }
    if ( class_exists( '\Blossom_Travel_WebFont_Loader' ) ) {
        $font_loader = new \Blossom_Travel_WebFont_Loader( '' );
        $removed = $font_loader->delete_fonts_folder();
        if ( ! $removed ) {
            wp_send_json_error( 'failed_to_flush' );
        }
        wp_send_json_success();
    }
    wp_send_json_error( 'no_font_loader' );
}
add_action( 'wp_ajax_blossom_travel_flush_fonts_folder', 'blossom_travel_ajax_delete_fonts_folder' );