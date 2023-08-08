<?php

add_action( 'wp_ajax_register_user_ajax','register_user_ajax_callback');
add_action( 'wp_ajax_nopriv_register_user_ajax','register_user_ajax_callback');
function register_user_ajax_callback(){
	
    $email = sanitize_email($_POST['email']);
	$nom = sanitize_text_field($_POST['nom']);
	$prenom = sanitize_text_field($_POST['prenom']);
	$user_name = $prenom.' '.$nom;

	if ( !$email ) {
		wp_send_json(
		   array(
			   'registered'=>false, 
			   'message'=> __('Please fill email address', 'instant_Appointement')
		   )
	   );
	   die();
   }		
    if ( !is_email($email)  ) {
 		wp_send_json(
        	array(
        		'registered'=>false, 
        		'message'=> __('This is not valid email address', 'instant_Appointement')
        	)
        );
        die();
    }
 	$user_login = sanitize_user(trim($_POST['nom'])); 
	$password = sanitize_text_field(trim($_POST['password']));
	
		if(empty($password)) {
			wp_send_json(
				array(
					'registered'=>false, 
					'message'=> esc_html__( 'Please provide password', 'instant_Appointement' )
				)
			);
			die();
		}  
	if(isset($_POST['role'])){
		$role = sanitize_text_field( $_POST['role'] );	
	} else {
		$role = 'insapp_customers';
	}
	if ( email_exists( $email ) ) { 
		wp_send_json(
        	array(
        		'registered'=>false, 
        		'message'=> __('Cette email existe déja', 'instant_Appointement')
        	)
        );
        die();
	}
	
	 $meta = array( 
            'telephone' => '',
            'adresse' => '',
        );

	$user_data = array(
	    'user_login'    => $user_name_.uniqid(rand(), true),
	    'user_email'    => $email,
	    'user_pass'     => $password,
	    'role'			=> $role,
		'first_name'    => $nom,
		'last_name'     => $prenom,
	    'meta_input'    => $meta,
	);

	 $user_id = wp_insert_user( $user_data );
 
	if (is_wp_error($user_id)){
		var_dump($user_id->get_error_messages());
		  wp_send_json(array('registered'=>false,'message'=> __('Une erreur c\'est produite veuillez réessayer', 'instant_Appointement')));
	} else {
		
	    wp_send_json(array('registered'=>true, 'message'=>esc_html__('You have been successfully registered, you will be logged in a moment.','instant_Appointement')));
	}
 
}

add_action( 'wp_ajax_login_user_ajax', 'login_user_ajax_callback' );
add_action( 'wp_ajax_nopriv_login_user_ajax', 'login_user_ajax_callback' );
function login_user_ajax_callback(){

	    // Nonce is checked, get the POST data and sign user on
	    $info = array(); 
		
	    $email = sanitize_email(trim($_POST['email']));
	    $info['user_password'] = sanitize_text_field(trim($_POST['password'])); 

		if ( !$email  ) {
 		wp_send_json(
        	array(
        		'loggedin'=>false, 
        		'message'=> __('Please fill email address', 'instant_Appointement')
        	)
        );
        
		}		
		if ( !is_email($email )  ) {
			wp_send_json(
				array(
					'loggedin'=>false, 
					'message'=> __('This is not valid email address', 'instant_Appointement')
				)
			); 
		}
	
	    if(empty($email )) {
	    	 wp_send_json(
	    	 	array(
	    	 		'loggedin'=>false, 
	    	 		'message'=> esc_html__( 'Please fill email address', 'instant_Appointement' )
	    	 	  )
				);
	     
	    } 
	    if(empty($info['user_password'])) {
	    	 wp_send_json( 
				array( 
					'loggedin'=>false,
			        'message'=> esc_html__( 'You need to enter a password to login.', 'instant_Appointement' )
				)
			);
	    	  
	    }

		$user = get_user_by( 'email' , $email) ; 
		$info['user_login'] = $user->user_login;   

		if(empty($info['user_login'])) {
	    	 wp_send_json( 
				array( 
					'loggedin'=>false,
			        'message'=> esc_html__( 'Wrong email , you don\'t have an account', 'instant_Appointement' )
				)
			);
	    	  
	    }

	    $user_signon = wp_signon( $info, is_ssl() );
	    if ( is_wp_error($user_signon) ){
	    	
	        wp_send_json(
	        	array(
	        		'loggedin'=>false, 
	        		'message'=>esc_html__('Wrong username or password.','instant_Appointement')
	        	)
	        );

	    } else {
	    	wp_clear_auth_cookie();
          //  do_action('wp_login', $user_signon->ID);
            wp_set_current_user($user_signon->ID);
            wp_set_auth_cookie($user_signon->ID, true);
	        wp_send_json(

	        	array(
	        		'loggedin'	=>	true, 
	        		'message'	=>	esc_html__('Login successful, redirecting...','instant_Appointement'),
	        	
	        	)

	        );

	    }
 
	}

	

