<!-- 
/***********************************************************************
***********            liste abonnes                 **************
*****************************************************************/ -->


<style>
    .table>:not(caption)>*>* { 
        padding: 0.75rem 1.5rem;
    }
</style>
<div class="wrap">
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="row justify-content-between mb-4">
                        <div class="col-lg-8 col-md-8 col-12">
                            <!-- Page header -->
                            <div class="mb-5">
                                <h3 class="mb-0 ">Les Abonnés</h3>

                            </div>
                        </div>
                        
                    </div>

                    <table class="table mb-0 text-nowrap table-centered">
                        <thead class="table-light">
                            <tr>
                                <th>No </th>
                                <th>Abonné</th>
                                <th>Abonnement</th>
                                <th>Statut </th>
                                <th>Date de l'abonnement</th>
                                <th>Fin de l'abonnement</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $args = array(
                                'post_type' => 'shop_order',
                                'meta_key ' => '_order_subscription',
                                'meta_value'    => 'is_subscription', // Postmeta value field
                                'meta_compare'  => 'LIKE', // Possible values are ‘=’, ‘!=’, ‘>’, ‘>=’, ‘<‘, ‘<=’, ‘LIKE’, ‘NOT LIKE’, ‘IN’, ‘NOT IN’, ‘BETWEEN’, ‘NOT BETWEEN’, ‘EXISTS’ (only in WP >= 3.5), and ‘NOT EXISTS’ (also only in WP >= 3.5). Values ‘REGEXP’, ‘NOT REGEXP’ and ‘RLIKE’ were added in WordPress 3.7. Default value is ‘=’
                            );

                            $orders = wc_get_orders( $args );

                            if(isset($orders)){
                                foreach($orders as $order){
                                    $order_id = $order->id;
                                    $item = wc_get_order($order_id );                                    
                                    $customer_name = $order->data["billing"]["first_name"].' '.$order->data["billing"]["last_name"];
                                    $customer_email = $order->data["billing"]["email"];
                                    $price = $order->data["total"].get_woocommerce_currency_symbol() ;
                                    $date_paiement = $order->get_date_paid()->date('d M Y  H:i:s');

                                    // var_dump($date_paiement);
                                    foreach ($item->get_items() as $item_id => $item_order ) {

                                        $product = $item_order->get_product();
                                        $product_id = $product->id;
                                        $meta = get_post_meta($product_id);
                                        $title = $product->name;
                                        $interval = $meta["_subscription_period_interval"][0];
                                        $date_fin = new DateTime($order->get_date_paid()->date('Y-m-d H:i:s'));
                                        $date_fin = $date_fin->modify("+$interval months");
                                        $date_fin_view = date_format( $date_fin, 'd M Y H:i:s' );
                                        $now = new DateTime(date('Y-m-d H:i:s'));
                                        $temps_restant = $date_fin->diff($now); 
                                        if($temps_restant->y <= 0 && $temps_restant->m <= 0 && $temps_restant->d <= 0 && $temps_restant->h <= 0 && $temps_restant->i <= 0 && $temps_restant->s <= 0 && $temps_restant->f <= 0 ){
                                            $statut = 'Terminé';
                                            $class = "badge badge-danger-soft text-danger";
                                        }else{
                                            $statut = 'En cours';
                                            $class = "badge badge-success-soft text-success";
                                        }
                                        // var_dump( $statut );
                                    }
                            ?>
                            <tr>
                                <td>
                                    <span>
                                        <?php echo '#'.esc_html($order_id) ?>
                                    </span>
                                </td>
                                <td class="row">
                                    <h6 class="mb-0 ia_table_text col-12">
                                        <?php echo esc_html($customer_name) ?>
                                    </h6>
                                    <span class="mb-0 ia_table_text" style=" font-weight: 600;">
                                        <a href="mailto:<?php echo esc_html($customer_email) ?>"><?php echo esc_html($customer_email) ?></a>
                                    </span>
                                </td>

                                <td>
                                    <span>
                                        <?php echo esc_html( $title ) ?>
                                    </span>
                                </td>

                                <td>
                                    <span class="<?php echo esc_html( $class ) ?>">
                                        <?php echo esc_html( $statut ) ?>
                                    </span>
                                </td>

                                <td>
                                    <span>
                                        <?php echo esc_html( $date_paiement ) ?>
                                    </span>
                                </td>

                                <td>
                                    <span>
                                        <?php echo esc_html( $date_fin_view ) ?>
                                    </span>
                                </td>
                            </tr>
                            <?php }}  ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>