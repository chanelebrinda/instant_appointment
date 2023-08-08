<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class IA_Menu_Appointment_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'ia-menu-appointment';
    }

    public function get_title() {
        return __('IA Menu Appointment', 'instant_Appointement');
    }

    public function get_icon() {
        return 'eicon-menu-bar';
    }

    public function get_categories() {
        return ['header'];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'instant_Appointement'),
            ]
        );

        $this->end_controls_section();
       
    }

    protected function render() {
        $dashboard_page = get_option('insapp_settings_name')['Dashboard_page']; 
        $auth_page = get_option('insapp_settings_name')['Login_page']; 
        $profile_photo_url = get_user_meta($current_user->ID, 'wp_user_avatar', true);

        if ($profile_photo_url) {
            $user_img = $profile_photo_url;
        } else {
            $user_img = TLPLUGIN_DEFAULT. '/avatar-fallback.jpg';
        }
        $current_user = wp_get_current_user();
        $roles = $current_user->roles;
        $role = array_shift( $roles );  
       ?>
       <div class="ia_menu_widget_container">

            <?php 
                    if(is_user_logged_in(  )){ ?>
                            <a class="drop-dow" href="javascript:void(0);">
                                <div class="infor-account d-flex align-items-center">
                                    <div class="avatar-wrapper">
                                        <img alt="" src="<?php  echo $user_img ?>" srcset="<?php  echo $user_img ?>" class="avatar avatar-54 photo" height="54" width="54" loading="lazy" decoding="async">                        </div>
                                    <div class="name-acount">admin <i class="fas fa-chevron-down"></i></div>
                                </div>
                            </a>
                            <div class="ia_menu_widget_content">
                                <ul id="menu-dashboard" class="nav navbar-nav ia_menu_widget_menu"> 
                                <?php if(in_array($role,array('administrator','insapp_photographe'))){ ?>
               
                                    <li id="ia-menu-bord" onclick="localStorage.setItem('jstabs-opentab', 1)" class="dropdown-item"><a href="<?php if( $dashboard_page ) {echo esc_url(get_permalink(get_option('insapp_settings_name')['Dashboard_page']));} ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M448 64H64a64 64 0 0 0-64 64v256a64 64 0 0 0 64 64h384a64 64 0 0 0 64-64V128a64 64 0 0 0-64-64zM160 368H80a16 16 0 0 1-16-16v-16a16 16 0 0 1 16-16h80zm128-16a16 16 0 0 1-16 16h-80v-48h80a16 16 0 0 1 16 16zm160-128a32 32 0 0 1-32 32H96a32 32 0 0 1-32-32v-64a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32z"/></svg>
                                          Tableau de bord</a></li>
                                    <li id="ia-menu-annonce"  onclick="localStorage.setItem('jstabs-opentab', 8)"  class="dropdown-item"><a href="<?php if( $dashboard_page ) {echo esc_url(get_permalink(get_option('insapp_settings_name')['Dashboard_page']));} ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart nav-icon me-2 icon-xxs"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                       Mes annonces</a></li>
                                <?php } ?>
                                
                                   <li id="ia-menu-rdv"  onclick="localStorage.setItem('jstabs-opentab', 2)"  class="dropdown-item"><a href="<?php if( $dashboard_page ) {echo esc_url(get_permalink(get_option('insapp_settings_name')['Dashboard_page']));} ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M80 368H16a16 16 0 0 0-16 16v64a16 16 0 0 0 16 16h64a16 16 0 0 0 16-16v-64a16 16 0 0 0-16-16zm0-320H16A16 16 0 0 0 0 64v64a16 16 0 0 0 16 16h64a16 16 0 0 0 16-16V64a16 16 0 0 0-16-16zm0 160H16a16 16 0 0 0-16 16v64a16 16 0 0 0 16 16h64a16 16 0 0 0 16-16v-64a16 16 0 0 0-16-16zm416 176H176a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h320a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-320H176a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h320a16 16 0 0 0 16-16V80a16 16 0 0 0-16-16zm0 160H176a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h320a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16z"/></svg>
                                      Mes rendez-vous</a></li>
                                    <li id="ia-menu-sms"  onclick="localStorage.setItem('jstabs-opentab', 3)"  class="dropdown-item"><a href="<?php if( $dashboard_page ) {echo esc_url(get_permalink(get_option('insapp_settings_name')['Dashboard_page']));} ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M448 0H64C28.7 0 0 28.7 0 64v288c0 35.3 28.7 64 64 64h96v84c0 7.1 5.8 12 12 12 2.4 0 4.9-.7 7.1-2.4L304 416h144c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64zm16 352c0 8.8-7.2 16-16 16H288l-12.8 9.6L208 428v-60H64c-8.8 0-16-7.2-16-16V64c0-8.8 7.2-16 16-16h384c8.8 0 16 7.2 16 16v288z"/></svg>
                                        Messages</a>
                                    </li>
                                    <li id="ia-menu-profil"  onclick="localStorage.setItem('jstabs-opentab', 7)"  class="dropdown-item"><a href="<?php if( $dashboard_page ) {echo esc_url(get_permalink(get_option('insapp_settings_name')['Dashboard_page']));} ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path d="M313.6 304c-28.7 0-42.5 16-89.6 16-47.1 0-60.8-16-89.6-16C60.2 304 0 364.2 0 438.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-25.6c0-74.2-60.2-134.4-134.4-134.4zM400 464H48v-25.6c0-47.6 38.8-86.4 86.4-86.4 14.6 0 38.3 16 89.6 16 51.7 0 74.9-16 89.6-16 47.6 0 86.4 38.8 86.4 86.4V464zM224 288c79.5 0 144-64.5 144-144S303.5 0 224 0 80 64.5 80 144s64.5 144 144 144zm0-240c52.9 0 96 43.1 96 96s-43.1 96-96 96-96-43.1-96-96 43.1-96 96-96z"/></svg>
                                        Profile
                                        </a>
                                    </li>
                                    <li class="dropdown-item"><a href="<?php echo esc_url(get_permalink($auth_page)); ?>">
                                       <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M497 273L329 441c-15 15-41 4.5-41-17v-96H152c-13.3 0-24-10.7-24-24v-96c0-13.3 10.7-24 24-24h136V88c0-21.4 25.9-32 41-17l168 168c9.3 9.4 9.3 24.6 0 34zM192 436v-40c0-6.6-5.4-12-12-12H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h84c6.6 0 12-5.4 12-12V76c0-6.6-5.4-12-12-12H96c-53 0-96 43-96 96v192c0 53 43 96 96 96h84c6.6 0 12-5.4 12-12z"/></svg>
                                      Deconnexion</a>
                                    </li>

                                </ul>
                            </div>            
     
                <?php
            }else{
            
                if( $auth_page ) {?>
                    <a class="ia_btn_login" href="<?php echo esc_url(get_permalink($auth_page)); ?>" title="Login/Sign Up">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512" style="fill:#222222"><style></style><path d="M313.6 304c-28.7 0-42.5 16-89.6 16-47.1 0-60.8-16-89.6-16C60.2 304 0 364.2 0 438.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-25.6c0-74.2-60.2-134.4-134.4-134.4zM400 464H48v-25.6c0-47.6 38.8-86.4 86.4-86.4 14.6 0 38.3 16 89.6 16 51.7 0 74.9-16 89.6-16 47.6 0 86.4 38.8 86.4 86.4V464zM224 288c79.5 0 144-64.5 144-144S303.5 0 224 0 80 64.5 80 144s64.5 144 144 144zm0-240c52.9 0 96 43.1 96 96s-43.1 96-96 96-96-43.1-96-96 43.1-96 96-96z"/></svg>
                       Connexion/Inscription                    
                    </a>
                <?php
                }
            }
             ?>  
       </div> <?php 
    }
}

 

