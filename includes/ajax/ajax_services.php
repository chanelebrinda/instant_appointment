<?php
/* Create product*/
add_action( 'wp_ajax_add_service_front', 'add_service_front_fn');
add_action( 'wp_ajax_nopriv_add_service_front', 'add_service_front_fn');
function add_service_front_fn(){

  $title = sanitize_text_field( $_POST['service_name']);
  $date_start = sanitize_text_field($_POST['service_date_start']);
  $date_end = sanitize_text_field($_POST['service_date_end']);
  $price_reg = sanitize_text_field($_POST['service_price_reg']);
  $price_sale = sanitize_text_field($_POST['service_price_sale']);
  $service_category= sanitize_text_field($_POST['service_category']);
  $service_duration = sanitize_text_field($_POST['service_duration']);
  $service_content= sanitize_textarea_field($_POST['service_content']);
  $user_id= sanitize_text_field($_POST['service_author']); 
  // $crenaux = sanitize_text_field($_POST['crenaux']);
  $filename = $_POST['image_name'];
  $image_size = $_POST['image_size'];
  $image_type = $_POST['image_type'];
  $image_url = $_POST['image_url'];
  $extras =  sanitize_text_field($_POST['extras']);
  // $extras =  json_encode($extras);

  if(isset($title) || isset($price_sale )|| isset($service_category )|| isset($service_duration )|| isset($image_url )){

    $product = array(
      'post_author' => $user_id,
      'post_content' => $service_content,
      'post_status' => "publish",
      'post_title' => $title,
      'post_parent' => '',
      'post_type' => "product"
    );
    $product_id = wp_insert_post( $product );
    wp_set_object_terms( $product_id, 'simple', 'product_type' ); 
    update_post_meta( $product_id, '_visibility', 'visible' );
    update_post_meta( $product_id, '_stock_status', 'instock'); 
    if(!empty($price_sale) && $price_sale != 0){
      update_post_meta($product_id, '_price', $price_sale );
    }else{
      update_post_meta($product_id, '_price', $price_reg );
    }
    update_post_meta($product_id, '_regular_price', $price_reg);
    update_post_meta($product_id, '_sale_price', $price_sale);
    update_post_meta($product_id, '_extras', $extras,'json');
    update_post_meta($product_id, '_duration', $service_duration);
    // update_post_meta($product_id, '_crenaux', $crenaux);

    wp_set_object_terms($product_id, $service_category, 'product_cat' );
    wp_set_object_terms($product_id, 'Air libre', 'product_tag' );

    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents( $image_url );

    if ( wp_mkdir_p( $upload_dir['path'] ) ) {
      $file = $upload_dir['path'] . '/' . $filename;
    }
    else {
      $file = $upload_dir['basedir'] . '/' . $filename;
    }

    file_put_contents( $file, $image_data );
    $wp_filetype = wp_check_filetype( $filename, null );
    $attachment = array(
      'guid' => $upload_dir['url'] . '/' . $file_name,
      'post_mime_type' => $wp_filetype['type'],
      'post_title' => sanitize_file_name( $filename ),
      'post_content' => '',
      'post_status' => 'inherit'
    );
      

    $attach_id = wp_insert_attachment( $attachment, $file, $product_id);

    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
    wp_update_attachment_metadata( $attach_id, $attach_data );
    set_post_thumbnail( $product_id, $attach_id );

    wp_publish_post( $product_id);
 
    if ( ! is_wp_error( $product_id ) ) {
            $resp = array(
                'code' => 200,
                'message' => "Annonce créé avec succès!"
            );
        }else{
            $resp = array(
            'code' => 400,
	        'message' => $user_id->get_error_messages(),
            );
        }
       
  }else{
        $resp = array(
            'code' => 404,
	        'message' => "Une erreur est survenue veuillez contactez l'administrateur",
        );
    }
    wp_send_json($resp);
 
}

