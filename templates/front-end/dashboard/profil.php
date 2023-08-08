<?php
$current_user = wp_get_current_user(); 
$user_info = get_userdata($current_user->ID); 
$meta = get_user_meta( $current_user->ID );
$first_name = $user_info->first_name;
$last_name = $user_info->last_name; 
$user_mail = $user_info->user_email;
$user_img = $user_info->user_url;
$user_phone = get_user_meta( $current_user->ID, 'telephone' , true );
$user_adresse = get_user_meta( $current_user->ID, 'adresse' , true );
$avatar_url = get_avatar_url( $current_user->ID );
$user_id = get_current_user_id(); 
$profile_photo_url = get_user_meta($user_id, 'wp_user_avatar', true);

if ($profile_photo_url) {
  $user_img = $profile_photo_url;
} else {
  // Display a default avatar image if the user does not have a profile photo
  $user_img =  TLPLUGIN_DEFAULT. '/avatar-fallback.jpg';
}

?>
<div class="container-fluid">

  <div class="row">
    <h3 class="text-dark mt-5">
      <?php _e('Mon Profil') ?>
    </h3>
  </div>

  <div class="row mt-5">
    <div class="col-12">

      <div class="card">
        <div class="insapp_notification_user_profil" style="text-align: center; margin-top: 30px;background-color: #ffcece;color: #f75555;font-weight: 600; justify-content: center;align-items: center;display: none; min-height: 50px;font-size: 14px;border-radius: 5px;">
        </div>

        <div class="card-body">
          <div class="mb-6">
            <h4 class="mb-1">
              <?php _e('Informations de base')?>
            </h4>
          </div>

          <form class="insapp_profile_form" action="">
            

            <div class="mb-3 row">
              <label for="email" class="col-sm-4 col-form-label
                              form-label">
                <?php _e('Photo de profil')?>
              </label>
              <div class="col-md-8 col-12">
                <div class="d-flex align-items-center mb-4">
                  <div>
                    <img class="image  avatar avatar-lg rounded-circle" id="user_pic"  src="<?php echo $user_img ?>" alt="Image">
                  </div>

                  <div class="file-upload btn btn-outline-white ms-4">
                    <input type="file" class="file-input opacity-0 " data_url="<?php _e($user_img) ?>" id="user_pic_input">
                    <?php _e('Choisir la photo')?>
                  </div>
                </div>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="fullName" class="col-sm-4 col-form-label
                              form-label">
                <?php _e('Nom et prénom')?>
              </label>
              <div class="col-sm-4 mb-3 mb-lg-0">
                <input type="text" class="form-control" placeholder="Prénom" value="<?php _e($last_name) ?>"
                  id="insapp_firstName" required="">
              </div>
              <div class="col-sm-4">
                <input type="text" class="form-control" placeholder="Nom" value="<?php _e($first_name) ?>"
                  id="insapp_lastName" required="">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="email" class="col-sm-4 col-form-label
                              form-label">
                <?php _e('E-mail')?>
              </label>
              <div class="col-md-8 col-12">
                <input type="email" class="form-control" placeholder="E-mail" value="<?php _e($user_mail) ?>"
                  id="insapp_useremail" required="">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="phone" class="col-sm-4 col-form-label
                              form-label">
                <?php _e('Téléphone ')?><span class="text-muted">(facultatif)</span>
              </label>
              <div class="col-md-8 col-12">
                <input type="number" class="form-control ib_confirme" placeholder="Téléphone" id="insapp_userphone" name="insapp_userphone"
                  value="<?php _e($user_phone) ?>">
                  <div id="phone_error"></div>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="addressLine" class="col-sm-4 col-form-label
                                form-label">Adresse</label>
              <div class="col-md-8 col-12">
                <input type="text" class="form-control" placeholder="adresse" id="insapp_addressLine"
                  value="<?php _e($user_adresse) ?>">
              </div>
            </div>

            <div class="row align-items-center">
              <div class="offset-md-4 col-md-8 mt-4">
                <button type="submit" class="btn btn-primary user_update_profile_btn">
                  <?php _e('Sauvegarder les modifications')?>
                </button>
              </div>
            </div>
          </form>

        </div>
      </div>

    </div>

  </div>
</div>