add_action( 'wp_ajax_ia_get_user_account_ajax','ia_get_user_account_ajax_callback');
add_action( 'wp_ajax_nopriv_ia_get_user_account_ajax','ia_get_user_account_ajax_callback');
function ia_get_user_account_ajax_callback() {

	if(isset($_POST['user_id'])){

		
		$user_id = sanitize_text_field( $_POST['user_id']);
		$check = insapp_get_connect_account($user_id);

		if(empty($check)){
			
			$account_id = insapp_create_account_stripe();
			$account = $account_id->id;
			$test = insapp_add_connect_account( $user_id,$account);
			$link = insapp_get_link_account_stripe( $account);
			
		}else{
		
			$account = $check[0]->account_id;
			$link = insapp_get_link_account_stripe( $account);
		}	
			
		$resp = array(
			'code' => 200,
			'message' => $link, 
		);

	}else{

	$resp = array(
		'code' => 404,
		'message' => 'une erreur c\'est produite veuillez contacter l\'administrateur',
		);

	}

	wp_send_json($resp);
	
}

add_action( 'wp_ajax_update_user_profile_ajax','update_user_profile_ajax_callback');
add_action( 'wp_ajax_nopriv_update_user_profile_ajax','update_user_profile_ajax_callback');
function update_user_profile_ajax_callback() {

	if(isset($_POST['user_id'])){

		$user_id = sanitize_text_field( $_POST['user_id']);
		$nom = sanitize_text_field( $_POST['nom']);
		$prenom = sanitize_text_field($_POST['prenom']);
		$telephone = sanitize_text_field($_POST['telephone']);
		$email = sanitize_email($_POST['email']);
		$adresse = sanitize_text_field($_POST['adresse']);
		$filename = $_POST['image_name'];
		$image_url = $_POST['image_url'];

		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';

	

		$upload_dir = wp_upload_dir();
		$image_data = file_get_contents( $image_url );

		if ( wp_mkdir_p( $upload_dir['path'] ) ) {
		$file = $upload_dir['path'] . '/' . $filename;
		}
		else {
		$file = $upload_dir['basedir'] . '/' . $filename;
		}
		file_put_contents( $file, $image_data );
		$wp_filetype = wp_check_filetype( $filename, null );
		$attachment = array(
			'guid' => $upload_dir['url'] . '/' . $filename,
			'post_mime_type' => $wp_filetype['type'],
			'post_title' => sanitize_file_name( $filename ),
			'post_content' => '',
			'post_status' => 'inherit'
		);

		$attach_id = wp_insert_attachment( $attachment, $file);
		

			
			$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
			wp_update_attachment_metadata( $attach_id, $attach_data ); 
			$attachment_url = wp_get_attachment_url($attach_id);
		 
		update_user_meta($user_id, 'wp_user_avatar', $attachment_url);
		$meta = array( 
				'telephone' => $telephone,
				'adresse' => $adresse,
			);

			$user_data = array(
				'ID'            => $user_id,
				'user_login'    => $prenom.' '.$nom,
				'user_email'    => $email,  
				// 'user_url'      => $attachment_url,
				'first_name'    => $nom,
				'last_name'     => $prenom,
				'meta_input'    => $meta,
			);
            $user = wp_update_user( $user_data ) ;
	
			if ( is_int( $user ) ) {

				$resp = array(
					'code' => 200,
					'message' => "Modification réussi",
				);

			}else{
				$resp = array(
				'code' => 400,
				'message' => 'Une erreur c\'est produite veuillez réessayer',
				);
			}
	}else{

		$resp = array(
				'code' => 404,
				'message' => 'une erreur c\'est produite veuillez contacter l\'administrateur',
				);

	}

    
	wp_send_json($resp);

}

add_action( 'wp_ajax_update_user_password_ajax','update_user_password_ajax_callback');
add_action( 'wp_ajax_nopriv_update_user_password_ajax','update_user_password_ajax_callback');
function update_user_password_ajax_callback() {

	if(isset($_POST['user_id'])){

		$user_id = sanitize_text_field( $_POST['user_id']);
		$password = sanitize_text_field( $_POST['password']);
        wp_set_password( $password, $user_id );

		$resp = array(
			'code' => 200,
			'message' => "Modification réussi"
		);

	}else{
		$resp = array(
				'code' => 404,
				'message' => 'une erreur c\'est produite veuillez contacter l\'administrateur',
				);
	}
    
	wp_send_json($resp);

}

