var DU = {};
(function () {
    DU.appointment = {
        calendar: null,
        selectors: {
            appointmentModal:           jQuery('#New_appointment'),
            clientCardModal:            jQuery('#Client_card'),
            repeatAppointmentModal:     jQuery('#repeat_Appointment'),
            newAppointmentBtn:          jQuery('#appointment'),
            repeatAppointmentForm:      jQuery("#addwaiterform"),
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
            context.appointmentUpdateBtn();
            context.staffList();
            context.openClientCardModal();
            context.closeClientCardModal();
            context.appointmentCancel();
            context.deleteAppointment();
            context.openResetAppointmentModal();
            context.repeatAppointmentSaveBtn();
            context.closeReAppointmentModal();
            context.locationDropdown();
            context.staffchangeafterlocation();
            context.staffchangecalendar();

            $('#clientmodal').hide();
            $('#service_error').hide();
            $('#client').hide();
            $("#repeat_error").hide();
            // $("#external-events").draggable()
        },

        initialCalender: function(){
            var context     = this;
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
                // titleFormat: 'dddd, MMMM D, YYYY',
                // dayHeaderFormat: {
                //     weekday: 'narrow', // Use 'narrow' for even shorter abbreviations.
                //     month: 'numeric'
                // },
                views: {
                    resourceTimeGridWeek: {
                        dayHeaderFormat: {
                            weekday: 'short', // Displays abbreviated day of the week
                            day: '2-digit',   // Displays day with leading zero (e.g., 01)
                            month: '2-digit', // Displays month with leading zero (e.g., 01)
                            year: 'numeric'   // Displays full year
                        },
                        titleFormat: {
                            year: 'numeric',  // Displays full year
                            month: 'long',    // Displays full month name
                            day: '2-digit'    // Displays day with leading zero (e.g., 01)
                        }
                    }
                },
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
                    right: 'resourceTimeGridDay,dayGridMonth,resourceTimelineYear'
                },

                datesSet: function (info) {
                    // info.start and info.end represent the new date range resourceTimeGridWeek
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
                    $('.app_sum').hide();
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
                        app_id              = info.event.extendedProps.app_id,
                        context.createAppointmentDetails(resourceId,start_date,start_time,end_time,duration,client_id,service_id,category_id,app_id);
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

                    // For difference between two dates -> duration
                    var start_time_diff     = moment(events.event.startStr),
                        end_time_diff       = moment(events.event.endStr),
                        durationInMinutes   = end_time_diff.diff(start_time_diff, 'minutes');

                    var data =  {
                            'staff_id'    : resourceId,
                            'start_date'  : start_date,
                            'start_time'  : start_time,
                            'end_time'    : end_time,
                            'duration'    : durationInMinutes,
                            'client_id'   : client_id,
                            'service_id'  : service_id,
                            'category_id' : category_id,
                            'event_id'    : eventId,
                        };

                        context.updateAppointmentDetails(data);
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

                    var data =  {
                            'staff_id'    : resourceId,
                            'start_date'  : start_date,
                            'start_time'  : start_time,
                            'end_time'    : end_time,
                            'duration'    : durationInMinutes,
                            'client_id'   : client_id,
                            'service_id'  : service_id,
                            'category_id' : category_id,
                            'event_id'    : eventId,
                        };

                        context.updateAppointmentDetails(data);
                },
                eventDidMount: function(info)
                {
                    //info.el.innerHTML += info.event.extendedProps.description;
                },
                eventContent: function (info)
                {
                    let italicEl = document.createElement('div');
                    italicEl.classList.add("fc-event-main-frame");
                    italicEl.innerHTML = `<div class='fc-event-time'>${info.timeText}</div>
                    <div class='fc-event-title-container'><div class='fc-event-title fc-sticky'>${info.event.extendedProps.client_name} ${info.event.title}</div></div>`;

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
            context.appointmentDraggable();
            context.wailtlistClientDraggable();

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
                // Scroll the page slightly bcs if time is 3:30 Go to and after that click 4:30 then not scroll
                window.scrollBy(0, 1); // Adjust the amount to scroll as needed
                // Extract date and time from the clicked element's attribute
                var date_time = $(this).attr('date_time');
                var dateTimeComponents = date_time.split(' ');
                var date = dateTimeComponents[0];
                var time = dateTimeComponents[1] + ' ' + dateTimeComponents[2];
                
                // Extracting the calendar object from the context
                var calendar = context.calendar;
                
                // Parsing the date and time using Moment.js
                var selectedDateTime = moment(date + ' ' + time, 'YYYY-MM-DD hh:mm A');
                
                console.log('Selected date and time:', selectedDateTime.format());
                
                // Navigating to the updated date
                calendar.gotoDate(selectedDateTime.toDate());
                console.log('Navigated to date:', selectedDateTime.format('YYYY-MM-DD'));
                
                // Scroll to the desired time slot after a short delay
                setTimeout(function() {
                    var timeSlot = selectedDateTime.format('HH:mm:ss');
                    var slotSelector = '[data-time="' + timeSlot + '"]';
                    var timeSlotElement = calendar.el.querySelector(slotSelector);
                    if (timeSlotElement) {
                        console.log('Time slot element found:', timeSlot);
                        timeSlotElement.scrollIntoView();
                        console.log('Scrolled to time slot:', timeSlot);
                    } else {
                        console.log('Time slot not found:', timeSlot);
                    }
                }, 100); // Adjust the delay as needed
            });            

            $(document).on('click', '.upcoming_go_to', function(e) {
                e.preventDefault();
                // Scroll the page slightly bcs if time is 3:30 Go to and after that click 4:30 then not scroll
                window.scrollBy(0, 1); // Adjust the amount to scroll as needed
                // Extract date and time from the clicked element's attribute
                var date_time = $(this).attr('date_time');
                var dateTimeComponents = date_time.split(' ');
                var date = dateTimeComponents[0];
                var time = dateTimeComponents[1] + ' ' + dateTimeComponents[2];
                
                // Extracting the calendar object from the context
                var calendar = context.calendar;
                
                // Parsing the date and time using Moment.js
                var selectedDateTime = moment(date + ' ' + time, 'YYYY-MM-DD hh:mm A');
                
                console.log('Selected date and time:', selectedDateTime.format());
                
                // Navigating to the updated date
                calendar.gotoDate(selectedDateTime.toDate());
                console.log('Navigated to date:', selectedDateTime.format('YYYY-MM-DD'));
                
                // Scroll to the desired time slot after a short delay
                setTimeout(function() {
                    var timeSlot = selectedDateTime.format('HH:mm:ss');
                    var slotSelector = '[data-time="' + timeSlot + '"]';
                    var timeSlotElement = calendar.el.querySelector(slotSelector);
                    if (timeSlotElement) {
                        console.log('Time slot element found:', timeSlot);
                        timeSlotElement.scrollIntoView();
                        console.log('Scrolled to time slot:', timeSlot);
                    } else {
                        console.log('Time slot not found:', timeSlot);
                    }
                }, 100); // Adjust the delay as needed
            });                         
            $(document).on('click','.rebook_histroy',function(e){
                $('.history_appointments').hide();
                //appointment rebook start

                var resultElement = document.getElementById("clientDetails"),
                details =  `<div class='app_sum'>
                                <div class="summry-header"><span class="ico-clock me-2 fs-4"></span> Appointment Summary</div>
                            </div>`;
                resultElement.innerHTML += details;

                // $("#selected_services > li").each(function(){
                    // var $this           = $(this),
                    eventName           = $(this).parent().find('#service_name').val(),
                    eventId             = $(this).parent().find('#service_id').val();
                    categoryId          = $(this).parent().find('#category_id').val();
                    duration            = $(this).parent().find('#duration').val();
                    clientName          = $(this).parent().find('#client_name').val();
                    clientId            = $(this).parent().find('#client_id').val();

                    // $('#mycalendar').remove();
                    $('#external-events').removeAttr('style');
                    $('#external-events').append(`
                    <div class="drag-box mb-3">
                        <div class="head mb-2"><b>Drag and drop on</b> to a day on the appointment book
                            <i class="ico-noun-arrow"></i></div>
                        <div class="treatment fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event" data-service_id="${eventId}" data-client_name="${clientName}" data-duration="${duration}" data-client_id="${clientId}" data-category_id="${categoryId}">${eventName}
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="javascript:void(0)" class="btn btn-primary btn-md blue-alter cancel_rebook">Cancel rebook</a>
                    </div>`);
                // });

                context.selectors.appointmentModal.modal('hide');
                //for reload all services & selected services
                $("#all_ser").load(location.href+" #all_ser>*","");
                $("#selected_services").empty();
                $('#editEventData').remove();

                //appointment rebook end


                // Prevent default behavior (e.g., form submission)
                e.preventDefault();
                // Initialize datepicker with options
                $('#datepicker').datepicker({
                numberOfMonths: 2, // Display two months
                dateFormat: 'yy-mm-dd', // Set date format to "yyyy-mm-dd"
                onSelect: function(selectedDate, inst) {
                    // Display selected date in console
                    console.log('Selected date:', selectedDate);
                    // You can also use the selected date for further processing
                    // For example, update a hidden input field with the selected date
                    $('#selectedDateInput').val(selectedDate);
                    // Change the calendar view to the selected date
                    context.calendar.gotoDate(selectedDate);
                  }
                });
                // Show datepicker
                $('#datepicker').datepicker('show');
            })

            $(document).on('click','.rebook_upcoming',function(e){
                $('.upcoming_appointments').hide();
                //appointment rebook start

                var resultElement = document.getElementById("clientDetails"),
                details =  `<div class='app_sum'>
                                <div class="summry-header"><span class="ico-clock me-2 fs-4"></span> Appointment Summary</div>
                            </div>`;
                resultElement.innerHTML += details;

                // $("#selected_services > li").each(function(){
                    // var $this           = $(this),
                    eventName           = $(this).parent().find('#service_name').val(),
                    eventId             = $(this).parent().find('#service_id').val();
                    categoryId          = $(this).parent().find('#category_id').val();
                    duration            = $(this).parent().find('#duration').val();
                    clientName          = $(this).parent().find('#client_name').val();
                    clientId            = $(this).parent().find('#client_id').val();

                    // $('#mycalendar').remove();
                    $('#external-events').removeAttr('style');
                    $('#external-events').append(`
                    <div class="drag-box mb-3">
                        <div class="head mb-2"><b>Drag and drop on</b> to a day on the appointment book
                            <i class="ico-noun-arrow"></i></div>
                        <div class="treatment fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event" data-service_id="${eventId}" data-client_name="${clientName}" data-duration="${duration}" data-client_id="${clientId}" data-category_id="${categoryId}"> ${eventName}
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="javascript:void(0)" class="btn btn-primary btn-md blue-alter cancel_rebook">Cancel rebook</a>
                    </div>`);
                // });

                context.selectors.appointmentModal.modal('hide');
                //for reload all services & selected services
                $("#all_ser").load(location.href+" #all_ser>*","");
                $("#selected_services").empty();

                //appointment rebook end

                // Prevent default behavior (e.g., form submission)
                e.preventDefault();
                // Initialize datepicker with options
                $('#datepicker').datepicker({
                numberOfMonths: 2, // Display two months
                dateFormat: 'yy-mm-dd', // Set date format to "yyyy-mm-dd"
                onSelect: function(selectedDate, inst) {
                    // Display selected date in console
                    console.log('Selected date:', selectedDate);
                    // You can also use the selected date for further processing
                    // For example, update a hidden input field with the selected date
                    $('#selectedDateInput').val(selectedDate);
                    // Change the calendar view to the selected date
                    context.calendar.gotoDate(selectedDate);
                  }
                });
                // Show datepicker
                $('#datepicker').datepicker('show');
            })
            $(document).on('click','.rebook',function(e){
                $('.history_appointments').hide();
                //appointment rebook start

                var resultElement = document.getElementById("clientDetails"),
                details =  `<div class='app_sum'>
                                <div class="summry-header"><span class="ico-clock me-2 fs-4"></span> Appointment Summary</div>
                            </div>`;
                resultElement.innerHTML += details;

                // $("#selected_services > li").each(function(){
                    // var $this           = $(this),
                    eventName           = $('#service_name').val(),
                    eventId             = $('#service_id').val();
                    categoryId          = $('#category_id').val();
                    duration            = $('#duration').val();
                    clientName          = $('#client_name').val();
                    clientId            = $('#client_id').val();

                    // $('#mycalendar').remove();
                    $('#external-events').removeAttr('style');
                    $('#external-events').append(`
                    <div class="drag-box mb-3">
                        <div class="head mb-2"><b>Drag and drop on</b> to a day on the appointment book
                            <i class="ico-noun-arrow"></i></div>
                        <div class="treatment fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event" data-service_id="${eventId}" data-client_name="${clientName}" data-duration="${duration}" data-client_id="${clientId}" data-category_id="${categoryId}">${eventName}
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="javascript:void(0)" class="btn btn-primary btn-md blue-alter cancel_rebook">Cancel rebook</a>
                    </div>`);
                // });

                context.selectors.appointmentModal.modal('hide');
                //for reload all services & selected services
                $("#all_ser").load(location.href+" #all_ser>*","");
                $("#selected_services").empty();
                $('#editEventData').remove();

                //appointment rebook end


                // Prevent default behavior (e.g., form submission)
                e.preventDefault();
                // Initialize datepicker with options
                $('#datepicker').datepicker({
                numberOfMonths: 2, // Display two months
                dateFormat: 'yy-mm-dd', // Set date format to "yyyy-mm-dd"
                onSelect: function(selectedDate, inst) {
                    // Display selected date in console
                    console.log('Selected date:', selectedDate);
                    // You can also use the selected date for further processing
                    // For example, update a hidden input field with the selected date
                    $('#selectedDateInput').val(selectedDate);
                    // Change the calendar view to the selected date
                    context.calendar.gotoDate(selectedDate);
                  }
                });
                // Show datepicker
                $('#datepicker').datepicker('show');
            })
            $(document).on('click','.move_appointment',function(e){
                var resultElement = document.getElementById("clientDetails"),
                details =  `<div class='app_sum'>
                                <div class="summry-header"><span class="ico-clock me-2 fs-4"></span> Appointment Summary</div>
                            </div>`;
                resultElement.innerHTML += details;

                // $("#selected_services > li").each(function(){
                    // var $this           = $(this),
                    eventName           = $('.orange-box').find('#service_name').val(),
                    eventId             = $('.orange-box').find('#service_id').val();
                    categoryId          = $('.orange-box').find('#category_id').val();
                    duration            = $('.orange-box').find('#duration').val();
                    clientName          = $('.orange-box').find('#client_name').val();
                    clientId            = $('.orange-box').find('#client_id').val();
                    appId               = $('.orange-box').next().find('#edit_appointment').attr('event_id');
                    // $('#mycalendar').remove();
                    $('#external-events').removeAttr('style');
                    $('#external-events').append(`
                    <div class="drag-box mb-3">
                        <div class="head mb-2"><b>Drag and drop on</b> to a day on the appointment book
                            <i class="ico-noun-arrow"></i></div>
                        <div class="treatment fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event" data-app_id="${appId}" data-service_id="${eventId}" data-client_name="${clientName}" data-duration="${duration}" data-client_id="${clientId}" data-category_id="${categoryId}">${eventName}
                        </div>
                    </div>`);
                // });

                context.selectors.appointmentModal.modal('hide');
                //for reload all services & selected services
                $("#all_ser").load(location.href+" #all_ser>*","");
                $("#selected_services").empty();
                $('#editEventData').remove();

                //appointment rebook end


                // Prevent default behavior (e.g., form submission)
                e.preventDefault();
                // Initialize datepicker with options
                $('#datepicker').datepicker({
                numberOfMonths: 2, // Display two months
                dateFormat: 'yy-mm-dd', // Set date format to "yyyy-mm-dd"
                onSelect: function(selectedDate, inst) {
                    // Display selected date in console
                    console.log('Selected date:', selectedDate);
                    // You can also use the selected date for further processing
                    // For example, update a hidden input field with the selected date
                    $('#selectedDateInput').val(selectedDate);
                    // Change the calendar view to the selected date
                    context.calendar.gotoDate(selectedDate);
                  }
                });
                // Show datepicker
                $('#datepicker').datepicker('show');
            })
            $(document).on('click','.cancel_rebook',function(e){
                $('.history_appointments').show();
                $('.upcoming_appointments').show();
                $('.app_sum').remove();
                $('#external-events').empty();
            })
        },

        appointmentDraggable: function(){
            var context         = this,
                containerEl     = document.getElementById('external-events');
            var eventdraggable  = new FullCalendar.Draggable(containerEl, {
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
                            app_id:dataset.app_id
                        }
                    };
                }
            });

        },

        wailtlistClientDraggable: function(){
            var context             = this,
                containerEl2        = document.getElementById('waitlist-events');
            var waitingdraggable    = new FullCalendar.Draggable(containerEl2, {
                itemSelector: '.fc-event',
                eventData: function (eventEl2) {
                    var dataset = eventEl2.dataset;
                    console.log('dataset',dataset);
                    return {
                        title: eventEl2.innerText,
                        extendedProps:{
                            client_name :dataset.client_name,
                            service_id  :dataset.service_id,
                            client_id   :dataset.client_id,
                            category_id :dataset.category_id,
                            duration    :dataset.duration,
                            app_id:dataset.app_id,
                            service_name:dataset.service_name
                        }
                    };
                }
            });
        },

        staffchangeafterlocation: function(){
            var context = this;
            jQuery('#locations').on('change', function(e) {
                var location_id           = $(this).val()

                $.ajax({
                    url: moduleConfig.getStaffList,
                    type: 'POST',
                    data: {
                        'location_id'    : location_id,
                    },
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        console.log(data.length);
                        // Update the FullCalendar resources with the retrieved data
                        context.calendar.setOption('resources', data);
                        context.calendar.refetchEvents(); // Refresh events if needed

                        $('#staff').empty();
                        $('#staff').append(`<option value="all">All staff</option>
                                <option disabled>Individual staff</option>`);
                        if (data && data.length > 0) {
                            data.forEach(function (name) {
                                let fullName = name.title;
                                let id = name.id;
                                $('#staff').append($('<option>', { value: id, text: fullName }));
                            });
                        }
                    },
                    error: function (error) {
                        console.error('Error fetching resources:', error);
                    }
                });
            });
        },

        staffchangecalendar: function(){
            var context = this;
            jQuery('#staff').on('change', function(e) {
                var resourceId    = $(this).val();
                const resources = context.calendar.getOption('resources');
                if(resourceId != 'all')
                {
                    const filteredResources = resources.filter(resource => resource.id === resourceId);

                    context.calendar.setOption('resources', filteredResources);
                    context.calendar.changeView('timeGridWeek');

                    // var start_date = moment(context.calendar.currentData.dateProfile.currentRange.start).format('YYYY-MM-DD');
                    // var end_date   = moment(context.calendar.currentData.dateProfile.currentRange.end).format('YYYY-MM-DD');
                    // context.eventsList(start_date, end_date);
                }
                else{
                    // context.calendar.setOption('resources', resources);
                    context.staffList();
                    context.calendar.changeView('resourceTimeGridDay');
                }
                console.log('test');
                context.calendar.render();
            });
        },

        locationDropdown: function(){
            var context = this;

            $.ajax({
                url: moduleConfig.getLocation,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if (data && data.length > 0) {
                        data.forEach(function (location) {
                            $('#locations').append($('<option>', { value: location.id, text: location.location_name }));
                        });
                    }
                },
                error: function (error) {
                    console.error('Error fetching resources:', error);
                }
            });
        },

        editEvent:function (eventId){
            var context       = this;
            $.ajax({
                url: moduleConfig.EventById.replace(':ID', eventId),
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    // console.log(response.data.client_data.first_name);return false;
                    $('#clientDetails').html(
                        `<div class="client-name">
                                <div class="drop-cap" style="background: #D0D0D0; color:#fff;">${response.data.client_data.first_name.charAt(0).toUpperCase()}
                                </div>
                                <div class="client-info">
                                    <input type='hidden' name='client_name' value='${response.data.client_data.first_name} ${response.data.client_data.last_name}'>
                                    <input type='hidden' id="client_id" name='client_id' value='${response.data.client_data.id}'>
                                    <input type='hidden' id="category_id" name='category_id' value='${response.data.category_id}'>
                                    <input type='hidden' id="service_id" name='service_id' value='${response.data.services_id}'>
                                    <input type='hidden' id="staff_id" name='staff_id' value='${response.data.staff_id}'>
                                    <input type='hidden' id="start_date" name='start_date' value='${response.data.date}'>
                                    <input type='hidden' name='appointment_duration' value='${response.data.duration}'>
                                    <h4 class="blue-bold">${response.data.client_data.first_name} ${response.data.client_data.last_name}</h4>
                                </div>
                            </div>
                            <div class="mb-2">
                                <a href="#" class="river-bed"><b>${response.data.client_data.mobile_no}</b></a><br>
                                <a href="#" class="river-bed"><b>${response.data.client_data.email}</b></a>
                            </div>
                            <hr>
                            <div class="btns">
                                <button class="btn btn-secondary btn-sm open-client-card-btn" data-client-id="${response.data.client_data.id}" >Client Card</button>
                                <button class="btn btn-secondary btn-sm history" data-client-id="${response.data.client_data.id}" >History</button>
                                <button class="btn btn-secondary btn-sm upcoming" data-client-id="${response.data.client_data.id}" >Upcoming</button>
                            </div>
                            <hr>
                            <div id="editEventData">
                            <div class="summry-header"><span class="ico-clock me-2 fs-4"></span> Appointment Summary</div>
                            <div class="river-bed mb-3">
                                Date:<br>
                                <b>${response.data.appointment_date}</b>
                            </div>
                            <div class="mb-3">
                                <a href="#" class="btn btn-primary btn-md blue-alter move_appointment">Move Appointment</a>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Status </label>
                                <input type="hidden" name="appointment_id" value=${response.data.id}>
                                <select class="form-select form-control change_status" id="appointment_status">
                                    <option value="1">Booked</option>
                                    <option value="2">Confirmed</option>
                                    <option value="3">Started</option>
                                    <option value="4">Completed</option>
                                    <option value="5">No Answer</option>
                                    <option value="6">Left Message</option>
                                    <option value="7">Pencilied In</option>
                                    <option value="8">Turned Up</option>
                                    <option value="9">No Show</option>
                                    <option value="10">Cancelled</option>
                                </select>
                            </div>
                            <div class="river-bed mb-3 reminder">
                                Reminder<br>
                                <div class="d-flex align-items-center mt-1"><span class="ico-clock me-1 fs-5"></span> SMS to be sent</div>
                            </div>
                            <div class="orange-box mb-3">
                                <p><b id='servicename'>${response.data.services_name}</b>
                                <label id='servicewithdoctor'>${response.data.appointment_time} with ${response.data.staff_name}</label></p>
                                <input type="hidden" id="check_edit_appt" value="">
                                <input type="hidden" id="service_name" value="${response.data.services_name}">
                                <input type="hidden" id="service_id" value="${response.data.service_id}">
                                <input type="hidden" id="category_id" value="${response.data.category_id}">
                                <input type="hidden" id="client_id" value="${response.data.client_data.id}">
                                <input type="hidden" id="client_name" value="${response.data.client_data.first_name+' '+response.data.client_data.last_name}">
                                <input type="hidden" id="duration" value="${response.data.duration}">
                                <input type="hidden" id="appointment_time" value="${response.data.appointment_time}">
                                <input type="hidden" id="staff_name" value="${response.data.staff_name}">
                                <input type="hidden" id="staff_id" value="${response.data.staff_id}">
                            </div>
                            <div class="btns mb-3">
                                <button class="btn btn-secondary btn-sm" id="edit_appointment" event_id="${response.data.id}" staff_id="${response.data.staff_id}" appointment_date="${response.data.appointment_date}" appointment_time="${response.data.appointment_time}" staff_name="${response.data.staff_name}" service_name="${response.data.services_name}" duration="${response.data.duration}" category_id="${response.data.category_id}" services_id="${response.data.service_id}" client-id="${response.data.id}" client-name="${response.data.client_data.first_name+' '+response.data.client_data.last_name}" edit-service-name="${response.data.service_id}">Edit Appt</button>
                                <button class="btn btn-secondary btn-sm">Edit Forms</button>
                                <button class="btn btn-secondary btn-sm rebook">Rebook</button>
                                <button class="btn btn-secondary btn-sm repeat_appt">Repeat Appt</button>
                                <button class="btn btn-secondary btn-sm">Messages</button>
                                <button class="btn btn-secondary btn-sm">Send appt details</button>
                            </div>
                            <a href="#" class="btn btn-primary btn-md mb-2 d-block">Make Sale</a>

                            <div class="text-end">
                                <a href="javascript:void(0)" class="btn btn-primary btn-md blue-alter" id="deleteAppointment">Delete</a>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="form-label">Notes</label>
                                <textarea rows="4" class="form-control" placeholder="Click to edit" id="commonNotes"></textarea>
                                <label class="form-label">Treatment Notes</label>
                                <textarea rows="4" class="form-control" placeholder="Click to edit" id="treatmentNotes"></textarea>
                            </div>
                            </div>`
                    );
                },
                error: function (error) {
                    console.error('Error fetching events:', error);
                }
            });

            $(document).on("keyup", '#commonNotes', function() {
                var appointmentId       = $('#clientDetails').find('input:hidden[name=appointment_id]').val(),
                        commonNotes     = $('#commonNotes').val();
                        clientId        = $('.open-client-card-btn').data('client-id');

                context.commonNoteAddUpdateAjax(appointmentId,commonNotes,clientId);
            });

            $(document).on("keyup", '#treatmentNotes', function() {
                var appointmentId       = $('#clientDetails').find('input:hidden[name=appointment_id]').val(),
                    treatmentNotes      = $('#treatmentNotes').val();
                        clientId        = $('.open-client-card-btn').data('client-id');

                context.treatmentNoteAddUpdateAjax(appointmentId,treatmentNotes,clientId);
            });

            // Update appointment status
            $(document).on('change', '.change_status', function(e) {
                var appointmentId = $('#clientDetails').find('input:hidden[name=appointment_id]').val(),
                    status        = $('#appointment_status').val(),
                    data          =  {
                        'status'      : status,
                        'event_id'    : appointmentId,
                    };

                $.ajax({
                    url: moduleConfig.updateAppointmentStatus,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: data,
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

            });
        },

        // Delete Appointment
        deleteAppointment: function(){
            var context = this;
            $(document).on("click", '#deleteAppointment', function() {
                var appointmentId       = $('#clientDetails').find('input:hidden[name=appointment_id]').val();
                if(confirm("Are you sure to delete this appointment?")){
                    $.ajax({
                        url: moduleConfig.DeleteAppointment.replace(':ID', appointmentId),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data.success) {

                                $('.summry-header').remove();
                                $('#editEventData').remove();
                                // context.calendar.refetchEvents();
                                // console.log(context.calendar.refetchEvents());
                                // $('#calendar').fullCalendar( 'refetchEvents' );
                                // context.calendar.render();
                                Swal.fire({
                                    title: "Appointment!",
                                    text: data.message,
                                    info: "success",
                                });
                                location.reload();
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
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    // Update the FullCalendar resources with the retrieved data
                    context.calendar.setOption('resources', data);
                    context.calendar.refetchEvents(); // Refresh events if needed

                    $('#staff').empty();
                    $('#staff').append(`<option value="all">All staff</option>
                    <option disabled>Individual staff</option>`);

                    if (data && data.length > 0) {
                        data.forEach(function (name) {
                            let fullName = name.title;
                            let id = name.id;
                            $('#staff').append($('<option>', { value: id, text: fullName }));
                        });
                    }
                },
                error: function (error) {
                    console.error('Error fetching resources:', error);
                }
            });
        },

        // For create appointment
        createAppointmentDetails: function(resourceId,start_date,start_time,end_time,durationInMinutes,client_id,service_id,category_id,app_id){
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
                    'category_id' : category_id,
                    'app_id'      : app_id
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
        // dharit:function(...$this)

        // For update appointment
        updateAppointmentDetails: function(data){
            $.ajax({
                url: moduleConfig.updateAppointment,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
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

            context.selectors.newAppointmentBtn.on('click', function(e)
            {
                var locationId = jQuery('#locations').val();
                // get all the services related to location
                context.selectors.appointmentModal.modal('show');
            });

            // var openModal = sessionStorage.getItem('openModal');
            // if (openModal === 'true') {
            //     // Clear session storage value
            //     sessionStorage.removeItem('openModal');

            //     // Open the modal
            //     context.selectors.appointmentModal.modal('show');
            // }
        },

        changeServices: function(){
            var context = this;
            jQuery('.parent_category_id').on('click', function(e) {
                e.preventDefault();
                var $this           = $(this),
                    categoryId      = $this.data('category_id'),
                    duration        = $this.data('duration'),
                    categoryTitle   = $this.text();
                $(this).closest('li').addClass('selected');
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
                            $("#sub_services").append(`<li><a href='javascript:void(0);' class='services' data-services_id=${item.id} data-category_id=${item.category_id} data-duration=${item.duration}>${item.service_name}</a></li>`);
                        });
                    },
                    error: function (error) {
                        console.error('Error fetching resources:', error);
                    }
                });
            });

            jQuery('.edit_parent_category_id').on('click', function(e) {
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
                        $('#edit_sub_services').empty();
                        $.each(data, function(index, item) {
                            $("#edit_sub_services").append(`<li><a href='javascript:void(0);' class='services' data-services_id=${item.id} data-category_id=${item.category_id} data-duration=${item.duration}>${item.service_name}</a></li>`);
                        });
                    },
                    error: function (error) {
                        console.error('Error fetching resources:', error);
                    }
                });
            });

            jQuery('.edit_waitlist_parent_category_id').on('click', function(e) {
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
                        $('#waitlist_sub_services').empty();
                        $.each(data, function(index, item) {
                            $("#waitlist_sub_services").append(`<li><a href='javascript:void(0);' class='services' data-services_id=${item.id} data-category_id=${item.category_id} data-duration=${item.duration}>${item.service_name}</a></li>`);
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

                $('#edit_sub_services').on('click', '.services', function(e) {

 
                    e.preventDefault();
                    var $this           = $(this),
                        serviceId       = $this.data('services_id'),
                        categoryId      = $this.data('category_id'),
                        duration        = $this.data('duration'),
                        serviceTitle    = $this.text();
                        var app_date = $('#latest_start_time').val();//$('#edit_appointment').attr('appointment_date'); 
                        var app_time =$('#latest_end_time').val();//$('#edit_appointment').attr('appointment_time'); 
                        var staff_name = $('#edit_appointment').attr('staff_name');                        ;

                    $("#edit_selected_services").append(`<li class='selected remove'  data-appointment_date= "${app_date}" data-appointment_time= "${app_time}" data-staff_name= "${staff_name}"  data-services_id= ${serviceId}  data-category_id= ${categoryId}  data-duration='${duration}'><a href='javascript:void(0);' > ${serviceTitle} </a><span class='btn btn-cross cross-red remove_services'><i class='ico-close'></i></span></li>`);
                });

                $('#waitlist_sub_services').on('click', '.services', function(e) {
                    e.preventDefault();
                    var $this           = $(this),
                        serviceId       = $this.data('services_id'),
                        categoryId      = $this.data('category_id'),
                        duration        = $this.data('duration'),
                        serviceTitle    = $this.text();
                        var app_date = $('#latest_start_time').val();//$('#edit_appointment').attr('appointment_date'); 
                        var app_time =$('#latest_end_time').val();//$('#edit_appointment').attr('appointment_time'); 
                        var staff_name = $('#edit_appointment').attr('staff_name');                        ;

                    $("#edit_waitlist_selected_services").append(`<li class='selected remove'  data-appointment_date= "${app_date}" data-appointment_time= "${app_time}" data-staff_name= "${staff_name}"  data-services_id= ${serviceId}  data-category_id= ${categoryId}  data-duration='${duration}'><a href='javascript:void(0);' > ${serviceTitle} </a><span class='btn btn-cross cross-red remove_services'><i class='ico-close'></i></span></li>`);
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
                var ser_ids = $(this).closest('li').attr('data-services_id');
                $('.service_selected').each(function(index, element) {
                    var id=ser_ids;
                    if($(element).find('.services').attr('data-services_id') == id)
                    {
                        $(element).removeClass('selected');
                    }
                });
            });
            jQuery('#edit_selected_services').on('click',".remove_services", function(e) {
                e.preventDefault();
                $(this).closest('li').remove();
                var ser_ids = $(this).closest('li').attr('data-services_id');
                $('.service_selected').each(function(index, element) {
                    var id=ser_ids;
                    if($(element).find('.services').attr('data-services_id') == id)
                    {
                        $(element).removeClass('selected');
                    }
                });
            });
            jQuery('#edit_waitlist_selected_services').on('click',".remove_services", function(e) {
                e.preventDefault();
                $(this).closest('li').remove();
                var ser_ids = $(this).closest('li').attr('data-services_id');
                var sel_id='';
                $('.service_selected').each(function(index, element) {
                    var id=ser_ids;
                    if($(element).find('.services').attr('data-services_id') == id)
                    {
                        $(element).removeClass('selected');
                        sel_id = $(element).find('.services').attr('data-category_id');
                    }
                });
                
                $('#edit_waitlist_selected_services').find('.selected').each(function(index) {
                    var ca_id = $(this).attr('data-category_id');
                    var ca_id_array = ca_id.split(',');
                    var indexToRemove = ca_id_array.indexOf(sel_id);
                    if (indexToRemove !== -1) {
                        // Value already exists, no need to push again
                        console.log('Value already exists in ca_id_array:', sel_id);
                        ca_id_array.push(sel_id);
                        
                        // Convert ca_id_array back to a comma-separated string
                        var updated_ca_id = ca_id_array.join(',');
                        
                        // Output the updated value
                        console.log('Updated ca_id:', updated_ca_id);
                        
                        // Update the data-category_id attribute
                        $(this).attr('data-category_id', updated_ca_id);
                    } else {
                        // Value does not exist, push it into ca_id_array
                        ca_id_array.push(sel_id);
                        
                        // Convert ca_id_array back to a comma-separated string
                        var updated_ca_id = ca_id_array.join(',');
                        
                        // Output the updated value
                        console.log('Updated ca_id:', updated_ca_id);
                        
                        // Update the data-category_id attribute
                        $(this).attr('data-category_id', updated_ca_id);
                    }
                });                
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
                var clientselectedServicesCount = $('#selected_services').children("li").length,
                    clientName                  = $('#clientDetailsModal').text();
                // console.log(clientName);

                if($('#check_client').val() == 'new_client')
                {
                    if ($("#create_client").valid()) {
                        var data = $('#create_client').serialize();
                        SubmitCreateClient(data);
                        if(clientName === "")
                        {
                            console.log('in if');
                            $('#client').show();
                        }
                        else
                        {
                            $('#client').hide();
                        }

                        if(clientselectedServicesCount == 0 )
                        {
                            $('#service_error').show();
                        }
                        else{
                            $('#service_error').hide();
                            // Check if the form is valid or not

                            var resultElement = document.getElementById("clientDetails"),
                                details =  `<div class="summry-header"><span class="ico-clock me-2 fs-4"></span> Appointment Summary</div>`;
                            resultElement.innerHTML += details;
                            var count = 0;
                            $("#selected_services > li").each(function(){
                                var $this           = $(this),
                                eventName           = $(this).text(),
                                eventId             = $(this).data('services_id');
                                categoryId          = $(this).data('category_id');
                                duration            = $(this).data('duration');
                                clientName          = $('#clientDetails').find('input:hidden[name=client_name]').val();
                                clientId            = $('#clientDetails').find('input:hidden[name=client_id]').val();
                                // Increment the counter
                                count++;
                                // $('#mycalendar').remove();
                                $('#external-events').removeAttr('style');
                                if (count === 1) {
                                    $('#external-events').append(`
                                        <div class="drag-box mb-3">
                                            <div class="head mb-2"><b>Drag and drop on</b> to a day on the appointment book
                                                <i class="ico-noun-arrow"></i></div>
                                            <div class="treatment fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event" data-service_id="${eventId}" data-service_name="${eventName}" data-client_name="${clientName}" data-duration="${duration}" data-client_id="${clientId}" data-category_id="${categoryId}">
                                                ${eventName}
                                            </div>
                                        </div>
                                        <div class="btns mb-3">
                                            <button class="btn btn-secondary btn-sm" id="edit_created_appointment" event_id="${eventId}" service_name="${eventName}" services_id="${eventId}"  category_id="${categoryId}"  duration="${duration}"  client-id="${clientId}" client-name="${clientName}" edit-service-name="${eventId}">Edit Appt</button>
                                            <button class="btn btn-secondary btn-sm">Repeat appt</button>
                                            <button class="btn btn-secondary btn-sm">Messages</button>
                                        </div>
                                        <div class="text-end">
                                            <a href="#" class="btn btn-primary btn-md blue-alter" id="appointment_cancel">Cancel</a>
                                        </div>`);
                                } else if (count > 1) {
                                    $('.drag-box').append(`
                                            <div class="treatment fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event" data-service_id="${eventId}" data-service_name="${eventName}" data-client_name="${clientName}" data-duration="${duration}" data-client_id="${clientId}" data-category_id="${categoryId}">
                                                ${eventName}
                                            </div>
                                        `);
                                }                            
                            });

                            context.selectors.appointmentModal.modal('hide');
                            //for reload all services & selected services
                            // $("#all_ser").load(location.href+" #all_ser>*","");
                            $("#selected_services").empty();
                        }
                    } else {
                        // Prevent the form from being submitted if it's not valid
                        e.preventDefault();
                    }
                }else{
                    if(clientName === "")
                    {
                        console.log('in if');
                        $('#client').show();
                    }
                    else
                    {
                        $('#client').hide();
                    }

                    if(clientselectedServicesCount == 0 )
                    {
                        $('#service_error').show();
                    }
                    else{
                        $('#service_error').hide();
                        // Check if the form is valid or not

                        var resultElement = document.getElementById("clientDetails"),
                            details =  `<div class="summry-header"><span class="ico-clock me-2 fs-4"></span> Appointment Summary</div>`;
                        resultElement.innerHTML += details;

                        var count = 0;
                        $("#selected_services > li").each(function(){
                            var $this           = $(this),
                            eventName           = $(this).text(),
                            eventId             = $(this).data('services_id');
                            categoryId          = $(this).data('category_id');
                            duration            = $(this).data('duration');
                            clientName          = $('#clientDetails').find('input:hidden[name=client_name]').val();
                            clientId            = $('#clientDetails').find('input:hidden[name=client_id]').val();
                            // Increment the counter
                            count++;
                            // $('#mycalendar').remove();
                            $('#external-events').removeAttr('style');
                            if (count === 1) {
                                $('#external-events').append(`
                                    <div class="drag-box mb-3">
                                        <div class="head mb-2"><b>Drag and drop on</b> to a day on the appointment book
                                            <i class="ico-noun-arrow"></i></div>
                                        <div class="treatment fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event" data-service_name="${eventName}" data-service_id="${eventId}" data-client_name="${clientName}" data-duration="${duration}" data-client_id="${clientId}" data-category_id="${categoryId}">
                                            ${eventName}
                                        </div>
                                    </div>
                                    <div class="btns mb-3">
                                        <button class="btn btn-secondary btn-sm" id="edit_created_appointment" event_id="${eventId}" service_name="${eventName}" services_id="${eventId}"  category_id="${categoryId}"  duration="${duration}"  client-id="${clientId}" client-name="${clientName}" edit-service-name="${eventId}">Edit Appt</button>
                                        <button class="btn btn-secondary btn-sm">Repeat appt</button>
                                        <button class="btn btn-secondary btn-sm">Messages</button>
                                    </div>
                                    <div class="text-end">
                                        <a href="#" class="btn btn-primary btn-md blue-alter" id="appointment_cancel">Cancel</a>
                                    </div>`);
                            } else if (count > 1) {
                                $('.drag-box').append(`
                                            <div class="treatment fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event" data-service_name="${eventName}" data-service_id="${eventId}" data-client_name="${clientName}" data-duration="${duration}" data-client_id="${clientId}" data-category_id="${categoryId}">
                                                ${eventName}
                                            </div>
                                        `);
                            }                            
                        });

                        context.selectors.appointmentModal.modal('hide');
                        //for reload all services & selected services
                        // $("#all_ser").load(location.href+" #all_ser>*","");
                        $("#selected_services").empty();
                    }
                }

                
            });
        },

        //appointment save
        appointmentUpdateBtn: function(){
            var context = this;
            // Validate the client form
            $("#edit_client").validate({
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

            $('#appointmentUpdateBtn').on('click', function(e) {
                e.preventDefault(); // Prevent default form submission behavior
                var clientselectedServicesCount = $('#edit_selected_services').children("li").length,
                    clientName                  = $('#clienteditDetailsModal').text();
                // console.log(clientName);

                if($('#check_client').val() == 'new_client')
                {
                    if ($("#edit_client").valid()) {
                        var data = $('#edit_client').serialize();
                        SubmitEditClient(data);
                        if(clientName === "")
                        {
                            console.log('in if');
                            $('#client').show();
                            return false;
                        }
                        else
                        {
                            $('#client').hide();
                        }

                        if(clientselectedServicesCount == 0 )
                        {
                            $('#service_error').show();
                        }
                        else{
                            $('#service_error').hide();
                            // Check if the form is valid or not

                            var resultElement = document.getElementById("clientDetails"),
                                details =  `<div class="summry-header"><span class="ico-clock me-2 fs-4"></span> Appointment Summary</div>`;
                            resultElement.innerHTML += details;
                            $('.reminder').next('.orange-box').remove();

                            var appointmentsData = []; // Array to store appointment data
                            $('.treatment').remove();
                            $("#edit_selected_services > li").each(function() {
                                var $this = $(this),
                                    eventName = $(this).text(),
                                    eventId = $(this).data('services_id'),
                                    categoryId = $(this).data('category_id'),
                                    duration = $(this).data('duration'),
                                    clientName = $('#clientDetails').find('input:hidden[name=client_name]').val(),
                                    clientId = $('#clientDetails').find('input:hidden[name=client_id]').val(),
                                    appointmentDate = $(this).data('appointment_date'),
                                    appointmentTime = $(this).data('appointment_time'),
                                    staffId = $(this).data('staff_name'),
                                    staffName = $(this).data('staff_name');
                        
                                const parsedDate = moment(appointmentDate, 'ddd DD MMM YYYY').format('YYYY-MM-DD');
                                const parsedTime = moment(appointmentTime, 'hh:mm a').format('HH:mm:ss');
                                const dateTimeString = `${parsedDate}T${parsedTime}`;
                        
                                // Push appointment data to the array
                                appointmentsData.push({
                                    'staff_id': $('#latest_staff_id').val(),//$('#edit_appointment').attr('staff_id'),
                                    'start_date': moment().format('YYYY-MM-DD'),
                                    'start_time': moment(dateTimeString).format('YYYY-MM-DDTHH:mm:ss'),
                                    'end_time': moment(dateTimeString).add(duration, 'minutes').format('YYYY-MM-DDTHH:mm:ss'),
                                    'duration': duration,
                                    'client_id': clientId,
                                    'service_id': eventId,
                                    'category_id': categoryId,
                                    'event_id': $('#event_id').val(),//$('#edit_appointment').attr('event_id'),
                                });
                                if($('#is_app_created').val() == '1'){
                                    
                                    $('#external-events').removeAttr('style');
                                    $('.drag-box').append(`
                                            <div class="treatment fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event" data-service_name="${eventName}" data-service_id="${eventId}" data-client_name="${clientName}" data-duration="${duration}" data-client_id="${clientId}" data-category_id="${categoryId}">
                                                ${eventName}
                                            </div>
                                        `);
                                    // $('#external-events').append(`
                                    //     <div class="orange-box mb-3">
                                    //         <p><b>${eventName}</b>
                                    //         ${appointmentTime} with ${staffName}</p>
                                    //         <input type="hidden" id="service_name" value="${eventName}">
                                    //         <input type="hidden" id="service_id" value="${eventId}">
                                    //         <input type="hidden" id="category_id" value="${categoryId}">
                                    //         <input type="hidden" id="client_id" value="${clientId}">
                                    //         <input type="hidden" id="client_name" value="${clientName}">
                                    //         <input type="hidden" id="duration" value="${duration}">
                                    //     </div>
                                    // `);
                                }
                            });
                            if($('#is_app_created').val() != '1'){
                                $.ajax({
                                    url: '../calender/update-create-appointments',
                                    type: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data: {
                                        appointments: appointmentsData
                                    },
                                    success: function(data) {
                                        if (data.success) {
                                            Swal.fire({
                                                title: "Appointments Updated!",
                                                text: data.message,
                                                icon: "success",
                                            }).then(function() {
                                                // Reload the current page
                                                location.reload();
                                            });
                                        } else {
                                            Swal.fire({
                                                title: "Error!",
                                                text: data.message,
                                                icon: "error",
                                            });
                                        }
                                    },
                                    error: function(error) {
                                        console.error('Error fetching resources:', error);
                                    }
                                });
                            }
                            // Fire AJAX request after collecting all appointment data
                            
                        
                            $('#Edit_appointment').modal('hide');
                            $("#all_ser").load(location.href + " #all_ser>*", "");
                            $("#edit_selected_services").empty();
                        }
                    } else {
                        // Prevent the form from being submitted if it's not valid
                        e.preventDefault();
                    }
                }else{
                    if(clientName === "")
                    {
                        console.log('in if');
                        $('#client').show();
                        return false;
                    }
                    else
                    {
                        $('#client').hide();
                    }

                    if(clientselectedServicesCount == 0 )
                    {
                        $('#service_error').show();
                    }
                    else{
                        $('#service_error').hide();
                        // Check if the form is valid or not

                        var resultElement = document.getElementById("clientDetails"),
                            details =  `<div class="summry-header"><span class="ico-clock me-2 fs-4"></span> Appointment Summary</div>`;
                        resultElement.innerHTML += details;
                        $('.reminder').next('.orange-box').remove();

                        var appointmentsData = []; // Array to store appointment data
                        $('.treatment').remove();
                        $("#edit_selected_services > li").each(function() {
                            var $this = $(this),
                                eventName = $(this).text(),
                                eventId = $(this).data('services_id'),
                                categoryId = $(this).data('category_id'),
                                duration = $(this).data('duration'),
                                clientName = $('#clientDetails').find('input:hidden[name=client_name]').val(),
                                clientId = $('#clientDetails').find('input:hidden[name=client_id]').val(),
                                appointmentDate = $(this).data('appointment_date'),
                                appointmentTime = $(this).data('appointment_time'),
                                staffId = $(this).data('staff_name'),
                                staffName = $(this).data('staff_name');
                    
                            const parsedDate = moment(appointmentDate, 'ddd DD MMM YYYY').format('YYYY-MM-DD');
                            const parsedTime = moment(appointmentTime, 'hh:mm a').format('HH:mm:ss');
                            const dateTimeString = `${parsedDate}T${parsedTime}`;
                    
                            // Push appointment data to the array
                            appointmentsData.push({
                                'staff_id': $('#latest_staff_id').val(),//$('#edit_appointment').attr('staff_id'),
                                'start_date': moment().format('YYYY-MM-DD'),
                                'start_time': moment(dateTimeString).format('YYYY-MM-DDTHH:mm:ss'),
                                'end_time': moment(dateTimeString).add(duration, 'minutes').format('YYYY-MM-DDTHH:mm:ss'),
                                'duration': duration,
                                'client_id': clientId,
                                'service_id': eventId,
                                'category_id': categoryId,
                                'event_id': $('#event_id').val(),//$('#edit_appointment').attr('event_id'),
                            });
                            if($("#is_app_created").val()=='1'){
                                
                                $('#external-events').removeAttr('style');
                                    $('.drag-box').append(`
                                            <div class="treatment fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event" data-service_name="${eventName}" data-service_id="${eventId}" data-client_name="${clientName}" data-duration="${duration}" data-client_id="${clientId}" data-category_id="${categoryId}">
                                                ${eventName}
                                            </div>
                                        `);
                                // $('.reminder').append(`
                                //     <div class="orange-box mb-3">
                                //         <p><b>${eventName}</b>
                                //         ${appointmentTime} with ${staffName}</p>
                                //         <input type="hidden" id="service_name" value="${eventName}">
                                //         <input type="hidden" id="service_id" value="${eventId}">
                                //         <input type="hidden" id="category_id" value="${categoryId}">
                                //         <input type="hidden" id="client_id" value="${clientId}">
                                //         <input type="hidden" id="client_name" value="${clientName}">
                                //         <input type="hidden" id="duration" value="${duration}">
                                //     </div>
                                // `);
                            }

                        });
                        if($("#is_app_created").val() != '1'){
                            // Fire AJAX request after collecting all appointment data
                            $.ajax({
                                url: '../calender/update-create-appointments',
                                type: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    appointments: appointmentsData
                                },
                                success: function(data) {
                                    if (data.success) {
                                        Swal.fire({
                                            title: "Appointments Updated!",
                                            text: data.message,
                                            icon: "success",
                                        }).then(function() {
                                            // Reload the current page
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire({
                                            title: "Error!",
                                            text: data.message,
                                            icon: "error",
                                        });
                                    }
                                },
                                error: function(error) {
                                    console.error('Error fetching resources:', error);
                                }
                            });
                        }
                        $('#Edit_appointment').modal('hide');
                        $("#all_ser").load(location.href + " #all_ser>*", "");
                        $("#edit_selected_services").empty();
                    }
                }

                
            });
        },

        // Cancel appointment
        appointmentCancel: function(){
            $(document).on("click", '#appointment_cancel', function() {
                $('.summry-header').remove();
                $('#external-events').empty();
            });
        },

        openClientCardModal: function(){
            var context = this;

            $(document).on('click','.open-client-card-btn', function(e){
                var clientId = $(this).data('client-id'); // Use data('client-id') to access the attribute

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
                        clientId         = $('#clientcardid').data('client_id');

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
            jQuery('#New_appointment').on('hide.bs.modal', function()
            {
                $('.clientCreateModal').show();
                $('#clientmodal').hide();
                $("#selected_services").empty();
            });
        },

        closeReAppointmentModal: function(){
            jQuery('#repeat_Appointment').on('hide.bs.modal', function()
            {
                $('#repeatappt')[0].reset();
            });
        },

        getOrdinalSuffix: function(weekofmonth){
            if (weekofmonth % 10 === 1 && weekofmonth !== 11) {
                return weekofmonth + "st";
            } else if (weekofmonth % 10 === 2 && weekofmonth !== 12) {
                return weekofmonth + "nd";
            } else if (weekofmonth % 10 === 3 && weekofmonth !== 13) {
                return weekofmonth + "rd";
            } else {
                return weekofmonth + "th";
            }
        },

        openResetAppointmentModal: function(){
            var context     = this;

            $(document).on('click','.repeat_appt', function(e){

                context.selectors.repeatAppointmentModal.modal('show');

                var clientName              = $('#clientDetails').find('input:hidden[name=client_name]').val(),
                    servicename             = $('#clientDetails').find('#servicename').text(),
                    servicewithdoctor       = $('#clientDetails').find('#servicewithdoctor').text(),
                    appointmentdate         = $('#clientDetails').find('#start_date').val(),
                    appointmentduration     = $('#clientDetails').find('input:hidden[name=appointment_duration]').val();

                var weekdate        = moment(appointmentdate),
                    days            = moment(appointmentdate).format("dddd"),
                    monthname       = moment(appointmentdate).format("MMMM"),
                    monthdigit      = moment(appointmentdate).format("Do"),
                    weekofmonth     = weekdate.isoWeek() - moment(weekdate).startOf('month').isoWeek() + 1;

                $('#repeat_name').text(clientName);
                $('#repeat_services_name').text(servicename);
                $('#servicewithdoctorname').text(servicewithdoctor);
                $('#appointment_date').val(appointmentdate);
                $('#appointment_duration').val(appointmentduration);

                $('.year').text(`On the ${monthdigit} of ${monthname}`);
                $('.week_year').text(`On the ${context.getOrdinalSuffix(weekofmonth)} ${days} of ${monthname}`);

                $('#repeat_every_month').text(`On the ${monthdigit} day of the month`);
                $('#repeat_every_month_weekday').text(`On the ${context.getOrdinalSuffix(weekofmonth)} ${days} of the month`);
                $('.repeat_every_month_weekday').val(`On the ${context.getOrdinalSuffix(weekofmonth)} ${days} of the month`);

                $('#repeat_day').val(days);
                $('#repeat_year_month').val(moment(appointmentdate).format("M"));

                $(`input[type=checkbox][value=${moment(appointmentdate).day()}]`).prop("checked",true);

                var startdate = $("#appointment_date").val();

                $("#stop_repeating_date").datepicker({
                    minDate: startdate,
                    dateFormat: 'yy-mm-d'
                });
                // var item = $(".repeat_every :selected").val();

                // if(item === 'day')
                // {
                //     $('#days').hide();
                // }
                // if(item === 'week')
                // {
                //     $('#days').show();
                // }
                // if(item === 'year')
                // {
                //     $('#days').hide();
                //     $('#years').show();
                // }

                // $("#stop_repeating_date").datepicker({ minDate: 0 });
                // $('#days').hide();
                // $('#years').hide();
                // $('#month').hide();

                $(document).on('change', '.repeat_every', function(e) {
                    var item = $(".repeat_every :selected").val();
                    if(item === 'day')
                    {
                        $('#days').hide();
                        $('#years').hide();
                    }
                    if(item === 'week')
                    {
                        $('#days').show();
                        $('#month').hide();
                        $('#years').hide();
                    }
                    if(item === 'month')
                    {
                        $('#month').show();
                        $('#days').hide();
                        $('#years').hide();
                    }

                    if(item === 'year')
                    {
                        $('#years').show();
                        $('#month').hide();
                        $('#days').hide();
                    }
                });
            });
        },

        // repeatAppointmentValidation: function(){
        //     var context = this;
        //     console.log('in function');
        //     context.selectors.repeatAppointmentForm.validate({
        //         rules: {
        //             stop_repeating: {
        //                 required: true
        //             }
        //         },
        //         messages: {
        //             stop_repeating: {
        //                 required: "Please enter price",
        //             },
        //         },
        //         errorPlacement: function (error, element) {
        //             console.log('test'+element);
        //             if (element.attr("type") == "checkbox") {
        //                 error.insertAfter($(element).closest('div'));
        //             } else {
        //                 error.insertAfter($(element));
        //             }
        //         },
        //     });
        // },

        repeatAppointmentSaveBtn: function(){
            var context = this;
            $('#repeatappt').on('submit' ,function(e){
                e.preventDefault();
                var option = document.getElementsByName('stop_repeating');

                if (!(option[0].checked || option[1].checked)) {
                    $("#repeat_error").show();
                    return false;
                }

                var Form        = new FormData($('#repeatappt')[0]);
                client_id       = $('#clientDetails').find('input:hidden[name=client_id]').val(),
                category_id     = $('#clientDetails').find('input:hidden[name=category_id]').val(),
                service_id      = $('#clientDetails').find('input:hidden[name=service_id]').val(),
                staff_id        = $('#clientDetails').find('input:hidden[name=staff_id]').val();
                duration        = $('#clientDetails').find('input:hidden[name=appointment_duration]').val();

                Form.append('client_id',client_id);
                Form.append('category_id',category_id);
                Form.append('service_id',service_id);
                Form.append('staff_id',staff_id);
                Form.append('duration',duration);

                $.ajax({
                    headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: moduleConfig.repeatAppointment,
                    type: 'POST',
                    data: Form,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    // headers: {
                    //     'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    // },
                    success: function (data) {
                        if (data.success) {
                            Swal.fire({
                                title: "Appointment!",
                                text: data.message,
                                info: "success",
                            });
                            location.reload();
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: data.message,
                                info: "error",
                            });
                        }
                    },
                    error: function (error) {
                        console.error('Error fetching events:', error);
                    }
                });

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
        // $('#clientDetails').find('input:hidden[name=client_name]').val()
        // $('.client_detail').hide();
        // $('.client_edit_change').show();
        // $('#clienteditDetailsModal').show();

        $('.clientEditModal').hide();
        $('#clienteditmodal').show();
        $("#clienteditDetailsModal").html(`<i class='ico-user2 me-2 fs-6'></i> ${$('#clientDetails').find('input:hidden[name=client_name]').val()}`);
    })

    $('.client_change').click(function(){
        $('.clientCreateModal').show();
        $('#clientmodal').hide();
    })
    $('.client_edit_change').click(function(){
        $('.clientEditModal').show();
        $('#clienteditmodal').hide();
    })
    $('.client_waitlist_change').click(function(){
        $('.clientWaitListEditModal').show();
        $('#clientWaitListEditModal').hide();
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
                    // $('#client_name').val(response.data.firstname + ' ' + response.data.lastname);
                    // $('#client_id').val(response.data.id);
                    var clientName = response.data.firstname + ' ' + response.data.lastname;
                    $('.treatment').each(function() {
                        $(this).attr('data-client_name', clientName);
                        $(this).attr('data-client_id', response.data.id);
                    });
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
                        `<div class="client-name">
                                <div class="drop-cap" style="background: #D0D0D0; color:#fff;">${response.data.firstname.charAt(0).toUpperCase()}
                                </div>
                                <div class="client-info">
                                    <input type='hidden' name='client_name' value='${response.data.firstname} ${response.data.lastname}'>
                                    <input type='hidden' id="client_id" name='client_id' value='${response.data.id}'>
                                    <h4 class="blue-bold">${response.data.firstname} ${response.data.lastname}</h4>
                                </div>
                            </div>
                            <div class="mb-2">
                                <a href="#" class="river-bed"><b>${response.data.mobile_number}</b></a><br>
                                <a href="#" class="river-bed"><b>${response.data.email}</b></a>
                            </div>
                            <hr>
                            <div class="btns">
                                <button class="btn btn-secondary btn-sm open-client-card-btn" data-client-id="${response.data.id}" >Client Card</button>
                                <button class="btn btn-secondary btn-sm history" data-client-id="${response.data.id}" >History</button>
                                <button class="btn btn-secondary btn-sm upcoming" data-client-id="${response.data.id}" >Upcoming</button>
                            </div>
                            <hr>`
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
    function SubmitEditClient(data){
        var url = $("#clientEdit").data("url");
		$.ajax({
			headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: url,
			type: "post",
			data: data,
            async: false,
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
                        `<div class="client-name">
                                <div class="drop-cap" style="background: #D0D0D0; color:#fff;">${response.data.firstname.charAt(0).toUpperCase()}
                                </div>
                                <div class="client-info">
                                    <input type='hidden' name='client_name' value='${response.data.firstname} ${response.data.lastname}'>
                                    <input type='hidden' id="client_id" name='client_id' value='${response.data.id}'>
                                    <h4 class="blue-bold">${response.data.firstname} ${response.data.lastname}</h4>
                                </div>
                            </div>
                            <div class="mb-2">
                                <a href="#" class="river-bed"><b>${response.data.mobile_number}</b></a><br>
                                <a href="#" class="river-bed"><b>${response.data.email}</b></a>
                            </div>
                            <hr>
                            <div class="btns">
                                <button class="btn btn-secondary btn-sm open-client-card-btn" data-client-id="${response.data.id}" >Client Card</button>
                                <button class="btn btn-secondary btn-sm history" data-client-id="${response.data.id}" >History</button>
                                <button class="btn btn-secondary btn-sm upcoming" data-client-id="${response.data.id}" >Upcoming</button>
                            </div>
                            <hr>`
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