<div class="row mt-5">
  <div class="col-12">

    <div class="card" id="edit">

      <div class="card-body">

        <div class="insapp_notification_user_password" style="text-align: center; margin-top: 30px;background-color: #ffcece;color: #f75555;font-weight: 600; justify-content: center;align-items: center;display: none; min-height: 50px;font-size: 14px;border-radius: 5px;">
        </div>

        <div class="mb-6 mt-6">
          <h4 class="mb-1">
            <?php _e('Changez votre mot de passe')?>
          </h4>
        </div>

        <form class="insapp_password_form" action="">
          <div class="mb-3 row">
            <label for="currentPassword" class="col-sm-4
                              col-form-label form-label">
              <?php _e('Mot de passe actuel')?>
            </label>

            <div class="col-md-8 col-12">
              <input type="password" class="form-control" placeholder="Entrer le mot de passe actuel"
                id="insappcurrentPassword" required="">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="currentNewPassword" class="col-sm-4
                              col-form-label form-label">
              <?php _e('Nouveau mot de passe')?>
            </label>

            <div class="col-md-8 col-12">
              <input type="password" class="form-control" placeholder="Entrez un nouveau mot de passe"
                id="insappcurrentNewPassword" required="">
            </div>
          </div>
          <div class="row align-items-center">
            <label for="confirmNewpassword" class="col-sm-4
                              col-form-label form-label">
              <?php _e('Confirmer le nouveau mot de passe')?>
            </label>
            <div class="col-md-8 col-12 mb-2 mb-lg-0">
              <input type="password" class="form-control" placeholder="Confirmer le nouveau mot de passe"
                id="insappconfirmNewpassword" required="">
            </div>
            <!-- list -->
            <div class="offset-md-4 col-md-8 col-12 mt-4">
              <h6 class="mb-1">
                <?php _e('Exigences relatives au mot de passe')?>&nbsp;:
              </h6>
              <p>
                <?php _e('Assurez-vous que ces exigences sont remplies')?>&nbsp;:
              </p>
              <ul>
                <li>
                  <?php _e("Minimum 8 caractères de long, plus il y en a, mieux c'est")?>
                </li>
              </ul>
              <button type="submit" class="btn btn-primary user_update_password_btn">
                <?php _e('Sauvegarder les modifications')?>
              </button>
            </div>
          </div>
        </form>

      </div>

    </div>

  </div>
</div>

<div class="row mt-5">
  <div class="col-12">

    <div class="card" id="edit">

      <div class="card-body"> 
        <?php 
              //  $result = insapp_get_connect_account($user_id)[0]->account_id;
           
              //  $check = insapp_get_status_account_stripe($result);
              //  var_dump($check);
              //  if($check == false){
                ?>
                 <!-- <p class="insapp_info_b"> -->
                  <?php //_e('Vous n\'avez pas fini de configurer votre compte stripe pour pouvoir 
                     // recevoir de l\'argent cliquez sur le bouton ci dessus pour terminer votre identification')
                  ?>
                  <!-- </p> -->
                <?php
                // } else{

                //   insapp_change_connect_account_status($user_id,$status);

                // }
             ?>
         <form class="insapp_stripe_account_btn" action="">
              <p class="insapp_info">
                <?php _e('Ces informations sont obligatoire si non vous ne recevrez 
                pas de vercement pour vos reservations')?>&nbsp;:
              </p> 
              <button type="submit" class="user_stripe_account_sub">
                <?php _e('Connect Stripe')?>
              </button>
            
        </form>

        <!-- <div class="insapp_notification_user_password" style="text-align: center; margin-top: 30px;background-color: #ffcece;color: #f75555;font-weight: 600; justify-content: center;align-items: center;display: none; min-height: 50px;font-size: 14px;border-radius: 5px;">
        </div>

        <div class="mb-6 mt-6">
          <h4 class="mb-1">
            <?php //_e('Changez votre mot de passe')?>
          </h4>
        </div> -->

        <!-- <form class="insapp_password_form" action="">
          <div class="mb-3 row">
            <label for="currentPassword" class="col-sm-4
                              col-form-label form-label">
              <?php //_e('Account ID')?>
            </label>

            <div class="col-md-8 col-12">
              <input type="text" class="form-control"
                id="ia_accound_id" required="">
            </div>
          </div> 
          <div class="row align-items-center">
            <label for="ia_linkaccount" class="col-sm-4
                              col-form-label form-label">
              <?php //_e('Lien de redirection')?>
            </label>
            <div class="col-md-8 col-12 mb-2 mb-lg-0">
              <input type="text" class="form-control" id="ia_linkaccount" required="">
            </div> 
            <div class="offset-md-4 col-md-8 col-12 mt-4">

              <p>
                <?php// _e('Ces informations sont obligatoire si non vous ne recevrez pas de vercement pour vos reservations')?>&nbsp;:
              </p> 
              <button type="submit" class="btn btn-primary user_update_account_btn">
                <?php// _e('Sauvegarder les modifications')?>
              </button>
            </div>
          </div>
        </form> -->

      </div>

    </div>

  </div>
</div>