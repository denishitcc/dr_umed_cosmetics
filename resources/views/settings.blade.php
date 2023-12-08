@extends('layouts/sidebar')
@section('content')
<!-- Page content-->
<!-- Page content-->
<style>
    .error{color:red;}
</style>
    <main>
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
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab_4"><i class="ico-staff-user"></i> Staff & Users</a>
                    </li>
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
                            <div class="row">
                                <form id="update_myaccount" name="update_myaccount" class="form">
                                @csrf
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="fname" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{$user->first_name}}">
                                        </div>
                                        <div class="form-group">
                                        <label for="lname" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{$user->last_name}}">
                                        </div>

                                        <div class="pt-4">
                                        <p><a href="#" class="simple-link" data-bs-toggle="modal" data-bs-target="#change_pass"> Change Password</a></p>
                                        <!-- <p><a href="#" class="simple-link" data-bs-toggle="modal" data-bs-target="#change_pin"> Change PIN</a></p> -->
                                    </div>
                                    
                                </div>
                                <div class="col-lg-12 text-lg-end mt-4">
                                    <button type="button" class="btn btn-light me-2">Discard</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                </form>
                            </div>
                        </div>
                        
                    </div>
                    <div class="tab-pane fade" id="tab_2" role="tabpanel">

                        <div class="card-head">
                            <h4 class="small-title mb-5">Business Settings</h4>
                            <h5 class="d-grey mb-0">Business Details</h5>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label class="form-label">Business Details For</label>
                                        <select class="form-select form-control">
                                            <option>Dr.Umed Enterprise</option>
                                            <option value="1">Option 1</option>
                                            <option value="2">Option 2</option>
                                            <option value="3">Option 3</option>
                                            <option value="4">Option 4</option>
                                            <option value="5">Option 5</option>
                                        </select>
                                        </div>
                                </div>
                            </div>
                            <h5 class="small-title mb-4 mt-3">Contact Info</h5>
                            <div class="mw-750">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Business Name </label>
                                            <input type="text" class="form-control" placeholder="Dr Umed Enterprise">
                                            </div>
                                            <div class="form-group">
                                            <label class="form-label">Business Email</label>
                                            <input type="text" class="form-control" placeholder="info@drumedcosmetics.com.au">
                                            </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Name Customers See</label>
                                            <input type="text" class="form-control" placeholder="Dr Umed Cosmetic and Injectables">
                                            </div>
                                            <div class="form-group">
                                            <label class="form-label">Business Phone</label>
                                            <input type="text" class="form-control" placeholder="0407194519">
                                            </div>
                                    </div>
                                </div>
                            </div>

                            <h5 class="small-title mb-3 mt-3">Give to Client</h5>
                            <p class="fw-500 d-grey mb-4">You can choose to include or exclude the 'More info' section of the Client Card in Give to Client view.</p>
                            <div class="form-group mb-5">
                                <div class="row">
                                    <div class="col-lg-3">
                                            <label class="form-label">Include 'More info' </label>
                                            <div class="toggle mb-1">
                                                <input type="radio" name="sizeBy" value="" id="yes" checked="checked" />
                                                <label for="yes">Yes <i class="ico-tick"></i></label>
                                                <input type="radio" name="sizeBy" value="" id="no" />
                                                <label for="no">No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-text">The 'More info' section includes client attributes set up in the umed Admin tab.</div>
                                </div>

                                <h5 class="small-title mb-4 mt-3">Gender Neutral Mode</h5>
                                
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-3">
                                                <label class="form-label">Enable 'Gender Neutral Mode'</label>
                                                <div class="toggle mb-1">
                                                    <input type="radio" name="genmod" value="" id="g-yes" checked="checked" />
                                                    <label for="g-yes">Yes <i class="ico-tick"></i></label>
                                                    <input type="radio" name="genmod" value="" id="g-no" />
                                                    <label for="g-no">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-text">The 'More info' section includes client attributes set up in the umed Admin tab.</div>
                                    </div>
                            
                            
                            

                            
                        </div>
                        
                        
                            
                        
                    </div>
                    <div class="tab-pane fade" id="tab_3" role="tabpanel">
                        3
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
    </main>

    <!-- All Modal  -->
            
    <!-- Modal -->
    <div class="modal fade" id="change_pass" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">Change Password</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @if($errors->any())
            {!! implode('', $errors->all('<div style="color:red">:message</div>')) !!}
            @endif
            @if(Session::get('error') && Session::get('error') != null)
            <div style="color:red">{{ Session::get('error') }}</div>
            @php
            Session::put('error', null)
            @endphp
            @endif
            @if(Session::get('success') && Session::get('success') != null)
            <div style="color:green">{{ Session::get('success') }}</div>
            @php
            Session::put('success', null)
            @endphp
            @endif
            <form id="change_passwords" name="change_passwords" class="form">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="c-pass" class="form-label">Current Password</label>
                    <input type="text" class="form-control" id="current_password" name="current_password">
                    </div>
                    <div class="form-group">
                    <label for="n-pass" class="form-label">New password</label>
                    <input type="text" class="form-control" id="new_password" name="new_password">
                    </div>
                    <div class="form-group">
                    <label for="cn-pass" class="form-label">Confirm New Password</label>
                    <input type="text" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
                    </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-light">Discard</button>
            <button type="submit" class="btn btn-primary change_pass">Save</button>
            </div>
            </form>
        </div>
        </div>
    </div>

       
    </div>
@stop
@section('script')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
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
			var data = $('#update_myaccount').serialize() ;
			submitMyAccountForm(data);
		}
	});
    function submitPasswordForm(data){
		$.ajax({
			headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: "{{route('change-password')}}",
			type: "post",
			data: data,
			success: function(response) {
				debugger;
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
    function submitMyAccountForm(data){
		$.ajax({
			headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: "{{route('my-account')}}",
			type: "post",
			data: data,
			success: function(response) {
				debugger;
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
</script>