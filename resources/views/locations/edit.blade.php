@extends('layouts/sidebar')
@section('content')
    <!-- Page content-->
    <main>
        <div class="card">
            
            <div class="card-head">
                <h4 class="small-title mb-5">Edit Location</h4>
                <h5 class="d-grey mb-0">Details</h5>
            </div>
            <form id="edit_location" name="edit_location" class="form">
            @csrf
            <input type="hidden" name="id" id="id" value="{{$locations->id}}">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Location Name </label>
                            <input type="text" class="form-control" id="location_name" name="location_name" value="{{$locations->location_name}}">
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group mb-0">
                            <label class="form-label">Phone </label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{$locations->phone}}">
                            </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group mb-0">
                            <label class="form-label">Email  Address</label>
                            <input type="text" class="form-control" id="email_address" name="email_address" value="{{$locations->email}}">
                            </div>
                    </div>
                </div>
            </div>
            <div class="card-head">
                <h5 class="d-grey mb-0">Address Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Street Address</label>
                            <input type="text" class="form-control" id="placeInput" name="street_address">
                            </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Suburb</label>
                            <input type="text" class="form-control" id="suburb" name="suburb">
                            </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city">
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">State/Region</label>
                            <input type="text" class="form-control" id="state" name="state">
                            </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Post Code</label>
                            <input type="text" class="form-control" id="postcode" name="postcode">
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Latitudes</label>
                            <input type="text" class="form-control" id="latitudes" name="latitudes">
                            </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Longitudes</label>
                            <input type="text" class="form-control" id="longitudes" name="longitudes">
                            </div>
                    </div>
                </div>

                <div class="map">
                    <img src="{{ asset('img/demo-map.jpg') }}" alt="">
                </div>
    
                <h5 class="small-title mb-4 mt-3">Opening Hours</h5>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="table-responsive">
                                <table class="table table-relax align-middle table-hover">
                                @foreach($working_hours_location as $works)
                                <tr class="rows_data">
                                    <td>
                                        <label class="cst-checks"><input type="checkbox" name="days[{{$works->day}}][check_status]" value="{{$works->day}}" {{$works->day==$works->day && $works->day_status=='Open' ? 'checked' : ''}} class="checkbox"><span class="checkmark"></span></label>
                                    </td>
                                    <td>Open</td>
                                    <td>{{$works->day}}</td>
                                    <td class="from_dates">
                                        <input type="hidden" name="days[{{$works->day}}][check_days]" value="{{$works->day}}">
                                        <select class="form-select form-control" id="start_time" name="days[{{$works->day}}][start_time]">
                                            <option value="12am" {{$works->start_time=='12am'?'selected':''}}>12am</option>
                                            <option value="30am" {{$works->start_time=='12:30am'?'selected':''}}>12:30am</option>
                                            <option value="1am" {{$works->start_time=='1am'?'selected':''}}>1am</option>
                                            <option value="30am" {{$works->start_time=='1:30am'?'selected':''}}>1:30am</option>
                                            <option value="2am" {{$works->start_time=='2am'?'selected':''}}>2am</option>
                                            <option value="2:30am" {{$works->start_time=='2:30am'?'selected':''}}>2:30am</option>
                                            <option value="3am" {{$works->start_time=='3am'?'selected':''}}>3am</option>
                                            <option value="3:30am" {{$works->start_time=='3:30am'?'selected':''}}>3:30am</option>
                                            <option value="4am" {{$works->start_time=='4am'?'selected':''}}>4am</option>
                                            <option value="4:30am" {{$works->start_time=='4:30am'?'selected':''}}>4:30am</option>
                                            <option value="5am" {{$works->start_time=='5am'?'selected':''}}>5am</option>
                                            <option value="5:30am" {{$works->start_time=='5:30am'?'selected':''}}>5:30am</option>
                                            <option value="6am" {{$works->start_time=='6am'?'selected':''}}>6am</option>
                                            <option value="6:30am" {{$works->start_time=='6:30am'?'selected':''}}>6:30am</option>
                                            <option value="7am" {{$works->start_time=='7am'?'selected':''}}>7am</option>
                                            <option value="7:30am" {{$works->start_time=='7:30am'?'selected':''}}>7:30am</option>
                                            <option value="8am" {{$works->start_time=='8am'?'selected':''}}>8am</option>
                                            <option value="8:30am" {{$works->start_time=='8:30am'?'selected':''}}>8:30am</option>
                                            <option value="9am" {{$works->start_time=='9am'?'selected':''}}>9am</option>
                                            <option value="9:30am" {{$works->start_time=='9:30am'?'selected':''}}>9:30am</option>
                                            <option value="10am" {{$works->start_time=='10am'?'selected':''}}>10am</option>
                                            <option value="10:30am" {{$works->start_time=='10:30am'?'selected':''}}>10:30am</option>
                                            <option value="11am" {{$works->start_time=='11am'?'selected':''}}>11am</option>
                                            <option value="11:30am" {{$works->start_time=='11:30am'?'selected':''}}>11:30am</option>
                                            <option value="12pm" {{$works->start_time=='12pm'?'selected':''}}>12pm</option>
                                            <option value="12:30pm" {{$works->start_time=='12:30pm'?'selected':''}}>12:30pm</option>
                                            <option value="1pm" {{$works->start_time=='1pm'?'selected':''}}>1pm</option>
                                            <option value="1:30pm" {{$works->start_time=='1:30pm'?'selected':''}}>1:30pm</option>
                                            <option value="2pm" {{$works->start_time=='2pm'?'selected':''}}>2pm</option>
                                            <option value="2:30pm" {{$works->start_time=='2:30pm'?'selected':''}}>2:30pm</option>
                                            <option value="3pm" {{$works->start_time=='3pm'?'selected':''}}>3pm</option>
                                            <option value="3:30pm" {{$works->start_time=='3:30pm'?'selected':''}}>3:30pm</option>
                                            <option value="4pm" {{$works->start_time=='4pm'?'selected':''}}>4pm</option>
                                            <option value="4:30pm" {{$works->start_time=='4:30pm'?'selected':''}}>4:30pm</option>
                                            <option value="5pm" {{$works->start_time=='5pm'?'selected':''}}>5pm</option>
                                            <option value="5:30pm" {{$works->start_time=='5:30pm'?'selected':''}}>5:30pm</option>
                                            <option value="6pm" {{$works->start_time=='6pm'?'selected':''}}>6pm</option>
                                            <option value="6:30pm" {{$works->start_time=='6:30pm'?'selected':''}}>6:30pm</option>
                                            <option value="7pm" {{$works->start_time=='7pm'?'selected':''}}>7pm</option>
                                            <option value="7:30pm" {{$works->start_time=='7:30pm'?'selected':''}}>7:30pm</option>
                                            <option value="8pm" {{$works->start_time=='8pm'?'selected':''}}>8pm</option>
                                            <option value="8:30pm" {{$works->start_time=='8:30pm'?'selected':''}}>8:30pm</option>
                                            <option value="9pm" {{$works->start_time=='9pm'?'selected':''}}>9pm</option>
                                            <option value="9:30pm" {{$works->start_time=='9:30pm'?'selected':''}}>9:30pm</option>
                                            <option value="10pm" {{$works->start_time=='10pm'?'selected':''}}>10pm</option>
                                            <option value="10:30pm" {{$works->start_time=='10:30pm'?'selected':''}}>10:30pm</option>
                                            <option value="11pm" {{$works->start_time=='11pm'?'selected':''}}>11pm</option>
                                            <option value="11:30pm" {{$works->start_time=='11:30pm'?'selected':''}}>11:30pm</option>
                                        </select>
                                    </td>
                                    <td class="text-center to_text">To</td>
                                    <td class="to_dates">
                                        <select class="form-select form-control" name="days[{{$works->day}}][to_time]">
                                        <option value="1am" {{$works->end_time=='1am'?'selected':''}}>1am</option>
                                            <option value="30am" {{$works->end_time=='1:30am'?'selected':''}}>1:30am</option>
                                            <option value="2am" {{$works->end_time=='2am'?'selected':''}}>2am</option>
                                            <option value="2:30am" {{$works->end_time=='2:30am'?'selected':''}}>2:30am</option>
                                            <option value="3am" {{$works->end_time=='3am'?'selected':''}}>3am</option>
                                            <option value="3:30am" {{$works->end_time=='3:30am'?'selected':''}}>3:30am</option>
                                            <option value="4am" {{$works->end_time=='4am'?'selected':''}}>4am</option>
                                            <option value="4:30am" {{$works->end_time=='4:30am'?'selected':''}}>4:30am</option>
                                            <option value="5am" {{$works->end_time=='5am'?'selected':''}}>5am</option>
                                            <option value="5:30am" {{$works->end_time=='5:30am'?'selected':''}}>5:30am</option>
                                            <option value="6am" {{$works->end_time=='6am'?'selected':''}}>6am</option>
                                            <option value="6:30am" {{$works->end_time=='6:30am'?'selected':''}}>6:30am</option>
                                            <option value="7am" {{$works->end_time=='7am'?'selected':''}}>7am</option>
                                            <option value="7:30am" {{$works->end_time=='7:30am'?'selected':''}}>7:30am</option>
                                            <option value="8am" {{$works->end_time=='8am'?'selected':''}}>8am</option>
                                            <option value="8:30am" {{$works->end_time=='8:30am'?'selected':''}}>8:30am</option>
                                            <option value="9am" {{$works->end_time=='9am'?'selected':''}}>9am</option>
                                            <option value="9:30am" {{$works->end_time=='9:30am'?'selected':''}}>9:30am</option>
                                            <option value="10am" {{$works->end_time=='10am'?'selected':''}}>10am</option>
                                            <option value="10:30am" {{$works->end_time=='10:30am'?'selected':''}}>10:30am</option>
                                            <option value="11am" {{$works->end_time=='11am'?'selected':''}}>11am</option>
                                            <option value="11:30am" {{$works->end_time=='11:30am'?'selected':''}}>11:30am</option>
                                            <option value="12pm" {{$works->end_time=='12pm'?'selected':''}}>12pm</option>
                                            <option value="12:30pm" {{$works->end_time=='12:30pm'?'selected':''}}>12:30pm</option>
                                            <option value="1pm" {{$works->end_time=='1pm'?'selected':''}}>1pm</option>
                                            <option value="1:30pm" {{$works->end_time=='1:30pm'?'selected':''}}>1:30pm</option>
                                            <option value="2pm" {{$works->end_time=='2pm'?'selected':''}}>2pm</option>
                                            <option value="2:30pm" {{$works->end_time=='2:30pm'?'selected':''}}>2:30pm</option>
                                            <option value="3pm" {{$works->end_time=='3pm'?'selected':''}}>3pm</option>
                                            <option value="3:30pm" {{$works->end_time=='3:30pm'?'selected':''}}>3:30pm</option>
                                            <option value="4pm" {{$works->end_time=='4pm'?'selected':''}}>4pm</option>
                                            <option value="4:30pm" {{$works->end_time=='4:30pm'?'selected':''}}>4:30pm</option>
                                            <option value="5pm" {{$works->end_time=='5pm'?'selected':''}}>5pm</option>
                                            <option value="5:30pm" {{$works->end_time=='5:30pm'?'selected':''}}>5:30pm</option>
                                            <option value="6pm" {{$works->end_time=='6pm'?'selected':''}}>6pm</option>
                                            <option value="6:30pm" {{$works->end_time=='6:30pm'?'selected':''}}>6:30pm</option>
                                            <option value="7pm" {{$works->end_time=='7pm'?'selected':''}}>7pm</option>
                                            <option value="7:30pm" {{$works->end_time=='7:30pm'?'selected':''}}>7:30pm</option>
                                            <option value="8pm" {{$works->end_time=='8pm'?'selected':''}}>8pm</option>
                                            <option value="8:30pm" {{$works->end_time=='8:30pm'?'selected':''}}>8:30pm</option>
                                            <option value="9pm" {{$works->end_time=='9pm'?'selected':''}}>9pm</option>
                                            <option value="9:30pm" {{$works->end_time=='9:30pm'?'selected':''}}>9:30pm</option>
                                            <option value="10pm" {{$works->end_time=='10pm'?'selected':''}}>10pm</option>
                                            <option value="10:30pm" {{$works->end_time=='10:30pm'?'selected':''}}>10:30pm</option>
                                            <option value="11pm" {{$works->end_time=='11pm'?'selected':''}}>11pm</option>
                                            <option value="11:30pm" {{$works->end_time=='11:30pm'?'selected':''}}>11:30pm</option>
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                                </table>
                            </div>
                            
                        </div>
                    </div>
                <div class="col-lg-12 text-lg-end mt-4">
                    <button type="button" class="btn btn-light me-2" onclick="window.location='{{ url("locations") }}'">Discard</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
            </form>
        </div>
