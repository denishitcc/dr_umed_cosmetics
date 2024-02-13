@extends('layouts/sidebar')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
        <!-- Page content-->
        <!-- <main> -->
                <div class="card">
                    <ul class="nav brand-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#tab_1"><i class="ico-my-account"></i> My Account</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab_2"><i class="ico-business-settings"></i> Business Settings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab_3"><i class="ico-branding"></i> Branding</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab_4"><i class="ico-staff-user"></i> Staff & Users</a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab_5"><i class="ico-appt-reminder"></i> Appt Reminders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab_6"><i class="ico-payment-gateway"></i> Payment Gateways</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="tab_1" role="tabpanel">
                        <div class="card-body">
                            <h4 class="small-title mb-5">My Account</h4>
                            
                                <form id="update_myaccount" name="update_myaccount" class="form" enctype='multipart/form-data'>
                                @csrf
                                <input type="hidden" name="imgremove" id="imgremove" value="">
                                <div class="row gap-4">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="fname" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="first_name" placeholder="First Name" name="first_name" value="{{$user->first_name}}" maxlength="50">
                                        </div>
                                        <div class="form-group">
                                            <label for="lname" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="last_name" placeholder="Last Name" name="last_name" value="{{$user->last_name}}" maxlength="50">
                                        </div>
                                            
                                        
                                            <div class="pt-4">
                                            <p><a href="#" class="simple-link" data-bs-toggle="modal" data-bs-target="#change_pass"> Change Password</a></p>
                                            <!-- <p><a href="#" class="simple-link" data-bs-toggle="modal" data-bs-target="#change_pin"> Change PIN</a></p> -->
                                        </div>
                                        
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="row">
                                            <div class="col-lg-9">
                                                <div class="form-group">
                                                    <label class="gl-upload">
                                                        <div class="icon-box">
                                                            <img src="img/upload-icon.png" alt="" class="up-icon">
                                                            <span class="txt-up">Upload File</span>
                                                            <input type="file" class="form-control" name="image" id="imgInput" accept="image/png, image/gif, image/jpeg">
                                                        </div>
                                                    </label>
                                                    <!-- <div class="mt-2 d-grey font-13"><em>Photos you add here will be visible to this client in Online Booking.</em></div> -->
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-3 text-center">
                                                @if($user->image!='')
                                                    <figure class="profile-img"><img src="{{ asset('/storage/images/user_image/'.$user->image) }}" alt="" id="imgPreview"></figure>
                                                    <button type="button" class="btn btn-sm black-btn round-6 dt-delete remove_image">
                                                    <i class="ico-trash"></i>
                                                    </button>
                                                @else
                                                    <figure class="profile-img"><img src="{{ asset('/storage/images/banner_image/no-image.jpg') }}" alt="" id="imgPreview"></figure>
                                                    <button type="button" class="btn btn-sm black-btn round-6 dt-delete remove_image">
                                                    <i class="ico-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                        

                                    </div>
                                </div>
                                <div class="col-lg-12 text-lg-end mt-4">
                                    <button type="button" class="btn btn-light me-2">Discard</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                </form>
                            
                        </div>
                            
                        </div>
                        <div class="tab-pane fade" id="tab_2" role="tabpanel">
                            <div class="card-head">
                                <h4 class="small-title mb-5">Business Settings</h4>
                                <h5 class="d-grey mb-0">Business Details</h5>
                            </div>
                            <div class="card-body">
                                <form id="update_business_settings" name="update_business_settings" class="form">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Business Details For</label>
                                            <select class="form-select form-control business_details_for" id="business_details_for" name="business_details_for">
                                                <option value="Dr Umed Enterprise">Dr Umed Enterprise</option>
                                                @foreach($locations as $loc)
                                                <option value="{{ $loc->id }}">{{ $loc->location_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="other_contacts">
                                    
                                    
                                    <div class="form-group mb-0">
                                        
                                        
                                        <h5 class="small-title mb-4 mt-3">Contact Info</h5>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label">Business Name </label>
                                                    <input type="text" class="form-control" placeholder="Business Name" name="business_name" id="business_name" value="{{ $users_data->business_name??'Dr Umed Enterprise' }}" maxlength="50">
                                                    </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label">Name Customers See</label>
                                                    <input type="text" class="form-control" placeholder="Name Customers See" name="name_customers_see" id="name_customers_see" value="{{ $users_data->name_customers_see??'Dr Umed Cosmetic and Injectables' }}" maxlength="100">
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                
                                                    <div class="form-group">
                                                    <label class="form-label">Business Email</label>
                                                    <input type="text" class="form-control" placeholder="Business Email" name="business_email" id="business_email" value="{{ $users_data->business_email??'info@drumedcosmetics.com.au' }}" maxlength="100">
                                                    </div>
                                            </div>
                                            <div class="col-lg-4">
                                                    <div class="form-group">
                                                    <label class="form-label">Business Phone</label>
                                                    <input type="text" class="form-control" placeholder="Business Phone" name="business_phone" id="business_phone" value="{{ $users_data->business_phone??'0407194519' }}" maxlength="20">
                                                    </div>
                                            </div>
                                            <div class="col-lg-4 postcode_info">
                                                <div class="form-group">
                                                    <label class="form-label">Postcode</label>
                                                    <input type="text" class="form-control" placeholder="Postcode" name="post_code" id="post_code" maxlength="10" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 street_address_info">
                                                    <div class="form-group">
                                                    <label class="form-label">Street Address</label>
                                                    <input type="text" class="form-control" placeholder="Street Address" name="street_address" id="street_address" maxlength="30" value="">
                                                    </div>
                                            </div>
                                            <div class="col-lg-4 suburb_info">
                                                    <div class="form-group">
                                                    <label class="form-label">Suburb</label>
                                                    <input type="text" class="form-control" placeholder="Suburb" name="suburb" id="suburb" maxlength="30" value="">
                                                    </div>
                                            </div>
                                            <div class="col-lg-4 city_info">
                                                    <div class="form-group">
                                                    <label class="form-label">City</label>
                                                    <input type="text" class="form-control" placeholder="City" name="city" id="city" maxlength="30" value="">
                                                    </div>
                                            </div>
                                            
                                            
                                            <div class="col-lg-12 text-lg-end mt-4">
                                                <button type="button" class="btn btn-light me-2">Discard</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </div>
                                        </form> 
                                        <!-- End -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab_3" role="tabpanel">
                            <div class="card-head">
                                <h4 class="small-title mb-3">Brand banner image <small>(optional)</small></h4>
                                <h5 class="d-grey mb-4">Recommended dimensions: 800px x 200px</h5>
                                <form id="update_brand_image" name="update_brand_image" class="form" enctype='multipart/form-data' action="{{route('update-brand-image')}}" method="post">
                                @csrf
                                <input type="hidden" name="bannerremove" id="bannerremove" value="">
                                @if($user->banner_image!='')
                                <div class="form-group"><img src="{{ asset('/storage/images/banner_image/'.$user->banner_image) }}" alt="" id="imgBannerPreview"></div>
                                @else
                                <div class="form-group"><img src="{{ asset('/storage/images/banner_image/no-image.jpg') }}" alt="" id="imgBannerPreview"></div>
                                @endif
                                
                                <div class="row">
                                    <div class="col-lg-7">
                                        <label class="gl-upload">
                                            <div class="icon-box">
                                                <img src="img/upload-icon.png" alt="" class="up-icon">
                                                <span class="txt-up">Upload File</span>
                                                <input class="form-control" type="file" id="brandInput" name="banner_image" accept="image/png, image/gif, image/jpeg">
                                            </div>
                                        </label>
                                        
                                        
                                        <button class="simple-link remove_banner p-0 btn mt-2">Remove Banner</button> 
                                    </div>
                                </div>
                                <div class="col-lg-12 text-lg-end mt-4">
                                        <button type="button" class="btn btn-light me-2">Discard</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                    
                                </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="tab_4" role="tabpanel">
                                4
                            </div>
                            <div class="tab-pane fade" id="tab_5" role="tabpanel">
                                5
                            </div>
                            <div class="tab-pane fade" id="tab_6" role="tabpanel">
                                6
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
        <!-- </main> -->
        <!-- All Modal  -->
            
    <!-- Modal -->
    <div class="modal fade" id="change_pass" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">Change Password</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="change_passwords" name="change_passwords" class="form">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="c-pass" class="form-label">Current Password</label>
                    <input type="text" class="form-control" id="current_password" placeholder="Current Password" name="current_password">
                    </div>
                    <div class="form-group">
                    <label for="n-pass" class="form-label">New password</label>
                    <input type="text" class="form-control" id="new_password" placeholder="New Password"  name="new_password">
                    </div>
                    <div class="form-group">
                    <label for="cn-pass" class="form-label">Confirm New Password</label>
                    <input type="text" class="form-control" id="new_password_confirmation" placeholder="Confirm New Password" name="new_password_confirmation">
                    </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-light custom-close">Discard</button>
            <button type="submit" class="btn btn-primary change_pass">Save</button>
            </div>
            </form>
        </div>
        </div>
    </div>

       
    </div>
    @stop
@section('script')
<script>
$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
    $(document).ready(function() {
        $('.website_info').hide();
        $('.street_address_info').hide();
        $('.suburb_info').hide();
        $('.city_info').hide();
        $('.postcode_info').hide();
        $("#business_details_for").change(function() {
            
            $('#business_details_fors').val($('option:selected', this).val());

            $.ajax({
            url: "{{route('get-business-details')}}",
            data: {'business_details_for' : $('option:selected', this).val()},
            type: "post",
            cache: false,
                success: function(html){
                    
                    $('#business_name').val(html.business_name);
                    $('#name_customers_see').val(html.name_customers_see);
                    $('#business_email').val(html.business_email);
                    $('#business_phone').val(html.business_phone);
                    $('#website').val(html.website);
                    $('#street_address').val(html.street_address);
                    $('#suburb').val(html.suburb);
                    $('#city').val(html.city);
                    $('#post_code').val(html.post_code);
                }
            });
            if($('option:selected', this).text() != 'Dr Umed Enterprise')
            {
                $('.website_info').show();
                $('.street_address_info').show();
                $('.suburb_info').show();
                $('.city_info').show();
                $('.postcode_info').show();
            }
            else
            {
                $('.website_info').hide();
                $('.street_address_info').hide();
                $('.suburb_info').hide();
                $('.city_info').hide();
                $('.postcode_info').hide();
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
        $('#brandInput').change(function() {
            if (this.files && this.files[0]) {

                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#imgBannerPreview').attr('src', e.target.result);
                }

                reader.readAsDataURL(this.files[0]);
            }
        });
        $('.remove_image').click(function(e){
            $('#imgPreview').attr('src', "{{ asset('/storage/images/banner_image/no-image.jpg') }}");
            $('#imgremove').val('1');
            e.preventDefault();
        })
        $('.remove_banner').click(function(e){
            $('#imgBannerPreview').attr('src', "{{ asset('/storage/images/banner_image/no-image.jpg') }}");
            $('#bannerremove').val('1');
            e.preventDefault();
        });
        $(".custom-close").on('click', function() {
            $('#change_pass').modal('hide');
        });
		$("#change_passwords").validate({
            rules: {
                current_password: {
                    required: true,
					minlength:8,
                },
                new_password:{
                    required: true,
					minlength:8,
                },
                new_password_confirmation:{
                    required: true,
					minlength:8,
                },
            }
        });
        $('#update_myaccount').validate({
            rules: {
                first_name: {
                    required: true,
                },
                last_name:{
                    required: true,
                }
            }
        });
        $('#update_business_settings').validate({
            rules: {
                // business_name: {
                //     required: true,
                // },
                // name_customers_see:{
                //     required: true,
                // },
                business_email:{
                    // required:true,
                    email: true
                },
                // business_phone:{
                //     required:true
                // }
            }
        });
        $('#update_business_setting').validate({
            rules: {
                // business_name: {
                //     required: true,
                // },
                // name_customers_see:{
                //     required: true,
                // },
                // business_email:{
                //     required:true,
                // },
                // business_phone:{
                //     required:true
                // },
                // website:{
                //     required: true,
                // },
                // city:{
                //     required:true,
                // },
                // post_code:{
                //     required:true
                // }
            }
        });
    });
    $(document).on('submit','#change_passwords',function(e){
		e.preventDefault();
		var valid= $("#change_passwords").validate();
			if(valid.errorList.length == 0){
			var data = $('#change_passwords').serialize() ;
			submitPasswordForm(data);
		}
	});
    $(document).on('submit','#update_myaccount',function(e){
		e.preventDefault();
		var valid= $("#update_myaccount").validate();
			if(valid.errorList.length == 0){
			// var data = $('#update_myaccount').serialize() ;
            var data = new FormData(this);
			submitMyAccountForm(data);
		}
	});
    $(document).on('submit','#update_business_settings',function(e){
		e.preventDefault();
		var valid= $("#update_business_settings").validate();
			if(valid.errorList.length == 0){
			var data = $('#update_business_settings').serialize() ;
			submitBusinessSettingsForm(data);
		}
	});
    function submitPasswordForm(data){
		$.ajax({
			headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: "{{route('change-password')}}",
			type: "post",
			data: data,
			success: function(response) {
				
				// Show a Sweet Alert message after the form is submitted.
				if (response.success) {
					
					Swal.fire({
						title: "Change Password!",
						text: "Your Password updated successfully.",
						type: "success",
					}).then((result) => {
                        window.location = "{{url('settings')}}"//'/player_detail?username=' + name;
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
    function submitMyAccountForm(data){
		$.ajax({
			headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: "{{route('my-account')}}",
			type: "post",
			data: data,
            contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
            processData: false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
            cache: false,
			success: function(response) {
				
				// Show a Sweet Alert message after the form is submitted.
				if (response.success) {
					Swal.fire({
						title: "My Account!",
						text: "Your Account updated successfully.",
						type: "success",
					}).then((result) => {
                        window.location = "{{url('settings')}}"//'/player_detail?username=' + name;
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
    function submitBusinessSettingsForm(data){
		$.ajax({
			headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: "{{route('update-business-settings')}}",
			type: "post",
			data: data,
			success: function(response) {
				
				// Show a Sweet Alert message after the form is submitted.
				if (response.success) {
					Swal.fire({
						title: "Business Settings!",
						text: "Your Business Settings updated successfully.",
						type: "success",
					}).then((result) => {
                        window.location = "{{url('settings')}}"//'/player_detail?username=' + name;
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