/*Delete product*/
add_action( 'wp_ajax_delete_product','delete_product_callback');
add_action( 'wp_ajax_nopriv_delete_product','delete_product_callback');
function delete_product_callback(){
  $product_id = sanitize_text_field( $_POST['product_id'] );
  $resp = array();
  $orders = wc_get_orders(array(
    'limit' => -1,
));

    // wp_send_json($orders);
// Supprimer les commandes du produit spécifique
foreach ($orders as $order) {
    $order_items = $order->get_items();
    $item = wc_get_order($order_items );
    $status = $order_items[ 'status' ] ;

    wp_send_json($item);
    foreach ($order_items as $item) {
        $product = $item->get_product();
        if ($product && $product->get_id() == $product_id) {
            $order->delete(true);
            echo 'Commande supprimée : ' . $order->get_id() . '<br>';
            break;
        }
    }
  }
  // array_push($resp,wp_delete_post($product_id));
    wp_send_json($resp);
}

/* Update product*/
add_action( 'wp_ajax_update_product','update_product_callback');
add_action( 'wp_ajax_nopriv_update_product','update_product_callback');
function update_product_callback(){
  
    $product_id = sanitize_text_field($_POST['product_id']);
    $product = get_post($product_id);
    $category = wp_get_post_terms($product_id, 'product_cat')[0]->slug;
    $_regular_price = wp_get_post_terms($product_id, '_regular_price');
    $meta_product = get_post_meta($product_id);
    $image = get_the_post_thumbnail($product_id);
    // $image_url = get_the_post_thumbnail_url($product_id);
    
    
    $array_result = array(
      'id' => $product_id,
      'nom' => $product->post_title,
      'description' => $product->post_content,
      'categorie' => $category,
      'reg_price' => $meta_product['_regular_price'][0],
      'sale_price' => $meta_product['_sale_price'][0],
      'duree' => $meta_product['_duration'][0],
      'extras' => json_decode($meta_product['_extras'][0]),
      'image' => $image,
      // 'image_url' => $image_url,
    );
// var_dump($product->get_description());
    wp_send_json($array_result);
}


add_action( 'wp_ajax_update_service_front','update_service_front_callback');
add_action( 'wp_ajax_nopriv_update_service_front','update_service_front_callback');
function update_service_front_callback(){
  
  $title = sanitize_text_field( $_POST['service_name']);
  // $date_start = sanitize_text_field($_POST['service_date_start']);
  // $date_end = sanitize_text_field($_POST['service_date_end']);
  $price_reg = sanitize_text_field($_POST['service_price_reg']);
  $price_sale = sanitize_text_field($_POST['service_price_sale']);
  $service_category= sanitize_text_field($_POST['service_category']);
  $service_duration = sanitize_text_field($_POST['service_duration']);
  $service_content= sanitize_textarea_field($_POST['service_content']);
  $product_id= sanitize_text_field($_POST['post_id']); 
  // $crenaux = sanitize_text_field($_POST['crenaux']);
  $filename = $_POST['image_name'];
  $image_size = $_POST['image_size'];
  $image_type = $_POST['image_type'];
  $image_url = $_POST['image_url'];
  $extras =  sanitize_text_field($_POST['extras']);
  // $extras =  json_encode($extras);

  if(isset($title) || isset($service_category )|| isset($service_duration )|| isset($image_url )){
    
    $product = array(
      'ID' => $product_id,
      'post_content' => $service_content,
      'post_title' => $title,
    );
    $product_id = wp_update_post( $product ); 
    update_post_meta( $product_id, '_visibility', 'visible' );
    update_post_meta( $product_id, '_stock_status', 'instock');
    if(!empty($price_sale) && $price_sale != 0){
      update_post_meta($product_id, '_price', $price_sale );
    }else{
      update_post_meta($product_id, '_price', $price_reg );
    }
    update_post_meta($product_id, '_regular_price', $price_reg);
    update_post_meta($product_id, '_sale_price', $price_sale);
    update_post_meta($product_id, '_extras', $extras,'json');
    update_post_meta($product_id, '_duration', $service_duration);
    // update_post_meta($product_id, '_crenaux', $crenaux);

    wp_set_object_terms($product_id, $service_category, 'product_cat' );

    $upload_dir = wp_upload_dir();
    // wp_send_json($image_url);
    $image_data = file_get_contents( $image_url );

    if ( wp_mkdir_p( $upload_dir['path'] ) ) {
      $file = $upload_dir['path'] . '/' . $filename;
    }
    else {
      $file = $upload_dir['basedir'] . '/' . $filename;
    }

    file_put_contents( $file, $image_data );
    $wp_filetype = wp_check_filetype( $filename, null );
    $attachment = array(
      'guid' => $upload_dir['url'] . '/' . $file_name,
      'post_mime_type' => $wp_filetype['type'],
      'post_title' => sanitize_file_name( $filename ),
      'post_content' => '',
      'post_status' => 'inherit'
    );
      

    $attach_id = wp_insert_attachment( $attachment, $file, $product_id);

    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
    wp_update_attachment_metadata( $attach_id, $attach_data );
    set_post_thumbnail( $product_id, $attach_id );

    // wp_publish_post( $product_id);
 
    if ( ! is_wp_error( $product_id ) ) {
            $resp = array(
                'code' => 200,
                'message' => "Service modifié avec succès!"
            );
        }else{
            $resp = array(
            'code' => 400,
	        'message' => $user_id->get_error_messages(),
            );
        }
       
  }else{
        $resp = array(
            'code' => 404,
	        'message' => "Une erreur est survenue veuillez contactez l'administrateur",
        );
    }
    wp_send_json($resp);
}


