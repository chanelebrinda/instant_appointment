<?php
add_action( 'wp_ajax_reservation_service','reservation_service');
add_action( 'wp_ajax_nopriv_reservation_service','reservation_service');
function reservation_service(){
    
    $customer = wp_get_current_user();
    $extra = sanitize_text_field($_POST['extra']);
    $service_id = sanitize_text_field( $_POST['service_id'] );
    $photograph_id = get_post($service_id)->post_author;
    $booking_date = sanitize_text_field( $_POST['insapp_booking_date'] );
    $booking_time = sanitize_text_field( $_POST['insapp_booking_time'] );
    // wp_send_json(wc_get_product( $service_id ));
    $price = wc_get_product( $service_id )->get_sale_price();
    $total_price =  sanitize_text_field( $_POST['Total_price'] );
    $price_params = array( 'totals' => array( 'subtotal' => $price, 'total' => $total_price ) );
    $order = wc_create_order();
    $order->add_product( wc_get_product( $service_id  ) , $item['quantity'], $price_params );
    $order->set_address( $customer, 'billing' );
    $order->set_customer_id( $customer->ID );
    $order->calculate_totals();
    $order->set_status( 'wc-on-hold', 'Order is created programmatically' );
    $order->save();
    add_post_meta( $order->id, '_booking_date', $booking_date );
    add_post_meta( $order->id, '_booking_time', $booking_time );
    add_post_meta( $order->id, '_booking_extra', $extra );
    
    $title = "Nouvelle reservation";
    $message = "Une reservation vient d\'etre effectuee";
    $statut = 'unread';
    $reception = "photographe";
    
    if(isset($order)){ 

      $code = insapp_insert_notification($title,$message,$statut,intval($customer->ID),intval($photograph_id),$reception); 
      $to = $customer->user_email;
      $subject = 'Confirmation de réception de votre réservation';
      $headers = array('Content-Type: text/html; charset=UTF-8','From: tentee <'.$customer->user_email.'>','Cc: ReceiverName <second email>' );
      $body = insapp_mail_template_book($order_id); 
      
     wp_mail( $to, $subject, $body, $headers);
   
      $resp = array(
        'code' => 200,
        'message' => 'Reservation réussie',
        'code_resa' => $extra
      );

    }else{
      $resp = array(
        'status' => 400,
        'message' => 'Une erreur s\'est produite veuillez contacter l\'administrateur',
      );
    }
    wp_send_json(  $resp );

}

add_action( 'wp_ajax_cancelled_order_status','cancelled_order_status_callback');
add_action( 'wp_ajax_nopriv_cancelled_order_status','cancelled_order_status_callback');
function cancelled_order_status_callback(){
    $order_id = sanitize_text_field( $_POST['order_id'] );
    $order = wc_get_order($order_id);
    if (!empty($order)) {
      $update_status = $order->update_status('cancelled');
      $customer_id = $order -> get_user_id (); 
      $customer = get_user_by('id', $customer_id);
      $items = $order->get_items();
      foreach ( $items as $item ) { 
        $product_id = $item['product_id']; 
      } 
        $product = get_post($product_id); 
        $author_id  = $product->post_author;
        $author_email = get_user_by('ID', $product->post_author)->user_email;

        $title = "Reservation Annulée";
        $message = "Le photographe a annulé votre reservation";
        $statut = 'unread';
        $reception = "client";
        insapp_insert_notification($title,$message,$statut,intval($customer->ID),intval($author_id),$reception); 

         $to = $customer->user_email;
         $subject = "Réservation annulée par le photographe";
         $headers = array('Content-Type: text/html; charset=UTF-8','From: tentee <'.$customer->user_email.'>','Cc: ReceiverName <second email>' );
         $body = insapp_mail_template_book_cancel($order_id); 

        wp_mail( $to, $subject, $body, $headers);

        // wp_send_json(  $update_status );
    }else{
         $update_status = 'commande vide!';
    }
    wp_send_json($update_status);
}

