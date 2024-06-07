var DU = {};
(function () {
    DU.timetable = {
        calendar: null,
        selectors: {
            editWorkingModal:           jQuery('#edit_Working_hours'),
        },
        init: function (){
            this.addHandler();
        },

        addHandler: function (){
            var context = this;
            context.initialTimeTable();
            context.getlocationId();
            context.changelocation();
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
                // events: 'https://fullcalendar.io/demo-events.json?single-day&for-resource-timeline'
            });

            context.calendar.render();
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
        }
    }
})();