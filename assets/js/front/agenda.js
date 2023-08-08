// const { DEFAULT_BREAKPOINTS } = require("react-bootstrap/esm/ThemeProvider");

function addRow() {
    var table = document.getElementById("ia_timeTable");
    var row = table.insertRow();
    var cell1 = row.insertCell();
    var cell2 = row.insertCell();
    var cell3 = row.insertCell();
    cell1.innerHTML = '<input type="time" class="form-control" name="start_time[]" />';
    cell2.innerHTML = '<input type="time" class="form-control" name="end_time[]" />';
    cell3.innerHTML = '<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon-xs"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></button>';
}

function removeRow(button) {
    var row = button.parentNode.parentNode;
    var table = row.parentNode.parentNode;
    table.deleteRow(row.rowIndex);
}


document.addEventListener('DOMContentLoaded', function () {

    jQuery(document).ready(function ($) {

        $('.ia_calendar_step').click(function (e) {
            e.preventDefault();

            $('.insapp_notification_agenda').css('display', 'none') 
            $('.insapia_calendar_stepp_btn').attr("disabled", "disabled");

            $('.insapp_loader_ajax_containeradmin').css('display', 'block')
            $('.ia_calendar_block').css('display', 'none')
            $('.ia_calendar_content').css('min-height', '100px') 
            
            if ($('.ia_time_start_step').val() != '' && $('.ia_time_end_step').val() != ''){
       
                var selected = [];
                $('#ia_checkboxes input:checked').each(function () {
                    selected.push($(this).attr('name'));
                });

                let data = {
                    'action': "agenda_step_default_ajax",
                    'user_id': $('.insapp_user').val(),
                    'agenda_default': selected,
                    'starthour': $('.ia_time_start_step').val(),
                    'endhour': $('.ia_time_end_step').val(),
                    'starthour2': $('.ia_time_start_step2').val(),
                    'endhour2': $('.ia_time_end_step2').val(),
                } 

                jQuery.post(insapp_agenda_ajax.ajaxurl, data, function (response) {

                        let starthours = response.data.starthours
                        let endhours = response.data.endhours
                        let starthours2 = response.data.starthours2
                        let endhours2 = response.data.endhours2

                        var timeStarthours = starthours.split(":")[0];
                        var timeStartminutes = starthours.split(":")[1];

                        var timeEndhours = endhours.split(":")[0];
                        var timeEndtminutes = endhours.split(":")[1];

                        var timeStarthours2 = starthours2.split(":")[0];
                        var timeStartminutes2 = starthours2.split(":")[1];

                        var timeEndhours2 = endhours2.split(":")[0];
                        var timeEndtminutes2 = endhours2.split(":")[1];

                         removeAllEventSources();

                        if (response.data.success == true) {

                            var workingDays = response.data.agenda_default;
                            var events = [];
                            workingDays.forEach(function (day) {

                                switch (day) {

                                    case 'lundi':
                                        for (var d = moment().startOf('week').add(1, 'days'); d.isBefore(moment().endOf('quarter')); d.add(1, 'week')) {
                                            events.push({
                                                title: 'crénaux',
                                                start: d.clone().hours(parseInt(timeStarthours)).format('YYYY-MM-DDTHH:mm:ss'),
                                                end: d.clone().hours(parseInt(timeEndhours)).format('YYYY-MM-DDTHH:mm:ss'),
                                                color: 'blueviolet',   // an option!
                                                textColor: 'white'
                                            });

                                            events.push({
                                                title: 'crénaux',
                                                start: d.clone().hours(parseInt(timeStarthours2)).format('YYYY-MM-DDTHH:mm:ss'),
                                                end: d.clone().hours(parseInt(timeEndhours2)).format('YYYY-MM-DDTHH:mm:ss'),
                                                color: 'blueviolet',   // an option!
                                                textColor: 'white'
                                            });
                                        }
                                        break;
                                    case 'mardi':
                                        for (var d = moment().startOf('week').add(2, 'days'); d.isBefore(moment().endOf('quarter')); d.add(1, 'week')) {
                                            events.push({
                                                title: 'crénaux',
                                                start: d.clone().hours(parseInt(timeStarthours)).format('YYYY-MM-DDTHH:mm:ss'),
                                                end: d.clone().hours(parseInt(timeEndhours)).format('YYYY-MM-DDTHH:mm:ss'),
                                                color: 'blueviolet',   // an option!
                                                textColor: 'white',
                                                eventBackgroundColor: 'blueviolet'
                                            });

                                            events.push({
                                                title: 'crénaux',
                                                start: d.clone().hours(parseInt(timeStarthours2)).format('YYYY-MM-DDTHH:mm:ss'),
                                                end: d.clone().hours(parseInt(timeEndhours2)).format('YYYY-MM-DDTHH:mm:ss'),
                                                color: 'blueviolet',   // an option!
                                                textColor: 'white'
                                            });


                                        }
                                        break;
                                    case 'mercredi':
                                        for (var d = moment().startOf('week').add(3, 'days'); d.isBefore(moment().endOf('quarter')); d.add(1, 'week')) {
                                            events.push({
                                                title: 'crénaux',
                                                start: d.clone().hours(parseInt(timeStarthours)).format('YYYY-MM-DDTHH:mm:ss'),
                                                end: d.clone().hours(parseInt(timeEndhours)).format('YYYY-MM-DDTHH:mm:ss'),
                                                color: 'blueviolet',   // an option!
                                                textColor: 'white',
                                                eventBackgroundColor: 'blue'
                                            });
                                            events.push({
                                                title: 'crénaux',
                                                start: d.clone().hours(parseInt(timeStarthours2)).format('YYYY-MM-DDTHH:mm:ss'),
                                                end: d.clone().hours(parseInt(timeEndhours2)).format('YYYY-MM-DDTHH:mm:ss'),
                                                color: 'blueviolet',   // an option!
                                                textColor: 'white'
                                            });
                                        }
                                        break;

                                    case 'jeudi':
                                        for (var d = moment().startOf('week').add(4, 'days'); d.isBefore(moment().endOf('quarter')); d.add(1, 'week')) {
                                            events.push({
                                                title: 'crénaux',
                                                start: d.clone().hours(parseInt(timeStarthours)).format('YYYY-MM-DDTHH:mm:ss'),
                                                end: d.clone().hours(parseInt(timeEndhours)).format('YYYY-MM-DDTHH:mm:ss'),
                                                color: 'blueviolet',   // an option!
                                                textColor: 'white'
                                            });
                                            events.push({
                                                title: 'crénaux',
                                                start: d.clone().hours(parseInt(timeStarthours2)).format('YYYY-MM-DDTHH:mm:ss'),
                                                end: d.clone().hours(parseInt(timeEndhours2)).format('YYYY-MM-DDTHH:mm:ss'),
                                                color: 'blueviolet',   // an option!
                                                textColor: 'white'
                                            });
                                        }
                                        break;
                                    case 'vendredi':
                                        for (var d = moment().startOf('week').add(5, 'days'); d.isBefore(moment().endOf('quarter')); d.add(1, 'week')) {
                                            events.push({
                                                title: 'crénaux',
                                                start: d.clone().hours(parseInt(timeStarthours)).format('YYYY-MM-DDTHH:mm:ss'),
                                                end: d.clone().hours(parseInt(timeEndhours)).format('YYYY-MM-DDTHH:mm:ss'),
                                                color: 'blueviolet',   // an option!
                                                textColor: 'white'
                                            });
                                            events.push({
                                                title: 'crénaux',
                                                start: d.clone().hours(parseInt(timeStarthours2)).format('YYYY-MM-DDTHH:mm:ss'),
                                                end: d.clone().hours(parseInt(timeEndhours2)).format('YYYY-MM-DDTHH:mm:ss'),
                                                color: 'blueviolet',   // an option!
                                                textColor: 'white'
                                            });
                                        }
                                        break;
                                    case 'samedi':
                                        for (var d = moment().startOf('week').add(6, 'days'); d.isBefore(moment().endOf('quarter')); d.add(1, 'week')) {
                                            events.push({
                                                title: '',
                                                start: d.clone().hours(parseInt(timeStarthours)).format('YYYY-MM-DDTHH:mm:ss'),
                                                end: d.clone().hours(parseInt(timeEndhours)).format('YYYY-MM-DDTHH:mm:ss'),
                                                color: 'blueviolet',   // an option!
                                                textColor: 'white'
                                            });
                                            events.push({
                                                title: 'crénaux',
                                                start: d.clone().hours(parseInt(timeStarthours2)).format('YYYY-MM-DDTHH:mm:ss'),
                                                end: d.clone().hours(parseInt(timeEndhours2)).format('YYYY-MM-DDTHH:mm:ss'),
                                                color: 'blueviolet',   // an option!
                                                textColor: 'white'
                                            });
                                        }
                                        break;
                                    case 'dimanche':
                                        for (var d = moment().startOf('week').add(0, 'days'); d.isBefore(moment().endOf('quarter')); d.add(1, 'week')) {
                                            events.push({
                                                title: '',
                                                start: d.clone().hours(parseInt(timeStarthours)).format('YYYY-MM-DDTHH:mm:ss'),
                                                end: d.clone().hours(parseInt(timeEndhours)).format('YYYY-MM-DDTHH:mm:ss'),
                                                color: 'blueviolet',   // an option!
                                                textColor: 'white'
                                            });
                                            events.push({
                                                title: 'crénaux',
                                                start: d.clone().hours(parseInt(timeStarthours2)).format('YYYY-MM-DDTHH:mm:ss'),
                                                end: d.clone().hours(parseInt(timeEndhours2)).format('YYYY-MM-DDTHH:mm:ss'),
                                                color: 'blueviolet',   // an option!
                                                textColor: 'white'
                                            });
                                        }
                                        break;

                                    default:

                                        break;
                                }

                            });

                            calendarinsapp.addEventSource(events);

                            refreshCalendar();
                            $('.insapp_btn').removeAttr("disabled"); 


                        } else {
                            $('.insapp_btn').removeAttr("disabled");
                            $('.insapp_notification_agenda').css('display', 'flex')
                            $('.insapp_notification_agenda').html('une erreur c\'est produite veuillez réessayer')
                        }

                        $('.insapp_loader_ajax_containeradmin').css('display', 'none')
                        $('.ia_calendar_block').css('display', 'flex')
                        $('.ia_calendar_content').css('min-height', '1000px')

                });
            } else {

                $('.insapp_btn').removeAttr("disabled");
                $('.insapp_notification_agenda').css('display', 'flex')
                $('.insapp_notification_agenda').html('Veuillez remplir tous les champs')

            }


        });


    });
    function refreshCalendar() {
        calendarinsapp.refetchEvents();
    }

    var calendarEl = document.getElementById('insapp-calendar-agenda');

    var calendarinsapp = new FullCalendar.Calendar(calendarEl, {
        customButtons: {
            myCustomButton: {
                text: 'Enregistrer',
                click: function () {
                    insapp_sendEventList();;
                }
            }
        },
        headerToolbar: {
            left: 'prev,next ,today',
            center: 'title',
            right: 'myCustomButton dayGridMonth,listMonth',
        },
        initialView: 'dayGridMonth',
        locale: 'fr',
        allDayText: 'Jours',
        weekends: true,
        buttonText: {
            today: 'Aujourd\'hui',
            month: 'Mois', 
            list: 'liste'
        },
        initialDate: new Date(),
        navLinks: true, // can click day/week names to navigate views
        businessHours: true,
        selectable: true,
        eventContent: function (info) {
            var startTime = '';
            var endTime = '';
            if (info.event.start && info.event.end) {
                startTime = info.event.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                endTime = info.event.end.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            } 
            var eventColor = info.event.backgroundColor;
            var textColor = info.event.textColor;

            return {
                html: '<div class="event-wrapper insapp_calendar_style" style="background-color: ' + eventColor + '; color: ' + textColor + ';">' +
                    '<span>' + startTime + ' - ' + endTime + '</span>' + '</div>',
                display: 'block'
            };

        },
        dateClick: function (info) {
            var dateClicked = info.date;
            afficherFormulaireModal(dateClicked);
        },
        eventSources: [

            {
                url: insapp_agenda_ajax.ajaxurl, // L'URL de l'endpoint AJAX
                extraParams: {
                    action: 'select_default_agenda',
                    param1: document.getElementsByClassName('insapp_user')[0].value,
                },
                method: 'GET',
                success: function (response) {
             
                    workingDays = response.data
                    var eventsouces = []
                    workingDays.forEach(function (day) { 
                        date = day.date_event 
                        ing = JSON.parse(JSON.stringify(day.star_time))
                        net = ing.replace(/[{\"\]} ]/g, "")
                        str = net.split(",") 

                        var timeStart = str[0]
                        var timeEnd = str[1] 
                        
                        eventsouces.push({
                            title: 'crénaux',
                            start: moment(date).hours(parseInt(timeStart)).format('YYYY-MM-DDTHH:mm:ss'),
                            end: moment(date).hours(parseInt(timeEnd)).format('YYYY-MM-DDTHH:mm:ss'),
                            color: 'blueviolet',
                            textColor: 'white'
                        });
                     
                    });

                    calendarinsapp.addEventSource(eventsouces);
                    // if(response.data.success == true){ 

                    // }else{

                    //   alert('echec');
                    // }
                },
                failure: function () {
                    alert('echec');
                }

            }
        ],
        eventRender: function (info) {
            // Créer un élément HTML pour afficher l'événement
            var eventElement = document.createElement('div');
            eventElement.classList.add('event');
            eventElement.textContent = info.event.title;

            // Ajouter l'élément à la cellule correspondant à la date de l'événement
            info.el.appendChild(eventElement);
        },
        //    dayCellContent: function(info, create) {

        //     const element = create('button', { id:info.date }, '+'); 

        //     return element;
        // }, 
        // select: function(arg) {

        //     addEditEventModal.show()
        //   var title = prompt('Event Title:');
        //   if (title) {
        //     calendarinsapp.addEvent({
        //       title: title,
        //       start: arg.start,
        //       end: arg.end,
        //       allDay: arg.allDay
        //     })
        //   }
        //   calendarinsapp.unselect()

        // },
        eventClick: function (arg) {
            if (confirm('Are you sure you want to delete this event?')) {
                arg.event.remove()
            }
        },
        // dayMaxEvents: true,
        // events: function(fetchInfo, successCallback, failureCallback) { 
        //   var events = [];


        //   // Événements pour les lundis
        //   for (var d = moment().startOf('week').add(1, 'days'); d.isBefore(moment().endOf('year')); d.add(1, 'week')) {
        //     events.push({
        //       title: 'Disponibilité par défaut pour les lundis',
        //       start: d.clone().hours(9),
        //       end: d.clone().hours(17), 
        //       backgroundColor: 'green',
        //     });
        //   }

        //   // Événements pour les mercredis
        //   for (var d = moment().startOf('week').add(3, 'days'); d.isBefore(moment().endOf('year')); d.add(1, 'week')) {
        //     events.push({
        //       title: 'Disponibilité par défaut pour les mercredis',
        //       start: d.clone().hours(10),
        //       end: d.clone().hours(18), 
        //       backgroundColor: 'green',
        //     });
        //   } 
        //   successCallback(events);
        // },
        // events: [ 
        //     // Exemple de créneaux horaires par défaut
        //     {
        //       title: 'Créneau 1',
        //       start: '2023-07-01T09:00:00',
        //       end: '2023-07-01T10:00:00'
        //     },
        //     {
        //       title: 'Créneau 2',
        //       start: '2023-07-01T11:00:00',
        //       end: '2023-07-01T12:00:00'
        //     },
        //     {
        //       title: 'Disponibilité par défaut pour les lundis',
        //       start: '2023-07-06T09:00:00',
        //       end: '2023-07-06T10:00:00', 
        //       backgroundColor:"green",

        //     },
        //     {
        //       start: '2023-07-06T09:00:00',
        //        end: '2023-07-06T10:00:00', 
        //       backgroundColor: '#ooo',
        //       title :'test'
        //     },
        //     {
        //       title: '',
        //       start: '2023-07-06T11:00:00',
        //       end: '2023-07-06T12:00:00'
        //     },  

        // ],




    });

    calendarinsapp.render();
    
    function removeAllEventSources() {
        var eventSources = calendarinsapp.getEventSources();
        eventSources.forEach(function (source) {
            source.remove();
        });
    }

    // Fonction pour afficher le formulaire modal
    function afficherFormulaireModal(date) {
        var modal = new bootstrap.Modal(document.getElementById('insapp_creneauModal'));
        modal.show(); 

        var formcrenaux = document.getElementById('insapp_creneauForm');
        document.body.contains(formcrenaux) && formcrenaux.addEventListener("submit", function (e) {

            e.preventDefault();
            var timeStart = jQuery('.ia_time_start_new').val()
            var timeEnd = jQuery('.ia_time_end_new').val()

            var newslot = {
                title: 'crénaux',
                start: moment(date).hours(parseInt(timeStart)).format('YYYY-MM-DDTHH:mm:ss'),
                end: moment(date).hours(parseInt(timeEnd)).format('YYYY-MM-DDTHH:mm:ss'),
                color: 'blueviolet',
                textColor: 'white'
            };

            Sendtimeslot(newslot);
            calendarinsapp.addEvent(newslot);
            formcrenaux.reset()
            modal.hide();
        });
    }

    function insapp_getEventList() {
        var events = calendarinsapp.getEvents();

        var eventData = events.map(function (event) {
            return {
                date: moment(event.start).format('YYYY-MM-DD'),
                times: moment(event.start).format('HH:mm') + ',' + moment(event.end).format('HH:mm'),
            };
        });
        return eventData;
    }

    function insapp_sendEventList() {
        var eventData = insapp_getEventList();

        let data = {
            'action': "ajax_insert_agenda",
            'events': eventData,
            'user_id': jQuery('.insapp_user').val(),
        }

        jQuery.post(insapp_agenda_ajax.ajaxurl, data, function (response) {

            if (response.success == true) {

                $.toast({
                    heading: 'success',
                    text: response.data.message,
                    showHideTransition: 'plain',
                    position: 'top-right',
                    icon: 'success',
                    hideAfter: 5000,
                });

            } else {
                $.toast({
                    heading: 'Warning',
                    text: response.data.message,
                    showHideTransition: 'plain',
                    position: 'top-right',
                    icon: 'warning',
                    hideAfter: 8000,
                });
            }
        });

    }
    function Sendtimeslot(eventData) { 
        eventData = {
            date: moment(eventData.start).format('YYYY-MM-DD'),
            times: moment(eventData.start).format('HH:mm') + ', ' + moment(eventData.end).format('HH:mm'),
        }; 

        let data = {
            'action': "ajax_insert_unique_agenda",
            'events': eventData,
            'user_id': jQuery('.insapp_user').val(),
        }
        

        jQuery.post(insapp_agenda_ajax.ajaxurl, data, function (response) {

                   if (response.success == true) {
                location.reload();


            } else {
                alert('error');
            }
        });

    }
});


   

jQuery(document).ready(function ($) {

    

var conversation_id = $('.contacts-link').attr('date-id');

        $height = $(document).height();
        console.log( $height);

        $("#insapp_conversation_list").animate(
            {
                scrollTop: document.body.clientHeight + $(this).height()
            }
        );
        
        // $("#insapp_conversation_list").scrollTop($height );

        setInterval(function() {

            $("#insapp_conversation_list").load("https://localhost/wordpress/insapp_chat/",{ conversation_id:conversation_id })
            // $("#insapp_conversation_list").load(window.location.href + "#insapp_conversation_list");
            // $('#insapp_conversation_list').load('#insapp_conversation_list')
            console.log('conversation_id');
            var cList = document.querySelector("#insapp_conversation_list")
            cList.scrollTop=cList.scrollHeight
        }, 15000);
    
        
    
    $('.contacts-link').click(function (){
        conversation_id = $(this).attr('date-id');  
        receiver_id = $(this).attr('date-r');  
   
         $("#insapp_conversation_list").attr('data-id',conversation_id);

        getChatMessages(conversation_id, receiver_id)

    });
    
    $('#chatinput-form').submit(function (e) { 
        e.preventDefault();
        var cList = document.querySelector("#insapp_conversation_list")
        content = $("#insapp_chat_input").val()
        time=(e=new Date).getHours()+":"+e.getMinutes();
        senderId = $(".insapp_chat_sender").val();
        receiverId = $(".insapp_chat_receiver").val();
        conversation_id = $("#insapp_conversation_list").attr('data-id');
        if (content !== '') {
        cList.insertAdjacentHTML("beforeend",'<div class="d-flex justify-content-end mb-4" id="chat-item-'+l+`">
        <div class="d-flex">
            <div class=" me-3 text-end">
                <small>`+time+`</small>
                <div class="d-flex">
                    <div class="me-2 mt-2">
                    </div>
                    <div
                        class="card mt-2 rounded-top-md-end-0 bg-primary text-white">
                        <div class="card-body text-start p-3">
                            <p class="mb-0">`+content+`</p>
                        </div>
                    </div>
                </div>
            </div>
              </div>
    </div>`);
        cList.scrollTop=cList.scrollHeight

            insapp_sendChatMessage(senderId, receiverId, content,conversation_id)
          $('#insapp_chat_input').val(''); 
        }
    
    
    });

    function insapp_sendChatMessage(senderId, receiverId, message, conversation_id) {
        let data ={
            action: 'insapp_send_chat_message',
            sender_id: senderId,
            receiver_id: receiverId,
            conversation_id : conversation_id,
            message: message,
        } 
        console.log(data); 
       
        jQuery.post(insapp_agenda_ajax.ajaxurl,data,function(response) {        
            console.log(response);
            
        });
    }

    function getChatMessages(conversation_id, receiver_id) {
        var cList = document.querySelector("#insapp_conversation_list")
        card = $(".insapp_discussion_space")

        let data ={
            action: 'insapp_get_chat_conversation', 
            conversation_id : conversation_id, 
            receiver_id : receiver_id
        } 
        console.log(data); 
       
        jQuery.post(insapp_agenda_ajax.ajaxurl,data,function(response) {
       
            card.html(response);
            cList.scrollTop=cList.scrollHeight

            
        });
    }
    // let sendbtn = $('#chatinput-form')
    // let contact = $('.contacts-link')
    // a=document.querySelector("#conversation-list"),
    // console.log(sendbtn );
//     sendbtn.click(function () { 
//         console.log('smms');
//         document.body.contains(sendbtn) && sendbtn.addEventListener("submit",function(e){
//             e.preventDefault();
//             e=(e=new Date).getHours()+":"+e.getMinutes();
//             a.insertAdjacentHTML("beforeend",
//             '<div class="d-flex justify-content-end mb-4" id="chat-item-'+l+`">
//                   <div class="d-flex">
//                       <div class=" me-3 text-end">
//                           <small>`+e+`</small>
//                           <div class="d-flex">
//                                 <div class="me-2 mt-2">
//                                     <div class="dropdown dropstart">
//                                         <a class="btn btn-ghost btn-icon btn-sm rounded-circle" href="#!" role="button"
//                                             id="dropdownMenuLinkTwo" data-bs-toggle="dropdown"
//                                             aria-haspopup="true" aria-expanded="false">
//                                                 <i  data-feather="more-vertical" class="icon-xs"></i>
//                                         </a>
//                                         <div class="dropdown-menu" aria-labelledby="dropdownMenuLinkTwo">
//                                             <a class="dropdown-item" href="#!">
//                                                 <i class="dropdown-item-icon" data-feather="copy" ></i>Copy</a>
//                                             <a class="dropdown-item" href="#!"> 
//                                                 <i class="dropdown-item-icon" data-feather="edit" ></i> Edit</a>
//                                             <a class="dropdown-item" href="#!">
//                                                 <i class="dropdown-item-icon" data-feather="corner-up-right" ></i>Reply</a>
//                                             <a class="dropdown-item" href="#!">
//                                                 <i class=" dropdown-item-icon" data-feather="corner-up-left" ></i>Forward</a>
//                                             <a class="dropdown-item" href="#!">
//                                                 <i class="dropdown-item-icon" data-feather="star" ></i>Favourite</a>
//                                             <a class="dropdown-item" href="#!">
//                                                 <i class="dropdown-item-icon" data-feather="trash" ></i>Delete
//                                             </a>
//                                         </div>
//                                     </div>
//                                 </div>
//                                 <div class="card mt-2 rounded-top-md-end-0 bg-primary text-white">
//                                     <div class="card-body text-start p-3">
//                                     <p class="mb-0">`+t.value+`</p>
//                                 </div>
//                             </div>
//                          </div>
//                    </div>
//                 <img src="../assets/images/avatar/avatar-11.jpg" alt="Image" class="rounded-circle avatar-md" />
//               </div>
//            </div>`),
// a.scrollTop=a.scrollHeight,
// feather.replace(),u(),l++})
//     })
        
    
// });

    const chatMessages = [
        { sender: 'John', message: 'Hi there!' },
        { sender: 'Jane', message: 'Hello! How can I help you?' },
      ];

        // function displayMessages() {
        //     const chatMessagesDiv = $('#chatMessages');
        //     chatMessagesDiv.empty(); // Clear previous messages
        
        //     for (const message of chatMessages) {
        //     const messageDiv = $('<div>').addClass('message');
        //     const senderSpan = $('<span>').addClass('sender').text(message.sender);
        //     const messageSpan = $('<span>').addClass('message-content').text(message.message);
        
        //     messageDiv.append(senderSpan, messageSpan);
        //     chatMessagesDiv.append(messageDiv);
        //     }
        
        //     // Scroll to the bottom to show the latest message
        //     chatMessagesDiv.scrollTop(chatMessagesDiv[0].scrollHeight);
        // }
 
   
    
        
    
        // Example usage:
        // sendChatMessage(senderId, receiverId, 'Hello, how are you?');
        // getChatMessages(senderId, receiverId); // Call this function periodically to get new messages


});