add_action( 'wp_ajax_cancelled_cient_order_status','cancelled_cient_order_status_callback');
add_action( 'wp_ajax_nopriv_cancelled_cient_order_status','cancelled_cient_order_status_callback');
function cancelled_cient_order_status_callback(){
    $order_id = sanitize_text_field( $_POST['order_id'] );
    $order = wc_get_order($order_id);
    $customer_id = $order -> get_user_id ();
    $customer = get_user_by('id', $customer_id);
    if (!empty($order)) {
      $update_status = $order->update_status('cancelled');
      $items = $order->get_items();
      foreach ( $items as $item ) { 
        $product_id = $item['product_id']; 
      } 
        $product = get_post($product_id); 
        $author_id  = $product->post_author;
        $author_email = get_user_by('ID', $product->post_author)->user_email;

        $title = "Reservation Annulée";
        $message = "Un client a annulé la reservation de cette annonce";
        $statut = 'unread';
        $reception = "photographe";
        insapp_insert_notification($title,$message,$statut,intval($customer->ID),intval($author_id),$reception); 

         $to = $author_email;
         $subject = "Réservation annulée par le client";
         $headers = array('Content-Type: text/html; charset=UTF-8','From: tentee <'.$customer->user_email.'>','Cc: ReceiverName <second email>' );
         $body = insapp_mail_template_client_cancel($order_id); 

        wp_mail( $to, $subject, $body, $headers);

    }else{
         $update_status = 'commande vide!';
    }
 
    wp_send_json($update_status);
}

add_action( 'wp_ajax_deleted_order_status','deleted_order_status_callback');
add_action( 'wp_ajax_nopriv_deleted_order_status','deleted_order_status_callback');
function deleted_order_status_callback(){
    $order_id = sanitize_text_field( $_POST['order_id'] );
    $order = new WC_Order($order_id);
    if (!empty($order)) {
        $update_status = $order->update_status( 'delete' );
    }else{
         $update_status = 'commande vide!';
    };
    wp_send_json($update_status);
}

add_action( 'wp_ajax_payement_order_process','payement_order_process_callback');
add_action( 'wp_ajax_nopriv_payement_order_process','payement_order_process_callback');
function payement_order_process_callback(){

  if (isset($_POST['order_id'])) {
    $order_id = sanitize_text_field($_POST['order_id']);
    $order = wc_get_order($order_id);
      if ($order) {
          $payment_url = $order->get_checkout_payment_url();
          // Redirigez le client vers la page de paiement de cette commande

          wp_send_json($payment_url);

      }
  }else{
    wp_send_json_error( 'La commande n\'existe pas.' );
  }

}



add_action( 'wp_ajax_accepted_order_status','accepted_order_status_callback');
add_action( 'wp_ajax_nopriv_accepted_order_status','accepted_order_status_callback');
function accepted_order_status_callback(){
   $order_id = sanitize_text_field( $_POST['order_id'] );

    $order = new WC_Order($order_id);
    if (!empty($order)) {
      $update_status = $order->update_status( 'pending' );
        $customer_id = $order -> get_user_id (); 
        $customer = get_user_by('id', $customer_id);

        $items = $order->get_items();
        foreach ( $items as $item ) { 
          $product_id = $item['product_id']; 
      } 
        $product = get_post($product_id); 
        $author_id  = $product->post_author;
        $author_name = get_user_by('ID', $product->post_author)->user_nicename;
        $author_email = get_user_by('ID', $product->post_author)->user_email;
        $pieces_jointes = insapp_facturepdf($order_id);
        $title = "Reservation Approuvée";
        $message = "Le photographe a approuvé votre reservation";
        $statut = 'unread';
        $reception = "client";
        insapp_insert_notification($title,$message,$statut,intval($customer->ID),intval($author_id),$reception); 

         $to = $customer->user_email;
         $subject = "Confirmation d'approbation de votre réservation";
         $headers = array('Content-Type: text/html; charset=UTF-8','From: tentee <'.$customer->user_email.'>','Cc: ReceiverName <second email>' );
         $body = insapp_mail_template_book_approve($order_id); 

        wp_mail( $to, $subject, $body, $headers, $pieces_jointes);

        // wp_send_json(  $update_status );
    }else{
         $update_status = 'commande vide!';
    }
    wp_send_json($update_status);
}

