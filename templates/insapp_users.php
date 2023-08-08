<!-- 
/***********************************************************************
***********            Create Employees                  **************
*****************************************************************/ -->


<div class="offcanvas offcanvas-end" data-bs-backdrop="true" tabindex="-1" id="offcanvasRight"
    aria-labelledby="offcanvasRightLabel" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Ajouter un Employé</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="offcanvas-content">
            <div class="offcanvas-body">
                <div>
                    <form id="insapp_add_employees" method="post">
                        <div>
                            <div class="d-flex align-items-center mb-4 file-upload btn btn-outline-white ms-4">
                                <div class="d-flex align-items-center mb-4">
                                    <div>
                                        <img class="image avatar avatar-lg rounded-circle" id="insapp_contact_image"
                                            src="<?php TLPLUGIN_URL.'/assets/images/avatar-fallback.jpg' ?>" alt="
                                            Image">
                                    </div>

                                    <div class="file-upload btn btn-outline-white ms-4">
                                        <input type="file" class="file-input opacity-0 insapp_file_input">Upload Photo
                                    </div>
                                </div>
                                <!-- <div class="file-upload btn btn-outline-white ms-4">
                                    <input type="file" class="file-input opacity-0">Upload Photo
                                </div> -->
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="name">Nom</label>
                            <input type="text" class="form-control" placeholder="Entrer votre nom" id="insapp_name"
                                name="name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_other_name">Prenom</label>
                            <input type="text" class="form-control" placeholder="Entrer votre prenom"
                                id="insapp_other_name" name="insapp_other_name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_sexe">Sexe</label>
                            <select name="insapp_sexe" id="insapp_sexe" class="form-control">
                                <option value="0" disabled>Choisissez votre sexe</option>
                                <option value="Femme">Femme</option>
                                <option value="Homme">Homme</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_tel">Telephone</label>
                            <input type="number" class="form-control" placeholder="Entrer votre numero de telephone"
                                id="insapp_tel" name="insapp_tel">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_email">Email</label>
                            <input type="email" class="form-control" placeholder="Entrer votre Email" id="insapp_email"
                                name="insapp_email" autocomplete="email">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_password">Mot de passe</label>
                            <input type="password" class="form-control" placeholder="Entrer votre mot de passe"
                                id="insapp_password" name="insapp_password" autocomplete="new-password">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_conf_password">Confirmation mot de passe</label>
                            <input type="password" class="form-control" placeholder="Confirmez votre mot de passe"
                                id="insapp_conf_password" name="insapp_conf_password" autocomplete="current-password" />
                            <div class="invalid-password-feedback" id="feedback_password">
                                <?php _e('Les mots de passe ne correspondent pas!'); ?> </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_birthday">Date de naissance</label>
                            <input type="date" name="insapp_birthday" id="insapp_birthday" class="form-control"
                                placeholder="Entrer votre date de naissance">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_language">Langue</label>
                            <select name="insapp_language" id="insapp_language" class="form-control">
                                <option value="0" disabled>Choisissez votre langue de preference</option>
                                <option value="Francais">Francais</option>
                                <option value="English">English</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="multiple-select-work-days" class="form-label">Jours de
                                travail</label>
                            <select class="form-select" id="multiple-select-work-days"
                                data-placeholder="Choisir les jours" multiple>
                                <option value="Lundi">Lundi</option>
                                <option value="Mardi">Mardi</option>
                                <option value="Mercredi">Mercredi</option>
                                <option value="Jeudi">Jeudi</option>
                                <option value="Vendredi">Vendredi</option>
                                <option value="Samedi">Samedi</option>
                                <option value="Dimanche">Dimanche</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="multiple-select-special-days" class="form-label">Jours
                                spéciaux</label>
                            <select class="form-select" id="multiple-select-special-days"
                                data-placeholder="Choisir les jours" multiple>
                                <option value="Lundi">Lundi</option>
                                <option value="Mardi">Mardi</option>
                                <option value="Mercredi">Mercredi</option>
                                <option value="Jeudi">Jeudi</option>
                                <option value="Vendredi">Vendredi</option>
                                <option value="Samedi">Samedi</option>
                                <option value="Dimanche">Dimanche</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <h4 class="form-label text-center mt-3">Horaires de Service</h4>
                            <div class="mb-3">
                                <label class="form-label" for="insapp_deb_heure">Heure de debut</label>
                                <input type="time" name="insapp_deb_heure" id="insapp_deb_heure" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="insapp_fin_heure">Heure de fin</label>
                                <input type="time" name="insapp_fin_heure" id="insapp_fin_heure" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary" id="add-btn" style="display: block;">+ Add
                                Employé</button>
                            <button type="submit" class="btn btn-primary" id="update-btn"
                                style="display: none;">Update</button>
                            <input type="hidden" class="form-control" placeholder="ID" id="id" value="2">
                            <button class="btn btn-light ms-2" data-bs-dismiss="offcanvas" aria-label="Close"
                                type="button">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 