</main>
@endsection
@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBR652zv0sbcR8AkNDA7PbQ3y33_yrzW0Q&libraries=places&callback=initAutocomplete" async></script>
<script>

    let autocomplete;

    /* ------------------------- Initialize Autocomplete ------------------------ */
    function initAutocomplete() {
        const input = document.getElementById("placeInput");
        const options = {
            componentRestrictions: { country: "IN" }
        }
        autocomplete = new google.maps.places.Autocomplete(input, options);
        autocomplete.addListener("place_changed", onPlaceChange)
    }

    /* --------------------------- Handle Place Change -------------------------- */
    function onPlaceChange() {
        const place = autocomplete.getPlace();
        console.log(place.formatted_address)
        console.log(place.geometry.location.lat())
        console.log(place.geometry.location.lng())
    }
    $(document).ready(function() {
        $('.rows_data').each(function(){
            debugger;
            if($(this).find(".checkbox").prop('checked') == true){
                // alert('checked');
            }
            else
            {
                $(this).find(".from_dates").hide();
                $(this).find(".to_text").hide();
                $(this).find(".to_dates").hide();
            }
        })
		$("#edit_location").validate({
            rules: {
                location_name: {
                    required: true,
                },
                phone:{
                    required: true,
                },
                email_address:{
                    required: true,
                    email: true
                },
            }
        });
        $('.checkbox').click(function() {
            debugger;
            if(this.checked) {
                $(this).parent().parent().parent().find('.from_dates').show();
                $(this).parent().parent().parent().find('.to_text').show();
                $(this).parent().parent().parent().find('.to_dates').show();
            }
            else
            {
                debugger;
                $(this).parent().parent().parent().find('.from_dates').hide();
                $(this).parent().parent().parent().find('.to_text').hide();
                $(this).parent().parent().parent().find('.to_dates').hide();
            }
            $('#textbox1').val(this.checked);        
        });
    });
    $(document).on('submit','#edit_location',function(e){debugger;
		e.preventDefault();
        var id=$('#id').val();
		var valid= $("#edit_location").validate();
			if(valid.errorList.length == 0){
			var data = $('#edit_location').serialize() ;
			submitEditLocationForm(data,id);
		}
	});
    function submitEditLocationForm(data,id){
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
						title: "Location!",
						text: "Your Location updated successfully.",
						type: "success",
					}).then((result) => {
                        window.location = "{{url('locations')}}"//'/player_detail?username=' + name;
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
