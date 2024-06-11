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

            $('.new_timetable_section').attr('style','display:none !important');
            $('.create_leave_section').attr('style','display:none !important');
            $('#lunch_start').hide();
            $('#lunch_duration').hide();


            $(document).on('click','input[name="sun"][type="checkbox"]',function(e){
                var sun = $('input[name="sun"][type="checkbox"]:checked').length;
                if (sun > 0 ) {
                    $(".sun_start_time").prop({disabled: false});
                    $(".sun_end_time").prop({disabled: false});

                    $(".sun_lunch").prop({disabled: false});
                    $(".sun_break").prop({disabled: false});
                    $(".sun_custom").prop({disabled: false});
                } else {
                    $(".sun_start_time").prop({disabled: true});
                    $(".sun_end_time").prop({disabled: true});
                    $(".sun_lunch").prop({disabled: true});
                }
            });

            $(document).on('click','.sun_lunch',function(e){
                $('.sun_lunch').removeClass('btn-primary');
                $('.sun_lunch').addClass('btn-red');
                $('.sun_lunch').addClass('remove_lunch');

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
                resourceLabelContent: function(arg) {
                    var resourceEl = document.createElement('div');
                    resourceEl.innerHTML = arg.resource.title;
                    resourceEl.classList.add('resource-label-dharit');
                    resourceEl.dataset.resourceId = arg.resource.id;
                    return { domNodes: [resourceEl] };
                },
                dateClick: function(info){
                    var currnetDate = info.dateStr;
                    $('#edit_Working_hours').modal('toggle');
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
    }
})();