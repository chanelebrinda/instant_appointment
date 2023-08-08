<?php
function insapp_list_page_templates() {
  $templates = array(); 
  // Template Name 
  $templates = [
        // 'listing.php' =>'ia_Dashboard_listing',
        'listing.php' =>'ia_Dashboard_listing',
        'account/login.php'=> 'ia_user_login',
        'account/register.php' => 'ia_My chanele Page Template',
      ];

  return $templates;
}

// register custom page template
add_filter( 'theme_page_templates', 'insapp_add_custom_page_template' );
function insapp_add_custom_page_template( $page_templates ) {

       $page_templates = insapp_list_page_templates();

       foreach ($page_templates as $file => $name){
          $page_templates;
       }

     return $page_templates;
}

// page template content
// add_action( 'template_include', 'insapp_custom_page_template' );
// function insapp_custom_page_template( $template ) {
//   global $post;

//     $page_template = get_page_template_slug( $post );

//     if ( ! $page_template ) {
//       return $template;
//     }

//     //  $listTemplate = insapp_list_page_templates();
//     //   echo  $listTemplate[$page_template];
//     // if ( is_page_template( $listTemplate[$page_template] ) ) {

//         $template = TLPLUGIN_DIR . '/templates/front-end/' .$page_template;

//     // }

//     return $template;
// }
// echo 'Instant Appointment';