add_action( 'wp_ajax_achived_order_status','achived_order_status_callback');
add_action( 'wp_ajax_nopriv_achived_order_status','achived_order_status_callback');
function achived_order_status_callback(){
    $order_id = sanitize_text_field( $_POST['order_id'] );

    $order = new WC_Order($order_id);
    if (!empty($order)) {
        $update_status = $order->update_status( 'completed' );
        $title = "Reservation Terminée";
        $message = "Le photographe a marqué cette reservation comme terminé";
        $statut = 'unread';
        $reception = "client";
        insapp_insert_notification($title,$message,$statut,intval($customer->ID),intval($photograph_id),$reception); 

    }else{
         $update_status = 'commande vide!';
    }
    wp_send_json($update_status);
}


add_action( 'wp_ajax_filter_state','filter_state_callback');
add_action( 'wp_ajax_nopriv_filter_state','filter_state_callback');
function filter_state_callback(){
    $etat = sanitize_text_field( $_POST['etat'] );
    ob_start();
    
    $current_user = wp_get_current_user();
    $author_id = $current_user->ID;
    $args1 = array(
        'author' => $author_id,
        'post_type' => 'product',
        'orderby' => 'author',
        'numberposts'      => -1,
    );
    $user_posts = get_posts( $args1 );
    $the_post = array();
    foreach($user_posts as $a_post){
        $the_post[] = $a_post->ID;
    }
    $args = array(
        'status' => $etat,
        'limit' => -1, 
    );
    $orders = wc_get_orders($args);
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $orders_per_page = 3;
    $total_pages = ceil(count($orders) / $orders_per_page);
    $orders_chunked = array_chunk($orders, $orders_per_page);
    $current_orders = isset($orders_chunked[$paged - 1]) ? $orders_chunked[$paged - 1] : array();

 
    if(!empty($current_orders)){
    foreach($current_orders as $order){
        $order_id = $order->id;
        $item = wc_get_order($order_id );
        $order_data = $order->data;
        $customer_id = $order -> get_user_id (); 
        $customer = get_user_by('id', $customer_id);
        $customer_name = $customer->display_name;
        $customer_email = $customer->user_email;
        $date = get_post_meta( $order_id, '_booking_date', true );
        $time = get_post_meta( $order_id, '_booking_time', true );
        $bd_extras = get_post_meta( $order_id, '_booking_extra', true );
        $extras = isset($bd_extras) ? json_decode($bd_extras) : [];
        
        foreach ($item->get_items() as $item_id => $item_order ) {
            $product = $item_order->get_product();
            $product_id = $product->id;

            $categories = wp_get_post_terms($product_id, 'product_cat');
            $meta = get_post_meta($product_id);
            $dure = isset($meta['_duration'][0]) ? $meta['_duration'][0] : 'undefine'; 
            $title = $product->post_name;
            $status = $order_data[ 'status' ] ;
            switch ($status) {
                case 'cancelled':{
                $btn = '<button class="dropdown-item d-flex align-items-center insapp_btn_state btn_delete" type="button" data-id="'.$order_id.'" id="btn_delete">Supprimer
                        </button>';
                    $statut = 'Refusé';
                    break;
                }   
                
                case 'pending':{
                    $btn = '<button class="dropdown-item d-flex align-items-center insapp_btn_state btn_fini" data-id="'.$order_id.'" type="button" id="btn_fini">Terminer
                            </button>';
                    $statut = 'Accepté';
                    break;

                }
                
                case 'completed':{
                    $btn = '';
                    $statut = 'Terminé';
                    break;

                }
                    
                
                case 'on-hold':{ 
                    $btn = '<div class="d-flex">
                    <button class="dropdown-item d-flex align-items-center insapp_btn_state btn_accepter" data-id="'. $order_id.'" type="button" id="btn_accepter">Accepter
                    </button>

                    <button class="dropdown-item d-flex align-items-center insapp_btn_state text-danger btn_refuser" data-id="'. $order_id.'" type="button" id="btn_refuser">Annuler
                    </button>
                    </div>';
                    $statut = 'En attente';
                    break;
                }
                default:{
                  break;
                }
                    
            }
              if($statut == 'Refusé'){
                $color = 'danger';
              }elseif($statut == 'Accepté'){
                $color = 'success';
              }elseif($statut == 'Terminé'){
                $color = 'primary';
              }else{
                $color = 'warning';
              }                                                         

            if(in_array($product_id, $the_post)){
              

        ?>
          <div class="row insapp_listing_timeline py-2"> 
                    <span></span>
                    <input type="hidden" name="the_order_id" id="the_order_id" value="<?php echo $order_id; ?>">
            </div>
          <div class="">
            <div class="row insapp_listing">
              <div class="col-6">

                <div class="d-flex align-items-center mb-3 mb-xl-0" style="width:100%">
                   <div class="insapp_gallery" style="width:40%;background-image: url('<?php _e(get_the_post_thumbnail_url( $product_id))?>')"> </div>
          
                  <div class="ms-3"  style="width:60%">
                    <div class="">
                      <span class="ia_table_title" style="vertical-align: inherit;"><?php echo '<span>' .  $title .'</span>' ?></span>
                    </div>
                    <span class="mb-0 ia_table_text">
                      <?php echo('Rendez-vous : '.$time) ?>
                    </span></br>
                    <span class="mb-0 ia_table_text">
                      <?php echo('Le : '.$date) ?>
                    </span></br> <span class="mb-0 ia_table_text"><?php echo 'prix: '.$order_data [ 'total' ].' '. $order_data['currency']; ?></span>
                  </div>
                </div>

              </div>
              <div class="col-2 d-flex align-items-center ">
                <span class="badge badge-<?php echo $color; ?>-soft text-<?php echo $color; ?>">
                  <span style="vertical-align: inherit;">
                    <span style="vertical-align: inherit;"><?php echo $statut ; ?></span>
                  </span>
                </span>
              </div>

              <div class="col-4 d-flex justify-content-end align-items-center " data-toggle="collapse"
                href="#listingcollapse" role="button" aria-expanded="false" aria-controls="listingcollapse">
                <span class="ia_table_collapse"><?php echo $btn ?></span>
              </div>
              <div class="" id="listingcollapse">
                <div class="detailslistingcollapse d-flex flex-column">
                  <div class="mb-0 row">
                    <span class="ia_table_subtitle col-4"><?php _e('Catégories: ') ?></span>
                    <?php foreach($categories as $category){?>
                    <span class="ia_table_text  col-8"><?php echo $category->name; ?></span>
                    <?php }?>
                  </div>
                  <!-- <div class="mb-0 row">
                    <span class="ia_table_subtitle col-4"><?php _e('Extras') ?></span>
                    <span class="ia_table_text  col-8">
                      <?php foreach($extras as $extra){?>
                          <li class="col"><?php echo $extra->nom.' (' .$extra->cout.$order_data['currency'].')' ;?></li>
                      <?php }?>
                    </span>
                  </div> -->
                  <div class="mb-0 row">
                    <span class="ia_table_subtitle col-4"><?php _e('Reservé pour le ') ?></span>
                    <span class="ia_table_text  col-8"><?php echo $date.' à '.$time; ?></span>
                  </div>               
                  <div class="mb-0 row">
                    <span class="ia_table_subtitle col-4"><?php _e('Client') ?></span>
                    <span class="ia_table_text  col-8"><?php echo $customer_name.' - '.$customer_email ?></span>
                  </div>
                  <div class="mb-0 row">
                    <span class="ia_table_subtitle col-4"><?php _e('Reservé le') ?></span>
                    <span class="ia_table_text  col-8"><?php echo $order_data['date_created']->date('d-m-Y H:i:s'); ?></span>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <?php }}}?>
      
        

            <nav class="mt-5">
                <ul class="pagination mt-5 justify-content-center">

                  <?php if ($paged > 1) : ?>
                      <li class="page-item">
                          <a class="page-link" href="<?php echo esc_attr(get_pagenum_link($paged - 1)); ?>" aria-label="Précédent">
                              <span aria-hidden="true">&laquo;</span>
                          </a>
                      </li>
                  <?php endif; ?>

                  <?php
                  $links_around_current = 5;
                  // Afficher les liens numériques avec points de pagination
                  for ($i = 1; $i <= $total_pages; $i++) {
                      if ($i === 1 || $i === $total_pages || abs($i - $paged) <= $links_around_current || $total_pages <= 5) {
                          // Afficher le premier, le dernier et les liens autour de la page actuelle, ou
                          // afficher tous les liens si le nombre total de pages est inférieur ou égal à 5.
                          if ($paged === $i) {
                              echo '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
                          } else {
                              echo '<li class="page-item"><a class="page-link" href="' . esc_attr(get_pagenum_link($i)) . '">' . $i . '</a></li>';
                          }
                      } elseif (abs($i - $paged) === $links_around_current + 1) {
                          // Ajouter des points de pagination s'il y a un écart de 2 pages
                          echo '<li class="page-item disabled"><span class="page-link">&hellip;</span></li>';
                      }
                  }
                  ?>

                    <?php if ($paged < $total_pages) : ?>
                      <li class="page-item">
                          <a class="page-link" href="<?php echo esc_attr(get_pagenum_link($paged + 1)); ?>" aria-label="Suivant">
                              <span aria-hidden="true">&raquo;</span>
                          </a>
                      </li>
                  <?php endif; ?>
                </ul>
            </nav>
      
      <?php }else{?>

          <div class="">
            <div class="row insapp_listing">
                <p class="text-muted fw-semibold fs-2"><?php _e("Vous n'avez aucune reservation pour l'instant")?></p>
            </div>  
          </div>
          <?php }?>
      <?php
  $ajax_out = ob_get_clean();
  wp_send_json( $ajax_out);
}
 



