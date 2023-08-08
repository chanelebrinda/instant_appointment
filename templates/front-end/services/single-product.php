<?php 

    global $product;
    $id = $product->get_id();
    error_log($product);
    error_log($id);  
    $_product = wc_get_product( $id );
    $name = $_product->get_name();
    $price_reg = $_product->get_regular_price();
    $price_sale = $_product->get_sale_price();
    $price = $_product->get_price();
    $categories = wp_get_post_terms($id, 'product_cat');
    $author_id  = get_the_author_meta('ID');
    $author = get_the_author_meta( 'display_name');
    $meta = get_post_meta($id);
    $dure = isset($meta['_duration'][0]) ? $meta['_duration'][0] : 'undefine';
    $extras = isset($meta["_extras"]) ? json_decode($meta["_extras"][0]) : [];
    $duration = isset($meta['_duration'][0]) ? $meta['_duration'][0] : '1:00';
    $url = get_the_post_thumbnail_url($id,'full') == false ? TLPLUGIN_URL . 'assets/images/default-placeholder.png': get_the_post_thumbnail_url();
    $dashboard_page = get_option('insapp_settings_name')['Dashboard_page']; 
    

 
  ?>
<div style="background-color: #FFF">
    <div class="insapp_single_services">
        <div class="insapp_single_services_container" style="background-image: 
            url('<?php _e($url)?>')">
            <div class="insapp_single_services_content">
                <div class="insapp_single_services_content_title">

                    <div class="insapp_service_item">
                        <div class="insapp_service_item_content">
                            <?php foreach($categories as $category){?>
                            <span class="tag">
                                <?php esc_attr_e($category->name) ?>
                            </span>
                            <?php } ?>
                        </div>
                        <span class="like-icon listeo_core-unbookmark-it liked">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-heart icon-sm">
                                <path
                                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                </path>
                            </svg>
                        </span>
                        <h1>
                            <?php esc_attr_e( $name) ?>
                        </h1>
                    </div>
                </div>

            </div>
            <span class="insapp_single_services_image"></span>

        </div>
    </div>
    <div class="insapp_single_service_body">

        <div class="insapp_single_service_description">

            <div class=" mb-4" id="insapp_descriptione_accordion">
                <ul class="list-group list-group-flush">
            
                    <li class="list-group-item px-0">
                        <!-- Toggle -->
                        <a class="d-flex justify-content-start align-items-center text-inherit text-decoration-none h4 mb-0"
                            data-bs-toggle="collapse" href="#insapp_product_details" role="button" aria-expanded="true"
                            aria-controls="insapp_product_details">
                            <div class="me-auto insapp_accordion_title">
                                Description
                            </div>
                            <!-- Chevron -->
                            <div>
            
                                <span class="chevron-arrow  ms-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-chevron-down icon-xs">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </span>
                            </div>
                        </a>
                        <div class="collapse show" id="insapp_product_details" data-bs-parent="#insapp_descriptione_accordion"
                            style="">
                            <div class="py-3 ">
                                <?php the_content(); ?>  
                            </div>
                        </div>
                    </li>
                    <!-- List group item -->
                    <li class="list-group-item px-0">
                        <!-- Toggle -->
                        <a class="d-flex align-items-center text-inherit text-decoration-none h4 mb-0 collapsed"
                            data-bs-toggle="collapse" href="#specifications" role="button" aria-expanded="false"
                            aria-controls="specifications">
                            <div class="me-auto insapp_accordion_title">
                                Specifications
                            </div>
                            <!-- Chevron -->
                            <span class="chevron-arrow  ms-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-chevron-down icon-xs">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </span>
                        </a>
                        <div class="collapse " id="specifications" data-bs-parent="#insapp_descriptione_accordion">
                            <div class="py-3 ">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
            
                                            <th class="w-20">Sport</th>
                                            <td>Running</td>
            
                                        </tr>
                                        <tr>
            
                                            <th class="w-20">Material</th>
                                            <td>Mesh</td>
            
                                        </tr>
                                        <tr>
            
                                            <th class="w-20">Fastening</th>
                                            <td>Lace-Ups </td>
            
                                        </tr>
                                        <tr>
            
                                            <th class="w-20">Outsole Type</th>
                                            <td>Marking </td>
            
                                        </tr>
                                        <tr>
            
                                            <th class="w-20">Warranty</th>
                                            <td>3 months </td>
            
                                        </tr>
            
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </li>
            
                    <li class="list-group-item px-0 border-bottom">
            
                        <a class="d-flex align-items-center text-inherit text-decoration-none h4 mb-0 collapsed"
                            data-bs-toggle="collapse" href="#insapp_product_reviews" role="button" aria-expanded="false"
                            aria-controls="insapp_product_reviews">
                            <div class="me-auto insapp_accordion_title">
                                Commentaires
                            </div>
                            <!-- Chevron -->
                            <span class="chevron-arrow  ms-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-chevron-down icon-xs">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </span>
                        </a>
                        <div class="collapse" id="insapp_product_reviews" data-bs-parent="#insapp_descriptione_accordion" style="">
                            <div class="py-3 ">
                                <div class="mb-4">
                                    <h3 class="mb-4">Ratings &amp; Reviews</h3>
                                    <div class="row align-items-center mb-4">
                                        <div class="col-md-4 mb-4 mb-md-0">
                                            <!-- rating -->
                                            <h3 class="display-2 ">4.5</h3>
                                            <i class="bi bi-star-fill text-success"></i>
                                            <i class="bi bi-star-fill text-success"></i>
                                            <i class="bi bi-star-fill text-success"></i>
                                            <i class="bi bi-star-fill text-success"></i>
                                            <i class="bi bi-star-fill text-success"></i>
                                            <p class="mb-0">595 Verified Buyers</p>
                                        </div>
                                        <div class="offset-lg-1 col-lg-7 col-md-8">
                                            <!-- progress -->
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="text-nowrap me-3 text-muted"><span
                                                        class="d-inline-block align-middle text-muted">5</span><i
                                                        class="bi bi-star-fill ms-1 fs-6"></i></div>
                                                <div class="w-100">
                                                    <div class="progress" style="height: 6px;">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%;"
                                                            aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div><span class="text-muted ms-3">420</span>
                                            </div>
                                            <!-- progress -->
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="text-nowrap me-3 text-muted"><span
                                                        class="d-inline-block align-middle text-muted">4</span><i
                                                        class="bi bi-star-fill ms-1 fs-6"></i></div>
                                                <div class="w-100">
                                                    <div class="progress" style="height: 6px;">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: 50%;"
                                                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="50"></div>
                                                    </div>
                                                </div><span class="text-muted ms-3">90</span>
                                            </div>
                                            <!-- progress -->
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="text-nowrap me-3 text-muted"><span
                                                        class="d-inline-block align-middle text-muted">3</span><i
                                                        class="bi bi-star-fill ms-1 fs-6"></i></div>
                                                <div class="w-100">
                                                    <div class="progress" style="height: 6px;">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: 35%;"
                                                            aria-valuenow="35" aria-valuemin="0" aria-valuemax="35"></div>
                                                    </div>
                                                </div><span class="text-muted ms-3">33</span>
                                            </div>
                                            <!-- progress -->
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="text-nowrap me-3 text-muted"><span
                                                        class="d-inline-block align-middle text-muted">2</span><i
                                                        class="bi bi-star-fill ms-1 fs-6"></i></div>
                                                <div class="w-100">
                                                    <div class="progress" style="height: 6px;">
                                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 22%;"
                                                            aria-valuenow="22" aria-valuemin="0" aria-valuemax="22"></div>
                                                    </div>
                                                </div><span class="text-muted ms-3">12</span>
                                            </div>
                                            <!-- progress -->
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="text-nowrap me-3 text-muted"><span
                                                        class="d-inline-block align-middle text-muted">1</span><i
                                                        class="bi bi-star-fill ms-1 fs-6"></i></div>
                                                <div class="w-100">
                                                    <div class="progress" style="height: 6px;">
                                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 14%;"
                                                            aria-valuenow="14" aria-valuemin="0" aria-valuemax="14"></div>
                                                    </div>
                                                </div><span class="text-muted ms-3">40</span>
                                            </div>
            
                                        </div>
                                    </div>
                                    <div>
                                        <!-- review -->
                                        <div class="border-top py-4 mt-4">
                                            <div class="border d-inline-block px-2 py-1 rounded-pill mb-3">
                                                <!-- rating -->
                                                <span class="text-dark  ">4.4 <i
                                                        class="bi bi-star-fill text-success fs-6"></i></span>
                                            </div>
                                            <!-- text -->
                                            <p>It's awesome , I never thought about Dash UI that awesome shoes.very pretty.</p>
                                            <div>
                                                <span>James Ennis</span>
                                                <span class="ms-4">28 Nov 2023</span>
                                            </div>
                                        </div>
                                        <div class="border-top py-4">
                                            <div class="border d-inline-block px-2 py-1 rounded-pill mb-3">
                                                <!-- rating -->
                                                <span class="text-dark  ">5.0 <i
                                                        class="bi bi-star-fill text-success fs-6"></i></span>
                                            </div>
                                            <!-- text -->
                                            <p>Quality is more than good that I was expected for buying. I first time
                                                purchase Dash UI shoes &amp; this brand is good. Thanks to Dash UI delivery
                                                was faster than fast ...Love Dash UI</p>
                                            <div>
                                                <span>Bradley Mouton</span>
                                                <span class="ms-4">21 Apr 2023
                                                </span>
                                            </div>
                                        </div>
                                        <div class="border-top py-4 border-bottom">
            
                                            <div class="border d-inline-block px-2 py-1 rounded-pill mb-3">
                                                <!-- rating -->
                                                <span class="text-dark  ">4.4 <i
                                                        class="bi bi-star-fill text-success fs-6"></i></span>
                                            </div>
                                            <!-- text -->
                                            <p>Excellent shoes with original logo , Thanks Dash UI , Buy these shoes
                                                without any tension</p>
                                            <div class="mb-5">
                                                <!-- img -->
                                                <img alt="avatar" class="avatar-md rounded-4"
                                                    src="<?php _e(TLPLUGIN_DEFAULT. '/avatar-fallback.jpg')?>">
                                                <img alt="avatar" class="avatar-md rounded-4"
                                                    src="<?php _e(TLPLUGIN_DEFAULT. '/avatar-fallback.jpg')?>">
                                            </div>
                                            <div>
                                                <!-- text -->
                                                <span>Kieth J. Watson </span>
                                                <span class="ms-4">21 May 2023</span>
                                            </div>
                                        </div>
                                        <div class="my-3">
                                            <!-- btn-link -->
                                            <a href="#!" class="btn-link fw-semi-bold ">View all 89 reviews</a>
                                        </div>
                                    </div>
                                </div>
            
            
                            </div>
                        </div>
                    </li>
                </ul>
            </div>


        </div>
        <div class="insapp_single_service_booking">
            <div class="insapp_booking_content">
                <div class="insapp_service_price">
                    <span class="ia_price_product" data_price="<?php _e($price_sale) ?>">
                        <?php esc_attr_e($price_sale) ?>
                    </span>
                    <span class="">
                        <?php echo get_woocommerce_currency_symbol() ; ?>
                    </span>
                </div>
                <div class="insapp_vendor_store_details ">
                    <div class="insapp_vendor_store_details_image">
                        <a href="#">
                            <img alt="avatar" class="vendor_store_image_single avatar-md rounded-2" src="<?php _e(TLPLUGIN_DEFAULT. '/avatar-fallback.jpg')?>" width="50" height="50">
                        </a>
                    </div>
                    <div class="insapp_vendor_store_details_single">
                        <div class="insapp_vendor_store_details_nameshop">
                            <span class="insapp_vendor_store_details_label">
                                <?php _e( 'Publier par'); ?>
                            </span>
                            <span class="insapp_vendor_store_details_title">
                                <h5><a href="https://bookingmarketplace.dokandemo.com/store/travelers-paradise/"
                                        class="wcvendors_cart_sold_by_meta">
                                        <?php echo $author; ?>
                                    </a>
                                </h5>
                                <input type="hidden" id="insapp_author_id" value="<?php esc_attr_e($author_id) ?>" data-id="<?php _e( get_current_user_id()) ?>">
                            </span>
                        </div>
                        <span class="vendor_store_details_contact">
                            <a href="https://bookingmarketplace.dokandemo.com/store/travelers-paradise/#dokan-form-contact-seller"
                                class="vendor_store_owner_contactlink"><i class="rhicon rhi-envelope"
                                    aria-hidden="true"></i>
                                
                                    <form action="<?php if( $dashboard_page ) {
                                            echo esc_url(get_permalink(get_option('insapp_settings_name')['Dashboard_page']));
                                        } ?>" class="insapp_envoyerMessageBtn">
                                         <a href="" class="insapp_envoyerMessage_link" type="submit">
                                        <?php $current_user=wp_get_current_user();
                                            $roles=$current_user->roles;
                                            $role = array_shift( $roles );
                                            if(!in_array($role,array('administrator','insapp_photographe','insapp_customers'))){
                                            echo ('data-bs-toggle="modal" data-bs-target="#staticBackdrop"');
                                        } ?>
                                       <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M448 0H64C28.7 0 0 28.7 0 64v288c0 35.3 28.7 64 64 64h96v84c0 7.1 5.8 12 12 12 2.4 0 4.9-.7 7.1-2.4L304 416h144c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64zm16 352c0 8.8-7.2 16-16 16H288l-12.8 9.6L208 428v-60H64c-8.8 0-16-7.2-16-16V64c0-8.8 7.2-16 16-16h384c8.8 0 16 7.2 16 16v288z"/></svg>
                                       <span> <?php _e( 'Envoyer un message'); ?></span>
                                    </a>
                                        
                                    </form>
                                
                            </a>
                        </span>
                    </div>
                </div>
                <div class="woo-button-area mb10" id="woo-button-area">

                    <p class="insapp_info">
                        <?php _e( ''); ?>
                    </p>

                    <form class="insapp_form_booking"
                        action="<?php echo esc_url(get_permalink(get_option('insapp_settings_name')['Dashboard_page'])) ?>"
                        method="post">
                        <div id="wc-bookings-booking-form" class="wc-bookings-booking-form" style="">
                        </div>

                        <div class="input-group me-3 d-flex justify-content-center " readonly="readonly">
                            <input class=" insapp_booking_date" type="hidden">
                            <input class=" insapp_booking_slot_choosen" type="hidden" value=" "> 
                            <input class=" insapp_booking_range" type="hidden" value="<?php _e($duration) ?>"> 
                        </div>

                        <input type="hidden" class="insapp_slot_value "value= "">
                        <div class="insapp_loader_ajax_container " style=""> <div class="insapp_loader_ajax"></div> </div>
                            
                        <div class="insapp_booking_slots" id="slot_container">

                        </div>
                        
                        <?php
                        if(getType($extras) === 'array' && count($extras) > 0){
                        ?>
                        <div style="width:90%">
                            <a class="nav-link has-arrow collapsed insapp_extra"
                                style="display: flex; justify-content: space-between; background: #f8f9fa" href="#!"
                                data-bs-toggle="collapse" data-bs-target="#navDashboard" aria-expanded="false"
                                aria-controls="navDashboard">
                                <span class=" px-3" style="vertical-align: inherit;"><span style="vertical-align: inherit;">
                                        <?php _e('Extras') ?>
                                    </span></span>
                                <svg id="changeColor" fill="#DC7633" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="21" viewBox="0 0 375 374.9999"
                                    height="21" version="1.0">
                                    <defs></defs>
                                    <g></g>
                                    <g id="inner-icon" transform="translate(85, 110)"> <svg
                                            xmlns="http://www.w3.org/2000/svg" width="199.8" height="199.8"
                                            fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16"
                                            id="IconChangeColor">
                                            <path
                                                d="M3.204 5h9.592L8 10.481 3.204 5zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z"
                                                id="mainIconPathAttribute"></path>
                                        </svg> </g>
                                </svg>
                            </a>

                            <div id="navDashboard" class="collapse px-3" data-bs-parent="#sideNavbar" style="">
                                <ul class="nav flex-column">
                                    <?php foreach($extras as $extra){ ?>
                                    <li class="nav-item">
                                        <div class="mb-3">
                                            <div class="form-check custom-checkbox">
                                                <input type="checkbox" class="form-check-input prod_exta insapp_extra_list" data_calculate="<?php _e($extra->cout) ?>" value="<?php _e($extra->nom) ?>">
                                                <label class="form-check-label d-flex justify-content-between">
                                                    <span class="fs-5">
                                                        <?php echo $extra->nom ;?>
                                                    </span>
                                                    <span class="fs-5">
                                                        <?php echo $extra->cout.get_woocommerce_currency_symbol() ;?>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>

                                    </li>
                                    <?php }?>
                                </ul>
                            </div>

                            

                        </div>
                        <?php }?>
                                            

                        <div class="insapp_total_content  "  style="width:90%">
                            <div>
                                <span>Cout Total</span>
                            </div>
                            <div  class =ia_price_product_content_total>
                                <span class="ia_price_product_total">
                                <?php esc_attr_e($price_sale) ?>
                            </span>
                            <span class="">
                                <?php echo get_woocommerce_currency_symbol() ; ?>
                            </span>
                        </div>
                    
                    
                </div>
                        <a type="submit" class="insapp_button insapp_btn_booking" <?php $current_user=wp_get_current_user();
                            $roles=$current_user->roles;
                            $role = array_shift( $roles );
                            if(!in_array($role,array('administrator','insapp_photographe','insapp_customers'))){
                            echo ('data-bs-toggle="modal" data-bs-target="#staticBackdrop"');
                            }
                            ?>
                            >
                            <?php _e( 'Reserver'); ?>
                            
                            <div class="insapp_loader_ajax_btn" ></div>
                        </a>
                        <input type="hidden" name="the_id" id="the_id" value="<?php echo $id ?>">
                    </form>
                </div>
              

            </div>
        </div>
    </div>
    <div class="insapp_single_service pb-4">
        <div class="row">
            <?php 
                $categories = wp_get_post_terms(get_the_ID(), 'product_cat', array('fields' => 'ids'));
                
                if (!empty($categories)) {
                    // Arguments de requête pour récupérer les produits associés
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 3,
                        'post__not_in' => array(get_the_ID()), // Exclure le produit actuel
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field' => 'term_id',
                                'terms' => $categories,
                                'operator' => 'IN'
                            )
                        )
                    );
                    // Exécuter la requête pour récupérer les produits associés
                    $related_query = new WP_Query($args);
                    // Vérifier s'il y a des produits associés
                    if ($related_query->have_posts()) {?>
                        <h2 class="pb-3"><?php _e('Produits associés')?></h2>'
    
                        <div class="row insapp_related_products"><?php
                        while ($related_query->have_posts()) {
                            $related_query->the_post();
                                global $product;
                                $product_id = $related_query->post->ID;
                                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), array('220','220'), true );
                                $title = get_the_title();
                                $_product = wc_get_product( $related_query->post->ID );
                                $price_reg = $_product->get_regular_price()?$_product->get_regular_price():0;
                                $price_sale = $_product->get_sale_price()?$_product->get_sale_price():0;
                                $price = $_product->get_price();
                                $categories = wp_get_post_terms($product_id, 'product_cat');
                                $url = get_the_post_thumbnail_url() == false ? TLPLUGIN_URL . 'assets/images/default-placeholder.png': get_the_post_thumbnail_url();
                
            ?>
            <div class="col-lg-4 col-md-6">
                <a href="<?php echo esc_url( get_permalink( get_the_id() ) ); ?>" class="insapp_service_item_container">
                    <div class="insapp_service_item">
                        <div class="insapp_service_small_badges_container"></div>
                        <img width="520" height="397"
                        src="<?php _e($url)?>" alt=""
                        decoding="async" loading="lazy">  
                            
                            <div class="insapp_service_item_content">
                                <?php foreach($categories as $category){ ?>
                                <span class="tag"><?php echo($category->name);} ?></span> 
                            </div>
                            <span class="like-icon listeo_core-unbookmark-it liked">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-heart icon-sm"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                            </span>
                    </div>
                    <div class="insapp_service_item_body"> 
                        <h3><?php echo($title); ?></h3>
                        <div class="insapp_service_star_rating">
                            <span><small><?php echo $price_reg.'€ - ' ?></small><?php echo $price_sale.'<span>€</span>' ?></span>
                            <div class="insapp_service_rating_counter">
                                <span class="text-dark  ">4.4 <i class="bi bi-star-fill text-success fs-6"></i></span>
                            </div>
                        </div>
                    </div>    
                </a>
            </div>
            <?php
                    }
                    echo '</div>';
                    // Réinitialiser les données de la boucle principale de WordPress
                    wp_reset_postdata();
                }
                }
            ?>
        </div>
    </div>

   <div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
               
                <div class="modal-body">
                    <?php
            $current_user = wp_get_current_user();
            $roles = $current_user->roles;
            $role = array_shift( $roles ); 
            if(!in_array($role,array('administrator','insapp_photographe','insapp_customers'))){       
                $template_loader = new Insapp_Template_Loader; 
                $template_loader->get_template_part( 'account/login'); 
            }else{
                $template_loader = new Insapp_Template_Loader; 
                $template_loader->get_template_part( 'reservation'); 
            }
        ?>
                </div>
       
            </div>
        </div>
    </div>
    </div>