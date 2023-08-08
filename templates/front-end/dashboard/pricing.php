<div class="row">
  <!-- col -->
  <div class="row mb-18">
    <!-- text -->
    <div class="col-md-12 col-12 mb-5">
      <h3 class="display-4 fw-bold ls-sm text-center">Trouvez le forfait qui vous convient</h3>

    </div>
        <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_type',
                        'field'    => 'slug',
                        'terms'    => 'subscription',
                    ),
                ),
             );
     
          $subscription_products = new WP_Query($args); 
          
          if ($subscription_products->have_posts()) {
              while ($subscription_products->have_posts()) {

                  $subscription_products->the_post();
                  
                  $list_elements =json_decode( get_post_meta(get_the_ID(), '_list_element', true));
                  $regular_price = get_post_meta(get_the_ID(), '_regular_price', true);
                  $billing_period = get_post_meta(get_the_ID(), '_subscription_period', true);
                  $billing_interval = get_post_meta(get_the_ID(), '_subscription_period_interval', true);
                  $currency = get_woocommerce_currency_symbol();
                  $status = get_post_status(); 
                  $sale_price = get_post_meta(get_the_ID(), '_sale_price', true);
                  if($billing_period == 'month'){
                    $billing_period  = 'mois';
                }
                if($status == 'publish'){
                    $status  = 'publié';
                }
                ?>

                  <div class="col-xl-4 col-lg-6 col-md-12 col-12 mb-3">
                    <!-- card -->
                    <div class="card">
                      <!-- card body -->
                      <div class="card-body border-bottom">
                        <!-- text -->
                        <h3 class="mb-3">
                          <?php echo esc_html(get_the_title()) ?>
                        </h3>
                        <p class="mb-0">
                          <?php echo esc_html(get_post( get_the_ID())->post_content)?>
                        </p>
                        <!-- price -->
                        <div class="d-flex align-items-end mt-3">
                          <h4 class=" me-1 mb-0">
                            <?php _e($regular_price.' '.$currency )?>
                          </h4>
                          <p class="mb-0">/
                            <?php _e($billing_period)?>
                          </p>
                        </div>
                        <!-- button -->
                      </div>
                      <!-- card body -->
                      <div class="card-body">
                        <?php  if($list_elements != NULL){ ?>
                        <p class="mb-0">Toutes les fonctionnalités de base, y compris:</p>
                          <ul class="list-unstyled my-4 mb-0">
                              <?php
                                  foreach ($list_elements as $list_element) {
                                              ?>
                              <li class="mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                  fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                  class="feather feather-check-circle me-2 text-success icon-xs">
                                  <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                  <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                                <?php _e($list_element) ?> 
                              </li>
                                <?php }  ?>         
                          </ul>
                          </p>
                        <?php } ?>
                                  
                        <div class="my-5">
                          <a href="#!" class="insapp_btn_state_sub abonnement_payment my-4"
                            data-id="<?php echo get_the_ID() ?>">Acheter</a>
                        </div>
                      </div>
                    </div>
                  </div>
              <?php }
            }?>
          </div>

  </div>
</div>