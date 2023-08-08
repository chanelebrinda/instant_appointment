<!-- 
/***********************************************************************
***********            Create Customers                  **************
*****************************************************************/ -->


<div class="offcanvas offcanvas-end" data-bs-backdrop="true" tabindex="-1" id="offcanvasRight_create_client"
    aria-labelledby="offcanvasRightLabel_create_client" data-bs-target="#offcanvasScrolling"
    aria-controls="offcanvasScrolling">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel_create_client">Ajouter un Employé</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="offcanvas-content">
            <div class="offcanvas-body">
                <div>
                    <form id="insapp_add_customers" method="post">
                        <div>
                            <div class="d-flex align-items-center mb-4 file-upload btn btn-outline-white ms-4">
                                <div class="d-flex align-items-center mb-4">
                                    <div>
                                        <img class="image avatar avatar-lg rounded-circle"
                                            id="insapp_contact_image_client"
                                            src="https://dashui.codescandy.com/dashuipro/assets/images/avatar/avatar-fallback.jpg"
                                            alt="Image">
                                    </div>

                                    <div class="file-upload btn btn-outline-white ms-4">
                                        <input type="file" class="file-input opacity-0 insapp_file_input_client">Upload
                                        Photo
                                    </div>
                                </div>
                                <!-- <div class="file-upload btn btn-outline-white ms-4">
                                    <input type="file" class="file-input opacity-0">Upload Photo
                                </div> -->
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="name">Nom</label>
                            <input type="text" class="form-control" placeholder="Entrer votre nom"
                                id="insapp_name_client" name="name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_other_name_client">Prenom</label>
                            <input type="text" class="form-control" placeholder="Entrer votre prenom"
                                id="insapp_other_name_client" name="insapp_other_name_client">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_sexe_client">Sexe</label>
                            <select name="insapp_sexe_client" id="insapp_sexe_client" class="form-control">
                                <option value="0" disabled selected>Choisissez votre sexe</option>
                                <option value="Femme">Femme</option>
                                <option value="Homme">Homme</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_tel_client">Telephone</label>
                            <input type="number" class="form-control" placeholder="Entrer votre numero de telephone"
                                id="insapp_tel_client" name="insapp_tel_client">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_email_client">Email</label>
                            <input type="email" class="form-control" placeholder="Entrer votre Email"
                                id="insapp_email_client" name="insapp_email_clientt" autocomplete="email">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_password_client">Mot de passe</label>
                            <input type="password" class="form-control" placeholder="Entrer votre mot de passe"
                                id="insapp_password_client" name="insapp_password_client" autocomplete="new-password">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_conf_password_client">Confirmation mot de
                                passe</label>
                            <input type="password" class="form-control" placeholder="Confirmez votre mot de passe"
                                id="insapp_conf_password_client" name="insapp_conf_password_client"
                                autocomplete="current-password" />
                            <div class="invalid-password-feedback" id="feedback_password">
                                <?php _e('Les mots de passe ne correspondent pas!'); ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_birthday_client">Date de naissance</label>
                            <input type="date" name="insapp_birthday_client" id="insapp_birthday_client"
                                class="form-control" placeholder="Entrer votre date de naissance">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_language_client">Langue</label>
                            <select name="insapp_language_client" id="insapp_language_client" class="form-control">
                                <option value="0" disabled selected>Choisissez votre langue de preference</option>
                                <option value="Francais">Francais</option>
                                <option value="English">English</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary" id="add-btn-client" style="display: block;">+
                                Ajouter Client</button>
                            <button class="btn btn-light ms-2" data-bs-dismiss="offcanvas"
                                aria-label="Close">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 
/*********************************************************************
***********            Show customers                  **************
***************************************************************/ -->

