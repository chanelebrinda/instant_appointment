<?php

function insapp_settings_page() {

  // If plugin settings don't exist, then create them
  if( false == get_option( 'insapp_general_settings' ) ) {
    add_option( 'insapp_general_settings' );
  }
  add_settings_section( 'Parametre_general', __( 'General' ), 'settings_callback', 'insapp_general');
    // input Field
    add_settings_field( 'Parametre_title',__( 'Nom de l\'entreprise'), 'title_callback','insapp_general','Parametre_general');
    add_settings_field('Parametre_description',__( 'Description'),'description_callback','insapp_general','Parametre_general',);
    add_settings_field('Parametre_mail',__( 'Email'), 'mail_callback','insapp_general','Parametre_general');
    add_settings_field( 'Parametre_adress',__( 'Adresse'), 'adresscallback','insapp_general','Parametre_general');
    add_settings_field('Parametre_numero',__( 'Telephone'), 'numerocallback','insapp_general','Parametre_general');
    add_settings_field('Dashboard_page',__( 'Page Dashboard<p class="fs-6 fw-light text-wrap">Page Principale du tableau de bord</p>', 'insapp_general'), 'insapp_page_dashboard_callback','insapp_general','Parametre_general');
    add_settings_field('Login_page',__( 'Page d\'authentification<p class="fs-6 fw-light text-wrap">Affichage de la Page d\'authentification</p>', 'insapp_general'), 'insapp_page_authentification_callback','insapp_general','Parametre_general');
    add_settings_field('Service_page',__( 'Page de service<p class="fs-6 fw-light text-wrap">Affiche ou liste ajoutee par l\'utilisateur</p>', 'insapp_general'), 'insapp_page_service_callback','insapp_general','Parametre_general');
    

  register_setting(
    'insapp_general_settings',
    'insapp_settings_name'
  );

}
add_action( 'admin_init', 'insapp_settings_page' );

function settings_callback() {

}

function title_callback() {

  $options = get_option( 'insapp_settings_name' );
  $titre = '';
  if( isset( $options[ 'Parametre_title' ] ) ) {
    $titre = esc_html( $options['Parametre_title'] );
  } else{ 
    $titre =  get_site_option( 'site_name' ) ;
  }
  echo '<input type="text" id="Parametre_title" name="insapp_settings_name[Parametre_title]" value="' . $titre . '" />';
}

function description_callback() {

  $options = get_option( 'insapp_settings_name' );
  $titre = '';
  if( isset( $options[ 'Parametre_description' ] ) ) {
    $titre = esc_html( $options['Parametre_description'] );
  } else{ 
    $titre =  get_site_option( '' ) ;
  }
  echo '<textarea id="Parametre_description" name="insapp_settings_name[Parametre_description]">'. $titre .'</textarea>';
}

function mail_callback() {

  $options = get_option( 'insapp_settings_name' );
  $titre = '';
  if( isset( $options[ 'Parametre_mail' ] ) ) {
    $titre = esc_html( $options['Parametre_mail'] );
  } else{ 
    $titre =  get_site_option( 'admin_email' ) ;
  }
  echo '<input type="text" id="Parametre_mail" name="insapp_settings_name[Parametre_mail]" value="' . $titre . '" />';
}

function adresscallback() {

  $options = get_option( 'insapp_settings_name' );
  $titre = '';
  if( isset( $options[ 'Parametre_adress' ] ) ) {
    $titre = esc_html( $options['Parametre_adress'] );
  }
  echo '<input type="text" id="Parametre_adress" name="insapp_settings_name[Parametre_adress]" value="' . $titre . '" />';
}

  function numerocallback() {

    $options = get_option( 'insapp_settings_name' );
    $titre = '';
    if( isset( $options[ 'Parametre_numero' ] ) ) {
      $titre = esc_html( $options['Parametre_numero'] );
    }
    echo '<input type="tel" id="Parametre_numero" name="insapp_settings_name[Parametre_numero]" value="' . $titre . '" />';
    
  }

