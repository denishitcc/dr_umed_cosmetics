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
            context.eventsList();
            context.openClientCardModal();

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
                        console.log(eventEl);
                    var dataset = eventEl.dataset;
                    return {
                        title: eventEl.innerText,
                        extendedProps:{
                            client_name :dataset.client_name,
                            service_id  :dataset.service_id,
                            client_id   :dataset.client_id,
                            category_id :dataset.category_id
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
                defaultAllDayEventDuration: "01:00",
                forceEventDuration: true,
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
                    console.log(isLoading);
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
                        start_time          = moment(info.event.startStr).format('YYYY-MM-DDTHH:mm:ss'),
                        end_time            = moment(info.event.endStr).format('YYYY-MM-DDTHH:mm:ss'),
                        client_id           = info.event.extendedProps.client_id,
                        service_id          = info.event.extendedProps.service_id,
                        category_id         = info.event.extendedProps.category_id;

                    // For difference between two dates -> duration
                    var start_time_diff     = moment(info.event.startStr),
                        end_time_diff       = moment(info.event.endStr),
                        durationInMinutes   = end_time_diff.diff(start_time_diff, 'minutes');

                        context.createAppointmentDetails(resourceId,start_date,start_time,end_time,durationInMinutes,client_id,service_id,category_id);
                },
                eventDrop: function (events) {
                    var resourceId          = events.event._def.resourceIds[0],
                        eventId             = events.event._def.publicId,
                        start_date          = moment(events.event.startStr).format('YYYY-MM-DD'),
                        start_time          = moment(events.event.startStr).format('YYYY-MM-DDTHH:mm:ss'),
                        end_time            = moment(events.event.endStr).format('YYYY-MM-DDTHH:mm:ss'),
                        client_id           = events.event.extendedProps.client_id,
                        service_id          = events.event.extendedProps.service_id,
                        category_id         = events.event.extendedProps.category_id;

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
                        start_time          = moment(events.event.startStr).format('YYYY-MM-DDTHH:mm:ss'),
                        end_time            = moment(events.event.endStr).format('YYYY-MM-DDTHH:mm:ss'),
                        client_id           = events.event.extendedProps.client_id,
                        service_id          = events.event.extendedProps.service_id;
                        category_id         = events.event.extendedProps.category_id;

                    // For difference between two dates -> duration
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
        },

        // For events list
        eventsList: function(start_date, end_date){
            var context = this;
            var todayDt = moment(context.calendar.currentData.dateProfile.currentDate).format('YYYY-MM-DD');

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
        updateAppointmentDetails: function(resourceId,start_date,start_time,end_time,durationInMinutes,client_id,service_id,category_id,eventId){
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
                    'duration'    : durationInMinutes,
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
            });
        },

        changeServices: function(){
            var context = this;
            jQuery('.parent_category_id').on('click', function(e) {
                e.preventDefault();
                var $this           = $(this),
                    categoryId      = $this.data('category_id'),
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
                            $("#sub_services").append(`<li><a href='javascript:void(0);' class='services' data-services_id=${item.id} data-category_id=${item.parent_category} >${item.service_name}</a></li>`);
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
                    var $this         = $(this),
                    serviceId       = $this.data('services_id'),
                    categoryId      = $this.data('category_id'),
                    serviceTitle    = $this.text();

                    $("#selected_services").append("<li class='selected remove' data-services_id=" + serviceId + " data-category_id=" + categoryId + "><a href='javascript:void(0);' data-services_id=" + serviceId + ">" + serviceTitle + "</a><span class='btn btn-cross cross-red remove_services'><i class='ico-close'></i></span></li>");
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

        // searchClient: function(){
        //     var context = this;
        //     $('.search_client').autocomplete({
        //         source: function (request, response) {
        //             $.ajax({
        //                 url: moduleConfig.getClients, // Replace with your actual API endpoint
        //                 type: 'POST',
        //                 headers: {
        //                     'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        //                 },
        //                 data: {
        //                     'name' : request.term
        //                 },
        //                 success: function (data) {
        //                     context.displayResults(data);
        //                 },
        //                 error: function (error) {
        //                     console.error('Error fetching resources:', error);
        //                 }
        //             });
        //         },
        //         minLength: 2, // minimum characters before triggering autocomplete
        //         select: function (event, ui) {
        //             console.log(ui);
        //             // Handle the selection event
        //             context.addSelectedProduct(ui.item.value);
        //             // Clear the input after selection if needed
        //             $(this).val('');
        //             return false; // Prevent the input value from being updated with the selected value
        //         }
        //     });
        //     // Handling the change event of the input field
        //     $('.search_client').on('input', function() {
        //         if ($(this).val().trim() === '') {
        //             context.clearResults();
        //         }
        //     });
        // },

        clearResults: function() {
            var resultElement = document.getElementById("result");
            resultElement.innerHTML = '';
        },


        searchClientModal: function(){
            var context = this;
            $('.search_client_modal').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: moduleConfig.getClients, // Replace with your actual API endpoint
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            'name' : request.term
                        },
                        success: function (data) {
                            context.displayResultsmodal(data);
                        },
                        error: function (error) {
                            console.error('Error fetching resources:', error);
                        }
                    });
                },
                minLength: 2, // minimum characters before triggering autocomplete
                onSelect: function (event, ui,data) {
                    // Handle the selection event
                    context.addSelectedProduct(ui.item.value);
                    // Clear the input after selection if needed
                    $(this).val('');
                    return false; // Prevent the input value from being updated with the selected value
                }
            })
            // Handling the change event of the input field
            $('.search_client_modal').on('input', function() {
                if ($(this).val().trim() === '') {
                    context.clearResultsModal();
                }
            });
        },

        clearResultsModal: function() {
            var resultElement = document.getElementById("search_client_modal");
            resultElement.innerHTML = '';
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
                        clientName          = $('#clientDetails').find('input:hidden[name=client_name]').val();
                        clientId            = $('#clientDetails').find('input:hidden[name=client_id]').val();

                        // $('#mycalendar').remove();
                        $('#external-events').removeAttr('style');
                        $('#external-events').append(`
                        <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event' data-service_id="${eventId}" data-client_name="${clientName}" data-client_id="${clientId}" data-category_id="${categoryId}"> ${eventName}
                        </div>`);
                    });

                    context.selectors.appointmentModal.modal('hide');
                    //for reload all services & selected services
                    $("#all_ser").load(location.href+" #all_ser>*","");
                    $("#selected_services").empty();
                }
            });
        },

    }

    // $(document).on('click','#add_notes', function(e){
    //     $('#common_notes').show();
    // });

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
                        console.log(result);
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