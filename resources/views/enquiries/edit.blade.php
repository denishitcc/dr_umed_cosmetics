@extends('layouts/sidebar')
@section('content')
<div class="card">
                        
    <div class="card-head">
        <h4 class="small-title mb-5">Edit Enquiry</h4>
        <h5 class="bright-gray mb-0">Details</h5>
    </div>
    <form id="edit_enquiry" name="edit_enquiry" class="form" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id" value="{{$enquiries->id}}">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstname" name="firstname" maxlength="50" value="{{$enquiries->firstname}}">
                    </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" maxlength="50" value="{{$enquiries->lastname}}">
                    </div>
            </div>
            <div class="col-lg-3">
                <label class="form-label">Gender</label>
                <div class="toggle form-group">
                        <input type="radio" name="gender" value="Male" {{ ($enquiries->gender=="Male")? "checked" : "" }}  id="male" checked="checked" />
                        <label for="male">Male <i class="ico-tick"></i></label>
                        <input type="radio" name="gender" value="Female" {{ ($enquiries->gender=="Female")? "checked" : "" }}  id="female" />
                        <label for="female">Female <i class="ico-tick"></i></label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="text" class="form-control" id="email" name="email" maxlength="100" value="{{$enquiries->email}}" disabled>
                    </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">Phone </label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" maxlength="15" value="{{$enquiries->phone_number}}">
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">Enquiry Date</label>
                    <input type="date" class="form-control" id="enquiry_date" name="enquiry_date" value="{{$enquiries->enquiry_date}}">
                    </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">Appointment Date </label>
                    <input type="date" class="form-control" id="appointment_date" name="appointment_date" value="{{$enquiries->appointment_date}}">
                    </div>
            </div>
        </div>
        <div class="row">
        <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">How Did You Hear About Us?</label>
                    <select class="form-select form-control" name="about_us">
                    <option selected value=""> -- select an option -- </option>
                        <option value="Search Engine" {{ ($enquiries->about_us == "Search Engine")? "selected" : "" }} >Search Engine</option>
                        <option value="Referral" {{ ($enquiries->about_us == "Referral")? "selected" : "" }} >Referral</option>
                        <option value="Social Media" {{ ($enquiries->about_us == "Social Media")? "selected" : "" }} >Social Media</option>
                        <option value="Other Website" {{ ($enquiries->about_us == "Other Website")? "selected" : "" }} >Other Website</option>
                        <option value="Banners" {{ ($enquiries->about_us == "Banners")? "selected" : "" }} >Banners</option>
                        <option value="Other" {{ ($enquiries->about_us == "Other")? "selected" : "" }} >Other</option>
                    </select>
                    </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group mb-0">
                    <label class="form-label">Enquiry Source </label>
                    <select class="form-select form-control" name="enquiry_source">
                        <option selected value=""> -- select an option -- </option>
                        <option value="Social Media" {{ ($enquiries->enquiry_source == "Social Media")? "selected" : "" }} >Social Media</option>
                        <option value="Website" {{ ($enquiries->enquiry_source == "Website")? "selected" : "" }} >Website</option>
                        <option value="Email" {{ ($enquiries->enquiry_source == "Email")? "selected" : "" }} >Email</option>
                        <option value="Phone" {{ ($enquiries->enquiry_source == "Phone")? "selected" : "" }} >Phone</option>
                        <option value="Walk In" {{ ($enquiries->enquiry_source == "Walk In")? "selected" : "" }} >Walk In</option>
                        <option value="Other" {{ ($enquiries->enquiry_source == "Other")? "selected" : "" }} >Other</option>
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
                        <option value="Follow Up Done" {{ ($enquiries->enquiry_status == "Follow Up Done")? "selected" : "" }} >Follow Up Done</option>
                        <option value="First Call Done" {{ ($enquiries->enquiry_status == "First Call Done")? "selected" : "" }} >First Call Done</option>
                        <option value="Client Contacted" {{ ($enquiries->enquiry_status == "Client Contacted")? "selected" : "" }} >Client Contacted</option>
                        <option value="No Response" {{ ($enquiries->enquiry_status == "No Response")? "selected" : "" }} >No Response</option>
                        <option value="Not Intrested" {{ ($enquiries->enquiry_status == "Not Intrested")? "selected" : "" }} >Not Intrested</option>
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
                            <option value="{{ $loc->location_name }}" {{ ( $loc->location_name == $enquiries->location_name) ? 'selected' : '' }}> {{ $loc->location_name }} </option>
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
            <?php
            $cosmetic = array_map('trim', explode(",", $enquiries->cosmetic_injectables));
            ?>
            <label class="cst-check"><input type="checkbox" name="cosmetic_injectables[]" value="Anti Wrinkle" {{ (in_array('Anti Wrinkle', $cosmetic)?'checked="checked"':NULL)}}><span class="checkmark me-2"></span>Anti Wrinkle</label>
            <label class="cst-check"><input type="checkbox" name="cosmetic_injectables[]" value="Dermal Filters" {{ (in_array('Dermal Filters', $cosmetic)?'checked="checked"':NULL)}}><span class="checkmark me-2"></span>Dermal Filters</label>
            <label class="cst-check"><input type="checkbox" name="cosmetic_injectables[]" value="Fat Dissolving" {{ (in_array('Fat Dissolving', $cosmetic)?'checked="checked"':NULL)}}><span class="checkmark me-2"></span>Fat Dissolving</label>
            <label class="cst-check"><input type="checkbox" name="cosmetic_injectables[]" value="Thread Lift" {{ (in_array('Thread Lift', $cosmetic)?'checked="checked"':NULL)}}><span class="checkmark me-2"></span>Thread Lift</label>
            <label class="cst-check"><input type="checkbox" name="cosmetic_injectables[]" value="V2 Beauty Booster" {{ (in_array('V2 Beauty Booster', $cosmetic)?'checked="checked"':NULL)}}><span class="checkmark me-2"></span>V2 Beauty Booster </label>
            <label class="cst-check"><input type="checkbox" name="cosmetic_injectables[]" value="IV-Vitamin Drip Therapy" {{ (in_array('IV-Vitamin Drip Therapy', $cosmetic)?'checked="checked"':NULL)}}><span class="checkmark me-2"></span>IV-Vitamin Drip Therapy</label>
        </div>

        <h6 class="bright-gray mb-4">Skin</h6>
        <div class="form-group check-gap30 mb-5">
            <?php
            $skin = array_map('trim', explode(",", $enquiries->skin));
            ?>
            <label class="cst-check"><input type="checkbox" name="skin[]" value="DMK Enzyme Therapy" {{ (in_array('DMK Enzyme Therapy', $skin)?'checked="checked"':NULL)}}><span class="checkmark me-2"></span>DMK Enzyme Therapy</label>
            <label class="cst-check"><input type="checkbox" name="skin[]" value="BBL Hero Skin Type" {{ (in_array('BBL Hero Skin Type', $skin)?'checked="checked"':NULL)}}><span class="checkmark me-2"></span>BBL Hero Skin Type</label>
            <label class="cst-check"><input type="checkbox" name="skin[]" value="TIXEL" {{ (in_array('TIXEL', $skin)?'checked="checked"':NULL)}}><span class="checkmark me-2"></span>TIXEL</label>
            <label class="cst-check"><input type="checkbox" name="skin[]" value="LED" {{ (in_array('LED', $skin)?'checked="checked"':NULL)}}><span class="checkmark me-2"></span>LED</label>
            <label class="cst-check"><input type="checkbox" name="skin[]" value="SircuitSkin Advanced Peels" {{ (in_array('SircuitSkin Advanced Peels', $skin)?'checked="checked"':NULL)}}><span class="checkmark me-2"></span>SircuitSkin Advanced Peels</label>
            <label class="cst-check"><input type="checkbox" name="skin[]" value="Alex Cosmetics Herbal Peels" {{ (in_array('Alex Cosmetics Herbal Peels', $skin)?'checked="checked"':NULL)}}><span class="checkmark me-2"></span>Alex Cosmetics Herbal Peels</label>
            <label class="cst-check"><input type="checkbox" name="skin[]" value="HALO Glow Hybrid Fractional Laser" {{ (in_array('HALO Glow Hybrid Fractional Laser', $skin)?'checked="checked"':NULL)}}><span class="checkmark me-2"></span>HALO Glow Hybrid Fractional Laser</label>
            <label class="cst-check"><input type="checkbox" name="skin[]" value="VIVACE"><span class="checkmark me-2" {{ (in_array('VIVACE', $skin)?'checked="checked"':NULL)}}></span>VIVACE</label>
            <label class="cst-check"><input type="checkbox" name="skin[]" value="BBL Hero Forever Young" {{ (in_array('BBL Hero Forever Young', $skin)?'checked="checked"':NULL)}}><span class="checkmark me-2"></span>BBL Hero Forever Young</label>
            <label class="cst-check"><input type="checkbox" name="skin[]" value="HIFU" {{ (in_array('HIFU', $skin)?'checked="checked"':NULL)}}><span class="checkmark me-2"></span>HIFU</label>
            <label class="cst-check"><input type="checkbox" name="skin[]" value="Pico Laser" {{ (in_array('Pico Laser', $skin)?'checked="checked"':NULL)}}><span class="checkmark me-2"></span>Pico Laser</label>
            <label class="cst-check"><input type="checkbox" name="skin[]" value="LED" {{ (in_array('LED', $skin)?'checked="checked"':NULL)}}><span class="checkmark me-2"></span>LED</label>
        </div>

        <h6 class="bright-gray mb-4">Surgical</h6>
        <div class="form-group check-gap30 mb-5">
            <?php
            $surgical = array_map('trim', explode(",", $enquiries->surgical));
            ?>
            <label class="cst-check"><input type="checkbox" name="surgical[]" value="Skin Cancer Removal" {{ (in_array('Skin Cancer Removal', $surgical)?'checked="checked"':NULL)}}><span class="checkmark me-2"></span>Skin Cancer Removal </label>
            <label class="cst-check"><input type="checkbox" name="surgical[]" value="Mole Removal" {{ (in_array('Mole Removal', $surgical)?'checked="checked"':NULL)}}><span class="checkmark me-2"></span>Mole Removal</label>
        </div>


        <h6 class="bright-gray mb-4">Body</h6>
        <div class="form-group check-gap30 mb-5">
            <?php
            $body = array_map('trim', explode(",", $enquiries->body));
            ?>
            <label class="cst-check"><input type="checkbox" name="body[]" value="Miradry" {{ (in_array('Miradry', $body)?'checked="checked"':NULL)}}><span class="checkmark me-2"></span>Miradry</label>
            <label class="cst-check"><input type="checkbox" name="body[]" value="Cooltech Fat Freezing" {{ (in_array('Cooltech Fat Freezing', $body)?'checked="checked"':NULL)}}><span class="checkmark me-2"></span>Cooltech Fat Freezing</label>
            <label class="cst-check"><input type="checkbox" name="body[]" value="BBL Hero Forever Body" {{ (in_array('BBL Hero Forever Body', $body)?'checked="checked"':NULL)}}><span class="checkmark me-2"></span>BBL Hero Forever Body</label>
            <label class="cst-check"><input type="checkbox" name="body[]" value="BBL Hero" {{ (in_array('BBL Hero', $body)?'checked="checked"':NULL)}}><span class="checkmark me-2"></span>BBL Hero</label>
            <label class="cst-check"><input type="checkbox" name="body[]" value="BBL Forever Bair/Hair Removal" {{ (in_array('BBL Forever Bair/Hair Removal', $body)?'checked="checked"':NULL)}}><span class="checkmark me-2"></span>BBL Forever Bair/Hair Removal</label>
            <label class="cst-check"><input type="checkbox" name="body[]" value="ClearV Nd Yag Laser" {{ (in_array('Mole Removal', $body)?'checked="checked"':NULL)}}><span class="checkmark me-2"></span>ClearV Nd Yag Laser</label>
            <label class="cst-check"><input type="checkbox" name="body[]" value="Empower RF Womens Health" {{ (in_array('Empower RF Womens Health', $body)?'checked="checked"':NULL)}}><span class="checkmark me-2"></span>Empower RF Women's Health</label>
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

    $("#edit_enquiry").validate({
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
    $(document).on('submit','#edit_enquiry',function(e){debugger;
		e.preventDefault();
		var valid= $("#edit_enquiry").validate();
			if(valid.errorList.length == 0){
			var data = $('#edit_enquiry').serialize() ;

            // var data = new FormData(this);
			submitEditEnquiryform(data);
		}
	});
    function submitEditEnquiryform(data){
        debugger;
		$.ajax({
			headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: id,
            type: "PUT",
            // contentType: 'multipart/form-data',
            // cache: false,
            // contentType: false,
            // processData: false,
			data: data,
			success: function(response) {
				debugger;
				// Show a Sweet Alert message after the form is submitted.
				if (response.success) {
					
					Swal.fire({
						title: "Enquiry!",
						text: "Enquiry Updated successfully.",
						type: "success",
					}).then((result) => {
                        window.location = "{{url('enquiries')}}"//'/player_detail?username=' + name;
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
});
</script>
@endsection