
jQuery(document).ready(function ($) {


    $('.insapp_profile_form').submit(function (e) {
 
        e.preventDefault(); 
        $('.user_update_profile_btn').attr("disabled", "disabled");

        image = $("#user_pic_input")[0].files[0];
        let id = $('.insapp_user').val()
        let nom = $('#insapp_lastName').val()
        let prenom = $('#insapp_firstName').val()
        let tel = $('#insapp_userphone').val()
        let email = $('#insapp_useremail').val()
        let adresse = $('#insapp_addressLine').val()

        let data = {
            'action': 'update_user_profile_ajax',
            'user_id': id,
            'nom': nom,
            'prenom': prenom,
            'telephone': tel,
            'email': email,
            'adresse': adresse,
            'image_name': image.name,
            'image_url': $('#user_pic').attr('src'),
        } 

        jQuery.post(profils_front_ajax.ajaxurl, data, function (response) {
     
            if (response.code == 200) {
                $.toast({
                    heading: 'success',
                    text: response.message,
                    showHideTransition: 'plain',
                    position: 'top-right',
                    icon: 'success',
                    hideAfter: 5000,
                });
                location.reload();

            } else if (response.code == 400) {
                $.toast({
                    heading: 'error',
                    text: response.message,
                    showHideTransition: 'plain',
                    position: 'top-right',
                    icon: 'error',
                    hideAfter: 10000,
                });
                location.reload();
            } else{
                $.toast({
                    heading: 'Warning',
                    text: response.message,
                    showHideTransition: 'plain',
                    position: 'top-right',
                    icon: 'warning',
                    hideAfter: 8000,
                });
                 
            }
            $('.user_update_profile_btn').removeAttr("disabled") 

        })

    });


        
    $('.insapp_stripe_account_btn').submit(function (e) {
 
        e.preventDefault(); 
        // $('.user_stripe_account_sub').attr("disabled", "disabled");
 
        let id = $('.insapp_user').val()
        
        let data = {
            'action': 'ia_get_user_account_ajax',  
            'user_id': id, 
        } 
       
        jQuery.post(service_front_ajax.ajaxurl, data, function (response) {
        
            if (response.code == 200) { 
                window.location.href = response.message; 

            }else{
                $.toast({
                    heading: 'Warning',
                    text: response.message,
                    showHideTransition: 'plain',
                    position: 'top-right',
                    icon: 'warning',
                    hideAfter: 8000,
                });
            }
            
            $('.user_stripe_account_sub').removeAttr("disabled") 

        })

    });

    function verify_pw(password, conf_password) {
        if (password !== conf_password) {
            return 0;
        } else {
            return 1;
        }
    }

    $('.insapp_password_form').submit(function (e) {
       
        e.preventDefault();
        $('.insapp_notification_user_password').css('display', 'none')
        $('.insapp_notification_user_password').css('display', 'none')
        $('.user_update_password_btn').attr("disabled", "disabled");

        let id = $('.insapp_user').val()
        let currentt_password = $('#insappcurrentPassword').val() 
        let new_password = $('#insappcurrentNewPassword').val()
        let c_new_password = $('#insappconfirmNewpassword').val() 

        if (verify_pw(new_password, c_new_password) == 1) {

            if (new_password.length < 8) {

                $('.user_update_password_btn').removeAttr("disabled")
                $('.insapp_notification_user_password').css('display', 'flex')
                $('.insapp_notification_user_password').html('le mot de passe est trop court.Il faut minimum 8 chiffres')


            } else {

                let data = {
                    'action': 'update_user_password_ajax',
                    'user_id': id,
                    'password': password, 
                } 


                jQuery.post(profils_front_ajax.ajaxurl, data, function (response) {
                
                    if (response.code == 200) {
                        $.toast({
                            heading: 'success',
                            text: response.message,
                            showHideTransition: 'plain',
                            position: 'top-right',
                            icon: 'success',
                            hideAfter: 5000,
                        });
                        location.reload();
                    } else {
                        $.toast({
                            heading: 'Warning',
                            text: response.message,
                            showHideTransition: 'plain',
                            position: 'top-right',
                            icon: 'warning',
                            hideAfter: 8000,
                        });

                    }

                })
            }
        } else {
           
            $('.user_update_password_btn').removeAttr("disabled")
            $('.insapp_notification_user_password').css('display', 'flex')
            $('.insapp_notification_user_password').html('les mots de passe ne correspondent pas')

        }
    });

    // function validerNumeroTelephone(numeroTelephone) {
    //     var regex = /^\d{10}$/; // Vérifie que le numéro de téléphone est composé exactement de 10 chiffres

    //     if (regex.test(numeroTelephone)) {
    //         // Le numéro de téléphone est valide
    //         return true;
    //     } else {
    //         // Le numéro de téléphone est invalide
    //         return false;
    //     }
    // }

    // let nbr_tel = document.getElementById('insapp_userphone');
    // nbr_tel.addEventListener("change", )

    // $("input[name='insapp_userphone']").on('change', function () {

    //     if (validerNumeroTelephone($("input[name='insapp_userphone']").val()) == false) {

    //         $("input[name='insapp_userphone']").addClass('is-invalid');
    //         $('#phone_error').css('display', 'block');
    //         $('.ib_confirme').attr("disabled", "disabled");
    //         $('.ib_confirme').css("background-color", "#f39071");

    //     } else {
    //         $("input[name='insapp_userphone']").removeClass('is-invalid');
    //         $('#phone_error').css('display', 'none');

    //     }

    // });

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Exemple d'utilisation :
    const emailToCheck = 'john.doe@example.com';

    if (isValidEmail(emailToCheck)) {
        // console.log("L'adresse e - mail est valide.");
    } else {
        // console.log("L'adresse e - mail n'est pas valide.");
    }

    const fileInput = document.getElementById('user_pic_input');

    if (fileInput != null) {
        fileInput.addEventListener('change', () => {

            const fr = new FileReader();
            fr.readAsDataURL(fileInput.files[0]);

            fr.addEventListener('load', () => {

                const url = fr.result;
                image_url = url
            
                $('#user_pic').attr('src', image_url);

                const img = new Image();
                img.src = url;
            })


        });
    }


});