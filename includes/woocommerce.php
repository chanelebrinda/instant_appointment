<?php

 
define( 'INSAPP_SCSP_TEST_CONNECT_ID', "ca_OO7AVmdALszYSzCU6g7oLkTCKLvjUt4p" );
define( 'INSAPP_SCSP_LIVE_CONNECT_ID', "ca_OO7AVmdALszYSzCU6g7oLkTCKLvjUt4p" );

function insapp_create_account_stripe(){

    $insapp_woocommerce_stripe_settings = get_option( 'woocommerce_stripe_settings' );
    if ( !$insapp_woocommerce_stripe_settings ) {
        return false;
    }

    $insapp_stripe_live_secret_key = ( isset( $insapp_woocommerce_stripe_settings['secret_key'] ) ? $insapp_woocommerce_stripe_settings['secret_key'] : null );
    $insapp_stripe_test_mode = ( isset( $insapp_woocommerce_stripe_settings['testmode'] ) ? $insapp_woocommerce_stripe_settings['testmode'] : null );
    $insapp_stripe_test_secret_key = ( isset( $insapp_woocommerce_stripe_settings['test_secret_key'] ) ? $insapp_woocommerce_stripe_settings['test_secret_key'] : null );
    $insapp_per_cent = 20;
    $amount = 400;
    // $woo_currency = get_woocommerce_currency();
    $currency = ( $woo_currency ? $woo_currency : 'usd' );

    $client_id = INSAPP_SCSP_TEST_CONNECT_ID;

    if (isset($insapp_stripe_test_mode) && $insapp_stripe_test_mode == "yes") {
      $secret_key = $insapp_stripe_test_secret_key;
    } else {
      $secret_key = $insapp_stripe_live_secret_key;
      $client_id = INSAPP_SCSP_LIVE_CONNECT_ID;
    }

    if (!empty($insapp_woocommerce_stripe_settings) && !empty($secret_key)) {
      $stripe = new \Stripe\StripeClient(
          $secret_key
      );

    }
     $account_id = $stripe->accounts->create(['type' => 'standard']);
     return  $account_id;
  }

  
  function insapp_get_link_account_stripe( $account_id){
    $insapp_woocommerce_stripe_settings = get_option( 'woocommerce_stripe_settings' );
    if ( !$insapp_woocommerce_stripe_settings ) {
        return false;
    }

    $insapp_stripe_live_secret_key = ( isset( $insapp_woocommerce_stripe_settings['secret_key'] ) ? $insapp_woocommerce_stripe_settings['secret_key'] : null );
    $insapp_stripe_test_mode = ( isset( $insapp_woocommerce_stripe_settings['testmode'] ) ? $insapp_woocommerce_stripe_settings['testmode'] : null );
    $insapp_stripe_test_secret_key = ( isset( $insapp_woocommerce_stripe_settings['test_secret_key'] ) ? $insapp_woocommerce_stripe_settings['test_secret_key'] : null );
    $insapp_per_cent = 20;
    $amount = 400;
    // $woo_currency = get_woocommerce_currency();
    $currency = ( $woo_currency ? $woo_currency : 'usd' );

    $client_id = INSAPP_SCSP_TEST_CONNECT_ID;

    if (isset($insapp_stripe_test_mode) && $insapp_stripe_test_mode == "yes") {
      $secret_key = $insapp_stripe_test_secret_key;
    } else {
      $secret_key = $insapp_stripe_live_secret_key;
      $client_id = INSAPP_SCSP_LIVE_CONNECT_ID;
    }

    if (!empty($insapp_woocommerce_stripe_settings) && !empty($secret_key)) {
      $stripe = new \Stripe\StripeClient(
          $secret_key
      );
    }

    $link = $stripe->accountLinks->create([
      'account' =>   $account_id, 
      'refresh_url' => 'https://localhost/wordpress',
      'return_url' => 'https://localhost/wordpress/dashboard-5/',
      'type' => 'account_onboarding',
    ]);

    return $link->url;
  }
 
  function insapp_get_status_account_stripe( $account_id){
      $insapp_woocommerce_stripe_settings = get_option( 'woocommerce_stripe_settings' );
      if ( !$insapp_woocommerce_stripe_settings ) {
          return false;
      }

      $insapp_stripe_live_secret_key = ( isset( $insapp_woocommerce_stripe_settings['secret_key'] ) ? $insapp_woocommerce_stripe_settings['secret_key'] : null );
      $insapp_stripe_test_mode = ( isset( $insapp_woocommerce_stripe_settings['testmode'] ) ? $insapp_woocommerce_stripe_settings['testmode'] : null );
      $insapp_stripe_test_secret_key = ( isset( $insapp_woocommerce_stripe_settings['test_secret_key'] ) ? $insapp_woocommerce_stripe_settings['test_secret_key'] : null );
      $insapp_per_cent = 20;
      $amount = 400;
      // $woo_currency = get_woocommerce_currency();
      $currency = ( $woo_currency ? $woo_currency : 'usd' );

      $client_id = INSAPP_SCSP_TEST_CONNECT_ID;

      if (isset($insapp_stripe_test_mode) && $insapp_stripe_test_mode == "yes") {
        $secret_key = $insapp_stripe_test_secret_key;
      } else {
        $secret_key = $insapp_stripe_live_secret_key;
        $client_id = INSAPP_SCSP_LIVE_CONNECT_ID;
      }

      if (!empty($insapp_woocommerce_stripe_settings) && !empty($secret_key)) {
        $stripe = new \Stripe\StripeClient(
            $secret_key
        );
      }

        $statut = $stripe->accounts->retrieve($account_id);

        return $statut->details_submitted;
    }
