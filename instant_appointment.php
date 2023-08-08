<?php
/*
Plugin Name: Instant Appointment
Description: Plugin de reservation et de prise de rendez-vous
Author: Tentee Global
Version: 1.1
Plugin URI: https://demo.tenteeglobal.com/outstrip/
*/

define( 'TLPLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'TLPLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'TLPLUGIN_DEFAULT', plugin_dir_url( __FILE__ ). 'assets/images' );



require_once TLPLUGIN_DIR . 'class-instant_appointment.php';
require_once('dompdf/autoload.inc.php');

use Dompdf\Dompdf;
use Dompdf\Options; 

/**
 * Activate the plugin.
 */
function pluginprefix_activate() { 
  include(TLPLUGIN_DIR . 'includes/insapp_tables.php');
  insapp_my_custom_page();
  insapp_file_replace();
}
register_activation_hook( __FILE__, 'pluginprefix_activate' );


function insapp_file_replace() {

  $plugin_dir = plugin_dir_path( __FILE__ ) . 'templates/front-end/insapp_chat.php';
  $theme_dir = get_stylesheet_directory() . '/page-insapp_chat.php';
  $plugin_dir = str_replace('\\', '/', $plugin_dir);
  $theme_dir = str_replace('\\', '/', $theme_dir);

  if (!copy($plugin_dir, $theme_dir)) {
      echo "failed to copy $plugin_dir to $theme_dir...\n";
  }
}
/**
 * Deactivation hook.
 */
function pluginprefix_deactivate() { 
 
}
register_deactivation_hook( __FILE__, 'pluginprefix_deactivate' );

//add admin menu
include(TLPLUGIN_DIR . 'includes/insapp_menus.php' );

//add style
include(TLPLUGIN_DIR . 'includes/enqueue_style.php' );

//add script
include(TLPLUGIN_DIR . 'includes/enqueue_script.php' );

include(TLPLUGIN_DIR . 'includes/insapp_insert.php');

include(TLPLUGIN_DIR . 'includes/ajax/ajax_users.php' );

include(TLPLUGIN_DIR . 'includes/ajax/ajax_customer.php' );

include(TLPLUGIN_DIR . 'includes/ajax/ajax_resa_service.php' );

include(TLPLUGIN_DIR . 'includes/ajax/ajax_rdv.php' );
include(TLPLUGIN_DIR . 'includes/ajax/ajax_services.php' );
include(TLPLUGIN_DIR . 'includes/front-end/ajax/login_ajax.php' );
include(TLPLUGIN_DIR . 'includes/front-end/ajax/reservation_ajax.php' );
include(TLPLUGIN_DIR . 'includes/front-end/ajax/agenda_ajax.php' );




include(TLPLUGIN_DIR . 'includes/users/users_roles.php');

include_once(TLPLUGIN_DIR . 'includes/pages/insapp_short_code.php'); 




include_once(TLPLUGIN_DIR . 'includes/widget/menu.php');

include_once(TLPLUGIN_DIR . 'includes/mail/ia_mail.php'); 
include_once(TLPLUGIN_DIR . 'includes/mail/email_template.php'); 

include_once(TLPLUGIN_DIR . 'includes/settings/general-settings.php');

include_once(TLPLUGIN_DIR . 'includes/front-end/short-code.php');

include_once(TLPLUGIN_DIR . 'includes/front-end/liste_templates.php');
include_once(TLPLUGIN_DIR . 'includes/woocommerce.php');

if ( ! class_exists( 'Gamajo_Template_Loader' ) ) {
    require_once TLPLUGIN_DIR . 'class-gamajo-template-loader.php';
}
include_once(TLPLUGIN_DIR . 'class-insapp-template-loader.php');

function insapp_page($post_title,$post_name,$post_content,$parent_id =NULL){
  // $Page = get_page_by_title($post_title, 'OBJECT', 'page');
  // if( ! empty( $Page ) )
  // {
  //     return ;
  // }
    $my_pages = wp_insert_post(
      array(
      'post_title'    => $post_title,
      'post_status'   => 'publish',
      'post_author'   => get_the_author(),
      'post_type'     => 'page',
      'post_name'      => $post_name,
      'post_content'   => $post_content,
      'comment_status' => 'closed',
      'post_parent'    =>  $parent_id,
    )
      );
      return $my_pages;
}
function insapp_my_custom_page() {

    // Create post object
    insapp_page('account','account','[insapp_authentification]');
    insapp_page('dashboard','dashboard','[insapp_dashboard_render]');
    insapp_page('services','services','[insapp_services]'); 
    insapp_page('insapp_chat_page','insapp_chat_page','');

}


