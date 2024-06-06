var DU = {};
(function () {
    DU.timetable = {
        calendar: null,
        init: function (){
            this.addHandler();
        },

        addHandler: function (){
            var context = this;
            context.initialCalender();
            context.getlocationId();
            context.changelocation();
        },

        initialCalender: function(){
            var context  = this;
            var calendarEl = document.getElementById('calendar');
            context.calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['interaction', 'resourceTimeline'],
                timeZone: 'UTC',
                defaultView: 'resourceTimelineWeek',
                columnHeaderHtml: function (date) {
                    return '<span class="day-name">' + date.format('ddd') + '</span><span class="day-number">' + date.format('DD') + '</span>';
                },
                header: {
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
                viewRender: function (view, element) {
                    // Find the day headers and update their content
                    element.find('.fc-cell-text').each(function () {
                      var day = $(this).text();
                      console.log(day);
                      var date = moment(day, 'YYYY-MM-DD');
                      var formattedDay = date.format('ddd'); // Change to three-letter day name
                      $(this).text(formattedDay);
                    });
                },
                // columnFormat: {
                //     month: 'dddd',    // Monday, Wednesday, etc
                //     week: 'dddd, MMM dS', // Monday 9/7
                //     day: 'dddd, MMM dS'  // Monday 9/7
                // },
                editable: true,
                resourceLabelText: 'Staff',
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
                    var resources = data.map(function (data) {
                        return {
                          id: data.id,
                          title: data.title,
                          // You can add more properties as needed
                        };
                      });
                      resources.forEach(function (resource) {
                        context.calendar.addResource(resource); // Add each resource
                      });

                    // Update the FullCalendar resources with the retrieved data
                    // context.calendar.addResource(data);
                    // context.calendar.refetchEvents(); // Refresh events if needed
                },
                error: function (error) {
                    console.error('Error fetching on staff:', error);
                }
            });
        }
    }
})();