function insapp_page_dashboard_callback() {

    $options = get_option( 'insapp_settings_name' );
    $secteur = '';
    if( isset( $options[ 'Dashboard_page' ] ) ) {
      $secteur = esc_html( $options['Dashboard_page'] );
    }
    $pages = get_pages( );
    
    $html = '<select id="Dashboard_page" name="insapp_settings_name[Dashboard_page]"> <option selected disable>Selectioner votre secteur </option>';
    foreach($pages as $page){
    
       $html .= '<option value="'.$page->ID.'"' . selected(isset(get_post($secteur)->post_title)?  get_post($secteur)->post_title : '',isset($page)? $page->post_title : '', false) . '>' . $page->post_title . '</option>';
    }
    $html .= '</select>';
    echo $html;
}

function insapp_page_authentification_callback(){

    $options = get_option( 'insapp_settings_name' );
    $secteur = '';
    if( isset( $options[ 'Login_page' ] ) ) {
      $secteur = esc_html( $options['Login_page'] );
    }
    $pages = get_pages( );
    
    $html = '<select id="Login_page" name="insapp_settings_name[Login_page]"> <option selected disable>Selectioner votre secteur </option>';
    foreach($pages as $page){
    
        $html .= '<option value="'.$page->ID.'"' . selected(isset(get_post($secteur)->post_title)?  get_post($secteur)->post_title : '',isset($page)? $page->post_title : '', false) . '>' . $page->post_title . '</option>';
   }
    $html .= '</select>';
    echo $html;

}
function insapp_page_service_callback(){

    $options = get_option( 'insapp_settings_name' );
    $secteur = '';
    if( isset( $options[ 'Service_page' ] ) ) {
      $secteur = esc_html( $options['Service_page'] );
    }
    $pages = get_pages( );
    
    $html = '<select id="Service_page" name="insapp_settings_name[Service_page]"> <option selected disable>Selectioner votre secteur </option>';
    foreach($pages as $page){
    
        $html .= '<option value="'.$page->ID.'"' . selected(isset(get_post($secteur)->post_title)?  get_post($secteur)->post_title : '',isset($page)? $page->post_title : '', false) . '>' . $page->post_title . '</option>';
   }
    $html .= '</select>';
    echo $html;

}
/*****************************  section paiement *********************/

function insapp_config_Payments() {

  if( false == get_option( 'insapp_Payments_Settings' ) ) {
    add_option( 'insapp_Payments_Settings' );
  }

 add_settings_section( 'insapp_setting_payement', __( 'Configuration', 'instant_booking' ), 'insapp_settings_callback', 'insapp_Payments');

  add_settings_field( 'insapp_setting_public_key',__( 'Clé public:', 'instant_booking'), 'insapp_setting_public_key_callback','insapp_Payments','insapp_setting_payement');
  add_settings_field( 'insapp_setting_private_key',__( 'Clé privée:', 'instant_booking'), 'insapp_setting_private_key_callback','insapp_Payments','insapp_setting_payement');

  add_settings_field('insapp_setting_commission',__( 'Commission:', 'instant_booking'), 'insapp_setting_commission_callback','insapp_Payments','insapp_setting_payement');

  register_setting(
    'insapp_Payments_Settings',
    'insapp_payments'
  );

}
add_action( 'admin_init', 'insapp_config_Payments');

function insapp_setting_commission_callback() {

  $options = get_option( 'insapp_payments' );
  $number = '';
  if( isset( $options[ 'insapp_setting_commission' ] ) ) {
    $number = esc_html( $options['insapp_setting_commission'] );
  }
  
  $html = '<input type="number" id="insapp_setting_commission" name="Payments_Settings[insapp_setting_commission]" value="' . $number . '"  min="0" max="5"/>';
  echo $html;
}


function insapp_setting_public_key_callback() {

  $options = get_option( 'insapp_payments' );
  $public_key = '';
  if( isset( $options[ 'insapp_setting_public_key' ] ) ) {
    $public_key = esc_html( $options['insapp_setting_public_key'] );
  }
  $html = '<input type="text" class="form-control col-lg-4 col-md-6" id="insapp_setting_public_key" name="insapp_payments[insapp_setting_public_key]" value="' . $public_key . '"/>';
  echo $html;
}
function insapp_setting_private_key_callback() {

  $options = get_option( 'insapp_payments' );
  $privata_key = '';
  if( isset( $options[ 'insapp_setting_private_key' ] ) ) {
    $privata_key = esc_html( $options['insapp_setting_private_key'] );
  }
 
  $html = '<input type="text" class="form-control col-lg-4 col-md-6" id="insapp_setting_private_key" name="insapp_payments[insapp_setting_private_key]" value="' . $privata_key . '"/>';
  echo $html;
}