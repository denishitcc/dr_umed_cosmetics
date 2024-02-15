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
        },

        initialCalender: function(){
            var context = this;
            // Calender
            var calendarEl = document.getElementById('calendar');
                context.calendar = new FullCalendar.Calendar(calendarEl, {
                selectable: true,
                editable: true,
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

            jQuery('#sub_services').on('click',".services", function(e) {
                e.preventDefault();
                var $this           = $(this),
                    serviceId      = $this.data('services_id'),
                    serviceTitle   = $this.text();

                $("#selected_services").append("<li class='selected remove'><a href='javascript:void(0);' data-services_id="+ serviceId +">" + serviceTitle + "</a><span class='btn btn-cross cross-red remove_services'><i class='ico-close'></i></span></li>");
            });
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
                source: function (request, response,modal) {
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
                source: function (request, response,modal) {
                    if (!request.term.trim()) {
                        $('.search_client_modal').empty();
                        return;
                    }
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
                select: function (event, ui) {
                    console.log(ui);
                    // Handle the selection event
                    context.addSelectedProduct(ui.item.value);
                    // Clear the input after selection if needed
                    $(this).val('');
                    return false; // Prevent the input value from being updated with the selected value
                }
            });
        },

        displayResultsmodal: function(data){
            console.log(data);
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
        }
    }
})();