<div class="row mt-5 align-middle">
  <div class="align-middle col-8">
    <h3 class="text-dark mt-5">
      <?php _e('Mes reservations') ?>
    </h3>  
  </div>
  <div class="align-middle col-4">
    <select name="insapp_etat" id="insapp_etat" class="form-select align-middle">
      <option value="all" selected>
        <?php _e('Toutes les reservations')?>
      </option>
      <option value="on-hold">
        <?php _e('En attente')?>
      </option>
      <option value="pending">
        <?php _e('En cours de traitement')?>
      </option>
      <option value="completed">
        <?php _e('Terminés')?>
      </option>
      <option value="cancelled">
        <?php _e('Refusées')?>
      </option>
    </select>
  </div>
</div>
<div class="wrap">
  <div class="row">
    <?php
      $current_user = wp_get_current_user();
      $user_id = $current_user->ID;
      $args = array(
          'customer_id' => $user_id,
          'limit' => -1, // to retrieve _all_ orders by this user if is -1
          'status' => array('cancelled', 'completed', 'on-hold', 'pending', 'processing'),
                                
      );
      $orders = wc_get_orders($args);
      $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
      $orders_per_page = 5;
      $total_pages = ceil(count($orders) / $orders_per_page);
      $orders_chunked = array_chunk($orders, $orders_per_page);
      $current_orders = isset($orders_chunked[$paged - 1]) ? $orders_chunked[$paged - 1] : array();
      $cpt = 0;
      if(isset($current_orders)){
        foreach($current_orders as $order){
          $cpt++;
          $order_id = $order->id;
          $item = wc_get_order($order_id );
          $order_data = $order->data;
          $customer_id = $order -> get_user_id (); 
          $customer = get_user_by('id', $customer_id);
          $date = get_post_meta( $order_id, '_booking_date', true );
          $time = get_post_meta( $order_id, '_booking_time', true );
          $bd_extras = get_post_meta( $order_id, '_booking_extra', true );
          $extras = isset($bd_extras) ? json_decode($bd_extras) : [];
          if(get_post_meta( $order_id, '_order_subscription', true ) != 'is_subscription'){
            foreach ($item->get_items() as $item_id => $item_order ) {
              $product_id = $item_order["product_id"];
              $product = get_post($product_id);
              $categories = wp_get_post_terms($product_id, 'product_cat');
              $meta = get_post_meta($product_id);
              $dure = isset($meta['_duration'][0]) ? $meta['_duration'][0] : 'undefine';
  
              $title = $product->post_title;
              $author_name = get_user_by('ID', $product->post_author)->display_name;
              $author_email = get_user_by('ID', $product->post_author)->user_email;
              switch ($order_data[ 'status' ]) {
                case 'on-hold':
                  $statut = 'En attente';
                  $btn = '<button class="dropdown-item d-flex align-items-center text-warning insapp_btn_state btn_refuser_client" data-id="'. $order_id.'" type="button" id="btn_refuser">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 me-2 icon-xs">
                                  <polyline points="3 6 5 6 21 6"></polyline>
                                  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                  <line x1="10" y1="11" x2="10" y2="17"></line>
                                  <line x1="14" y1="11" x2="14" y2="17"></line>
                              </svg>Annuler
                          </button>';
                  break;
                case 'cancelled':
                  $statut = 'Annulé';
                  $btn = '<button class="dropdown-item d-flex align-items-center text-danger insapp_btn_state btn_delete" data-id="'. $order_id.'" type="button" id="btn_delete">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 me-2 icon-xs">
                                  <polyline points="3 6 5 6 21 6"></polyline>
                                  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                  <line x1="10" y1="11" x2="10" y2="17"></line>
                                  <line x1="14" y1="11" x2="14" y2="17"></line>
                              </svg>Supprimer
                          </button>';
                  break;
                case 'completed':{
                  $statut = 'Terminé';
                  $btn = '';
                  break;
                }
                case 'pending':{
                  $payment_url = wc_get_checkout_url($order_id) ;
                  $statut = 'Accepté';
                  $btn = '<button type="button" class="insapp_button_back btn_payment" data-id="'. $order_id.'" data-product-id="'.$product_id.'" type="button" id="btn_pay">Payer</button>';
                  break;
                }
                case 'processing':{
                  $payment_url = wc_get_checkout_url($order_id) ;
                  $statut = 'Payé';
                  $btn = '';
                  break;
                }
                default:
                  
                  break;
              }
              if($statut == 'Annulé'){
                $color = 'danger';
              }elseif($statut == 'Accepté'){
                $color = 'success';
              }elseif($statut == 'Terminé'){
                $color = 'primary';
              }else{
                $color = 'warning';
              }  
              $url = get_the_post_thumbnail_url($product_id) == false ? TLPLUGIN_URL . 'assets/images/default-placeholder.png': get_the_post_thumbnail_url($product_id);
               
    ?>

    <div class="row insapp_listing_timeline py-2">
      <span></span>
    </div>
    <div class="">
      <div class="row insapp_listing">
        <div class="col-6">
          

           <div class="d-flex align-items-center mb-3 mb-xl-0" style="width:100%"> 
           <div class="insapp_gallery" style="width:30%;background-image: url('<?php _e($url)?>')"> </div>
            <div class="ms-3"  style="width:70%">
              <div class="">
                <span class="ia_table_title" style="vertical-align: inherit;">
                  <?php echo '<span>' .  $title .'</span>' ?>
                </span>
              </div>
              <span class="mb-0 ia_table_text">
                <?php echo('Rendez-vous : '.$time) ?>
              </span></br>
              <span class="mb-0 ia_table_text">
                <?php echo('Le : '.$date) ?>
              </span></br>
              <span class="mb-0 ia_table_text">
              <?php echo 'prix: '.$order_data [ 'total' ].' '. get_woocommerce_currency_symbol(); ?>
              </span>
            </div>
          </div>

        </div>
        <div class="col-2 d-flex align-items-center ">
          <span class="badge badge-<?php echo $color; ?>-soft text-<?php echo $color; ?>">
            <span style="vertical-align: inherit;">
              <span style="vertical-align: inherit;">
                <?php echo $statut ; ?>
              </span>
            </span>
          </span>
        </div>

        <div class="col-4 d-flex justify-content-end align-items-center ">
        <span class="ia_table_collapse pe-5 d-flex justify-content-between align-items-center ">
            <?php echo $btn ?> 
            <span class="insapp_details ps-5 " type="button" data-bs-toggle="collapse" data-bs-target="#listingcollapse<?php _e($cpt)?>" >
            <?php _e(' Details') ?>
            </span>
          </span>
          
        </div>
        <div class="collapse" id="listingcollapse<?php _e($cpt)?>">
          <div class="detailslistingcollapse d-flex flex-column">
            <div class="mb-0 row">
              <span class="ia_table_subtitle col-4">
                <?php _e('Catégories: ') ?>
              </span>
              <?php foreach($categories as $category){?>
              <span class="ia_table_text  col-8">
                <?php echo $category->name; ?>
              </span>
              <?php }?>
            </div>
            <div class="mb-0 row">
              <span class="ia_table_subtitle col-4">
                <?php _e('Extras') ?>
              </span>
              <span class="ia_table_text  col-8">
               <?php  if(empty($extras)){
                  foreach($extras as $extra){?>
                <li class="col">
                <?php echo $extra->nom.' (' .$extra->cout.get_woocommerce_currency_symbol().')' ;?>
                </li> 
                <?php } }?>
              </span>
            </div>
            <!-- <div class="mb-0 row">
              <span class="ia_table_subtitle col-4">
                <?php _e('Reservé pour le ') ?>
              </span>
              <span class="ia_table_text  col-8">
                <?php echo $date.' à '.$time; ?>
              </span>
            </div> -->
            <div class="mb-0 row">
              <span class="ia_table_subtitle col-4">
                <?php _e('Auteur') ?>
              </span>
              <span class="ia_table_text  col-8">
                <?php echo $author_name.' - '.$author_email ?>
              </span>
            </div>
            <div class="mb-0 row">
              <span class="ia_table_subtitle col-4">
                <?php _e('Reservé le') ?>
              </span>
              <span class="ia_table_text  col-8">
                <?php echo $order_data['date_created']->date('d-m-Y H:i:s'); ?>
              </span>
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
        <p class="insapp_info_b">
          <?php _e("Vous n'avez aucune reservation pour l'instant")?>
        </p>
       
      </div>
    </div>
    <?php }?>
  </div>
</div>