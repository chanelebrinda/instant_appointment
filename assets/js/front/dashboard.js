function Extra(_libelle = '', cout_extra = 0) {
    this.nom = _libelle;
    this.cout = cout_extra;
}
let liste_extras = [];
let _addExtraButton = document.getElementById('btn_addM');
if (_addExtraButton != null) {
    _addExtraButton.addEventListener('click', function () {
        let nom_extra = document.getElementById('nom_extra').value;
        let cout_extra = document.getElementById('cout_extra').value;

        let extra = new Extra(nom_extra, cout_extra);
        liste_extras.push(extra);
        console.log(liste_extras);

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
        let _btnMore = document.createElement('button');
        _btnMore.innerHTML = '';
        _btnMore.classList.add("btn");
        _btnMore.classList.add("btn-outline-primary");

        // _tdAction.appendChild(_btnMore);
        _tdAction.appendChild(_btnDele);
        _tr.appendChild(_tdM);
        _tr.appendChild(_tdN);
        _tr.appendChild(_tdAction);

        document.getElementById('tab_extra').appendChild(_tr);


        document.getElementById('nom_extra').value = '';
        document.getElementById('cout_extra').value = '';

        _btnDele.addEventListener('click', () => {
            _tr.remove();
        });
    });
}
jQuery(document).ready(function ($) {
    const tabs = document.querySelectorAll('.ins_dashbord_menu')
    const tabContents = document.querySelectorAll('.insapp_content_dashbord')
    // Functions
    const activateTab = tabnum => {

        tabs.forEach(tab => {
            tab.classList.remove('ins_active')
        })

        tabContents.forEach(tabContent => {
            tabContent.classList.remove('insapp_div_active')
        })

        document.querySelector('#tab' + tabnum).classList.add('ins_active')
        document.querySelector('#insapp_tab' + tabnum).classList.add('insapp_div_active')
        localStorage.setItem('jstabs-opentab', JSON.stringify(tabnum))

    }

    // Event Listeners
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            activateTab(tab.dataset.tab)
            console.log(tab.dataset.tab)

        })
    })


    var opentab = JSON.parse(localStorage.getItem('jstabs-opentab')) || '1'
    console.log(opentab);
    activateTab(opentab)

    const fileInput = document.getElementById('product_img');
    const preview = document.getElementById('preview');

    // $('.ins_dashbord_menu').on('click', function () {
    //     $(this).child().addClass('ins_active');
    // });


    $('.insapp_register_service').submit(function (e) {

        e.preventDefault();
        $('.insapp_register_service_btn').attr("disabled", "disabled");

        let content_editor = $('.ql-editor').html();
        let date_start = $('#insapp-date-start').val();
        let date_end = $('#insapp-date-start').val();
        image = $("#product_img")[0].files[0];

        let data = {
            'action': "add_service_front",
            'service_name': $('#insapp_service_name').val(),
            'service_date_start': moment(date_start).format('Y-MM-DD'),
            'service_date_end': moment(date_end).format('Y-MM-DD'),
            'service_price_reg': $('#insapp_price_reg').val(),
            'service_price_sale': $('#insapp_price_sale').val(),
            'service_content': content_editor,
            'service_category': $('#insapp_category').val(),
            'service_duration': $('#insapp_duree').val(),
            'service_author': $('.insapp_user').val(),
            'extras': JSON.stringify(liste_extras),
            // 'crenaux': crenaux,
            'image_name': image.name,
            'image_type': image.type,
            'image_size': image.size,
            'image_url': $('.insapp_img_service_url').val(),


        }

        jQuery.post(service_front_ajax.ajaxurl, data, function (response) {
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


    });

    fileInput.addEventListener('change', () => {

        const fr = new FileReader();
        fr.readAsDataURL(fileInput.files[0]);

        fr.addEventListener('load', () => {

            const url = fr.result;
            image_url = url
            $('.insapp_img_service_url').val(image_url);
            const img = new Image();
            img.src = url;
        })


    });
 
})
