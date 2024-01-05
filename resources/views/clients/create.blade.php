@extends('layouts/sidebar')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Page content-->
    
    <div class="card">
                        
        <div class="card-head">
            <div class="toolbar mb-5">
                <div class="tool-left"><h4 class="small-title mb-0">Add Clients</h4></div>
                <div class="tool-right"><a href="#" class="btn btn-primary btn-md">Get client to fill the details</a></div></div>
            
            <h5 class="bright-gray mb-0">Details | Photos | Documents</h5>
        </div>
        <form id="create_client" name="create_client" class="form" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="file_names" id="fileNames" value="">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">First Name</label>
                        
                        <input type="text" class="form-control" name="firstname" id="firstname" maxlength="50">
                        </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">Last Name </label>
                        <input type="text" class="form-control" name="lastname" id="lastname" maxlength="50">
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
                        <input type="text" class="form-control" name="email" id="email" maxlength="100" onblur="duplicateEmail(this)">
                        </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" name="date_of_birth" id="date_of_birth" maxlength="100">
                        </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group mb-0">
                        <label class="form-label">Mobile Number</label>
                        <input type="text" class="form-control" name="mobile_number" id="mobile_number" maxlength="15">
                        </div>
                </div>
            </div>
        </div>

        <div class="card-head">
            <h5 class="bright-gray mb-0">Contact preferences</h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group mb-0">
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
                
                <div class="col-lg-3">
                    <label class="form-label">Send promotions</label>
                    <div class="toggle mb-0">
                        <input type="radio" name="send_promotions" value="1" id="yes" checked="checked">
                        <label for="yes">Yes <i class="ico-tick"></i></label>
                        <input type="radio" name="send_promotions" value="0" id="no">
                        <label for="no">No <i class="ico-tick"></i></label>
                    </div>
                </div>
            </div>

            
        </div>
        <div class="card-head">
            <h5 class="bright-gray mb-0">Address</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">Street address</label>
                        <input type="text" class="form-control" name="street_address" id="street_address" maxlength="100">
                        </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">Suburb</label>
                        <input type="text" class="form-control" name="suburb" id="suburb" maxlength="100">
                        </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group mb-0">
                        <label class="form-label">City</label>
                        <input type="text" class="form-control" name="city" id="city" maxlength="100">
                        </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group mb-0">
                        <label class="form-label">Post code</label>
                        <input type="text" class="form-control" name="postcode" id="postcode" maxlength="100">
                        </div>
                </div>
            </div>
        </div>

        <div class="card-head">
            <h5 class="bright-gray mb-0">Photos <span class="badge text-bg-blue badge-circle">10</span></h5>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-lg-7">
                    <label class="gl-upload">
                        <div class="icon-box">
                            <img src="{{ asset('img/upload-icon.png') }}" alt="" class="up-icon">
                            <!-- <span class="txt-up">Choose a File or drag them here</span> -->
                            <input class="form-control" type="file" class="client_photos" id="client_photos" name="client_photos[]" accept="image/png, image/gif, image/jpeg" multiple>
                        </div>
                    </label>
                    <div class="mt-2 d-grey font-13"><em>Photos you add here will be visible to this client in Online Booking.</em></div>
                </div>
                <div class="col-lg-5">
                    <div class="client-phbox">
                    </div>

                </div>
                
            </div>

            
        </div>
        <div class="card-head">
            <h5 class="bright-gray mb-0">Documents <span class="badge text-bg-blue badge-circle">4</span></h5>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-lg-7">
                    <label class="gl-upload">
                        <div class="icon-box">
                            <img src="{{ asset('img/upload-icon.png') }}" alt="" class="up-icon">
                            <!-- <span class="txt-up">Choose a File or drag them here</span> -->
                            <!-- <span class="txt-up" style="opacity: .5;">.xls, Word, PNG, JPG or PDF (max. 5MB Upload)</span> -->
                            
                            <input class="form-control" type="file" id="client_documents" name="client_documents[]" accept="image/png, image/gif, image/jpeg" multiple>
                        </div>
                    </label>
                    <div class="mt-2 d-grey font-13"><em>Documents you add here will be visible to this client in Online Booking.</em></div>
                </div>
                <div class="col-lg-5">
                    <div class="file-hoder">
                        <!-- <a href="#" class="btn tag icon-btn-left skyblue"><i class="ico-pdf me-2 fs-2"></i> Alana_Invoice.pdf <i class="del ico-trash"></i></a>
                        <a href="#" class="btn tag icon-btn-left skyblue"><i class="ico-png me-2 fs-2"></i> Alana_treatment.png <i class="del ico-trash"></i></a>
                        <a href="#" class="btn tag icon-btn-left skyblue"><i class="ico-pdf me-2 fs-2"></i> Alana_Invoice.pdf <i class="del ico-trash"></i></a>
                        <a href="#" class="btn tag icon-btn-left skyblue"><i class="ico-pdf me-2 fs-2"></i> Alana_Invoice.pdf <i class="del ico-trash"></i></a> -->
                    </div>
                </div>
                
            </div>

            <div class="col-lg-12 text-lg-end mt-4">
                <button type="button" class="btn btn-light me-2" onclick="window.location='{{ url("clients") }}'">Discard</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
            
        </div>
        </form>

        
        
        
    </div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
		$("#create_client").validate({
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
                client_photos:{
                    required: true,
                }
            },
        });

        $("#client_photos").change(function() {
            var inputElement = document.getElementById('client_photos');
            for (var i = 0; i < this.files.length; i++) {
                var reader = new FileReader();
                var files = this.files[i].name;
                var currFile = this.files[i];

                reader.onload = (function (file) {debugger;
                    return function (e) {
                        var fileName = file.name;
                        var fileContents = e.target.result;
                        $('.client-phbox').append('<input type="hidden" name="hdn_img" value='+file+'><figure imgname='+ fileName +' id="remove_image" class="remove_image"><img src=' + fileContents + '><button type="button" class="btn black-btn round-6 dt-delete"><i class="ico-trash"></i></button></figure>');
                    };
                })(currFile);
                reader.readAsDataURL(this.files[i]);

            }
        });
        $("#client_documents").change(function() {
            var inputElement = document.getElementById('client_documents');
            for (var i = 0; i < this.files.length; i++) {
                var reader = new FileReader();
                var files = this.files[i].name;
                var currFile = this.files[i];

                reader.onload = (function (file) {debugger;
                    return function (e) {
                        var fileName = file.name;
                        var fileContents = e.target.result;
                        $('.file-hoder').append('<a href="#" class="btn tag icon-btn-left skyblue remove_doc"><i class="ico-pdf me-2 fs-2"></i> ' + fileName + ' <i class="del ico-trash"></i></a><figure style="display:none"; imgname='+ fileName +' id="remove_image" class="remove_image"><img src=' + fileContents + '><button type="button" class="btn black-btn round-6 dt-delete"><i class="ico-trash"></i></button></figure>');
                    };
                })(currFile);
                reader.readAsDataURL(this.files[i]);
            }
        });
        
    });
    $(document).on('submit','#create_client',function(e){debugger;
		e.preventDefault();
		var valid= $("#create_client").validate();
			if(valid.errorList.length == 0){
            var data = new FormData(this);
            $.each($('.client-phbox').find('img'),function(index){
                debugger;
                var photos_img = $('.client-phbox').find('img')[index].src;
                data.append('pics[]', photos_img);
            });
            $.each($('.file-hoder').find('a'),function(index){
                debugger;
                var docs_imgs = $('.file-hoder').find('img')[index].src;
                data.append('docs[]', docs_imgs);
            });
			SubmitCreateClient(data);
		}
	});
    $(document).on('click', '.remove_image', function (e) {debugger;
        e.preventDefault();
        $(this).remove();
    });
    $(document).on('click', '.remove_doc', function (e) {debugger;
        e.preventDefault();
        $(this).next().remove();
        $(this).remove();
    });
    function SubmitCreateClient(data){
		$.ajax({
			headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: "{{route('clients.store')}}",
			type: "post",
			data: data,
            contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
            processData: false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
            cache: false, // To unable request pages to be cached
			success: function(response) {
				debugger;
				// Show a Sweet Alert message after the form is submitted.
				if (response.success) {
					
					Swal.fire({
						title: "Client!",
						text: "Your Client created successfully.",
						type: "success",
					}).then((result) => {
                        window.location = "{{url('clients')}}"//'/player_detail?username=' + name;
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
    function duplicateEmail(element){
        var email = $(element).val();
        var url = "../clients/checkClientEmail";
        $.ajax({
            type: "POST",
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            data: {// change data to this object
              _token : $('meta[name="csrf-token"]').attr('content'), 
              email:email
            },
            dataType: "json",
            success: function(res) {
                if(res.exists){
                  $('#email').after('<p style="color:red";>Email already exist');
                    // alert('true');
                }else{
                    // alert('false');
                }
            },
            error: function (jqXHR, exception) {

           }
       });
    }
</script>
@endsection