function booking_get_agenda_slot_callback(){

    if (isset($_POST['author_id'])) {
        
        $author_id = sanitize_text_field( $_POST['author_id'] );
        $date = json_decode(json_encode($_POST['date'])) ;
       
        $agenda = insapp_select_agenda_by_date( $author_id ,$date) ;
           $response = array(
            'success' => 'true',
            'message' => $agenda
          );
   
        wp_send_json_success($response);
  
      } else {
        $response = array(
          'success' => false,
          'message' => 'Une erreur est survenu veuillez contacter l\'adminstrateur'
        );
        wp_send_json_error($response);
  
      }
}  
add_action( 'wp_ajax_booking_get_agenda_slot','booking_get_agenda_slot_callback');
add_action( 'wp_ajax_nopriv_booking_get_agenda_slot','booking_get_agenda_slot_callback');


add_action( 'wp_ajax_booking_services_slot', 'booking_services_slot_fn');
add_action( 'wp_ajax_nopriv_booking_services_slot', 'booking_services_slot_fn');
function booking_services_slot_fn(){
  $slots =  $_POST['slots'];
  $tampon =  $_POST['tampon'];
  $author_id = sanitize_text_field( $_POST['author_id'] );
  $date = json_decode(json_encode($_POST['date'])) ;
  $args = array(
    'post_type' => 'product',
    'posts_per_page' => -1,
    'author' => $author_id,
  );$products_query = new WP_Query($args); 
    
  if ($products_query->have_posts()) {
    $product_ids = array();
    while ($products_query->have_posts()) {
        $products_query->the_post();
        $product_ids[] = get_the_ID();
    }
    $args = array(
      'limit' => -1,  
    );
    $orders = wc_get_orders($args); 
    
    if(isset($orders)){
      $p_ids = array(); 
      foreach($orders as $order){
        $order_id = $order->id;
        $item = wc_get_order($order_id ); 
        $order_date = get_post_meta( $order_id, '_booking_date', true );
        $order_time = get_post_meta( $order_id, '_booking_time', true );
    
        foreach ($item->get_items() as $item_id => $item_order ) {
          $product = $item_order->get_product();
          $product_id = $product->id;
          $meta = get_post_meta($product_id);
                
          $dure = isset($meta['_duration'][0]) ? $meta['_duration'][0] : 'undefine';
          if( $dure != 'undefine'){
            
            if(in_array($product_id, $product_ids)){
              
              if($order_date == $date){
                  $book_slot[] = $order_time;
              }
                
            }
          }                                                       
            
        }
      }

      // Vérification et suppression des créneaux
      foreach ($book_slot as $creneau1) {
        foreach ($slots as $key => $creneau2) {
          if (insapp_creneaux_final($creneau1, $creneau2)) {
            unset($slots[$key]);
          }
        }
      }
      $slots = array_values($slots);

    }  
  }
  ob_start();
  
  if( $slots == null){
  ?>
  <span class="insapp_date_slot_vide"><?php _e('Nous n\'avons plus de crénaux disponible dans cette journée')  ?></span> 
          
  <?php }else{
    foreach ($slots as $slot){
  ?>
  <div class="insapp_date_slot " value="<?php _e($slot) ?>" ><?php _e($slot)  ?></div> 
  <?php }} 
    $ajax_out = ob_get_clean();
    wp_send_json( $ajax_out);
}


