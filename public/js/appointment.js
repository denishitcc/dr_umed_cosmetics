var DU = {};
(function () {
    DU.appointment = {
        calendar: null,
        selectors: {
            appointmentModal: jQuery('#New_appointment'),
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
            context.searchClient();
            context.searchClientModal();
            context.appointmentSaveBtn();

            $('#clientmodal').hide();
            $('#service_error').hide();
            // $("#external-events").draggable()
        },

        initialCalender: function(){
            var context     = this,
                Draggable   = FullCalendar.Draggable;
                containerEl = document.getElementById('external-events');

            new Draggable(containerEl, {
                itemSelector: '.fc-event',
                eventData: function (eventEl) {
                    console.log(eventEl.innerText);
                    return {
                        title: eventEl.innerText
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
                initialView: 'resourceTimeGridDay',
                buttonText: {
                    today: 'Today',
                    day: 'Daily',
                    week: 'Weekly',
                    month: 'Monthly',
                    year: 'Year',
                },
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'resourceTimeGridDay,resourceTimeGridWeek,dayGridMonth,resourceTimelineYear'
                },
                resources: [],
                resourceAreaHeaderContent: 'Name of Dr',
                events: [
                    // {
                    //     resourceId: 22,
                    //     title: "Long Event",
                    //     start: "2024-02-07",
                    //     end: "2024-02-10"
                    // },
                    // { resourceTimelineMonth
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
                ],
                drop: function(info) {
                    //remove draggable event
                    info.draggedEl.parentNode.removeChild(info.draggedEl);
                    $("#external-events").remove();
                },
                dayMaxEvents: true,
                select: function(start, end, allDays){
                    $('#New_appointment').modal('toggle');

                    $('#saveBtn').click(function(){
                        // var timeline = getCurrentTimeline(calendar);
                        var time = moment().format("HH:mm:ss");
                        console.log(calendar.startStr);
                    })
                },
            });
            $.ajax({
                url: moduleConfig.doctorAppointments, // Replace with your actual API endpoint
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

            context.calendar.render();

            jQuery( "#mycalendar" ).datepicker({
                dateFormat: 'yy-mm-dd' // Customize the date format as needed
            });

            $(".fc-today-button").click(function() {
                // calendar.today();
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
                            $("#sub_services").append("<li><a href='javascript:void(0);' class='services' data-services_id="+ item.id +">" + item.service_name + "</a></li>");
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
            $(document).on('click', '#sub_services', function (e) {
                e.preventDefault();
                var $this           = $(this),
                    serviceId      = $this.data('services_id'),
                    serviceTitle   = $this.text();        
                $("#selected_services").append("<li class='selected remove' data-services_id="+ serviceId +"><a href='javascript:void(0);' data-services_id="+ serviceId +">" + serviceTitle + "</a><span class='btn btn-cross cross-red remove_services'><i class='ico-close'></i></span></li>");
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

        searchClient: function(){
            var context = this;
            $('.search_client').autocomplete({
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
                            context.displayResults(data);
                        },
                        error: function (error) {
                            console.error('Error fetching resources:', error);
                        }
                    });
                },
                minLength: 2, // minimum characters before triggering autocomplete
                select: function (event, ui) {
                    console.log(ui);
                    // Handle the selection event
                    context.addSelectedProduct(ui.item.value);
                    // Clear the input after selection if needed
                    $(this).val('');
                    return false; // Prevent the input value from being updated with the selected value
                }
            });
            // Handling the change event of the input field
            $('.search_client').on('input', function() {
                if ($(this).val().trim() === '') {
                    context.clearResults();
                }
            });
        },
        clearResults: function() {
            var resultElement = document.getElementById("result");
            resultElement.innerHTML = '';
        },

        displayResults: function(data){
            var resultElement = document.getElementById("result");
            resultElement.innerHTML = '';

            if (data.length === 0) {
                resultElement.append('<p>No results found</p>');
            } else {
                $.each(data, function(index, item) {
                    var title_details = "Results <label class='blue-bold'> (" + data.length + ")</label>";
                    data.forEach(function (item) {

                        var details = "<div class='client-invo-notice'>" + item.first_name + "<br>" + item.email + " | " + item.mobile_no + "</div>";
                        resultElement.innerHTML += title_details + details ;
                    });
                });
            }
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
                    console.log(ui);
                    console.log(data);
                    // Handle the selection event
                    context.addSelectedProduct(ui.item.value);
                    // Clear the input after selection if needed
                    $(this).val('');
                    return false; // Prevent the input value from being updated with the selected value
                }
                // .appendTo($('.test ul'))
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

        displayResultsmodal: function(data){
            var resultElement = document.getElementById("search_client_modal");
            resultElement.innerHTML = '';

            if (data.length === 0) {
                resultElement.append('<p>No results found</p>');
            } else {
                $.each(data, function(index, item) {
                    data.forEach(function (item) {
                        var title_details = "Results <label class='blue-bold'> (" + data.length + ")</label>";
                        var details = "<div class='client-invo-notice'>" + item.first_name + "<br>" + item.email + " | " + item.mobile_no + "</div>";
                        resultElement.innerHTML += title_details + details ;
                    });
                });
            }
        },

        addSelectedProduct: function(product){
            console.log(product);
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

                if ($("#create_client").valid()) {
                    var data = $('#create_client').serialize();
                    SubmitCreateClient(data);
                } else {
                    // Prevent the form from being submitted if it's not valid
                    e.preventDefault();
                }
                if(clientselectedServicesCount == 0)
                {
                    $('#service_error').show();
                }
                else{
                    $('#service_error').hide();
                    var resultElement = document.getElementById("clientDetails"),
                        details =  "<div>";
                        details += "<label>appointment summary</label><br><label>Drag and drop on to a day on the appointment book</label>";
                        details += "</div>";
                    resultElement.innerHTML += details;

                    $("#selected_services > li").each(function(){
                        $('#external-events').append("<div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'><div class='fc-event-main'>"+$(this).text()+"</div></div>");
                    });

                    // $('#external-events').draggable();

                    context.selectors.appointmentModal.modal('hide');
                }
            });
        }
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
						type: "success",
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
						type: "error",
					});
				}
			},
		});
	}
})();