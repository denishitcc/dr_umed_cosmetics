@extends('layouts.sidebar')
@section('title', 'Calender')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="card">
    <div class="card-head">
        <h4 class="small-title mb-0">Appointments</h4>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-lg-3">
                <div class="mb-3 d-flex">
                    <a href="javascript:void(0);" class="btn btn-primary btn-md me-3 w-100" id="appointment">New Appointment</a>
                    <a href="#" class="btn btn-wait-list"><i class="ico-calendar"></i></a>
                </div>
                <div class="form-group icon">
                    <input type="text" class="form-control" placeholder="Search for a client">
                    <i class="ico-search"></i>
                </div>
                <div id="mycalendar"> </div>
                {{-- <img src="img/demo-calander.png" alt=""> --}}
            </div>

            <div class="col-lg-9">
                <div class="main-apnt-calendar" id="calendar">
                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="New_appointment" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xxl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Please add new appointment here</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="one-inline align-items-center mb-5">
                        <div class="form-group icon mb-0 me-3">
                            <input type="text" class="form-control" placeholder="Search for a client">
                            <i class="ico-search"></i>
                        </div>
                        <span class="me-3">Or</span>
                        <button type="button" class="btn btn-primary btn-md">Add a New Client</button>
                    </div>
                    <div class="mb-5">
                        <div class="one-inline align-items-center mb-2">
                            <span class="custname me-3"><i class="ico-user2 me-2 fs-6"></i> Alana Ahfock</span>
                            <button type="button" class="btn btn-primary btn-md">Change</button>
                        </div>
                        <em class="d-grey font-12 btn-light">No recent appointments found</em>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h6>Categories</h6>
                            <div class="service-list-box p-2">
                                <ul class="ctg-tree ps-0 pe-1">
                                    <li class="pt-title">
                                        <div class="disflex">
                                            <a href="javascript:void(0);" class="parent_category_id">All Services &amp; Tasks </a>
                                        </div>
                                    </li>
                                    @foreach ($categories as $category)
                                    <li>
                                        <div class="disflex">
                                            <a href="javascript:void(0);" class="parent_category_id" ids="{{$category->id}}" data-category_id="{{$category->id}}">{{$category->category_name}}</a>
                                        </div>
                                        @if ($category->children)
                                            <ul>
                                                @foreach ($category->children as $child)
                                                    {{-- <li class="selected"><a href="#">BBL &amp; HALO - Combination Packages</a></li> --}}
                                                    <li>
                                                        <a href="javascript:void(0);">{{$child->category_name}}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col">
                            <h6>Services</h6>
                            <div class="service-list-box p-2">
                                <ul class="ctg-tree ps-0 pe-1">
                                    <li class="pt-title">
                                        <div class="disflex">
                                            <label id="subcategory_text">All Services &amp; Tasks</label>
                                        </div>
                                        <ul>
                                            @foreach ($services as $services)
                                                <li>
                                                    <a href="javascript:void(0);">{{ $services->service_name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col">
                            <h6>Selected Services</h6>
                            <div class="service-list-box p-2">
                                <ul class="ctg-tree ps-0 pe-1">
                                    <li class="pt-title">
                                        <div class="disflex">
                                            Please Select/Deselect Services
                                        </div>
                                        {{-- <ul>
                                            <li class="selected remove"><a href="#">1# Christmas Offer</a> <span class="btn btn-cross cross-red"><i class="ico-close"></i></span></li>
                                            <li class="selected remove"><a href="#">1# Offer DMK 3 Enzymes</a> <span class="btn btn-cross cross-red"><i class="ico-close"></i></span></li>
                                            <li class="selected remove"><a href="#">2 Areas $264</a> <span class="btn btn-cross cross-red"><i class="ico-close"></i></span></li>
                                            <li class="selected remove"><a href="#">3V (Forma V + VTone + M8V - in this order) x 3 monthly package</a> <span class="btn btn-cross cross-red"><i class="ico-close"></i></span></li>
                                        </ul> --}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-md" data-bs-dismiss="modal">Discard</button>
                    <button type="button" class="btn btn-primary btn-md" id="saveBtn">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
</div>
@stop
@section('script')
<script src="{{ asset('js/fullcalendar-scheduler-6.1.10/dist/index.global.js') }}"></script>
<script src="{{ asset('js/fullcalendar-scheduler-6.1.10/dist/index.global.min.js') }}"></script>
<script src="{{ asset('js/appointment.js') }}"></script>
<script type="text/javascript">
    var moduleConfig = {
        doctorAppointments: "{!! route('doctor-appointments') !!}",
        categotyByservices: "{!! route('calender.get-category-services') !!}",
    };

    $(document).ready(function()
    {
        DU.appointment.init();
    });
</script>
</html>
@endsection