/*********************************************************************
***********            Show Employees                  **************
***************************************************************/ -->

<main id="main-wrapper" class="main-wrapper">


    <div id="app-content">
        <div class="app-content-area">
            <div class="container-fluid">
                <div class="mb-3">
                    <div class="col-lg-12 col-md-12 col-12">
                        <!-- Page header -->
                        <div class="mb-5">
                            <h3 class="mb-0 ">Employés</h3>

                        </div>
                    </div>
                </div>

                <div class="row justify-content-between mb-4">
                    <div class=" col-4 col-md-6">
                        <input type="search" class="form-control " placeholder="Search for seller and ownwer name...">

                    </div>
                    <div class="col-8 col-md-6 d-flex justify-content-end text-end mt-0">
                        <button id="add" name="add" class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Nouvel utilisateur</button>
                    </div>

                </div>
                <div class="py-6">
                    <div class="row">

                        <?php
                            $blogusers = get_users( array( 'role__in' => array( 'insapp_photographe' ) ) );
                            // Array of WP_User objects.
                            foreach ( $blogusers as $user ) {
                                if(esc_url( $user->user_url ) != null) {
                                    $insapp_url = esc_url( $user->user_url ) ;
                                }else {
                                    $insapp_url = TLPLUGIN_URL.'/assets/images/avatar-fallback.jpg';
                                }
                        ?>

                        <div class="col-lg-4 col-12">
                            <!-- card -->
                            <div class="card mb-5 rounded-3">
                                <div
                                    style="background-color: #624bff; height: 46px; width: 100%; border-radius: 0.5rem 0.5rem 0 0 !important;">
                                    <!-- <img src="<?php echo TLPLUGIN_URL.'/assets/images/1.jpg' ?>" alt="Image"
                                        class="img-fluid rounded-top" width="309px" height="46px"> -->
                                </div>
                                <!-- avatar -->
                                <div class="avatar avatar-xl mt-n7 ms-4">
                                    <img src="<?php echo $insapp_url; ?>" alt="Image"
                                        class="rounded-circle border-4 border-white-color-40">
                                </div>
                                <!-- card body -->
                                <div class="card-body">
                                    <!-- Title -->
                                    <h4 class="mb-1">
                                        <?php echo '<span>' . esc_html( $user->display_name ).'</span>' ?>
                                    </h4>
                                    <p>
                                        <?php echo '<span>' . esc_html( $user->user_email ) . '</span>' ?>
                                    </p>
                                    <p>
                                        <?php echo '<span>' . esc_html( $user->telephone ) . '</span>' ?>
                                    </p>
                                    <div>
                                        <!-- Dropdown -->
                                        <div class="d-flex justify-content-evenly align-items-center">
                                            <a value="<?php echo esc_html( $user->ID )  ?>"
                                                class="btn btn-outline-primary insapp_btn_employees_update"
                                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight_update"
                                                aria-controls="offcanvasRight">Modifier</a>
                                            <a value="<?php echo esc_html( $user->ID )  ?>"
                                                class="btn btn-outline-danger insapp_btn_employees_delete">Spprimer</a>
                                            <!-- // <input type="hidden" name="insapp_employees_update" id="insapp_employees_update"> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<!-- /*****************************************************************
***********            Update Employees                 **************
****************************************************************/ -->

<div class="offcanvas offcanvas-end" data-bs-backdrop="true" tabindex="-1" id="offcanvasRight_update"
    aria-labelledby="offcanvasRightLabel-update" data-bs-target="#offcanvasScrolling"
    aria-controls="offcanvasScrolling">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel-update">Modifier l'Employé</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
        <div class="offcanvas-content">
            <div class="offcanvas-body">
                <div>
                    <form class="insapp_add_employees_update" method="post">
                        <div>
                            <div class="d-flex align-items-center mb-4 file-upload btn btn-outline-white ms-4">
                                <div class="d-flex align-items-center mb-4">
                                    <div>
                                        <img class="image avatar avatar-lg rounded-circle"
                                            id="insapp_update_contact_image" src="" alt="Image">
                                    </div>

                                    <div class="file-upload btn btn-outline-white ms-4">
                                        <input type="file" class="file-input opacity-0 insapp_file_input"
                                            value="">Telecharger une Photo
                                    </div>
                                </div>
                                <!-- <div class="file-upload btn btn-outline-white ms-4">
                                    <input type="file" class="file-input opacity-0">Upload Photo
                                </div> -->
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="name">Nom</label>
                            <input type="text" class="form-control" value="" id="insapp_update_name"
                                name="insapp_update_name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_update_other_name">Prenom</label>
                            <input type="text" class="form-control" id="insapp_update_other_name"
                                name="insapp_update_other_name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_update_sexe">Sexe</label>
                            <select name="insapp_update_sexe" id="insapp_update_sexe" class="form-control">
                                <option value="0" disabled>Choisissez votre sexe</option>
                                <option value="Femme">Femme</option>
                                <option value="Homme">Homme</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_update_tel">Telephone</label>
                            <input type="number" class="form-control" value="" id="insapp_update_tel"
                                name="insapp_update_tel">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_update_email">Email</label>
                            <input type="email" class="form-control" value="" id="insapp_update_email"
                                name="insapp_update_email" autocomplete="email">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_update_birthday">Date de naissance</label>
                            <input type="date" name="insapp_update_birthday" id="insapp_update_birthday"
                                class="form-control" value="">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="insapp_update_language">Langue</label>
                            <select name="insapp_update_language" id="insapp_update_language" class="form-control">
                                <option value="0" disabled>Choisissez votre langue de preference</option>
                                <option value="Francais">Francais</option>
                                <option value="English">English</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="multiple-select-update-work-days" class="form-label">Jours de travail</label>
                            <select class="form-select" id="multiple-select-update-work-days"
                                data-placeholder="Choisir jours" multiple>
                                <option value="Lundi">Lundi</option>
                                <option value="Mardi">Mardi</option>
                                <option value="Mercredi">Mercredi</option>
                                <option value="Jeudi">Jeudi</option>
                                <option value="Vendredi">Vendredi</option>
                                <option value="Samedi">Samedi</option>
                                <option value="Dimanche">Dimanche</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="multiple-select-update-special-days" class="form-label">Jours spéciaux</label>
                            <select class="form-select" id="multiple-select-update-special-days"
                                data-placeholder="Choisir jours" multiple>
                                <option value="Lundi">Lundi</option>
                                <option value="Mardi">Mardi</option>
                                <option value="Mercredi">Mercredi</option>
                                <option value="Jeudi">Jeudi</option>
                                <option value="Vendredi">Vendredi</option>
                                <option value="Samedi">Samedi</option>
                                <option value="Dimanche">Dimanche</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <h4 class="form-label text-center mt-3">Horaires de Service</h4>
                            <div class="mb-3">
                                <label class="form-label" for="insapp_update_deb_heure">Heure de debut</label>
                                <input type="time" name="insapp_update_deb_heure" id="insapp_update_deb_heure" value=""
                                    class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="insapp_fin_heure">Heure de fin</label>
                                <input type="time" name="insapp_update_fin_heure" id="insapp_update_fin_heure"
                                    class="form-control" value="">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary" id="save-btn" style="display: block;">+
                                Ajouter
                                Employé</button>
                            <button class="btn btn-light ms-2" data-bs-dismiss="offcanvas" aria-label="Close"
                                type="button">Fermer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>