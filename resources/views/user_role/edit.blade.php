@extends('layouts/sidebar')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<!-- <main> -->
    <div class="card">
        
        <div class="card-head">
            <h4 class="small-title mb-0">Edit User Role</h4>
        </div>
        <!-- <form class="form"  action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
        @csrf -->
        <form id="edit_user_role" name="edit_user" class="form">
        @csrf
        <input type="hidden" name="id" id="id" value="{{$users->id}}">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="form-label">Role Name</label>
                        <input type="text" class="form-control" name="role_name" id="role_name" maxlength="50" value="{{$users->role_name}}">
                </div>
            </div>
            <div class="col-lg-12 text-lg-end mt-4">
                <button type="button" class="btn btn-light me-2" onclick="window.location='{{ url("users-roles") }}'">Discard</button>
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
		$("#edit_user_role").validate({
            rules: {
                role_name: {
                    required: true,
                }
            }
        });
    });
    $(document).on('submit','#edit_user_role',function(e){
		e.preventDefault();
		var valid= $("#edit_user_role").validate();
			if(valid.errorList.length == 0){
			var data = $('#edit_user_role').serialize() ;
			submitEditUserRoleForm(data);
		}
	});
    function submitEditUserRoleForm(data){
        
		$.ajax({
			headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			// url: "{{route('users.store')}}",
            url: id,
			type: "PUT",
            // contentType: 'multipart/form-data',
            // cache: false,
            // contentType: false,
            // processData: false,
			data: data,
			success: function(response) {
				
				// Show a Sweet Alert message after the form is submitted.
				if (response.success) {
					
					Swal.fire({
						title: "User!",
						text: "Your User Role updated successfully.",
						icon: "success",
					}).then((result) => {
                        window.location = "{{url('users-roles')}}"//'/player_detail?username=' + name;
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
</script> 
@endsection