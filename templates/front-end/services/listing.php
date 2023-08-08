<div class="insapp_service_container">
    <div class="row">
<?php 



YITH_Stripe_Connect::instance()->frontend->print_account_page();







// if ( class_exists( 'YITH_Stripe_Connect_Frontend' ) ) {
//     $stripe_frontend = new YITH_Stripe_Connect_Frontend();
    
//     // Use the method to enqueue scripts and styles for the account page
//     $stripe_frontend->enqueue_scripts_for_account_page();
    
//     // Retrieve the current user's status and generate the button HTML
//     $current_status = yith_wcsc_get_stripe_user_status( get_current_user_id() );
//     $button_text = '';
//     $button_class = '';

//     if ( 'connect' == $current_status ) {
//         $button_text = apply_filters( 'yith_wcsc_disconnect_from_stripe_button_text', __( 'Disconnect from Stripe', 'yith-stripe-connect-for-woocommerce' ) );
//         $button_class = 'yith-sc-disconnect';
//     } else if ( 'disconnect' == $current_status ) {
//         $button_text = apply_filters( 'yith_wcsc_connect_with_stripe_button_text', __( 'Connect with Stripe', 'yith-stripe-connect-for-woocommerce' ) );
//     }

//     $oauth_link = $stripe_frontend->_stripe_connect_api_handler->get_OAuth_link();

//     echo '<a href="' . esc_url( $oauth_link ) . '" class="' . esc_attr( $button_class ) . '">' . esc_html( $button_text ) . '</a>';
// }


$button_text = apply_filters( 'yith_wcsc_connect_with_stripe_button_text', __( 'Connect with Stripe', 'yith-stripe-connect-for-woocommerce' ) );
   
?>
        <div class="insapp_loader_ajax_container" style=""><div class="insapp_loader_ajax"></div> </div>
        <?php
           $services_page = (get_query_var('paged')) ? get_query_var('paged') : 1;
        // var_dump($number_elements);
           $args = array(
            'post_type' => 'product',
            'posts_per_page' => $number_elements,
            'paged' => $services_page,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_type',
                    'field'    => 'slug',
                    'terms'    => 'simple',
                ),
                array(
                    'key'     => '_stock_status',
                    'value'   => 'instock', // Filtrer uniquement les produits en stock
                    'compare' => '=',
                ),

            ),
        );

            $services = new WP_Query( $args );
            if ( $services->have_posts() ) {
            while ( $services->have_posts() ) : $services->the_post(); 
                global $product;
                $product_id = $services->post->ID;
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), array('220','220'), true );
                $title = get_the_title();
                $_product = wc_get_product( $services->post->ID );
                $price_reg = $_product->get_regular_price()?$_product->get_regular_price():0;
                $price_sale = $_product->get_sale_price()?$_product->get_sale_price():0;
                $price = $_product->get_price();
                $categories = wp_get_post_terms($product_id, 'product_cat');
                $url = get_the_post_thumbnail_url() == false ? TLPLUGIN_URL . 'assets/images/default-placeholder.png': get_the_post_thumbnail_url();
                $user_email = get_the_author_meta('user_email');
                $product_type = WC_Product_Factory::get_product_type($product_id);
                if($product_type === 'simple'){
                    $args_sub = array(
                        'post_type' => 'shop_order',
                        'meta_key ' => '_order_subscription',
                        'meta_value'    => 'is_subscription', // Postmeta value field
                        'meta_compare'  => 'LIKE', // Possible values are ‘=’, ‘!=’, ‘>’, ‘>=’, ‘<‘, ‘<=’, ‘LIKE’, ‘NOT LIKE’, ‘IN’, ‘NOT IN’, ‘BETWEEN’, ‘NOT BETWEEN’, ‘EXISTS’ (only in WP >= 3.5), and ‘NOT EXISTS’ (also only in WP >= 3.5). Values ‘REGEXP’, ‘NOT REGEXP’ and ‘RLIKE’ were added in WordPress 3.7. Default value is ‘=’
                    );

                    $subscriptions = wc_get_orders( $args_sub );
                    if(isset($subscriptions)){
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
                
                <div class="col-lg-4 col-md-6 py-5">
                    <a href="<?php echo esc_url( get_permalink( get_the_id() ) ); ?>" class="insapp_service_item_container">
                        <div class="insapp_service_item">
                            <div class="insapp_service_small_badges_container"></div>
                            <img width="520" height="397"
                            src="<?php _e($url)?>" alt=""
                            decoding="async" loading="lazy">  
                                
                                <div class="insapp_service_item_content">
                                    <?php 
                                    foreach($categories as $category){ }?>
                                    <span class="tag"><?php echo($category->name); ?></span> 
                                </div>
                                <span class="like-icon listeo_core-unbookmark-it liked align-center">
                                    <span class="pe-2 " id="service_rating"><?php _e('0.0')?></span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="star" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>.star{fill:#ffffff !important}</style><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/></svg>
                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc.<style>svg{fill:#ad0000}</style><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/></svg> -->
                                </span>
                        </div>
                        <div class="insapp_service_item_body"> 
                            <h3><?php echo($title); ?></h3>
                            <div class="insapp_service_star_rating">
                               <span><small><?php echo $price_reg.''.get_woocommerce_currency_symbol().' - ' ?></small><?php echo $price_sale.'<span>'.get_woocommerce_currency_symbol().'</span>' ?></span>
                               <div class="insapp_service_rating_counter">
                                    <span class="  ">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1.25em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#000000 !important}</style><path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z"/></svg>
                                        <!-- <svg xmlns="http://www.w3.org/2000/svg" height="1.25em" viewBox="0 0 512 512">! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc.<style>svg{fill:#a80000}</style><path d="M47.6 300.4L228.3 469.1c7.5 7 17.4 10.9 27.7 10.9s20.2-3.9 27.7-10.9L464.4 300.4c30.4-28.3 47.6-68 47.6-109.5v-5.8c0-69.9-50.5-129.5-119.4-141C347 36.5 300.6 51.4 268 84L256 96 244 84c-32.6-32.6-79-47.5-124.6-39.9C50.5 55.6 0 115.2 0 185.1v5.8c0 41.5 17.2 81.2 47.6 109.5z"/></svg> -->
                                    </span>
                                </div>
                           </div>
                        </div>    
                    </a>
                </div>         
                <?php
                }
              }
           }

       }
    }

                
                 } endwhile; 
        wp_reset_query();
} else {
     __( 'No products found' );
}
wp_reset_postdata(); 

?>     
        

    </div>

</div>