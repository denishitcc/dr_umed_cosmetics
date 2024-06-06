@extends('layouts.sidebar')
@section('title', 'Staff Timetable')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- <main> -->
<div class="card">
    <div class="card-head">
        <div class="toolbar mb-0">
            <div class="tool-left">
                <h4 class="small-title mb-0">Staff timetables</h4>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group icon searh_data">
                    <select class="form-select" id="location">
                        @foreach ($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->location_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <i class="fas fa-square normalWorking"></i>
                Normal working hours
            </div>
            <div class="col-lg-2">
                <i class="fas fa-square editedWorking"></i>
                Edited working hours
            </div>
            <div class="col-lg-2">
                <i class="fas fa-square squareIcon"></i>
                Not working
            </div>
            <div class="col-lg-2">
                <i class="fas fa-square onLeave"></i>
                On leave
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-apnt-calendar" id="calendar">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
{{-- <script src="{{ asset('js/fullcalendar-scheduler-6.1.10/dist/index.global.js') }}"></script>
<script src="{{ asset('js/fullcalendar-scheduler-6.1.10/dist/index.global.min.js') }}"></script> --}}
<script src="https://unpkg.com/@fullcalendar/core@4.4.0/main.min.js"></script>
<script src="https://unpkg.com/@fullcalendar/interaction@4.4.0/main.min.js"></script>
<script src="https://unpkg.com/@fullcalendar/resource-common@4.4.0/main.min.js"></script>
<script src="https://unpkg.com/@fullcalendar/timeline@4.4.0/main.min.js"></script>
<script src="https://unpkg.com/@fullcalendar/resource-timeline@4.4.0/main.min.js"></script>
<script src="{{ asset('js/timetable.js') }}"></script>
<script type="text/javascript">
    var moduleConfig = {
        getStaffList:                 "{!! route('get-staff-list') !!}",
    };
    $(document).ready(function()
    {
        DU.timetable.init();
    });
</script>
@endsection
