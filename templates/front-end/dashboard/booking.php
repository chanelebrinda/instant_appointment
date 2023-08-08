<div class="row mt-5 align-middle">
  <div class="align-middle col-8">
    <h3 class="text-dark align-middle">
      <?php _e('Reservation d\'annonces') ?>
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
<?php
    $current_user = wp_get_current_user();
    $args_sub = array(
        'post_type' => 'shop_order',
        'meta_key ' => '_order_subscription',
        'meta_value'    => 'is_subscription', // Postmeta value field
        'meta_compare'  => 'LIKE', // Possible values are ‘=’, ‘!=’, ‘>’, ‘>=’, ‘<‘, ‘<=’, ‘LIKE’, ‘NOT LIKE’, ‘IN’, ‘NOT IN’, ‘BETWEEN’, ‘NOT BETWEEN’, ‘EXISTS’ (only in WP >= 3.5), and ‘NOT EXISTS’ (also only in WP >= 3.5). Values ‘REGEXP’, ‘NOT REGEXP’ and ‘RLIKE’ were added in WordPress 3.7. Default value is ‘=’
    );
    $current_user = wp_get_current_user(); 
    $user_info = get_userdata($current_user->ID);   
    $user_email = $user_info->user_email;

    $subscriptions = wc_get_orders( $args_sub );
   
      if(!empty($subscriptions)){

        foreach($subscriptions as $subscription){
            $subscription_id = $subscription->id;
            $item = wc_get_order($subscription_id );                                    
            $customer_name = $subscription->data["billing"]["first_name"].' '.$subscription->data["billing"]["last_name"];
            $customer_email = $subscription->data["billing"]["email"];
        
            if($customer_email == $user_email){
                foreach ($item->get_items() as $item_id => $item_order ) {

                    $product = $item_order->get_product();
                    $product_id = $product->id;
                    $meta = get_post_meta($product_id);
                    $interval = $meta["_subscription_period_interval"][0];
                    $date_fin = new DateTime($subscription->get_date_paid()->date('Y-m-d H:i:s'));
                    $date_fin = $date_fin->modify("+$interval months");
                    $now = new DateTime(date('Y-m-d H:i:s'));
                    $temps_restant = $date_fin->diff($now); 
                    if($temps_restant->y >= 0 && $temps_restant->m >= 0 && $temps_restant->d >= 0 && $temps_restant->h >= 0 && $temps_restant->i >= 0 && $temps_restant->s >= 0 && $temps_restant->f >= 0 ){
              ?>

<div class="insapp_resa_list">

  <?php
                          
                          $current_user = wp_get_current_user();
                          $author_id = $current_user->ID;
                          $args1 = array(
                            'author'      => $author_id,
                            'post_type'   => 'product',
                            'orderby'     => 'author', 
                            'numberposts' => -1,
                          ); 
                          $user_posts = get_posts( $args1 );

                          $the_post = array();
                          foreach($user_posts as $a_post){
                            $the_post[] = $a_post->ID;
                          }
                          $args = array(
                            'limit' => -1, 
                            'status' => array('cancelled', 'completed', 'on-hold', 'pending', 'processing'),
                          );
                          $orders = wc_get_orders($args); 

                          $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
                          $orders_per_page = 3;
                          $total_pages = ceil(count($orders) / $orders_per_page);
                          $orders_chunked = array_chunk($orders, $orders_per_page);
                          $current_orders = isset($orders_chunked[$paged - 1]) ? $orders_chunked[$paged - 1] : array();

              
                          
                          if(isset($current_orders)){
                
                              foreach($current_orders as $order){
                                $order_id = $order->id;
                                $item = wc_get_order($order_id );
                                $order_data = $order->data;
                                $status = $order_data[ 'status' ] ;
                                // var_dump(json_decode(get_post_meta($order_id) ["_booking_extra"][0]));
                                $customer_id = $order -> get_user_id (); 
                                $customer = get_user_by('id', $customer_id);
                                $customer_name = $customer->display_name;
                                $customer_email = $customer->user_email;
                                $date = get_post_meta( $order_id, '_booking_date', true );
                                $time = get_post_meta( $order_id, '_booking_time', true );
                                $bd_extras = get_post_meta( $order_id, '_booking_extra', true );
                                $extras = isset($bd_extras) ? json_decode($bd_extras) : [];
                                
                                  // if($status != 'delete'){
                                    if(get_post_meta( $order_id, '_order_subscription', true ) != 'is_subscription'){

                                      foreach ($item->get_items() as $item_id => $item_order ) {

                                          $product = $item_order->get_product();
                                          $product_id = $product->id;

                                          $categories = wp_get_post_terms($product_id, 'product_cat');
                                          $meta = get_post_meta($product_id);
                                          $dure = isset($meta['_duration'][0]) ? $meta['_duration'][0] : 'undefine';
                                          
                                          $title = $product->name;

                                          // var_dump($product->name);
                                          switch ($status) {
                                            case 'cancelled':{
                                              $btn = '<button class="dropdown-item d-flex align-items-center insapp_btn_state btn_delete" type="button" data-id="'.$order_id.'" id="btn_delete">Supprimer
                                                  </button>';
                                              $statut = 'Refusé';
                                              break;
                                            }   
                                                
                                            case 'pending':{
                                              $btn = '';
                                              $statut = 'Accepté';
                                              break;

                                            } 
                                                
                                            case 'processing':{
                                              $btn = '<button class="dropdown-item d-flex align-items-center insapp_btn_state btn_fini" data-id="'.$order_id.'" type="button" id="btn_fini">Terminer
                                                      </button>';
                                              $statut = 'Payé';
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
                                                $url = get_the_post_thumbnail_url($product_id) == false ? TLPLUGIN_URL . 'assets/images/default-placeholder.png': get_the_post_thumbnail_url($product_id);
                      ?>
  <div class="row insapp_listing_timeline py-2">
    <span></span>
    <input type="hidden" name="the_order_id" id="the_order_id" value="<?php echo $order_id; ?>">
  </div>
  <div class="">
    <div class="row insapp_listing">
      <div class="col-6">

        <div class="d-flex align-items-center mb-3 mb-xl-0" style="width:100%">
          <div class="insapp_gallery" style="width:40%;background-image: url('<?php _e($url)?>')"> </div>
          <div class="ms-3" style="width:60%">
            <div class="">
              <span class="ia_table_title" style="vertical-align: inherit;">
                <?php echo '<span>' .  $title .'</span>' ?>
              </span>
            </div>
            <span class="mb-0 ia_table_text">
              <?php echo('Rendez-vous : '.$time) ?>
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

      <div class="col-4 d-flex justify-content-end insapp_btn_state align-items-center " data-toggle="collapse"
        href="#listingcollapse" role="button" aria-expanded="false" aria-controls="listingcollapse">
        <span class="ia_table_collapse">
          <?php echo $btn ?>
        </span>
      </div>
      <div class="" id="listingcollapse">
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
          <!-- <div class="mb-0 row">
                                                                <span class="ia_table_subtitle col-4"><?php _e('Extras') ?></span>
                                                                <span class="ia_table_text  col-8">
                                                                  <?php foreach($extras as $extra){?>
                                                                      <li class="col-1"><?php echo $extra->nom.' (' .$extra->cout.get_woocommerce_currency_symbol().')' ;?></li>
                                                                  <?php }?>
                                                                </span>
                                                              </div> 
                                                            -->
          <div class="mb-0 row">
            <span class="ia_table_subtitle col-4">
              <?php _e('Reservé pour le ') ?>
            </span>
            <span class="ia_table_text  col-8">
              <?php echo $date.' à '.$time; ?>
            </span>
          </div>
          <div class="mb-0 row">
            <span class="ia_table_subtitle col-4">
              <?php _e('Client') ?>
            </span>
            <span class="ia_table_text  col-8">
              <?php echo $customer_name.' - '.$customer_email ?>
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

  <?php 
                                            }
                                      }
                                  
                              } }?>

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
  <?php
                          } else { 
                            ?>
  <div class="">
    <div class="row insapp_listing">
      <p class="text-muted fw-semibold fs-3">
        <?php _e("Vous n'avez aucune reservation en cours pour l'instant")?>
      </p>
    </div>
  </div>
  <?php
                          } 

                          ?>


</div>
<?php
                    }else{
                       ?>
<div class="">
  <div class="row insapp_listing">
    <p class="insapp_info_b">
      <?php _e("Vous n'avez pas d'abonnement actif")?>
    </p>
  </div>
</div>
<?php 
                    }
                }
            }else{
                ?>
<div class="">
  <div class="row insapp_listing">
    <p class="insapp_info_b">
      <?php _e("Vous n'avez pas d'abonnement actif")?>
    </p>
  </div>
</div>
<?php
            }
          } 


      }else{
            ?>
<div class="">
  <div class="row insapp_listing">
    <p class="insapp_info_b">
      <?php _e("Vous n'avez pas d'abonnement actif")?>
    </p>
  </div>
</div>
<?php
        }
            