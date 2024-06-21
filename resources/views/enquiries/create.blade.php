@extends('layouts/sidebar')
@section('content')
<div class="card">
                        
    <div class="card-head">
        <h4 class="small-title mb-5">Add Enquiry</h4>
        <h5 class="bright-gray mb-0">Details</h5>
    </div>
    <form id="create_enquiry" name="create_enquiry" class="form" enctype="multipart/form-data">
    @csrf
    <div class="card-body">
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstname" name="firstname" maxlength="50">
                    </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" maxlength="50">
                    </div>
            </div>
            <div class="col-lg-3">
                <label class="form-label">Gender</label>
                <div class="toggle form-group">
                    <input type="radio" name="gender" value="Male" id="yes" checked="checked">
                    <label for="yes">Male <i class="ico-tick"></i></label>
                    <input type="radio" name="gender" value="Female" id="no">
                    <label for="no">Female <i class="ico-tick"></i></label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">Email  Address</label>
                    <input type="text" class="form-control" id="email" name="email" maxlength="100">
                    </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">Phone </label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" maxlength="15">
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">Enquiry Date</label>
                    <input type="date" class="form-control" id="enquiry_date" name="enquiry_date">
                    </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">Appointment Date </label>
                    <input type="date" class="form-control" id="appointment_date" name="appointment_date">
                    </div>
            </div>
        </div>
        <div class="row">
        <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">How Did You Hear About Us?</label>
                    <select class="form-select form-control" name="about_us">
                    <option selected value=""> -- select an option -- </option>
                        <option>Search Engine</option>
                        <option>Referral</option>
                        <option>Social Media</option>
                        <option>Other Website</option>
                        <option>Banners</option>
                        <option>Other</option>
                    </select>
                    </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group mb-0">
                    <label class="form-label">Enquiry Source </label>
                    <select class="form-select form-control" name="enquiry_source">
                        <option selected value=""> -- select an option -- </option>
                        <option>Social Media</option>
                        <option>Website</option>
                        <option>Email</option>
                        <option>Phone</option>
                        <option>Walk In</option>
                        <option>Other</option>
                    </select>
                    </div>
            </div>
        </div>
        <div class="row">
        <div class="col-lg-4">
            <div class="form-group mb-0">
                    <label class="form-label">Enquiry Status</label>
                    <select class="form-select form-control" name="enquiry_status" id="enquiry_status">
                        <option selected value=""> -- select an option -- </option>
                        <option>New Enquiry</option>
                        <option>Follow Up Done</option>
                        <option>First Call Done</option>
                        <option>Client Contacted</option>
                        <option>No Response</option>
                        <option>Not Intrested</option>
                    </select>
                    </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group mb-0">
                    <label class="form-label">Location </label>
                    <select class="form-select form-control" name="location_name">
                        <option selected value=""> -- select an option -- </option>
                        @if(count($location)>0)
                        @foreach($location as $loc)
                            <option value="{{$loc->id}}"> {{$loc->location_name}} </option>
                        @endforeach
                        @endif
                    </select>
                    </div>
            </div>
        </div>
    </div>
    <div class="card-head">
        <h5 class="bright-gray mb-0">Select Treatment(s)</h5>
    </div>
    <div class="card-body">
        
        <h6 class="bright-gray mb-4">Cosmetics Injectables</h6>
        <div class="form-group check-gap30 mb-5">
            <label class="cst-check"><input type="checkbox" name="cosmetic_injectables[]" value="Anti Wrinkle" checked><span class="checkmark me-2"></span>Anti Wrinkle</label>
            <label class="cst-check"><input type="checkbox" name="cosmetic_injectables[]" value="Dermal Filters"><span class="checkmark me-2"></span>Dermal Filters</label>
            <label class="cst-check"><input type="checkbox" name="cosmetic_injectables[]" value="Fat Dissolving"><span class="checkmark me-2"></span>Fat Dissolving</label>
            <label class="cst-check"><input type="checkbox" name="cosmetic_injectables[]" value="Thread Lift"><span class="checkmark me-2"></span>Thread Lift</label>
            <label class="cst-check"><input type="checkbox" name="cosmetic_injectables[]" value="V2 Beauty Booster"><span class="checkmark me-2"></span>V2 Beauty Booster </label>
            <label class="cst-check"><input type="checkbox" name="cosmetic_injectables[]" value="IV-Vitamin Drip Therapy"><span class="checkmark me-2"></span>IV-Vitamin Drip Therapy</label>
        </div>

        <h6 class="bright-gray mb-4">Skin</h6>
        <div class="form-group check-gap30 mb-5">
            <label class="cst-check"><input type="checkbox" name="skin[]" value="DMK Enzyme Therapy" checked><span class="checkmark me-2"></span>DMK Enzyme Therapy</label>
            <label class="cst-check"><input type="checkbox" name="skin[]" value="BBL Hero Skin Type"><span class="checkmark me-2"></span>BBL Hero Skin Type</label>
            <label class="cst-check"><input type="checkbox" name="skin[]" value="TIXEL"><span class="checkmark me-2"></span>TIXEL</label>
            <label class="cst-check"><input type="checkbox" name="skin[]" value="LED"><span class="checkmark me-2"></span>LED</label>
            <label class="cst-check"><input type="checkbox" name="skin[]" value="SircuitSkin Advanced Peels"><span class="checkmark me-2"></span>SircuitSkin Advanced Peels</label>
            <label class="cst-check"><input type="checkbox" name="skin[]" value="Alex Cosmetics Herbal Peels"><span class="checkmark me-2"></span>Alex Cosmetics Herbal Peels</label>
            <label class="cst-check"><input type="checkbox" name="skin[]" value="HALO Glow Hybrid Fractional Laser"><span class="checkmark me-2"></span>HALO Glow Hybrid Fractional Laser</label>
            <label class="cst-check"><input type="checkbox" name="skin[]" value="VIVACE"><span class="checkmark me-2"></span>VIVACE</label>
            <label class="cst-check"><input type="checkbox" name="skin[]" value="BBL Hero Forever Young"><span class="checkmark me-2"></span>BBL Hero Forever Young</label>
            <label class="cst-check"><input type="checkbox" name="skin[]" value="HIFU"><span class="checkmark me-2"></span>HIFU</label>
            <label class="cst-check"><input type="checkbox" name="skin[]" value="Pico Laser"><span class="checkmark me-2"></span>Pico Laser</label>
            <label class="cst-check"><input type="checkbox" name="skin[]" value="LED"><span class="checkmark me-2"></span>LED</label>
        </div>

        <h6 class="bright-gray mb-4">Surgical</h6>
        <div class="form-group check-gap30 mb-5">
            <label class="cst-check"><input type="checkbox" name="surgical[]" value="Skin Cancer Removal" checked><span class="checkmark me-2"></span>Skin Cancer Removal </label>
            <label class="cst-check"><input type="checkbox" name="surgical[]" value="Mole Removal"><span class="checkmark me-2"></span>Mole Removal</label>
        </div>


        <h6 class="bright-gray mb-4">Body</h6>
        <div class="form-group check-gap30 mb-5">
            <label class="cst-check"><input type="checkbox" name="body[]" value="Miradry" checked><span class="checkmark me-2"></span>Miradry</label>
            <label class="cst-check"><input type="checkbox" name="body[]" value="Cooltech Fat Freezing"><span class="checkmark me-2"></span>Cooltech Fat Freezing</label>
            <label class="cst-check"><input type="checkbox" name="body[]" value="BBL Hero Forever Body"><span class="checkmark me-2"></span>BBL Hero Forever Body</label>
            <label class="cst-check"><input type="checkbox" name="body[]" value="BBL Hero"><span class="checkmark me-2"></span>BBL Hero</label>
            <label class="cst-check"><input type="checkbox" name="body[]" value="BBL Forever Bair/Hair Removal"><span class="checkmark me-2"></span>BBL Forever Bair/Hair Removal</label>
            <label class="cst-check"><input type="checkbox" name="body[]" value="ClearV Nd Yag Laser"><span class="checkmark me-2"></span>ClearV Nd Yag Laser</label>
            <label class="cst-check"><input type="checkbox" name="body[]" value="Empower RF Womens Health"><span class="checkmark me-2"></span>Empower RF Women's Health</label>
        </div>

        <div class="form-group">
            <label class="form-label">Comments</label>
            <textarea class="form-control" rows="5" name="comments" maxlength="100"></textarea>
        </div>

        <div class="col-lg-12 text-lg-end mt-4">
            <button type="button" class="btn btn-light me-2" onclick="window.location='{{ url("enquiries") }}'">Discard</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </div>
    </form>
