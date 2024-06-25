@extends('layouts/sidebar')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- <main> -->
    <div class="card">
        @if(Auth::check() && (Auth::user()->role_type == 'admin'))
        <div class="card-head">
            <div class="toolbar mb-0">
                <div class="tool-left">
                    <a href="{{ route('clients.create') }}" class="btn btn-primary btn-md me-2">Add New Client</a>
                    <a href="#" id="openWaitListModalBtn" class="btn btn-primary btn-md me-2">Add New Waitlist Client</a>
                    <a href="{{ route('calender.index') }}" class="btn btn-primary btn-md new_app">Make New Appointment</a>
                </div>
            </div>
        </div>
        @elseif(Auth::user()->checkPermission('clients') != 'View Only')
        <div class="card-head">
            <div class="toolbar mb-0">
                <div class="tool-left">
                    <a href="{{ route('clients.create') }}" class="btn btn-primary btn-md me-2">Add New Client</a>
                    <a href="#" id="openWaitListModalBtn" class="btn btn-primary btn-md me-2">Add New Waitlist Client</a>
                    <a href="{{ route('calender.index') }}" class="btn btn-primary btn-md new_app">Make New Appointment</a>
                </div>
            </div>
        </div>
        @endif
        <div class="card-head">
            <h4 class="small-title mb-3">Client's Summary</h4>
            
            <ul class="taskinfo-row">
                <li>
                    <div class="font-24 mb-1">{{count($clients)}}</div>
                    <b class="d-grey">Total Clients</b>
                </li>
                <li>
                    @php
                    $active_client = \App\Models\Clients::where(['status' => 'active'])->get();
                    @endphp
                    <div class="font-24 mb-1">{{count($active_client)}}</div>
                    <b class="text-succes-light">Active Clients </b>
                </li>
                <li>
                    @php
                    $inactive = \App\Models\Clients::where(['status' => 'deactive'])->get();
                    @endphp
                    <div class="font-24 mb-1">{{count($inactive)}}</div>
                    <b class="text-danger">InActive Clients</b>
                </li>
                <li>
                    <div class="font-24 mb-1">{{count($count_today_appointments)}}</div>
                    <b class="text-warning">Client's Appointment Today</b>
                </li>
            </ul>
        </div>
        <div class="card-head py-3">
            <div class="toolbar">
                <div class="tool-left d-flex align-items-center ">
                    <div class="cst-drop-select me-3"><select class="location" multiple="multiple" id="MultiSelect_DefaultValues"></select></div>
                    <label class="cst-check"><input type="checkbox" class="checkbox" value="" id="exclude" name="" checked=""><span class="checkmark me-2"></span>Exclude Inactive Clients</label>
                </div>
                <div class="tool-right">
                    <div class="cst-drop-select drop-right"><select class="filter_by" multiple="multiple" id="DayFilter"></select></div>
                </div>
            </div>
        </div>
        <div class="card-body">
        <div class="row">
                <table class="table data-table all-db-table display" style="width:100%;">
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>Client Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Next Appointments</th>
                    <!-- <th>Appointment Status</th> -->
                    <!-- <th>Date and Time</th> -->
                    <th>Status</th>
                    <!-- <th>Location</th> -->
                    <!--<th>status</th>-->
                    </tr>
                </thead>
                <tbody>
                </tbody>
                </table>
        </div>

        <div class="modal fade" id="New_waitlist_client" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-xxl">
                <div class="modal-content">
                <div id="clientCreate" data-url="{{ route('clients.store') }}"></div>
                <form id="create_waitlist_client" name="create_waitlist_client" class="form" method="post">
                    @csrf
                    <input type="hidden" name="check_client" id="check_client" value="selected_client">
                    <div class="modal-header">
                        <h4 class="modal-title">New waitlist client</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="clientCreateModal">
                            <div class="one-inline align-items-center mb-4 client_detail">
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
                                            <input type="text" class="form-control" name="firstname" id="firstname_client" maxlength="50">
                                            </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label">Last Name</label>
                                            <input type="text" class="form-control" name="lastname" id="lastname_client" maxlength="50">
                                            </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control" name="email" id="email_client" maxlength="100">
                                            </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="form-label">Gender</label>
                                        <div class="toggle form-group">
                                            <input type="radio" name="gender" value="Male" id="male" checked="checked" />
                                            <label for="male">Male <i class="ico-tick"></i></label>
                                            <input type="radio" name="gender" value="Female" id="female" />
                                            <label for="female">Female <i class="ico-tick"></i></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label">Phone </label>
                                            <input type="text" class="form-control" name="phone" id="phone_client" maxlength="15">
                                            </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label">Phone type</label>
                                            <select class="form-select form-control" name="phone_type" id="phone_type_client">
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
                                            <input type="radio" name="send_promotions" value="1" id="yes" checked="checked">
                                            <label for="yes">Yes <i class="ico-tick"></i></label>
                                            <input type="radio" name="send_promotions" value="0" id="no">
                                            <label for="no">No <i class="ico-tick"></i></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label">Preferred contact method</label>
                                                <select class="form-select form-control" name="contact_method" id="contact_method_client">
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
                        {{-- <div id="resultmodal" class="list-group"></div> --}}
                        <div class="client_list_box" style="display:none;">
                            <ul class="drop-list" id="resultmodal"></ul>
                        </div>
                        <div class="mb-5" id="clientmodal">
                            <div class="one-inline align-items-center mb-2">
                                <span class="custname me-3" id="clientDetailsModal"> </span>
                                <input type="hidden" name="clientname" id="clientName">
                                <input type="hidden" name="clientid" id="clientid">
                                <button type="button" class="btn btn-primary btn-md client_change">Change</button>
                            </div>
                            <em class="d-grey font-12 btn-light">No recent appointments found</em>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="form-label">Preferred staff member</label>
                                    <select class="form-select form-control" name="user_id" id="user_id">
                                        <option selected="" value="">Anyone</option>
                                        @if(count($users)>0)
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->first_name.' '.$user->last_name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="form-label">Preferred date</label>
                                    <input type="date" class="form-control" placeholder="No preference" id="preferred_from_date" name="preferred_from_date">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="form-label">&nbsp;</label>
                                    <input type="date" class="form-control" id="preferred_to_date" name="preferred_to_date">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="form-label">Additional notes</label>
                                <textarea class="form-control" rows="5" name="additional_notes" id="additional_notes"></textarea>
                            </div>
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
                                                <a href="javascript:void(0);" class="parent_category_id" data-category_id="{{$category->id}}" data-duration="{{ $category->duration }}">{{$category->category_name}}</a>
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
                                <div class="service-list-box p-2" id="all_ser">
                                    <ul class="ctg-tree ps-0 pe-1">
                                        <li class="pt-title">
                                            <div class="disflex">
                                                <label id="subcategory_text">All Services &amp; Tasks</label>
                                            </div>
                                            <ul id="sub_services">
                                                @foreach ($services as $service)
                                                    <li class="service_selected">
                                                        <a href="javascript:void(0);" class="services" data-services_id="{{$service->id}}" data-category_id="{{$service->category_id}}" data-duration="{{ $service->appearoncalender->duration }}">{{ $service->service_name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col">
                                <h6>Selected Services</h6>
                                <div class="service-list-box p-2" id="all_selected_ser">
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
                            <div style="display:none;" id="service_error"><label style="color: red">Please select at least one service for this appointment.</label></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light btn-md" data-bs-dismiss="modal">Discard</button>
                        <button type="button" class="btn btn-primary btn-md" id="waitlistSaveBtn">Save Changes</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
<!-- </main> -->
     
@stop
@section('script')
<script>
    $(function() {

        $("#create_waitlist_client").validate({
            rules: {
                firstname: {
                    required: true,
                },
                lastname:{
                    required:true,
                },
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "../clients/checkClientEmail", // Replace with the actual URL to check email uniqueness
                        type: "post", // Use "post" method for the AJAX request
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            email: function () {
                                return $("#email_client").val(); // Pass the value of the email field to the server
                            }
                        },
                        dataFilter: function (data) {
                            var json = $.parseJSON(data);
                            var chk = json.exists ? '"Email already exist!"' : '"true"';
                            return chk;
                        }
                    }
                },
                phone:{
                    required: true,
                },
                phone_type:{
                    required: true,
                },
                contact_method:{
                    required: true,
                },
                preferred_from_date:{
                    required: true,
                },
                preferred_to_date:{
                    required: true,
                }
            },
        });

        $('#waitlistSaveBtn').on('click' ,function(e){
            var clientselectedServicesCount = $('#selected_services').children("li").length,
                clientName                  = $('#clientDetailsModal').text();

            if($('#check_client').val() == 'new_client')
            {
                if ($("#create_waitlist_client").valid()) {
                    var data = $('#create_waitlist_client').serialize();
                    SubmitCreateWaitlistClient(data);
                    if(clientName === "")
                    {
                        console.log('in if');
                        $('#client').show();
                    }
                    else
                    {
                        $('#client').hide();
                    }

                    if(clientselectedServicesCount == 0 )
                    {
                        $('#service_error').show();
                    }
                    else{
                        $('#service_error').hide();
                        // Check if the form is valid or not

                        var appointmentsData = []; // Array to store appointment data
                        var eventIds = []; // Array to store eventIds
                        var categoryIdsSet = new Set();

                        $("#selected_services > li").each(function(){
                            var eventId = $(this).data('services_id');
                            categoryId = $(this).data('category_id');

                            // Push eventId to eventIds array
                            eventIds.push(eventId);
                            categoryIdsSet.add(categoryId);
                        });
                        var categoryIds = Array.from(categoryIdsSet);

                        // Create a comma-separated string of eventIds
                        var eventIdsStr = eventIds.join(',');
                        var categoryIdsStr = categoryIds.join(',');

                        // Create a single appointment object with all eventIds stored as comma-separated
                        var appointment = {
                            'client_id': $('#clientid').val(),
                            'user_id': $('#user_id').val(),
                            'preferred_from_date': $('#preferred_from_date').val(),
                            'preferred_to_date': $('#preferred_to_date').val(),
                            'additional_notes': $('#additional_notes').val(),
                            'category_id': categoryIdsStr,
                            'service_id': eventIdsStr // Store eventIds as comma-separated string
                        };

                        appointmentsData.push(appointment);

                        // Now appointmentsData contains only one object with all eventIds stored as comma-separated
                        console.log("Appointments Data:", appointmentsData);

                        // Clear selected services
                        $("#selected_services").empty();

                        $.ajax({
                            url: '../calender/add-waitlist-client',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                appointments: appointmentsData
                            },
                            success: function(data) {
                                if (data.success) {
                                    Swal.fire({
                                        title: "WaitList Client Created!",
                                        text: data.message,
                                        icon: "success",
                                    }).then(function() {
                                        // Reload the current page
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Error!",
                                        text: data.message,
                                        icon: "error",
                                    });
                                }
                            },
                            error: function(error) {
                                console.error('Error fetching resources:', error);
                            }
                        });
                    }
                } else {
                    // Prevent the form from being submitted if it's not valid
                    e.preventDefault();
                }
            }else{
                if(clientName === "")
                {
                    console.log('in if');
                    $('#client').show();
                }
                else
                {
                    $('#client').hide();
                }

                if(clientselectedServicesCount == 0 )
                {
                    $('#service_error').show();
                }
                else{
                    $('#service_error').hide();
                    // Check if the form is valid or not

                    var appointmentsData = []; // Array to store appointment data
                    var eventIds = []; // Array to store eventIds
                    var categoryIdsSet = new Set();

                    $("#selected_services > li").each(function(){
                        var eventId = $(this).data('services_id');
                        categoryId = $(this).data('category_id');

                        // Push eventId to eventIds array
                        eventIds.push(eventId);
                        categoryIdsSet.add(categoryId);
                    });

                    var categoryIds = Array.from(categoryIdsSet);

                    // Create a comma-separated string of eventIds
                    var eventIdsStr = eventIds.join(',');
                    var categoryIdsStr = categoryIds.join(',');

                    // Create a single appointment object with all eventIds stored as comma-separated
                    var appointment = {
                        'client_id': $('#clientid').val(),
                        'user_id': $('#user_id').val(),
                        'preferred_from_date': $('#preferred_from_date').val(),
                        'preferred_to_date': $('#preferred_to_date').val(),
                        'additional_notes': $('#additional_notes').val(),
                        'category_id': categoryIdsStr,
                        'service_id': eventIdsStr // Store eventIds as comma-separated string
                    };

                    appointmentsData.push(appointment);

                    // Now appointmentsData contains only one object with all eventIds stored as comma-separated
                    console.log("Appointments Data:", appointmentsData);

                    // Clear selected services
                    $("#selected_services").empty();

                    $.ajax({
                        url: '../calender/add-waitlist-client',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            appointments: appointmentsData
                        },
                        success: function(data) {
                            if (data.success) {
                                Swal.fire({
                                    title: "WaitList Client Created!",
                                    text: data.message,
                                    icon: "success",
                                }).then(function() {
                                    // Reload the current page
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: "Error!",
                                    text: data.message,
                                    icon: "error",
                                });
                            }
                        },
                        error: function(error) {
                            console.error('Error fetching resources:', error);
                        }
                    });
                }
            }

            
        });
        var loc_name = [];

        $.ajax({
            url: "get-all-locations",
            cache: false,
            type: "POST",
            data: {
                type: "client"
            },
            success: function(res) {
                for (var i = 0; i < res.length; ++i) {
                    $("#results").append(res[i].location_name);
                    loc_name.push(res[i].location_name); // Push the location_name to the array
                }
                $('.location').append('<option value="No appointment">No appointment</option>');
                // Move the map function inside the success callback
                $.map(loc_name, function(x) {
                    return $('.location').append("<option>" + x + "</option>");
                });

                // Initialize the multiselect after appending options
                $('.location')
                .multiselect({
                    allSelectedText: 'Select Location',
                    maxHeight: 200,
                    includeSelectAllOption: true
                })
                .multiselect('selectAll', false)
                .multiselect('updateButtonText');
            }
        });
        // var loc_name = [];//['Follow Up Done', 'First Call Done', 'Client Contacted','No Response','Not Intrested'];
        // $.map(loc_name, function (x) {
        // return $('.location').append("<option>" + x + "</option>");
        // });
        // $('.location')
        // .multiselect({
        //     allSelectedText: 'Select Locations',
        //     maxHeight: 200,
        //     includeSelectAllOption: true
        // })
        // .multiselect('selectAll', false)
        // .multiselect('updateButtonText');

        var filter_by = ['No appointment', 'All Days', 'Feature Appointments', 'Today','Tomorrow'];
        $.map(filter_by, function (x) {
        return $('.filter_by').append("<option>" + x + "</option>");
        });
        $('.filter_by')
        .multiselect({
            allSelectedText: 'Filter By',
            maxHeight: 200,
            includeSelectAllOption: true
        })
        .multiselect('selectAll', false)
        .multiselect('updateButtonText');
    });
