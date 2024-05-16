@extends('layouts.sidebar')
@section('title', 'Add Service')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />

<div class="card">
    <div class="card-head">
        <div class="toolbar mb-5">
            <div class="tool-left"><h4 class="small-title mb-0">Add Services</h4></div>
            <div class="tool-right"><a href="{{URL::to('services')}}" class="btn btn-primary btn-md">Back to Services</a></div></div>
        
        <h5 class="bright-gray mb-0">New service</h5>
    </div>
    <div class="card-body">
        <form id="create_service" name="create_service" class="form" enctype="multipart/form-data">
        @csrf
        <div class="row mb-4">
            <div class="col-lg-7">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Service name </label>
                            <input type="text" class="form-control" name="service_name" id="service_name" maxlength="50">
                            </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Parent Category </label>
                            <select class="form-select form-control" name="parent_category" id="parent_category">
                                <option selected="" value=""> -- select an option -- </option>
                                @if(count($list_parent_cat)>0)
                                    @foreach($list_parent_cat as $cats)
                                        @if($cats->parent_category != '0')
                                            <option value="{{$cats->id}}">&nbsp;&nbsp;{{$cats->category_name}}</option>
                                        @else
                                            <option value="{{$cats->id}}">{{$cats->category_name}}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Gender Specific </label>
                            <select class="form-select form-control" name="gender_specific" id="gender_specific">
                                <option selected="" value=""> -- select an option -- </option>
                                <option>Anyone</option>
                                <option>Only females</option>
                                <option>Only males</option>
                            </select>
                            </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Code <span class="d-grey">(for adding to invoice)</span></label>
                            <input type="text" class="form-control" name="code" id="code">
                            </div>
                    </div>
                </div>
                
                <div class="bor-box pd-20">
                    <div class="form-group">
                        <input type="hidden" name="appear_on_calendar" value="0" id="appear_on_calendar_hidden"> 
                        <label class="cst-check d-flex align-items-center"><input type="checkbox" checked value="1" class="appear_on_calendar" name="appear_on_calendar" id="appear_on_calendar_checkbox"><span class="checkmark me-2"></span>Appear on Calendar</label>
                    </div>
                    <div class="row main_appear_on_calendar">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label">Duration</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="0" id="duration" name="duration" maxlength="3">
                                    <span class="input-group-text font-12 duration_error">Mins</span>
                                    </div>
                                </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label">Processing Time</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="0" id="processing_time" name="processing_time" maxlength="3">
                                    <span class="input-group-text font-12">Mins</span>
                                    </div>
                                </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label">Fast Duration</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="0" id="fast_duration" name="fast_duration" maxlength="3">
                                    <span class="input-group-text font-12">Mins</span>
                                    </div>
                                </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label">Slow Duration</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="0" id="slow_duration" name="slow_duration" maxlength="3">
                                    <span class="input-group-text font-12">Mins</span>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="row main_appear_on_calendar">
                        <div class="col-lg-7">
                            <div class="form-group">
                                <label class="form-label">Usual Next Service </label>
                                <select class="form-select form-control" name="usual_next_service">
                                    <option selected="" value=""> -- select an option -- </option>
                                    @if(count($services)>0)
                                        @foreach($services as $ser)
                                            <option value="{{$ser->id}}">{{$ser->service_name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                </div>
                        </div>
                    </div>
                    <div class="row main_appear_on_calendar">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <input type="hidden" name="dont_include_reports" value="0">
                                <label class="cst-check d-flex align-items-center"><input type="checkbox" name="dont_include_reports" value="1"><span class="checkmark me-2"></span>Don't include in reports</label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <input type="hidden" name="technical_service" value="0">
                                <label class="cst-check d-flex align-items-center"><input type="checkbox" value="1" name="technical_service"><span class="checkmark me-2"></span>Technical service</label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <input type="hidden" name="available_on_online_booking" value="0">
                                <label class="cst-check d-flex align-items-center"><input type="checkbox" value="1" name="available_on_online_booking" checked><span class="checkmark me-2"></span>Available in Online Booking</label>
                            </div>
                        </div>
                    </div>
                    <div class="row main_appear_on_calendar">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="hidden" name="require_a_room" value="0">
                                <label class="cst-check d-flex align-items-center"><input type="checkbox" value="1" name="require_a_room"><span class="checkmark me-2"></span>Requires a room/equipment</label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="hidden" name="unpaid_time" value="0">
                                <label class="cst-check d-flex align-items-center"><input type="checkbox" value="1" name="unpaid_time"><span class="checkmark me-2"></span>Unpaid time</label>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row main_appear_on_calendar">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <input type="hidden" name="require_a_follow_on_service" value="0">
                                <label class="cst-check d-flex align-items-center"><input type="checkbox" value="1" name="require_a_follow_on_service"><span class="checkmark me-2"></span>Requires a follow-on service</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group mb-0">
                                <label class="form-label">Follow on services</label>
                                    <select class="form-select form-control" id="choices-multiple-remove-button" name="follow_on_services[]" placeholder="-- select an option --" multiple>
                                        @if(count($services)>0)
                                            @foreach($services as $ser)
                                                <option value="{{$ser->id}}">{{$ser->service_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                            </div>
                        </div>
                    </div>

                    
                </div>

            </div>
            <div class="col-lg-5">
                <div class="d-flex justify-content-between mb-2">
                    <label class="form-label mb-0">Availability</label>  
                    <div class="small-tool">Select:   <a href="javascript:void(0);" class="me-2 ms-2 btn-link select_all">All</a>  |   <a href="javascript:void(0);" class="ms-2 btn-link select_none">None</a></div>
                </div>
                <div class="bor-box pd-20">
                    @if(count($locations)>0)
                    <ul class="list-group list-group-flush ad-flus">
                        @foreach($locations as $loc)
                            <li class="list-group-item"><label class="cst-check d-flex align-items-center"><input type="checkbox" value="{{$loc->id}}" name="locations[]" id="locations" class="locations" checked><span class="checkmark me-2"></span>{{$loc->location_name}}</label></li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>

            <div class="col-lg-5">
                <div class="d-flex justify-content-between mb-2">
                    <label class="form-label mb-0">Select Forms</label>
                </div>
                <div class="bor-box pd-20 scroll-y">
                    @if (count($forms) > 0)
                        <ul class="list-group list-group-flush ad-flus">
                            @foreach ($forms as $loc)
                                <li class="list-group-item">
                                    <label class="cst-check d-flex align-items-center">
                                        <input type="checkbox" value="{{ $loc->id }}" name="forms[]" id="forms" class="forms">
                                        <span class="checkmark me-2"></span>
                                        {{ $loc->title }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label class="form-label">Standard price</label>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="0" name="standard_price" maxlength="5">
                    <span class="input-group-text"><span class="ico-dollar fs-4"></span></span>
                    </div>
                    <span class="form-text">GST Include</span>
                </div>
        </div>
        <div class="col-lg-12 text-lg-end mt-4">
            <button type="button" class="btn btn-light me-2" onclick="window.location='{{ url("services") }}'">Discard</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
        </form>
    </div>

</div>
@endsection
@section('script')
<script>
$(document).ready(function() {
    $('.appear_on_calendar').click(function(){
        
        if (!$(this).is(':checked')) {
            $('.main_appear_on_calendar').hide();
        }
        else{
            $('.main_appear_on_calendar').show();
        }
    })
    
    var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
        removeItemButton: true,
        // searchResultLimit:5,
        // renderChoiceLimit:5
        });
    $('.select_none').click(function(){
        
        $("input[name='locations[]']:checkbox").prop('checked',false);
    })
    $('.select_all').click(function(){
        
        $("input[name='locations[]']:checkbox").prop('checked',true);
    })
    $("#create_service").validate({
        rules: {
            service_name: {
                required: true,
                remote: {
                    url: "../services/checkServiceName", // Replace with the actual URL to check service_name uniqueness
                    type: "post", // Use "post" method for the AJAX request
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        type:'create',
                        service_name: function () {
                            return $("#service_name").val(); // Pass the value of the service_name field to the server
                        }
                    },
                    dataFilter: function (data) {
                        var json = $.parseJSON(data);
                        var chk = json.exists ? '"Service already exist!"' : '"true"';
                        return chk;
                    }
                }
            },
            parent_category:{
                required: true,
            },
            gender_specific:{
                required: true,
            },
            duration:{
                required: true,
            }
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "duration") {
                error.insertAfter(".duration_error");
            } else {
                error.insertAfter(element);
            }
        }
    });
});

$(document).on('submit','#create_service',function(e){
    e.preventDefault();
    var valid= $("#create_service").validate();
        if(valid.errorList.length == 0){
        // var data = $('#create_user').serialize() ;

        var data = new FormData(this);
        submitCreateServiceForm(data);
    }
});
function submitCreateServiceForm(data){
    
    $.ajax({
        headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{route('services.store')}}",
        type: "post",
        // contentType: 'multipart/form-data',
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        success: function(response) {
            
            // Show a Sweet Alert message after the form is submitted.
            if (response.success) {
                
                Swal.fire({
                    title: "Service!",
                    text: "Service created successfully.",
                    type: "success",
                }).then((result) => {
                    window.location = "{{url('services')}}"//'/player_detail?username=' + name;
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