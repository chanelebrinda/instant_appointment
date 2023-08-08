
jQuery(document).ready(function ($) {
    window['moment-range'].extendMoment(moment);

});


function Extra(_libelle = '', cout_extra = 0) {
    this.nom = _libelle;
    this.cout = cout_extra;
}
let liste_extras_update = [];
let _updateExtraButton = document.getElementById('btn_update_exta');
if (_updateExtraButton != null) {
    _updateExtraButton.addEventListener('click', function () {

        let nom_extra = document.getElementById('nom_extra_update').value;
        let cout_extra = document.getElementById('cout_extra_update').value;

        let extra = new Extra(nom_extra, cout_extra);
        e.push(extra);
        console.log(e);

        let _tr = document.createElement('tr');
        let _tdM = document.createElement('td'); _tdM.innerHTML = nom_extra;
        let _tdN = document.createElement('td'); _tdN.innerHTML = cout_extra;
        let _tdAction = document.createElement('td');
        _tdAction.classList.add("justify-content-evenly");
        _tdAction.classList.add("d-grid");
        _tdAction.classList.add("gap-2");
        _tdAction.classList.add("d-md-flex");
        let _btnDele = document.createElement('button');
        _btnDele.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke = "currentColor" stroke - width="2" stroke - linecap="round" stroke - linejoin="round" class="feather feather-trash-2 icon-xs"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg > ';
        _btnDele.classList.add("btn")
        _btnDele.classList.add("btn-outline-danger")

        // _tdAction.appendChild(_btnMore);
        _tdAction.appendChild(_btnDele);
        _tr.appendChild(_tdM);
        _tr.appendChild(_tdN);
        _tr.appendChild(_tdAction);

        document.getElementById('tab_update_extra').appendChild(_tr);


        document.getElementById('nom_extra_update').value = '';
        document.getElementById('cout_extra_update').value = '';

        _btnDele.addEventListener('click', () => {
            _tr.remove();
        });
    });
}