$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$(document).ready(function() {
    $("#openWaitListModalBtn").click(function(){
        $("#New_waitlist_client").modal('show');
        $('#clientmodal').hide();
        
        $('.clientCreateModal').show();
        $('#subcategory_text').text('All Services & Tasks');
        $('#create_waitlist_client').trigger('reset');
        $('#sub_services').empty();
        $('#selected_services').empty();
        
        $('.new_client_head').hide();
        $('.client_form').hide();
        $('.client_detail').show();
        
        //for all services append code
        var $this           = $(this),
            categoryId      = $this.data('category_id'),
            duration        = $this.data('duration'),
            categoryTitle   = $this.text();
            $.ajax({
                url: "{{ route('calender.get-category-services') }}", // Replace with your actual API endpoint
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'category_id' : categoryId === undefined ? 0 : categoryId
                },
                success: function (data) {

                    $('#subcategory_text').text(categoryTitle);
                    $('#sub_services').empty();
                    $.each(data, function(index, item) {
                        $("#sub_services").append(`<li><a href='javascript:void(0);' class='services' data-services_id=${item.id} data-category_id=${item.category_id} data-duration=${item.duration}>${item.service_name}</a></li>`);
                    });
                },
                error: function (error) {
                    console.error('Error fetching resources:', error);
                }
            });
    });

    $('.add_new_client').click(function(){
        $('#check_client').val('new_client');
        $('.client_detail').hide();
        $('.new_client_head').show();
        $('.client_form').show();
    })

    $('.cancel_client').click(function(){
        $('#check_client').val('selected_client');
        $('.new_client_head').hide();
        $('.client_form').hide();
        $('.client_detail').show();
        // $('#clientDetails').find('input:hidden[name=client_name]').val()
        // $('.client_detail').hide();
        // $('.client_edit_change').show();
        // $('#clienteditDetailsModal').show();

        $('.clientEditModal').hide();
        $('#clienteditmodal').show();
        $("#clienteditDetailsModal").html(`<i class='ico-user2 me-2 fs-6'></i> ${$('#clientDetails').find('input:hidden[name=client_name]').val()}`);
    })

    $('.client_change').click(function(){
        $('.clientCreateModal').show();
        $('#clientmodal').hide();
    })

    $('.parent_category_id').on('click', function(e) {
        e.preventDefault();
        var $this           = $(this),
            categoryId      = $this.data('category_id'),
            duration        = $this.data('duration'),
            categoryTitle   = $this.text();

        $.ajax({
            url: "{{ route('calender.get-category-services') }}", // Replace with your actual API endpoint
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'category_id' : categoryId === undefined ? 0 : categoryId
            },
            success: function (data) {

                $('#subcategory_text').text(categoryTitle);
                $('#sub_services').empty();
                $.each(data, function(index, item) {
                    $("#sub_services").append(`<li><a href='javascript:void(0);' class='services' data-services_id=${item.id} data-category_id=${item.category_id} data-duration=${item.duration}>${item.service_name}</a></li>`);
                });
            },
            error: function (error) {
                console.error('Error fetching resources:', error);
            }
        });
    });
    
    $('#sub_services').on('click', '.services', function(e) {
        e.preventDefault();
        var $this           = $(this),
            serviceId       = $this.data('services_id'),
            categoryId      = $this.data('category_id'),
            duration        = $this.data('duration'),
            serviceTitle    = $this.text();

        $("#selected_services").append(`<li class='selected remove' data-services_id= ${serviceId}  data-category_id= ${categoryId}  data-duration='${duration}'><a href='javascript:void(0);' > ${serviceTitle} </a><span class='btn btn-cross cross-red remove_services'><i class='ico-close'></i></span></li>`);
    });

    $('#selected_services').on('click',".remove_services", function(e) {
        e.preventDefault();
        $(this).closest('li').remove();
        var ser_ids = $(this).closest('li').attr('data-services_id');
        $('.service_selected').each(function(index, element) {
            var id=ser_ids;
            if($(element).find('.services').attr('data-services_id') == id)
            {
                $(element).removeClass('selected');
            }
        });
    });
    $(document).on('click','.services',function(e){
        $(this).parent().addClass('selected');
    })
    // Click event for the anchor tag
    $('.new_app').on('click', function(e) {
        e.preventDefault(); // Prevent default anchor behavior (i.e., redirecting)

        // Set session storage value to indicate modal should be opened
        // sessionStorage.setItem('openModal', 'true');

        // Redirect to calendar page
        window.location.href = $(this).attr('href');
    });
    document.title='Clients';
    var table = $('.data-table').DataTable({
        processing: true,
        // serverSide: true,
        ajax: {
            url: "{{ route('clients.table') }}",
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
        },
        columns: [
            // {data: '', name: ''},
            {data: 'autoId', name: 'autoId'},
            {data: 'username', name: 'username',
                "render": function(data, type, row, meta){
                    var link = ''; // Initialize link variable
                    // Check permission here
                    if ("{{ $permission }}" != 'View Only') {
                        // Permission allows viewing
                        link = '<a class="blue-bold" href="clients/' + row.id + '">' + data + '</a>';
                    } else {
                        // Permission does not allow viewing
                        link = '<a class="blue-bold" href="javascript:void(0);">' + data + '</a>';
                    }
                    return link;
                }
            },
            {data: 'email', name: 'email'},
            {data: 'mobile_number', name: 'mobile_number'},
            {
                data: 'appointment_dates',
                name: 'appointment_dates',
                render: function (data, type, row, meta) {
                    if (data === null) {
                        return 'No appointment';
                    } else {
                        var datesArray = data.split(',');
                        var statusArray = row.app_status.split(',');
                        var locationArray = row.staff_location.split(',');
                        var commonNotesArray = row.common_notes ? row.common_notes.split(',') : [];
                        var treatmentNotesArray = row.treatment_notes ? row.treatment_notes.split(',') : [];

                        var html_app = '';

                        datesArray.forEach(function (app, index) {
                            var formattedDate = app;
                            var formattedStatus = '';
                            var formattedLocation = '';
                            var formattedCommonNotes = '';
                            var formattedTreatmentNotes = '';

                            // Add location
                            if (locationArray[index]) {
                                formattedLocation = locationArray[index];
                            }

                            // Add a line break after AM or PM
                            formattedDate = formattedDate.replace(/(\d{2}-\d{2}-\d{4}\s\d{2}:\d{2}\s)(AM|PM)/g, '<b>$1$2</b> <em>(' + formattedLocation + ')</em><br>');

                            // Add status badge
                            if (statusArray[index]) {
                                var statusClass = '';
                                switch (statusArray[index]) {
                                    case 'Booked':
                                        statusClass = 'text-bg-yellow';
                                        break;
                                    case 'Confirmed':
                                        statusClass = 'text-bg-cyan';
                                        break;
                                    case 'Started':
                                        statusClass = 'text-bg-orange';
                                        break;
                                    case 'Completed':
                                        statusClass = 'text-bg-blue';
                                        break;
                                    case 'No answer':
                                        statusClass = 'text-bg-light-red';
                                        break;
                                    case 'Left message':
                                        statusClass = 'text-bg-green';
                                        break;
                                    case 'Pencilied in':
                                        statusClass = 'text-bg-black';
                                        break;
                                    case 'Turned up':
                                        statusClass = 'text-bg-purple';
                                        break;
                                    case 'No show':
                                        statusClass = 'text-bg-red-purple';
                                        break;
                                    case 'Cancelled':
                                        statusClass = 'text-bg-red';
                                        break;
                                }
                                formattedStatus = '<span class="badge ' + statusClass + ' badge-md ms-1">' + statusArray[index] + '</span>';
                            }

                            // Add common notes
                            if (commonNotesArray.length > index && commonNotesArray[index]) {
                                formattedCommonNotes = '<br><div class="yellow-note-box mt-2"><strong>Common Notes:</strong><br> ' + commonNotesArray[index] + ' </div>';
                            }

                            // Add treatment notes
                            if (treatmentNotesArray.length > index && treatmentNotesArray[index]) {
                                formattedTreatmentNotes = '<div class="yellow-note-box mt-2"><strong>Treatment Notes:</strong><br> ' + treatmentNotesArray[index] + ' </div>';
                            }

                            html_app += '<div class="user-appnt">' + formattedDate + formattedStatus + formattedCommonNotes + formattedTreatmentNotes + '</div>';
                        });

                        return html_app;
                    }
                }
            },
            {
                data: 'status_bar',
                name: 'status_bar',
                render: function(data, type, full, meta) {
                    if (data == null) {
                        data = '';
                    }
                    var disabled = ''; // Default is not disabled

                    // Check your condition to determine whether the status bar should be disabled
                    if ("{{ $permission }}" === 'View Only') {
                        disabled = 'disabled';
                    }

                    return "<span style='display:none;'>" + data + "</span><div class='form-check form-switch green'>" +
                        "<input class='form-check-input flexSwitchCheckDefault' id='flexSwitchCheckDefault' type='checkbox' ids='" +
                        full.id + "' value='" + data + "' " + data + " " + disabled + "></div>";
                }
            },
        ],
        "dom": 'Blrftip',
        "language": {
            "search": '<i class="fa fa-search"></i>',
            "searchPlaceholder": "search...",
            "infoFiltered": "",
        },
        "paging": true,
        "pageLength": 10,
        "autoWidth": true,
        'columnDefs': [{
            // "targets": [0],
            'orderable': false,
        }],
        buttons: [
            {
                extend: 'collection',
                text: 'Export',
                buttons: [
                    { 
                        text: "Excel",
                        exportOptions: { 
                            columns: [0,1,2,3,4,5],
                            format: {
                                body: function (data, row, column, node) {
                                    // For the 7th column, replace 'checked' with 'Active' and 'unchecked' with 'Deactive'
                                    if (column === 1) {
                                        return node.textContent;
                                    }
                                    else if(column === 4) {
                                        return node.textContent;
                                    }
                                    else if (column === 5) {
                                        return node.textContent === 'checked' ? 'Active' : 'Deactive';
                                    }
                                    return data;
                                }
                            }
                        },
                        extend: 'excelHtml5'
                    },
                    { 
                        text: "CSV",
                        exportOptions: { 
                            columns: [0,1,2,3,4,5],
                            format: {
                                body: function (data, row, column, node) {
                                    // For the 7th column, replace 'checked' with 'Active' and 'unchecked' with 'Deactive'
                                    if (column === 1) {
                                        return node.textContent;
                                    }
                                    else if(column === 4) {
                                        return node.textContent;
                                    }
                                    else if (column === 5) {
                                        return node.textContent === 'checked' ? 'Active' : 'Deactive';
                                    }
                                    return data;
                                }
                            }
                        },
                        extend: 'csvHtml5'
                    },
                    { 
                        text: "PDF",
                        exportOptions: { 
                            columns: [0,1,2,3,4,5],
                            format: {
                                body: function (data, row, column, node) {
                                    // For the 7th column, replace 'checked' with 'Active' and 'unchecked' with 'Deactive'
                                    if (column === 1) {
                                        return node.textContent;
                                    }
                                    else if(column === 4) {
                                        return node.textContent;
                                    }
                                    else if (column === 5) {
                                        return node.textContent === 'checked' ? 'Active' : 'Deactive';
                                    }
                                    return data;
                                }
                            }
                        },
                        extend: 'pdfHtml5'
                    },
                    { 
                        text: "PRINT",
                        exportOptions: { 
                            columns: [0,1,2,3,4,5],
                            format: {
                                body: function (data, row, column, node) {
                                    // For the 7th column, replace 'checked' with 'Active' and 'unchecked' with 'Deactive'
                                    if (column === 1) {
                                        return node.textContent;
                                    }
                                    else if(column === 4) {
                                        return node.textContent;
                                    }
                                    else if(column === 5) {
                                        return node.textContent;
                                    }
                                    else if (column === 6) {
                                        return node.textContent === 'checked' ? 'Active' : 'Deactive';
                                    }
                                    else if(column === 7) {
                                        return node.textContent;
                                    }
                                    return data;
                                }
                            }
                        },
                        extend: 'print'
                    },
                ]
            }
        ],
        select: {
            style : "multi",
        },
        // 'order': [[0, 'desc']],
        initComplete: function () {
            var btns = $('.dt-buttons'),
                dtFilter = $('.dataTables_filter'),
                dtInfo  = $('.dataTables_info'),
                api     = this.api(),
                page_info = api.rows( {page:'current'} ).data().page.info(),
                length = page_info.length,
                start = 0;
                

            var pageInfoHtml = `
                <div class="dt-page-jump">
                    <select name="pagelist" id="pagelist" class="pagelist">
            `;
            
            for(var count = 1; count <= page_info.pages; count++)
            {
                var page_number = count - 1;

                pageInfoHtml += `<option value="${page_number}" data-start="${start}" data-length="${length}">${count}</option>`;

                start = start + page_info.length;
            }
            
            pageInfoHtml += `</select></div>`;
                
            dtFilter.find('label').remove();
            
            dtFilter.html(
            `
            <label>
                <div class="input-group search">
                    <span class="input-group-addon">
                        <span class="ico-mini-search"></span>
                    </span>
                    <input type="search" class="form-control input-sm dt-search" placeholder="Search..." aria-controls="example">
                </div>
            </label>
            `);
            
            $(pageInfoHtml).insertAfter(dtInfo);

            btns.addClass('btn-group');
            btns.find('button').removeAttr('class');
            btns.find('button').addClass('btn btn-default buttons-collection');
        },
        "drawCallback": function( settings ) {
            var   api     = this.api(),
            dtInfo  = $('.dataTables_info');
            var page_info = api.rows( {page:'current'} ).data().page.info();
            $('#totalpages').text(page_info.pages);
            var html = '';

            var start = 0;

            var length = page_info.length;

            for(var count = 1; count <= page_info.pages; count++)
            {
            var page_number = count - 1;

            html += '<option value="'+page_number+'" data-start="'+start+'" data-length="'+length+'">'+count+'</option>';

            start = start + page_info.length;
            }

            $('#pagelist').html(html);

            $('#pagelist').val(page_info.page);
        }
    });
    table.select.info( false);
    table.column(5).search('checked', true, false).draw();
    $(document).on('input', '.dt-search', function()
    {
        table.search($(this).val()).draw() ;
    });
    $(document).on('change', '#pagelist', function()
    {
        var page_no = $('#pagelist').find(":selected").text();
        var table = $('.data-table').dataTable();
        table.fnPageChange(page_no - 1,true);
    });
    $(document).on('change','#exclude',function(){
        var ts = $('#exclude').prop('checked');
        if(ts==false)
        {
            table.column(5).search('checked|', true, false).draw();
        }
        else
        {
            table.column(5).search('checked').draw();
        }
    })
    $(document).on('change', '#MultiSelect_DefaultValues', function() {
        var vals = [];
        var regex;

        $(this).find(':selected').each(function(index, element) {
            var val = $.fn.dataTable.util.escapeRegex($(element).val());
            vals.push(val);
        });

        if (vals.length > 0) {
            regex = vals.join('|');
        } else {
            regex = null;
        }
        table.columns(4).search(regex, true, false).draw();
    });
    $(document).on('change', '#DayFilter', function() {
        // Get the selected values from the dropdown
        var selectedValues = $(this).val();

        // Define a date filter to get the data for today, tomorrow, or a future date
        var dateFilter = [];

        // Function to format date to dd-mm-yyyy
        function formatDateToDDMMYYYY(date) {
            var dd = String(date.getDate()).padStart(2, '0');
            var mm = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero based
            var yyyy = date.getFullYear();
            return dd + '-' + mm + '-' + yyyy;
        }
        
        // Loop through each selected value
        if (selectedValues != null) {
            selectedValues.forEach(function(selectedValue) {
                switch (selectedValue) {
                    case 'No appointment':
                        dateFilter.push('No appointment'); // Filter for 'No appointment'
                        break;
                    case 'All Days':
                        // Filter for today, tomorrow, and future appointments
                        var today = new Date();
                        var tomorrow = new Date();
                        tomorrow.setDate(tomorrow.getDate() + 1);
                        var future = new Date(tomorrow);
                        dateFilter.push(formatDateToDDMMYYYY(today), formatDateToDDMMYYYY(tomorrow), formatDateToDDMMYYYY(future));
                        break;
                    case 'Today':
                        dateFilter.push(formatDateToDDMMYYYY(new Date())); // Filter for today's appointments
                        break;
                    case 'Tomorrow':
                        var tomorrow = new Date();
                        tomorrow.setDate(tomorrow.getDate() + 1); // Filter for tomorrow's appointments
                        dateFilter.push(formatDateToDDMMYYYY(tomorrow));
                        break;
                    case 'Feature Appointments':
                        var future = new Date();
                        future.setDate(future.getDate() + 1); // Filter for feature appointments
                        dateFilter.push(formatDateToDDMMYYYY(future));
                        // Assuming 'feature' is a placeholder for the actual date of the last feature appointment,
                        // use the actual date instead of 'feature' in the future.
                        break;
                }
            });
        }
        // If no value is selected, remove the filter
        if (selectedValues === null || selectedValues.length === 0) {
            selectedValues = null;
            table.column(4).search(selectedValues).draw(); // Clear the filter
            return; // Exit the function early
        }

        // Join the elements of dateFilter with the | pipe sign
        var dateFilterString = dateFilter.join('|');

        // Apply the filter to the DataTable column 4 (assuming column 4 contains the date)
        if (dateFilterString === "") {
            dateFilterString = "^(?!No appointment$)"; // Show only appointments other than 'No appointment'
        }
        table.column(4).search(dateFilterString, true, false).draw();
    });


});
$(document).on('click', '.dt-edit', function(e) {
    e.preventDefault();
    var ids = $(this).attr('ids');
    window.location = 'email-templates/' + ids;
});
$(document).on('click', '.dt-delete', function(e) {
    e.preventDefault();
    $this = $(this);
    var dtRow = $this.parents('tr');
    if(confirm("Are you sure to delete this row?")){
        $.ajax({
        headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "email-templates/"+$(this).attr('ids'),
        type: 'DELETE',
        data: {
            "id": $(this).attr('ids'),
        },
        success: function(response) {
            // Show a Sweet Alert message after the form is submitted.
            if (response.success) {
            Swal.fire({
                title: "Email Template!",
                text: "Your Email Template deleted successfully.",
                icon: "success",
            }).then((result) => {
                            window.location = "{{url('email-templates')}}"//'/player_detail?username=' + name;
                        });
            } else {
            Swal.fire({
                title: "Error!",
                text: response.message,
                icon: "error",
            });
            }
        },
        });
        var table = $('#example').DataTable();
        table.row(dtRow[0].rowIndex-1).remove().draw( false );
    }
});
var client_details = [];
$(document).on('click','.flexSwitchCheckDefault',function(){
    var id =$(this).attr('ids');
    var chk = $(this).val();
    var url = "clients/updateStatus";
    $.ajax({
        type: "POST",
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        data: {// change data to this object
          _token : $('meta[name="csrf-token"]').attr('content'), 
          id:id,
          chk:chk
        },
        dataType: "json",
        success: function(response) {
            if (response.success) {
      
      Swal.fire({
        title: "Client Status!",
        text: "Client Status updated successfully.",
        icon: "success",
      }).then((result) => {
              window.location = "{{url('clients')}}"//'/player_detail?username=' + name;
          });
    } else {
      Swal.fire({
        title: "Error!",
        text: response.message,
        icon: "error",
      });
    }
        },
        error: function (jqXHR, exception) {

        }
    });
})