function insapp_creneaux_final($creneau1, $creneau2) {
  return ($creneau1 === $creneau2  || insapp_verification_tampon_intervalle($creneau1, $creneau2) || insapp_creneaux_chevauchant($creneau1, $creneau2));
}

// Fonction pour vérifier si deux créneaux sont dans l'intervalle de +/- 1 heure
function insapp_verification_tampon_intervalle($creneau1, $creneau2) {
  list($debut1, $fin1) = explode(' - ', $creneau1);
  list($debut2, $fin2) = explode(' - ', $creneau2);
  // Ajouter 1 heure aux dates de début et de fin du créneau 1
  $debut1_plus_1h = date('H:i', strtotime($debut1 . '+1 hour'));
  $fin1_plus_1h = date('H:i', strtotime($fin1 . '+1 hour'));
  return ($debut1_plus_1h <= $fin2 && $fin1_plus_1h >= $debut2);
}

// Fonction pour vérifier si deux créneaux se chevauchent
function insapp_creneaux_chevauchant($creneau1, $creneau2) {
  list($debut1, $fin1) = explode(' - ', $creneau1);
  list($debut2, $fin2) = explode(' - ', $creneau2);
  return ($debut1 < $fin2 && $fin1 > $debut2);
}

add_action('wp_ajax_orders_payement_bill', 'get_orders_payement_bill_callback');
add_action('wp_ajax_nopriv_orders_payement_bill', 'get_orders_payement_bill_callback');

