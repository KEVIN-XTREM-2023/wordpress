<?php
/**
 * Instagram Section
 * 
 * @package Blossom_Travel
 */

$sec_title      = get_theme_mod( 'instagram_title', __( 'Instagram', 'blossom-travel' ) );

$ed_instagram = get_theme_mod( 'ed_instagram', true );
$insta_code   = get_theme_mod( 'instagram_shortcode', '[instagram-feed]' );

if( $ed_instagram ){
    echo '<div id="instagram_section" class="instagram-section">';
    if( $sec_title ) echo '<h2 class="section-title">' . esc_html( $sec_title ) . '</h2>';
    echo do_shortcode( $insta_code );
    echo '</div>';    
}