add_action('woocommerce_before_single_product', 'insappp_call_single_services');

function insappp_call_single_services() {
  include_once(TLPLUGIN_DIR . 'templates/front-end/services/single-product.php');
}


add_action( 'wp', 'woo_hide_product_gallery' );
function woo_hide_product_gallery() {

  // if ( is_product() ) { 

    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
    remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

  // }

}	

function register_delete_order_status() {
   register_post_status( 'wc-delete', array(
       'label'                     => 'Delete',
       'public'                    => true,
       'show_in_admin_status_list' => true,
       'show_in_admin_all_list'    => true,
       'exclude_from_search'       => false,
       'label_count'               => _n_noop( 'Delete <span class="count">(%s)</span>', 'Delete <span class="count">(%s)</span>' )
   ) );
}
add_action( 'init', 'register_delete_order_status' );

// Disable the order notification emails
function insapp_disable_order_emails( $enabled, $order ) {
  return false;
}
add_filter( 'woocommerce_email_enabled_new_order', 'insapp_disable_order_emails', 10, 2 );
add_filter( 'woocommerce_email_enabled_customer_processing_order', 'insapp_disable_order_emails', 10, 2 );
add_filter( 'woocommerce_email_enabled_customer_completed_order', 'insapp_disable_order_emails', 10, 2 );
add_filter( 'woocommerce_email_enabled_customer_on_hold_order', 'insapp_disable_order_emails', 10, 2 );
add_filter( 'woocommerce_email_enabled_customer_refunded_order', 'insapp_disable_order_emails', 10, 2 );
add_filter( 'woocommerce_email_enabled_customer_partially_refunded_order', 'insapp_disable_order_emails', 10, 2 );
add_filter( 'woocommerce_email_enabled_customer_note', 'insapp_disable_order_emails', 10, 2 );

// Disable the order status change notification emails
function insapp_disable_order_status_change_emails( $enabled, $order ) {
  return false;
}
add_filter( 'woocommerce_email_enabled_customer_processing_order_status', 'insapp_disable_order_status_change_emails', 10, 2 );
add_filter( 'woocommerce_email_enabled_customer_completed_order_status', 'insapp_disable_order_status_change_emails', 10, 2 );
add_filter( 'woocommerce_email_enabled_customer_on_hold_order_status', 'insapp_disable_order_status_change_emails', 10, 2 );
add_filter( 'woocommerce_email_enabled_customer_refunded_order_status', 'insapp_disable_order_status_change_emails', 10, 2 );
add_filter( 'woocommerce_email_enabled_customer_partially_refunded_order_status', 'insapp_disable_order_status_change_emails', 10, 2 );



function insapp_move_product_tabs() {
  remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10); 
  
  remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
}
add_action('init', 'insapp_move_product_tabs');
  
add_filter( 'wc_order_statuses', 'insapp_delete_order_status');
function insapp_delete_order_status( $order_statuses ) {
    $order_statuses['wc-delete'] = _x( 'Delete', 'Order status', 'woocommerce' ); 
    return $order_statuses;
}


function create_routes( $router ) {
  $router->add_route('facebook-login', array(
      'path' => 'masssaord',
      'access_callback' => true,
      'page_callback' => 'lost_password_callback'
  )); 
  $router->add_route('error', array(
      'path' => 'error',
      'access_callback' => true,
      'page_callback' => 'error'
  ));
}
add_action( 'wp_router_generate_routes', 'create_routes' );
function lost_password_callback() {
  $insapp_templates = new Insapp_Template_Loader;
  $insapp_templates->get_template_part( 'account/lost_password' );	
  exit();
} 



