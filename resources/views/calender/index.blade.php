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
                <div class="form-group icon searh_data">
                    <input type="text" id="search" class="form-control " autocomplete="off" placeholder="Search for a client" onkeyup="changeInput(this.value)">
                    <i class="ico-search"></i>
                </div>
                <div id="clientDetails">
                </div>
                <div id="result" class="list-group"></div>
                <div id="mycalendar"> </div>
                {{-- <img src="img/demo-calander.png" alt="" class="search_client"> onkeyup="changeInput(this.value)" --}}
            </div>

            <div class="col-lg-9">
                <div class="main-apnt-calendar" id="calendar">
                </div>
            </div>
            <div id='external-events'>
                <p>
                    <strong>Draggable Events</strong>
                </p>
                <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
                    <div class='fc-event-main'>My Event 1</div>
                </div>
                <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
                    <div class='fc-event-main'>My Event 2</div>
                </div>
                <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
                    <div class='fc-event-main'>My Event 3</div>
                </div>
                <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
                    <div class='fc-event-main'>My Event 4</div>
                </div>
                <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
                    <div class='fc-event-main'>My Event 5</div>
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
                    <form>
                    <div class="clientCreateModal">
                        <div class="one-inline align-items-center mb-5 client_detail">
                            <div class="form-group icon mb-0 me-3">
                                <input type="text" class="form-control" autocomplete="off" id="searchmodel" placeholder="Search for a client"  onkeyup="changeInputModal(this.value)">
                                <!-- search_client_modal -->
                                <i class="ico-search"></i>
                            </div>
                            <!-- <div class="list-group" id="search_client_modal"></div> -->
                            <span class="me-3">Or</span>
                            <button type="button" class="btn btn-primary btn-md add_new_client">Add a New Client</button>
                        </div>
                        <strong class="new_client_head" style="display:none;">New client details</strong><span class="sep new_client_head" style="display:none">|</span><a href="#" class="new_client_head cancel_client" style="display:none">Cancel</a>
                        <div class="mb-5 client_form" style="display:none;">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="form-control">
                                        </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control">
                                        </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input type="text" class="form-control">
                                        </div>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label">Gender</label>
                                    <div class="toggle form-group">
                                        <input type="radio" name="t-gender" value="" id="t-male" checked="checked">
                                        <label for="t-male">Male <i class="ico-tick"></i></label>
                                        <input type="radio" name="t-gender" value="" id="t-female">
                                        <label for="t-female">Female <i class="ico-tick"></i></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">Phone </label>
                                        <input type="text" class="form-control">
                                        </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">Phone type</label>
                                        <select class="form-select form-control">
                                            <option selected="" value=""> -- select an option -- </option>
                                            <option>Mobile</option>
                                            <option>Home</option>
                                            <option>Work</option>
                                        </select>
                                        </div>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label">Send Promotions</label>
                                    <div class="toggle form-group">
                                        <input type="radio" name="s-promo" value="" id="pro-yes" checked="checked">
                                        <label for="pro-yes">No <i class="ico-tick"></i></label>
                                        <input type="radio" name="s-promo" value="" id="pro-no">
                                        <label for="pro-no">Yes <i class="ico-tick"></i></label>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">Preferred contact method</label>
                                        <select class="form-select form-control" name="contact_method" id="contact_method">
                                            <option selected="" value=""> -- select an option -- </option>
                                            <option>Text message (SMS)</option>
                                            <option>Email</option>
                                            <option>Phone call</option>
                                            <option>Post</option>
                                            <option>No preference</option>
                                            <option>Don't send reminders</option>
                                        </select>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="resultmodal" class="list-group"></div>

                    <div class="mb-5" id="clientmodal">
                        <div class="one-inline align-items-center mb-2">
                            <span class="custname me-3" id="clientDetailsModal"> </span>
                            <button type="button" class="btn btn-primary btn-md client_change">Change</button>
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
                        <div><label style="color: red" id="service_error">Please select at least one service for this appointment.</label></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-md" data-bs-dismiss="modal">Discard</button>
                    <button type="button" class="btn btn-primary btn-md" id="appointmentSaveBtn">Save Changes</button>
                </div>
            </form>
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
        getClients:         "{!! route('calendar.get-all-clients') !!}",
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
            if (res.length > 0) {
                for (var i = 0; i < res.length; ++i) {
                    // Push client details to the client_details array
                    client_details.push({
                        id: res[i].id,
                        name: res[i].first_name,
                        lastname: res[i].last_name,
                        email: res[i].email,
                        mobile_number: res[i].mobile_no
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
        $('#clientDetails').empty();
        var autoCompleteResult = matchClient(val);
        var resultElement = document.getElementById("result");
        if (val.trim() === "") {
            resultElement.innerHTML = ""; // Clear the result if search box is empty
        } else {
            if (autoCompleteResult.length === 0) {
                resultElement.innerHTML = "<p>No records found</p>";
            } else {
                resultElement.innerHTML = ""; // Clear previous message if records are found
                for (var i = 0, limit = 10, len = autoCompleteResult.length; i < len && i < limit; i++) {
                    var person = autoCompleteResult[i];
                    var firstCharacter = person.name.charAt(0).toUpperCase();
                    var details = "<div class='client-name'><div class='drop-cap' style='background: #D0D0D0; color: #000;'>" + firstCharacter + "</div></div>" + "<p>" + person.name + "<br>" + person.email + " | " + person.mobile_number + "</p>";
                    resultElement.innerHTML += "<a class='list-group-item list-group-item-action' href='javascript:void(0);' onclick='setSearch(\"" + person.name + "\")'>" + details + "</a>";
                }
            }
        }
    }

    function changeInputModal(val) {
        $('#clientDetailsModal').empty();
        var autoCompleteResult = matchClient(val);
        var resultElement = document.getElementById("resultmodal");
        if (val.trim() === "") {
            resultElement.innerHTML = ""; // Clear the result if search box is empty
        } else {
            if (autoCompleteResult.length === 0) {
                resultElement.innerHTML = "<p>No records found</p>";
            } else {
                resultElement.innerHTML = ""; // Clear previous message if records are found
                for (var i = 0, limit = 10, len = autoCompleteResult.length; i < len && i < limit; i++) {
                    var person = autoCompleteResult[i];
                    var firstCharacter = person.name.charAt(0).toUpperCase();
                    var details = "<div class='client-name'><div class='drop-cap' style='background: #D0D0D0; color: #000;'>" + firstCharacter + "</div></div>" + "<p>" + person.name + "<br>" + person.email + " | " + person.mobile_number + "</p>";
                    resultElement.innerHTML += "<a class='list-group-item list-group-item-action' href='javascript:void(0);' onclick='setSearchModal(\"" + person.name + "\")'>" + details + "</a>";
                }
            }
        }
    }

    function setSearch(value) {
        document.getElementById('search').value = value;
        document.getElementById("result").innerHTML = "";

        // Iterate over client_details to find a matching value
        for (const key in client_details) {
            if (client_details.hasOwnProperty(key)) {
                const client = client_details[key];
                // Check if value matches any field in the client object
                if (client.email === value || client.mobile_number === value || client.name === value) {
                    // If a match is found, dynamically bind HTML to clientDetails element
                    $('#clientDetails').html(
                        "<div class='client-name'><div class='drop-cap' style='background: #D0D0D0; color: #000;'>" +
                        client.name.charAt(0).toUpperCase() +
                        "</div></div>" +
                        "<p>" +
                        client.name + "<br>" +
                        client.email + " | " +
                        client.mobile_number +
                        "</p>" +
                        "<button class='btn btn-primary btn-sm me-2' client-id='"+ client.id+"' onclick='buttonAction1()'>Client Card</button>" +
                        "<button class='btn btn-primary btn-sm me-2' client-id='"+ client.id+"' onclick='buttonAction2()'>History</button>" +
                        "<button class='btn btn-primary btn-sm me-2' client-id='"+ client.id+"' onclick='buttonAction3()'>Upcoming</button>"
                    );

                    document.getElementById('search').value = '';
                    break; // Stop iterating once a match is found
                }
            }
        }
    }

    function setSearchModal(value) {
        document.getElementById('searchmodel').value = value;
        document.getElementById("resultmodal").innerHTML = "";

        // Iterate over client_details to find a matching value
        for (const key in client_details) {
            if (client_details.hasOwnProperty(key)) {
                const client = client_details[key];
                // Check if value matches any field in the client object
                if (client.email === value || client.mobile_number === value || client.name === value) {
                    // If a match is found, dynamically bind HTML to clientDetails element
                    $('#clientmodal').show();
                    $('.clientCreateModal').hide();
                    $("#clientDetailsModal").html(
                        "<i class='ico-user2 me-2 fs-6'></i> "+ client.name +' '+ client.lastname);
                    $('#clientDetails').html(
                        "<div class='client-name'><div class='drop-cap' style='background: #D0D0D0; color: #000;'>" +
                        client.name.charAt(0).toUpperCase() +
                        "</div></div>" +
                        "<p>" +
                        client.name + "<br>" +
                        client.email + " | " +
                        client.mobile_number +
                        "</p>" +
                        "<button class='btn btn-primary btn-sm me-2' client-id='"+ client.id+"' onclick='buttonAction1()'>Client Card</button>" +
                        "<button class='btn btn-primary btn-sm me-2' client-id='"+ client.id+"' onclick='buttonAction2()'>History</button>" +
                        "<button class='btn btn-primary btn-sm me-2' client-id='"+ client.id+"' onclick='buttonAction3()'>Upcoming</button>"
                    );
                    document.getElementById('searchmodel').value = '';
                    break; // Stop iterating once a match is found
                }
            }
        }
    }
</script>
</html>
@endsection