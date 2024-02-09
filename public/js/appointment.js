
// Calender
document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
        selectable: true,
        editable: true,
        initialView: 'resourceTimeGridDay',
        headerToolbar: {
            left: 'prev,today,next',
            center: 'title',
            right: 'resourceTimeGridDay,resourceTimeGridWeek,resourceTimelineMonth,resourceTimelineYear'
        },
        resources: [],
        resourceAreaHeaderContent: 'Name of Dr',
        events: [
            {
                resourceId: 22,
                title: "Long Event",
                start: "2024-02-07",
                end: "2024-02-10"
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
            calendar.setOption('resources', data);
            calendar.refetchEvents(); // Refresh events if needed
        },
        error: function (error) {
            console.error('Error fetching resources:', error);
        }
    });
    calendar.render();
});