<?php

function jspersoJS(){
    if(!empty($_GET['page']) && strpos($_GET['page'], 'insapp_') !== false){
        wp_enqueue_script('toast', TLPLUGIN_URL.'assets/js/jquery.toast.min.js', array('jquery'), null, true);
        wp_enqueue_script('mon_script', TLPLUGIN_URL.'assets/js/mon_script.js', array('jquery'), null, true);
        wp_enqueue_script('Sweetalert', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', array('jquery'), null, true);

        wp_enqueue_script('Bootstrap', TLPLUGIN_URL.'assets/js/bootstrap.min.js');
        wp_enqueue_script('Bootstrap_bundle', TLPLUGIN_URL.'assets/js/bootstrap.bundle.min.js');
        wp_enqueue_script('Select', "https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js");
        if ( ! did_action( 'wp_enqueue_media' ) ) {
            wp_enqueue_media();
        }
        wp_enqueue_script('users', TLPLUGIN_URL.'assets/js/insapp_user.js', array('jquery'), null, true);
        wp_localize_script( 'users', 'users_ajax', array('ajaxurl' => admin_url( 'admin-ajax.php' ),));
        wp_enqueue_script('customers', TLPLUGIN_URL.'assets/js/insapp_customer.js', array('jquery'), null, true);
        wp_localize_script( 'customers', 'customers_ajax', array('ajaxurl' => admin_url( 'admin-ajax.php' ),));
        wp_enqueue_script('rdv', TLPLUGIN_URL.'assets/js/insapp_rdv.js', array('jquery'), null, true);
        wp_localize_script( 'rdv', 'rdv_ajax', array('ajaxurl' => admin_url( 'admin-ajax.php' ),));
        wp_enqueue_script('tagify_js', TLPLUGIN_URL.'assets/libs/tagify.min.js', array('jquery'), null, true);
   
        // wp_enqueue_script('tagify_script', 'https://cdn.jsdelivr.net/npm/@yaireo/tagify', array('jquery'));
       
        wp_enqueue_script('subscription_script', TLPLUGIN_URL.'assets/js/js/subscription.js', array('jquery'), null, true);
        wp_localize_script( 'subscription_script', 'subscription_ajax', array('ajaxurl' => admin_url( 'admin-ajax.php' ),));
    }
}
add_action('admin_enqueue_scripts', 'jspersoJS',10, 0);

function jspersoJS2(){
     // Load upload an thickbox script
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_script('main_script_config', TLPLUGIN_URL.'assets/js/main.js', array('jquery'), null, true);
    wp_enqueue_script('subscription_script', TLPLUGIN_URL.'assets/js/js/subscription.js', array('jquery'), null, true);
    wp_localize_script( 'subscription_script', 'subscription_ajax', array('ajaxurl' => admin_url( 'admin-ajax.php' ),));
}
add_action('admin_enqueue_scripts', 'jspersoJS2',10, 100);


add_action( 'wp_enqueue_scripts','jspersoJS_front',10, 1);
function jspersoJS_front(){
    wp_enqueue_script('Bootstrap_front', TLPLUGIN_URL.'assets/js/bootstrap.min.js', array('jquery'), null, true);
    wp_enqueue_script('Bootstrap_bundle_front', TLPLUGIN_URL.'assets/js/bootstrap.bundle.min.js', array('jquery'), null, true);
    wp_enqueue_script('popper_front','https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js', array('jquery'), null, true);
    wp_enqueue_script('services_js', TLPLUGIN_URL.'assets/js/front/services.js', array('jquery'), null, true);
    wp_localize_script('services_js', 'reservation_service_front_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
    wp_enqueue_script('main_script_config', TLPLUGIN_URL.'assets/js/main.js', array('jquery'), null, true);
    wp_enqueue_script('toast_front', TLPLUGIN_URL.'assets/js/jquery.toast.min.js', array('jquery'), null, true);
    wp_enqueue_script('Sweetalert_front', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', array('jquery'), null, true);

    wp_enqueue_script('flatpickr_js', TLPLUGIN_URL.'assets/libs/flatpickr.min.js', array('jquery'), null, true);
    wp_enqueue_script('quill_js', TLPLUGIN_URL.'assets/libs/quill.min.js', array('jquery'), null, true);
    wp_enqueue_script('feather_js', TLPLUGIN_URL.'assets/libs/feather.min.js', array('jquery'), null, true);
    wp_enqueue_script('dropzone_js', TLPLUGIN_URL.'assets/libs/dropzone.min.js', array('jquery'), null, true);
    wp_enqueue_script('feather_js', TLPLUGIN_URL.'assets/libs/feather.min.js', array('jquery'), null, true);
    wp_enqueue_script('moment_js', TLPLUGIN_URL.'assets/libs/moment.min.js', array('jquery'), null, true);
    wp_enqueue_script('moment_range_js', TLPLUGIN_URL.'assets/libs/moment-range.js', array('jquery'), null, true);
    wp_enqueue_script('insapp_datatable_js','https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js', array('jquery'), null, true);
    // wp_enqueue_script('insapp_chat_js', TLPLUGIN_URL.'assets/libs/chat.js', array('jquery'), null, true);
   
    wp_enqueue_script('calendar_js', TLPLUGIN_URL.'assets/libs/main.js', array('jquery'), null, true);
    wp_enqueue_script('services_js', TLPLUGIN_URL.'assets/js/front/services.js', array('jquery'), null, true);
    wp_localize_script('services_js', 'booking_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
    wp_enqueue_script('agenda_js', TLPLUGIN_URL.'assets/js/front/agenda.js', array('jquery'), null, true);
    wp_localize_script('agenda_js', 'insapp_agenda_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
    wp_enqueue_script('dashboard_script_js', TLPLUGIN_URL.'assets/js/front/dashboard.js', array('jquery'), null, true);
    wp_localize_script( 'dashboard_script_js', 'service_front_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));

    wp_enqueue_script('user_auth', TLPLUGIN_URL.'assets/js/front/login.js', array('jquery'), null, true);
    wp_localize_script( 'user_auth', 'insapp_user_login', array('ajaxurl' => admin_url( 'admin-ajax.php' ),));

    wp_enqueue_script('profils_script_js', TLPLUGIN_URL.'assets/js/front/profils.js', array('jquery'), null, true);
    wp_localize_script( 'profils_script_js', 'profils_front_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
    
    
}
    