// $stripe->paymentIntents->create([
//   'amount' => 1099,
//   'currency' => 'eur',
//   'automatic_payment_methods' => ['enabled' => true],
//   'application_fee_amount' => 123,
//   'transfer_data' => ['destination' => '{{CONNECTED_ACCOUNT_ID}}'],
// ]);
  // $rer = $stripe->accounts->retrieve('acct_1NbhB62abDj938RA');
  // var_dump($rer->details_submitted);

  // $link = $stripe->accountLinks->create([
  //   'account' =>   $account_id->id, 
  //   'refresh_url' => 'https://example.com/reauth',
  //   'return_url' => 'https://localhost/wordpress/dashboard-5/',
  //   'type' => 'account_onboarding',
  // ]);

  // var_dump($link->url);
 
  

  $insapp_woocommerce_stripe_settings = get_option( 'woocommerce_stripe_settings' );
      if ( !$insapp_woocommerce_stripe_settings ) {
          return false;
      }
   
      $insapp_stripe_live_secret_key = ( isset( $insapp_woocommerce_stripe_settings['secret_key'] ) ? $insapp_woocommerce_stripe_settings['secret_key'] : null );
      $insapp_stripe_test_mode = ( isset( $insapp_woocommerce_stripe_settings['testmode'] ) ? $insapp_woocommerce_stripe_settings['testmode'] : null );
      $insapp_stripe_test_secret_key = ( isset( $insapp_woocommerce_stripe_settings['test_secret_key'] ) ? $insapp_woocommerce_stripe_settings['test_secret_key'] : null );
      $insapp_per_cent = 20;
      $amount = 400;
      // $woo_currency = get_woocommerce_currency();
      $currency = ( $woo_currency ? $woo_currency : 'usd' );

      $client_id = INSAPP_SCSP_TEST_CONNECT_ID;

      if (isset($insapp_stripe_test_mode) && $insapp_stripe_test_mode == "yes") {
        $secret_key = $insapp_stripe_test_secret_key;
      } else {
        $secret_key = $insapp_stripe_live_secret_key;
        $client_id = INSAPP_SCSP_LIVE_CONNECT_ID;
      }
      // var_dump($secret_key);
      if (!empty($insapp_woocommerce_stripe_settings) && !empty($secret_key)) {
      //   $stripe = new \Stripe\StripeClient(
      //       $secret_key
      //   );
      //   $stripetransfert = new \Stripe\Transfer(
      //     $secret_key
      // );
      }
      // $stripe->topups->create([
      //   'amount' => 2000,
      //   'currency' => 'usd',
      //   'description' => 'Top-up for week of May 31',
      //   'statement_descriptor' => 'Weekly top-up',
      // ]);

    //   \Stripe\Stripe::setApiKey( $secret_key);

    //   $transfer = \Stripe\Transfer::create([
    //     "amount" => 1000,
    //     "currency" => "usd",
    //     "destination" => "acct_1NbhB62abDj938RA",
    //   ]);
    // var_dump($transfer);

















































 
  // $redirect_uri = site_url("/") . "?bsd_action=get_code";
  // echo $redirect_uri;
  // $url = 'https://connect.stripe.com/oauth/authorize?response_type=code';
  // $url = add_query_arg(
  //     'client_id',
  //     $client_id,
  //     $url
  // );
  // $url = add_query_arg('scope', 'read_write', $url);
  // $url = add_query_arg('redirect_uri', urlencode($redirect_uri), $url);
  // echo $url;
  // wp_redirect($url);