add_action( 'wp_ajax_add_subcrition_back','add_subcrition_back_callback');
add_action( 'wp_ajax_nopriv_add_subcrition_back','add_subcrition_back_callback');
function add_subcrition_back_callback(){

  $name = sanitize_text_field($_POST['sub_name']);
  $description= sanitize_text_field($_POST['sub_content']); 
  $price= sanitize_textarea_field($_POST['sub_price_mensuel']); 
  $price_pro= sanitize_textarea_field($_POST['sub_price_mensuel_pro']);
  $duree = sanitize_textarea_field($_POST['sub_duration']); 
  $element = sanitize_textarea_field($_POST['sub_element']); 

  $product_data = array(
    'post_title'    => $name, 
    'post_content'  =>  $description, 
    'post_status'   => 'publish',
    'post_type'     => 'product', 
 );
  $product_id = wp_insert_post($product_data);

    if ($product_id) {

        wp_set_object_terms($product_id, 'subscription', 'product_type', false);

        update_post_meta($product_id, '_subscription_period_interval', $duree); // Durée de l'abonnement (1 mois)
        update_post_meta($product_id, '_subscription_period', 'month'); // Période de facturation (mois)
        update_post_meta($product_id, '_regular_price', $price);
        update_post_meta($product_id, '_sale_price', $price_pro);
        update_post_meta($product_id, '_list_element', $element);
        if(!empty($price_pro) && $price_pro != 0){
          update_post_meta($product_id, '_price', $price_pro );
        }else{
          update_post_meta($product_id, '_price', $price );
        }
          

        if ( ! is_wp_error( $product_id ) ) {
        $resp = array(
            'code' => 200,
            'message' => "Annonce créé avec succès!"
        );
      }else{
          $resp = array(
          'code' => 400,
        'message' => $user_id->get_error_messages(),
          );
      }

   }else{
      $resp = array(
        'code' => 404,
        'message' => "Une erreur est survenue veuillez contactez l'administrateur",
      );
    }

    wp_send_json($resp);
}

/*Delete subscription*/
add_action( 'wp_ajax_delete_subscription','delete_subscription_callback');
add_action( 'wp_ajax_nopriv_delete_subscription','delete_subscription_callback');
function delete_subscription_callback(){
  $subscription_id = sanitize_text_field( $_POST['subscription_id'] );
    $resp = array();
    array_push($resp,wp_delete_post($subscription_id));
  wp_send_json($resp);
}

