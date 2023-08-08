jQuery(document).ready(function ($) {

    $('#multiple-select-work-days').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        closeOnSelect: false,
    });
    $('#multiple-select-special-days').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        closeOnSelect: false,
    });
    $('#multiple-select-update-work-days').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        closeOnSelect: false,
    });
    $('#multiple-select-update-special-days').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        closeOnSelect: false,
    });


    $('body').on('click', '.insapp_file_input', function (e) {
        e.preventDefault();
        insapp_uploader = wp.media({
            title: 'Custom image',
            button: {
                text: 'Utiliser cette image'
            },
            multiple: false
        }).on('select', function () {
            var attachment = insapp_uploader.state().get('selection').first().toJSON();
            $('#insapp_contact_image').attr('src', attachment.url);
        })
            .open();
    });


    $('#insapp_add_employees').submit((e) => {
        e.preventDefault();


        // $('.offcanvas-end').removeClass('show')
        // $('.offcanvas-end').removeClass('hiding')
        // $('div').remove('.offcanvas-backdrop') 

        let insapp_name = $('#insapp_name').val()
        let insapp_other_name = $('#insapp_other_name').val()
        let insapp_tel = $('#insapp_tel').val()
        let insapp_email = $('#insapp_email').val()
        let insapp_sexe = $('#insapp_sexe').val()
        let insapp_password = $('#insapp_password').val()
        let insapp_conf_password = $('#insapp_conf_password').val()
        let insapp_birthday = $('#insapp_birthday').val()
        let insapp_language = $('#insapp_language').val()
        let insapp_deb_heure = $('#insapp_deb_heure').val()
        let insapp_fin_heure = $('#insapp_fin_heure').val()
        let status = verify_pw(insapp_password, insapp_conf_password);
        let insapp_contact_image = $('#insapp_contact_image').attr('src')
        let insapp_work_days = []
        let insapp_special_days = []
        $("#multiple-select-work-days :selected").map(function (i, el) {
            insapp_work_days.push($(el).val());
        }).get();
        $("#multiple-select-special-days :selected").map(function (i, el) {
            insapp_special_days.push($(el).val());
        }).get();

        switch (status) {
            case 0:
                $('#feedback_password').addClass('invalid-feedback')
                $('#insapp_conf_password').addClass('invalid-input')
                break;
            case 1:
                $('#feedback_password').removeClass('invalid-feedback')
                $('#insapp_conf_password').removeClass('invalid-input')

                let data = {
                    'action': 'add_employees_ajax',
                    'nom': insapp_name,
                    'prenom': insapp_other_name,
                    'telephone': insapp_tel,
                    'email': insapp_email,
                    'sexe': insapp_sexe,
                    'password': insapp_password,
                    'birthday': insapp_birthday,
                    'langue': insapp_language,
                    'deb_heure': insapp_deb_heure,
                    'fin_heure': insapp_fin_heure,
                    'profil_image': insapp_contact_image,
                    'work_days': JSON.stringify(insapp_work_days),
                    'special_days': JSON.stringify(insapp_special_days),
                }
                console.log(data)


                jQuery.post(users_ajax.ajaxurl, data, (response) => {
                    $('.offcanvas-backdrop').removeClass('invalid-input')
                    console.log(response)
                    if (response.code == 200) {
                        $.toast({
                            heading: 'success',
                            text: response.message,
                            showHideTransition: 'plain',
                            position: 'top-right',
                            icon: 'success',
                            hideAfter: 5000,
                        })

                    } else if (response.code == 400) {
                        $.toast({
                            heading: 'error',
                            text: response.message,
                            showHideTransition: 'plain',
                            position: 'top-right',
                            icon: 'error',
                            hideAfter: 5000,
                        })
                    } else if (response.code == 404) {
                        $.toast({
                            heading: 'Warning',
                            text: response.message,
                            showHideTransition: 'plain',
                            position: 'top-right',
                            icon: 'warning',
                            hideAfter: 5000,
                        })
                    } else { }

                })

        }
    })


function verify_pw(password, conf_password) {
    if (password !== conf_password) {
        return 0;
    } else {
        return 1;
    }
}


