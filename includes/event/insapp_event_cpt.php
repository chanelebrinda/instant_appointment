<?php

include(TLPLUGIN_DIR . 'includes/event/insapp_event_cf.php');// Register Custom Post Type
include(TLPLUGIN_DIR . 'includes/lieux/insapp_lieux_cf.php');// Register Custom Post Type

function insapp_post_type_Evenement() {

    $labels = array(
        'name'                  => ( 'Evenements' ),
        'singular_name'         => ( 'Evenement' ),
        'menu_name'             => ( 'Evenements' ),
        'name_admin_bar'        => ( 'Evenement' ),
        'archives'              => ( `Archives de l'evenement` ),
        'attributes'            => ( `Attributs de l'evenement` ),
        'parent_item_colon'     => ( 'Evenement parent' ),
        'all_items'             => ( 'Tous les evenements' ),
        'add_new_item'          => ( 'Ajouter un evenement' ),
        'add_new'               => ( 'Ajouter un evenement' ),
        'new_item'              => ( 'Nouvel evenement' ),
        'edit_item'             => ( `Modifier l'evenement` ),
        'update_item'           => ( `Mettre à jour l'evenement` ),
        'view_item'             => ( `Voir l'evenement` ),
        'view_items'            => ( 'Voir les evenements' ),
        'search_items'          => ( 'Chercher un evenement' ),
        'not_found'             => ( 'Aucun evenement trouvé' ),
        'not_found_in_trash'    => ( 'Aucun evenement trouvé dans la corbeille' ),
        'featured_image'        => ( 'Image mise en avant' ),
        'set_featured_image'    => ( "Définir l'image mise en avant" ),
        'remove_featured_image' => __( "Supprimer l'image mise en avant"),
        'use_featured_image'    => ( 'Utiliser comme image mise en avant' ),
        'insert_into_item'      => ( `Insérer dans l'evenement` ),
        'uploaded_to_this_item' => ( 'Téléversé sur cet evenement' ),
        'items_list'            => ( 'Liste des evenements' ),
        'items_list_navigation' => ( 'Navigation des evenements' ),
        'filter_items_list'     => ( 'Filtrer la liste des evenements' ),
    );
    $args = array(
        'label'                 => ( 'Evenement' ),
        'description'           => ( 'Tous les Evenements' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail' ),
        'taxonomies'            => array( 'lieux', date($format = '', $post = null) ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-admin-generic',
        // 'show_in_admin_bar'     => true,
        // 'show_in_nav_menus'     => true,
        // 'can_export'            => true,
        // 'has_archive'           => true,
        // 'exclude_from_search'   => false,
        // 'publicly_queryable'    => true,
        // 'capability_type'       => 'page',
    );
    register_post_type( 'evenement', $args );

}
add_action( 'init', 'insapp_post_type_Evenement', 0 );

// Register Custom Taxonomy
function insapp_taxonomy_lieux() {

    $labels = array(
        'name'                       => _x( 'Lieux', 'Taxonomy General Name' ),
        'singular_name'              => _x( 'Lieux', 'Taxonomy Singular Name' ),
        'menu_name'                  => ( 'Lieux' ),
        'all_items'                  => ( 'Tous les lieux' ),
        'parent_item'                => ( 'Lieu parent' ),
        'parent_item_colon'          => ( 'Lieu parent' ),
        'new_item_name'              => ( 'Nouveau lieu' ),
        'add_new_item'               => ( 'Ajouter un nouveau lieu' ),
        'edit_item'                  => ( 'Modifier le lieu' ),
        'update_item'                => ( 'Mettre à jour le Lieu' ),
        'view_item'                  => ( 'Voir le lieu' ),
        'separate_items_with_commas' => ( 'Séparer les lieux par des virgules' ),
        'add_or_remove_items'        => ( 'Ajouter ou supprimer des lieux' ),
        'choose_from_most_used'      => ( 'Choisir parmi les plus utilisés' ),
        'popular_items'              => ( 'Lieux populaires' ),
        'search_items'               => ( 'Chercher un lieu' ),
        'not_found'                  => ( 'Aucun lieu trouvé' ),
        'no_terms'                   => ( 'Aucun lieu' ),
        'items_list'                 => ( 'Liste des lieux' ),
        'items_list_navigation'      => ( 'Navigation des lieux' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => false,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_menu'          => true,
    );
    register_taxonomy( 'lieux', array( 'evenement' ), $args );

}
add_action( 'init', 'insapp_taxonomy_lieux', 0 );


?>