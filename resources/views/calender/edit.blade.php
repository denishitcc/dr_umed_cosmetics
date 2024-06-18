@extends('layouts/sidebar')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="card">
                        
    <div class="card-head">
        <div class="toolbar mb-5">
            <div class="tool-left"><h4 class="small-title mb-0">Edit Supplier</h4></div>
            <div class="tool-right"><a href="{{ route('products.index') }}" class="btn btn-primary btn-md">Back to Products</a></div>
        </div>
        
        <h5 class="bright-gray mb-0">Details</h5>
    </div>
    <form id="edit_suppliers" name="edit_suppliers" class="form">
    @csrf
    <input type="hidden" name="id" id="id" value="{{$suppliers->id}}">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group">
                    <label class="form-label">Business Name</label>
                    <input type="text" class="form-control" id="business_name" name="business_name" maxlength="50" value="{{$suppliers->business_name}}">
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group">
                    <label class="form-label">Contact first Name </label>
                    <input type="text" class="form-control" id="contact_first_name" name="contact_first_name" maxlength="50" value="{{$suppliers->contact_first_name}}">
                    </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label class="form-label">Contact last name</label>
                    <input type="text" class="form-control" id="contact_last_name" name="contact_last_name" maxlength="50" value="{{$suppliers->contact_last_name}}">
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group">
                    <label class="form-label">Home Phone</label>
                    <input type="text" class="form-control" id="home_phone" name="home_phone" maxlength="15" value="{{$suppliers->home_phone}}">
                    </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label class="form-label">Work Phone</label>
                    <input type="text" class="form-control" id="work_phone" name="work_phone" maxlength="15" value="{{$suppliers->work_phone}}">
                    </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label class="form-label">Fax Number</label>
                    <input type="text" class="form-control" id="fax_number" name="fax_number" maxlength="50" value="{{$suppliers->fax_number}}">
                    </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label class="form-label">Mobile Phone</label>
                    <input type="text" class="form-control" id="mobile_phone" name="mobile_phone" maxlength="15" value="{{$suppliers->mobile_phone}}">
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group mb-0">
                    <label class="form-label">Email Address</label>
                    <input type="text" class="form-control" id="email" name="email" maxlength="100" value="{{$suppliers->email}}" disabled>
                    </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group mb-0">
                    <label class="form-label">Web address</label>
                    <input type="text" class="form-control" id="web_address" name="web_address" maxlength="100" value="{{$suppliers->web_address}}">
                    </div>
            </div>
        </div>
    </div>
    <div class="card-head">
        <h5 class="bright-gray mb-0">Address Details</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">Street Address</label>
                    <input type="text" class="form-control" id="street_address" name="street_address" maxlength="100" value="{{$suppliers->street_address}}">
                    </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">Suburb</label>
                    <input type="text" class="form-control" id="suburb" name="suburb" maxlength="50" value="{{$suppliers->suburb}}">
                    </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">City</label>
                    <input type="text" class="form-control" id="city" name="city" maxlength="50" value="{{$suppliers->city}}">
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">State/Region</label>
                    <input type="text" class="form-control" id="state" name="state" maxlength="50" value="{{$suppliers->state}}">
                    </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">Post Code</label>
                    <input type="text" class="form-control" id="post_code" name="post_code" maxlength="50" value="{{$suppliers->post_code}}">
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">Country</label>
                    <input type="text" class="form-control" id="country" name="country" maxlength="50" value="{{$suppliers->country}}">
                    </div>
            </div>
        </div>
        <div class="col-lg-12 text-lg-end mt-4">
            <button type="button" class="btn btn-light me-2" onclick="window.location='{{ url("suppliers") }}'">Discard</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </div>
    </form>
</div>
@stop
@section('script')
<script>
$(document).ready(function() {
    $("#edit_suppliers").validate({
        rules: {
            business_name: {
                required: true,
            },
            contact_first_name:{
                required: true,
            },
            contact_last_name:{
                required: true,
            },
            home_phone:{
                required: true,
            },
            // email:{
            //     required: true,
            //     email: true
            // },
            street_address:{
                required: true,
            },
            suburb:{
                required: true,
            },
            city:{
                required:true,
            },
            state:{
                required:true
            },
            post_code:{
                required:true
            },
            country:{
                required:true
            }
        }
    });
    $(document).on('submit','#edit_suppliers',function(e){
		e.preventDefault();
        var id=$('#id').val();
		var valid= $("#edit_suppliers").validate();
			if(valid.errorList.length == 0){
			var data = $('#edit_suppliers').serialize() ;

            // var data = new FormData(this);
			submitEditSupplierForm(data,id);
		}
	});
    function submitEditSupplierForm(data,id){
        
		$.ajax({
			headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: id,
			type: "PUT",
			data: data,
			success: function(response) {
				
				// Show a Sweet Alert message after the form is submitted.
				if (response.success) {
					
					Swal.fire({
						title: "Supplier!",
						text: "Supplier edited successfully.",
						icon: "success",
					}).then((result) => {
                        window.location = "{{url('suppliers')}}"//'/player_detail?username=' + name;
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
	}
});
</script>
@endsection