/* Update product*/
add_action( 'wp_ajax_update_subscription','update_subscription_callback');
add_action( 'wp_ajax_nopriv_update_subscription','update_subscription_callback');
function update_subscription_callback(){
  
    $subscription_id = sanitize_text_field($_POST['subscription_id']);
    $subscription = get_post($subscription_id);
    $meta_subscription = get_post_meta($subscription_id);
    $name = $subscription->post_title ;
    $description=  $subscription->post_content; 
    $price= $meta_subscription['_regular_price'][0] ; 
    $price_pro= $meta_subscription['_sale_price'][0] ;
    $duree = $meta_subscription['_subscription_period_interval'][0] ; 
    $list = $meta_subscription['_list_element'][0] ;
    
    
    $array_result = array(
      'id' => $subscription_id,
      'nom' => $name,
      'description' => $description,
      'reg_price' => $price,
      'sale_price' => $price_pro,
      'duree' => $duree,
      'list' => $list
    );
    wp_send_json($array_result);
}


add_action( 'wp_ajax_save_subscription_update','save_subscription_update_callback');
add_action( 'wp_ajax_nopriv_save_subscription_update','save_subscription_update_callback');
function save_subscription_update_callback(){
  $subscription_id = sanitize_text_field($_POST['subscription_id']);
  $name = sanitize_text_field($_POST['name']);
  $description= sanitize_text_field($_POST['description']); 
  $price= sanitize_textarea_field($_POST['price_reg']); 
  $price_pro= sanitize_textarea_field($_POST['price_sale']);
  $duree = sanitize_textarea_field($_POST['duration']); 
  $element = sanitize_textarea_field($_POST['sub_element']); 
 
    $subscription = array(
      'ID' => $subscription_id,
      'post_content' => $description,
      'post_title' => $name,
    );
    $response = wp_update_post( $subscription ); 
    update_post_meta( $subscription_id, '_visibility', 'visible' );
    update_post_meta( $subscription_id, '_stock_status', 'instock'); 
    update_post_meta($subscription_id, '_list_element', $element);
    if(!empty($price_pro) && $price_pro != 0){
      update_post_meta($product_id, '_price', $price_pro );
    }else{
      update_post_meta($product_id, '_price', $price );
    }
    update_post_meta($subscription_id, '_regular_price', $price);
    update_post_meta($subscription_id, '_sale_price', $price_pro);
    update_post_meta($subscription_id, '_subscription_period_interval', $duree);
 
    if ( ! is_wp_error( $response ) ) {
            $resp = array(
                'code' => 200,
                'message' => "Abonnement modifié avec succès!"
            );
        }else{
            $resp = array(
            'code' => 400,
	        'message' => $user_id->get_error_messages(),
            );
        }
  wp_send_json($resp);
}




add_action( 'wp_ajax_payement_abonnement','payement_abonnement_callback');
add_action( 'wp_ajax_nopriv_payement_abonnement','payement_abonnement_callback');
function payement_abonnement_callback(){
  $customer = wp_get_current_user();
  $abonnement_id = sanitize_text_field($_POST['abonnement_id']);
  $duree = get_post_meta($abonnement_id)['_subscription_period_interval'][0];
  // wp_send_json($abonnement);
  

  if ( ! empty( WC()->cart->get_cart() ) ) {
      WC()->cart->empty_cart();
  }
  if ( wc_get_product( $abonnement_id ) ) {
    // Ajouter le produit au panier
    WC()->cart->add_to_cart( $abonnement_id , $duree);

    // Rediriger vers la page checkout
    $response =  wc_get_checkout_url() ;
    
  }else{
    $response = false;
  };
  
  $resp['payment_code'] = $response;
  

    wp_send_json($resp);
}
