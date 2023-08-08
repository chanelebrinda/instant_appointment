<?php 

    $dashboard_page = get_option('insapp_settings_name')['Dashboard_page']; 
    if( $dashboard_page ) {
           
    }else{
       
        
    } 
    if(is_user_logged_in()){
    }else{
        
    }
    $current_user = wp_get_current_user();
    
    // var_dump((get_option('insapp_settings_name')['Dashboard_page']));
 ?>


<div class="insapp_login_container">
    <div class="insapp_login_content">
        <div class="insapp_title_text">
            <div class="title insapp_login">
                <?php _e('Connexion') ?>
            </div>
            <div class="title insapp_register">
                <?php _e('Inscription') ?>
            </div>
        </div>

        <div class="insapp_form_container">

            <div class="insapp_slide_controls">
                <input type="radio" name="insapp_slide" id="insapp_login" checked>
                <input type="radio" name="insapp_slide" id="insapp_register">
                <label for="insapp_login" class="insapp_slide insapp_login">Connexion</label>
                <label for="insapp_register" class="insapp_slide insapp_register">Incription</label>
                <div class="insapp_slider_tab"></div>
            </div>

            <div class="insapp_form_inner">
                <form id="insapp_login_user_form" class="insapp_login"
                    action="<?php echo esc_url(get_permalink(get_option('insapp_settings_name')['Dashboard_page'])) ?>"
                    methode="post">
                    <div id="insapp_login_user" class="insapp_notification_sucess my-2" style="text-align: center;
                         margin-top: 30px; background-color: rgb(206 255 209); color: rgb(85 171 112); 
                         font-weight: 600; justify-content: center; min-height: 50px;
                          align-items: center; display: none; font-size: 14px; border-radius: 5px;">

                    </div>

                    <div class="field">
                        <input type="email" id="insapp_logname" placeholder="<?php _e('Email') ?>" required>
                    </div>
                    <div class="field">
                        <input type="password" id="insapp_log_password" placeholder="<?php _e('Password') ?>" required>
                    </div>
                    <div class="pass-link"><a href="<?php echo esc_url( wp_lostpassword_url() ); ?>">
                            <?php _e('Mot de passe oublie?') ?>
                        </a></div>
                    <div class="field">
                        <div class="btn-layer"></div>
                        <button type="submit" class="insapp_btn" id="insapp_login_user">
                            <?php _e('Se connecter') ?>
                        </button>
                    </div>
                    <div class="insapp_signup_link">
                        <?php _e('Vous n\'avez pas de compte?') ?> <a href="">
                            <?php _e("S'inscrire") ?>
                        </a>
                    </div>
                    <div id="insapp_login_user" class="insapp_notification" style="text-align: center;
                    margin-top: 30px;background-color: #ffcece;color: #f75555;font-weight: 600;
                     justify-content: center;min-height: 50px; align-items: center;display:
                      none; font-size: 14px;border-radius: 5px;">

                    </div>
                </form>

                <form id="insapp_register_user_form" class="insapp_register"
                    action="<?php echo esc_url(get_permalink(get_option('insapp_settings_name')['Login_page'])); ?>"
                    methode="post">
                    <div id="insapp_login_user" class="insapp_notification_sucess" style="text-align: center;
                         margin-top: 30px; background-color: rgb(206 255 209); color: rgb(85 171 112); 
                         font-weight: 600; justify-content: center; min-height: 50px;
                          align-items: center;  display: none; font-size: 14px; border-radius: 5px;">
                    </div>
                    <div class=" insapp_btn_group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="insapp-role" value="insapp_customers"
                            id="insapp-custumer-radio" autocomplete="off" checked>
                        <label class="btn btn-outl-pri" for="insapp-custumer-radio">
                            <?php _e( 'Client') ?>
                        </label>

                        <input type="radio" class="btn-check" name="insapp-role" value="insapp_photographe"
                            id="insapp-owner-radio" autocomplete="off">
                        <label class="btn btn-outl-pri" for="insapp-owner-radio">
                            <?php _e('Photographe')?>
                        </label>

                    </div>

                    <div class="field">
                        <input type="text" placeholder=" <?php _e('Nom') ?>" id="insapp_firstname" required>
                    </div>
                    <div class="field">
                        <input type="text" placeholder=" <?php _e('Prenom') ?>" id="insapp_lastname" required>
                    </div>
                    <div class="field">
                        <input type="email" placeholder=" <?php _e('Email') ?>" id="insapp_useremail" required>
                    </div>

                    <div class="field">
                        <input type="password" id="insapp_userpassword" placeholder="<?php _e('Mot de passe') ?>"
                            required>
                    </div>
                    <div class="field">
                        <input type="password" placeholder="<?php _e('confirmer le mot passe')?>"
                            id="insapp_conf_userpassword" required>
                    </div>

                    <div class="field">
                        <div></div>
                        <button type="submit" class="insapp_btn">
                            <?php _e("S'inscrire") ?>
                        </button>
                    </div>

                    <div id="insapp_register_user" class="insapp_notification" style="text-align: center;
                    margin-top: 30px;background-color: #ffcece;color: #f75555;font-weight: 600;
                     justify-content: center;align-items: center;display:
                      none; min-height: 50px;font-size: 14px;border-radius: 5px;">

                    </div>

                </form>

            </div>
        </div>
    </div>
</div>