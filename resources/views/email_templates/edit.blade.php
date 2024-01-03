@extends('layouts/sidebar')
@section('content')
    <!-- Page content-->
    
        <div class="card">
            
            <div class="card-head">
                <h4 class="small-title mb-5">Edit Email Template</h4>
                <h5 class="d-grey mb-0">Details</h5>
            </div>
            <form id="update_email_templates" name="update_email_templates" class="form" method="post">
            @csrf
            <input type="hidden" name="id" id="id" value="{{$email_templates->id}}">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Email Template Type </label>
                            <input type="text" class="form-control" id="email_template_type" name="email_template_type" value="{{$email_templates->email_template_type}}">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Subject </label>
                            <input type="text" class="form-control" id="subject" name="subject" value="{{$email_templates->subject}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group mb-0">
                            <label class="form-label">Email Template Description </label>
                            <textarea class="form-control" id="email_template_description" name="email_template_description" rows="5">{!! $email_templates->email_template_description !!}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="col-lg-12 text-lg-end mt-4">
                    <button type="button" class="btn btn-light me-2" onclick="window.location='{{ url("email-templates") }}'">Discard</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
            </form>
        </div>
@endsection
@section('script')
<script>
    ClassicEditor
        .create(document.querySelector( '#email_template_description' ) )
        .then(editor => {
            editor.editing.view.change( writer => {
                writer.setStyle('min-height', '300px', editor.editing.view.document.getRoot());
                writer.setStyle('min-width', '1100px', editor.editing.view.document.getRoot());
            } );
        window.editor = editor;
        });
    $(document).ready(function() {
		$("#update_email_templates").validate({
            // ignore: [],
            // debug: false,
            rules: {
                email_template_type: {
                    required: true,
                },
                subject: {
                    required: true,
                },
                email_template_description:{
                    required: function() 
                    {
                        CKEDITOR.instances.email_template_description.updateElement();
                    },
                }
            },
        });
    });
    $(document).on('submit','#update_email_templates',function(e){debugger;
		e.preventDefault();
        var id=$('#id').val();
		var valid= $("#update_email_templates").validate();
			if(valid.errorList.length == 0){
			var data = $('#update_email_templates').serialize() ;
			SubmitCreateEmailTemplates(data);
		}
	});
    function SubmitCreateEmailTemplates(data,id){
		$.ajax({
			headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: id,
			type: "PUT",
			data: data,
			success: function(response) {
				debugger;
				// Show a Sweet Alert message after the form is submitted.
				if (response.success) {
					
					Swal.fire({
						title: "Email Template!",
						text: "Your Email Template updated successfully.",
						type: "success",
					}).then((result) => {
                        window.location = "{{url('email-templates')}}"//'/player_detail?username=' + name;
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
