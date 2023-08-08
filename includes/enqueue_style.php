<?php

function csspersoCSS(){
    
    if(!empty($_GET['page']) && strpos($_GET['page'], 'insapp_') !== false){
    wp_enqueue_style('toast', TLPLUGIN_URL.'/assets/css/jquery.toast.min.css');
    wp_enqueue_style('mon_style', TLPLUGIN_URL.'assets/css/mon-style.css'); 
    wp_enqueue_style('Bootstrap', TLPLUGIN_URL.'/assets/css/bootstrap.min.css');
    wp_enqueue_style('tagify_front', TLPLUGIN_URL.'assets/libs/tagify.css');
    // wp_enqueue_style('tagify_css', ' https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css');
    wp_enqueue_style('muliselect', "https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" );
    wp_enqueue_style('boostrap_muliselect', "https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" );
}
}
    add_action('admin_enqueue_scripts', 'csspersoCSS',10,1);

    
function csspersoCSS2(){ 
    
    if(!empty($_GET['page']) && strpos($_GET['page'], 'insapp_') !== false){
    wp_enqueue_style('main_style_config', TLPLUGIN_URL.'/assets/css/main.css'); 
    wp_enqueue_style('thickbox');
}
}
    add_action('admin_enqueue_scripts', 'csspersoCSS2',10,1);



function csspersoCSS_front(){
    
    wp_enqueue_style('Bootstrap_front', TLPLUGIN_URL.'assets/css/bootstrap.min.css');
    wp_enqueue_style('style_min_front', TLPLUGIN_URL.'assets/css/css/dashboard.css');
    wp_enqueue_style('dropzone_front', TLPLUGIN_URL.'assets/css/front/dropzone.css');
    
    wp_enqueue_style('ib_datatable_front', "https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" );
    
    wp_enqueue_style('ib_datatable_front2', "https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" );
    wp_enqueue_script('calendar_css_front', TLPLUGIN_URL.'assets/libs/main.css');
    wp_enqueue_style('muliselect_front', "https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" );
    wp_enqueue_style('style_front', TLPLUGIN_URL.'assets/css/css/services.css');
    wp_enqueue_style('style_login_front', TLPLUGIN_URL.'assets/css/css/login.css');
    wp_enqueue_style('ins_calendar', TLPLUGIN_URL.'assets/css/css/calendar.css');
    wp_enqueue_style('toast_front', TLPLUGIN_URL.'/assets/css/jquery.toast.min.css');
    wp_enqueue_style('insapp_datatable_css', 'https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css');
    wp_enqueue_style('main_style_config_front', TLPLUGIN_URL.'assets/css/css/main_front.css'); 
   

}
 add_action('wp_enqueue_scripts', 'csspersoCSS_front',10000);