<main id="main-wrapper" class="main-wrapper">


    <div id="app-content">
        <div class="app-content-area">
            <div class="container-fluid">
                <div class="mb-3">
                    <div class="col-lg-12 col-md-12 col-12">
                        <!-- Page header -->
                        <div class="mb-5">
                            <h3 class="mb-0 ">Clients</h3>

                        </div>
                    </div>
                </div>

                <div class="row justify-content-between mb-4">
                    <div class=" col-4 col-md-6">
                        <input type="search" class="form-control " placeholder="Rechercher un client...">

                    </div>
                    <div class="col-8 col-md-6 d-flex justify-content-end text-end mt-0">
                        <button id="add" name="add" class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasRight_create_client" aria-controls="offcanvasRight">Nouveau
                            client</button>
                    </div>

                </div>

                <table class="table mb-0 text-nowrap table-centered">
                    <thead class="table-light">
                        <tr>
                            <th>Nom Clients</th>
                            <th>Dates d'anniversaire</th>
                            <th>Sexe </th>
                            <th>Numero telephone</th>
                            <th>Email</th>
                            <th>Langue</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $customers = get_users( array( 'role__in' => array( 'insapp_customers' ) ) );
                        
                        // Array of WP_User objects.
                        foreach ( $customers as $user ) {  
                            if(esc_url( $user->user_url ) != null) {
                                $insapp_url = esc_url( $user->user_url ) ;
                            }else {
                                $insapp_url = TLPLUGIN_URL.'/assets/images/avatar-fallback.jpg';
                            }
                        ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="icon-shape icon-lg rounded-3 border ">
                                        <img src="<?php echo $insapp_url; ?>" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="feather feather-layout icon-sm text-muted" />
                                    </div>
                                    <div class="ms-3">
                                        <h4 class="mb-0 fs-5"><span
                                                class="text-inherit"><?php echo esc_html( $user->display_name ) ?></span>
                                        </h4>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span><?php echo esc_html( $user->birthday_client ) ?></span>
                            </td>
                            <td>
                                <span><?php echo esc_html( $user->sexe_client ) ?></span>
                            </td>

                            <td>
                                <span><?php echo esc_html( $user->telephone_client ) ?></span>
                            </td>
                            <td>
                                <span class=""><?php echo esc_html( $user->user_email ) ?></span>
                            </td>
                            <td>
                                <span><?php echo esc_html( $user->locale ) ?></span>
                            </td>
                            <td class="text-end">
                                <div class="dropdown dropstart">
                                    <a href="#!" class="btn-icon btn btn-ghost btn-sm rounded-circle"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-more-vertical icon-xs">
                                            <circle cx="12" cy="12" r="1"></circle>
                                            <circle cx="12" cy="5" r="1"></circle>
                                            <circle cx="12" cy="19" r="1"></circle>
                                        </svg>
                                    </a>
                                    <div class="dropdown-menu">

                                        <a class="dropdown-item d-flex align-items-center insapp_btn_customers_update"
                                            href="#!" value="<?php echo esc_html( $user->ID )  ?>"
                                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight_update_client"
                                            aria-controls="offcanvasRight">
                                            <svg xmlns=" http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-edit  dropdown-item-icon">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                </path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                </path>
                                            </svg>Modifier
                                        </a>
                                        <a class="dropdown-item d-flex align-items-center insapp_btn_customers_delete"
                                            href="#!" value="<?php echo esc_html( $user->ID )  ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-trash dropdown-item-icon">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path
                                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                </path>
                                            </svg>Supprimer
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="7">
                                <div class="d-flex align-items-center">
                                    <btn id="add" data-bs-toggle="offcanvas" class="d-flex align-items-center"
                                        type="button" data-bs-target=" #offcanvasRight_create_client"
                                        aria-controls="offcanvasRight">
                                        <div class="icon-shape icon-lg fs-3 "> + </div>
                                        <div class="ms-3">
                                            <h4 class="mb-0 fs-5 text-inherit">Nouveau Client</h4>
                                        </div>
                                    </btn>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>


<!-- /*****************************************************************
***********            Update customers                 **************
****************************************************************/ -->

<div class="offcanvas offcanvas-end" data-bs-backdrop="true" tabindex="-1" id="offcanvasRight_update_client"
    aria-labelledby="offcanvasRightLabel-update-client" data-bs-target="#offcanvasScrolling"
    aria-controls="offcanvasScrolling">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel-update-client">Modifier le Client</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
        <div class="offcanvas-content">
            <div class="offcanvas-body">
                <div>
                    <form class="insapp_add_customers_update" method="post">
                        <div>
                            <div class="d-flex align-items-center mb-4 file-upload btn btn-outline-white ms-4">
                                <div class="d-flex align-items-center mb-4">
                                    <div>
                                        <img class="image avatar avatar-lg rounded-circle"
                                            id="insapp_update_contact_image_client" src="" alt="Image">
                                    </div>

                                    <div class="file-upload btn btn-outline-white ms-4">
                                        <input type="file" class="file-input opacity-0 insapp_file_input_client"
                                            value="">Telecharger une Photo
                                    </div>
                                </div>
                                <!-- <div class="file-upload btn btn-outline-white ms-4">
                                    <input type="file" class="file-input opacity-0">Upload Photo
                                </div> -->
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_update_name_client">Nom</label>
                            <input type="text" class="form-control" value="" id="insapp_update_name_client"
                                name="insapp_update_name_client">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_update_other_name_client">Prenom</label>
                            <input type="text" class="form-control" id="insapp_update_other_name_client"
                                name="insapp_update_other_name_client">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_update_sexe_client">Sexe</label>
                            <select name="insapp_update_sexe_client" id="insapp_update_sexe_client"
                                class="form-control">
                                <option value="0" disabled>Choisissez votre sexe</option>
                                <option value="Femme">Femme</option>
                                <option value="Homme">Homme</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_update_tel_client">Telephone</label>
                            <input type="number" class="form-control" value="" id="insapp_update_tel_client"
                                name="insapp_update_tel_client">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_update_email_client">Email</label>
                            <input type="email" class="form-control" value="" id="insapp_update_email_client"
                                name="insapp_update_email_client" autocomplete="email">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_update_birthday_client">Date de naissance</label>
                            <input type="date" name="insapp_update_birthday_client" id="insapp_update_birthday_client"
                                class="form-control" value="">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_update_language_client">Langue</label>
                            <select name="insapp_update_language_client" id="insapp_update_language_client"
                                class="form-control">
                                <option value="0" disabled>Choisissez votre langue de preference</option>
                                <option value="Francais">Francais</option>
                                <option value="English">English</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-evenly mt-5">
                            <button type="submit" class="btn btn-primary" id="save-btn-client" style="display: block;">+
                                Enregistrer</button>
                            <button class="btn btn-light ms-2" data-bs-dismiss="offcanvas" aria-label="Close"
                                type="button">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>