//for match clients
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

function debounce(func, timeout = 300){
    let timer;
    return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => { func.apply(this, args); }, timeout);
    };
}

//change input modal
const changeInputModal = debounce((val) =>
{
    $('#clientDetails').empty();
    $('.upcoming_appointments').empty();
    $('.history_appointments').empty();
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('calendar.get-all-clients')}}",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                name: $('#searchmodel').val(),
            },
            dataType: "json",
            success: function(res) {
                if (res.length > 0) {
                    $('.client_list_box').show();
                    for (var i = 0; i < res.length; ++i) {
                        // Check if the record with the same id already exists in the array
                        var existingRecordIndex = client_details.findIndex(record => record.id === res[i].id);

                        // If the record doesn't exist in the array, add it
                        if (existingRecordIndex === -1) {
                            // Push client details to the client_details array
                            client_details.push({
                                id: res[i].id,
                                name: res[i].first_name,
                                lastname: res[i].last_name,
                                email: res[i].email,
                                mobile_number: res[i].mobile_no,
                                date_of_birth: res[i].date_of_birth,
                                gender: res[i].gender,
                                home_phone: res[i].home_phone,
                                work_phone: res[i].work_phone,
                                contact_method: res[i].contact_method,
                                send_promotions: res[i].send_promotions,
                                street_address: res[i].street_address,
                                suburb: res[i].suburb,
                                city: res[i].city,
                                postcode: res[i].postcode,
                                client_photos:res[i].client_photos,
                                client_documents: [], // Initialize an empty array for client documents
                                service_name: res[i].last_appointment.service_name,
                                staff_name: res[i].last_appointment.staff_name,
                                start_date: res[i].last_appointment.appointment_date,
                                status: res[i].last_appointment.status,
                                location_name: res[i].last_appointment.location_name
                            });
                        }
                        // Iterate over client documents and push only doc_name and created_at
                        for (var j = 0; j < res[i].documents.length; j++) {
                            // If the record with the same doc_id already exists in the array, skip
                            if (existingRecordIndex !== -1 && client_details[existingRecordIndex].client_documents.some(doc => doc.doc_id === res[i].documents[j].doc_id)) {
                                continue;
                            }
                            // If the record doesn't exist in the array or the doc_id doesn't exist in the documents array, add it
                            if (existingRecordIndex === -1 || !client_details[existingRecordIndex].client_documents.some(doc => doc.doc_id === res[i].documents[j].doc_id)) {
                                client_details[existingRecordIndex !== -1 ? existingRecordIndex : i].client_documents.push({
                                    doc_id: res[i].documents[j].doc_id,
                                    doc_name: res[i].documents[j].doc_name,
                                    created_at: res[i].documents[j].created_at
                                });
                            }
                        }
                    }
                } else {
                    $('.table-responsive').empty();
                }
            },
            error: function(jqXHR, exception) {
                // Handle error
            }
        });

        // $('#clientDetails').empty();
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
                if(person.service_name == null)
                {
                    var appointment = `No Visit history`;
                }
                else
                {
                    var appointment = `<p>last appt at ${person.location_name} on ${person.start_date} </p>
                            <p> ${person.service_name} with ${person.staff_name}(${person.status})</p>`;
                }
                resultElement.innerHTML += `<li onclick='setSearchModal("${person.name}")'>
                        <div class='client-name'>
                            <div class='drop-cap' style='background: #D0D0D0; color: #000;'>${firstCharacter}</div>
                            <div class="client-info">
                                <h4 class="blue-bold">${person.name} ${person.lastname}</h4>
                            </div>
                        </div>
                        <div class="mb-2">
                            <a href="#" class="river-bed"><b>${person.mobile_number || person.home_phone || person.work_phone || ''}</b></a><br>
                            <a href="#" class="river-bed"><b> ${person.email} </b></a>
                        </div>
                        ${appointment}
                    </li>`;
            }
        }
    }
});