add_action('init', 'insapp_init_widget_elementor');
function insapp_init_widget_elementor() {
 
    // Check if Elementor installed and activated
    if ( ! did_action( 'elementor/loaded' ) ) {
      add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
      return;
    }
    include_once(TLPLUGIN_DIR . 'includes/widget/menu_elementor.php');
}

  function admin_notice_missing_main_plugin() {
    if ( isset( $_GET['activate'] ) ) {
      unset( $_GET['activate'] );
    }
 
    $message = sprintf(
      /* translators: 1: Plugin name 2: Elementor */
      esc_html__( '"%1$s" requires "%2$s" to be installed and activated.'),
      '<strong>' . esc_html__( 'Elementor Zendawesome') . '</strong>',
      '<strong>' . esc_html__( 'Elementor') . '</strong>'
    );
 
    printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
  }

// Display custom fee on the checkout page
// add_action( 'woocommerce_review_order_before_cart_contents', 'ajouter_extra_checkout' );

// function ajouter_extra_checkout() {
//     // Récupérer le panier actuel
//     $cart = WC()->cart;

//     // Vérifier si le panier n'est pas vide
//     if ( ! $cart->is_empty() ) {
//         // Récupérer les informations du produit
//         foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
//             $product_id = $cart_item['product_id'];
//             echo $product_id;
//         }

//         // Récupérer les informations de la commande
//         // $order_id = WC()->session->get('order_awaiting_payment');
//         echo $order_id;
//     }

//     // Le reste de votre code pour ajouter les extras sur la page checkout
// }


add_action( 'init', 'insapp_register_subscription_product_type' );
 
function insapp_register_subscription_product_type() {
 
  class WC_Product_subscription extends WC_Product {
			
    public function __construct( $product ) {
        $this->product_type = 'subscription';
	parent::__construct( $product );
    }
  }
}

/**
     * Add custom Product Type to Select Dropdown
     */
 
add_filter( 'product_type_selector', 'add_subscription_product_type' );
 
function add_subscription_product_type( $types ){
    $types[ 'subscription' ] = __( 'Subscription');
 
    return $types;	
}
/**
     * Hide Attributes data panel.
     */
 
    function wcs_hide_attributes_data_panel( $tabs) {
 
        // Other default values for 'attribute' are; general, inventory, shipping, linked_product, variations, advanced
       $tabs['general']['class'][] = 'show_if_subscription';
        $tabs['attribute']['class'][] = 'hide_if_subscription';
        $tabs['shipping']['class'][] = 'hide_if_subscription';
        $tabs['inventory']['class'][] = 'show_if_subscription';
 
        return $tabs;
 
    }
 
/**
     * Show pricing fields for subscription product.
     */
function subscription_custom_js() {
  if ( 'product' != get_post_type() ) :
      return;
  endif;
  ?><script type='text/javascript'>
  jQuery( document ).ready( function() {
  jQuery( '.options_group.pricing' ).addClass( 'show_if_subscription' ).show();
  jQuery( '.general_options' ).show();
      });
  </script><?php
}
add_action( 'admin_footer', 'subscription_custom_js' );

add_filter( 'woocommerce_product_data_tabs', 'subscription_product_tab' );
function subscription_product_tab( $tabs) {
 
$tabs['subscription'] = array(
'label' => __( 'My Subscription Tab', 'dm_product' ),
'target' => 'subscription_product_options',
'class' => 'show_if_subscription_product',
);
return $tabs;
}
 
add_action( 'woocommerce_product_data_panels', 'QL_custom_product_options_product_tab_content' );
 
function QL_custom_product_options_product_tab_content() {
// Dont forget to change the id in the div with your target of your product tab
?><div id='subscription_product_options' class='panel woocommerce_options_panel'><?php
?><div class='options_group'><?php
 
  woocommerce_wp_checkbox( 
    array(
    'id' => '_enable_custom_product',
    'label' => __( 'Enable Subscription'),
    ) );
 
  woocommerce_wp_text_input(
    array(
    'id' => 'subscription_product_info',
    'label' => __( 'Enter Subscription Details', 'dm_product' ),
    'placeholder' => '',
    'desc_tip' => 'true',
    'description' => __( 'Enter subscription details.', 'dm_product' ),
    'type' => 'text'
    )
  );
  ?></div>
</div><?php
}
add_action( 'woocommerce_process_product_meta', 'save_subscription_product_settings' );
 
