<?php
            
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
        'limit' => -1, 
        'status' => array('cancelled', 'completed', 'pending', 'processing'),
    );
    $orders = wc_get_orders($args); 

    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $orders_per_page = 3;
    $total_pages = ceil(count($orders) / $orders_per_page);
    $orders_chunked = array_chunk($orders, $orders_per_page);
    $current_orders = isset($orders_chunked[$paged - 1]) ? $orders_chunked[$paged - 1] : array();

    $nbr_orders = 0;
    
    if(isset($current_orders)){

        foreach($current_orders as $order){
          $order_id = $order->id;
          $item = wc_get_order($order_id );
          $order_data = $order->data;
          $status = $order_data[ 'status' ] ;
          $customer_id = $order -> get_user_id (); 
          $customer = get_user_by('id', $customer_id);
          $customer_name = $customer->display_name;
          $customer_email = $customer->user_email;
          $date = get_post_meta( $order_id, '_booking_date', true );
          $time = get_post_meta( $order_id, '_booking_time', true );


          foreach ($item->get_items() as $item_id => $item_order ) {

              $product = $item_order->get_product();
              $product_id = $product->id;
            var_dump($product_id);
              $categories = wp_get_post_terms($product_id, 'product_cat');
              $meta = get_post_meta($product_id);
              $dure = isset($meta['_duration'][0]) ? $meta['_duration'][0] : 'undefine';
              $extras = isset($meta["_extras"]) ? json_decode($meta["_extras"][0]) : [];
              $title = $product->name;

              // var_dump($product->name);
              switch ($status) {
                  case 'cancelled':{
                  $btn = '<button class="dropdown-item d-flex align-items-center insapp_btn_state btn_delete" type="button" data-id="'.$order_id.'" id="btn_delete">Supprimer
                      </button>';
                  $statut = 'Refusé';
                  break;
                  }   
                      
                  case 'processing':{
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
                      
                  
                  case 'pending':{ 
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
                  $nbr_orders += 1;
                  $url = get_the_post_thumbnail_url($product_id) == false ? TLPLUGIN_URL . 'assets/images/default-placeholder.png': get_the_post_thumbnail_url($product_id);
              }
          }
            
          // insapp_facturation($order_id);
        }
    }
                
        
?>
<?php

    $current_user = wp_get_current_user();
    $author_id = $current_user->ID;
    $args = array(
        'post_type' => 'product',
        'author' => $author_id,
    );
    $services = new WP_Query( $args );
    $nbr_services = $services->found_posts;
?>

<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="d-flex justify-content-between mb-5 align-items-center">
                <h3 class="mb-0 ">
                    <span style="vertical-align: inherit;">
                        <span style="vertical-align: inherit;"><?php _e('Tableau de bord')?></span>
                    </span>
                </h3>
                <a href="javascript:void(0)" id="tab6" data-tab="6" class="btn btn-primary ins_dashbord_menu">
                    <?php _e('Ajouter un service')?>
                </a>
            </div>
            <div class="row row-cols-lg-2 row-cols-1 g-5  ">
                <div class="col">
                  <div class="card h-100 card-lift">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-semi-bold "><span style="vertical-align: inherit;"><span style="vertical-align: inherit;"><?php _e('Nombre de services') ?></span></span></span>
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart text-gray-400"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path><path d="M22 12A10 10 0 0 0 12 2v10z"></path></svg></span>

                      </div>
                      <div class="mt-4 mb-2 ">
                        <h3 class="fw-bold mb-0 text-center"><span style="vertical-align: inherit;"><span style="vertical-align: inherit;"><?php echo $nbr_services ?></span></span></h3>

                      </div>
                      <span class=" text-success "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up me-1 icon-xs"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg><span style="vertical-align: inherit;"><span style="vertical-align: inherit;">-2,50&nbsp;% </span></span></span>
                      <small><span style="vertical-align: inherit;"><span style="vertical-align: inherit;">contre 74,60 (préc.)</span></span></small>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="card h-100 card-lift">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-semi-bold "><span style="vertical-align: inherit;"><span style="vertical-align: inherit;"><?php _e('Nombre de reservations') ?></span></span></span>
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity text-gray-400"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg></span>

                      </div>
                      <div class="mt-4 mb-2 ">
                        <h3 class="fw-bold mb-0 text-center"><span style="vertical-align: inherit;"><span style="vertical-align: inherit;"><?php echo $nbr_orders ?></span></span></h3>

                      </div>
                      <span class="text-danger "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-down me-1 icon-xs"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg><span style="vertical-align: inherit;"><span style="vertical-align: inherit;">-26,50&nbsp;% </span></span></span>
                      <small><span style="vertical-align: inherit;"><span style="vertical-align: inherit;">contre 66,88 (préc.)</span></span></small>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="card h-100 card-lift">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-semi-bold "><span style="vertical-align: inherit;"><span style="vertical-align: inherit;"><?php _e('Nombre de clients ') ?></span></span></span>
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send text-gray-400"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg></span>

                      </div>
                      <div class="mt-4 mb-2 ">
                        <h3 class="fw-bold mb-0"><span style="vertical-align: inherit;"><span style="vertical-align: inherit;">2.15</span></span></h3>

                      </div>
                      <span class="text-danger "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-down me-1 icon-xs"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg><span style="vertical-align: inherit;"><span style="vertical-align: inherit;">-1,83&nbsp;% </span></span></span>
                      <small><span style="vertical-align: inherit;"><span style="vertical-align: inherit;">contre 2,19 (préc.)</span></span></small>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="card h-100 card-lift">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-semi-bold "><span style="vertical-align: inherit;"><span style="vertical-align: inherit;"><?php _e('Revenu total') ?></span></span></span>
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock text-gray-400"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></span>

                      </div>
                      <div class="mt-4 mb-2 ">
                        <h3 class="fw-bold mb-0 text-center"><span style="vertical-align: inherit;"><span style="vertical-align: inherit;">2m:15s</span></span></h3>

                      </div>
                      <span class="text-success "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up me-1 icon-xs"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg><span style="vertical-align: inherit;"><span style="vertical-align: inherit;">21,50&nbsp;% </span></span></span>
                      <small><span style="vertical-align: inherit;"><span style="vertical-align: inherit;">contre 2,19 (préc.)</span></span></small>
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>
</div>

<?php   $order = wc_get_order(24650 );
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
  foreach( $order->get_items() as $item_id => $item ) {
    $product_name = $item->get_name();
    $product_price =  $item->get_total();
    
}

  ?>
 
<div class="invoice_wrap">
		<div class="invoice-container">
			<div class="invoice-content-wrap" id="download_section">
				<!--Header Start Here -->
				<header class="invoice-header text-invoice content-min-width internet_header" id="invo_header">
					<div class="invoice-logo-content">
						<div class="invoice-logo">
							<a href="internet_invoice.html" class="logo">
              <?php 
                    $custom_logo_id = get_theme_mod( 'custom_logo' );
                    $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                    
                    if ( has_custom_logo() ) {  ?>
                        <img src="<?php echo esc_url( $logo[0] );?>" style="width: 150px;" alt="<?php get_bloginfo( 'name' );?>">
           
                    <?php } else {
                             echo '<h3 class="text-white">' . get_bloginfo('name') . '</h3>';
                 
                    }
                ?>
              </a>
						</div>
						<div class="invo-head-content">
							<div class="invo-head-wrap">
								<div class="invo-num-title invo-no inter-700">No de facture:</div>
								<div class="invo-num inter-400">#<?php _e( $order_number) ?></div>
							</div>
							<div class="invo-head-wrap invoi-date-wrap">
								<div class="invo-num-title invo-date inter-700">Invoice Date:</div>
								<div class="invo-num inter-400"><?php _e($date_paid) ?></div>
							</div>
						</div>
					</div>
					<div class="invoice-header-contact">
						<div class="invo-cont-wrap invo-contact-wrap">
							<div class="invo-social-icon">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_6_94)"><path d="M5 4H9L11 9L8.5 10.5C9.57096 12.6715 11.3285 14.429 13.5 15.5L15 13L20 15V19C20 19.5304 19.7893 20.0391 19.4142 20.4142C19.0391 20.7893 18.5304 21 18 21C14.0993 20.763 10.4202 19.1065 7.65683 16.3432C4.8935 13.5798 3.23705 9.90074 3 6C3 5.46957 3.21071 4.96086 3.58579 4.58579C3.96086 4.21071 4.46957 4 5 4" stroke="#00BAFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M15 7C15.5304 7 16.0391 7.21071 16.4142 7.58579C16.7893 7.96086 17 8.46957 17 9" stroke="#00BAFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M15 3C16.5913 3 18.1174 3.63214 19.2426 4.75736C20.3679 5.88258 21 7.4087 21 9" stroke="#00BAFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></g><defs><clipPath id="clip0_6_94"><rect width="24" height="24" fill="white"/></clipPath></defs>
								</svg>
							</div>
							<div class="invo-social-name">
								<a href="tel:+12345678899" class="invo-hedaer-contact inter-400 sm-text"><?php _e($customer_id ) ?></a>
							</div>
						</div>
						<div class="invo-cont-wrap">
							<div class="invo-social-icon">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_6_108)"><path d="M19 5H5C3.89543 5 3 5.89543 3 7V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V7C21 5.89543 20.1046 5 19 5Z" stroke="#00BAFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M3 7L12 13L21 7" stroke="#00BAFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></g><defs><clipPath id="clip0_6_108"><rect width="24" height="24" fill="white"/></clipPath></defs></svg>
							</div>
							<div class="invo-social-name">
								<a href="mailto:contact@invoice.com" class="invo-hedaer-mail inter-400 sm-text"><?php _e( $customer_email) ?></a>
							</div>
						</div>
					</div>
				</header>
				<!--Header End Here -->


				<!--Invoice content start here -->
				<section class="ticket-booking-content" id="internet_invoice">
					<div class="container">
						<!--invoice owner name content -->
						<div class="invoice-owner-conte-wrap">
							<div class="invo-to-wrap">
								<div class="invoice-to-content">
									<p class="invo-to inter-700 medium-font mtb-0">Bill To:</p>
									<h1 class="invo-to-owner inter-700 md-lg-font">Jordon Smith</h1>
									<p class="invo-owner-address medium-font inter-400 mtb-0">Phone: +1 562 563 8899 <br> Email: jordon123@mail.com</p>
								</div>
							</div>
							<div class="invo-pay-to-wrap">
								<div class="invoice-pay-content">
									<p class="inter-700 md-lg-font mtb-0 primary-color mb-digital">Digital Invoico LTD</p>
									<h2 class="disply-none">Display</h2>
									<p class="invo-owner-address medium-font inter-400 mtb-0">4510 E Dolphine St, IN 3526<br> Hills Road, New York, USA</p>
								</div>
							</div>
						</div>
						<!--invoice owner name end here -->

						<!--Internet  Details Start -->
						<div class="invo-car-book-wrap1 mt">
							<div class="booking-content-wrap">
								<div class="invo-book-detail detail-col-car1">
									<span class="sm-md-text book-id inter-700 invo-to">Durée:</span>
									<span class="add-info-desc inter-400"><?php _e($date) ?></span>
								</div>
								<div class="invo-book-detail detail-col-car1">
									<span class="sm-md-text check-in inter-700 invo-to">Date:</span>
									<span class="add-info-desc inter-400"><?php _e($date) ?></span>
								</div>
								<div class="invo-book-detail detail-col-car1">
									<span class="sm-md-text nights inter-700 invo-to">Créneaux:</span>
									<span class="add-info-desc inter-400"><?php _e($time) ?></span>
								</div>
							</div> 
						</div>
						<!--Internet  Details End -->

						<!--Internet Table Data Start here -->
						<div class="table-wrapper">
							<table class="invoice-table">
								<thead>
									<tr class="invo-tb-header">
										<th class="invo-table-title inter-700 medium-font">Sr No</th>
										<th class="invo-table-title inter-700 medium-font">Details</th>
										<th class="invo-table-title rate-title inter-700 medium-font">Amount</th>
									</tr>
								</thead>
								<tbody class="invo-tb-body">
									<tr class="invo-tb-row">
										<td class="invo-tb-data">1</td>
										<td class="invo-tb-data"><?php  _e($product_name) ?></td> 
										<td class="invo-tb-data total-data">
                    <span> <?php  _e($product_price) ?></span> <?php _e(get_woocommerce_currency_symbol()) ?>    
                   
                    </td>
									</tr> 
                 
                  <?php  var_dump($selected_extras); if(empty($selected_extras))
                  $i= 2;
                  {
                    
                  foreach($selected_extras as $extra){?>
									<tr class="invo-tb-row">
										<td class="invo-tb-data"><?php _e($i) ?></td>
										<td class="invo-tb-data"><?php  _e( $extra->nom)?></td> 
										<td class="invo-tb-data total-data">
                    <span> <?php  _e( $extra->cout) ?></span> <?php _e(get_woocommerce_currency_symbol()) ?>    
                   
                    </td>
									</tr>
                  <?php $i++; } }?>
								</tbody>
							</table>
						</div>
						<!-- Internet Table Data End here -->

						<!--Invoice additional info start here -->
						<div class="invo-addition-wrap">
							<div class="invo-add-info-content">
								<h3 class="addi-info-title inter-700 medium-font">Pay By:</h3>
								<div class="mon-send-left-data pf-data" >
									<!-- <div>
										<span class="mon-send-title sm-md-text b-text inter-500">Credit Card:</span>
										<span class="mon-send-desc sm-md-text second-color inter-400">**** **** **** **23</span>
									</div> -->
									<div>
										<span class="mon-send-title sm-md-text b-text inter-500">Amount:</span>
										<span class="mon-send-desc sm-md-text second-color inter-400">
                      <span> <?php  _e($total) ?></span> <?php _e(get_woocommerce_currency_symbol()) ?>    
                    </span>
									</div>
									<div>
										<span class="mon-send-title sm-md-text b-text inter-500">Date:</span>
										<span class="mon-send-desc sm-md-text second-color inter-400"><?php _e($date_paid) ?></span>
									</div>
								</div>
							</div>
							<div class="invo-bill-total">
								<table class="invo-total-table">
									<tbody>
										<tr>
											<td class="inter-700 medium-font b-text hotel-sub">Sub Total:</td>
											<td class="invo-total-data inter-400 medium-font second-color">
                        <span> <?php  _e($total) ?></span> <?php _e(get_woocommerce_currency_symbol()) ?>
                      </td>
										</tr>
										<tr class="tax-row bottom-border">
											<td class="inter-700 medium-font b-text hotel-sub">Discount</td>
											<td class="invo-total-data inter-400 medium-font second-color">$0.00</td>
										</tr>
										<tr class="invo-grand-total bottom-border">
											<td class="inter-700 sm-text primary-color hotel-sub">Grand Total:</td>
											<td class="sm-text b-text invo-total-price ">
                         <span> <?php  _e($total) ?></span> <?php _e(get_woocommerce_currency_symbol()) ?>
                      </td>
                      </tr>
									</tbody>
								</table>
							</div>
						</div>
						<!--Invoice additional info end here -->
 
					</div>
				</section>
			</div>

			<!--bottom content start here -->
			<section class="agency-bottom-content d-print-none" id="agency_bottom">
				<div class="container">
					<div class="invo-note-wrap">
						<div class="note-title">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_8_240)"><path d="M14 3V7C14 7.26522 14.1054 7.51957 14.2929 7.70711C14.4804 7.89464 14.7348 8 15 8H19" stroke="#00BAFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M17 21H7C6.46957 21 5.96086 20.7893 5.58579 20.4142C5.21071 20.0391 5 19.5304 5 19V5C5 4.46957 5.21071 3.96086 5.58579 3.58579C5.96086 3.21071 6.46957 3 7 3H14L19 8V19C19 19.5304 18.7893 20.0391 18.4142 20.4142C18.0391 20.7893 17.5304 21 17 21Z" stroke="#00BAFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 7H10" stroke="#00BAFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 13H15" stroke="#00BAFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M13 17H15" stroke="#00BAFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></g><defs><clipPath id="clip0_8_240"><rect width="24" height="24" fill="white"/>
							</clipPath></defs></svg>
							<span class="inter-700 medium-font">Note:</span>
						</div>
						<h3 class="inter-400 medium-font third-color note-desc mtb-0">This is computer generated receipt and does not require physical signature.</h3>
					</div>
				</div>
			</section> 
			<!--bottom content end here -->
		</div>
	</div>

 
