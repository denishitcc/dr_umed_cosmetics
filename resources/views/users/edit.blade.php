@extends('layouts.sidebar')
@section('title', 'Edit User')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Page content-->
    <!-- <main> -->
        <div class="card">
            <div class="card-head">
                <h4 class="small-title mb-5">Edit Staff</h4>
                <h5 class="d-grey mb-0">Details | Photos</h5>
            </div>
            <form id="edit_users" name="edit_users" class="form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="id" value="{{$users->id}}">
            <input type="hidden" name="imgremove" id="imgremove" value="">
            <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control" name="first_name" id="first_name" maxlength="50" value="{{$users->first_name}}">
                        </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">Last Name </label>
                        <input type="text" class="form-control" name="last_name" id="last_name"maxlength="50" value="{{$users->last_name}}">
                        </div>
                </div>
                <div class="col-lg-3">
                    <label class="form-label">Gender</label>
                    <div class="toggle mb-1">
                        <!-- <input type="radio"  id="gender" name="gender" value="Male"  {{ ($users->gender=="Male")? "checked" : "" }} > -->
                        <!-- <input type="radio" name="gender" value="Male" id="male" checked="checked" /> -->
                        <!-- <label for="male">Male <i class="ico-tick"></i></label> -->
                        <!-- <input type="radio"  id="gender" name="gender" value="Female"  {{ ($users->gender=="Female")? "checked" : "" }} > -->
                        <!-- <input type="radio" name="gender" value="Female" id="female" /> -->
                        <!-- <label for="female">Female <i class="ico-tick"></i></label> -->
                        <input type="radio" name="gender" value="Male" {{ ($users->gender=="Male")? "checked" : "" }}  id="male" checked="checked" />
                        <label for="male">Male <i class="ico-tick"></i></label>
                        <input type="radio" name="gender" value="Female" {{ ($users->gender=="Female")? "checked" : "" }}  id="female" />
                        <label for="female">Female <i class="ico-tick"></i></label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" maxlength="100" value="{{$users->email}}" onblur="duplicateEmail(this)" disabled>
                        </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone" maxlength="15" value="{{$users->phone}}">
                        </div>
                </div>
                <div class="col-lg-3">
                    <label class="form-label">Available in Online Booking</label>
                    <div class="toggle mb-4">
                        <input type="radio" name="available_in_online_booking" value="1" {{ ($users->available_in_online_booking=="1")? "checked" : "" }}  id="yes" checked="checked" />
                        <label for="yes">Yes <i class="ico-tick"></i></label>
                        <input type="radio" name="available_in_online_booking" value="0" {{ ($users->available_in_online_booking=="0")? "checked" : "" }}  id="no" />
                        <label for="no">No <i class="ico-tick"></i></label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">Role Type</label>
                        
                        <select class="form-select form-control" name="role_type" id="role_type">
                            <option value> -- select an option -- </option>
                            @foreach ($userRole as $role)
                                <option value="{{ $role->role_name }}" {{ ( $role->role_name == $users->role_type) ? 'selected' : '' }}> {{ $role->role_name }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">Access Level</label>
                        <select class="form-select form-control" name="access_level" id="access_level">
                            <option value> -- select an option -- </option>
                            <option value="Targets" {{ ($users->access_level == "Targets")? "selected" : "" }} >Targets</option>
                            <option value="Limited" {{ ($users->access_level == "Limited")? "selected" : "" }} >Limited</option>
                            <option value="Standard" {{ ($users->access_level == "Standard")? "selected" : "" }} >Standard</option>
                            <option value="Standard+" {{ ($users->access_level == "Standard+")? "selected" : "" }} >Standard+</option>
                            <option value="Advance" {{ ($users->access_level == "Advance")? "selected" : "" }} >Advance</option>
                            <option value="Advance+" {{ ($users->access_level == "Advance+")? "selected" : "" }} >Advance+</option>
                            <option value="Accounts" {{ ($users->access_level == "Accounts")? "selected" : "" }} >Accounts</option>
                            <option value="Admin" {{ ($users->access_level == "Admin")? "selected" : "" }} >Admin</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <label class="form-label">Is a staff member</label>
                    <div class="toggle form-group">
                        <input type="radio" name="is_staff_memeber" value="1" {{ ($users->is_staff_memeber=="1")? "checked" : "" }}  id="yes_staff" checked="checked" />
                        <label for="yes_staff">Yes <i class="ico-tick"></i></label>
                        <input type="radio" name="is_staff_memeber" value="0" {{ ($users->is_staff_memeber=="0")? "checked" : "" }}  id="no_staff" />
                        <label for="no_staff">No <i class="ico-tick"></i></label>
                    </div>
                </div>
                <div class="col-lg-4 staff_hide">
                    <div class="form-group">
                        <label class="form-label">Staff member at</label>
                        <select class="form-select form-control" name="staff_member_location" id="staff_member_location">
                        <option selected value> -- select an option -- </option>
                            @foreach($locations as $location)
                            <option value="{{ $location->id }}" {{ ( $location->id == $users->staff_member_location) ? 'selected' : '' }}> {{ $location->location_name }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">Calendar Color</label>
                        <input type="color" class="form-control" name="calendar_color" id="calendar_color" value="{{ $users->calendar_color }}">
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-7">
                    <label class="gl-upload">
                        <div class="icon-box">
                            <img src="../img/upload-icon.png" alt="" class="up-icon">
                            <span class="txt-up">Upload File</span>
                            <!-- <input class="form-control" type="file" id="imgInput" name="image" accept="image/png, image/gif, image/jpeg"> -->
                            <input type="file" class="form-control" name="image" id="imgInput" accept="image/png, image/gif, image/jpeg">
                        </div>
                    </label>
                    <div class="mt-2 d-grey font-13"><em>Photos you add here will be visible to this client in Online Booking.</em></div>
                </div>
                <div class="col-lg-2 text-center">
                    @if($users->image != '')
                    <figure class="profile-img"><img src="{{asset('storage/images/user_image/').'/'.$users->image}}" alt="" id="imgPreview"></figure>
                    @else
                    <figure class="profile-img"><img src="{{asset('storage/images/banner_image/no-image.jpg')}}" alt="" id="imgPreview"></figure>
                    @endif
                    <button type="button" class="btn btn-sm black-btn round-6 dt-delete remove_image">
                        <i class="ico-trash"></i>
                        </button>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-lg-3">
                    <label class="form-label">Performs all services</label>
                    <div class="toggle form-group">
                        <input type="radio" name="all_services" value="0" id="no1" checked="checked">
                        <label for="no1">No <i class="ico-tick"></i></label>
                        <input type="radio" name="all_services" value="1" id="yes1">
                        <label for="yes1">Yes <i class="ico-tick"></i></label>
                    </div>
                </div>
                <label for="" class="hide_services">Set capabilities below or <a
                        href="javascript:void(0);" class="copy_capabilities">copy another staff member's capabilities.</a></label>
            </div>

            <div class="row form-group hide_services">
                <div class="col-lg-6">
                    <div class="d-flex justify-content-between mb-2">
                        <label class="form-label mb-0">Services</label>
                        <div class="small-tool">Select:
                            <a href="javascript:void(0);" class="me-2 ms-2 btn-link select_all">All</a> | <a
                                href="javascript:void(0);" class="ms-2 btn-link select_none">None</a>
                        </div>
                    </div>
                    <div class="bor-box pd-20 scroll-y mb-3">
                        @if (count($services) > 0)
                            <ul class="list-group list-group-flush ad-flus">
                                @foreach ($services as $service)
                                    <li class="list-group-item">
                                        <label class="cst-check d-flex align-items-center">
                                            <input type="checkbox" value="{{ $service->id }}" name="services[]" class="services" {{ in_array($service->id, $users->user_services->pluck('services_id')->toArray()) ? 'checked' : '' }}>
                                            <span
                                                class="checkmark me-2"></span>{{ $service->service_name }}
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-12 text-lg-end mt-4">
                <button type="button" class="btn btn-light me-2" onclick="window.location='{{ url("users") }}'">Discard</button>
                <button type="submit" class="btn btn-primary" >Save Changes</button>
            </div>
        </div>
            </div>
            </form>
        </div>
    @include('users.partials.copy_capabilities')
<!-- </main> -->
@endsection
@section('script')
<script>
    var moduleConfig = {
        copyCapabilities:   "{!! route('user.copyCapabilities') !!}",
    };
    $.validator.addMethod("validImageExtension", function(value, element) {
        // Check if the file extension is one of the allowed extensions
        return this.optional(element) || /^(png|jpe?g)$/i.test(value.split('.').pop());
    }, "Only PNG, JPEG, or JPG images are allowed.");

    $(document).ready(function() {
        var staffs = $("input[type=radio][name='is_staff_memeber']:checked").val();
        if(staffs== 0) {
            $('.staff_hide').hide();
        }

        $('input[type=radio][name=is_staff_memeber]').change(function() {
            if (this.value == '1') {
                $('.staff_hide').show();
            }
            else if (this.value == '0') {
                // $('#staff_member_location').val('');
                $('.staff_hide').hide();
            }
        });
        $('.select_none').click(function(){
            $("input[name='services[]']:checkbox").prop('checked',false);
        })
        $('.select_all').click(function(){
            $("input[name='services[]']:checkbox").prop('checked',true);
        })
		$("#edit_users").validate({
            rules: {
                first_name: {
                    required: true,
                },
                last_name:{
                    required: true,
                },
                image: {
                    validImageExtension: {
                        depends: function(element) {
                            // Only validate if the file input has a value
                            return $(element).val() !== "";
                        }
                    }
                },
                email:{
                    required: true,
                    email: true
                },
                phone:{
                    required: true,
                },
                last_name:{
                    required: true,
                },
                // image:{
                //     required:true,
                // },
                role_type:{
                    required:true
                },
                access_level:{
                    required:true
                },
                staff_member_location:{
                    required:true
                }
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") === "image") {
                    error.insertAfter(".gl-upload");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                // Check the image extension
                var fileName = $('#imgInput').val();
                var fileExt = fileName.split('.').pop().toLowerCase();
                if(fileName != ''){
                    // Check if the file is an image and has a valid extension
                    if ($.inArray(fileExt, ['png', 'jpeg', 'jpg']) !== -1) {
                        // If valid, submit the form
                        $(form).trigger('submit');
                    } else {
                        // Display an error message
                        // $('.gl-upload').after('<label class="error">Only PNG, JPEG, or JPG images are allowed.</label>');
                    }
                }else{
                    $(form).trigger('submit');
                }
            }
        });
        $("#imgInput").change(function() {
            if (this.files && this.files[0]) {
                var fileName = this.files[0].name;
                var fileSize = this.files[0].size; // in bytes
                var fileExt = fileName.split('.').pop().toLowerCase(); // file extension

                // Check if the file is an image and has a valid extension and size
                if ($.inArray(fileExt, ['png', 'jpeg', 'jpg']) !== -1) { //  && fileSize <= 2097152 2MB in bytes
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#imgPreview').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(this.files[0]);
                } else {
                    // Reset the file input and display an error message
                    $('#imgPreview').attr('src', "{{ asset('/storage/images/banner_image/no-image.jpg') }}");
                    // $('.gl-upload').after('<label class="error">Only PNG, JPEG, or JPG images are allowed.</label>');
                }
            }
        });
        $('.remove_image').click(function(e){
            $('#imgPreview').attr('src', "{{URL::to('/storage/images/banner_image/no-image.jpg')}}");
            $('#imgremove').val('1');
            $("#imgInput").val(null);
            e.preventDefault();
        })

        // Open Copy Capabilities Modal
        $('.copy_capabilities').click(function(e) {
            $('#copy_capabilities_modal').modal('show');
        })

        // Copy Capabilities
        $('#copyCap').click(function(e) {
            var staffId = $('#staff_cap :selected').val();
            $.ajax({
                url: moduleConfig.copyCapabilities,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'staff_id'  : staffId,
                },
                success: function (data) {
                    console.log(data.services);
                    $.each(data.services, function( index, value) {
                        $('.services[value="'+ value +'"]').prop('checked', true);
                        $('#copy_capabilities_modal').modal('hide');
                    });
                    return false;
                },
                error: function (error) {
                    console.error('Error fetching capabilities:', error);
                }
            });
        })
    });
    $(document).on('submit','#edit_users',function(e){
		e.preventDefault();
        var id=$('#id').val();
		var valid= $("#edit_users").validate();
			if(valid.errorList.length == 0){
            var data = new FormData(this);
            submitEditUserForm(data,id);
		}
	});
    function submitEditUserForm(data,id){
        var url = "../users/update_info";
		$.ajax({
			headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			// url: id,
            url: url,
			type: "POST",
            processData: false,
            contentType: false,
            data: data,
			success: function(response) {
				// Show a Sweet Alert message after the form is submitted.
				if (response.success) {
					Swal.fire({
						title: "User!",
						text: "Your User updated successfully.",
						type: "success",
					}).then((result) => {
                        window.location = "{{url('users')}}"//'/player_detail?username=' + name;
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
@endsection