function get_orders_payement_bill_callback() {
  

  if (isset($_POST['order_id'])) {
      $order_id = $_POST['order_id'];
      $order = wc_get_order($order_id ); 
      $output = insapp_facturepdf($order_id);

      header('Content-Type: application/json');

      // Retourner les données du PDF généré sous forme de JSON
      wp_send_json(array('pdf_data' => base64_encode($output)));
     

}else{
  wp_send_json('echec');
}
}

// function insapp_facturepdf($order_id){ 
  
//   $order = wc_get_order($order_id );
//   $order_data = $order->data;
//   $customer_id = $order->get_user_id(); 
//   $customer = get_user_by('id', $customer_id);
//   $customer_name = $customer->display_name;
//   $customer_email = $customer->user_email;
//   $date = get_post_meta( $order_id, '_booking_date', true );
//   $time = get_post_meta( $order_id, '_booking_time', true );
//   $bd_extras = get_post_meta( $order_id, '_booking_extra', true ); 
//   $selected_extras = (isset($bd_extras) && $bd_extras != null) ? json_decode($bd_extras) : [];
//   $items = $order->items;
  
//   ob_start();
  
//   require TLPLUGIN_DIR. 'templates/invoice.php';
//   $html = ob_get_contents();
//   ob_end_clean(); 

//   $options = new Options();
//   $options->set('defaultFont', 'Courier');

//   $dompdf = new Dompdf($options);
//   $dompdf->loadHtml($html );
//   $dompdf->setPaper('A4', 'portrait');
//   $dompdf->render();
//   $output = $dompdf->output();
//   $pdfOutput = 'facture'.uniqid(rand(), true).'.pdf';
//   file_put_contents( $pdfOutput, $output);

//   return $pdfOutput;
// }


?>