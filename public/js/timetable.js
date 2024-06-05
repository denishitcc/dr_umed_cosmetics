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
        },

        initialCalender: function(){
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'resourceTimeGridDay',
                headerToolbar: {
                    left: 'prev,today,next',
                    center: 'title',
                    // right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                    right: 'resourceTimeGridDay,resourceTimeGridWeek,resourceTimelineMonth,resourceTimelineYear'
                },
                resources: [{
                        id: 'A',
                        title: 'Resource A',
                    },
                    {
                        id: 'B',
                        title: 'Resource B',
                    },
                    {
                        id: 'C',
                        title: 'Resource C',
                        backgroundColor: 'red'
                    }
                ],
                events: [{
                        id: '1',
                        resourceId: 'A',
                        start: '2024-02-07T09:00:00',
                        end: '2024-02-28T12:00:00',
                        title: 'Event 1',
                        allDay: false,
                        backgroundColor: "green",
                        borderColor: "red"
                    },
                    {
                        id: '2',
                        resourceId: 'B',
                        start: '2024-02-07T10:00:00',
                        end: '2024-02-07T14:00:00',
                        title: 'Event 2'
                    },
                    {
                        id: '3',
                        resourceId: 'C',
                        start: '2024-02-07T10:00:00',
                        end: '2024-02-07T14:00:00',
                        title: 'Event 3',
                        allDay: true,
                        backgroundColor: "green"
                    },
                    // Add more events as needed
                ],
                selectable: true,
                select: function (start, end, allDays) {
                    console.log('test');
                },
                dayMaxEvents: true,
            });
            calendar.render();
        },
    }
})();