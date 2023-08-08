<?php

$current_user = wp_get_current_user();
$roles = $current_user->roles;
$role = array_shift( $roles );  
$user_info = get_userdata($current_user->ID);
$user_img = $user_info->user_url;
 

if(!in_array($role,array('administrator','insapp_photographe','insapp_customers'))) :
    $template_loader = new Insapp_Template_Loader; 
    $template_loader->get_template_part( 'account/login'); 
    return;
endif;


global $wpdb;
$sql =  "SELECT * FROM insapp_notification ORDER BY create_date DESC LIMIT 3";
$result = $wpdb->get_results($sql );
// var_dump($result);
?>

<?php
    // $dashboard_page = get_option('insapp_settings_name')['Dashboard_page'];   
?>
<div class="insapp_dashboard_wrap">
    <div class="insapp_dashboard_sidebar">
        <div id="insapp_navigation"></div>
        <div class="insapp-simplebar-content justify-content-center" style="padding: 30px 15px;">
            <!-- Brand logo -->
            <!-- <a class="insapp-navbar-brand d-flex justify-content-center " href="">
                <?php 
                    $custom_logo_id = get_theme_mod( 'custom_logo' );
                    $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                    
                    if ( has_custom_logo() ) {  ?>
                        <img src="<?php // echo esc_url( $logo[0] );?>" style="width: 150px;" alt="<?php// get_bloginfo( 'name' );?>">
           
                    <?php } else {
                          //   echo '<h3 class="text-white">' .get_bloginfo('name') . '</h3>';
                 
                    }
                ?>
               </a> -->
            <!-- Navbar nav -->
            <ul class="navbar-nav flex-column" id="sideNavbar">

                <!-- Nav item -->
                <?php if(in_array($role,array('administrator','insapp_photographe'))){ ?>
                <li class="nav-item ins_dashbord_menu" id="tab1" data-tab="1">
                    <a class="nav-link has-arrow ins_active" href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home nav-icon me-2 icon-xxs">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        <?php _e('Tableau de bord','instant_Appointement') ?>
                    </a>
                </li>
                    <?php }?>
                <!-- Nav item -->
                <li class="nav-item">
                    <div class="navbar-heading">
                        <?php _e('Principal');?>
                    </div>
                </li>
                <?php if(in_array($role,array('administrator','insapp_photographe'))){ ?>
                <li class="nav-item ins_dashbord_menu" id="tab5" data-tab="5">
                    <a class="nav-link has-arrow collapsed " href="#!" data-bs-toggle="collapse"
                        data-bs-target="#navinvoice" aria-expanded="false" aria-controls="navinvoice">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-clipboard nav-icon me-2 icon-xxs">
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                            <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                        </svg>
                        <?php _e('Reservations Client')?>
                    </a>

                </li>
                <li class="nav-item ins_dashbord_menu" id="tab6" data-tab="6">
                    <a class="nav-link has-arrow collapsed " href="" data-bs-toggle="collapse"
                        data-bs-target="#navecommerce" aria-expanded="false" aria-controls="navecommerce">
                        +
                        <?php _e('Ajouter une Annonce')?>
                    </a>

                </li> 
                <li class="nav-item ins_dashbord_menu" id="tab10" data-tab="10">
                    <!-- <a class="nav-link has-arrow collapsed " href="" data-bs-toggle="collapse"
                        data-bs-target="#navecommerce" aria-expanded="false" aria-controls="navecommerce">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-shopping-cart nav-icon me-2 icon-xxs">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        <?php _e('Modifier une annonce')?>
                    </a> -->

                </li>
                <li class="nav-item ins_dashbord_menu" id="tab8" data-tab="8">
                    <a class="nav-link has-arrow collapsed " href="" data-bs-toggle="collapse"
                        data-bs-target="#navecommerce" aria-expanded="false" aria-controls="navecommerce">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-shopping-cart nav-icon me-2 icon-xxs">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        <?php _e('Les Annonces')?>
                    </a>

                </li>
                <?php } ?>
               
                <li class="nav-item ins_dashbord_menu" id="tab2" data-tab="2">
                <a class="nav-link has-arrow " href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-calendar nav-icon me-2 icon-xxs">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <!-- <?php if(in_array($role,array('administrator','insapp_photographe'))){ ?>
                            <?php }else{?>
                               <?php _e('Mes reservations');?>
                         <?php   } ?>
                         -->
                        <?php _e('Mes reservations');?>
                    </a>
                </li>
                <!-- Nav item -->
                <li class="nav-item ins_dashbord_menu" id="tab3" data-tab="3">
                    <a class="nav-link has-arrow " href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-message-square nav-icon me-2 icon-xxs">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                        <?php _e('Chat');?>
                    </a>
                </li>
                <li class="nav-item ins_dashbord_menu" id="tab4" data-tab="4">
                    <a class="nav-link has-arrow " href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-pie-chart nav-icon me-2 icon-xxs">
                            <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                            <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                        </svg>
                        <?php _e('Paiement');?>
                    </a>
                </li>

                <!-- Nav item -->
                <!-- Nav item -->
                <li class="nav-item">
                    <div class="navbar-heading">
                        <?php _e('Compte')?>
                    </div>
                </li>
                <!-- Nav item -->
                <?php if(in_array($role,array('administrator','insapp_photographe'))){ ?>
                <li class="nav-item ins_dashbord_menu" id="tab9" data-tab="9">
                    <a class="nav-link has-arrow " href="javascript:void(0)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar nav-icon me-2 icon-xxs"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        <?php
                            _e('Agenda');
                        ?>
                    </a>
                </li>
                <li class="nav-item ins_dashbord_menu" id="tab11" data-tab="11">
                    <a class="nav-link has-arrow " href="javascript:void(0)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package nav-icon me-2 icon-xxs"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        <?php
                            _e('Abonnement');
                        ?>
                    </a>
                </li>
                <?php   } ?>
                <li class="nav-item ins_dashbord_menu" id="tab7" data-tab="7">
                    <a class="nav-link has-arrow " href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-user nav-icon me-2 icon-xxs">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <?php _e('Profil')?>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link has-arrow " href="<?php echo wp_logout_url( get_permalink() ); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-lock nav-icon me-2 icon-xxs">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <?php _e('Déconnexion')?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="insapp_dashboard_content">

        <div class="insappp_content_page">

            <!-- <header class="insapp_content_hearder">
                <div class="navbar-custom navbar navbar-expand-lg">
                    <div class="container-fluid px-5">

                        <div class="d-none d-md-none d-lg-block">
                
                            <form action="#">

                                <div class="input-group ">
                                    <input class="form-control rounded-3" type="search" value="" id="searchInput"
                                        placeholder="Rechercher">
                                    <span class="input-group-append">
                                        <button class="btn  ms-n10 rounded-0 rounded-end" type="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-search text-dark">
                                                <circle cx="11" cy="11" r="8"></circle>
                                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                            </svg>
                                        </button>
                                    </span>
                                </div>
                            </form>
                        </div>
                        <div class="d-flex flex-row align-items-center">
                            <div class="dropdown stopevent ms-2 px-3">
                                <a class=" " href="#!" role="button"
                                    id="dropdownNotification" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-bell insapp_notif_icons">
                                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                    </svg>
                                </a>
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end"
                                    aria-labelledby="dropdownNotification">
                                    <div>
                                        <div  class="border-bottom px-3 pt-2 pb-3 d-flex justify-content-between align-items-center bg-light">
                                            <p class="mb-0 text-dark fw-medium fs-4">
                                                <?php _e('Notifications') ;?>
                                            </p>
                                            <a href="#!" class="text-muted">
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                                        viewBox="0 0 100 100" fill="grey" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-settings me-1 icon-xs">
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                        <path
                                                            d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                                        </path>
                                                    </svg>
                                                </span>
                                            </a>
                                        </div>
                                        <div data-simplebar="init" style="height: auto;">
                                            <div class="simplebar-wrapper" style="margin: 0px;">
                                                <div class="simplebar-height-auto-observer-wrapper">
                                                    <div class="simplebar-height-auto-observer"></div>
                                                </div>
                                                <div class="simplebar-mask">
                                                    <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                                        <div class="simplebar-content-wrapper" tabindex="0"
                                                            role="region" aria-label="scrollable content"
                                                            style="height: auto; overflow: hidden;">
                                                            <div class="simplebar-content" style="padding: 0px;">
                                                           
                                                                <ul class="list-group list-group-flush notification-list-scroll">
                                                                   
                                                                    <?php foreach ($result as $key => $elt) { ?>
                                                                    <li class="list-group-item">
                                                                        <a href="#!" class="text-muted">
                                                                            <h6 class=" mb-1">
                                                                                <?php// echo $elt->title ;?>
                                                                            </h6>
                                                                            <span class="mb-0 me-5 fs-6 col-12">
                                                                                <?php// echo $elt->msg; ?>
                                                                            </span>
                                                                            <span class="mb-0 ms-5 fs-6 col-12">
                                                                                <?php// echo $elt->create_date; ?>
                                                                            </span>
                                                                        </a>
                                                                    </li>
                                                                    <hr />
                                                                    <?php } ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="simplebar-placeholder" style="width: 0px; height: 0px;">
                                                </div>
                                            </div>
                                            <div class="simplebar-track simplebar-horizontal"
                                                style="visibility: hidden;">
                                                <div class="simplebar-scrollbar" style="width: 0px; display: none;">
                                                </div>
                                            </div>
                                            <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                                                <div class="simplebar-scrollbar" style="height: 0px; display: none;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="border-top px-3 py-2 text-center">
                                            <a href="#!" class="text-inherit ">
                                                <?php //_e('Voir toutes les notifications')?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="avatar avatar-md avatar-indicators avatar-online">
                                <?php 
                                $profile_photo_url = get_user_meta($current_user->ID, 'wp_user_avatar', true);

                                if ($profile_photo_url) {
                                    $user_img = $profile_photo_url;
                                  } else {
                                    // Display a default avatar image if the user does not have a profile photo
                                    $user_img = " TLPLUGIN_DEFAULT. '/avatar-fallback.jpg'";
                                  }
                                 ?>
                                <img alt="avatar" src="<?php // echo $user_img ;?>"
                                    class="rounded-circle">
                                    
                            </div>
                            <div class="px-4 pb-0 pt-2">
                                <div class="lh-1 ">
                                    <h5 class="">
                                        <?php //esc_attr_e($current_user->display_name);
                                        ?>
                                    </h5>
                                    <a href="javascript:void(0)" id="tab7" data-tab="7"
                                        class="text-inherit fs-6 ins_dashbord_menu">
                                        <?php //_e('Voir mon profil'); ?>
                                    </a>
                                </div>
                                <input type="hidden" class="insapp_user" value="<?php //esc_attr_e($current_user->ID) ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </header> -->

            <main class="insapp_content_main">

                <div class="insapp_content_dashbord" id="insapp_tab1">
                    <?php
                            $insapp_templates = new Insapp_Template_Loader;
                            $insapp_templates->get_template_part( 'dashboard/index' );
                        ?>
                </div>
                <div class="insapp_content_dashbord" id="insapp_tab2">
                    <?php
                            $insapp_templates = new Insapp_Template_Loader;
                            $insapp_templates->get_template_part( 'dashboard/my_booking' );
                        ?>
                </div>
                <div class="insapp_content_dashbord" id="insapp_tab3">
                    <?php
                            $insapp_templates = new Insapp_Template_Loader;
                            $insapp_templates->get_template_part( 'dashboard/chat' );
                        ?>
                </div>
                <div class="insapp_content_dashbord" id="insapp_tab4">
                    <?php
                            $insapp_templates = new Insapp_Template_Loader;
                            $insapp_templates->get_template_part( 'dashboard/payment' );
                        ?>
                </div>
                <div class="insapp_content_dashbord" id="insapp_tab5">
                    <?php
                            $insapp_templates = new Insapp_Template_Loader;
                            $insapp_templates->get_template_part( 'dashboard/booking' );
                        ?>
                </div>
                <div class="insapp_content_dashbord" id="insapp_tab6">
                    <?php
                            $insapp_templates = new Insapp_Template_Loader;
                            $insapp_templates->get_template_part( 'dashboard/services' );
                        ?>
                </div>
                <div class="insapp_content_dashbord" id="insapp_tab7">
                    <?php
                            $insapp_templates = new Insapp_Template_Loader;
                            $insapp_templates->get_template_part( 'dashboard/profil' );
                        ?>
                </div>
                <div class="insapp_content_dashbord" id="insapp_tab8">
                    <?php
                            $insapp_templates = new Insapp_Template_Loader;
                            $insapp_templates->get_template_part( 'dashboard/liste_service' );
                        ?>
                </div>
                <div class="insapp_content_dashbord" id="insapp_tab9">
                    <?php
                            $insapp_templates = new Insapp_Template_Loader;
                            $insapp_templates->get_template_part( 'dashboard/agenda' );
                        ?>
                </div>
                <div class="insapp_content_dashbord" id="insapp_tab10">
                    <?php
                            $insapp_templates = new Insapp_Template_Loader;
                            $insapp_templates->get_template_part( 'dashboard/update_service' );
                        ?>
                </div> 
                <div class="insapp_content_dashbord" id="insapp_tab11">
                    <?php
                            $insapp_templates = new Insapp_Template_Loader;
                            $insapp_templates->get_template_part( 'dashboard/pricing' );
                        ?>
                </div>



            </main>
        </div>
    </div>

</div>

<?php
function disable_comments_on_specific_page($page_id) {
    // Vérifier si l'ID de la page est valide
    if (!$page_id || !is_numeric($page_id)) {
        return;
    }

    // Récupérer les informations de la page par son ID
    $page = get_post($page_id);

    if ($page) {
        // Mettre à jour les paramètres de la page pour désactiver les commentaires
        $updated_page = array(
            'ID' => $page_id,
            'comment_status' => 'closed', // Désactiver les commentaires sur cette page
        );

        // Mettre à jour la page avec les nouveaux paramètres
        wp_update_post($updated_page);
    }
}
// var_dump(get_the_title());
// Utilisation : Appelez cette fonction en spécifiant l'ID de la page sur laquelle vous souhaitez désactiver les commentaires.
$page_id_to_disable_comments = get_the_id(); // Remplacez 123 par l'ID de la page sur laquelle vous souhaitez désactiver les commentaires.
disable_comments_on_specific_page($page_id_to_disable_comments);
?>