add_action( 'elementor/widgets/widgets_registered', function() {
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new IA_Menu_Appointment_Widget() );
} );

class IA_Menu_Appointment_Widget_white extends \Elementor\Widget_Base {

    public function get_name() {
        return 'ia-menu-appointment_white';
    }

    public function get_title() {
        return __('IA Menu Appointment White', 'instant_Appointement');
    }

    public function get_icon() {
        return 'eicon-menu-bar';
    }

    public function get_categories() {
        return ['header'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'instant_Appointement'),
            ]
        );

        $this->end_controls_section();
       
    }

    protected function render() {
        $dashboard_page = get_option('insapp_settings_name')['Dashboard_page']; 
        $auth_page = get_option('insapp_settings_name')['Login_page']; 
        $profile_photo_url = get_user_meta($current_user->ID, 'wp_user_avatar', true);

        if ($profile_photo_url) {
            $user_img = $profile_photo_url;
        } else {
            $user_img = TLPLUGIN_DEFAULT. '/avatar-fallback.jpg';
        }
        $current_user = wp_get_current_user();
            $roles = $current_user->roles;
            $role = array_shift( $roles );  
       ?>
       <div class="ia_menu_widget_container">

            <?php 
            if(is_user_logged_in(  )){
                
                 ?>
            
                            <a class="drop-dow" href="javascript:void(0);">
                                <div class="infor-account d-flex align-items-center">
                                    <div class="avatar-wrapper">
                                        <img alt="" src="<?php  echo $user_img ?>" srcset="<?php  echo $user_img ?>" class="avatar avatar-54 photo" height="54" width="54" loading="lazy" decoding="async">                        </div>
                                    <div class="name-acount">admin <i class="fas fa-chevron-down"></i></div>
                                </div>
                            </a>
                            <div class="ia_menu_widget_content">
                                <ul id="menu-dashboard" class="nav navbar-nav ia_menu_widget_menu"> 
                                <?php if(in_array($role,array('administrator','insapp_photographe'))){ ?>
               
                                    <li id="ia-menu-bord" onclick="localStorage.setItem('jstabs-opentab', 1)" class="dropdown-item"><a href="<?php if( $dashboard_page ) {echo esc_url(get_permalink(get_option('insapp_settings_name')['Dashboard_page']));} ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M448 64H64a64 64 0 0 0-64 64v256a64 64 0 0 0 64 64h384a64 64 0 0 0 64-64V128a64 64 0 0 0-64-64zM160 368H80a16 16 0 0 1-16-16v-16a16 16 0 0 1 16-16h80zm128-16a16 16 0 0 1-16 16h-80v-48h80a16 16 0 0 1 16 16zm160-128a32 32 0 0 1-32 32H96a32 32 0 0 1-32-32v-64a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32z"/></svg>
                                          Tableau de bord</a></li>
                                    <li id="ia-menu-annonce"  onclick="localStorage.setItem('jstabs-opentab', 8)"  class="dropdown-item"><a href="<?php if( $dashboard_page ) {echo esc_url(get_permalink(get_option('insapp_settings_name')['Dashboard_page']));} ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart nav-icon me-2 icon-xxs"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                       Mes annonces</a></li>
                                <?php } ?>
                                
                                   <li id="ia-menu-rdv"  onclick="localStorage.setItem('jstabs-opentab', 2)"  class="dropdown-item"><a href="<?php if( $dashboard_page ) {echo esc_url(get_permalink(get_option('insapp_settings_name')['Dashboard_page']));} ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M80 368H16a16 16 0 0 0-16 16v64a16 16 0 0 0 16 16h64a16 16 0 0 0 16-16v-64a16 16 0 0 0-16-16zm0-320H16A16 16 0 0 0 0 64v64a16 16 0 0 0 16 16h64a16 16 0 0 0 16-16V64a16 16 0 0 0-16-16zm0 160H16a16 16 0 0 0-16 16v64a16 16 0 0 0 16 16h64a16 16 0 0 0 16-16v-64a16 16 0 0 0-16-16zm416 176H176a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h320a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-320H176a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h320a16 16 0 0 0 16-16V80a16 16 0 0 0-16-16zm0 160H176a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h320a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16z"/></svg>
                                      Mes rendez-vous</a></li>
                                    <li id="ia-menu-sms"  onclick="localStorage.setItem('jstabs-opentab', 3)"  class="dropdown-item"><a href="<?php if( $dashboard_page ) {echo esc_url(get_permalink(get_option('insapp_settings_name')['Dashboard_page']));} ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M448 0H64C28.7 0 0 28.7 0 64v288c0 35.3 28.7 64 64 64h96v84c0 7.1 5.8 12 12 12 2.4 0 4.9-.7 7.1-2.4L304 416h144c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64zm16 352c0 8.8-7.2 16-16 16H288l-12.8 9.6L208 428v-60H64c-8.8 0-16-7.2-16-16V64c0-8.8 7.2-16 16-16h384c8.8 0 16 7.2 16 16v288z"/></svg>
                                        Messages</a>
                                    </li>
                                    <li id="ia-menu-profil"  onclick="localStorage.setItem('jstabs-opentab', 7)"  class="dropdown-item"><a href="<?php if( $dashboard_page ) {echo esc_url(get_permalink(get_option('insapp_settings_name')['Dashboard_page']));} ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path d="M313.6 304c-28.7 0-42.5 16-89.6 16-47.1 0-60.8-16-89.6-16C60.2 304 0 364.2 0 438.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-25.6c0-74.2-60.2-134.4-134.4-134.4zM400 464H48v-25.6c0-47.6 38.8-86.4 86.4-86.4 14.6 0 38.3 16 89.6 16 51.7 0 74.9-16 89.6-16 47.6 0 86.4 38.8 86.4 86.4V464zM224 288c79.5 0 144-64.5 144-144S303.5 0 224 0 80 64.5 80 144s64.5 144 144 144zm0-240c52.9 0 96 43.1 96 96s-43.1 96-96 96-96-43.1-96-96 43.1-96 96-96z"/></svg>
                                        Profile
                                        </a>
                                    </li>
                                    <li class="dropdown-item"><a href="<?php echo esc_url(get_permalink($auth_page)); ?>">
                                       <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M497 273L329 441c-15 15-41 4.5-41-17v-96H152c-13.3 0-24-10.7-24-24v-96c0-13.3 10.7-24 24-24h136V88c0-21.4 25.9-32 41-17l168 168c9.3 9.4 9.3 24.6 0 34zM192 436v-40c0-6.6-5.4-12-12-12H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h84c6.6 0 12-5.4 12-12V76c0-6.6-5.4-12-12-12H96c-53 0-96 43-96 96v192c0 53 43 96 96 96h84c6.6 0 12-5.4 12-12z"/></svg>
                                      Deconnexion</a>
                                    </li>

                                </ul>
                            </div>             
     
                <?php
            }else{
            
                if( $auth_page ) {?>
                    <a class="ia_btn_login_white" href="<?php echo esc_url(get_permalink($auth_page)); ?>" title="Login/Sign Up">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512" style="fill:#ffffff"> <path d="M313.6 304c-28.7 0-42.5 16-89.6 16-47.1 0-60.8-16-89.6-16C60.2 304 0 364.2 0 438.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-25.6c0-74.2-60.2-134.4-134.4-134.4zM400 464H48v-25.6c0-47.6 38.8-86.4 86.4-86.4 14.6 0 38.3 16 89.6 16 51.7 0 74.9-16 89.6-16 47.6 0 86.4 38.8 86.4 86.4V464zM224 288c79.5 0 144-64.5 144-144S303.5 0 224 0 80 64.5 80 144s64.5 144 144 144zm0-240c52.9 0 96 43.1 96 96s-43.1 96-96 96-96-43.1-96-96 43.1-96 96-96z"/></svg>  Connexion/Inscription                    
                    </a>
                <?php
                }
            }
             ?>  
       </div> <?php 
    }
}

 

add_action( 'elementor/widgets/widgets_registered', function() {
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new IA_Menu_Appointment_Widget_white() );
} );


class IA_Menu_Appointment_Widget_submit extends \Elementor\Widget_Base {

    public function get_name() {
        return 'ia-menu-appointment_submit';
    }

    public function get_title() {
        return __('IA Menu Appointment submit', 'instant_Appointement');
    }

    public function get_icon() {
        return 'eicon-menu-bar';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'instant_Appointement'),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'instant_Appointement'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Ajouter une annonce', 'instant_Appointement'),
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $dashboard_page = get_option('insapp_settings_name')['Dashboard_page']; 

        $settings = $this->get_settings_for_display();

        // Rendre le bouton
        ?>
 
        <a class="insapp_btn_action_widget" onclick="localStorage.setItem('jstabs-opentab', 6)" href="<?php if( $dashboard_page ) {echo esc_url(get_permalink(get_option('insapp_settings_name')['Dashboard_page']));} ?>" class="my-button">
            <?php echo esc_html($settings['button_text']); ?>
        </a>
        <?php
    }
}

 

add_action( 'elementor/widgets/widgets_registered', function() {
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new IA_Menu_Appointment_Widget_submit() );
} );
