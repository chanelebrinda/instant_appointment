<h3>
    <?php _e('Paiements')?>
</h3>


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

        $your_post = array();
        foreach($user_posts as $a_post){
            $your_post[] = $a_post->ID;
        }
 
     ?>

            <div class="row">
                <div class="col-12">
                    <!-- card -->
                    <div class="card p-2">

                        <div class="card-body">

                            <table id="insapp_payement_orders_table" class="table text-nowrap mb-0 table-centered">
                                <thead class="table-light">
                                    <tr>
                                        <th>
                                            <?php _e('Date')?>
                                        </th>
                                        <th>
                                            <?php _e('Montant')?>
                                        </th>
                                        <th>
                                            <?php _e('Commande')?>
                                        </th>
                                        <th>
                                            <?php _e('Annonce')?>
                                        </th>
                                        <th>
                                            <?php _e('Client')?>
                                        </th>
                                        <th>
                                            <?php _e('Facture')?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                     $args = array(
                                            'post_type'      => 'shop_order',
                                            'post_status'    => array( 'wc-completed', 'wc-processing' ),
                                            'posts_per_page' => -1,
                                        );

                                        $completed_orders_query = new WP_Query( $args );

                                        if ( $completed_orders_query->have_posts() ) {
                                            while ( $completed_orders_query->have_posts() ) {
                                                $completed_orders_query->the_post();
                                                // Récupérez les détails de la commande
                                                $order = wc_get_order( get_the_ID() );
                                                $customer = $order->get_user();
                                                // foreach ($variable as $key => $value) {
                                                //     # code...
                                                // }

                                                // if(in_array($product_id, $the_post)){

                                                ?>
                                        <tr>
                                            <td>
                                                <?php _e($order->get_date_paid()->date('d/m/Y')) ?>
                                            </td>
                                            <td> 
                                                <span>
                                                    <?php  _e($order->get_total()) ?>
                                                </span>
                                                <?php _e(get_woocommerce_currency_symbol()) ?>
                                            </td>
                                            <td class="ps-0">
                                                <a href="#!">
                                                    <?php _e($order->get_order_number() )?>
                                                </a>
                                            </td>
                                            <td>
                                                <?php 
                                                    foreach( $order->get_items() as $item_id => $item ) {
                                                        $product_name = $item->get_name();
                                                        echo '<p>' . $product_name . '</p>';
                                                    }
                                                    ?>
                                            </td>
                                            <td class="ps-1">
                                                <div class="d-flex align-items-center">
                                                    <div class="ms-2">
                                                        <p>
                                                            <?php _e($customer->display_name) ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn_generate_bill btn-icon btn-sm"
                                                    data-id="<?php _e($order->get_id()) ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                                                        <path
                                                            d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32V274.7l-73.4-73.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l128-128c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L288 274.7V32zM64 352c-35.3 0-64 28.7-64 64v32c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V416c0-35.3-28.7-64-64-64H346.5l-45.3 45.3c-25 25-65.5 25-90.5 0L165.5 352H64zm368 56a24 24 0 1 1 0 48 24 24 0 1 1 0-48z" />
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                <?php 
                                        }
                                    } 
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>