/************************************************************
***********            Update                  **************
************************************************************/

    $('.insapp_btn_employees_update').on("click", function () {
        let insapp_id = $(this).attr("value")
        console.log(insapp_id)
        let data = {
            'action': 'update_employees_ajax',
            'employe_id': insapp_id,
        }
        console.log(data)

        jQuery.post(users_ajax.ajaxurl, data, (response) => {
            // $('.offcanvas-backdrop').removeClass('invalid-input')
            $('#insapp_update_name').val(response.nom)
            $('#insapp_update_other_name').val(response.prenom)
            $('#insapp_update_tel').val(response.tel)
            $('#insapp_update_email').val(response.email)
            $('#insapp_update_sexe').val(response.sexe)
            $('#insapp_update_birthday').val(response.birthday)
            $('#insapp_update_language').val(response.langue)
            $('#insapp_update_deb_heure').val(response.deb_heure)
            $('#insapp_update_fin_heure').val(response.fin_heure)
            $('#insapp_update_contact_image').attr('src', response.profil)
            $('#save-btn').val(response.id)
            console.log(response.work_days)

            // response.work_days.map(function (i, el) {
            //     console.log(i)
            //     // $('#multiple-select-update-work-days').val(i)
            //     $('#multiple-select-update-work-days')[el].prop('selected', true);
            // });
            // $("#multiple-select-update-special-days :selected").map(function (i, el) {
            //     insapp_special_days.push($(el).val());
            // }).get();
            console.log(response.special_days)
            console.log(response.work_days)
            // console.log(response.work_days[0])
        })
    })

    $('.insapp_add_employees_update').submit((e) => {
        console.log('hello')
        e.preventDefault();
        // $('.offcanvas-end').removeClass('show')
        // $('.offcanvas-end').removeClass('hiding')
        // $('div').remove('.offcanvas-backdrop') 
        let id = $('#save-btn').val()
        let insapp_name = $('#insapp_update_name').val()
        let insapp_other_name = $('#insapp_update_other_name').val()
        let insapp_tel = $('#insapp_update_tel').val()
        let insapp_email = $('#insapp_update_email').val()
        let insapp_sexe = $('#insapp_update_sexe').val()
        let insapp_birthday = $('#insapp_update_birthday').val()
        let insapp_language = $('#insapp_update_language').val()
        let insapp_contact_image = $('#insapp_contact_image').attr('src')

        $('#feedback_password').removeClass('invalid-feedback')
        $('#insapp_conf_password').removeClass('invalid-input')

        let data = {
            'action': 'save_update_employees_ajax',
            'id': id,
            'nom': insapp_name,
            'prenom': insapp_other_name,
            'telephone': insapp_tel,
            'email': insapp_email,
            'sexe': insapp_sexe,
            'birthday': insapp_birthday,
            'langue': insapp_language,
            'profil_image': insapp_contact_image,
        }
        console.log(data)


        jQuery.post(users_ajax.ajaxurl, data, function (response) {
            $('.offcanvas-backdrop').removeClass('invalid-input')
            console.log(response)
            if (response.code == 200) {
                $.toast({
                    heading: 'success',
                    text: response.message,
                    showHideTransition: 'plain',
                    position: 'top-right',
                    icon: 'success',
                    hideAfter: 5000,
                })

            } else if (response.code == 400) {
                $.toast({
                    heading: 'error',
                    text: response.message,
                    showHideTransition: 'plain',
                    position: 'top-right',
                    icon: 'error',
                    hideAfter: 5000,
                })
            } else if (response.code == 404) {
                $.toast({
                    heading: 'Warning',
                    text: response.message,
                    showHideTransition: 'plain',
                    position: 'top-right',
                    icon: 'warning',
                    hideAfter: 5000,
                })
            } else { }

        })

    }
    )


/************************************************************
***********            Delete                  **************
************************************************************/

    $('.insapp_btn_employees_delete').on("click", function () {
        let insapp_id = $(this).attr("value")

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Etes-vous sur?',
            text: "Cette action sera irreversible!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Supprimer!',
            cancelButtonText: 'Annuler',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
           
                let data = {
                    'action': 'delete_employees_ajax',
                    'employe_id': insapp_id,
                }
                jQuery.post(users_ajax.ajaxurl, data, (response) => {

                    console.log(response)
                    swalWithBootstrapButtons.fire(
                        'Supprimé!',
                        "L'employé a été supprimé.",
                        'Bravo'
                    )
                    setTimeout(() => {
                        
                    location.reload()
                    }, 2000);

                })
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Annuler',
                    "L'employé n'a pas été supprimé :)",
                    'erreur'
                )
            }
        })

    })

    $('.swal2-actions').addClass('justify-content-evenly')

    
})

