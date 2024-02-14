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
                    <input type="text" id="search" onkeyup="changeInput(this.value)" class="form-control" placeholder="Search for a client">
                    <i class="ico-search"></i>
                    <div id="result" class="list-group"></div>
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
                    {{-- <div class="mb-5">
                        <div class="one-inline align-items-center mb-2">
                            <span class="custname me-3"><i class="ico-user2 me-2 fs-6"></i> Alana Ahfock</span>
                            <button type="button" class="btn btn-primary btn-md">Change</button>
                        </div>
                        <em class="d-grey font-12 btn-light">No recent appointments found</em>
                    </div> --}}
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
                                            <a href="javascript:void(0);" class="parent_category_id" data-category_id="{{$category->id}}">{{$category->category_name}}</a>
                                        </div>
                                        @if ($category->children)
                                            <ul>
                                                @foreach ($category->children as $child)
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
                                        <ul id="sub_services">
                                            @foreach ($services as $services)
                                                <li>
                                                    <a href="javascript:void(0);" class="services" data-services_id="{{$services->id}}">{{ $services->service_name }}</a>
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
                                        <ul id="selected_services">
                                        </ul>
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
    //get all client details

    var client_details = [];

    // $.ajaxvar client_details = [];

    $.ajax({
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{route('calendar.get-all-clients')}}",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: "json",
        success: function(res) {
            debugger;
            if (res.data.length > 0) {
                for (var i = 0; i < res.data.length; ++i) {
                    // Push client details to the client_details array
                    client_details.push({
                        name: res.data[i].firstname,
                        email: res.data[i].email,
                        mobile_number: res.data[i].mobile_number
                    });
                }
            } else {
                $('.table-responsive').empty();
            }
        },
        error: function(jqXHR, exception) {
            // Handle error
        }
    });


    function matchClient(input) {
        var reg = new RegExp(input.trim(), "i");
        var res = [];
        if (input.trim().length === 0) {
            return res;
        }
        for (var i = 0, len = client_details.length; i < len; i++) {
            var person = client_details[i];
            // Check specifically for the mobile_number number field
            if (person.mobile_number && person.mobile_number.match(reg)) {
                res.push(person);
            } else {
                // If mobile_number number didn't match, check other fields
                for (var key in person) {
                    if (person.hasOwnProperty(key) && typeof person[key] === 'string' && person[key].match(reg)) {
                        res.push(person);
                        break; // Break loop if any field matches
                    }
                }
            }
        }
        return res;
    }



    function changeInput(val) {
        var autoCompleteResult = matchClient(val);
        var resultElement = document.getElementById("result");
        resultElement.innerHTML = "";
        for (var i = 0, limit = 10, len = autoCompleteResult.length; i < len && i < limit; i++) {
            var person = autoCompleteResult[i];
            var details = "<p>" + person.name + "<br>" + person.email + " | " + person.mobile_number + "</p>";
            resultElement.innerHTML += "<a class='list-group-item list-group-item-action' href='#' onclick='setSearch(\"" + person.name + "\")'>" + details + "</a>";
        }
    }

    function setSearch(value) {
        document.getElementById('search').value = value;
        document.getElementById("result").innerHTML = "";
    }
</script>
</html>
@endsection