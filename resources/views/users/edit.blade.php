@extends('layouts/sidebar')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Page content-->
    <!-- <main> -->
        <div class="card">
            
            <div class="card-head">
                <h4 class="small-title mb-5">Edit User</h4>
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
                        <input type="email" class="form-control" id="email" name="email" maxlength="100" value="{{$users->email}}" onblur="duplicateEmail(this)" readonly>
                        </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone" maxlength="15" value="{{$users->phone}}">
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
                    <div class="toggle mb-0">
                        <input type="radio" name="is_staff_memeber" value="1" {{ ($users->is_staff_memeber=="1")? "checked" : "" }}  id="yes" checked="checked" />
                        <label for="yes">Yes <i class="ico-tick"></i></label>
                        <input type="radio" name="is_staff_memeber" value="0" {{ ($users->is_staff_memeber=="0")? "checked" : "" }}  id="no" />
                        <label for="no">No <i class="ico-tick"></i></label>
                    </div>
                </div>
                <div class="col-lg-4 staff_hide">
                    <div class="form-group">
                        <label class="form-label">Staff member at</label>
                        <select class="form-select form-control" name="staff_member_location" id="staff_member_location">
                        <option selected value> -- select an option -- </option>
                            @foreach($locations as $location)
                            <option value="{{ $location->location_name }}" {{ ( $location->location_name == $users->staff_member_location) ? 'selected' : '' }}> {{ $location->location_name }} </option>
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
                    @if($users->image != '')
                    <figure class="profile-img"><img src="{{asset('images/user_image/').'/'.$users->image}}" alt="" id="imgPreview"></figure>
                    @else
                    <figure class="profile-img"><img src="../images/banner_image/no-image.jpg" alt="" id="imgPreview"></figure>
                    @endif
                    <button type="button" class="btn btn-sm black-btn round-6 dt-delete remove_image">
                        <i class="ico-trash"></i>
                        </button>
                    
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
<!-- </main> -->
@endsection
@section('script')
<script>


    $(document).ready(function() {
        debugger;
        var staffs = $("input[type=radio][name='is_staff_memeber']:checked").val();
        if(staffs== 0) {
            $('.staff_hide').hide();
        }

        $('input[type=radio][name=is_staff_memeber]').change(function() {
            if (this.value == '1') {
                $('.staff_hide').show();
            }
            else if (this.value == '0') {
                $('#staff_member_location').val('');
                $('.staff_hide').hide();
            }
        });
		$("#edit_users").validate({
            rules: {
                first_name: {
                    required: true,
                },
                last_name:{
                    required: true,
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
            }
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
            $("#imgInput").val(null);
            e.preventDefault();
        })
    });
    $(document).on('submit','#edit_users',function(e){debugger;
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
				debugger;
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
