@extends('layouts/sidebar')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<!-- <main> -->
    <div class="card">
        
        <div class="card-head">
            <h4 class="small-title mb-5">Add Staff</h4>
            <h5 class="d-grey mb-0">Details | Photos</h5>
        </div>
        <!-- <form class="form"  action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
        @csrf -->
        <form id="create_user" name="create_user" class="form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="imgremove" id="imgremove" value="">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">First Name</label>
                        
                        <input type="text" class="form-control" name="first_name" id="first_name" maxlength="50">
                        </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">Last Name </label>
                        <input type="text" class="form-control" name="last_name" id="last_name"maxlength="50">
                        </div>
                </div>
                <div class="col-lg-3">
                    <label class="form-label">Gender</label>
                    <div class="toggle mb-1">
                        <input type="radio" name="gender" value="Male" id="male" checked="checked" />
                        <label for="male">Male <i class="ico-tick"></i></label>
                        <input type="radio" name="gender" value="Female" id="female" />
                        <label for="female">Female <i class="ico-tick"></i></label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" maxlength="100">
                        </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone" maxlength="15">
                        </div>
                </div>
                <div class="col-lg-3">
                    <label class="form-label">Available in Online Booking</label>
                    <div class="toggle mb-4">
                        <input type="radio" name="available_in_online_booking" value="1" id="yes_available" checked="checked">
                        <label for="yes_available">Yes <i class="ico-tick"></i></label>
                        <input type="radio" name="available_in_online_booking" value="0" id="no_available">
                        <label for="no_available">No <i class="ico-tick"></i></label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">Role Type</label>
                        <select class="form-select form-control" name="role_type" id="role_type">
                            <option selected value> -- select an option -- </option>
                            @foreach($userRole as $role)
                            <option>{{$role->role_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">Access Level</label>
                        <select class="form-select form-control" name="access_level" id="access_level">
                            <option selected value> -- select an option -- </option>
                            <option>Targets</option>
                            <option>Limited</option>
                            <option>Standard</option>
                            <option>Standard+</option>
                            <option>Advance</option>
                            <option>Advance+</option>
                            <option>Accounts</option>
                            <option>Admin</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <label class="form-label">Is a staff member</label>
                    <div class="toggle form-group">
                        <input type="radio" name="is_staff_memeber" value="1" id="yes" checked="checked">
                        <label for="yes">Yes <i class="ico-tick"></i></label>
                        <input type="radio" name="is_staff_memeber" value="0" id="no">
                        <label for="no">No <i class="ico-tick"></i></label>
                    </div>
                </div>
                <div class="col-lg-4 staff_hide">
                    <div class="form-group">
                        <label class="form-label">Staff member at</label>
                        <select class="form-select form-control" name="staff_member_location" id="staff_member_location">
                        <option selected value> -- select an option -- </option>
                            @foreach($locations as $location)
                            <option>{{$location->location_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
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
                    <figure class="profile-img"><img src="../images/banner_image/no-image.jpg" alt="" id="imgPreview"></figure>
                    <button type="button" class="btn btn-sm black-btn round-6 dt-delete remove_image">
                        <i class="ico-trash"></i>
                        </button>
                    
                </div>
            </div>

            <div class="col-lg-12 text-lg-end mt-4">
                <button type="button" class="btn btn-light me-2" onclick="window.location='{{ url("users") }}'">Discard</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
        </form>
        
    </div>
<!-- </main> -->
@stop
@section('script')
<script>
    $(document).ready(function() {
        $('input[type=radio][name=is_staff_memeber]').change(function() {
            if (this.value == '1') {
                $('.staff_hide').show();
            }
            else if (this.value == '0') {
                $('.staff_hide').hide();
            }
        });
		$("#create_user").validate({
            rules: {
                first_name: {
                    required: true,
                },
                last_name: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "../users/checkEmail", // Replace with the actual URL to check email uniqueness
                        type: "post", // Use "post" method for the AJAX request
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            email: function () {
                                return $("#email").val(); // Pass the value of the email field to the server
                            }
                        },
                        dataFilter: function (data) {
                            var json = $.parseJSON(data);
                            var chk = json.exists ? '"Email already exist!"' : '"true"';
                            return chk;
                        }
                    }
                },
                phone: {
                    required: true,
                },
                last_name: {
                    required: true,
                },
                role_type: {
                    required: true
                },
                access_level: {
                    required: true
                },
                staff_member_location: {
                    required: true
                }
            },
        });

        $("#imgInput").change(function() {
            if (this.files && this.files[0]) {

                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#imgPreview').attr('src', e.target.result);
                }

                reader.readAsDataURL(this.files[0]);
            }
        });

        $('.remove_image').click(function(e){
            debugger;
            $('#imgPreview').attr('src', "{{URL::to('/images/banner_image/no-image.jpg')}}");
            $('#imgremove').val('1');
            // $('#imgInput').attr('src', '#');
            $("#imgInput").val(null);
            e.preventDefault();
        })
    });
    $(document).on('submit','#create_user',function(e){debugger;
		e.preventDefault();
		var valid= $("#create_user").validate();
			if(valid.errorList.length == 0){
			// var data = $('#create_user').serialize() ;

            var data = new FormData(this);
            // let image = $('#imgInput')[0].files.length;
            // let files = $('#imgInput')[0];
            // data.append('files', files.files);

			submitCreateUserForm(data);
		}
	});
    function submitCreateUserForm(data){
        debugger;
        // var formData = new FormData();
        // var image = $('#imgInput').prop('files')[0];   
        // var first_name=$('#first_name').val();
        // var last_name=$('#last_name').val();
        // var email=$('#email').val();
        // var phone=$('#phone').val();
        // var role_type=$('#role_type').val();
        // var access_level=$('#access_level').val();
        // var gender = $('input[name="gender"]:checked').val();
        // var imgremove = $('#imgremove').val();

        // formData.append('image', image);
        // formData.append('first_name', first_name);
        // formData.append('last_name', last_name);
        // formData.append('email', email);
        // formData.append('phone', phone);
        // formData.append('role_type', role_type);
        // formData.append('access_level', access_level);
        // formData.append('gender', gender);
        // formData.append('imgremove',imgremove);
		$.ajax({
			headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: "{{route('users.store')}}",
            type: "post",
            // contentType: 'multipart/form-data',
            cache: false,
            contentType: false,
            processData: false,
			data: data,
			success: function(response) {
				debugger;
				// Show a Sweet Alert message after the form is submitted.
				if (response.success) {
					
					Swal.fire({
						title: "User!",
						text: "Your User created successfully.",
						type: "success",
					}).then((result) => {
                        window.location = "{{url('users')}}"//'/player_detail?username=' + name;
                    });
					
				} else {
					debugger;
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