//   exit;
// }


// add_action("wp_ajax_add_custom_account", array($this, "add_custom_account"));


//  function get_event_type( $request_body )
// {
//     $request_body = json_decode( $request_body );
//     $event_type = ( $request_body->type ? strtolower( $request_body->type ) : NULL );
//     return $event_type;
// }
//  function transfer_controller( $request_body )
// {
//     require_once dirname( __FILE__ ) . '/vendor/autoload.php';
//     $event_type = get_event_type( $request_body );
    
//     if ( $event_type == 'payment_intent.succeeded' ) {
//         list( $success, $result_message, $transfer ) = $this->transfer_to_account( $request_body );
        
//         if ( $success ) {
//             $this->log_transfer_request( $request_body, $transfer );
//         } else {
//             // TODO: Notify administrator. For now, error_log it
//             \WC_Stripe_Logger::log( $this->log_prefix . ': ' . print_r( $result_message, true ) );
//         }
    
//     }

// }
// \Stripe\PaymentIntent::create([
//       'amount' => $montant_photographe * 100, // Le montant doit être en cents
//       'currency' => 'USD', // Changez selon votre devise
//       'payment_method_types' => ['card'],
//       'transfer_data' => [
//           'destination' => 'acct_1NXKAkKaTsFSFSsQ', // Remplacez par l'identifiant du compte Stripe du photographe
//       ],
//   ]);
// $stripe->accountLinks->create([
//   'account' => '{{acct_1NXKAkKaTsFSFSsQ}}',
//   'refresh_url' => 'https://example.com/reauth',
//   'return_url' => 'https://example.com/return',
//   'type' => 'account_onboarding',
// ]);

  // $stripe->paymentIntents->create([
  //   'amount' => $montant_photographe * 100,
  //   'currency' => 'usd',
  //   'automatic_payment_methods' => ['enabled' => true],
  //   // 'on_behalf_of' => 'acct_1NXKAkKaTsFSFSsQ',
  //   'transfer_data' => ['destination' => 'acct_1NXKAkKaTsFSFSsQ'],
  // ]);

// Effectuer les paiements fractionnés via Stripe Connect
// $transfer_photographe = \Stripe\Transfer::create([
//     'amount' => $montant_photographe * 100, 
//     'currency' => 'usd', 
//     'destination' => 'acct_1NXKAkKaTsFSFSsQ', 
// ]);

// function process_split_payments($order_id) {
//   // Récupérer les montants à payer au photographe et au client
//   $photographer_amount = get_post_meta($order_id, 'photographer_amount', true);
//   $client_amount = get_post_meta($order_id, 'client_amount', true);

//   \Stripe\Stripe::setApiKey('sk_test_XXXXXX');
//   \Stripe\PaymentIntent::create([
//       'amount' => $photographer_amount * 100,
//       'currency' => 'USD', 
//       'payment_method_types' => ['card'],
//       'transfer_data' => [
//           'destination' => 'acct_XXXXX',
//       ],
//   ]);

//   \Stripe\PaymentIntent::create([
//       'amount' => $client_amount * 100, // Le montant doit être en cents
//       'currency' => 'USD', // Changez selon votre devise
//       'payment_method_types' => ['card'],
//       'transfer_data' => [
//           'destination' => 'acct_XXXXX', // Remplacez par l'identifiant du compte Stripe du client
//       ],
//   ]);
  
//   update_post_meta($order_id, 'payment_processed', 'yes');
// }
// add_action('woocommerce_payment_complete', 'process_split_payments');



?>
