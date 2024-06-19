var DU = {};
(function () {
    DU.timetable = {
        calendar: null,
        selectors: {
            editWorkingModal:           jQuery('#edit_Working_hours'),
            copyTimetableModal:         jQuery('#copy_timetable_modal'),
            editTimetable:              jQuery('#edit_timetable'),
        },
        init: function (){
            this.addHandler();
        },

        addHandler: function (){
            var context = this;
            context.initialTimeTable();
            context.getlocationId();
            context.changelocation();
            context.newTimetableSection();
            context.createLeaveSection();
            context.btnEnabled();
            context.openCopyTimeTableModal();
            context.saveWorkingHours();

            $('.new_timetable_section').attr('style','display:none !important');
            $('.create_leave_section').attr('style','display:none !important');
            $('#lunch_start').hide();
            $('#lunch_duration').hide();


            $(document).on('click','input[name="sun"][type="checkbox"]',function(e){
                var sun = $('input[name="sun"][type="checkbox"]:checked').length;
                if (sun > 0 ) {
                    $(".sun_start_time").prop({disabled: false});
                    $(".sun_end_time").prop({disabled: false});

                    $(".lunch").prop({disabled: false});
                    $(".sun_break").prop({disabled: false});
                    $(".sun_custom").prop({disabled: false});
                } else {
                    $(".sun_start_time").prop({disabled: true});
                    $(".sun_end_time").prop({disabled: true});
                    $(".lunch").prop({disabled: true});
                }
            });

            $(document).on('click','.lunch',function(e){
                console.log($(this).data('weekdays'));
                var weekdays = $(this).data('weekdays');

                switch (weekdays) {
                    case 1:
                        $(this).removeClass('btn-primary');
                        $(this).addClass('btn-red');
                        $(this).addClass('remove_lunch');

                        $('.sun_leave_icon').removeClass('ico-add');
                        $('.sun_leave_icon').addClass('ico-trash');
                        break;

                    case 2:
                        $(this).removeClass('btn-primary');
                        $(this).addClass('btn-red');
                        $(this).addClass('remove_lunch');

                        break;
                    default:
                        break;
                }
                return false;
                console.log($('#lunch_start').data('appt_id'));

                $('.sun_leave_icon').removeClass('ico-add');
                $('.sun_leave_icon').addClass('ico-trash');

                $('#lunch_start').show();
                $('#lunch_duration').show();
            });

            $(document).on('click','.remove_lunch',function(e) {
                $('.remove_lunch').removeClass('btn-red');
                $('.remove_lunch').addClass('btn-primary');
                $('.remove_lunch').removeClass('remove_lunch');

                $('.sun_leave_icon').removeClass('ico-trash');
                $('.sun_leave_icon').addClass('ico-add');

                $('#lunch_start').hide();
                $('#lunch_duration').hide();
            });

        },

        initialTimeTable: function(){
            var context  = this;
            var calendarEl = document.getElementById('calendar');
            context.calendar = new FullCalendar.Calendar(calendarEl, {
                // timeZone: 'UTC',
                initialView: 'resourceTimelineWeek',
                headerToolbar: {
                    left: 'prev,today,next',
                    center: 'title',
                    right: 'resourceTimelineWeek,resourceTimelineMonth'
                },
                slotLabelFormat: [
                    { weekday: "short", day: "2-digit" , month: "2-digit"}, // lower level of text
                ],
                views: {
                    resourceTimelineWeek: {
                        slotDuration: {
                            days: 1
                        }
                    }
                },
                buttonText: {
                    today: 'Today',
                    week: 'Week',
                    month: 'Month'
                },
                editable: true,
                resourceAreaHeaderContent: 'Staff',
                resources:  [],
                events: [
                    {
                        resourceId: 66,
                        title: "Long Event",
                        start: "2024-06-17",
                        end: "2024-06-18"
                    },
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
                resourceLabelContent: function(arg) {
                    var resourceEl = document.createElement('div');
                    resourceEl.innerHTML = arg.resource.title;
                    resourceEl.classList.add('resource-label-dharit');
                    resourceEl.dataset.resourceId = arg.resource.id;
                    return { domNodes: [resourceEl] };
                },
                dateClick: function(info){
                    var currnetDate = moment(info.dateStr).format('ddd Do MMM YYYY');
                    $('.staff_name').html(info.resource._resource.title);
                    $('#staff_id').val(info.resource._resource.id);

                    $('.current_date').html(currnetDate);
                    $('#current_date').val(moment(info.dateStr).format('YYYY-MM-DD'));

                    $('#edit_Working_hours').modal('toggle');
                },
                datesSet: function (info) {
                    // info.start and info.end represent the new date range resourceTimeGridWeek
                    var start_date  = moment(info.startStr).format('YYYY-MM-DD'),
                        end_date    = moment(info.endStr).format('YYYY-MM-DD');

                    // Make an AJAX call to fetch events for the new date range
                    context.eventsList(start_date, end_date);
                },
                // events: 'https://fullcalendar.io/demo-events.json?single-day&for-resource-timeline'
            });
            context.calendar.render();

            // Event delegation for resource clicks
            document.addEventListener('click', function(event) {
                var resourceEl = event.target.closest('.resource-label-dharit');
                if (resourceEl) {
                    var resourceId = resourceEl.dataset.resourceId;

                    // Display the modal with resource details
                    $('#edit_timetable').modal('show');
                }
            });
        },

        getlocationId: function(){
            var context = this;
            var locationId = $('#location').val();
            context.changeStaff(locationId)
        },

        changelocation: function(){
            var context = this;
            jQuery('#location').on('change', function(e) {
                var location_id           = $(this).val();
                context.getlocationId(location_id);
            });
        },

        changeStaff: function(locationId){
            var context = this;
            $.ajax({
                url: moduleConfig.getStaffList,
                type: 'POST',
                data: {
                    'location_id'    : locationId,
                },
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    context.calendar.setOption('resources', data);
                },
                error: function (error) {
                    console.error('Error fetching on staff:', error);
                }
            });
        },

        newTimetableSection: function(){
            $(".new_timetable").click(function () {
                $('.new_timetable_section').attr('style','display:block !important');
            });

            $(".cancel_timetable").click(function () {
                $('.new_timetable_section').attr('style','display:none !important');
            });
        },

        createLeaveSection: function(){
            $(".create_leave").click(function () {
                $('.create_leave_section').attr('style','display:block !important');
            });

            $(".cancel_leave").click(function () {
                $('.create_leave_section').attr('style','display:none !important');
            });
        },

        btnEnabled: function(){
            $(document).on('click','input[name="time_check[]"][type="checkbox"]',function(e){
                var checkedCount = $('input[name="time_check[]"][type="checkbox"]:checked').length;
                if (checkedCount > 0 ) {
                    $(".repeat").prop({disabled: false});
                    $(".delete").prop({disabled: false});
                } else {
                    $(".repeat").prop({disabled: true});
                    $(".delete").prop({disabled: true});
                }
            });
        },

        openCopyTimeTableModal: function(){
            var context = this;

            $(document).on('click','#open_copy_timetable',function(e){
                context.selectors.copyTimetableModal.modal('show');
            });

            $('#copy_timetable_modal').on('show.bs.modal', function () {
                context.selectors.editTimetable.css('z-index', 1039);
            });

            $('#copy_timetable_modal').on('hidden.bs.modal', function () {
                document.getElementById('edit_timetable').style.removeProperty('z-index');
            });
        },

        saveWorkingHours: function(){
            $(document).on('click','#WorkingHoursBtn',function(e){
                var working_status          = $("li a.active").data('status'),
                    leave_reason            = $('#leave_reason :selected').val(),
                    current_date            = $('#current_date').val(),
                    staff_id                = $('#staff_id').val(),
                    working_start_time      = $('#working_start_time').val(),
                    working_end_time        = $('#working_end_time').val(),
                    lunch_start_time        = $('#lunch_start_time').val(),
                    lunch_duration_minutes  = $('#lunch_duration_minutes').val(),
                    break_start_time        = $('#break_start_time').val(),
                    break_duration          = $('#break_duration').val()

                    data  =  {
                        'working_status'         : working_status,
                        'leave_reason'           : leave_reason,
                        'staff_id'               : staff_id,
                        'current_date'           : current_date,
                        'working_start_time'     : working_start_time,
                        'working_end_time'       : working_end_time,
                        'lunch_start_time'       : lunch_start_time,
                        'lunch_duration_minutes' : lunch_duration_minutes,
                        'break_start_time'       : break_start_time,
                        'break_duration'         : break_duration
                    };

                $.ajax({
                    url: moduleConfig.updateWorkingHours,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: data,
                    success: function (data) {
                        console.log(data);
                        if (data.success) {
                            Swal.fire({
                                title: "Working Status!",
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
                    error: function (error) {
                        console.error('Error fetching resources:', error);
                    }
                });
            });
        },

        eventsList: function(start_date, end_date){
            var context = this;
            $.ajax({
                url: moduleConfig.getWorkingHours,
                type: 'POST',
                data: {
                    'start_date'    : start_date,
                    'end_date'      : end_date,
                },
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    console.log(data);
                    context.calendar.setOption('events', data);
                },
                error: function (error) {
                    console.error('Error fetching on staff:', error);
                }
            });
            context.calendar.render();

        },
    }
})();