function save_subscription_product_settings( $post_id ){
 
	//save checkbox infomation
	$engrave_text_option = isset( $_POST['_enable_custom_product'] ) ? 'yes' : 'no';
   update_post_meta($post_id, '_enable_custom_product', esc_attr( $engrave_text_option ));
 
	// save text field information
  $subscription_product_info = $_POST['subscription_product_info1'];
 
  if( !empty( $subscription_product_info ) ) {
    update_post_meta( $post_id, 'subscription_product_info1', esc_attr( $subscription_product_info ) );
  }
}add_action( 'woocommerce_single_product_summary', 'subscription_product_front' );
 
  function subscription_product_front () {
    global $product;
    if ( 'subscription' == $product->get_type() ) { 
      echo "<strong>Subscription Type: </strong>".( get_post_meta( $product->get_id(), 'subscription_product_info' )[0] );
    }
  
  }
  // Fonction pour envoyer la facture par e-mail lorsqu'une nouvelle commande est créée
function insapp_envoyer_facture_apres_initialisation_paiement($order_id) {
  $order = wc_get_order($order_id);
 
  $customer = wp_get_current_user();
  $to = $customer->user_email;
  $subject = 'facture de réception de votre réservation';
  $headers = array('Content-Type: text/html; charset=UTF-8','From: tentee <'.$customer->user_email.'>','Cc: ReceiverName <second email>' );
  $body = insapp_mail_template_book($order_id);  
  $pieces_jointes = insapp_facturepdf($order_id);
  wp_mail( $to, $subject, $body, $headers,$pieces_jointes);
  // unlink($pieces_jointes);
}
add_action('woocommerce_new_order', 'insapp_envoyer_facture_apres_initialisation_paiement');

add_action( "woocommerce_subscription_add_to_cart", function() {
  do_action( 'woocommerce_simple_add_to_cart' );
});

add_action( 'woocommerce_order_status_processing', 'ajouter_meta_abonnement' );

// Function to add meta when the order goes to processing
function ajouter_meta_abonnement($order_id)
{
  // Récupérer la commande
  $order = wc_get_order($order_id);

  // Vérifier si la commande contient un produit d'abonnement (vous pouvez ajuster cette condition selon vos besoins)
  $items = $order->get_items();
  foreach ($items as $item) {
      $product = $item->get_product();
      var_dump($product);
      if ($product->is_type('subscription')) {
        // Ajouter votre meta ici
        $meta_key = '_order_subscription';
        $meta_value = 'is_subscription';
        $order->update_meta_data($meta_key, $meta_value);

        // Enregistrez les modifications
        $order->save();
        break; // Sortir de la boucle, car nous avons traité un seul produit d'abonnement
      }
  }
}


function insapp_facturepdf($order_id){ 
  
  $order = wc_get_order($order_id ); 
  $order_data = $order->data;
  $customer = $order->get_user();
  $total = $order->get_total();
 

  $customer_name = $customer->display_name;
  $customer_email = $customer->user_email;
  $order_number = $order->get_order_number();
  $date_paid = $order->get_date_paid()->date('d/m/Y');
  $date = get_post_meta( $order_id, '_booking_date', true );
  $time = get_post_meta( $order_id, '_booking_time', true );
  $bd_extras = get_post_meta( $order_id, '_booking_extra', true ); 
  $selected_extras = (isset($bd_extras) && $bd_extras != null) ? json_decode($bd_extras) : [];
  $items = $order->items; 
  $custom_logo_id = get_theme_mod( 'custom_logo' );
                    $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
  foreach( $order->get_items() as $item_id => $item ) {
    $product_name = $item->get_name();
    $product_price =  $item->get_total();
    
}
  
ob_start();
 
require TLPLUGIN_DIR. 'templates/invoice.php';
$html = ob_get_contents();
ob_end_clean(); 


$options = new Options();
$options->set('defaultFont', 'Courier');

$dompdf = new Dompdf($options); 
$dompdf->loadHtml($html, 'UTF-8');
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$output = $dompdf->output();
// $pdfOutput = 'facture'.uniqid(rand(), true).'.pdf';
// file_put_contents( $pdfOutput, $output);

 return $output;
}


?>