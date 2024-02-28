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
                <div id="clientDetails"></div>
                <div id='external-events'></div>
                <div id="result" class="list-group"></div>
                <div id="mycalendar"> </div>
                {{-- <img src="img/demo-calander.png" alt="" class="search_client"> onkeyup="changeInput(this.value)" --}}
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
            <div id="clientCreate" data-url="{{ route('clients.store') }}"></div>
            <form id="create_client" name="create_client" class="form" method="post">
                @csrf
                <input type="hidden" name="check_client" id="check_client" value="selected_client">
                <div class="modal-header">
                    <h4 class="modal-title">Please add new appointment here</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                            <div class="service-list-box p-2" id="all_ser">
                                <ul class="ctg-tree ps-0 pe-1">
                                    <li class="pt-title">
                                        <div class="disflex">
                                            <label id="subcategory_text">All Services &amp; Tasks</label>
                                        </div>
                                        <ul id="sub_services">
                                            @foreach ($services as $services)
                                                <li>
                                                    <a href="javascript:void(0);" class="services" data-services_id="{{$services->id}}" data-category_id="{{$services->parent_category}}">{{ $services->service_name }}</a>
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
    @include('calender.partials.client-modal')
</div>
@stop
@section('script')
<script src="{{ asset('js/fullcalendar-scheduler-6.1.10/dist/index.global.js') }}"></script>
<script src="{{ asset('js/fullcalendar-scheduler-6.1.10/dist/index.global.min.js') }}"></script>
<script src="{{ asset('js/appointment.js') }}"></script>
<script type="text/javascript">
    var moduleConfig = {
        getStaffList:       "{!! route('get-staff-list') !!}",
        categotyByservices: "{!! route('calender.get-category-services') !!}",
        getClients:         "{!! route('calendar.get-all-clients') !!}",
        createAppointment:  "{!! route('calendar.create-appointments') !!}",
        getEvents:          "{!! route('calendar.get-events') !!}",
        updateAppointment:  "{!! route('calendar.update-appointments') !!}",
        getClientCardData:  "{!! route('calendar.get-client-card-data', ':ID') !!}",
    };

    $(document).ready(function()
    {
        DU.appointment.init();
        $('#external-events').draggable();

        //for fancybox gallery
        $(".gallery a").attr("data-fancybox","mygallery");
        $(".gallery a").fancybox();

        /*
        We want to preview images, so we need to register the Image Preview plugin
        */
        FilePond.registerPlugin(
            
            // encodes the file as base64 data
            FilePondPluginFileEncode,
            
            // validates the size of the file
            FilePondPluginFileValidateSize,
            
            // corrects mobile image orientation
            FilePondPluginImageExifOrientation,
            
            // previews dropped images
            FilePondPluginImagePreview
        );
        const inputElement = document.getElementById('client_photos');

        // update client detail validation
        $("#update_client_detail").validate({
            rules: {
                firstname: {
                    required: true,
                },
                lastname:{
                    required:true,
                },
                email:{
                    required: true,
                    email: true
                },
                mobile_number:{
                    required: true,
                },
                date_of_birth:{
                    required: true,
                },
                contact_method:{
                    required: true,
                },
                street_address:{
                    required: true,
                },
                suburb:{
                    required: true,
                },
                city:{
                    required: true,
                },
                postcode:{
                    required: true,
                },
            },
        });

        // client photo updates
        $("#client_photos").change(function () {
            
            var inputElement = document.getElementById('client_photos');
            var data = new FormData();
            var id=$('#id').val();
            for (var i = 0; i < this.files.length; i++) {
                var reader = new FileReader();
                var files = this.files[i].name;
                var currFile = this.files[i];

                reader.onload = (function (file) {
                    return function (e) {
                        var fileName = file.name;
                        var fileContents = e.target.result;
                        
                        $('.client-phbox').append('<input type="hidden" name="hdn_img" value="' + file + '">' +
                        '<figure imgname="' + fileName + '" id="remove_image" class="remove_image">' +
                        '<a href='+ fileContents +' data-fancybox="mygallery">' +
                        '<img src=' + fileContents + ' class="img-fluid">' +
                        '</a></figure>');
                    };
                })(currFile);
                reader.readAsDataURL(this.files[i]);
                data.append('pics[]', currFile);
                data.append('id',id);
            }
            jQuery.ajax({
                headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{route('clients-photos')}}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Client!",
                            text: "Client Photos Updated successfully.",
                            type: "success",
                        }).then((result) => {
                            var photosCount = parseInt($('.photos_count').text());
                            var resultdoc = photosCount + 1;
                            $('.photos_count').text(resultdoc);
                            // window.location = "{{url('calender')}}/"
                            // window.location = "{{url('clients')}}"//'/player_detail?username=' + name;
                        });
                    } else {
                        
                        Swal.fire({
                            title: "Error!",
                            text: response.message,
                            type: "error",
                        });
                    }
                }
            });
        });

        //update client documents
        $("#client_documents").change(function() {
            var inputElement = document.getElementById('client_documents');
            var data = new FormData();
            var id=$('#id').val();
            for (var i = 0; i < this.files.length; i++) {
                var reader = new FileReader();
                var files = this.files[i].name;
                var currFile = this.files[i];

                reader.onload = (function (file) {
                    return function (e) {
                        var d = new Date();
                        const month = d.toLocaleString('default', { month: 'long' });
                        var fulldate = d.getDate()+' '+ month + ' ' + d.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
                        var fileName = file.name;
                        var fileContents = e.target.result;
                        $('.docs').append('<a href="#" class="btn tag icon-btn-left skyblue mb-2"><span><i class="ico-pdf me-2 fs-2 align-middle"></i> ' + fileName + '</span> <span class="file-date">' + fulldate + '</span><i class="del ico-trash"></i></a>');
                        // $('.docs').append('<a href="#" class="btn tag icon-btn-left skyblue remove_doc mb-2"><i class="ico-pdf me-2 fs-2"></i> ' + fileName + ' <i class="del ico-trash"></i></a><figure style="display:none"; imgname='+ fileName +' id="remove_image" class="remove_image"><img src=' + fileContents + '><button type="button" class="btn black-btn round-6 dt-delete"><i class="ico-trash"></i></button></figure>');
                    };
                })(currFile);
                reader.readAsDataURL(this.files[i]);
                data.append('pics[]', currFile);
                data.append('id',id);
            }
            jQuery.ajax({
                headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{route('clients-documents')}}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Client!",
                            text: "Client Documents Updated successfully.",
                            type: "success",
                        }).then((result) => {
                            var documentsCount = parseInt($('.documents_count').text());
                            var resultdoc = documentsCount + 1;
                            $('.documents_count').text(resultdoc);
                            // Bind links for each uploaded file
                            var files = inputElement.files; // Get selected files
                            for (var i = 0; i < files.length; i++) {
                                var file = files[i];
                                var fileName = file.name; // Get file name
                                var formattedDate = formatDate(new Date()); // Format date (you may adjust this as needed)
                                var clientId = response.client_id[i];
                                // Create link element for the file
                                var link = $('<a>').addClass('btn tag icon-btn-left skyblue mb-2').html('<span><i class="ico-pdf me-2 fs-2 align-middle"></i>' + fileName + '</span><span class="file-date">' + formattedDate + '</span><i class="del ico-trash remove_doc" ids="'+clientId+'"></i>');
                                $('.client_docs').append(link);
                            }
                        });
                    } else {
                        
                        Swal.fire({
                            title: "Error!",
                            text: response.message,
                            type: "error",
                        });
                    }
                }
            });
        });

        //remove document
        $(document).on('click', '.remove_doc', function (e) {
            e.preventDefault();
            $(this).parent().remove();
            var data = new FormData();
            var id = $('#id').val();
            var doc_id = $(this).attr('ids');
            data.append('id',id);
            data.append('doc_id',doc_id);
            jQuery.ajax({
                headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{route('clients-documents-remove')}}",
                data: data,
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                data: data,
                contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
                processData: false,
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Client!",
                            text: "Client Documents Deleted successfully.",
                            type: "success",
                        }).then((result) => {
                            var documentsCount = parseInt($('.documents_count').text());
                            var resultdoc = documentsCount - 1;
                            $('.documents_count').text(resultdoc);
                            // window.location = "{{url('clients')}}/" + id
                        });
                    } else {
                        
                        Swal.fire({
                            title: "Error!",
                            text: response.message,
                            type: "error",
                        });
                    }
                }
            });
        });
    });

    //submit update client details form
    $(document).on('submit','#update_client_detail',function(e){
		e.preventDefault();
        var id=$('#id').val();
		var valid= $("#update_client_detail").validate();
			if(valid.errorList.length == 0){
            var data = $('#update_client_detail').serialize() ;
			SubmitUpdateClientDetails(data,id);
		}
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
                        client_documents: [], // Initialize an empty array for client documents,
                        service_name: res[i].last_appointment.service_name,
                        staff_name: res[i].last_appointment.staff_name,
                        start_date: res[i].last_appointment.start_date,
                        status: res[i].last_appointment.status,
                        location_name: res[i].last_appointment.location_name
                   });
                    // Iterate over client documents and push only doc_name and created_at
                    for (var j = 0; j < res[i].client_documents.length; j++) {
                        client_details[i].client_documents.push({
                            doc_id: res[i].client_documents[j].doc_id,
                            doc_name: res[i].client_documents[j].doc_name,
                            created_at: res[i].client_documents[j].created_at
                        });
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

    // Assuming you have a function to trigger opening the modal with a specific client id
    // For example, if you have a button or link to open the modal, you can attach a click event handler to it
    // $(document).on('click','.open-client-card-btn',function(e){
    //     var clientId = $(this).data('client-id'); // Use data('client-id') to access the attribute
    //     openClientCard(clientId);
    // });

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

    //change input event
    function changeInput(val) {
        $('#clientDetails').empty();
            $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('calendar.get-all-clients')}}",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                name: $('#search').val(),
            },
            dataType: "json",
            success: function(res) {
                if (res.length > 0) {
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
                                start_date: res[i].last_appointment.start_date,
                                status: res[i].last_appointment.status,
                                location_name: res[i].last_appointment.location_name
                            });
                        }
                        // Iterate over client documents and push only doc_name and created_at
                        for (var j = 0; j < res[i].client_documents.length; j++) {
                            // If the record with the same doc_id already exists in the array, skip
                            if (existingRecordIndex !== -1 && client_details[existingRecordIndex].client_documents.some(doc => doc.doc_id === res[i].client_documents[j].doc_id)) {
                                continue;
                            }
                            // If the record doesn't exist in the array or the doc_id doesn't exist in the client_documents array, add it
                            if (existingRecordIndex === -1 || !client_details[existingRecordIndex].client_documents.some(doc => doc.doc_id === res[i].client_documents[j].doc_id)) {
                                client_details[existingRecordIndex !== -1 ? existingRecordIndex : i].client_documents.push({
                                    doc_id: res[i].client_documents[j].doc_id,
                                    doc_name: res[i].client_documents[j].doc_name,
                                    created_at: res[i].client_documents[j].created_at
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
                    var details = `<div class='client-name'><div class='drop-cap' style='background: #D0D0D0; color: #000;'>${firstCharacter}</div></div><p> ${person.name} <br> ${person.email}  |  ${person.mobile_number} </p>
                    last appointment at ${person.location_name} on ${person.start_date} ${person.service_name} with ${person.staff_name}(${person.status})`;
                    resultElement.innerHTML += `<a class='list-group-item list-group-item-action' href='javascript:void(0);' onclick='setSearch("${person.name}")'>${details}</a>`;
                }
            }
        }
    }

    //change input modal
    function changeInputModal(val) {
        $('#clientDetails').empty();
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
                                    start_date: res[i].last_appointment.start_date,
                                    status: res[i].last_appointment.status,
                                    location_name: res[i].last_appointment.location_name
                                });
                            }
                            // Iterate over client documents and push only doc_name and created_at
                            for (var j = 0; j < res[i].client_documents.length; j++) {
                                // If the record with the same doc_id already exists in the array, skip
                                if (existingRecordIndex !== -1 && client_details[existingRecordIndex].client_documents.some(doc => doc.doc_id === res[i].client_documents[j].doc_id)) {
                                    continue;
                                }
                                // If the record doesn't exist in the array or the doc_id doesn't exist in the client_documents array, add it
                                if (existingRecordIndex === -1 || !client_details[existingRecordIndex].client_documents.some(doc => doc.doc_id === res[i].client_documents[j].doc_id)) {
                                    client_details[existingRecordIndex !== -1 ? existingRecordIndex : i].client_documents.push({
                                        doc_id: res[i].client_documents[j].doc_id,
                                        doc_name: res[i].client_documents[j].doc_name,
                                        created_at: res[i].client_documents[j].created_at
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
                    var details = `<div class='client-name'><div class='drop-cap' style='background: #D0D0D0; color: #000;'>${firstCharacter}</div></div><p> ${person.name} <br> ${person.email}  |  ${person.mobile_number} </p>
                    last appointment at ${person.location_name} on ${person.start_date} ${person.service_name} with ${person.staff_name}(${person.status})`;
                    resultElement.innerHTML += `<a class='list-group-item list-group-item-action' href='javascript:void(0);' onclick='setSearchModal("${person.name}")'>${details}</a>`;
               }
            }
        }
    }

    //search and set clients
    function setSearch(value) {
        document.getElementById('search').value = value;
        document.getElementById("result").innerHTML = "";

        // Iterate over client_details to find a matching value
        for (const key in client_details) {
            console.log(client_details);
            if (client_details.hasOwnProperty(key)) {
                const client = client_details[key];
                // Check if value matches any field in the client object
                if (client.email === value || client.mobile_number === value || client.name === value) {
                    console.log(client);
                    // If a match is found, dynamically bind HTML to clientDetails element
                    $('#clientDetails').html(
                        `<div class='client-name'><div class='drop-cap' style='background: #D0D0D0; color: #000;'>
                        ${client.name.charAt(0).toUpperCase() }
                        </div></div>
                        <p><input type='hidden' name='client_name' value='${client.name} ${client.lastname}'><input type='hidden' name='client_id' value='${client.id}'>
                        ${client.name} <br>
                        ${client.email} |
                        ${client.mobile_number}
                        </p>
                        <button class='btn btn-primary btn-sm me-2 open-client-card-btn' data-client-id="${client.id}">Client Card</button>
                        <button class='btn btn-primary btn-sm me-2' data-client-id="${client.id}">History</button>
                        <button class='btn btn-primary btn-sm me-2' data-client-id="${client.id}">Upcoming</button>`
                    );

                    document.getElementById('search').value = '';
                    break; // Stop iterating once a match is found
                }
            }
        }
    }

    //search and set clients modal
    function setSearchModal(value) {
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
                    $("#clientDetailsModal").html(
                        "<i class='ico-user2 me-2 fs-6'></i> "+ client.name +' '+ client.lastname);
                    $('#clientDetails').html(
                        `<div class='client-name'><div class='drop-cap' style='background: #D0D0D0; color: #000;'>
                        ${client.name.charAt(0).toUpperCase() }
                        </div></div>
                        <p><input type='hidden' name='client_name' value='${client.name} ${client.lastname}'><input type='hidden' name='client_id' value='${client.id}'>
                        ${client.name} <br>
                        ${client.email} |
                        ${client.mobile_number}
                        </p>
                        <button class='btn btn-primary btn-sm me-2 open-client-card-btn' data-client-id="${client.id}">Client Card</button>
                        <button class='btn btn-primary btn-sm me-2' data-client-id="${client.id}">History</button>
                        <button class='btn btn-primary btn-sm me-2' data-client-id="${client.id}">Upcoming</button>`
                    );
                    document.getElementById('searchmodel').value = '';
                    break; // Stop iterating once a match is found
                }
            }
        }
    }

    // Assuming you have a function to open the modal
    function openClientCard(clientId) {
        // Find the client details by id
        var client = client_details.find(function(client) {
            return client.id == clientId;
        });

        // Update the modal with the client details
        if (client) {
            $('.modal-title-client').text('Client card - ' + client.name + ' ' + client.lastname);
            $('.client-name .blue-bold').text(client.name + ' ' + client.lastname);
            $('.client-info a:eq(0)').text(client.mobile_number ?? '').attr('href', 'tel:' + client.mobile_number ?? '');
            $('.client-info a:eq(1)').text(client.email).attr('href', 'mailto:' + client.email);
            $('.drop-cap').text(client.name.charAt(0));
            // You can add more fields as needed
            
            // clien details bind
            $('#id').val(client.id);
            $('#firstname').val(client.name);
            $('#lastname').val(client.lastname);
            $('input[name="gender"][value="' + client.gender + '"]').prop('checked', true);
            $('input[name="email"]').val(client.email);
            $('#date_of_birth').val(client.date_of_birth);
            $('#mobile_number').val(client.mobile_number);
            $('#home_phone').val(client.home_phone);
            $('#work_phone').val(client.work_phone);
            $('#contact_method').val(client.contact_method);
            $('input[name="send_promotions"][value="' + client.send_promotions + '"]').prop('checked', true);
            $('#street_address').val(client.street_address);
            $('#suburb').val(client.suburb);
            $('#city').val(client.city);
            $('#postcode').val(client.postcode);

            // Display client photos dynamically
            if (client.client_photos && client.client_photos.length > 0) {
                $('.photos_count').text(client.client_photos.length);

                var photoContainer = $('.client-phbox'); // Assuming you have a container for client photos in your modal
                photoContainer.empty(); // Clear previous photos
                client.client_photos.forEach(function(photoUrl) {
                    var img = $('<img>').attr('src', '{{ asset('storage/images/clients_photos/') }}' + '/' + photoUrl).addClass('img-fluid');
                    var anchor = $('<a>').attr({
                        'href': '{{ asset('storage/images/clients_photos/') }}' + '/' + photoUrl,
                        'data-fancybox': 'mygallery' // Add data-fancybox attribute
                    }).append(img);
                    var figure = $('<figure>').append(anchor);
                    photoContainer.append(figure);
                });
            }
             // Display client documents dynamically
            if (client.client_documents && client.client_documents.length > 0) {
                $('.documents_count').text(client.client_documents.length);
                // client_documents_created_at
                var documentListContainer = $('.client_docs'); // Assuming you have a container for client documents in your modal
                documentListContainer.empty(); // Clear previous documents
                client.client_documents.forEach(function(doc) {
                    // Assuming each document object has a property called 'created_at' representing its creation date
                    var createdDate = new Date(doc.created_at);
                    var formattedDate = formatDate(createdDate); // Assuming formatDate function formats the date appropriately
                    
                    var link = $('<a>').addClass('btn tag icon-btn-left skyblue mb-2').html('<span><i class="ico-pdf me-2 fs-2 align-middle"></i>' + doc.doc_name + '</span><span class="file-date">' + formattedDate + '</span><i class="del ico-trash remove_doc" ids = "'+ doc.doc_id+ '"></i>');
                    var listItem = $('<span>').append(link);
                    documentListContainer.append(listItem);
                });
            }


            // Open the modal
            $('#Client_card').modal('show');
        }
    }

    //format date
    function formatDate(date) {
        const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        const day = date.getDate();
        const monthIndex = date.getMonth();
        const month = months[monthIndex];
        const hours = date.getHours();
        const minutes = date.getMinutes();
        const ampm = hours >= 12 ? 'PM' : 'AM';
        const formattedHours = hours % 12 === 0 ? 12 : hours % 12;
        const formattedMinutes = minutes < 10 ? '0' + minutes : minutes;
        return `${day} ${month} ${formattedHours}:${formattedMinutes} ${ampm}`;
    }

    // Example usage:
    const date = new Date(); // Replace this with your actual date object
    const formattedDate = formatDate(date);

    //submit update client details form
    function SubmitUpdateClientDetails(data,id){
		$.ajax({
			headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: '/clients/' + id,
			type: "PUT",
			data: data,
            success: function(response) {
				
				// Show a Sweet Alert message after the form is submitted.
				if (response.success) {
					
					Swal.fire({
						title: "Client!",
						text: "Client Updated successfully.",
						type: "success",
					}).then((result) => {
                        // window.location = "{{url('calender')}}/"
                    });
					
				} else {
					
					Swal.fire({
						title: "Error!",
						text: response.message,
						type: "error",
					});
				}
			},
		});
	}
</script>
</html>
@endsection