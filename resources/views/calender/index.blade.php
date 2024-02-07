@extends('layouts.sidebar')
@section('title', 'Calender')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="card">
    <div class="card-head">
        <h4 class="small-title mb-0">Appointments</h4>
    </div>
    <div class="card-body" id="calendar">
    </div>
</div>
@stop
@section('script')
<script src="{{asset('js/fullcalendar-scheduler-6.1.10/dist/index.global.js')}}"></script>
<script src="{{asset('js/fullcalendar-scheduler-6.1.10/dist/index.global.min.js')}}"></script>
<script>

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
    themeSystem: 'bootstrap5',
    initialView: 'resourceTimeGridDay',
    headerToolbar: {
        left: 'prev,today,next',
        center: 'title',
        right: 'resourceTimeGridDay,resourceTimeGridWeek,resourceTimelineMonth,resourceTimelineYear'
    },
    resources: [],
    dayMaxEvents: true,
    });

    $.ajax({
        url: "{{ route('doctor-appointments') }}", // Replace with your actual API endpoint
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

</script>
</html>
@endsection