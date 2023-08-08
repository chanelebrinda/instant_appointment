<?php
add_action( 'wp_ajax_add_employees_ajax', 'insapp_add_employees' );
function insapp_add_employees() {

    $nom = sanitize_text_field( $_POST['nom']);
    $prenom = sanitize_text_field($_POST['prenom']);
    $tel = sanitize_text_field($_POST['telephone']);
    $email = sanitize_email($_POST['email']);
    $sexe = sanitize_text_field($_POST['sexe']);
    $password = sanitize_text_field($_POST['password']);
    $birthday = sanitize_text_field($_POST['birthday']);
    $langue = sanitize_text_field($_POST['langue']);
    $deb_heure = sanitize_text_field($_POST['deb_heure']);
    $fin_heure = sanitize_text_field($_POST['fin_heure']);
    $profil_image = sanitize_url($_POST['profil_image']);
    $work_days = sanitize_text_field($_POST['work_days']);
    $special_days = sanitize_text_field($_POST['special_days']);

    if(isset($nom) && isset($email)){

        $array_result = array(
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'password' => $password,
            'langue' => $langue,
            'sexe' => $sexe,
            'tel' => $tel,
            'birthday' => $birthday,
            'deb_heure' => $deb_heure,
            'fin_heure' => $fin_heure,
            'work_days' => $work_days,
            'special_days' => $special_days,
        );
        $meta = array(
            'sexe' => $sexe,
            'telephone' => $tel,
            'birthday' => $birthday,
            'deb_heure' => $deb_heure,
            'fin_heure' => $fin_heure,
            'first_nom'	=> $nom, 
            'last_nom'	=> $prenom,
            'work_days' => $work_days,
            'special_days' => $special_days,
        );
       

        $userdata = array(
            'user_pass'				=> $password,
            'user_login'            => $prenom.' '.$nom,
            'user_email' 			=> $email, 
            'user_url'              => $profil_image,
            'user_registered' 		=> '', 	
            'role' 					=> 'insapp_employees',
            'locale' 				=> $langue, 
            'meta_input'            =>$meta,
        );
       $user_id = wp_insert_user( $userdata ) ;

        if ( ! is_wp_error( $user_id ) ) {
            $resp = array(
                'code' => 200,
                'message' => "L'employé a bien ete créé!"
            );
        }else{
            $resp = array(
            'code' => 400,
	        'message' => $user_id->get_error_messages(),
            );
        }
    }else{
        $resp = array(
            'code' => 404,
	        'message' => "Une erreur est survenue veuillez contactez l'administrateur",
        );
    }

    // Make your array as json
	wp_send_json($resp);

}


/************************************************************
***********            Update                  **************
************************************************************/

add_action( 'wp_ajax_update_employees_ajax', 'insapp_update_employees_ajax' );
function insapp_update_employees_ajax() {
    $id = $_POST['employe_id'];
    $user = get_user_by('ID', $id);
    $deb_heure = get_user_meta($user->ID, 'deb_heure', true);
    $fin_heure = get_user_meta($user->ID, 'fin_heure', true);
    $work_days = get_user_meta($user->ID, 'work_days', true);
    $special_days = get_user_meta($user->ID, 'special_days', true);
    $telephone = get_user_meta($user->ID, 'telephone', true);
    $sexe = get_user_meta($user->ID, 'sexe', true);
    $nom = get_user_meta($user->ID, 'first_nom', true);
    $prenom = get_user_meta($user->ID, 'last_nom', true);
    $email = $user->user_email;
    $profil = $user->user_url;
    $langue = get_user_locale($user->ID, 'locale', true);
    $birthday = get_user_meta($user->ID, 'birthday', true);

        $array_result = array(
            'id' => $id,
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'profil' => $profil,
            'langue' => $langue,
            'sexe' => $sexe,
            'tel' => $telephone,
            'birthday' => $birthday,
            'deb_heure' => $deb_heure,
            'fin_heure' => $fin_heure,
            'work_days' => json_decode($work_days),
            'special_days' =>json_decode($special_days) ,
        );


	wp_send_json($array_result);
}

add_action( 'wp_ajax_save_update_employees_ajax', 'insapp_save_update_employees' );
function insapp_save_update_employees() {
    $id = sanitize_text_field( $_POST['id']);
    $nom = sanitize_text_field( $_POST['nom']);
    $prenom = sanitize_text_field($_POST['prenom']);
    $tel = sanitize_text_field($_POST['telephone']);
    $email = sanitize_email($_POST['email']);
    $sexe = sanitize_text_field($_POST['sexe']);
    $password = sanitize_text_field($_POST['password']);
    $birthday = sanitize_text_field($_POST['birthday']);
    $langue = sanitize_text_field($_POST['langue']);
    $profil_image = sanitize_url($_POST['profil_image']);
    if(isset($nom) && isset($email)){

        $array_result = array(
            'id' => $id,
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'password' => $password,
            'langue' => $langue,
            'sexe' => $sexe,
            'tel' => $tel,
            'birthday' => $birthday,
        );
        $meta = array(
            'sexe' => $sexe,
            'telephone' => $tel,
            'birthday' => $birthday,
            'first_nom'	=> $nom, 
            'last_nom'	=> $prenom,
        );
       

        $userdata = array(
            'ID'                    => $id,
            'user_pass'				=> $password,
            'user_login'            => $prenom.' '.$nom,
            'user_email' 			=> $email, 
            'user_url'              => $profil_image,
            'user_registered' 		=> '', 	
            'role' 					=> 'insapp_employees',
            'locale' 				=> $langue, 
            'meta_input'            =>$meta,
        );
       $user_id = wp_update_user( $userdata ) ;

        if ( ! is_wp_error( $user_id ) ) {
            $resp = array(
                'code' => 200,
                'message' => "Employé a bien été enregistré!"
            );
        }else{
            $resp = array(
            'code' => 400,
	        'message' => $user_id->get_error_messages(),
            );
        }
    }else{
        $resp = array(
            'code' => 404,
	        'message' => "Une erreur est survenue veuillez contactez l'administrateur",
        );
    }

    
	wp_send_json($resp);

}



add_action( 'wp_ajax_delete_employees_ajax', 'insapp_delete_employees_ajax' );
function insapp_delete_employees_ajax() {


    $id = $_POST['employe_id'];
    $status = wp_delete_user($id);
    if($status) {
            $resp = array(
                'code' => 200,
                'message' => 'Employé supprime avec succes!'
            );
        }else{
            $resp = array(
            'code' => 400,
	        'message' => $user_id->get_error_messages(),
            );
        }

	wp_send_json($resp);

}