jQuery(document).ready(function ($) {
 
    $('.insapp_envoyerMessage_link').on('click', function (e) {
        e.preventDefault();
         
         localStorage.setItem('jstabs-opentab',3)
       let  currentuser = $('#insapp_author_id').attr('data-id');
        let photographeUser = $('#insapp_author_id').val();
        let data = {
            'action': 'insapp_newconverstion_ajax', 
            'sender_id':  currentuser,
            'receiver_id':  photographeUser,
        }
        console.log(data)

        jQuery.post(insapp_agenda_ajax.ajaxurl, data, function (response) {
            console.log(response)
            $('.insapp_envoyerMessageBtn').submit();
            if (response) {
                 
              } else {
                alert('Une erreur s\'est produite lors de la génération du PDF.');
              }
              
        })
    }); 

    $(".insapp_booking_date").flatpickr({
        enableTime: false,
        inline: true,
        minDate: "today",
        disable: [
            "2023-06-27",
            "2023-06-30",
        ],
        locale: {
            firstDayOfWeek: 0,
            weekdays: {
                shorthand: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
                longhand: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
            },
            months: {
                shorthand: ['jan', 'Fev', ',Mar', 'Avr', 'Mai', 'jun', 'Jul', 'Aou', 'Sep', 'Oct', 'Nov', 'Déc'],
                longhand: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            },
        },
    });


    $(".insapp_booking_date").change(function () {

        $('.insapp_loader_ajax_container').addClass('loading_slots')
        $('.insapp_booking_slots').html(' ');

        let author_id = $('#insapp_author_id').val()
        let book_date = $('.insapp_booking_date').val();
        let timeInMinutes = $('.insapp_booking_range').val();
        const range = moment.duration(timeInMinutes).asMinutes();

        let data = {
            'action': "booking_get_agenda_slot",
            'date': book_date,
            'author_id': author_id
        }

        jQuery.post(reservation_service_front_ajax.ajaxurl, data, function (response) {
      
            if (response.success == true) {
                tab = response.data.message
                var agenda = [];
                tab.forEach(element => {

                    agenda.push(element.star_time.replace(/['"]+/g, ''))
                });
                var slotArray = []
                agenda.forEach(element => {
                    agenda = element.split(",")

                    const day_start = moment(agenda[0], 'h:mm a').hours(agenda[0]);
                    const day_end = moment(agenda[1], 'h:mm a').hours(agenda[1])
                    const day = moment.range(day_start, day_end)

                    const time_slots = Array.from(day.by('minutes', { step: range }))

                    for (i = 0; i <= time_slots.length - 2; i++) {
                        time = moment(time_slots[i]).format('H:mm') + " - " + moment(time_slots[i + 1]).format('H:mm')
                        // $('.insapp_booking_slots').append(
                        '<div class="insapp_date_slot " data-slot-start="' + moment(time_slots[i]).format('H:mm') + '" data-slot-end="' + moment(time_slots[i]).format('H:mm') + '" >' + time + ' </div>'
                        // );
                        slotArray.push(time)
                        // i++
                    }
                });
                tampon = '+1 hour 30 minutes'

                let data = {
                    'action': "booking_services_slot",
                    'date': book_date,
                    'author_id': author_id,
                    'slots': slotArray,
                    'tampon': tampon
                }
                if(slotArray.length == 0){
                    $('.insapp_loader_ajax_container').removeClass('loading_slots')
                        $('.insapp_booking_slots').css('display', 'flex')
                    $('.insapp_booking_slots').html('<span class="insapp_date_slot_vide">Nous n\'avons plus de crénaux disponible dans cette journée</span> ');
                }else{

                    jQuery.post(reservation_service_front_ajax.ajaxurl, data, function (response) {
                    
                        $('.insapp_loader_ajax_container').removeClass('loading_slots')
                        $('.insapp_booking_slots').css('display', 'flex')
                        $('.insapp_booking_slots').html(response);

                        $(".insapp_date_slot").click(function () {
                            $('.insapp_date_slot').removeClass('style_slots')
                            $(this).addClass('style_slots')
                            let slotval = $(this).attr('value')
                            $('.insapp_slot_value').val(slotval);

                            // slot = $(this).val()
                            // $('.insapp_slot_value').val(slot)
                        });

                    });
                    
                }

            } else {
                $('.insapp_info').html(response.message)
                $('.insapp_info').css('display', 'block')

                $('.insapp_loader_ajax_container').removeClass('loading_slots')
            }

        })

    });


    var ia_extraTab = [];

    $('.insapp_extra_list').click(function () {
        ia_priceExtra = parseInt($('.ia_price_product_total').text());

        if ($(this).prop("checked")) {
            data = parseInt($(this).attr('data_calculate'));
            ia_priceExtra = ia_priceExtra + data
            $('.ia_price_product_total').text(ia_priceExtra);

        } else {
            var data = parseInt($(this).attr('data_calculate'));
            ia_priceExtra = ia_priceExtra - data
            $('.ia_price_product_total').text(ia_priceExtra);
        }


        var ia_checkedValue = $('.insapp_extra_list');

        ia_checkedValue.each(function () {
            if ($(this).is(":checked")) {
                if (!ia_extraTab.includes($(this).val())) {
                    ia_extraTab.push($(this).val());
                }
            } else {
                if (ia_extraTab.includes($(this).val())) {
                    ia_extraTab.splice(ia_extraTab.indexOf($(this).val()), 1);
                }
            }
        });

    });

    $('.insapp_btn_booking').on('click', function (e) {

        e.preventDefault();
        $('.insapp_button').attr("disabled", "disabled");
        $('.insapp_info').css("display", "none")
        $('.insapp_loader_ajax_btn').css("display", "block")

        let insapp_booking_date = $('.insapp_booking_date').val();
        let insapp_booking_time = $('.insapp_slot_value').val();

        let insapp_total = $('.ia_price_product_total').text()
        if (insapp_booking_date != '' && insapp_booking_time != '') {
            let service_id = $('#the_id').val()

            let data = {
                'action': 'reservation_service',
                'insapp_booking_date': insapp_booking_date,
                'insapp_booking_time': insapp_booking_time,
                'service_id': service_id,
                'Total_price': insapp_total,
                'extra': JSON.stringify(ia_extraTab)
            }

            jQuery.post(reservation_service_front_ajax.ajaxurl, data, function (response) {
                console.log(response);
                if (response.code == 200) { 
                       $('.insapp_form_booking').submit();
                        // e.currentTarget.submit()

                    localStorage.setItem('jstabs-opentab', 2)
                } else if (response.code == 200) {
                    $('.insapp_info').css("display", "block")
                        .html(response.message)
                        $('.insapp_loader_ajax_btn').css("display", "none")
                } else {
                    $('.insapp_info').css("display", "block")
                        .html('Une erreur s\'est produite veuillez contacter l\'administrateur')
                        $('.insapp_loader_ajax_btn').css("display", "none")

                 }
                $('.insapp_button').removeAttr("disabled")
            })
        } else {
            $('.insapp_info').css("display", "block")
                .html('Une date et une heure valide sont requises')
            $('.insapp_loader_ajax_btn').css("display", "none")
        }

    });



    /** services et reservations back-office */

    $('.btn_refuser').click(function () {
        let order_id = $(this).attr("data-id")
        let data = {
            'action': 'cancelled_order_status',
            'order_id': order_id,
        }
        console.log(data)

        jQuery.post(reservation_service_front_ajax.ajaxurl, data, function (response) {
            console.log(response);
            location.reload()
        })
    })
    $('.btn_refuser_client').click(function () {
        let order_id = $(this).attr("data-id")
        let data = {
            'action': 'cancelled_cient_order_status',
            'order_id': order_id,
        }

        console.log(data)

        jQuery.post(reservation_service_front_ajax.ajaxurl, data, function (response) {
            console.log(response);
            location.reload()
        })
    })


    $('.btn_delete').click(function () {
        let order_id = $(this).attr("data-id")

        let data = {
            'action': 'deleted_order_status',
            'order_id': order_id,
        }
        console.log(data)

        jQuery.post(reservation_service_front_ajax.ajaxurl, data, function (response) {
            console.log(response);
            location.reload()
        })
    })

    
    $('.btn_payment').click(function () {
        let order_id = $(this).attr("data-id")
        let product_id = $(this).attr("data-product-id")

        let data = {
            'action': 'payement_order_process',
            'order_id': order_id,
            'product_id': product_id,
        }
        console.log(data)

        jQuery.post(reservation_service_front_ajax.ajaxurl, data, function (response) {
            console.log(response)
            if(response){
                window.location.replace(response)
            }
        })
    })

    $('.btn_accepter').click(function () {
        let order_id = $(this).attr("data-id")
        let data = {
            'action': 'accepted_order_status',
            'order_id': order_id,
        }

        console.log(data)

        jQuery.post(reservation_service_front_ajax.ajaxurl, data, function (response) {
            console.log(response);
            location.reload()
        })
    })


    $('.btn_fini').click(function () {
        let order_id = $(this).attr("data-id")
        let data = {
            'action': 'achived_order_status',
            'order_id': order_id,
        }

        console.log(data)

        jQuery.post(reservation_service_front_ajax.ajaxurl, data, function (response) {
            console.log(response);
            location.reload()
        })
    })

    $('#insapp_etat').change(function () {
        let etat = $(this).val()
        let data = {
            'action': 'filter_state',
            'etat': etat,
        }

        console.log(data)

        jQuery.post(reservation_service_front_ajax.ajaxurl, data, function (response) {
            $('.insapp_resa_list').html(response);
            $('.btn_refuser').click(function () {
                let order_id = $(this).attr("data-id")
                let data = {
                    'action': 'cancelled_order_status',
                    'order_id': order_id,
                }

                console.log(data)

                jQuery.post(reservation_service_front_ajax.ajaxurl, data, function (response) {
                    console.log(response);
                })
            })


            $('.btn_delete').click(function () {
                let order_id = $(this).attr("data-id")
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
                            'action': 'deleted_order_status',
                            'order_id': order_id,
                        }
                        console.log(data)

                        jQuery.post(reservation_service_front_ajax.ajaxurl, data, function (response) {
                            console.log(response);
                        })
                    }
                })
            })

            // $('.btn_accepter').click(function () {
            //     let order_id = $(this).attr("data-id")
            //     let data = {
            //         'action': 'accepted_order_status',
            //         'order_id': order_id,
            //     }

            //     console.log(data)

            //     jQuery.post(reservation_service_front_ajax.ajaxurl, data, function (response) {
            //         console.log(response);
            //     })
            // })


            $('.btn_fini').click(function () {
                let order_id = $(this).attr("data-id")
                let data = {
                    'action': 'achived_order_status',
                    'order_id': order_id,
                }

                console.log(data)

                jQuery.post(reservation_service_front_ajax.ajaxurl, data, function (response) {
                    console.log(response);
                })
            })
        })

    })


    /*Delete service*/
    $('.btn_del').click(function () {
        let product_id = $(this).attr("data-id")
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-danger',
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
                    'action': 'delete_product',
                    'product_id': product_id,
                }

                console.log(data)

                jQuery.post(reservation_service_front_ajax.ajaxurl, data, function (response) {
                    console.log(response);
                    location.reload()

                })
            }
        })
    })


    /* Update service*/
    $('.btn_edit').click(function () {
        let product_id = $(this).attr("data-id")
        let data = {
            'action': 'update_product',
            'product_id': product_id,
        }

        console.log(data)

        jQuery.post(reservation_service_front_ajax.ajaxurl, data, function (response) {
            console.log(response);
            localStorage.setItem('jstabs-opentab', 10)
            // location.reload()
            $('#tab10').click()
            $('#product_id').val(response.id)
            $('#insapp_update_service_name').val(response.nom)
            $('#insapp_update_service_editor').html(response.description)
            $('#insapp_update_price_reg').val(response.reg_price)
            $('#insapp_update_price_sale').val(response.sale_price)
            $('#insapp_update_category').val(response.categorie)
            $('#insapp_update_duree').val(response.duree)
            // $('#tab_update_extra').val()
            $('#insapp_img_preview').append(response.image)
            if (response.extras != null) {
                e = response.extras
                console.log(e)
                e.forEach(extra => {
                    let _tr = document.createElement('tr');
                    let _tdM = document.createElement('td');
                    _tdM.innerHTML = extra.nom;
                    console.log(extra.nom)
                    let _tdN = document.createElement('td');
                    _tdN.innerHTML = extra.cout;
                    let _tdAction = document.createElement('td');
                    _tdAction.classList.add("justify-content-evenly");
                    _tdAction.classList.add("d-grid");
                    _tdAction.classList.add("gap-2");
                    _tdAction.classList.add("d-md-flex");
                    let _btnDele = document.createElement('button');
                    _btnDele.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke = "currentColor" stroke - width="2" stroke - linecap="round" stroke - linejoin="round" class="feather feather-trash-2 icon-xs"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg >';
                    _btnDele.classList.add("btn")
                    _btnDele.classList.add("btn-outline-danger")

                    _tdAction.appendChild(_btnDele);
                    _tr.appendChild(_tdM);
                    _tr.appendChild(_tdN);
                    _tr.appendChild(_tdAction);

                    document.getElementById('tab_update_extra').appendChild(_tr);
                    _btnDele.addEventListener('click', () => {
                        _tr.remove();
                    });
                });
            }
        })
    })

    $('.insapp_update_service').submit(function (e) {
        e.preventDefault()
        $('.insapp_update_service').attr("disabled", "disabled");

        let content_editor = $('#insapp_update_service_editor').html();
     
        image = $("#update_product_img")[0].files[0]; 

         
        let data
        if (console.log(Array.isArray(image))){
            data = {
                'action': "update_service_front",
                'service_name': $('#insapp_update_service_name').val(),
                // 'service_date_start': moment(date_start).format('Y-MM-DD'),
                // 'service_date_end': moment(date_end).format('Y-MM-DD'),
                'service_price_reg': $('#insapp_update_price_reg').val(),
                'service_price_sale': $('#insapp_update_price_sale').val(),
                'service_content': content_editor,
                'service_category': $('#insapp_update_category').val(),
                'service_duration': $('#insapp_update_duree').val(),
                'post_id': $('#product_id').val(),
                'extras': JSON.stringify(liste_extras_update),
                // 'crenaux': crenaux,
                'image_name': image.name,
                'image_type': image.type,
                'image_size': image.size,
                'image_url': $('.insapp_update_img_service_url').val(),


            }
        }else{
            data = {
                'action': "update_service_front",
                'service_name': $('#insapp_update_service_name').val(),
                // 'service_date_start': moment(date_start).format('Y-MM-DD'),
                // 'service_date_end': moment(date_end).format('Y-MM-DD'),
                'service_price_reg': $('#insapp_update_price_reg').val(),
                'service_price_sale': $('#insapp_update_price_sale').val(),
                'service_content': content_editor,
                'service_category': $('#insapp_update_category').val(),
                'service_duration': $('#insapp_update_duree').val(),
                'post_id': $('#product_id').val(),
                'extras': JSON.stringify(liste_extras_update),
                // 'crenaux': crenaux,
                // 'image_name': image.name,
                // 'image_type': image.type,
                // 'image_size': image.size,
                'image_url': $('.insapp_update_img_service_url').val(),


            }
        }

        jQuery.post(reservation_service_front_ajax.ajaxurl, data, function (response) {
            console.log(response);
            if (response.code == 200) {
                $.toast({
                    heading: 'success',
                    text: response.message,
                    showHideTransition: 'plain',
                    position: 'top-right',
                    icon: 'success',
                    hideAfter: 5000,

                });
                localStorage.setItem('jstabs-opentab', 8)
                location.reload()

            } else if (response.code == 400) {
                $.toast({
                    heading: 'error',
                    text: response.message,
                    showHideTransition: 'plain',
                    position: 'top-right',
                    icon: 'error',
                    hideAfter: 10000,
                });

                $('.insapp_register_service_btn').removeAttr("disabled")

            } else {
                $.toast({
                    heading: 'Warning',
                    text: response.message,
                    showHideTransition: 'plain',
                    position: 'top-right',
                    icon: 'warning',
                    hideAfter: 8000,
                });

                $('.insapp_register_service_btn').removeAttr("disabled")

            }



        })


    })

    $('.abonnement_payment').click(function () {

        let abonnement_id = $(this).attr("data-id")

        let data = {
            'action': 'payement_abonnement',
            'abonnement_id': abonnement_id,
        }
        console.log(data)

        jQuery.post(reservation_service_front_ajax.ajaxurl, data, function (response) {
            console.log(response)
            if (response) {
                window.location.replace(response.payment_code)
            }
        })
    })

    const fileInput = document.getElementById('update_product_img');

    if (fileInput != null) {
        fileInput.addEventListener('change', () => {

            const fr = new FileReader();
            fr.readAsDataURL(fileInput.files[0]);

            fr.addEventListener('load', () => {

                const url = fr.result;
                image_url = url
                // console.log(image_url)
                $('.insapp_update_img_service_url').val(image_url);

                const img = new Image();
                img.src = url;
            })


        });
    }


        // Initialize the DataTable
       $('#insapp_payement_orders_table').DataTable();
    
        // Handle the click event on the "Generate Invoice PDF" button
        $('#insapp_payement_orders_table').on('click', '.btn_generate_bill', function() {
            const orderId = $(this).attr('data-id');
            insapp_generateInvoicePDF(orderId);
        });

    function insapp_generateInvoicePDF(orderId){

        let data = {
            'action': 'orders_payement_bill', 
            'order_id':  orderId
        }

        console.log(data)

        jQuery.post(reservation_service_front_ajax.ajaxurl, data, function (response) {
            
            if (response.pdf_data) {
                // Convertir les données du PDF de base64 en Blob
                var pdfBlob = base64toBlob(response.pdf_data, 'application/pdf');
        
                // Créer un lien de téléchargement pour le fichier PDF
                var downloadLink = document.createElement('a');
                downloadLink.href = URL.createObjectURL(pdfBlob);
                downloadLink.download = 'Facture_' + orderId + '.pdf';
                downloadLink.click();
              } else {
                alert('Une erreur s\'est produite lors de la génération du PDF.');
              }
    
        })
    }

    function base64toBlob(base64Data, contentType) {
        contentType = contentType || '';
        var sliceSize = 1024;
        var byteCharacters = atob(base64Data);
        var byteArrays = [];
      
        for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
          var slice = byteCharacters.slice(offset, offset + sliceSize);
          var byteNumbers = new Array(slice.length);
      
          for (var i = 0; i < slice.length; i++) {
            byteNumbers[i] = slice.charCodeAt(i);
          }
      
          var byteArray = new Uint8Array(byteNumbers);
          byteArrays.push(byteArray);
        }
      
        var blob = new Blob(byteArrays, { type: contentType });
        return blob;
      }

 
 
});



