<?php
add_shortcode( 'insapp_dashboard',  'insapp_dashboard_template' );

add_shortcode( 'insapp_listing_service',  'insapp_listing_service_template' );
function insapp_listing_service_template(){
include_once(TLPLUGIN_DIR . 'templates/front-end/listing.php');
    
}



add_shortcode( 'insapp_chat',  'insapp_chat_template' );
function insapp_chat_template(){
include_once(TLPLUGIN_DIR . 'templates/front-end/chat.php');
    
}



add_shortcode( 'insapp_authentification',  'insapp_authentification_template' );
function insapp_authentification_template(){
include_once(TLPLUGIN_DIR . 'templates/front-end/account/login.php');
    
}



add_shortcode( 'insapp_dashboard_render',  'insapp_dashboard_render' );
function insapp_dashboard_render($atts){
include_once(TLPLUGIN_DIR . 'templates/front-end/dashboard/dashboard.php');
}


add_shortcode( 'insapp_my_service',  'insapp_my_service' );
function insapp_my_service($atts){
include_once(TLPLUGIN_DIR . 'templates/front-end/dashboard/my_booking.php');
}


add_shortcode( 'insapp_profil',  'insapp_profil' );
function insapp_profil($atts){
include_once(TLPLUGIN_DIR . 'templates/front-end/dashboard/profil.php');
}


add_shortcode( 'insapp_chat',  'insapp_chat' );
function insapp_chat($atts){
include_once(TLPLUGIN_DIR . 'templates/front-end/dashboard/chat.php');
}


add_shortcode( 'insapp_paiement',  'insapp_paiement' );
function insapp_paiement($atts){
include_once(TLPLUGIN_DIR . 'templates/front-end/dashboard/payment.php');
}

add_shortcode( 'insapp_services',  'insapp_services_listing' );
function insapp_services_listing($atts){
    $atts = shortcode_atts( array(
        'number' => -1,  
    ), $atts, 'insapp_services' );

    $number_elements = intval( $atts['number'] );

    include_once(TLPLUGIN_DIR . 'templates/front-end/services/listing.php');
}