</div>
@endsection
@section('script')
<script>
$(document).ready(function() {
    //min enquiry date select
    var now = new Date(),
    minDate = now.toISOString().substring(0,10);

    $('#enquiry_date').prop('min', minDate);

    //min appointment date select
    minDate = now.toISOString().substring(0,10);

    $('#appointment_date').prop('min', minDate);
    
    $("#create_enquiry").validate({
        rules: {
            firstname: {
                required: true,
            },
            lastname:{
                required: true,
            },
            email:{
                required: true,
                email: true
            },
            phone_number:{
                required: true,
            },
            enquiry_date:{
                required: true,
            },
            appointment_date:{
                required:true,
            },
            about_us:{
                required:true
            },
            enquiry_source:{
                required:true
            },
            enquiry_status:{
                required:true
            }
        }
    });
    $(document).on('submit','#create_enquiry',function(e){
		e.preventDefault();
		var valid= $("#create_enquiry").validate();
			if(valid.errorList.length == 0){
			var data = $('#create_enquiry').serialize() ;

            // var data = new FormData(this);
			submitCreateUserForm(data);
		}
	});
    function submitCreateUserForm(data){
        
		$.ajax({
			headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: "{{route('enquiries.store')}}",
            type: "post",
            // contentType: 'multipart/form-data',
            // cache: false,
            // contentType: false,
            // processData: false,
			data: data,
			success: function(response) {
				
				// Show a Sweet Alert message after the form is submitted.
				if (response.success) {
					
					Swal.fire({
						title: "Enquiry!",
						text: "Enquiry created successfully.",
						icon: "success",
					}).then((result) => {
                        window.location = "{{url('enquiries')}}"//'/player_detail?username=' + name;
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