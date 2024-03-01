@extends('layouts/sidebar')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Page content-->
    
    <div class="card">
                        
        <div class="card-head">
            <div class="toolbar mb-5">
                <div class="tool-left"><h4 class="small-title mb-0">Add Clients</h4></div>
                <div class="tool-right">
                    <!-- <a href="#" class="btn btn-primary btn-md">Get client to fill the details</a> -->
                </div>
            </div>
            
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
                        <input type="text" class="form-control" name="email" id="email" maxlength="100">
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
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">Home Phone</label>
                        <input type="text" class="form-control" name="home_phone" id="home_phone" maxlength="15">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">Work Phone</label>
                        <input type="text" class="form-control" name="work_phone" id="work_phone" maxlength="15">
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
            <h5 class="bright-gray mb-0">Photos <span class="badge text-bg-blue badge-circle photos_cnt"></span></h5>
        </div>
        <div class="card-body">
            <!-- <input type="file" class="filepond" name="filepond" id="client_photos" multiple/> -->
            <div class="row form-group">
                <div class="col-lg-7">
                    <label class="gl-upload photo_img">
                        <div class="icon-box">
                            <img src="{{ asset('img/upload-icon.png') }}" alt="" class="up-icon">
                            <span class="txt-up">Choose a File or drag them here</span>
                            <input type="file" class="filepond form-control" name="photos" id="client_photos" accept="image/png, image/jpeg" multiple/>
                            
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
            <h5 class="bright-gray mb-0">Documents <span class="badge text-bg-blue badge-circle docs_cnt"></span></h5>
        </div>

        <div class="card-body">

            <div class="row form-group">
                <div class="col-lg-7">
                    <label class="gl-upload doc_img">
                        <div class="icon-box">
                            <img src="{{ asset('img/upload-icon.png') }}" alt="" class="up-icon">
                            <span class="txt-up">Choose a File or drag them here</span>
                            <span class="txt-up" style="opacity: .5;">.xls, Word, PNG, JPG or PDF</span>
                            <input type="file" class="filepond form-control" name="documents" id="client_documents" accept="application/pdf, applucation/vnd.ms-excel,application/msword,image/png, image/jpeg" multiple/>
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

    // Select the file input and use create() to turn it into a pond
    // FilePond.create(
    //     document.querySelector('input')
    // );

    // const inputElement = document.getElementById('client_photos');
    //     FilePond.create(
    //     document.querySelector('input')
    // );
    const inputElement = document.getElementById('client_photos');
    // FilePond.create(inputElement, {
    // // options here
    // })

    // const inputElement = document.getElementById('client_documents');
    //     FilePond.create(
    //     document.querySelector('input')
    // );
    const inputElement1 = document.getElementById('client_documents');
    // FilePond.create(inputElement1, {
    // // options here
    // })
    var file_cnt=0;
    var doc_cnt=0;
    $(document).ready(function() {
		$("#create_client").validate({
            rules: {
                firstname: {
                    required: true,
                },
                lastname:{
                    required: true
                },
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "../clients/checkClientEmail",
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            email: function () {
                                return $("#email").val();
                            }
                        },
                        dataFilter: function (data) {
                            var json = $.parseJSON(data);
                            return json.exists ? '"Email already exists!"' : '"true"';
                        }
                    }
                },
                mobile_number: {
                    required: true
                },
                date_of_birth: {
                    required: true
                },
                contact_method: {
                    required: true
                },
                street_address: {
                    required: true
                },
                suburb: {
                    required: true
                },
                city: {
                    required: true
                },
                postcode: {
                    required: true
                },
                photos: {
                    validImageExtension: true // Remove the depends option
                },
                documents: {
                    validDocumentExtension: true // Remove the depends option
                }
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") === "photos") {
                    error.insertAfter(".photo_img");
                } else if (element.attr("name") === "documents") {
                    error.insertAfter(".doc_img");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {
                // The form is already valid at this point
                $(form).trigger('submit');
            }
        });

        // Custom validation methods
        $.validator.addMethod("validImageExtension", function (value, element) {
            var fileExt = value.split('.').pop().toLowerCase();
            return $.inArray(fileExt, ['png', 'jpeg', 'jpg']) !== -1;
            if(file_cnt != ''){
                $('.photos_cnt').text(file_cnt);
            }else{
                $('.photos_cnt').text('');
            }
        }, "Only PNG, JPEG, or JPG images are allowed for photos.");

        $.validator.addMethod("validDocumentExtension", function (value, element) {
            var fileExt = value.split('.').pop().toLowerCase();
            return $.inArray(fileExt, ['png', 'jpeg', 'jpg', 'xlsx', 'doc', 'pdf']) !== -1;
            if(doc_cnt != ''){
                $('.docs_cnt').text(doc_cnt);
            }else{
                $('.docs_cnt').text('');
            }
        }, "Only PNG, JPEG, XLS, Word, PDF or JPG images are allowed for documents.");

        
        $("#client_photos").change(function() {
            var inputElement = document.getElementById('client_photos');
            for (var i = 0; i < this.files.length; i++) {
                $('.photos_cnt').text(file_cnt+1);
                var reader = new FileReader();
                var files = this.files[i].name;
                var currFile = this.files[i];
                var fileExt = files.split('.').pop().toLowerCase(); // file extension

                // Check if the file is an image and has a valid extension and size
                if ($.inArray(fileExt, ['png', 'jpeg', 'jpg']) !== -1) { // 2MB in bytes  && fileSize <= 2097152
                    var reader = new FileReader();

                    reader.onload = (function (file) {
                        return function (e) {
                            var files = file.name;
                            var fileContents = e.target.result;
                            $('.client-phbox').append('<input type="hidden" name="hdn_img" value='+file+'><figure imgname='+ files +' id="remove_image" class="remove_image"><img src=' + fileContents + '><button type="button" class="btn black-btn round-6 dt-delete"><i class="ico-trash"></i></button></figure>');
                        };
                    })(currFile);
                    reader.readAsDataURL(this.files[i]);
                    file_cnt++;
                } else {
                    
                    if(file_cnt != ''){
                        $('.photos_cnt').text(file_cnt);
                    }else{
                        $('.photos_cnt').text('');
                    }
                    
                    // Reset the file input and display an error message
                    // $('#imgPreview').attr('src', "{{ asset('/storage/images/banner_image/no-image.jpg') }}");
                    // $('.error').remove();
                    // $('.photo_img').after('<label class="error">Only PNG, JPEG, or JPG images are allowed for photos.</label>');
                }
            }
        });
        $("#client_documents").change(function() {
            var inputElement = document.getElementById('client_documents');
            for (var i = 0; i < this.files.length; i++) {
                $('.docs_cnt').text(doc_cnt+1);
                var reader = new FileReader();
                var files = this.files[i].name;
                var currFile = this.files[i];
                var fileExt = files.split('.').pop().toLowerCase(); // file extension

                // Check if the file is an image and has a valid extension and size
                if ($.inArray(fileExt, ['png', 'jpeg', 'jpg', 'xlsx', 'doc', 'pdf']) !== -1) {
                    var reader = new FileReader();

                    reader.onload = (function (file) {
                        return function (e) {
                            var fileName = file.name;
                            var fileContents = e.target.result;
                            $('.file-hoder').append('<a href="#" class="btn tag icon-btn-left skyblue remove_doc"><i class="ico-pdf me-2 fs-2"></i> ' + files + ' <i class="del ico-trash"></i></a><figure style="display:none"; imgname='+ fileName +' id="remove_image" class="remove_image"><img src=' + fileContents + '><button type="button" class="btn black-btn round-6 dt-delete"><i class="ico-trash"></i></button></figure>');
                        };
                    })(currFile);
                    reader.readAsDataURL(this.files[i]);
                    doc_cnt++;
                } else {
                    
                    if(doc_cnt != ''){
                        $('.docs_cnt').text(doc_cnt);
                    }else{
                        $('.docs_cnt').text('');
                    }
                    
                    // Reset the file input and display an error message
                    // $('#imgPreview').attr('src', "{{ asset('/storage/images/banner_image/no-image.jpg') }}");
                    // $('.doc_img').after('<label class="error">Only PNG, JPEG, XLS, Word, PDF or JPG images are allowed for documents.</label>');
                }
                
            }
        });
        
    });
    $(document).on('submit','#create_client',function(e){
		e.preventDefault();
		var valid= $("#create_client").validate();
			if(valid.errorList.length == 0){
            var data = new FormData(this);
            $.each($('.client-phbox').find('img'),function(index){
                
                var photos_img = $('.client-phbox').find('img')[index].src;
                data.append('pics[]', photos_img);
            });
            $.each($('.file-hoder').find('a'),function(index){
                
                var docs_imgs = $('.file-hoder').find('img')[index].src;
                data.append('docs[]', docs_imgs);
            });
			SubmitCreateClient(data);
		}
	});
    $(document).on('click', '.remove_image', function (e) {
        e.preventDefault();
        $(this).remove();
        file_cnt--;
        $('.photos_cnt').text(file_cnt);
    });
    $(document).on('click', '.remove_doc', function (e) {
        e.preventDefault();
        $(this).next().remove();
        $(this).remove();
        doc_cnt--;
        $('.docs_cnt').text(doc_cnt);
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
					
					Swal.fire({
						title: "Error!",
						text: response.message,
						type: "error",
					});
				}
			},
		});
	}
    // function duplicateEmail(element){
    //     var email = $(element).val();
    //     var url = "../clients/checkClientEmail";
    //     $.ajax({
    //         type: "POST",
    //         headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         url: url,
    //         data: {// change data to this object
    //           _token : $('meta[name="csrf-token"]').attr('content'), 
    //           email:email
    //         },
    //         dataType: "json",
    //         success: function(res) {
    //             if(res.exists){
    //               $('#email').after('<p style="color:red";>Email already exist');
    //                 // alert('true');
    //             }else{
    //                 // alert('false');
    //             }
    //         },
    //         error: function (jqXHR, exception) {

    //        }
    //    });
    // }
</script>
@endsection
