var DU = {};
(function () {
    DU.appointment = {
        calendar: null,
        selectors: {
            appointmentModal: jQuery('#New_appointment'),
            clientCardModal:  jQuery('#Client_card'),
        },
        init: function (){
            this.addHandler();
        },

        addHandler: function (){
            var context = this;

            context.initialCalender();
            context.openAppointmentModal();
            context.changeServices();
            context.selecedServices();
            context.removeSelectedServices();
            // context.searchClient();
            // context.searchClientModal();
            context.appointmentSaveBtn();
            context.staffList();
            context.openClientCardModal();
            context.closeClientCardModal();

            $('#clientmodal').hide();
            $('#service_error').hide();
            // $("#external-events").draggable()
        },

        initialCalender: function(){
            const draggableElements = document.querySelectorAll('.fc-event');
            var context     = this,
                Draggable   = FullCalendar.Draggable;
                containerEl = document.getElementById('external-events');

                new Draggable(containerEl, {
                    itemSelector: '.fc-event',
                    eventData: function (eventEl) {
                    var dataset = eventEl.dataset;
                    return {
                        title: eventEl.innerText,
                        extendedProps:{
                            client_name :dataset.client_name,
                            service_id  :dataset.service_id,
                            client_id   :dataset.client_id,
                            category_id :dataset.category_id,
                            duration    :dataset.duration,
                        }
                    };
                }
            });

            // Calender
            var calendarEl = document.getElementById('calendar');
                context.calendar = new FullCalendar.Calendar(calendarEl, {
                selectable: true,
                editable: true,
                droppable: true,
                aspectRatio: 1.8,
                forceEventDuration: true,
                defaultAllDayEventDuration: "01:00",
                initialView: 'resourceTimeGridDay',
                buttonText: {
                    today: 'Today',
                    day: 'Daily',
                    week: 'Weekly',
                    month: 'Monthly',
                    year: 'Year',
                },
                headerToolbar: {
                    left: 'prev,today,next',
                    center: 'title',
                    right: 'resourceTimeGridDay,resourceTimeGridWeek,dayGridMonth,resourceTimelineYear'
                },

                datesSet: function (info) {
                    // info.start and info.end represent the new date range
                    var start_date  = moment(info.startStr).format('YYYY-MM-DD'),
                        end_date    = moment(info.endStr).format('YYYY-MM-DD');

                    // Make an AJAX call to fetch events for the new date range
                    context.eventsList(start_date, end_date);
                },
                loading: function (isLoading) {
                    // console.log(isLoading);
                    // if (isLoading) {
                    //   // Show loader
                    //   $('#loader').show();
                    // } else {
                    //   // Hide loader
                    //   $('#loader').hide();
                    // }
                },
                resources: [],
                resourceAreaHeaderContent: 'Staff Name',
                events: [
                    // {
                    //     resourceId: 22,
                    //     title: "Long Event",
                    //     start: "2024-02-07",
                    //     end: "2024-02-10"
                    // },
                    // {
                    //     "groupId": 23,
                    //     "resourceId": "a",
                    //     "title": "Repeating Event",
                    //     "start": "2024-02-09T16:00:00+00:00"
                    // },
                    // {
                    //     "resourceId": "a",
                    //     "title": "Conference",
                    //     "start": "2024-02-06",
                    //     "end": "2024-02-08"
                    // },
                    // {
                    //     "resourceId": "b",
                    //     "title": "Meeting",
                    //     "start": "2024-02-07T10:30:00+00:00",
                    //     "end": "2024-02-07T12:30:00+00:00"
                    // },
                    // {
                    //     "resourceId": "a",
                    //     "title": "Lunch",
                    //     "start": "2024-02-07T12:00:00+00:00"
                    // },
                    // {
                    //     "resourceId": "b",
                    //     "title": "Birthday Party",
                    //     "start": "2024-02-08T07:00:00+00:00"
                    // }
                    // {
                    //     title: 'BCH237',
                    //     start: '2024-08-12T10:30:00',
                    //     end: '2024-08-12T11:30:00',
                    //     extendedProps: {
                    //       department: 'BioChemistry'
                    //     },
                    //     description: 'Lecture'
                    // }
                ],
                drop: function(info) {
                    info.draggedEl.parentNode.removeChild(info.draggedEl);
                    // $("#external-events").remove();
                },
                eventReceive: function (info) {
                    var resourceId          = info.event._def.resourceIds[0],
                        start_date          = moment(info.event.startStr).format('YYYY-MM-DD'),
                        client_id           = info.event.extendedProps.client_id,
                        service_id          = info.event.extendedProps.service_id,
                        category_id         = info.event.extendedProps.category_id,
                        duration            = info.event.extendedProps.duration,
                        start_time          = moment(info.event.startStr).format('YYYY-MM-DDTHH:mm:ss'),
                        end_time            = moment(start_time).add(duration,'minutes').format('YYYY-MM-DDTHH:mm:ss');

                        context.createAppointmentDetails(resourceId,start_date,start_time,end_time,duration,client_id,service_id,category_id);
                },
                eventDrop: function (events) {
                    var resourceId          = events.event._def.resourceIds[0],
                        eventId             = events.event._def.publicId,
                        start_date          = moment(events.event.startStr).format('YYYY-MM-DD'),
                        // duration            = events.event.extendedProps.duration,
                        start_time          = moment(events.event.startStr).format('YYYY-MM-DDTHH:mm:ss'),
                        end_time            = moment(events.event.endStr).format('YYYY-MM-DDTHH:mm:ss'),
                        client_id           = events.event.extendedProps.client_id,
                        service_id          = events.event.extendedProps.service_id,
                        category_id         = events.event.extendedProps.category_id;
                    // console.log(duration);
                    // For difference between two dates -> duration
                    var start_time_diff     = moment(events.event.startStr),
                        end_time_diff       = moment(events.event.endStr),
                        durationInMinutes   = end_time_diff.diff(start_time_diff, 'minutes');

                        context.updateAppointmentDetails(resourceId,start_date,start_time,end_time,durationInMinutes,client_id,service_id,category_id,eventId);
                },
                eventResize: function(events) {
                    var resourceId          = events.event._def.resourceIds[0],
                        start_date          = moment(events.event.startStr).format('YYYY-MM-DD'),
                        eventId             = events.event._def.publicId,
                        // duration            = events.event.extendedProps.duration,
                        start_time          = moment(events.event.startStr).format('YYYY-MM-DDTHH:mm:ss'),
                        end_time            = moment(events.event.endStr).format('YYYY-MM-DDTHH:mm:ss'),
                        client_id           = events.event.extendedProps.client_id,
                        service_id          = events.event.extendedProps.service_id;
                        category_id         = events.event.extendedProps.category_id;

                    var start_time_diff     = moment(events.event.startStr),
                        end_time_diff       = moment(events.event.endStr),
                        durationInMinutes   = end_time_diff.diff(start_time_diff, 'minutes');

                        context.updateAppointmentDetails(resourceId,start_date,start_time,end_time,durationInMinutes,client_id,service_id,category_id,eventId);
                },
                eventDidMount: function(info)
                {
                    //info.el.innerHTML += info.event.extendedProps.description;
                },
                eventContent: function (info)
                {
                    let italicEl = document.createElement('i');

                    italicEl.innerHTML = `<i>${info.timeText}</i>&nbsp;&nbsp;&nbsp;
                    <label>${info.event.extendedProps.client_name}</label><br><label>${info.event.title}</label>`;

                    let arrayOfDomNodes = [italicEl]
					return {
                        domNodes: arrayOfDomNodes
                    }
                },
                eventClick: function(info){
                    var eventId = info.event._def.publicId;
                    context.editEvent(eventId);
                },
                dayMaxEvents: true,
                select: function(start, end, allDays){
                    $('#New_appointment').modal('toggle');
                },
            });

            context.calendar.render();

            jQuery( "#mycalendar" ).datepicker({
                dateFormat: 'yy-mm-dd' // Customize the date format as needed
            });

            $(".fc-today-button").click(function() {
                var todayDt = moment(context.calendar.currentData.dateProfile.currentDate).format('YYYY-MM-DD');
                $('#mycalendar').datepicker().datepicker('setDate', new Date(todayDt));
            });

            // Change calendar view based on user input
            $('#mycalendar').change(function (e) {
                e.preventDefault();
                var inputValue = $(this).val();

                // Change the calendar view to the selected date
                context.calendar.gotoDate(inputValue);
            });

            $(document).on('click', '.history_go_to', function(e) {
                e.preventDefault();
                var date_time = $(this).attr('date_time');
                var dateTimeComponents = date_time.split(' ');
                var date = dateTimeComponents[0];
                var time = dateTimeComponents[1] + ' ' + dateTimeComponents[2];
                
                // Extracting the calendar object from the context
                var calendar = context.calendar;
            
                // Parsing the date and time using Moment.js
                var selectedDateTime = moment(date + ' ' + time, 'YYYY-MM-DD hh:mm A');
                
                // Reset time to midnight
                selectedDateTime.startOf('day');
                
                // Navigating to the updated date and time
                calendar.gotoDate(selectedDateTime.toDate());
            }); 

            $(document).on('click', '.upcoming_go_to', function(e) {
                e.preventDefault();
                var date_time = $(this).attr('date_time');
                var dateTimeComponents = date_time.split(' ');
                var date = dateTimeComponents[0];
                var time = dateTimeComponents[1] + ' ' + dateTimeComponents[2];
                
                // Extracting the calendar object from the context
                var calendar = context.calendar;
            
                // Parsing the date and time using Moment.js
                var selectedDateTime = moment(date + ' ' + time, 'YYYY-MM-DD hh:mm A');
                
                // Reset time to midnight
                selectedDateTime.startOf('day');
                
                // Navigating to the updated date and time
                calendar.gotoDate(selectedDateTime.toDate());
            });
        },

        editEvent:function (eventId){
            $.ajax({
                url: moduleConfig.EventById.replace(':ID', eventId),
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    // console.log(data);return false;
                    $('#clientDetails').html(
                        `<div class='client-name'><div class='drop-cap' style='background: #D0D0D0; color: #000;'>
                        
                        </div></div>
                            <p>
                        ${data.first_name} <br>
                        ${(data.email ? data.email : '')}
                        ${(data.mobile_no ? " | "  + data.mobile_no : '')}
                        </p>
                        <button class='btn btn-primary btn-sm me-2 open-client-card-btn' data-client-id=' ${data.id}'>Client Card</button>
                        <button class='btn btn-primary btn-sm me-2' data-client-id='${data.id}'>History</button>
                        <button class='btn btn-primary btn-sm me-2' data-client-id='${data.id}'>Upcoming</button>
                        <div>
                        <label>appointment summary</label><br><label>Drag and drop on to a day on the appointment book</label>
                        </div>`
                    );
                },
                error: function (error) {
                    console.error('Error fetching events:', error);
                }
            });
        },

        // For events list
        eventsList: function(start_date, end_date){
            var context = this,
                todayDt = moment(context.calendar.currentData.dateProfile.currentDate).format('YYYY-MM-DD');

            $.ajax({
                url: moduleConfig.getEvents,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'start_date'  : start_date,
                    'end_date'    : end_date
                },
                success: function (data) {
                    // Update the FullCalendar resources with the retrieved data
                    context.calendar.setOption('events', data);
                    context.calendar.refetchEvents(); // Refresh events if needed
                },
                error: function (error) {
                    console.error('Error fetching events:', error);
                }
            });
        },

        // For fetch staff list and append in calendar header
        staffList: function(){
            var context = this;

            $.ajax({
                url: moduleConfig.getStaffList,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    // Update the FullCalendar resources with the retrieved data
                    context.calendar.setOption('resources', data);
                    context.calendar.refetchEvents(); // Refresh events if needed
                },
                error: function (error) {
                    console.error('Error fetching resources:', error);
                }
            });
        },

        // For create appointment
        createAppointmentDetails: function(resourceId,start_date,start_time,end_time,durationInMinutes,client_id,service_id,category_id){
            $.ajax({
                url: moduleConfig.createAppointment,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'staff_id'    : resourceId,
                    'start_date'  : start_date,
                    'start_time'  : start_time,
                    'end_time'    : end_time,
                    'duration'    : durationInMinutes,
                    'client_id'   : client_id,
                    'service_id'  : service_id,
                    'category_id' : category_id
                },
                success: function (data) {
                    if (data.success) {
                        Swal.fire({
                            title: "Appointment!",
                            text: data.message,
                            info: "success",
                        });
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: data.message,
                            info: "error",
                        });
                    }
                },
                error: function (error) {
                    console.error('Error fetching resources:', error);
                }
            });
        },

        // For update appointment
        updateAppointmentDetails: function(resourceId,start_date,start_time,end_time,duration,client_id,service_id,category_id,eventId){
            $.ajax({
                url: moduleConfig.updateAppointment,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'staff_id'    : resourceId,
                    'start_date'  : start_date,
                    'start_time'  : start_time,
                    'end_time'    : end_time,
                    'duration'    : duration,
                    'client_id'   : client_id,
                    'service_id'  : service_id,
                    'category_id' : category_id,
                    'event_id'    : eventId
                },
                success: function (data) {
                    if (data.success) {
                        Swal.fire({
                            title: "Appointment!",
                            text: data.message,
                            info: "success",
                        });
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: data.message,
                            info: "error",
                        });
                    }
                },
                error: function (error) {
                    console.error('Error fetching resources:', error);
                }
            });
        },

        openAppointmentModal: function(){
            var context = this;

            $('#appointment').on('click', function(e)
            {
                context.selectors.appointmentModal.modal('show');
            });
        },

        changeServices: function(){
            var context = this;
            jQuery('.parent_category_id').on('click', function(e) {
                e.preventDefault();
                var $this           = $(this),
                    categoryId      = $this.data('category_id'),
                    duration        = $this.data('duration'),
                    categoryTitle   = $this.text();

                $.ajax({
                    url: moduleConfig.categotyByservices, // Replace with your actual API endpoint
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'category_id' : categoryId === undefined ? 0 : categoryId
                    },
                    success: function (data) {

                        $('#subcategory_text').text(categoryTitle);
                        $('#sub_services').empty();
                        $.each(data, function(index, item) {
                            $("#sub_services").append(`<li><a href='javascript:void(0);' class='services' data-services_id=${item.id} data-category_id=${item.parent_category} data-duration=${item.duration}>${item.service_name}</a></li>`);
                        });
                    },
                    error: function (error) {
                        console.error('Error fetching resources:', error);
                    }
                });
            });
        },

        selecedServices: function(){
            var context = this;
            $(document).ready(function() {
                $('#sub_services').on('click', '.services', function(e) {
                    e.preventDefault();
                    var $this           = $(this),
                        serviceId       = $this.data('services_id'),
                        categoryId      = $this.data('category_id'),
                        duration        = $this.data('duration'),
                        serviceTitle    = $this.text();

                    $("#selected_services").append(`<li class='selected remove' data-services_id= ${serviceId}  data-category_id= ${categoryId}  data-duration='${duration}'><a href='javascript:void(0);' > ${serviceTitle} </a><span class='btn btn-cross cross-red remove_services'><i class='ico-close'></i></span></li>`);
                });
            });
            // jQuery('#sub_services').on('click',".services", function(e) {
            //     e.preventDefault();
            //     var $this           = $(this),
            //         serviceId      = $this.data('services_id'),
            //         serviceTitle   = $this.text();

            //     $("#selected_services").append("<li class='selected remove' data-services_id="+ serviceId +"><a href='javascript:void(0);' data-services_id="+ serviceId +">" + serviceTitle + "</a><span class='btn btn-cross cross-red remove_services'><i class='ico-close'></i></span></li>");
            // });
        },

        removeSelectedServices: function(){
            var context = this;

            jQuery('#selected_services').on('click',".remove_services", function(e) {
                e.preventDefault();
                $(this).closest('li').remove();
            });
        },

        addSelectedProduct: function(product){
            var selectedProductsDiv = $('#selectedProducts');
            var newProductDiv = $('<div class="selected-product">');
            newProductDiv.text(product);
            selectedProductsDiv.append(newProductDiv);
        },

        //appointment save
        appointmentSaveBtn: function(){
            var context = this;
            // Validate the client form
            $("#create_client").validate({
                rules: {
                    firstname: {
                        required: true,
                    },
                    lastname:{
                        required:true,
                    },
                    email: {
                        required: true,
                        email: true,
                        remote: {
                            url: "../clients/checkClientEmail", // Replace with the actual URL to check email uniqueness
                            type: "post", // Use "post" method for the AJAX request
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                email: function () {
                                    return $("#email_client").val(); // Pass the value of the email field to the server
                                }
                            },
                            dataFilter: function (data) {
                                var json = $.parseJSON(data);
                                var chk = json.exists ? '"Email already exist!"' : '"true"';
                                return chk;
                            }
                        }
                    },
                    phone:{
                        required: true,
                    },
                    phone_type:{
                        required: true,
                    },
                    contact_method:{
                        required: true,
                    },
                },
            });

            $('#appointmentSaveBtn').on('click' ,function(e){
                var clientselectedServicesCount = $('#selected_services').children("li").length;

                if($('#check_client').val() == 'new_client')
                {
                    if ($("#create_client").valid()) {
                        var data = $('#create_client').serialize();
                        SubmitCreateClient(data);
                    } else {
                        // Prevent the form from being submitted if it's not valid
                        e.preventDefault();
                    }
                }

                if(clientselectedServicesCount == 0)
                {
                    $('#service_error').show();
                }
                else{
                    $('#service_error').hide();
                    // Check if the form is valid or not

                    var resultElement = document.getElementById("clientDetails"),
                        details =  `<div>
                        <label>appointment summary</label><br><label>Drag and drop on to a day on the appointment book</label>
                        </div>`;
                    resultElement.innerHTML += details;

                    $("#selected_services > li").each(function(){
                        var $this           = $(this),
                        eventName           = $(this).text(),
                        eventId             = $(this).data('services_id');
                        categoryId          = $(this).data('category_id');
                        duration            = $(this).data('duration');
                        clientName          = $('#clientDetails').find('input:hidden[name=client_name]').val();
                        clientId            = $('#clientDetails').find('input:hidden[name=client_id]').val();

                        // $('#mycalendar').remove();
                        $('#external-events').removeAttr('style');
                        $('#external-events').append(`
                        <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event' data-service_id="${eventId}" data-client_name="${clientName}" data-duration="${duration}" data-client_id="${clientId}" data-category_id="${categoryId}"> ${eventName}
                        </div>`);
                    });

                    context.selectors.appointmentModal.modal('hide');
                    //for reload all services & selected services
                    $("#all_ser").load(location.href+" #all_ser>*","");
                    $("#selected_services").empty();
                }
            });
        },

        openClientCardModal: function(){
            var context = this;

            $(document).on('click','.open-client-card-btn', function(e){
                var clientId = $(this).data('client-id'); // Use data('client-id') to access the attribute

                // openClientCard(clientId);
                $.ajax({
                    url: moduleConfig.getClientCardData.replace(':ID', clientId), // Replace with your actual API endpoint
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        // remove client info with first div
                        $('#client_info').find('#client-invo-notice').remove();
                        $('#client_info').prepend(response.data);

                        $('#client_info').find('#appointmentsData').remove();
                        $('#appointmentTab').prepend(response.appointmenthtml);

                        $('#client_info').find('#ClientNotesData').remove();
                        $('#clientNotes').prepend(response.clientnoteshtml);
                    },
                    error: function (error) {
                        console.error('Error fetching resources:', error);
                    }
                });
                context.selectors.clientCardModal.modal('show');

                // Open form on add notes button
                $(document).on('click','#add_notes', function(e){
                    var $this           = $(this),
                        appointment_id  = $this.data('appointment_id');

                        $('.common_notes').find('input:hidden[name=appointment_id]').val(appointment_id);
                        $(".viewnotes").remove();
                        $(".common").removeClass('d-none');
                        $("#common_notes").val('');
                });

                // Open form on add treatment notes button
                $(document).on('click','#add_treatment_notes', function(e){
                    var $this           = $(this),
                        appointment_id  = $this.data('appointment_id');

                    $('.treatment_notes').find('input:hidden[name=appointment_id]').val(appointment_id);
                    $(".treatmentviewnotes").remove();
                    $(".treatment_common").removeClass('d-none');
                    $("#treatment_common").val('');
                });

                // Open form on edit custom notes button
                $(document).on('click','#edit_common_notes', function(e){
                    $(".common").removeClass('d-none');
                    $(".viewnotes").remove();
                });

                // Open form on edit treatment notes button
                $(document).on('click','#edit_treatment_notes', function(e){
                    $(".treatment_common").removeClass('d-none');
                    $(".treatmentviewnotes").remove();
                });

                // add common note ajax
                $(document).on('click','#add_common_notes', function(e){
                    e.preventDefault();
                    var appointmentId = $('.common_notes').find('input:hidden[name=appointment_id]').val(),
                        commonNotes   = $('#common_notes').val(),
                        clientId      = $('#clientcardid').data('client_id');

                    context.commonNoteAddUpdateAjax(appointmentId,commonNotes,clientId);
                });

                // add treatment note ajax
                $(document).on('click','#submit_treatment_notes', function(e){
                    e.preventDefault();
                    var appointmentId    = $('.treatment_notes').find('input:hidden[name=appointment_id]').val(),
                        treatmentNotes   = $('#treatment_notes').val(),
                        clientId      = $('#clientcardid').data('client_id');

                    context.treatmentNoteAddUpdateAjax(appointmentId,treatmentNotes,clientId);
                });

                // view notes
                $(document).on('click','.show_notes', function(e){
                    var appointmentId   = $(this).data('appointment_id'),
                        clientId        = $('#clientcardid').data('client_id');
                    context.viewNotes(appointmentId,clientId);
                });
            });
        },

        viewNotes: function(appointmentId,clientId){
            $.ajax({
                url: moduleConfig.viewNotes,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'appointment_id'  : appointmentId,
                    'client_id'       : clientId
                },
                success: function (data) {
                    $('#client_info').find('#ClientNotesData').remove();
                    $('#clientNotes').prepend(data.client_notes);
                },
                error: function (error) {
                    console.error('Error fetching events:', error);
                }
            });
        },

        commonNoteAddUpdateAjax: function(appointmentId,commonNotes,clientId){
            $.ajax({
                url: moduleConfig.addNotes,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'appointmentId'  : appointmentId,
                    'commonNotes'    : commonNotes,
                    'client_id'      : clientId
                },
                success: function (data) {
                    $('#client_info').find('#ClientNotesData').remove();
                    $('#clientNotes').prepend(data.client_notes);
                },
                error: function (error) {
                    console.error('Error fetching events:', error);
                }
            });
        },

        treatmentNoteAddUpdateAjax: function(appointmentId,treatmentNotes,clientId){
            $.ajax({
                url: moduleConfig.addNotes,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'appointmentId'  : appointmentId,
                    'treatmentNotes' : treatmentNotes,
                    'client_id'      : clientId
                },
                success: function (data) {
                    $('#client_info').find('#ClientNotesData').remove();
                    $('#clientNotes').prepend(data.client_notes);
                },
                error: function (error) {
                    console.error('Error fetching events:', error);
                }
            });
        },

        closeClientCardModal: function(){
            var context = this;
            jQuery('#Client_card').on('hide.bs.modal', function()
            {
                var $this = $(this);
                $this.find('#ClientNotesData').remove();
                $this.find('.show_notes').remove();

                // $('#ClientNotesData').remove();
                // $('#appointmentsData').remove();
            });
        },

    }

    $('.add_new_client').click(function(){
        $('#check_client').val('new_client');
        $('.client_detail').hide();
        $('.new_client_head').show();
        $('.client_form').show();
    })

    $('.cancel_client').click(function(){
        $('#check_client').val('selected_client');
        $('.new_client_head').hide();
        $('.client_form').hide();
        $('.client_detail').show();
    })

    $('.client_change').click(function(){
        $('.clientCreateModal').show();
        $('#clientmodal').hide();
    })
    //submit create client form
    function SubmitCreateClient(data){
        var url = $("#clientCreate").data("url");
		$.ajax({
			headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: url,
			type: "post",
			data: data,
			success: function(response) {
				// Show a Sweet Alert message after the form is submitted.
				if (response.success) {
                    $('.photos_count').text(0);
                    $('.documents_count').text(0);
                    // Push client details to the client_details array
                    client_details.push({
                        id: response.data.id,
                        name: response.data.firstname,
                        lastname: response.data.lastname,
                        email: response.data.email,
                        mobile_number: response.data.mobile_number,
                        date_of_birth: response.data.date_of_birth,
                        gender: response.data.gender,
                        home_phone: response.data.home_phone,
                        work_phone: response.data.work_phone,
                        contact_method: response.data.contact_method,
                        send_promotions: response.data.send_promotions,
                        street_address: response.data.street_address,
                        suburb: response.data.suburb,
                        city: response.data.city,
                        postcode: response.data.postcode,
                    });
                    $('#clientDetails').html(
                        "<div class='client-name'><div class='drop-cap' style='background: #D0D0D0; color: #000;'>" +
                        response.data.firstname.charAt(0).toUpperCase() +
                        "</div></div>" +
                        "<p>" +
                        response.data.firstname + "<br>" +
                        (response.data.email ? response.data.email : '') +
                        (response.data.mobile_number ? " | "  +response.data.mobile_number : '') +
                        "</p>" +
                        "<button class='btn btn-primary btn-sm me-2 open-client-card-btn' data-client-id='"+ response.data.id+"'>Client Card</button>" +
                        "<button class='btn btn-primary btn-sm me-2' data-client-id='"+ response.data.id+"'>History</button>" +
                        "<button class='btn btn-primary btn-sm me-2' data-client-id='"+ response.data.id+"'>Upcoming</button>"+
                        "<div>"+
                        "<label>appointment summary</label><br><label>Drag and drop on to a day on the appointment book</label>"+
                        "</div>"
                    );

					Swal.fire({
						title: "Client!",
						text: "Client & Appointment created successfully.",
						info: "success",
					}).then((result) => {
                        $("#create_client").trigger("reset");
                        $('#check_client').val('selected_client');
                        $('.new_client_head').hide();
                        $('.client_form').hide();
                        $('.client_detail').show();
                        //for reload all services & selected services
                        $("#all_ser").load(location.href+" #all_ser>*","");
                        $("#selected_services").empty();
                        // console.log(result);
                        // window.location = redirct_url;
                    });
				} else {
					Swal.fire({
						title: "Error!",
						text: response.message,
						info: "error",
					});
				}
			},
		});
	}
})();