<?php
    $current_user = wp_get_current_user();
    
    $args = array('taxonomy'   => "product_cat",'hide_empty'=> false);
    $categories = get_terms( $args);
    $args = array(
        'post_type' => 'shop_order',
        'meta_key ' => '_order_subscription',
        'meta_value'    => 'is_subscription',  
        'meta_compare'  => 'LIKE',  );

    $orders = wc_get_orders( $args );

    if(!empty($orders)){
        foreach($orders as $order){
            $order_id = $order->id;
            $item = wc_get_order($order_id );                                    
            $customer_name = $order->data["billing"]["first_name"].' '.$order->data["billing"]["last_name"];
            $customer_email = $order->data["billing"]["email"];
            $user_email =$current_user->data->user_email;
        
            if($customer_email == $user_email){
                foreach ($item->get_items() as $item_id => $item_order ) {

                    $product = $item_order->get_product();
                    $product_id = $product->id;
                    $meta = get_post_meta($product_id);
                    $interval = $meta["_subscription_period_interval"][0];
                    $date_fin = new DateTime($order->get_date_paid()->date('Y-m-d H:i:s'));
                    $date_fin = $date_fin->modify("+$interval months");
                    $now = new DateTime(date('Y-m-d H:i:s'));
                    $temps_restant = $date_fin->diff($now); 
                    if($temps_restant->y >= 0 && $temps_restant->m >= 0 && $temps_restant->d >= 0 && $temps_restant->h >= 0 && $temps_restant->i >= 0 && $temps_restant->s >= 0 && $temps_restant->f >= 0 ){

                    
                        ?>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12 mt-5">
                                <!-- Page header -->
                                <div class="my-5">
                                    <h3 class="mt-5">
                                        <?php _e('Ajouter une annonce','instant_Appointement') ?>
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <form action="" class="insapp_register_service">
                            <div class="row">
                                <div class="col-md-12 col-12">
                                
                                    <div class="card mb-4">
                                    
                                        <div class="card-body">
                                            <div class="mb-5 col-lg-12 col-12 ">
                                                <label for="insapp_service_name" class="form-label">
                                                    <?php _e("Nom","instant_Appointement") ?>
                                                </label>
                                                <input type="text" id="insapp_service_name" class="form-control" placeholder="<?php _e(" Entrez le nom du service","instant_Appointement") ?>"
                                                required="" />
                                            </div>

                                            <div class="mb-5 col-lg-12 col-12">
                                                <label class="form-label">
                                                    <?php _e("Description","instant_Appointement") ?>
                                                </label>

                                                <div class="pb-8 ql-container ql-snow" id="insapp_service_editor">
                                                    <div class="ql-editor ql-blank" data-gramm="false" contenteditable="true">
                                                        <p><br></p>
                                                    </div>
                                                    <div class="ql-clipboard" contenteditable="true" tabindex="-1"></div>
                                                    <div class="ql-tooltip ql-hidden">
                                                        <a class="ql-preview" rel="noopener noreferrer" target="_blank" href="about:blank"></a>
                                                        <input type="text" data-formula="e=mc^2" maxlength="15" data-link="https://quilljs.com"
                                                            data-video="Embed URL">
                                                        <a class="ql-action"></a>
                                                        <a class="ql-remove"></a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="card mb-4">
                                        
                                            <div class="card-body">
                                        
                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        <?php _e('Prix Regulier','instant_Appointement') ?>
                                                    </label>
                                                    <input type="text" class="form-control" id="insapp_price_reg" placeholder="49.00 <?php echo get_woocommerce_currency_symbol() ;?>" />
                                                </div>
                                            
                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        <?php _e('Prix promotionnel','instant_Appointement') ?>
                                                    </label>
                                                    <input type="text" class="form-control" id="insapp_price_sale" placeholder="49.00 <?php echo get_woocommerce_currency_symbol() ;?>"
                                                        required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="card mb-4">
                                            
                                            <div class="card-body">
                                            
                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-between">
                                                        <label class="form-label">
                                                            <?php _e('Categorie','instant_Appointement') ?>
                                                        </label>
                                                    </div>
                                                
                                                    <select class="form-select" id="insapp_category" aria-label="Default select example"
                                                        required>
                                                        <?php foreach($categories as $category){?>
                                                        <option value="<?php echo $category->slug ;?>">
                                                            <?php echo $category->name ;?>
                                                        </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                        
                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        <?php _e('Durée du service','instant_Appointement') ?>
                                                    </label>
                                                    <input name='insapp_duree' id="insapp_duree" type="time" class="form-control"
                                                        placeholder='<?php _e(" Choisir la durée du service","instant_Appointement") ?>'
                                                        required />

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row ">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="col-12 mt-3 table-responsive">
                                                <table class="table table-bordered" style="border-color : #cbd5e1; border-raduis: 5px">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">
                                                                <?php _e("Extra") ?>
                                                            </th>
                                                            <th class="text-center">
                                                                <?php _e("Cout") ?>
                                                            </th>
                                                            <th class="text-center">
                                                                <?php _e("Action") ?>
                                                            </th>
                                                        </tr>
                                                    </thead>

                                                    <tbody id="tab_extra"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    
                                        <div class="card-body">
                                        <div class="row">
                                                <div class="col-5">
                                                    <label class="form-label">
                                                        <?php _e("Nom de l'extra") ?>
                                                    </label>
                                                    <input type="text" class="form-control" id="nom_extra" />
                                                </div>

                                                <div class="col-3">
                                                    <label class="form-label">
                                                        <?php _e("Cout de l'extra") ?>
                                                    </label>
                                                    <input type='number' class="form-control" id='cout_extra' />
                                                </div>

                                                <div class="col-4">
                                                    <br />
                                                    <a class="btn btn-primary" id="btn_addM">
                                                        <?php _e(" + Ajouter") ?>
                                                    </a>
                                            
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="mb-4">
                                        <h5 class="mb-1">
                                            <?php _e('Image du service')?>
                                        </h5>
                                        <p>
                                            <?php _e('Ajouter la photo principale.')?>
                                        </p>
                                        <input type="file" class="form-control" id="product_img" required>
                                    </div>
                                    <input type="hidden" class="insapp_img_service_url" value="" />
                                    <div id="preview"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="card px-5">
                                    <div class="card-body">

                                        <div class="col-6">
                                            <button type="submit" class="btn btn-primary insapp_register_service_btn"
                                                style="padding: 10px 40px;">
                                                <?php _e('Créer le service')?>
                                                <span class="insapp_loader_ajax_btn" ></span>
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
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