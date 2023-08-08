<h3>Liste des annonces</h3>

<div class="row">
    <?php

            $current_user = wp_get_current_user();
            $author_id = $current_user->ID;
            $args = array(
                'post_type' => 'product',
                'author' => $author_id,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_type',
                        'field'    => 'slug',
                        'terms'    => 'simple',
                    ),
                ),
            );
            $cpt = 0;
            $services = new WP_Query( $args );
            if ( $services->have_posts() ) {
            while ( $services->have_posts() ) : $services->the_post(); 
                global $product;
               
                $cpt++;
                $product_id = $services->post->ID;
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), array('220','220'), true );
                $title = get_the_title();
                $_product = wc_get_product( $services->post->ID );
                $price_reg = $_product->get_regular_price()?$_product->get_regular_price():0;
                $price_sale = $_product->get_sale_price()?$_product->get_sale_price():0;
                $price = $_product->get_price();
                $categories = wp_get_post_terms($product_id, 'product_cat');
                $datas = $_product->get_data();
                $meta_product = $datas["meta_data"];
                $meta = get_post_meta($product_id);
                $date_created = get_the_date();
                $duration = isset($meta['_duration'][0]) ? $meta['_duration'][0] : 'undefine';
                $extras = isset($meta["_extras"]) ? json_decode($meta["_extras"][0]) : [];
                // var_dump($extras);
                // $the_date = current_datetime();
                // $interval = $date_created->diff($current_datetime);
                $url = get_the_post_thumbnail_url() == false ? TLPLUGIN_URL . 'assets/images/default-placeholder.png': get_the_post_thumbnail_url();
                $product_type = WC_Product_Factory::get_product_type($product_id);
                if($product_type === 'simple'){
            ?>
    <div>

    

        <div class="row insapp_listing_timeline py-2">
            <span></span>
        </div>
        <div class="">
            <div class="row insapp_listing">
                <div class="col-7">

                    <div class="d-flex mb-3 mb-xl-0" style="width:100%">
                        <div class="insapp_gallery" style="width:25%;background-image: url('<?php _e($url)?>')"> </div>
                        <div class="ms-3" style="width:75%">
                            <div class="">
                                <span class="ia_table_title" style="vertical-align: inherit;">
                                    <?php  echo $title; ?>
                                </span>
                            </div>
                            <span class="mb-0 ia_table_text">
                                <?php  echo 'Durée: '.$duration; ?>
                            </span></br>
                            <span class="mb-0 ia_table_text" style=" font-weight: 600;">

                                <?php  echo 'Prix: <span style="text-decoration: line-through; color: #000;">'.$price_reg.' '.get_woocommerce_currency_symbol().'</span> - <span>'.$price_sale.' '.get_woocommerce_currency_symbol().'</span>'; ?>

                            </span>
                            <span class="ia_table_collapse"></br>
                            <span class="insapp_details pt-2" type="button" data-bs-toggle="collapse" data-bs-target="#serviceslistingcollapse<?php _e($cpt)?>" >
                                Détails
                            </span>
                    </span>
                        </div>
                    </div>

                </div>
                <div class="col-2 d-flex align-items-center ">
                    <span class="badge badge-success-soft text-success">
                        <span style="vertical-align: inherit;">
                            <span style="vertical-align: inherit;">
                                <?php  echo $date_created; ?>
                            </span>
                        </span>
                    </span>
                </div>


                <div class="col-3 d-flex justify-content-evenly align-items-center">                  
                    <span class="btn_del insapp_btn_action" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Suppimer" data-id="<?php echo $product_id ?>" id="btn_del">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-trash-2 me-2 icon-xs">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                            </path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </span>
                    <span class="btn_edit insapp_btn_action" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Modifier" data-id="<?php echo $product_id ?>" id="btn_edit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-edit me-2 icon-xs">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                    </span>
                    <a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>">
                      <span class="btn_edit insapp_btn_action" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Voir" data-id="<?php echo $product_id ?>" id="btn_edit">    
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                           class="feather feather-eye me-2 icon-xs">
                           <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                           <circle cx="12" cy="12" r="3"></circle></svg>
                       </span>
                    </a> 
                   
                </div>


                <div class="collapse" id="serviceslistingcollapse<?php _e($cpt)?>">
                    <div class="detailslistingcollapse d-flex flex-column">
                        <div class="mb-0 row">
                            <span class="ia_table_subtitle col-4">
                                <?php  _e('Categorie: ') ?>
                            </span>
                            <?php foreach($categories as $category){?>
                            <span class="ia_table_text  col-8">
                                <?php echo $category->name; ?>
                            </span>
                            <?php }?>
                        </div>
                        <div class="mb-0 row">
                            <span class="ia_table_subtitle col-4">
                                <?php _e('extras')?>
                            </span>
                            <span class="ia_table_text col-8">
                                <?php 
                                if(is_array($extras)){
                                foreach($extras as $extra){
                                ?>
                                <li class="col">
                                    <?php echo $extra->nom.' (' .$extra->cout.'€)' ;?>
                                </li>
                                <?php }}?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <?php } endwhile;}?>
</div>