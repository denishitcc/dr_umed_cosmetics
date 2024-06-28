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
            context.saveTimetable();

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
                    $(".break").prop({disabled: false});
                } else {
                    $(".sun_start_time").prop({disabled: true});
                    $(".sun_end_time").prop({disabled: true});
                    $(".lunch").prop({disabled: true});
                    $(".break").prop({disabled: true});
                }
            });


            $(document).on('click','input[name="mon"][type="checkbox"]',function(e){
                var mon = $('input[name="mon"][type="checkbox"]:checked').length;
                if (mon > 0 ) {
                    $(".mon_start_time").prop({disabled: false});
                    $(".mon_end_time").prop({disabled: false});
                    $(".mon_lunch").prop({disabled: false});
                    $(".mon_break").prop({disabled: false});
                } else {
                    $(".mon_start_time").prop({disabled: true});
                    $(".mon_end_time").prop({disabled: true});
                    $(".mon_lunch").prop({disabled: true});
                    $(".mon_break").prop({disabled: true});
                }
            });

            $(document).on('click','input[name="tue"][type="checkbox"]',function(e){
                var tue = $('input[name="tue"][type="checkbox"]:checked').length;
                if (tue > 0 ) {
                    $(".tue_start_time").prop({disabled: false});
                    $(".tue_end_time").prop({disabled: false});
                    $(".tue_lunch").prop({disabled: false});
                    $(".tue_break").prop({disabled: false});
                } else {
                    $(".tue_start_time").prop({disabled: true});
                    $(".tue_end_time").prop({disabled: true});
                    $(".tue_lunch").prop({disabled: true});
                    $(".tue_break").prop({disabled: true});
                }
            });

            $(document).on('click','input[name="wed"][type="checkbox"]',function(e){
                var wed = $('input[name="wed"][type="checkbox"]:checked').length;
                if (wed > 0 ) {
                    $(".wed_start_time").prop({disabled: false});
                    $(".wed_end_time").prop({disabled: false});
                    $(".wed_lunch").prop({disabled: false});
                    $(".wed_break").prop({disabled: false});
                } else {
                    $(".wed_start_time").prop({disabled: true});
                    $(".wed_end_time").prop({disabled: true});
                    $(".wed_lunch").prop({disabled: true});
                    $(".wed_break").prop({disabled: true});
                }
            });

            $(document).on('click','input[name="thu"][type="checkbox"]',function(e){
                var thu = $('input[name="thu"][type="checkbox"]:checked').length;
                if (thu > 0 ) {
                    $(".thu_start_time").prop({disabled: false});
                    $(".thu_end_time").prop({disabled: false});
                    $(".thu_lunch").prop({disabled: false});
                    $(".thu_break").prop({disabled: false});
                } else {
                    $(".thu_start_time").prop({disabled: true});
                    $(".thu_end_time").prop({disabled: true});
                    $(".thu_lunch").prop({disabled: true});
                    $(".thu_break").prop({disabled: true});
                }
            });

            $(document).on('click','input[name="fri"][type="checkbox"]',function(e){
                var fri = $('input[name="fri"][type="checkbox"]:checked').length;
                if (fri > 0 ) {
                    $(".fri_start_time").prop({disabled: false});
                    $(".fri_end_time").prop({disabled: false});
                    $(".fri_lunch").prop({disabled: false});
                    $(".fri_break").prop({disabled: false});
                } else {
                    $(".fri_start_time").prop({disabled: true});
                    $(".fri_end_time").prop({disabled: true});
                    $(".fri_lunch").prop({disabled: true});
                    $(".fri_break").prop({disabled: true});
                }
            });

            $(document).on('click','input[name="sat"][type="checkbox"]',function(e){
                var sat = $('input[name="sat"][type="checkbox"]:checked').length;
                if (sat > 0 ) {
                    $(".sat_start_time").prop({disabled: false});
                    $(".sat_end_time").prop({disabled: false});
                    $(".sat_lunch").prop({disabled: false});
                    $(".sat_break").prop({disabled: false});
                } else {
                    $(".sat_start_time").prop({disabled: true});
                    $(".sat_end_time").prop({disabled: true});
                    $(".sat_lunch").prop({disabled: true});
                    $(".sat_break").prop({disabled: true});
                }
            });


            jQuery('.lunch').on('click', function(e) {
                $('.lunch').removeClass('btn-primary');
                $('.lunch').addClass('btn-red');
                $('.lunch').addClass('remove_lunch');
                $('.lunch').removeClass('lunch');

                $('.sun_leave_icon').addClass('ico-trash');
                $('.sun_leave_icon').removeClass('ico-add');

                $('#lunch_start').show();
                $('#lunch_duration').show();
                $('.sun_lunch_start').show();
                $('.sun_duration').show();

                $('.mon_lunch_start').hide();
                $('.mon_duration').hide();
                $('.tue_lunch_start').hide();
                $('.tue_duration').hide();
                $('.wed_lunch_start').hide();
                $('.wed_duration').hide();
                $('.thu_lunch_start').hide();
                $('.thu_duration').hide();
                $('.fri_lunch_start').hide();
                $('.fri_duration').hide();
                $('.sat_lunch_start').hide();
                $('.sat_duration').hide();
            });

            $(document).on('click','.remove_lunch',function(e){

            // jQuery('.remove_lunch').on('click', function(e) {
                alert('hi 0');
                $('#lunch_start').hide();
                $('#lunch_duration').hide();
                $('.lunch').addClass('remove_lunch');

                $('.remove_lunch').removeClass('btn-red');
                $('.remove_lunch').addClass('btn-primary');
                $('.remove_lunch').addClass('lunch');
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
                buttonText: {
                    today: 'Today',
                    week: 'Week',
                    month: 'Month'
                },
                editable: true,
                resourceAreaHeaderContent: 'Staff',
                resources:  [
                    {
                      "id": "a",
                      "title": "Auditorium A"
                    },
                    {
                      "id": "b",
                      "title": "Auditorium B",
                      "eventColor": "green"
                    },
                    {
                      "id": "c",
                      "title": "Auditorium C",
                      "eventColor": "orange"
                    },
                    {
                      "id": "d",
                      "title": "Auditorium D",
                      "children": [
                        {
                          "id": "d1",
                          "title": "Room D1"
                        },
                        {
                          "id": "d2",
                          "title": "Room D2"
                        }
                      ]
                    },
                    {
                      "id": "e",
                      "title": "Auditorium E"
                    },
                    {
                      "id": "f",
                      "title": "Auditorium F",
                      "eventColor": "red"
                    },
                    {
                      "id": "g",
                      "title": "Auditorium G"
                    },
                    {
                      "id": "h",
                      "title": "Auditorium H"
                    },
                    {
                      "id": "i",
                      "title": "Auditorium I"
                    },
                    {
                      "id": "j",
                      "title": "Auditorium J"
                    },
                    {
                      "id": "k",
                      "title": "Auditorium K"
                    },
                    {
                      "id": "l",
                      "title": "Auditorium L"
                    },
                    {
                      "id": "m",
                      "title": "Auditorium M"
                    },
                    {
                      "id": "n",
                      "title": "Auditorium N"
                    },
                    {
                      "id": "o",
                      "title": "Auditorium O"
                    },
                    {
                      "id": "p",
                      "title": "Auditorium P"
                    },
                    {
                      "id": "q",
                      "title": "Auditorium Q"
                    },
                    {
                      "id": "r",
                      "title": "Auditorium R"
                    },
                    {
                      "id": "s",
                      "title": "Auditorium S"
                    },
                    {
                      "id": "t",
                      "title": "Auditorium T"
                    },
                    {
                      "id": "u",
                      "title": "Auditorium U"
                    },
                    {
                      "id": "v",
                      "title": "Auditorium V"
                    },
                    {
                      "id": "w",
                      "title": "Auditorium W"
                    },
                    {
                      "id": "x",
                      "title": "Auditorium X"
                    },
                    {
                      "id": "y",
                      "title": "Auditorium Y"
                    },
                    {
                      "id": "z",
                      "title": "Auditorium Z"
                    }
                  ],
                events: [
                    {
                      "resourceId": "66",
                      "title": "event 1",
                      "start": "2024-06-26",
                      "end": "2024-06-28",
                       "backgroundColor": "blue",
                        "borderColor"    :"darkblue"
                    },
                    {
                      "resourceId": "65",
                      "title": "event 3",
                      "start": "2024-06-27T12:00:00+00:00",
                      "end": "2024-06-28T06:00:00+00:00"
                    },
                    {
                      "resourceId": "66",
                      "title": "event 4",
                      "start": "2024-06-27T07:30:00+00:00",
                      "end": "2024-06-27T09:30:00+00:00"
                    },
                    {
                      "resourceId": "74",
                      "title": "event 5",
                      "start": "2024-06-27T10:00:00+00:00",
                      "end": "2024-06-27T15:00:00+00:00"
                    },
                    {
                      "resourceId": 65,
                      "title": "event 2",
                      "start": "2024-06-27T09:00:00+00:00",
                      "end": "2024-06-27T14:00:00+00:00"
                    }
                ],
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
                eventContent: function (info)
                {
                    console.log('eventcontent');
                    console.log(info.event);
                    let italicEl = document.createElement('div');
                        italicEl.classList.add("fc-event-main-frame");
                    if(info.event.start){
                        italicEl.innerHTML = `<div class='fc-event-time'>${info.timeText}</div>
                        <div class='fc-event-title-container'><div class='fc-event-title fc-sticky'>${info.event.title}</div></div>`;
                    } else {
                        italicEl.innerHTML = `<div class='fc-event-time'>dharit</div>
                        <div class='fc-event-title-container'><div class='fc-event-title fc-sticky'>Maniyar</div></div>`;
                    }

                    let arrayOfDomNodes = [italicEl]
					return {
                        domNodes: arrayOfDomNodes
                    }
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

        saveTimetable: function(){
            var context = this;
            jQuery('#timetableSavebtn').on('click', function(e) {
                var timetable   = [];
                var start_date  = $('input[name="start_date"]').val();
                var end_date    = $('input[name="end_date"]').val();
                var sunday      = $('input[name="sun"]').prop("checked");
                var monday      = $('input[name="mon"]').prop("checked");
                var tuesday     = $('input[name="tue"]').prop("checked");
                var wednesday   = $('input[name="wed"]').prop("checked");
                var thrusday    = $('input[name="thu"]').prop("checked");
                var friday      = $('input[name="fri"]').prop("checked");
                var saturaday   = $('input[name="sat"]').prop("checked");

                var timetable1 = {
                    "start_date" : start_date,
                    "end_date"   : end_date
                }
                timetable.push(timetable1);
                var days = [];
                if(sunday == true)
                {
                    var sun_start_time  = $('select[name="sun_start_time"]').find(":selected").val();
                    var sun_end_time    = $('select[name="sun_end_time"]').find(":selected").val();
                    var sun = {
                        'day_name'  : "sun",
                        'start_time': sun_start_time,
                        'end_time' : sun_end_time
                    }
                    days.push(sun);
                    // timetable.push(days);
                    // arr1.concat(arr2);
                    timetable.concat(days);
                    // call_user_func_array('array_merge', timetable);
                    console.log(timetable);
                    var jarray = [];
                    for (var i=0; i<days.length && i<timetable.length; i++)
                        jarray[i] = [timetable[i], [days[i]]];
                    }
                    console.log(jarray);

                if(monday == true)
                {
                    var mon_start_time  = $('select[name="mon_start_time"]').find(":selected").val();
                    var mon_end_time    = $('select[name="mon_end_time"]').find(":selected").val();
                    var mon = {
                        'start_time': mon_start_time,
                        'end_time' : sun_end_time
                    }
                }

                if(tuesday == true)
                {
                    var tue_start_time  = $('select[name="tue_start_time"]').find(":selected").val();
                    var tue_end_time    = $('select[name="tue_end_time"]').find(":selected").val();
                    // console.log(tue_start_time);
                }

                if(wednesday == true)
                {
                    var wed_start_time  = $('select[name="wed_start_time"]').find(":selected").val();
                    var wed_end_time    = $('select[name="wed_end_time"]').find(":selected").val();
                    // console.log(tue_start_time);
                }

                if(thrusday == true)
                {
                    var thu_start_time  = $('select[name="thu_start_time"]').find(":selected").val();
                    var thu_end_time    = $('select[name="thu_end_time"]').find(":selected").val();
                    // console.log(tue_start_time);
                }

                if(friday == true)
                {
                    var fri_start_time  = $('select[name="fri_start_time"]').find(":selected").val();
                    var fri_end_time    = $('select[name="fri_end_time"]').find(":selected").val();
                    // console.log(tue_start_time);
                }

                if(saturaday == true)
                {
                    var sat_start_time  = $('select[name="sat_start_time"]').find(":selected").val();
                    var sat_end_time    = $('select[name="sat_end_time"]').find(":selected").val();
                    // console.log(tue_start_time);
                }

                // console.log(timetable);
            });
        },
    }
})();