//search and set clients
//search and set clients modal
function setSearchModal(value) {
    $('.client_list_box').hide();
    document.getElementById('searchmodel').value = value;
    document.getElementById("resultmodal").innerHTML = "";

    // Iterate over client_details to find a matching value
    for (const key in client_details) {
        console.log(client_details);
        if (client_details.hasOwnProperty(key)) {
            const client = client_details[key];
            // Check if value matches any field in the client object
            if (client.email === value || client.mobile_number === value || client.name === value) {
                console.log(client);
                // If a match is found, dynamically bind HTML to clientDetails element
                $('#clientmodal').show();
                $('.clientCreateModal').hide();
                $("#clientName").val(client.name+client.lastname);
                $("#clientid").val(client.id);
                $("#clientDetailsModal").html(
                    `<i class='ico-user2 me-2 fs-6'></i> ${client.name} ${client.lastname}`);
                document.getElementById('searchmodel').value = '';
                // Trigger the click event of the history button
                // $('.history').click();
                break; // Stop iterating once a match is found
            }
        }
    }
}

//submit create client form
function SubmitCreateWaitlistClient(data){
    var url = $("#clientCreate").data("url");
    $.ajax({
        headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: url,
        type: "post",
        data: data,
        async: false,
        success: function(response) {
            // Show a Sweet Alert message after the form is submitted.
            if (response.success) {
                $('#clientid').val(response.data.id);
            } else {
                Swal.fire({
                    title: "Error!",
                    text: response.message,
                    icon: "error",
                });
            }
        },
    });
}
</script>
</html>
@endsection