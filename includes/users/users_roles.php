<?php


add_role(
    'insapp_employees', //  System name of the role.
    __( 'Employé'  ), // Display name of the role.
    array(
        'read'  => true,
        'delete_posts'  => true,
        'delete_published_posts' => true,
        'edit_posts'   => true,
        'publish_posts' => true,
        'upload_files'  => true,
        'edit_pages'  => true,
        'edit_published_pages'  =>  true,
        'publish_pages'  => true,
        'delete_published_pages' => true,
        'moderate_comments' => true,
        'manage_categories' => true,
        'manage_links' => true,
        'edit_others_posts' => true,
        'edit_others_pages' => true,
        'delete_pages' => true,
        'delete_others_pages' => true,
        'delete_others_posts' => true,
        'delete_private_posts' => true,
        'edit_private_posts' => true,
        'read_private_posts' => true,
        'delete_private_pages' => true,
        'edit_private_pages' => true,
        'read_private_pages' => true,
        'unfiltered_html' => true,
        'unfiltered_html' => true,
    )
);

add_role('insapp_customers', 'Client'  );

add_role('insapp_photographe', 'Photographe'  );

remove_role( 'eleve' );
remove_role( 'website_admin' );