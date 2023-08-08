<?php 
if(isset( get_option('insapp_settings_name')['Parametre_adress'] ) || isset( get_option('insapp_settings_name')['Parametre_numero'] ) || isset( get_option('insapp_settings_name')['Parametre_title'] ) || isset(get_option('insapp_settings_name')['Parametre_mail'] ) ) {
  $insapp_siteMail = esc_html( get_option('insapp_settings_name')['Parametre_mail']  );
  $insapp_sitename = esc_html( get_option('insapp_settings_name')['Parametre_title']  ); 
  $insapp_phone = esc_html( get_option('insapp_settings_name')['Parametre_numero']  ); 
  $Parametre_adress = esc_html( get_option('insapp_settings_name')['Parametre_adress']  ); 
  
} 
global $insapp_siteMail;
global $insapp_sitename; 
global $insapp_phone;
global $Parametre_adress; 


function insapp_mail_template_book($book_id){

  $order = new WC_Order($book_id);
  
  $customer_id = $order -> get_user_id (); 
  $customer = get_user_by('id', $customer_id);  
  $customer_name = $customer->user_email;

  ob_start();?>
      <html>
        <head>
          <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
          <style>
            /* Add custom classes and styles that you want inlined here */
          </style>
        </head>
        <body class="bg-light">
          <div class="container">
             <div class="card my-10">
              <div class="card-body">
                <h1 class="h3 mb-2">Confirmation de réception de votre réservation</h1> 
                <hr>
                <div class="space-y-3">
                  <p class="text-gray-700">
                     Nous sommes heureux de vous informer que votre réservation pour une séance photo avec <?php _e($author_name) ?> a bien été reçue !
                  </p>
                  <p class="text-gray-700">
                    Nous avons transmis votre demande de réservation à <?php _e($author_name) ?>, qui est en train d'examiner les détails de votre demande. Votre réservation est en attente d'approbation de la part du photographe.
                  </p>
                  <p class="text-gray-700">
                  Dès que <?php _e($author_name) ?> aura examiné votre demande, nous vous enverrons une confirmation définitive par e-mail. Cela devrait prendre généralement [indiquez le délai d'attente, par exemple 24 heures] pour recevoir une réponse.
                  </p>
                  <p class="text-gray-700">
                    Veuillez noter que votre réservation n'est pas encore confirmée définitivement, et nous vous recommandons de ne pas prendre d'autres engagements pour la date et l'heure de la séance jusqu'à ce que vous ayez reçu une confirmation finale
                  </p>
                </div>
                <hr>
                <a class="btn btn-dark text-center  px-3 py-1 fw-700" href="https://app.bootstrapemail.com/templates" target="_blank">Revenir sur le site</a>
              </div>
            </div>
          </div>
        </body>
      </html>

    <?php
    $body = ob_get_clean();
    return $body;
}

function insapp_mail_template_book_approve($book_id){

  $order = new WC_Order($book_id);
  $order_id = $order->id;
  $customer_id = $order -> get_user_id (); 
  $customer = get_user_by('id', $customer_id);  
  $customer_name = $customer->user_email;
  
  $date = get_post_meta( $order_id, '_booking_date', true );
  $time = get_post_meta( $order_id, '_booking_time', true );

  $items = $order->get_items();
  foreach ( $items as $item ) { 
  $product_id = $item['product_id']; 
  } 
      $product = get_post($product_id);  
      $author_name = get_user_by('ID', $product->post_author)->user_nicename; 
      
      $meta = get_post_meta($product_id);
      $durée = isset($meta['_duration'][0]) ? $meta['_duration'][0] : 'undefine';
      $extras =  json_decode($meta["_extras"][0]) == null ? [] : json_decode($meta["_extras"][0]);
  
      ob_start();?>
          <html>
          <head>
              <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
              <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
              <style>
              /* Add custom classes and styles that you want inlined here */
              </style>
          </head>
          <body class="bg-light">
              <div class="container">
                <div class="card my-10">
                  <div class="card-body">
                  <h1 class="h3 mb-2">Confirmation d'approbation de votre réservation</h1> 
                  <hr>
                  <div class="space-y-3"> 
                      <p class="text-gray-700">
                      Nous sommes ravis de vous informer que votre réservation pour une séance photo avec <?php _e( $author_name ) ?>a été approuvée avec succès !
                  </p>
                      <p class="text-gray-700">
                      <span class="text-gray-900"> Détails de la réservation<span>
                          Date de la séance : <?php _e( $date) ?> </br>
                          Crénaux horaire: <?php _e( $time) ?></br>
                          Durée de la séance : <?php _e( $durée) ?> </br>
                      </p>
                      <p class="text-gray-700">
                          Votre réservation a été confirmée et vous pouvez maintenant procéder au paiement pour confirmer définitivement votre séance. Veuillez cliquer sur le lien ci-dessous pour accéder à la page de paiement sécurisé :
                      </p>
                      <p class="text-gray-700">
                      Veuillez noter que le paiement doit être effectué avant la date de la séance pour garantir votre réservation. Si vous avez des questions ou des préoccupations concernant le paiement ou la séance en général, n'hésitez pas à nous contacter. Nous avons hâte de vous rencontrer lors de la séance photo et de créer des souvenirs précieux ensemble.
                      </p>
                  </div>
                  <hr>
                  <a class="btn btn-dark text-center  px-3 py-1 fw-700" href="https://app.bootstrapemail.com/templates" target="_blank">Payer maintenant</a>
                  </div>
              </div>
              </div>
          </body>
          </html>
  
      <?php
      $body = ob_get_clean();
                
    return $body;
}
  
function insapp_mail_template_book_cancel($book_id){

  $order = new WC_Order($book_id);
  $order_id = $order->id;
  $customer_id = $order -> get_user_id (); 
  $customer = get_user_by('id', $customer_id);  
  $customer_name = $customer->user_email;
  
  $date = get_post_meta( $order_id, '_booking_date', true );
  $time = get_post_meta( $order_id, '_booking_time', true );

  $items = $order->get_items();
  foreach ( $items as $item ) { 
  $product_id = $item['product_id']; 
  } 
  $product = get_post($product_id);  
  $author_name = get_user_by('ID', $product->post_author)->user_nicename; 
  
  $meta = get_post_meta($product_id);
  $durée = isset($meta['_duration'][0]) ? $meta['_duration'][0] : 'undefine';
  $extras =  json_decode($meta["_extras"][0]) == null ? [] : json_decode($meta["_extras"][0]);

  ob_start();?>
      <html>
      <head>
          <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
          <style>
          /* Add custom classes and styles that you want inlined here */
          </style>
      </head>
      <body class="bg-light">
          <div class="container">
          <div class="card my-10">
              <div class="card-body">
              <h1 class="h3 mb-2">Confirmation d'approbation de votre réservation</h1> 
              <hr>
              <div class="space-y-3"> 
                  <p class="text-gray-700">
                  Nous sommes désolés de vous informer que votre réservation pour une séance photo avec <?php _e( $author_name ) ?> a été annulée.
              </p> 
                  <p class="text-gray-700">
                  Nous comprenons que cela peut être décevant, et nous nous excusons pour tout inconvénient que cela peut causer. Votre satisfaction est importante pour nous, et nous sommes disponibles pour discuter de toute autre réservation future ou pour répondre à vos questions.
                  </p>
                  <p class="text-gray-700">
                  Nous vous remercions de votre intérêt pour nos services de photographie et nous espérons que vous trouverez bientôt une autre occasion pour une séance photo avec <?php _e( $author_name ) ?>.
                </p>
              </div>
              <hr> 
            </div>
          </div>
              
          </div>
      </body>
      </html>

  <?php
    $body = ob_get_clean();
             
  return $body;
}

 
function insapp_mail_template_client_cancel($book_id){

  $order = new WC_Order($book_id);
  $order_id = $order->id;
  $customer_id = $order -> get_user_id (); 
  $customer = get_user_by('id', $customer_id);  
  $customer_name = $customer->user_email;
  
  $date = get_post_meta( $order_id, '_booking_date', true );
  $time = get_post_meta( $order_id, '_booking_time', true );

  $items = $order->get_items();
  foreach ( $items as $item ) { 
  $product_id = $item['product_id']; 
} 
  $product = get_post($product_id);  
  $author_name = get_user_by('ID', $product->post_author)->user_nicename; 
  
  $meta = get_post_meta($product_id);
  $durée = isset($meta['_duration'][0]) ? $meta['_duration'][0] : 'undefine';
  $extras =  json_decode($meta["_extras"][0]) == null ? [] : json_decode($meta["_extras"][0]);

  ob_start();?>
      <html>
      <head>
          <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
          <style>
          /* Add custom classes and styles that you want inlined here */
          </style>
      </head>
      <body class="bg-light">
          <div class="container">
            <div class="card my-10">
              <div class="card-body">
              <h1 class="h3 mb-2">Annulation de réservation par le client</h1> 
              <hr>
              <div class="space-y-3"> 
                  <p class="text-gray-700">
                  Nous avons le regret de vous informer que le client a annulé sa réservation pour une séance photo avec vous.
                  </p>
                  <p class="text-gray-700">
                  <span class="text-gray-900">Détails de la réservation annulée<span>
                      Date de la séance : <?php _e( $date) ?> </br>
                      Crénaux horaire: <?php _e( $time) ?></br>
                      Durée de la séance : <?php _e( $durée) ?> </br>
                  </p>
                  <p class="text-gray-700">
                  Nous comprenons que cela peut être décevant, et nous tenions à vous informer dès que possible afin que vous puissiez ajuster votre emploi du temps en conséquence.
                </p>
                  <p class="text-gray-700">
                  Nous vous remercions de votre compréhension et espérons que vous trouverez bientôt une autre occasion pour une séance photo avec le même client ou avec de nouveaux clients.
                  </p>
              </div>
              <hr>
              <a class="btn btn-dark text-center  px-3 py-1 fw-700" href="https://app.bootstrapemail.com/templates" target="_blank">Payer maintenant</a>
              </div>
          </div>
          </div>
      </body>
      </html>

  <?php
  $body = ob_get_clean();
             
  return $body;
}


?>