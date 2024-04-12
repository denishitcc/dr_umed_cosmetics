@extends('layouts.sidebar')
@section('title', 'Calender')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="card">
    <div class="card-head">
        <div class="toolbar">
            <div class="tool-left"><h4 class="small-title mb-0">Appointments</h4></div>
            <div class="tool-right">@include('calender.partials.appointment-dropdown')</div>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-lg-3">
                <div class="main_calendar">
                <div class="mb-3 d-flex">
                    <div class="dropdown d-flex w-100">
                        <button class="btn btn-primary btn-md me-3 w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Add
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" id="appointment" href="javascript:void(0);">New appointment</a></li>
                            <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#Walkin_Retail" id="new_walk_in_sale" href="javascript:void(0);">New walk-in sale</a></li>
                        </ul>
                    </div>
                    <!-- <a href="javascript:void(0);" class="btn btn-primary btn-md me-3 w-100" id="appointment">New Appointment</a> -->
                    <a href="javascript:void(0);" class="btn btn-wait-list waitlist_btn"><i class="ico-calendar"></i></a>
                </div>
                </div>
                <div class="form-group icon searh_data">
                    <input type="text" id="search" class="form-control " autocomplete="off" placeholder="Search for a client" onkeyup="changeInput(this.value)">
                    <i class="ico-search"></i>
                </div>
                <div id="clientDetails" class="detaild-theos pt-3"></div>
                <div id='external-events'></div>
                {{-- <div id="result" class="list-group"></div>  --}}
                <div class="client_list_box" style="display:none;">
                    <ul class="drop-list" id="result"></ul>
                </div>
                <div id="mycalendar"> </div>
                <div class="waitlist" id="waitlist" style="display:none;">
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="mb-3">Waitlist</h5>
                        <button class="btn-close close_waitlist"></button>
                    </div>
                    <div class="mb-3">
                        <label class="cst-check d-flex align-items-center"><input type="checkbox" value="" class="current_date_checked" checked><span class="checkmark me-2"></span>Filter waitlist by current calendar date</label>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Staff </label>
                        @if(count($staffs)>0)
                            <select class="form-select form-control all_staffs">
                                <option value="All staffs">All staff</option>
                                @foreach($staffs as $user_data)
                                <option value="{{$user_data->id}}">{{$user_data->first_name.' '.$user_data->last_name}}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>

                    <div class="drag-box blue mb-3">
                        <div class="head"><b>Drag and drop on</b> to a day on the appointment book
                            <i class="ico-noun-arrow"></i></div>
                    </div>
                    <ul class="drop-list light-green" id="waitlist-events">
                    @if(count($waitlist)>0)
                    @foreach($waitlist as $waitlists)
                        @foreach($waitlists->servid as $wait)
                            @php
                                $ser_ids[] = $wait;
                            @endphp
                        @endforeach
                        @php
                        $ser_ids_str = implode(',', $ser_ids); // Convert array to comma-separated string
                        @endphp
                        @foreach($waitlists->service_name as $key => $ser)
                            @php
                                $ser_names[] = $ser;
                            @endphp
                        @endforeach
                        @php
                        $ser_names_str = implode(',', $ser_names); // Convert array to comma-separated string
                        $dur_str = implode(',',$waitlists->duration);
                        @endphp
                        <li class="fc-event" data-app_id="{{$waitlists->id}}" data-client_id="{{$waitlists->client_id}}" data-category_id="{{$waitlists->category_id}}" data-duration="{{$dur_str}}" data-service_name="{{$ser_names_str}}" data-service_id="{{$ser_ids_str}}" data-client_name="{{$waitlists->firstname.' '.$waitlists->lastname}}">
                            <div class="hist-strip">
                                @php
                                    // Convert the date string to a DateTime object
                                    $date = new DateTime($waitlists->preferred_from_date ?? null);
                                    
                                    // Format the date as "D d F" (e.g., "Thu 28 March")
                                    $formattedDate = $date->format('D d F');
                                @endphp
                                {{$formattedDate ?? 'Anytime'}}
                                <span><i class="ico-clock me-1 fs-5"></i> {{ \Carbon\Carbon::parse($waitlists->updated_at)->diffForHumans() }}</span>
                            </div>
                            <div class="client-name">
                                <div class="drop-cap" style="background: #D0D0D0; color:#fff;">{{ strtoupper(substr($waitlists->firstname, 0, 1))}}</div>
                                <div class="client-info">
                                    <h4 class="blue-bold" data-clientid="{{$waitlists->id}}">{{$waitlists->firstname.' '.$waitlists->lastname}}</h4>
                                </div>
                            </div>
                            <div class="mb-2"><a href="#" class="river-bed"><b>{{$waitlists->mobile_number}}</b></a><br>
                            <a href="#" class="river-bed"><b>{{$waitlists->email}}</b></a></div>
                            <!-- Your other content -->
                            @php
                            $ser_names = [];
                            @endphp
                            @foreach($waitlists->service_name as $key => $ser)
                                @php
                                    $ser_names[] = $ser;
                                    $dur = isset($waitlists->duration[$key]) ? $waitlists->duration[$key] : '';
                                    $userFirstName = isset($waitlists->user_firstname) ? $waitlists->user_firstname : '';
                                    $userLastName = isset($waitlists->user_lastname) ? $waitlists->user_lastname : '';
                                    $userName = trim($userFirstName . ' ' . $userLastName);
                                @endphp
                                <p>{{$ser}}</p>
                                <p>{{$dur}} Mins with {{$userName ? $userName : 'Anyone'}}</p>
                            @endforeach
                            @php
                            $ser_names_str = implode(',', $ser_names); // Convert array to comma-separated string
                            @endphp
                            @php
                            $ser_ids = [];
                            @endphp
                            @foreach($waitlists->servid as $wait)
                                @php
                                    $ser_ids[] = $wait;
                                @endphp
                            @endforeach
                            @php
                            $ser_ids_str = implode(',', $ser_ids); // Convert array to comma-separated string
                            @endphp
                            <p class="additional_notes" style="display:none;">{{$waitlists->additional_notes}}
                            <div class="mt-2">
                                <span class="dropdown show">
                                    <a class="btn btn-primary font-13 alter btn-sm slot-btn me-2 dropdown-toggle more-options-btn" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        More Options
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item edit-btn" href="javascript:void(0)" waitlist_id="{{$waitlists->id}}" id="edit_waitlist_clients" client_id="{{$waitlists->client_id}}" category_id="{{$waitlists->category_id}}" duration="{{$dur}}" service_name="{{$ser_names_str}}" services_id="{{ $ser_ids_str }}" preferred-from-date="{{$waitlists->preferred_from_date}}" user-id="{{$waitlists->user_id}}" preferred-to-date="{{$waitlists->preferred_to_date}}" additional-notes="{{$waitlists->additional_notes}}" client-name="{{$waitlists->firstname.' '.$waitlists->lastname}}">Edit</a>
                                        <a class="dropdown-item delete-btn delete_waitlist_client" href="#"  waitlist_id="{{$waitlists->id}}">Delete</a>
                                    </div>
                                </span>
                                @if(!empty($waitlists->additional_notes))
                                    <a href="#" class="btn btn-primary font-13 alter btn-sm slot-btn show_notes"> Show notes</a>
                                @else
                                    <a href="#" class="btn btn-primary font-13 alter btn-sm slot-btn show_notes" disabled style="color: darkgray;"> Show notes</a>
                                @endif
                            </div>
                        </li>
                    @endforeach
                    @else
                    <span>No data found
                    </ul>
                    @endif
                </div>
                {{-- <img src="img/demo-calander.png" alt="" class="search_client"> onkeyup="changeInput(this.value)" --}}
            </div>
            <!-- Hidden input field for datepicker -->
            <input type="text" id="datepicker" style="display:none;">
            <input type="hidden" id="selectedDateInput">
            <input type="hidden" id="client_name" name="client_name">
            <input type="hidden" id="client_id" name="client_id">
            <div class="col-lg-9">
                <div class="main-apnt-calendar" id="calendar">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="New_appointment" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xxl">
            <div class="modal-content">
            <div id="clientCreate" data-url="{{ route('clients.store') }}"></div>
            <form id="create_client" name="create_client" class="form" method="post">
                @csrf
                <input type="hidden" name="check_client" id="check_client" value="selected_client">
                <input type="hidden" name="appointmentlocationId" id="appointmentlocationId">
                <div class="modal-header">
                    <h4 class="modal-title">Please add new appointment here</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="clientCreateModal">
                        <div class="one-inline align-items-center mb-4 client_detail">
                            <div class="form-group icon mb-0 me-3">
                                <input type="text" class="form-control" autocomplete="off" id="searchmodel" placeholder="Search for a client"  onkeyup="changeInputModal(this.value)">
                                <!-- search_client_modal -->
                                <i class="ico-search"></i>
                            </div>
                            <!-- <div class="list-group" id="search_client_modal"></div> -->
                            <span class="me-3">Or</span>
                            <button type="button" class="btn btn-primary btn-md add_new_client">Add a New Client</button>
                        </div>
                        <strong class="new_client_head" style="display:none;">New client details</strong><span class="sep new_client_head" style="display:none">|</span><a href="#" class="new_client_head cancel_client" style="display:none">Cancel</a>
                        <div class="mb-5 client_form" style="display:none;">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="form-control" name="firstname" id="firstname_client" maxlength="50">
                                        </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control" name="lastname" id="lastname_client" maxlength="50">
                                        </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input type="text" class="form-control" name="email" id="email_client" maxlength="100">
                                        </div>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label">Gender</label>
                                    <div class="toggle form-group">
                                        <input type="radio" name="gender" value="Male" id="male" checked="checked" />
                                        <label for="male">Male <i class="ico-tick"></i></label>
                                        <input type="radio" name="gender" value="Female" id="female" />
                                        <label for="female">Female <i class="ico-tick"></i></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">Phone </label>
                                        <input type="text" class="form-control" name="phone" id="phone_client" maxlength="15">
                                        </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">Phone type</label>
                                        <select class="form-select form-control" name="phone_type" id="phone_type_client">
                                            <option selected="" value=""> -- select an option -- </option>
                                            <option>Mobile</option>
                                            <option>Home</option>
                                            <option>Work</option>
                                        </select>
                                        </div>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label">Send Promotions</label>
                                    <div class="toggle form-group">
                                        <input type="radio" name="send_promotions" value="1" id="yes" checked="checked">
                                        <label for="yes">Yes <i class="ico-tick"></i></label>
                                        <input type="radio" name="send_promotions" value="0" id="no">
                                        <label for="no">No <i class="ico-tick"></i></label>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">Preferred contact method</label>
                                            <select class="form-select form-control" name="contact_method" id="contact_method_client">
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
                            </div>
                        </div>
                    </div>
                    {{-- <div id="resultmodal" class="list-group"></div> --}}
                    <div class="client_list_box" style="display:none;">
                        <ul class="drop-list" id="resultmodal"></ul>
                    </div>
                    <div class="mb-5" id="clientmodal">
                        <div class="one-inline align-items-center mb-2">
                            <span class="custname me-3" id="clientDetailsModal"> </span>
                            <input type="hidden" name="clientname" id="clientName">
                            <button type="button" class="btn btn-primary btn-md client_change">Change</button>
                        </div>
                        <em class="d-grey font-12 btn-light">No recent appointments found</em>
                    </div>

                    <div class="row">
                        <div class="col">
                            <h6>Categories</h6>
                            <div class="service-list-box p-2">
                                <ul class="ctg-tree ps-0 pe-1" id="main_categories">
                                    <li class="pt-title">
                                        <div class="disflex">
                                            <a href="javascript:void(0);" class="parent_category_id">All Services &amp; Tasks </a>
                                        </div>
                                    </li>
                                    @foreach ($categories as $category)
                                    <li>
                                        <div class="disflex">
                                            <a href="javascript:void(0);" class="parent_category_id" data-category_id="{{$category->id}}" data-duration="{{ $category->duration }}">{{$category->category_name}}</a>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col">
                            <h6>Services</h6>
                            <div class="service-list-box p-2" id="all_ser">
                                <ul class="ctg-tree ps-0 pe-1">
                                    <li class="pt-title">
                                        <div class="disflex">
                                            <label id="subcategory_text">All Services &amp; Tasks</label>
                                        </div>
                                        <ul id="sub_services">
                                            @foreach ($services as $service)
                                                <li class="service_selected">
                                                    <a href="javascript:void(0);" class="services" data-services_id="{{$service->id}}" data-category_id="{{$service->category_id}}" data-duration="{{ $service->appearoncalender->duration }}">{{ $service->service_name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col">
                            <h6>Selected Services</h6>
                            <div class="service-list-box p-2" id="all_selected_ser">
                                <ul class="ctg-tree ps-0 pe-1">
                                    <li class="pt-title">
                                        <div class="disflex">
                                            Please Select/Deselect Services
                                        </div>
                                        <ul id="selected_services">
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div><label style="color: red" id="service_error">Please select at least one service for this appointment.</label></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-md" data-bs-dismiss="modal">Discard</button>
                    <button type="button" class="btn btn-primary btn-md" id="appointmentSaveBtn">Save Changes</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="Edit_appointment" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xxl">
            <div class="modal-content">
            <div id="clientEdit" data-url="{{ route('clients.store') }}"></div>
            <form id="edit_client" name="edit_client" class="form" method="post">
                @csrf
                <input type="hidden" name="check_edit_client" id="check_edit_client" value="selected_client">
                <div class="modal-header">
                    <h4 class="modal-title">Please Edit appointment here</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="clientEditModal">
                        <div class="one-inline align-items-center mb-5 client_detail">
                            <div class="form-group icon mb-0 me-3">
                                <input type="text" class="form-control" autocomplete="off" id="searcheditmodel" placeholder="Search for a client"  onkeyup="changeEditInputModal(this.value)">
                                <!-- search_client_modal -->
                                <i class="ico-search"></i>
                            </div>
                            <!-- <div class="list-group" id="search_client_modal"></div> -->
                            <span class="me-3">Or</span>
                            <button type="button" class="btn btn-primary btn-md add_new_client">Add a New Client</button>
                        </div>
                        <strong class="new_client_head" style="display:none;">New client details</strong><span class="sep new_client_head" style="display:none">|</span><a href="#" class="new_client_head cancel_client" style="display:none">Cancel</a>
                        <div class="mb-5 client_form" style="display:none;">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="form-control" name="firstname" id="firstname_client" maxlength="50">
                                        </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control" name="lastname" id="lastname_client" maxlength="50">
                                        </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input type="text" class="form-control" name="email" id="email_client" maxlength="100">
                                        </div>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label">Gender</label>
                                    <div class="toggle form-group">
                                        <input type="radio" name="gender" value="Male" id="edit_male" checked="checked" />
                                        <label for="edit_male">Male <i class="ico-tick"></i></label>
                                        <input type="radio" name="gender" value="Female" id="edit_female" />
                                        <label for="edit_female">Female <i class="ico-tick"></i></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">Phone </label>
                                        <input type="text" class="form-control" name="phone" id="phone_client" maxlength="15">
                                        </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">Phone type</label>
                                        <select class="form-select form-control" name="phone_type" id="phone_type_client">
                                            <option selected="" value=""> -- select an option -- </option>
                                            <option>Mobile</option>
                                            <option>Home</option>
                                            <option>Work</option>
                                        </select>
                                        </div>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label">Send Promotions</label>
                                    <div class="toggle form-group">
                                        <input type="radio" name="send_promotions" value="1" id="edit_yes" checked="checked">
                                        <label for="edit_yes">Yes <i class="ico-tick"></i></label>
                                        <input type="radio" name="send_promotions" value="0" id="edit_no">
                                        <label for="edit_no">No <i class="ico-tick"></i></label>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">Preferred contact method</label>
                                            <select class="form-select form-control" name="contact_method" id="contact_method_client">
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
                            </div>
                        </div>
                    </div>
                    {{-- <div id="resultmodal" class="list-group"></div> --}}
                    <div class="client_list_box" style="display:none;">
                        <ul class="drop-list" id="resulteditmodal"></ul>    
                    </div>
                    <div class="mb-5" id="clienteditmodal">
                        <div class="one-inline align-items-center mb-2">
                            <input type="hidden" id="event_id" value="">
                            <input type="hidden" id="latest_staff_id" value="">
                            <input type="hidden" id="latest_start_time" value="">
                            <input type="hidden" id="latest_end_time" value="">
                            <span class="custname me-3" id="clienteditDetailsModal"> </span>
                            <input type="hidden" name="clientname" id="clientName">
                            <button type="button" class="btn btn-primary btn-md client_edit_change">Change</button>
                        </div>
                        <em class="d-grey font-12 btn-light">No recent appointments found</em>
                    </div>

                    <div class="row">
                        <div class="col">
                            <h6>Categories</h6>
                            <div class="service-list-box p-2">
                                <ul class="ctg-tree ps-0 pe-1" id="edit_main_categories" >
                                    <li class="pt-title">
                                        <div class="disflex">
                                            <a href="javascript:void(0);" class="edit_parent_category_id">All Services &amp; Tasks </a>
                                        </div>
                                    </li>
                                    @foreach ($categories as $category)
                                    <li>
                                        <div class="disflex">
                                            <a href="javascript:void(0);" class="edit_parent_category_id" data-category_id="{{$category->id}}" data-duration="{{ $category->duration }}">{{$category->category_name}}</a>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col">
                            <h6>Services</h6>
                            <div class="service-list-box p-2" id="all_ser">
                                <ul class="ctg-tree ps-0 pe-1">
                                    <li class="pt-title">
                                        <div class="disflex">
                                            <label id="subcategory_text">All Services &amp; Tasks</label>
                                        </div>
                                        <ul id="edit_sub_services" class="edit_sub_services">
                                            @foreach ($services as $services_data)
                                                <li class="service_selected">
                                                    <a href="javascript:void(0);" class="services" data-services_id="{{$services_data->id}}" data-services_id="{{$services_data->id}}" data-category_id="{{$services_data->category_id}}" data-duration="{{ $services_data->appearoncalender->duration }}">{{ $services_data->service_name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col">
                            <h6>Selected Services</h6>
                            <div class="service-list-box p-2" id="all_selected_ser">
                                <ul class="ctg-tree ps-0 pe-1">
                                    <li class="pt-title">
                                        <div class="disflex">
                                            Please Select/Deselect Services
                                        </div>
                                        <ul id="edit_selected_services">
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div><label style="color: red" id="service_error">Please select at least one service for this appointment.</label></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-md" data-bs-dismiss="modal">Discard</button>
                    <button type="button" class="btn btn-primary btn-md" id="appointmentUpdateBtn">Update appointment</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="Edit_waitlist_client" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xxl">
            <div class="modal-content">
            <div id="clientCreate" data-url="{{ route('clients.store') }}"></div>
            <form id="edit_waitlist_client" name="edit_waitlist_client" class="form" method="post">
                @csrf
                <input type="hidden" name="check_client" id="check_client" value="selected_client">
                <div class="modal-header">
                    <h4 class="modal-title">Edit waitlist client</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="clientWaitListEditModal">
                        <div class="one-inline align-items-center mb-4 client_detail">
                            <div class="form-group icon mb-0 me-3">
                                <input type="text" class="form-control" autocomplete="off" id="searchwaitlistmodel" placeholder="Search for a client"  onkeyup="changeWaitListInputModal(this.value)">
                                <!-- search_client_modal -->
                                <i class="ico-search"></i>
                            </div>
                            <!-- <div class="list-group" id="search_client_modal"></div> -->
                            <span class="me-3">Or</span>
                            <button type="button" class="btn btn-primary btn-md add_new_client">Add a New Client</button>
                        </div>
                        <strong class="new_client_head" style="display:none;">New client details</strong><span class="sep new_client_head" style="display:none">|</span><a href="#" class="new_client_head cancel_client" style="display:none">Cancel</a>
                        <div class="mb-5 client_form" style="display:none;">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="form-control" name="firstname" id="firstname_client" maxlength="50">
                                        </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control" name="lastname" id="lastname_client" maxlength="50">
                                        </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input type="text" class="form-control" name="email" id="email_clients" maxlength="100">
                                        </div>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label">Gender</label>
                                    <div class="toggle form-group">
                                        <input type="radio" name="gender" value="Male" id="male" checked="checked" />
                                        <label for="male">Male <i class="ico-tick"></i></label>
                                        <input type="radio" name="gender" value="Female" id="female" />
                                        <label for="female">Female <i class="ico-tick"></i></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">Phone </label>
                                        <input type="text" class="form-control" name="phone" id="phone_client" maxlength="15">
                                        </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">Phone type</label>
                                        <select class="form-select form-control" name="phone_type" id="phone_type_client">
                                            <option selected="" value=""> -- select an option -- </option>
                                            <option>Mobile</option>
                                            <option>Home</option>
                                            <option>Work</option>
                                        </select>
                                        </div>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label">Send Promotions</label>
                                    <div class="toggle form-group">
                                        <input type="radio" name="send_promotions" value="1" id="yes" checked="checked">
                                        <label for="yes">Yes <i class="ico-tick"></i></label>
                                        <input type="radio" name="send_promotions" value="0" id="no">
                                        <label for="no">No <i class="ico-tick"></i></label>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">Preferred contact method</label>
                                            <select class="form-select form-control" name="contact_method" id="contact_method_client">
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
                            </div>
                        </div>
                    </div>
                    {{-- <div id="resultmodal" class="list-group"></div> --}}
                    <div class="client_waitlist_box" style="display:none;">
                        <ul class="drop-list" id="resultwaitlistmodal"></ul>
                    </div>
                    <div class="mb-5" id="clientWaitListEditModal">
                        <div class="one-inline align-items-center mb-2">
                            <span class="custname me-3" id="clientEditDetailsModal"> </span>
                            <input type="hidden" name="clientname" id="clientName">
                            <input type="hidden" name="clientid" id="clientid">
                            <input type="hidden" name="waitlist_id" id="waitlist_id">
                            <button type="button" class="btn btn-primary btn-md client_waitlist_change">Change</button>
                        </div>
                        <em class="d-grey font-12 btn-light">No recent appointments found</em>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label">Preferred staff member</label>
                                <select class="form-select form-control" name="user_id" id="user_id">
                                    <option selected="" value="">Anyone</option>
                                    @if(count($staffs)>0)
                                    @foreach($staffs as $user)
                                        <option value="{{$user->id}}">{{$user->first_name.' '.$user->last_name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label">Preferred date</label>
                                <input type="date" class="form-control" placeholder="No preference" id="preferred_from_date" name="preferred_from_date">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label">&nbsp;</label>
                                <input type="date" class="form-control" id="preferred_to_date" name="preferred_to_date">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label class="form-label">Additional notes</label>
                            <textarea class="form-control" rows="5" name="additional_notes" id="additional_notes"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h6>Categories</h6>
                            <div class="service-list-box p-2">
                                <ul class="ctg-tree ps-0 pe-1" id="waitlist_main_categories">
                                    <li class="pt-title">
                                        <div class="disflex">
                                            <a href="javascript:void(0);" class="edit_waitlist_parent_category_id">All Services &amp; Tasks </a>
                                        </div>
                                    </li>
                                    @foreach ($categories as $category)
                                    <li>
                                        <div class="disflex">
                                            <a href="javascript:void(0);" class="edit_waitlist_parent_category_id" data-category_id="{{$category->id}}" data-duration="{{ $category->duration }}">{{$category->category_name}}</a>
                                        </div>
                                        @if ($category->children)
                                            <ul>
                                                @foreach ($category->children as $child)
                                                    <li>
                                                        <a href="javascript:void(0);">{{$child->category_name}}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col">
                            <h6>Services</h6>
                            <div class="service-list-box p-2" id="all_ser">
                                <ul class="ctg-tree ps-0 pe-1">
                                    <li class="pt-title">
                                        <div class="disflex">
                                            <label id="subcategory_text">All Services &amp; Tasks</label>
                                        </div>
                                        <ul id="waitlist_sub_services" class="waitlist_sub_services">
                                            @foreach ($services as $service)
                                                <li class="service_selected">
                                                    <a href="javascript:void(0);" class="services" data-services_id="{{$service->id}}" data-category_id="{{$service->category_id}}" data-duration="{{ $service->appearoncalender->duration }}">{{ $service->service_name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col">
                            <h6>Selected Services</h6>
                            <div class="service-list-box p-2" id="all_selected_ser">
                                <ul class="ctg-tree ps-0 pe-1">
                                    <li class="pt-title">
                                        <div class="disflex">
                                            Please Select/Deselect Services
                                        </div>
                                        <ul id="edit_waitlist_selected_services">
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div><label style="color: red" id="service_error">Please select at least one service for this appointment.</label></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-md" data-bs-dismiss="modal">Discard</button>
                    <button type="button" class="btn btn-primary btn-md" id="waitlistUpdateBtn">Save Changes</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="Walkin_Retail" tabindex="-1">
        <input type="hidden" id="customer_type" value="casual">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content main_walk_in">
                <div class="modal-header">
                <h4 class="modal-title">Walk-in retail sale @ Hope Island</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="create_walkin" name="create_walkin" class="form" method="post">
                @csrf
                <input type="hidden" name="walk_in_client_id" id="walk_in_client_id">
                <input type="hidden" name="hdn_customer_type" id="hdn_customer_type" value="casual">
                <input type='hidden' id="hdn_subtotal" name='hdn_subtotal' value='0'>
                <input type='hidden' id="hdn_total" name='hdn_total' value='0'>
                <input type='hidden' id="hdn_gst" name='hdn_gst' value='0'>
                <input type='hidden' id="hdn_discount" name='hdn_discount' value='0'>

                <!--discount hidden fields-->
                <input type='hidden' id="hdn_main_discount_surcharge" name='hdn_main_discount_surcharge' value='No Discount'>
                <input type='hidden' id="hdn_main_discount_type" name='hdn_main_discount_type' value='amount'>
                <input type='hidden' id="hdn_main_discount_amount" name='hdn_main_discount_amount' value='0'>
                <input type='hidden' id="hdn_main_discount_reason" name='hdn_main_discount_reason' value=''>
                <div class="modal-body">
                        <ul class="nav nav-pills nav-fill nav-group mb-3 main_walkin" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active casual_cus" data-bs-toggle="tab" href="#casual_customer" aria-selected="true" role="tab">Casual Customer <i class="ico-tick ms-1"></i></a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link new_cus" data-bs-toggle="tab" href="#new_customer" aria-selected="true" role="tab">New Customer <i class="ico-tick ms-1"></i></a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link existing_cus" data-bs-toggle="tab" href="#exist_customer" aria-selected="true" role="tab">Existing Customer <i class="ico-tick ms-1"></i></a>
                            </li>
                        </ul>
                        <div class="tab-content">
                        <div class="tab-pane fade show active" id="casual_customer" role="tabpanel">
                            <div class="form-group icon">
                                <label>Invoice Date</label>
                                <input type="date" id="datePicker1" name="casual_invoice_date" class="form-control" placeholder="date" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="form-group icon">
                                <input type="text" id="search_products" class="form-control " autocomplete="off" placeholder="Search for services or products" onkeyup="changeProductInput(this.value)">
                                <i class="ico-search"></i>
                                <div id="result1" class="list-group"></div>
                                <div class="products_box" style="display:none;">
                                    <ul class="drop-list" id="resultproductmodal"></ul>
                                </div>
                            </div>
                            <div id="productDetails" class="detaild-theos pt-3"></div>
                            
                            <div class="mb-3">
                                <a href="#" class="btn btn-dashed w-100 btn-blue icon-btn-center add_discount"><i class="ico-percentage me-2 fs-5"></i> Add discount / surcharge</a>
                            </div>
                            <table width="100%">
                                <tbody>
                                    <tr>
                                        <td>Subtotal</td>
                                        <td class="text-end subtotal">$0.00</td>
                                    </tr>
                                    <tr class="discount-row">
                                        <td>Discount</td>
                                        <td class="text-end discount">$0.00</td>
                                    </tr>
                                    <tr>
                                        <td><b>Total</b></td>
                                        <td class="text-end total"><b>$0.00</b></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td class="text-end d-grey font-13 gst_total">(Includes GST of $0.00)</td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr class="my-4">
                            <div class="form-group credit_sale">
                                <label class="form-label">Credit Sale to <span class="d-grey font-13">(required)</span></label>
                                <select class="form-select form-control" name="casual_staff" id="sale_staff_id">
                                    <option value="">Please select</option>
                                    @foreach($staffs as $staff)
                                        <option value="{{$staff->id}}">{{$staff->first_name.' '.$staff->last_name}}</option>
                                    @endforeach
                                </select>
                                </div>
                                <div class="form-group mb-0">
                                <label class="form-label">Note</label>
                                <textarea class="form-control" rows="3" placeholder="Add a note" name="notes" id="notes"></textarea>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="new_customer" role="tabpanel">
                            <div class="row">
                                <div class="form-group icon col-lg-4">
                                    <label>First Name</label>
                                    <input type="text" id="first_name" class="form-control" placeholder="First">
                                </div>
                                <div class="form-group icon col-lg-4">
                                    <label>Last Name</label>
                                    <input type="text" id="last_name" class="form-control" placeholder="Last">
                                </div>
                                <div class="form-group icon col-lg-4">
                                    <label>Email</label>
                                    <input type="text" id="email" class="form-control" placeholder="Email">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group icon col-lg-4">
                                    <label>Phone</label>
                                        <select class="form-select form-control" name="phone_type" id="phone_type">
                                            <option selected="" value=""> -- select an option -- </option>
                                            <option>Mobile</option>
                                            <option>Home</option>
                                            <option>Work</option>
                                        </select>
                                </div>
                                <div class="form-group icon col-lg-4">
                                    <label></label>
                                    <input type="text" id="phone_no" name="phone_no" class="form-control">
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label">Gender</label>
                                    <div class="toggle form-group">
                                        <input type="radio" name="gender" value="Male" id="males" checked="checked" />
                                        <label for="males">Male <i class="ico-tick"></i></label>
                                        <input type="radio" name="gender" value="Female" id="females" />
                                        <label for="females">Female <i class="ico-tick"></i></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="form-label">Preferred contact method</label>
                                        <select class="form-select form-control" name="contact_method" id="contact_method_client">
                                            <option selected="" value=""> -- select an option -- </option>
                                            <option>Text message (SMS)</option>
                                            <option>Email</option>
                                            <option>Phone call</option>
                                            <option>Post</option>
                                            <option>No preference</option>
                                            <option>Don't send reminders</option>
                                        </select>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label">Send promotions</label>
                                    <div class="toggle mb-0">
                                        <input type="radio" name="send_promotions" value="1" id="walkin_yes" checked="checked">
                                        <label for="walkin_yes">Yes <i class="ico-tick"></i></label>
                                        <input type="radio" name="send_promotions" value="0" id="walkin_no">
                                        <label for="walkin_no">No <i class="ico-tick"></i></label>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4">
                            <div class="form-group icon">
                                <label>Invoice Date</label>
                                <input type="date" id="datePicker2" name="new_invoice_date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="form-group icon">
                                <input type="text" id="search_products_new_customer" class="form-control " autocomplete="off" placeholder="Search for services or products" onkeyup="changeProductInputNewCustomer(this.value)">
                                <i class="ico-search"></i>
                                <div id="result1" class="list-group"></div>
                                <div class="products_box_new" style="display:none;">
                                    <ul class="drop-list" id="resultproductmodalNew"></ul>
                                </div>
                            </div>
                            <div id="NewproductDetails" class="detaild-theos pt-3"></div>
                            
                            <div class="mb-3">
                                <a href="#" class="btn btn-dashed w-100 btn-blue icon-btn-center add_discount"><i class="ico-percentage me-2 fs-5"></i> Add discount / surcharge</a>
                            </div>
                            <table width="100%">
                                <tbody>
                                    <tr>
                                        <td>Subtotal</td>
                                        <td class="text-end subtotal">$0.00</td>
                                    </tr>
                                    <tr class="discount-row">
                                        <td>Discount</td>
                                        <td class="text-end discount">$0.00</td>
                                    </tr>
                                    <tr>
                                        <td><b>Total</b></td>
                                        <td class="text-end total"><b>$0.00</b></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td class="text-end d-grey font-13 gst_total">(Includes GST of $0.00)</td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr class="my-4">
                            <div class="form-group credit_sale">
                                <label class="form-label">Credit Sale to <span class="d-grey font-13">(required)</span></label>
                                <select class="form-select form-control" name="new_staff" id="sale_staff_id">
                                    <option value="">Please select</option>
                                    @foreach($staffs as $staff)
                                        <option value="{{$staff->id}}">{{$staff->first_name.' '.$staff->last_name}}</option>
                                    @endforeach
                                </select>
                                </div>
                                <div class="form-group mb-0">
                                <label class="form-label">Note</label>
                                <textarea class="form-control" rows="3" placeholder="Add a note"></textarea>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="exist_customer" role="tabpanel">
                            <div class="form-group icon client_search_bar">
                                <input type="text" id="search_exist_customer" class="form-control " autocomplete="off" placeholder="Search for a client" onkeyup="changeExistingCutomerInput(this.value)">
                                <i class="ico-search"></i>
                                <div id="result1" class="list-group"></div>
                            </div>
                            <div class="existing_client_list_box" style="display:none;">
                                <ul class="drop-list" id="resultexistingmodal"></ul>
                            </div>
                            <div class="mb-5" id="existingclientmodal"  style="display:none;">
                                <div class="one-inline align-items-center mb-2">
                                    <span class="custname me-3" id="existingclientDetailsModal"> </span>
                                    <input type="hidden" name="clientname" id="clientName">
                                    <button type="button" class="btn btn-primary btn-md existing_client_change">Change</button>
                                </div>
                                <em class="d-grey font-12 btn-light">No recent appointments found</em>
                            </div>
                            <div class="form-group icon">
                                <label>Invoice Date</label>
                                <input type="date" id="datePicker3" name="existing_invoice_date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="form-group icon">
                                <input type="text" id="search_products_existing_customer" class="form-control " autocomplete="off" placeholder="Search for services or products" onkeyup="changeProductInputExistingCustomer(this.value)">
                                <i class="ico-search"></i>
                                <div id="result1" class="list-group"></div>
                                <div class="products_box_existing" style="display:none;">
                                    <ul class="drop-list" id="resultproductmodalExisting"></ul>
                                </div>
                            </div>
                            <div id="ExistingproductDetails" class="detaild-theos pt-3"></div>
                            
                            <div class="mb-3">
                                <a href="#" class="btn btn-dashed w-100 btn-blue icon-btn-center add_discount"><i class="ico-percentage me-2 fs-5"></i> Add discount / surcharge</a>
                            </div>
                            <table width="100%">
                                <tbody>
                                    <tr>
                                        <td>Subtotal</td>
                                        <td class="text-end subtotal">$0.00</td>
                                    </tr>
                                    <tr class="discount-row">
                                        <td>Discount</td>
                                        <td class="text-end discount">$0.00</td>
                                    </tr>
                                    <tr>
                                        <td><b>Total</b></td>
                                        <td class="text-end total"><b>$0.00</b></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td class="text-end d-grey font-13 gst_total">(Includes GST of $0.00)</td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr class="my-4">
                            <div class="form-group credit_sale">
                                <label class="form-label">Credit Sale to <span class="d-grey font-13">(required)</span></label>
                                <select class="form-select form-control" name="existing_staff" id="sale_staff_id">
                                    <option value="">Please select</option>
                                    @foreach($staffs as $staff)
                                        <option value="{{$staff->id}}">{{$staff->first_name.' '.$staff->last_name}}</option>
                                    @endforeach
                                </select>
                                </div>
                                <div class="form-group mb-0">
                                <label class="form-label">Note</label>
                                <textarea class="form-control" rows="3" placeholder="Add a note"></textarea>
                            </div>
                            </div>
                        </div>
                </div>
                
                <div class="modal-footer justify-content-between">
                    <div class="mod-ft-left d-flex gap-2">
                        <button type="button" class="btn btn-light-outline-grey btn-md icon-btn-left"><i class="ico-print3 me-2 fs-6"></i> Print Quote</button>
                        <!-- <button type="button" class="btn btn-light-outline-grey btn-md icon-btn-left"><i class="ico-draft me-2 fs-6"></i> Save sale as a draft</button> -->
                    </div>
                    <div class="mod-ft-right">
                        <button type="button" class="btn btn-light btn-md">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-md take_payment" main_total="">Take Payment</button>
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-content edit_product" style="display:none;">
                <div class="modal-header" id="edit_product">
                    <h4 class="modal-title">Edit Product</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="invo-notice mb-4 closed">
                        <input type="hidden" name="edit_product_id" id="edit_product_id">
                        <div class="inv-left"><b class="edit_product_name">VIP Skin treatment</b></div>
                        <span id="dynamic_discount"></span>
                        <div class="inv-number edit_product_quantity"><b>1</b></div>
                        <div class="inv-number edit_product_price"><b>$60.00</b></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Price per unit</label>
                                <div class="input-group">
                                    <input type="text" class="form-control edit_price_per_unit" placeholder="0">
                                    <span class="input-group-text"><i class="ico-percentage fs-4"></i></span>
                                    </div>
                                </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label">Quantity</label>
                                <div class="number-input safari_only">
                                    <button class="minus"></button>
                                    <input class="quantity form-control edit_quantity" min="0" name="quantity" value="1" type="number">
                                    <button class="plus"></button>
                                </div>
                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Who did work</label>
                                <select class="form-select form-control" name="edit_sale_staff_id" id="edit_sale_staff_id">
                                    <option>Please select</option>
                                    @foreach($staffs as $staff)
                                        <option value="{{$staff->id}}">{{$staff->first_name.' '.$staff->last_name}}</option>
                                    @endforeach
                                </select>
                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Select discount / surcharge</label>
                                <select class="form-select form-control" id="edit_discount_surcharge" name="edit_discount_surcharge">
                                    <option selected>No Discount</option>
                                    <option>Manual Discount</option>
                                    <option>Manual Surcharge</option>
                                    <option>Credit Card Surcharge</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto">
                            <div class="form-group">
                                <label class="form-label mb-3">Discount type </label><br>
                                <label class="cst-radio me-3"><input type="radio" checked="" name="edit_discount_type" id="edit_discount_type" value="amount"><span class="checkmark me-2"></span>Amount</label>
                                <label class="cst-radio"><input type="radio" name="edit_discount_type" id="edit_discount_type" value="percent"><span class="checkmark me-2"></span>Percent</label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Amount</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="edit_amount" placeholder="0">
                                    <span class="input-group-text"><i class="ico-percentage fs-4"></i></span>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Reason</label>
                        <textarea class="form-control" rows="3" placeholder="Add a reason" id="edit_reason"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <div class="mod-ft-left"><button type="button" class="btn btn-light-outline-red btn-md remove_edit_product">Remove</button></div>
                    <div class="mod-ft-right">
                        <button type="button" class="btn btn-light btn-md cancel_product">Cancel</button>
                        <button type="button" class="btn btn-primary btn-md update_product">Update</button>
                    </div>
                </div>
            </div>
            <div class="modal-content main_discount" style="display:none;">
                <input type="hidden" id="discount_customer_type">
                <input type="hidden" id="hdn_amt">
                <input type="hidden" id="hdn_dis_type">
                <input type="hidden" id="hdn_discount_surcharge">
                <div class="modal-header" id="main_discount">
                    <h4 class="modal-title">Add discount / surcharge</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Select discount / surcharge</label>
                                <select class="form-select form-control" id="discount_surcharge" name="discount_surcharge">
                                    <option>No Discount</option>
                                    <option selected>Manual Discount</option>
                                    <option>Manual Surcharge</option>
                                    <option>Credit Card Surcharge</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-auto">
                        <div class="form-group">
                            <label class="form-label mb-3">Discount type </label><br>
                            <label class="cst-radio me-3"><input type="radio" checked="" name="discount_type" id="discount_type" value="amount"><span class="checkmark me-2"></span>Amount</label>
                            <label class="cst-radio"><input type="radio" name="discount_type" id="discount_type" value="percent"><span class="checkmark me-2"></span>Percent</label>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Amount</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="amount" placeholder="0">
                                <span class="input-group-text"><i class="ico-percentage fs-4"></i></span>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Reason</label>
                        <textarea class="form-control" rows="7" placeholder="Add a reason" id="reason"></textarea>
                    </div>
                    <table width="100%" class="add_dis">
                        <tr>
                            <td>Subtotal</td>
                            <td class="text-end subtotal dis_subtotal">$0.00</td>
                        </tr>
                        <tr class="discount-row">
                            <td>Discount</td>
                            <td class="text-end discount dis_discount">$0.00</td>
                        </tr>
                        <tr>
                            <td><b>Total</b></td>
                            <td class="text-end total dis_total"><b>$0.00</b></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-end d-grey font-13 gst_total">(Includes GST of $0.00)</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-md cancel_discount">Cancel</button>
                    <button type="button" class="btn btn-primary btn-md update_discount">Update</button>
                </div>
            </div>
            
        </div>
    </div>
    <div class="modal fade" id="take_payment" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">Take Payment</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row payment_details">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Payment</label>
                                <select class="form-select form-control" name="payment_type[]" id="payment_type">
                                    <option>Card</option>
                                    <option>Afterpay</option>
                                    <option>Bank Transfer</option>
                                    <option>Cash</option>
                                    <option>Humm payment</option>
                                    <option>Voucher</option>
                                    <option>Zip Pay</option>
                                </select>
                                </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ico-dollar fs-4"></i></span>
                                    <input type="text" class="form-control payment_amount" name="payment_amount[]" placeholder="0">
                                    
                                    </div>
                                </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Date</label>
                                <input type="date" id="datePicker4" name="payment_date[]" class="form-control" id="payment_date" placeholder="date" value="<?php echo date('Y-m-d'); ?>" readonly>
                            </div>
                        </div>
                        <div class="remove_payment">
                            <a href="#" class="remove_payment_btn"><button class="btn-close close_waitlist"></button></a>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <a href="#" class="btn btn-dashed w-100 btn-blue icon-btn-center mb-2 add_another_payment"><i class="ico-ticket-discount me-2 fs-5"></i> Add another payment</a>
                        <div class="form-text d-flex align-items-center"><span class="ico-danger fs-5 me-2"></span> Not all payment type supported</div>
                    </div>

                    <hr class="my-4">

                    <table width="100%">
                        <tbody>
                            <tr>
                                <td><b>Total</b></td>
                                <td class="text-end blue payment_total"><b>$250.00</b></td>
                            </tr>
                            <tr>
                                <td>Remaining balance</td>
                                <td class="text-end remaining_balance">$0.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-md back_to_sale">Back to Sale</button>
                    <button type="button" class="btn btn-primary btn-md complete_sale">Complete Sale</button>                                    
                </div>
            </div>
        </div>
    </div>
    @include('calender.partials.client-modal')
    @include('calender.partials.repeat-appointment-modal')
</div>
@stop
@section('script')
<script src="{{ asset('js/fullcalendar-scheduler-6.1.10/dist/index.global.js') }}"></script>
<script src="{{ asset('js/fullcalendar-scheduler-6.1.10/dist/index.global.min.js') }}"></script>
<script src="{{ asset('js/appointment.js') }}"></script>
<script type="text/javascript">
    var moduleConfig = {
        getStaffList:                 "{!! route('get-staff-list') !!}",
        categotyByservices:           "{!! route('calender.get-category-services') !!}",
        getClients:                   "{!! route('calendar.get-all-clients') !!}",
        createAppointment:            "{!! route('calendar.create-appointments') !!}",
        getEvents:                    "{!! route('calendar.get-events') !!}",
        updateAppointment:            "{!! route('calendar.update-appointments') !!}",
        getClientCardData:            "{!! route('calendar.get-client-card-data', ':ID') !!}",
        addNotes:                     "{!! route('calendar.add-appointment-notes') !!}",
        viewNotes:                    "{!! route('calendar.view-appointment-notes') !!}",
        EventById:                    "{!! route('calendar.get-event-by-id', ':ID') !!}",
        updateAppointmentStatus:      "{!! route('calendar.update-appointment-status') !!}",
        DeleteAppointment:            "{!! route('calendar.delete-appointment', ':ID') !!}",
        repeatAppointment:            "{!! route('calendar.repeat-appointment') !!}",
        getLocation:                  "{!! route('get-all-locations') !!}"
    };

    $(document).ready(function()
    {
        var product_details = [];
        
        var today = new Date();
        
        // Set the max attribute of the date pickers to yesterday
        document.getElementById("datePicker1").setAttribute("max", today.toISOString().split('T')[0]);
        document.getElementById("datePicker2").setAttribute("max", today.toISOString().split('T')[0]);
        document.getElementById("datePicker3").setAttribute("max", today.toISOString().split('T')[0]);
        document.getElementById("datePicker4").setAttribute("min", today.toISOString().split('T')[0]);
        document.getElementById("datePicker4").setAttribute("max", today.toISOString().split('T')[0]);
        
        $("#edit_waitlist_client").validate({
            rules: {
                firstname: {
                    required: true,
                },
                lastname:{
                    required:true,
                },
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "../clients/checkClientEmail", // Replace with the actual URL to check email uniqueness
                        type: "post", // Use "post" method for the AJAX request
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            email: function () {
                                return $("#email_clients").val(); // Pass the value of the email field to the server
                            }
                        },
                        dataFilter: function (data) {
                            var json = $.parseJSON(data);
                            var chk = json.exists ? '"Email already exist!"' : '"true"';
                            return chk;
                        }
                    }
                },
                phone:{
                    required: true,
                },
                phone_type:{
                    required: true,
                },
                contact_method:{
                    required: true,
                },
                preferred_from_date:{
                    required: true,
                },
                preferred_to_date:{
                    required: true,
                }
            },
        });

        // Define validation rules
        var validationRules = {
            casual_staff: {
                required: true
            },
            new_staff: {
                required: true
            },
            existing_staff: {
                required: true
            }
        };

        $("#create_walkin").validate({
            rules: validationRules,
            messages: {
                casual_staff: {
                    required: "Please select credit sale."
                },
                new_staff: {
                    required: "Please select credit sale."
                },
                existing_staff: {
                    required: "Please select credit sale."
                }
            },
            errorPlacement: function(error, element) {
                // Custom error placement
                error.insertAfter(element); // Display error message after the element
            }
        });

         // Switch tabs and validate on tab change
        // $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
        //     var target = $(e.target).attr("href");
        //     var $target = $(target);
        //     // Check if the tab has validation rules defined
        //     if (validationRules[target]) {
        //         // Remove previous validation rules
        //         validator.resetForm();
        //         // Add new validation rules for the current tab
        //         $target.find('input, select, textarea').each(function() {
        //             $(this).rules('remove'); // Remove previous rules
        //         });
        //         $target.find('input, select, textarea').each(function() {
        //             $(this).rules('add', validationRules[target][$(this).attr('name')]); // Add new rules
        //         });
        //     }
        // });

        $('#waitlistUpdateBtn').on('click' ,function(e){
            var clientselectedServicesCount = $('#edit_waitlist_selected_services').children("li").length,
                clientName                  = $('#clientDetailsModal').text();
            // console.log(clientName);

            if($('#check_client').val() == 'new_client')
            {
                if ($("#edit_waitlist_client").valid()) {
                    var data = $('#edit_waitlist_client').serialize();
                    SubmitEditWaitlistClient(data);
                    if(clientName === "")
                    {
                        console.log('in if');
                        $('#client').show();
                    }
                    else
                    {
                        $('#client').hide();
                    }

                    if(clientselectedServicesCount == 0 )
                    {
                        $('#service_error').show();
                    }
                    else{
                        $('#service_error').hide();
                        // Check if the form is valid or not

                        var appointmentsData = []; // Array to store appointment data
                        var eventIds = []; // Array to store eventIds
                        var categoryIdsSet = new Set(); 

                        $("#edit_waitlist_selected_services > li").each(function(){
                            var eventId = $(this).data('services_id');
                            categoryId = $(this).data('category_id');

                            // Push eventId to eventIds array
                            eventIds.push(eventId);
                            categoryIdsSet.add(categoryId);
                        });
                        var categoryIdsArray = Array.from(categoryIdsSet);

                        // Create a comma-separated string of eventIds
                        var eventIdsStr = eventIds.join(',');
                        var categoryIdsStr = categoryIdsArray.join(',');

                        // Create a single appointment object with all eventIds stored as comma-separated
                        var appointment = {
                            'waitlist_id':$('#waitlist_id').val(),
                            'client_id': $('#clientid').val(),
                            'user_id': $('#user_id').val(),
                            'preferred_from_date': $('#preferred_from_date').val(),
                            'preferred_to_date': $('#preferred_to_date').val(),
                            'additional_notes': $('#additional_notes').val(),
                            // 'category_id': categoryIdsStr,
                            // 'service_id': eventIdsStr // Store eventIds as comma-separated string
                        };

                        // Create categoryIdsStr with unique category IDs
                        for (var i = 0; i < categoryIdsArray.length; i++) {
                            if (categoryIdsStr !== '') {
                                categoryIdsStr += ',';
                            }
                            categoryIdsStr += categoryIdsArray[i];
                        }
                        appointment.category_id = categoryIdsStr;
                        appointment.service_id = eventIdsStr; // Store eventIds as comma-separated string
                        
                        appointmentsData.push(appointment);

                        // Now appointmentsData contains only one object with all eventIds stored as comma-separated
                        console.log("Appointments Data:", appointmentsData);

                        // Clear selected services
                        $("#selected_services").empty();

                        $.ajax({
                            url: '../calender/update-waitlist-client',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                appointments: appointmentsData
                            },
                            success: function(data) {
                                if (data.success) {
                                    Swal.fire({
                                        title: "WaitList Client Created!",
                                        text: data.message,
                                        icon: "success",
                                    }).then(function() {
                                        // Reload the current page
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Error!",
                                        text: data.message,
                                        icon: "error",
                                    });
                                }
                            },
                            error: function(error) {
                                console.error('Error fetching resources:', error);
                            }
                        });
                    }
                } else {
                    // Prevent the form from being submitted if it's not valid
                    e.preventDefault();
                }
            }else{
                if(clientName === "")
                {
                    console.log('in if');
                    $('#client').show();
                }
                else
                {
                    $('#client').hide();
                }

                if(clientselectedServicesCount == 0 )
                {
                    $('#service_error').show();
                }
                else{
                    $('#service_error').hide();
                    // Check if the form is valid or not

                    var appointmentsData = []; // Array to store appointment data
                    var eventIds = []; // Array to store eventIds
                    var categoryIdsSet = new Set(); 

                    $("#edit_waitlist_selected_services > li").each(function(){
                        var eventId = $(this).data('services_id');
                        categoryId = $(this).data('category_id');

                        // Push eventId to eventIds array
                        eventIds.push(eventId);
                        categoryIdsSet.add(categoryId);
                    });
                    var categoryIdsArray = Array.from(categoryIdsSet);

                    // Create a comma-separated string of eventIds
                    var eventIdsStr = eventIds.join(',');
                    var categoryIdsStr = '';

                    // Create a single appointment object with all eventIds stored as comma-separated
                    var appointment = {
                        'waitlist_id':$('#waitlist_id').val(),
                        'client_id': $('#client_id').val(),
                        'user_id': $('#user_id').val(),
                        'preferred_from_date': $('#preferred_from_date').val(),
                        'preferred_to_date': $('#preferred_to_date').val(),
                        'additional_notes': $('#additional_notes').val(),
                        // 'category_id': categoryIdsStr,
                        // 'service_id': eventIdsStr // Store eventIds as comma-separated string
                    };
                    // Create categoryIdsStr with unique category IDs
                    for (var i = 0; i < categoryIdsArray.length; i++) {
                        if (categoryIdsStr !== '') {
                            categoryIdsStr += ',';
                        }
                        categoryIdsStr += categoryIdsArray[i];
                    }
                    appointment.category_id = categoryIdsStr;
                    appointment.service_id = eventIdsStr; // Store eventIds as comma-separated string

                    appointmentsData.push(appointment);

                    // Now appointmentsData contains only one object with all eventIds stored as comma-separated
                    console.log("Appointments Data:", appointmentsData);

                    // Clear selected services
                    $("#selected_services").empty();

                    $.ajax({
                        url: '../calender/update-waitlist-client',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            appointments: appointmentsData
                        },
                        success: function(data) {
                            if (data.success) {
                                Swal.fire({
                                    title: "WaitList Client Updated!",
                                    text: data.message,
                                    icon: "success",
                                }).then(function() {
                                    // Reload the current page
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: "Error!",
                                    text: data.message,
                                    icon: "error",
                                });
                            }
                        },
                        error: function(error) {
                            console.error('Error fetching resources:', error);
                        }
                    });
                }
            }

            
        });
        $("#update_client_photos").validate({
            rules: {
                filepond: {
                    validImageExtension: true // Remove the depends option
                }
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") === "filepond") {
                    error.insertAfter(".photo_img");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {
                // The form is already valid at this point
                // file_cnt++;
                $(form).trigger('submit');
            }
        });

        $("#update_client_documents").validate({
            rules: {
                client_documents: {
                    validDocumentExtension: true // Remove the depends option
                }
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") === "client_documents") {
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
            
        }, "Only PNG, JPEG, or JPG images are allowed for photos.");

        $.validator.addMethod("validDocumentExtension", function (value, element) {
            var fileExt = value.split('.').pop().toLowerCase();
            return $.inArray(fileExt, ['png', 'jpeg', 'jpg', 'xlsx', 'doc', 'pdf']) !== -1;
            
        }, "Only PNG, JPEG, XLS, Word, PDF or JPG images are allowed for documents.");

        DU.appointment.init();
        $('#external-events').draggable();
        $('#waitlist-events').draggable();
        $('#waitlist-events').removeAttr('style');
        //for fancybox gallery
        $(".gallery a").attr("data-fancybox","mygallery");
        $(".gallery a").fancybox();

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
        const inputElement = document.getElementById('client_photos');

        // update client detail validation
        $("#update_client_detail").validate({
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
            },
        });

        // client photo updates
        $("#client_photos").change(function () {
            var fileCount = this.files.length;
            var inputElement = document.getElementById('client_photos');
            var data = new FormData();
            var id = $('#client_id').val();
            var uploadedImageIds = []; // Array to hold IDs of uploaded images
            for (var i = 0; i < this.files.length; i++) {
                var reader = new FileReader();
                var files = this.files[i].name;
                var currFile = this.files[i];
                var fileExt = files.split('.').pop().toLowerCase(); // file extension
                // Check if the file is an image and has a valid extension and size
                if ($.inArray(fileExt, ['png', 'jpeg', 'jpg']) !== -1) { // 2MB in bytes  && fileSize <= 2097152
                    var reader = new FileReader();

                    reader.onload = (function (file) {
                    return function (e) {
                        var fileName = file.name;
                        var fileContents = e.target.result;

                        $('.gallery.client-phbox').append(
                            '<input type="hidden" name="hdn_img" value="' + file + '">' +
                            '<figure imgname="' + fileName + '" class="remove_image latest">' +
                            '<a href='+ fileContents +' data-fancybox="mygallery">' +
                            '<img src=' + fileContents + ' class="img-fluid">' +
                            '</a></figure>'
                        );

                        $('.gallery.abc').append(
                            '<input type="hidden" name="hdn_img" value="' + file + '">' +
                            '<figure imgname="' + fileName + '" class="remove_image latest">' +
                            '<a href='+ fileContents +' data-fancybox="mygallery">' +
                            '<img src=' + fileContents + ' class="img-fluid">' +
                            '</a></figure>'
                        );

                        // Add delete button
                        var deleteButton = $('<button>')
                            .addClass('btn black-btn round-6 remove_image dt-delete')
                            .html('<i class="ico-trash"></i>')
                            .click(function () {
                                // You can call a function here to delete the photo using AJAX
                                // For example, deletePhoto(photoId);
                            });

                        $('.remove_image:last').append(deleteButton);
                    };
                })(currFile);
                reader.readAsDataURL(this.files[i]);
                data.append('pics[]', currFile);
                data.append('id',id);
                } else {
                    
                    // if(file_cnt != ''){alert('11');
                    //     $('.photos_count').text(file_cnt);
                    // }else{alert('22');
                    //     $('.photos_count').text('');
                    // }
                    
                    // Reset the file input and display an error message
                    // $('#imgPreview').attr('src', "{{ asset('/storage/images/banner_image/no-image.jpg') }}");
                    // $('.error').remove();
                    // $('.photo_img').after('<label class="error">Only PNG, JPEG, or JPG images are allowed for photos.</label>');
                }
            }
            if(data.has('pics[]')) {
                jQuery.ajax({
                    headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: "{{route('clients-photos')}}",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                    type: 'POST', // For jQuery < 1.9
                    success: function (response) {
                        if (response.success) {
                            uploadedImageIds = response.id;
                            Swal.fire({
                                title: "Client!",
                                text: "Client Photos Updated successfully.",
                                type: "success",
                            }).then((result) => {
                                // Update the photos count after success 01-03-2023
                                var photosCount = parseInt($('.photos_count').text());
                                var resultdoc = photosCount + fileCount;
                                $('.photos_count').text(resultdoc);
                                // Loop through each .remove_image element and set the ids attribute
                                $('.latest').each(function(index, element) {
                                    $(this).find('.dt-delete').attr('ids', uploadedImageIds[index]);
                                });
                            });
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: response.message,
                                type: "error",
                            });
                        }
                    }

                });
            }
        });

        //update client documents
        $("#client_documents").change(function() {
            var fileCount = this.files.length;
            var inputElement = document.getElementById('client_documents');
            var data = new FormData();
            var id=$('#id').val();
            for (var i = 0; i < this.files.length; i++) {
                var reader = new FileReader();
                var files = this.files[i].name;
                var currFile = this.files[i];
                var fileExt = files.split('.').pop().toLowerCase(); // file extension
                // Check if the file is an image and has a valid extension and size
                if ($.inArray(fileExt, ['png', 'jpeg', 'jpg', 'xlsx', 'doc', 'pdf']) !== -1) { // 2MB in bytes  && fileSize <= 2097152
                    var reader = new FileReader();

                    reader.onload = (function (file) {
                        return function (e) {
                            var d = new Date();
                            const month = d.toLocaleString('default', { month: 'long' });
                            var fulldate = d.getDate()+' '+ month + ' ' + d.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
                            var fileName = file.name;
                            var fileContents = e.target.result;
                            $('.docs').append('<a href="#" class="btn tag icon-btn-left skyblue mb-2"><span><i class="ico-pdf me-2 fs-2 align-middle"></i> ' + fileName + '</span> <span class="file-date">' + fulldate + '</span><i class="del ico-trash"></i></a>');
                            // $('.docs').append('<a href="#" class="btn tag icon-btn-left skyblue remove_doc mb-2"><i class="ico-pdf me-2 fs-2"></i> ' + fileName + ' <i class="del ico-trash"></i></a><figure style="display:none"; imgname='+ fileName +' id="remove_image" class="remove_image"><img src=' + fileContents + '><button type="button" class="btn black-btn round-6 dt-delete"><i class="ico-trash"></i></button></figure>');
                        };
                    })(currFile);
                    reader.readAsDataURL(this.files[i]);
                    data.append('pics[]', currFile);
                    data.append('id',id);
                } else {
                    
                    // if(file_cnt != ''){
                    //     $('.photos_cnt').text(file_cnt);
                    // }else{
                    //     $('.photos_cnt').text('');
                    // }
                    
                    // Reset the file input and display an error message
                    // $('#imgPreview').attr('src', "{{ asset('/storage/images/banner_image/no-image.jpg') }}");
                    // $('.error').remove();
                    // $('.photo_img').after('<label class="error">Only PNG, JPEG, or JPG images are allowed for photos.</label>');
                }
                
            }
            if(data.has('pics[]')) {
                jQuery.ajax({
                    headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: "{{route('clients-documents')}}",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                    type: 'POST', // For jQuery < 1.9
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                title: "Client!",
                                text: "Client Documents Updated successfully.",
                                type: "success",
                            }).then((result) => {
                                var documentsCount = parseInt($('.documents_count').text());
                                var resultdoc = documentsCount + fileCount;
                                $('.documents_count').text(resultdoc);
                                // Bind links for each uploaded file
                                var files = inputElement.files; // Get selected files
                                for (var i = 0; i < files.length; i++) {
                                    var file = files[i];
                                    var fileName = file.name; // Get file name
                                    var formattedDate = formatDate(new Date()); // Format date (you may adjust this as needed)
                                    var clientId = response.client_id[i];
                                    // Create link element for the file
                                    var link = $('<a>').addClass('btn tag icon-btn-left skyblue mb-2').html('<span><i class="ico-pdf me-2 fs-2 align-middle"></i>' + fileName + '</span><span class="file-date">' + formattedDate + '</span><i class="del ico-trash remove_doc" ids="'+clientId+'"></i>');
                                    $('.client_docs').append(link);
                                }
                            });
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: response.message,
                                type: "error",
                            });
                        }
                    }
                });
            }
        });
        $(document).on('click','.services',function(e){
            $(this).parent().addClass('selected');
        })
        //remove document
        $(document).on('click', '.remove_doc', function (e) {
            e.preventDefault();
            $(this).parent().remove();
            var data = new FormData();
            var id = $('#id').val();
            var doc_id = $(this).attr('ids');
            data.append('id',id);
            data.append('doc_id',doc_id);
            jQuery.ajax({
                headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{route('clients-documents-remove')}}",
                data: data,
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                data: data,
                contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
                processData: false,
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Client!",
                            text: "Client Documents Deleted successfully.",
                            type: "success",
                        }).then((result) => {
                            var documentsCount = parseInt($('.documents_count').text());
                            var resultdoc = documentsCount - 1;
                            $('.documents_count').text(resultdoc);
                            // window.location = "{{url('clients')}}/" + id
                        });
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: response.message,
                            type: "error",
                        });
                    }
                }
            });
        });
        
        //upcoming appointment
        $(document).on('click', '.upcoming', function(e) {
            var client_id = $(this).attr('data-client-id');
            var clickedElement = $(this); // store a reference to the clicked element
            var conflict = $('.conflict_upcoming_appointment').prop('checked') ? '1' : '0';
            $.ajax({
                headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{ route('calendar.upcoming-appointment') }}",
                type: "POST",
                data: {'id': client_id, 'conflict': conflict},
                success: function(response) {
                    // Show a Sweet Alert message after the form is submitted.
                    if (response.success) {
                        // Remove existing div with class "user-appent"
                        $('.upcoming_appointments').empty();
                        $('.history_appointments').empty();
                        var app_div = `<div class="upcoming_appointments">
                            <div class="summry-header"><span class="ico-clock me-2 fs-4"></span> Upcoming appointments</div>
                            <div class="mb-3">
                                <label class="cst-check d-flex align-items-center">
                                    <input type="checkbox" class="conflict_upcoming_appointment" data-client-id= ${client_id} >
                                    <span class="checkmark me-2"></span>Only show appointments with conflicts
                                </label>
                            </div>`;

                        if (response.appointments.length > 0) {
                            // Append the new div after #clientDetails
                            $.each(response.appointments, function(index, appointment) {
                                var appointmentDetails = appointment.appointment_details.split(' ');
                                var boldDateTime = `<input type="hidden" id="service_id" value="${appointment.service_id}">
                                <input type="hidden" id="service_name" value="${appointment.service_name}">
                                <input type="hidden" id="category_id" value="${appointment.category_id}">
                                <input type="hidden" id="client_id" value="${appointment.id}">
                                <input type="hidden" id="client_name" value="${appointment.client_name}">
                                <input type="hidden" id="duration" value="${appointment.durations}"><b> ${appointmentDetails[0]}  ${appointmentDetails[1]} ${appointmentDetails[2]} </b>`; // Concatenate the date, time, and AM/PM together
                                var restOfDetails = appointmentDetails.slice(3).join(' '); // Joining the rest of the details without modification

                                // Adding buttons for rebook and go to
                                app_div += `<div class="recent-slot">
                                            <div class="status-check">
                                                ${boldDateTime}  ${restOfDetails} <span class="ico-danger fs-5"></span>
                                            </div>
                                            <p>
                                                <b> ${appointment.staff_locations} </b>
                                                (${appointment.durations} mins) - ${appointment.app_status}
                                            </p>
                                            <a href="#" class="btn btn-primary font-13 alter slot-btn btn-sm me-2 rebook_upcoming"> Rebook</a>
                                            <a href="#" class="btn btn-primary font-13 alter slot-btn btn-sm upcoming_go_to" date_time= "${appointmentDetails[0]} ${appointmentDetails[1]} ${appointmentDetails[2]}"> Go to</a>
                                        </div>`;
                            });
                        } else {
                            app_div += '<div class="user-appnt">No upcoming appointment found</div>';
                        }
                        // Append abc to the DOM after the loop is complete
                        $('#clientDetails').after(app_div);

                        // Set data-client-id attribute for the clicked element
                        clickedElement.attr('data-client-id', client_id);
                        $('.conflict_upcoming_appointment').prop('checked', response.conflict);
                    } else {
                        // Handle error case
                    }
                },
            });
        });

        //history appointment
        $(document).on('click', '.history', function(e) {
            var client_id = $(this).attr('data-client-id');
            var clickedElement = $(this); // store a reference to the clicked element
            var conflict = $('.conflict_history_appointment').prop('checked') ? '1' : '0';
            $.ajax({
                headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{ route('calendar.history-appointment') }}",
                type: "POST",
                data: {'id': client_id, 'conflict': conflict},
                success: function(response) {
                // Show a Sweet Alert message after the form is submitted.
                if (response.success) {
                    // Remove existing div with class "user-appent"
                    $('.upcoming_appointments').empty();
                    $('.history_appointments').empty();
                    var app_div = `<div class="history_appointments">
                        <div class="summry-header"><span class="ico-clock me-2 fs-4"></span> Recent appointments</div>
                        <div class="mb-3">
                            <label class="cst-check d-flex align-items-center">
                                <input type="checkbox" class="conflict_history_appointment" data-client-id= ${client_id} >
                                <span class="checkmark me-2"></span>Only show appointments with conflicts
                            </label>
                        </div>`;
                    if (response.appointments.length > 0) {
                        // Append the new div after #clientDetails
                        $.each(response.appointments, function(index, appointment) {
                            var appointmentDetails = appointment.appointment_details.split(' ');
                            var boldDateTime = `<input type="hidden" id="service_id" value="${appointment.service_id}">
                            <input type="hidden" id="service_name" value="${appointment.service_name}">
                            <input type="hidden" id="category_id" value="${appointment.category_id}">
                            <input type="hidden" id="client_id" value="${appointment.id}">
                            <input type="hidden" id="client_name" value="${appointment.client_name}">
                            <input type="hidden" id="duration" value="${appointment.durations}"><b> ${appointmentDetails[0]}  ${appointmentDetails[1]} ${appointmentDetails[2]} </b>`; // Concatenate the date, time, and AM/PM together
                            var restOfDetails = appointmentDetails.slice(3).join(' '); // Joining the rest of the details without modification

                            // Adding buttons for rebook and go to
                            app_div += `<div class="recent-slot">
                                            <div class="status-check">
                                                ${boldDateTime}  ${restOfDetails} <span class="ico-danger fs-5"></span>
                                            </div>
                                            <p>
                                                <b> ${appointment.staff_locations} </b>
                                                (${appointment.durations} mins) - ${appointment.app_status}
                                            </p>
                                            <a href="#" class="btn btn-primary font-13 alter slot-btn btn-sm me-2 rebook_histroy"> Rebook</a>
                                            <a href="#" class="btn btn-primary font-13 alter slot-btn btn-sm history_go_to" date_time= "${appointmentDetails[0]} ${appointmentDetails[1]} ${appointmentDetails[2]}"> Go to</a>
                                        </div>`;
                        });
                    }else{
                        app_div += '<div class="user-appnt">No history found</div>';
                    }
                    // Append abc to the DOM after the loop is complete
                    $('#clientDetails').after(app_div);
                    // Set data-client-id attribute for the clicked element
                    clickedElement.attr('data-client-id', client_id);
                    $('.conflict_history_appointment').prop('checked', response.conflict);
                } else {
                    // Handle error case
                }
            },
            });
        });
        $(document).on('click','.conflict_upcoming_appointment',function(e){
            var conflict = '1';
            $('.upcoming').trigger('click', [conflict]);
        })
        $(document).on('click','.conflict_history_appointment',function(e){
            var conflict = '1';
            $('.history').trigger('click', [conflict]);
        })

        $(document).on('click', '.waitlist_btn', function(e) {
            $('.main_calendar').hide();
            $('.searh_data').hide();
            $('#mycalendar').hide();
            $('.waitlist').show();
            $('.client_list_box').hide();
            $('#clientDetails').hide();
            $('.history_appointments').hide();
        })
        $(document).on('click', '.close_waitlist', function(e) {
            $('.main_calendar').show();
            $('.searh_data').show();
            $('#mycalendar').show();
            $('.waitlist').hide();
            $('.client_list_box').show();
            $('#clientDetails').show();
            $('.history_appointments').show();
        })
        $(document).on('click', '.show_notes', function(e) {
            e.preventDefault();
            var notesDiv = $(this).closest('li').find('.additional_notes');
            notesDiv.toggle(); // Toggle the visibility of notes
        });
        $(document).on('click', '.more-options-btn', function(e) {
            e.preventDefault();
            $(this).next('.more-options').toggle();
        });
        $(document).on('click', '.current_date_checked', function(e) {
            var isChecked = $(this).prop('checked') ? '1' : '0';
            
            $.ajax({
                headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{ route('calendar.filter-current-date') }}",
                method: 'GET',
                data: {'is_checked': isChecked},
                success: function (response) {
                    if (response.success) {

                        // Handle data or UI changes here based on response.data
                        console.log(response.data); // Example of handling data
                        // Assuming response.data is an array of objects containing the necessary data
                        
                        function formatDateToCustom(dateString) {
                            const monthsOfYear = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                            const date = new Date(dateString);
                            const dayOfWeek = date.toLocaleDateString('en', { weekday: 'short' });
                            const dayOfMonth = date.getDate();
                            const month = monthsOfYear[date.getMonth()];
                            return `${dayOfWeek} ${dayOfMonth} ${month}`;
                        }

                        function formatTimeElapsed(timestamp) {
                            const now = new Date();
                            const updatedTime = new Date(timestamp);
                            const timeDiffMs = now - updatedTime; // Time difference in milliseconds
                            const timeDiffHours = Math.floor(timeDiffMs / (1000 * 60 * 60)); // Convert milliseconds to hours
                            const timeDiffMinutes = Math.floor((timeDiffMs % (1000 * 60 * 60)) / (1000 * 60)); // Convert remaining milliseconds to minutes

                            if (timeDiffHours >= 1) {
                                return `${timeDiffHours} hours ago`;
                            } else {
                                return `${timeDiffMinutes} minutes ago`;
                            }
                        }

                        let htmlContent = `
                            <div class="waitlist" id="waitlist">
                                <div class="d-flex justify-content-between mb-3">
                                    <h5 class="mb-3">Waitlist</h5>
                                    <button class="btn-close close_waitlist"></button>
                                </div>
                                <div class="mb-3">
                                    <label class="cst-check d-flex align-items-center">
                                        <input type="checkbox" value="" class="current_date_checked">
                                        <span class="checkmark me-2"></span>Filter waitlist by current calendar date
                                    </label>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Staff</label>
                                    <select class="form-select form-control all_staffs" id="staffSelect">
                                        <option value="">All staff</option>`;
                                        htmlContent += `
                                    </select>
                                </div>

                                <div class="drag-box blue mb-3">
                                    <div class="head"><b>Drag and drop on</b> to a day on the appointment book
                                        <i class="ico-noun-arrow"></i>
                                    </div>
                                </div>

                                <ul class="drop-list light-green" id="waitlist-events">`;

                        response.data.forEach(item => {
                            console.log('item',item);
                            let formattedDate = formatDateToCustom(item.preferred_from_date); // Format date as desired
                            let formattedTimeElapsed = formatTimeElapsed(item.updated_at); // Format time elapsed
                            htmlContent += `
                                <li class="fc-event" data-app_id="${item.id}" data-client_id="${item.client_id}" data-category_id="${item.category_id}" data-duration="${item.duration}" data-service_name="${item.service_name}" data-service_id="${item.service_id}" data-client_name="${item.firstname+' '+item.lastname}">
                                    <div class="hist-strip">${formattedDate} <span><i class="ico-clock me-1 fs-5"></i>${formattedTimeElapsed}</span></div>
                                    <div class="client-name">
                                        <div class="drop-cap" style="background: #D0D0D0; color:#fff;">${item.firstname.charAt(0).toUpperCase()}</div>
                                        <div class="client-info"><h4 class="blue-bold" data-clientid="${item.client_id}">${item.firstname} ${item.lastname}</h4></div>
                                    </div>
                                    <div class="mb-2"><a href="#" class="river-bed"><b>${item.mobile_number}</b></a><br>
                                    <a href="#" class="river-bed"><b>${item.email}</b></a></div>
                                    <!-- Your other content -->
                                    ${item.service_name.map((service, index) => `
                                        <p>${service}</p>
                                        <p>${item.duration[index]} Mins with ${item.user_firstname ? item.user_firstname + ' ' + item.user_lastname : 'Anyone'}</p>
                                    `).join('')}
                                    <p class="additional_notes" style="display:none;">${item.additional_notes}</p>
                                    <div class="mt-2">
                                        <span class="dropdown show">
                                            <a class="btn btn-primary font-13 alter btn-sm slot-btn me-2 dropdown-toggle more-options-btn" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                More Options
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item edit-btn" href="javascript:void(0)" waitlist_id="${item.id}" client_id="${item.client_id}" category_id="${item.category_id}" duration="${item.duration}" service_name="${item.service_name}" services_id="${item.service_id}" preferred-from-date="${item.preferred_from_date}" user-id="${item.user_id}" preferred-to-date="${item.preferred_to_date}" additional-notes="${item.additional_notes}" client-name="${item.firstname+' '+item.lastname}" id="edit_waitlist_clients">Edit</a>
                                                <a class="dropdown-item delete-btn" href="#">Delete</a>
                                            </div>
                                        </span>
                                        ${item.additional_notes ? `<a href="#" class="btn btn-primary font-13 alter btn-sm slot-btn show_notes"> Show notes</a>` : `<a href="#" class="btn btn-primary font-13 alter btn-sm slot-btn show_notes" disabled style="color: darkgray;"> Show notes</a>`}
                                    </div>
                                </li>`;
                        });

                        htmlContent += `
                                </ul>
                            </div>
                        `;

                        // Update the .waitlist element with the generated HTML content
                        $('.waitlist').html(htmlContent);
                        wailtlistClientDraggable();
                        $('#waitlist-events').draggable();
                        $('#waitlist-events').removeAttr('style');

                        $('.current_date_checked').prop('checked', isChecked === '1');
                        let selectedStaff = response.staffs; // Assuming this is provided in your response
                        if (response.staffs && response.staffs.length > 0) {
                            response.staffs.forEach(function (name) {
                                let fullName = name.first_name + ' ' + name.last_name;
                                let id = name.id;
                                $('#staffSelect').append($('<option>', { value: id, text: fullName }));
                            });
                        }
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: "Failed to fetch data.",
                            type: "error",
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText); // Log the detailed error response
                    Swal.fire({
                        title: "Error!",
                        text: "Failed to fetch data. Check console for details.",
                        type: "error",
                    });
                }
            });
        });

        $(document).on('submit', '#create_walkin', function(e) {
            e.preventDefault();
            // Check if the form is valid
            if ($("#create_walkin").valid()) {
                var data = new FormData(this);
                
                $('#Walkin_Retail').modal('hide');
                $('#take_payment').modal('show');
                $('.payment_amount').val($('.take_payment').attr('main_total')); 
                $('.payment_total').text('$' + $('.take_payment').attr('main_total'));
                // SubmitWalkIn(data);
            }
        });

        $(document).on('change', '.all_staffs', function(e) {
            // Get the selected option value
            var selectedValue = $(this).val();
            
            // Get the selected option text
            var selectedText = $(this).find('option:selected').text();
            // Display selected option details (you can modify this as needed)
            console.log('Selected Value: ' + selectedValue);
            console.log('Selected Text: ' + selectedText);
            
            $.ajax({
                headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{ route('calendar.filter-staff') }}",
                method: 'GET',
                data: {'staff_id': selectedValue},
                success: function (response) {
                    if (response.success) {

                        // Handle data or UI changes here based on response.data
                        console.log(response.data); // Example of handling data
                        // Assuming response.data is an array of objects containing the necessary data
                        
                        function formatDateToCustom(dateString) {
                            const monthsOfYear = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                            const date = new Date(dateString);
                            const dayOfWeek = date.toLocaleDateString('en', { weekday: 'short' });
                            const dayOfMonth = date.getDate();
                            const month = monthsOfYear[date.getMonth()];
                            return `${dayOfWeek} ${dayOfMonth} ${month}`;
                        }

                        function formatTimeElapsed(timestamp) {
                            const now = new Date();
                            const updatedTime = new Date(timestamp);
                            const timeDiffMs = now - updatedTime; // Time difference in milliseconds
                            const timeDiffHours = Math.floor(timeDiffMs / (1000 * 60 * 60)); // Convert milliseconds to hours
                            const timeDiffMinutes = Math.floor((timeDiffMs % (1000 * 60 * 60)) / (1000 * 60)); // Convert remaining milliseconds to minutes

                            if (timeDiffHours >= 1) {
                                return `${timeDiffHours} hours ago`;
                            } else {
                                return `${timeDiffMinutes} minutes ago`;
                            }
                        }

                        let htmlContent = `
                            <div class="waitlist" id="waitlist">
                                <div class="d-flex justify-content-between mb-3">
                                    <h5 class="mb-3">Waitlist</h5>
                                    <button class="btn-close close_waitlist"></button>
                                </div>
                                <div class="mb-3">
                                    <label class="cst-check d-flex align-items-center">
                                        <input type="checkbox" value="" class="current_date_checked">
                                        <span class="checkmark me-2"></span>Filter waitlist by current calendar date
                                    </label>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Staff</label>
                                    <select class="form-select form-control all_staffs" id="staffSelect">
                                        <option value="">All staff</option>`;
                                        htmlContent += `
                                    </select>
                                </div>

                                <div class="drag-box blue mb-3">
                                    <div class="head"><b>Drag and drop on</b> to a day on the appointment book
                                        <i class="ico-noun-arrow"></i>
                                    </div>
                                </div>

                                <ul class="drop-list light-green" id="waitlist-events">`;
                        if(response.data.length > 0)
                        {
                            response.data.forEach(item => {
                                let formattedDate = formatDateToCustom(item.preferred_from_date); // Format date as desired
                                let formattedTimeElapsed = formatTimeElapsed(item.updated_at); // Format time elapsed
                                htmlContent += `
                                    <li class="fc-event" data-app_id="${item.id}" data-client_id="${item.client_id}" data-category_id="${item.category_id}" data-duration="${item.duration}" data-service_name="${item.service_name}" data-service_id="${item.service_id}" data-client_name="${item.firstname+' '+item.lastname}">
                                        <div class="hist-strip">${formattedDate} <span><i class="ico-clock me-1 fs-5"></i>${formattedTimeElapsed}</span></div>
                                        <div class="client-name">
                                            <div class="drop-cap" style="background: #D0D0D0; color:#fff;">${item.firstname.charAt(0).toUpperCase()}</div>
                                            <div class="client-info"><h4 class="blue-bold">${item.firstname} ${item.lastname}</h4></div>
                                        </div>
                                        <div class="mb-2"><a href="#" class="river-bed"><b>${item.mobile_number}</b></a><br>
                                        <a href="#" class="river-bed"><b>${item.email}</b></a></div>
                                        <!-- Your other content -->
                                        ${item.service_name.map((service, index) => `
                                            <p>${service}</p>
                                            <p>${item.duration[index]} Mins with ${item.user_firstname ? item.user_firstname + ' ' + item.user_lastname : 'Anyone'}</p>
                                        `).join('')}
                                        <p class="additional_notes" style="display:none;">${item.additional_notes}</p>
                                        <div class="mt-2">
                                            <span class="dropdown show">
                                                <a class="btn btn-primary font-13 alter btn-sm slot-btn me-2 dropdown-toggle more-options-btn" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    More Options
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    <a class="dropdown-item edit-btn" href="javascript:void(0)" waitlist_id="${item.id}" client_id="${item.client_id}" category_id="${item.category_id}" duration="${item.duration}" service_name="${item.service_name}" services_id="${item.service_id}" preferred-from-date="${item.preferred_from_date}" user-id="${item.user_id}" preferred-to-date="${item.preferred_to_date}" additional-notes="${item.additional_notes}" client-name="${item.firstname+' '+item.lastname}" id="edit_waitlist_clients" client-name="${item.firstname} ${item.lastname}">Edit</a>
                                                    <a class="dropdown-item delete-btn" href="#">Delete</a>
                                                </div>
                                            </span>
                                            ${item.additional_notes ? `<a href="#" class="btn btn-primary font-13 alter btn-sm slot-btn show_notes"> Show notes</a>` : `<a href="#" class="btn btn-primary font-13 alter btn-sm slot-btn show_notes" disabled  style="color: darkgray;"> Show notes</a>`}
                                        </div>
                                    </li>`;
                            });
                        }else{
                            htmlContent +=`<span>No data found</span>`;
                        }
                        

                        htmlContent += `
                                </ul>
                            </div>
                        `;

                        // Update the .waitlist element with the generated HTML content
                        $('.waitlist').html(htmlContent);
                        wailtlistClientDraggable();
                        $('#waitlist-events').draggable();
                        $('#waitlist-events').removeAttr('style');
                        
                        // $('.current_date_checked').prop('checked', isChecked === '1');
                        let selectedStaff = response.staffs; // Assuming this is provided in your response
                        if (response.staffs && response.staffs.length > 0) {
                            response.staffs.forEach(function (name) {
                                let fullName = name.first_name + ' ' + name.last_name;
                                let id = name.id;
                                $('#staffSelect').append($('<option>', { value: id, text: fullName }));
                            });
                        }
                        $('#staffSelect').empty();

                        if (response.staffs && response.staffs.length > 0) {
                            response.staffs.forEach(function (name) {
                                let fullName = name.first_name + ' ' + name.last_name;
                                let id = name.id;
                                $('#staffSelect').append($('<option>', { value: id, text: fullName }));
                            });
                        }

                        $('#staffSelect').val(selectedValue);
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: "Failed to fetch data.",
                            type: "error",
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText); // Log the detailed error response
                    Swal.fire({
                        title: "Error!",
                        text: "Failed to fetch data. Check console for details.",
                        type: "error",
                    });
                }
            });
        });
        
        //edit wait list client
        $(document).on('click', '#edit_waitlist_clients', function (e) {
            e.preventDefault();

            // Get the data attributes from the button
            var clientId = $(this).attr('client_id');
            var clientName = $(this).attr('client-name');
            var serviceId = $(this).attr('services_id');
            var serviceIdArray = serviceId.split(',');
            var categoryId = $(this).attr('category_id');
            var duration = $(this).attr('duration');
            var serviceTitle = $(this).attr('service_name');
            var serviceNameArray = serviceTitle.split(',');
            var app_date = $(this).attr('preferred-from-date');
            var app_time = $(this).attr('preferred-to-date');
            var staff_name = $(this).attr('staff_name');
            var staff_id = $(this).attr('user-id');
            var event_id = $(this).attr('event_id');
            var waitlist_id = $(this).attr('waitlist_id');
            $('#client_id').val(clientId);
            $('#user_id').val(staff_id);
            $('#waitlist_id').val(waitlist_id);
            // Set values in modal fields
            $('#latest_staff_id').val(staff_id);
            $('#latest_start_time').val(app_date);
            $('#latest_end_time').val(app_time);
            $('#event_id').val(event_id);
            $('#preferred_from_date').val(app_date);
            $('#preferred_to_date').val(app_time);
            $('#additional_notes').val($(this).attr('additional-notes'));

            // Trigger the modal to open
            $("#Edit_waitlist_client").modal('show');
            $('.clientWaitListEditModal').hide();
            $("#clientEditDetailsModal").html(`<i class='ico-user2 me-2 fs-6'></i>${clientName}`);

            $('#edit_waitlist_selected_services').empty();
            // Loop through each service item
            $('#waitlist_main_categories li').each(function(){
                let selected_cats = categoryId;
                var cat_id = $(this).find('.edit_waitlist_parent_category_id').attr('data-category_id');
                if (selected_cats.indexOf(cat_id) !== -1) {
                    $(this).addClass('selected'); // Add the 'selected' class to the <li> element
                }
            })
            $('.waitlist_sub_services li').each(function () {
                var serviceLi = $(this);
                var serviceDataId = serviceLi.find('a').data('services_id');
                var serviceDataCategoryId = serviceLi.find('a').data('category_id');
                var serviceDataDuration = serviceLi.find('a').data('duration');
                
                // Check if any service matches the selected services
                serviceNameArray.forEach(function (serviceName, index) {
                    console.log('1',serviceDataId,serviceDataCategoryId);
                    console.log('2',serviceDataCategoryId,categoryId)
                    console.log('3',serviceDataDuration,duration)
                    if (serviceDataId == serviceIdArray[index]) {
                        serviceLi.addClass('selected'); // Add 'selected' class to the matched service
                        // Append the selected service to the list in the modal
                        $("#edit_waitlist_selected_services").append(`<li class='selected remove' data-appointment_date="${app_date}" data-appointment_time="${app_time}" data-staff_name="${staff_name}" data-services_id="${serviceIdArray[index]}" data-category_id="${categoryId}" data-duration="${duration}"><a href='javascript:void(0);'>${serviceName}</a><span class='btn btn-cross cross-red remove_services'><i class='ico-close'></i></span></li>`);
                    }
                });
            });
        });
        $(document).on('click', '.delete_waitlist_client', function (e) {
            var appointmentId = $(this).attr('waitlist_id');
            var url = 'calender/delete-waitlist-client/' + appointmentId; // Corrected the URL construction

            if (confirm("Are you sure to delete this waitlist client?")) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data.success) {
                            Swal.fire({
                                title: "Waitlist Client!",
                                text: data.message,
                                icon: "success", // Changed 'info' to 'icon'
                            });
                            location.reload();
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: data.message,
                                icon: "error", // Changed 'info' to 'icon'
                            });
                        }
                    },
                    error: function (error) {
                        console.error('Error fetching resources:', error);
                    }
                });
            }
        });


    });

    //submit update client details form
    $(document).on('submit','#update_client_detail',function(e){
		e.preventDefault();
        var id=$('#id').val();
		var valid= $("#update_client_detail").validate();
			if(valid.errorList.length == 0){
            var data = $('#update_client_detail').serialize() ;
			SubmitUpdateClientDetails(data,id);
		}
	});

    //get all client details

    var client_details = [];
    // var product_details = [];
    var product_details = @json($productServiceJson);
    // var service_details = @json($services);

    // Assuming you have a function to trigger opening the modal with a specific client id
    // For example, if you have a button or link to open the modal, you can attach a click event handler to it
    $(document).on('click','.open-client-card-btn',function(e){
        var clientId = $(this).data('client-id'); // Use data('client-id') to access the attribute
        openClientCard(clientId);
    });
    $(document).on('click', '.remove_image', function (e) {
        
        e.preventDefault();
        $(this).parent().remove();
        var data = new FormData();
        var id = $('#id').val();
        var photo_id = $(this).attr('ids');
        data.append('id',id);
        data.append('photo_id',photo_id);

        jQuery.ajax({
            headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: "{{route('clients-photos-remove')}}",
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            data: data,
            contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
            processData: false,
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        title: "Client!",
                        text: "Client Photo Deleted successfully.",
                        type: "success",
                    }).then((result) => {
                        var phtcnt = parseInt($('.photos_count').text());
                        var resultdoc = phtcnt - 1;
                        $('.photos_count').text(resultdoc);
                        // window.location = "{{url('clients')}}/" + id
                    });
                } else {
                    
                    Swal.fire({
                        title: "Error!",
                        text: response.message,
                        type: "error",
                    });
                }
            }
        });
        return false;
    });

    $(document).on('click','#edit_appointment', function(e){
        e.preventDefault();
        // Get the data attributes from the button
        var clientId = $(this).attr('client-id')
        var clientName = $(this).attr('client-name');
        var serviceId = $(this).attr('services_id');
        var categoryId = $(this).attr('category_id');
        var duration = $(this).attr('duration');
        var serviceTitle = $(this).attr('service_name');
        var app_date = $(this).attr('appointment_date');
        var app_time = $(this).attr('appointment_time');
        var staff_name = $(this).attr('staff_name');
        var staff_id = $(this).attr('staff_id');
        var event_id = $(this).attr('event_id');
        $('#latest_staff_id').val(staff_id);
        $('#latest_start_time').val(app_date);
        $('#latest_end_time').val(app_time);
        $('#event_id').val(event_id);
        // Use the clientId and clientName as needed
        console.log("Client ID:", clientId);
        console.log("Client Name:", staff_id);
        // Trigger the modal to open
        $('#Edit_appointment').modal('show');
        $('.clientEditModal').hide();
        $("#clienteditDetailsModal").html(`<i class='ico-user2 me-2 fs-6'></i>  ${clientName}`);
        $('#edit_selected_services').empty();
        // Loop through each service item
        $('#edit_main_categories li').each(function(){
            let selected_cats = categoryId;
            // alert(selected_cats);
            var cat_id = $(this).find('.edit_parent_category_id').attr('data-category_id');
            if (selected_cats.indexOf(cat_id) !== -1) {
                $(this).addClass('selected'); // Add the 'selected' class to the <li> element
            }
        })
        
        $('.edit_sub_services li').each(function () {
            var serviceLi = $(this);
            var serviceDataId = serviceLi.find('a').data('services_id');
            var serviceDataCategoryId = serviceLi.find('a').data('category_id');
            var serviceDataDuration = serviceLi.find('a').data('duration');
            // Check if the service matches the selected service
            if (serviceDataId == serviceId && serviceDataCategoryId == categoryId && serviceDataDuration == duration) {
                serviceLi.addClass('selected'); // Add 'selected' class to the matched service
            }
        });

        $("#edit_selected_services").append(`<li class='selected remove' test="1" data-appointment_date= "${app_date}"  data-appointment_time= "${app_time}" data-staff_name= "${staff_name}" data-services_id= ${serviceId}  data-category_id= ${categoryId}  data-duration='${duration}'><a href='javascript:void(0);' > ${serviceTitle} </a><span class='btn btn-cross cross-red remove_services'><i class='ico-close'></i></span></li>`);
    });
    $(document).on('click','#edit_created_appointment', function(e){
        e.preventDefault();
        console.log('start');
        $('#edit_selected_services').empty();
        $('.summry-header').hide();
        $(this).parent().parent().find('.treatment').each(function() {
            console.log('start_1',$(this));
            // Your code to operate on each '.treatment' element goes here
            // You can access each '.treatment' element using $(this) inside this function
            var serviceId = $(this).data('service_id');
            // var serviceName = $(this).data('service_name');
            console.log('serviceId',serviceId);
            var categoryId = $(this).data('category_id');
            var duration = $(this).data('duration');
            var serviceTitle = $(this).data('service_name');

            // Loop through each service item
            $('.edit_sub_services li').each(function () {
                var serviceLi = $(this);
                var serviceDataId = serviceLi.find('a').data('services_id');
                var serviceDataCategoryId = serviceLi.find('a').data('category_id');
                var serviceDataDuration = serviceLi.find('a').data('duration');
                // Check if the service matches the selected service
                if (serviceDataId == serviceId && serviceDataCategoryId == categoryId && serviceDataDuration == duration) {
                    serviceLi.addClass('selected'); // Add 'selected' class to the matched service
                }
            });
            // Appending a list item to #edit_selected_services
            $("#edit_selected_services").append(`
                <li class='selected remove' data-services_id='${serviceId}' data-services_name='${serviceTitle}'  data-category_id='${categoryId}' data-duration='${duration}'>
                    <a href='javascript:void(0);'>${serviceTitle}</a>
                    <span class='btn btn-cross cross-red remove_services'><i class='ico-close'></i></span>
                </li>
            `);
        });

        // Get the data attributes from the button
        var clientName = $(this).attr('client-name');
        // Trigger the modal to open
        $('#Edit_appointment').modal('show');
        $('.clientEditModal').hide();
        $("#clienteditDetailsModal").html(`<i class='ico-user2 me-2 fs-6'></i>  ${clientName}`);
        // Add hidden fields dynamically to the modal
        $('#Edit_appointment').find('.modal-body').append(`
            <input type="hidden" name="is_app_created" id="is_app_created" value="1">
        `);
    });
    $(document).on('click','.add_discount',function(e){
        $('.main_walkin .nav-item:visible').each(function() {
            // Check if the current nav-item is active (visible)
            if ($(this).find('a.nav-link').hasClass('active')) {
                var link = $(this).find('a.nav-link');
                if (link.hasClass('casual_cus')) {
                    $('#discount_customer_type').val('casual');
                } else if (link.hasClass('new_cus')) {
                    $('#discount_customer_type').val('new');
                } else {
                    $('#discount_customer_type').val('existing');
                }
                return false; // Exit the loop once we find the active nav-item
            }
        });
        
        $('.main_discount').show();
        $('.main_walk_in').hide();

        if($(this).text() == 'Edit discount / surcharge')
        {
            $('#main_discount').find('h4').text('Edit discount / surcharge')
            $('#hdn_amt').val($('#amount').val());
            $('#hdn_dis_type').val($('input[name="discount_type"]:checked').val());
            // $('.main_walk_in').find('.add_discount').each(function() {
                // Update the HTML content of the element
                // $(this).html('<i class="ico-percentage me-2 fs-5"></i>Edit discount / surcharge');

                // Your additional code logic here for each element with the class 'add_discount'
            // });   
        }
    });
    $(document).on('click','.cancel_discount',function(e){
        $('.main_discount').hide();
        $('.main_walk_in').show();
        $('#discount_surcharge').val($('#hdn_discount_surcharge').val());
        // $('#discount_surcharge').val($('#discount_surcharge').val());
        $('#amount').prop('disabled', false);
        $('#discount_type').prop('disabled', false);
        $('#percent_type').prop('disabled', false);
        $('#reason').prop('disabled', false);
        $('.discount-row').show();
        $('#reason').val('');
        var type = $('#discount_customer_type').val();

        //cancel 
        if($('#main_discount').find('h4').text() != 'Edit discount / surcharge')
        {
            $('#amount').val(0);
        }
        else
        {
            $('#amount').val($('#hdn_amt').val());
            var hd = $('#hdn_dis_type').val();
            $('input[name="discount_type"][value="' + hd + '"]').prop('checked', true);
        }
        updateSubtotalAndTotal(type);
    })
    $(document).on('click','.cancel_product',function(e){
        // $('.main_product').hide();
        $('.edit_product').hide();
        $('.main_walk_in').show();
    })
    $(document).on('click','.update_product',function(e){
        // $('.main_product').hide();
        $('.edit_product').hide();
        $('.main_walk_in').show();
        
        // Retrieve the product details
        var productInfo = $('.modal-body');

        // Update the product price in the productDetail div
        var pricePerUnit = parseFloat(productInfo.find('.edit_price_per_unit').val());
        var quantity = parseInt(productInfo.find('.edit_quantity').val());
        var productPrice = pricePerUnit * quantity;
        $('.productDetail .edit_product_price').text('$' + productPrice.toFixed(2));
        var cus_type = $('#customer_type').val();
        var edit_prod_id = $('#edit_product_id').val();
        $('.invo-notice').each(function(index, element) {
            if($(this).attr('prod_id') == edit_prod_id)
            {
                $(this).find('.inv-number').find('b').text($('.edit_product_price').text());
                $(this).find('.inv-left').find('.dis').text('(' + $('#dynamic_discount').text() + ')');
                $(this).find('.quantity').val($('.edit_product_quantity').text());

                $(this).find('#product_price').val($('.edit_price_per_unit').val()); 
                var productPrice = $(this).find('#product_price').val() // Get the text content of edit_product_price
                var priceWithoutDollar = productPrice.replace('$', ''); // Remove the dollar sign
                $(this).find('.product-name').attr('product_price', priceWithoutDollar); // Set the product_price attribute
                $(this).find('#hdn_discount_surcharge').val($('#edit_discount_surcharge').val());
                $(this).find('#hdn_discount_amount').val($('#edit_amount').val());
                $(this).find('#discount_types').val($('input[name="edit_discount_type"]:checked').val());
                $(this).find('#hdn_reason').val($('#edit_reason').val());
                $(this).find('.who_did_work').text('Sold by '+ $('#edit_sale_staff_id option:selected').text());
                $(this).find('#hdn_who_did_work').val($('#edit_sale_staff_id').val());
                $(this).find('#hdn_edit_amount').val($('#edit_amount').val());
                
                updateSubtotalAndTotal(cus_type); // Update Subtotal and Total
            }
        });
        $('#notes').append('\n' + $('#edit_reason').val() + ' - ' + '$'+$('#edit_amount').val() + ' on ' + $('.edit_product_name').text() + '\n');
    })
    $(document).on('click','.update_discount',function(e){

        $('.main_discount').hide();
        $('.main_walk_in').show();

        // $('#hdn_discount_surcharge').val($('#discount_surcharge').val());
        $('.main_walk_in').find('.add_discount').each(function() {
            // Update the HTML content of the element
            $(this).html('<i class="ico-percentage me-2 fs-5"></i>Edit discount / surcharge');

            // Your additional code logic here for each element with the class 'add_discount'
        });

        var amt_type_note = $('input[name="discount_type"]:checked').val();
        if(amt_type_note == 'amount')
        {
            $('#notes').text($('#reason').val() + ' - ' + '$'+$('#amount').val() + ' applied to invoice.' );
        }else{
            $('#notes').text($('#reason').val() + ' - ' +$('#amount').val()+'%' + ' applied to invoice.');
        }
        $('#hdn_main_discount_surcharge').val($('#discount_surcharge').val());
        $('#hdn_main_discount_type').val($('input[name="discount_type"]:checked').val());
        $('#hdn_main_discount_amount').val($('#amount').val());
        $('#hdn_main_discount_reason').val($('#reason').val());
    })
    $(document).on('click', '.c_minus', function(e) {
        var type = "casual";
        var $currentDiv = $(this).closest('.product-info1'); // Reference to the current div
        var $input = $currentDiv.find('input.quantity');
        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);

        var chk_dis_type = $(this).parent().parent().parent().find('#discount_types').val();

        var main_price = parseFloat($currentDiv.find('#product_price').val());
        var price_amt;
        
        if (chk_dis_type == 'percent') {
            if($(this).parent().parent().parent().find('.inv-left').find('.dis').text() == '')
            {
                var discount = 0;
                price_amt = main_price - (main_price * (discount / 100));
            }
            else
            {
                var discount = parseFloat($(this).parent().parent().parent().find('#hdn_discount_amount').val());
                if($(this).parent().parent().parent().find('#hdn_discount_surcharge').val() == 'Credit Card Surcharge' || $(this).parent().parent().parent().find('#hdn_discount_surcharge').val() == 'Manual Surcharge')
                {
                    price_amt = main_price + (main_price * (discount / 100));
                }
                else
                {
                    price_amt = main_price - (main_price * (discount / 100));
                }
            }
            
        } else {
            if($(this).parent().parent().parent().find('.inv-left').find('.dis').text() == '')
            {
                price_amt = parseFloat(main_price);
            }else{
                if($(this).parent().parent().parent().find('#hdn_discount_surcharge').val() == 'Manual Surcharge')
                {
                    price_amt = parseFloat(main_price) + parseFloat($(this).parent().parent().parent().find('#hdn_discount_amount').val());
                }else{
                    price_amt = parseFloat(main_price) - parseFloat($(this).parent().parent().parent().find('#hdn_discount_amount').val());
                }
            }
        }

        var price_mul = price_amt * parseInt($input.val());
        $currentDiv.find('.inv-number b').text('$' + price_mul);
        // $(this).parent().parent().parent().find('.product-name').attr('product_price',price_amt);
        $input.change();
        
        var textValue = $(this).parent().parent().parent().find('.dis').text();

        // Extract the number from the text using regular expressions
        var regex = /\$([\d.]+)/;
        var match = textValue.match(regex);

        if (match && match.length > 1) {
            // Extracted number from the text
            var discountAmount = parseFloat(match[1]);
            
            // Calculate half of the discount amount
            if(chk_dis_type =='percent')
            {
                var editAmountValue = $(this).parent().parent().parent().find('#hdn_discount_amount').val();
                var parsedEditAmount = editAmountValue !== "" ? parseFloat(editAmountValue) : 0;

                var discount = (parseFloat(main_price) * parsedEditAmount) / 100;
                var newDiscountAmount = discountAmount - discount;
            }else{
                var editAmountValue = $(this).parent().parent().parent().find('#hdn_discount_amount').val();
                var parsedEditAmount = editAmountValue !== "" ? parseFloat(editAmountValue) : 0;

                var newDiscountAmount = discountAmount - parsedEditAmount;
            }
            // var final = discountAmount - newDiscountAmount;

            newDiscountAmount = Math.max(newDiscountAmount, 0);
            // Replace the text with the new discount amount
            // $(".dis").text("( Discount: $" + newDiscountAmount.toFixed(2) + ")");
            // $('#dynamic_discount').text(' Discount: $' + newDiscountAmount.toFixed(2));

            // $(".dis").text("( Discount: $" + newDiscountAmount.toFixed(2) + ")");
            // Inside the click event handler for c_minus and c_plus
            $currentDiv.find('.dis').text("( Discount: $" + newDiscountAmount.toFixed(2) + ")");
            $('#dynamic_discount').text(' Discount: $' + newDiscountAmount.toFixed(2));
        }

        updateSubtotalAndTotal(type);
        return false;
    });

    $(document).on('click', '.c_plus', function(e) {
        var type = "casual";
        var $currentDiv = $(this).closest('.product-info1'); // Reference to the current div
        var $input = $currentDiv.find('input.quantity');
        $input.val(parseInt($input.val()) + 1);

        var chk_dis_type = $(this).parent().parent().parent().find('#discount_types').val();

        var main_price = parseFloat($currentDiv.find('#product_price').val());
        var price_amt;

        if (chk_dis_type == 'percent') {
            if($(this).parent().parent().parent().find('.inv-left').find('.dis').text() == '')
            {
                var discount = 0;
                price_amt = main_price - (main_price * (discount / 100));
            }
            else
            {
                var discount = parseFloat($(this).parent().parent().parent().find('#hdn_discount_amount').val());
                if($(this).parent().parent().parent().find('#hdn_discount_surcharge').val() == 'Credit Card Surcharge' || $(this).parent().parent().parent().find('#hdn_discount_surcharge').val() == 'Manual Surcharge')
                {
                    var discount = parseFloat($(this).parent().parent().parent().find('#hdn_discount_amount').val());
                    price_amt = main_price + (main_price * (discount / 100));
                }
                else
                {
                    var discount = parseFloat($(this).parent().parent().parent().find('#hdn_discount_amount').val());
                    price_amt = main_price - (main_price * (discount / 100));
                }
            }
            
        } else {
            if($(this).parent().parent().parent().find('.inv-left').find('.dis').text() == '')
            {
                price_amt = parseFloat(main_price);
            }else{
                if($(this).parent().parent().parent().find('#hdn_discount_surcharge').val() == 'Manual Surcharge')
                {
                    price_amt = parseFloat(main_price) + parseFloat($(this).parent().parent().parent().find('#hdn_discount_amount').val());
                }else{
                    price_amt = parseFloat(main_price) - parseFloat($(this).parent().parent().parent().find('#hdn_discount_amount').val());
                }
            }
        }

        var price_mul = price_amt * parseInt($input.val());
        $currentDiv.find('.inv-number b').text('$' + price_mul);
        $input.change();
        var textValue = $currentDiv.find('.dis').text();

        // Extract the number from the text using regular expressions
        var regex = /\$([\d.]+)/;
        var match = textValue.match(regex);

        if (match && match.length > 1) {
            // Extracted number from the text
            var discountAmount = parseFloat(match[1]);

            // Calculate the new discount amount based on the discount type
            var newDiscountAmount;
            if(chk_dis_type =='percent')
            {
                var editAmountValue = $(this).parent().parent().parent().find('#hdn_discount_amount').val();
                var parsedEditAmount = editAmountValue !== "" ? parseFloat(editAmountValue) : 0;

                var discount = (parseFloat(main_price) * parsedEditAmount) / 100;
                var newDiscountAmount = discountAmount + discount;
            }else{
                var editAmountValue = $(this).parent().parent().parent().find('#hdn_discount_amount').val();
                var parsedEditAmount = editAmountValue !== "" ? parseFloat(editAmountValue) : 0;
                
                var newDiscountAmount = discountAmount + parsedEditAmount;
            }
            newDiscountAmount = Math.max(newDiscountAmount, 0);

            // Update the displayed discount value
            $currentDiv.find('.dis').text("( Discount: $" + newDiscountAmount.toFixed(2) + ")");
            $('#dynamic_discount').text(' Discount: $' + newDiscountAmount.toFixed(2));
        }
        updateSubtotalAndTotal(type);
        return false;
    });

    $(document).on('click', '.n_minus', function(e) {
        var type="new";
        var $currentDiv = $(this).closest('.product-info2'); // Reference to the current div
        var $input = $currentDiv.find('input.quantity');
        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);

        var chk_dis_type = $(this).parent().parent().parent().find('#discount_types').val();

        var main_price = parseFloat($currentDiv.find('#product_price').val());
        var price_amt;
        
        if (chk_dis_type == 'percent') {
            if($(this).parent().parent().parent().find('.inv-left').find('.dis').text() == '')
            {
                var discount = 0;
                price_amt = main_price - (main_price * (discount / 100));
            }
            else
            {
                var discount = parseFloat($(this).parent().parent().parent().find('#hdn_discount_amount').val());
                if($(this).parent().parent().parent().find('#hdn_discount_surcharge').val() == 'Credit Card Surcharge' || $(this).parent().parent().parent().find('#hdn_discount_surcharge').val() == 'Manual Surcharge')
                {
                    price_amt = main_price + (main_price * (discount / 100));
                }
                else
                {
                    price_amt = main_price - (main_price * (discount / 100));
                }
            }
            
        } else {
            if($(this).parent().parent().parent().find('.inv-left').find('.dis').text() == '')
            {
                price_amt = parseFloat(main_price);
            }else{
                if($(this).parent().parent().parent().find('#hdn_discount_surcharge').val() == 'Manual Surcharge')
                {
                    price_amt = parseFloat(main_price) + parseFloat($(this).parent().parent().parent().find('#hdn_discount_amount').val());
                }else{
                    price_amt = parseFloat(main_price) - parseFloat($(this).parent().parent().parent().find('#hdn_discount_amount').val());
                }
            }
        }

        var price_mul = price_amt * parseInt($input.val());
        $currentDiv.find('.inv-number b').text('$' + price_mul);

        $input.change();
        var textValue = $(this).parent().parent().parent().find('.dis').text();

        // Extract the number from the text using regular expressions
        var regex = /\$([\d.]+)/;
        var match = textValue.match(regex);

        if (match && match.length > 1) {
            // Extracted number from the text
            var discountAmount = parseFloat(match[1]);
            
            // Calculate half of the discount amount
            if(chk_dis_type =='percent')
            {
                var editAmountValue = $(this).parent().parent().parent().find('#hdn_discount_amount').val();
                var parsedEditAmount = editAmountValue !== "" ? parseFloat(editAmountValue) : 0;

                var discount = (parseFloat(main_price) * parsedEditAmount) / 100;
                var newDiscountAmount = discountAmount - discount;
            }else{
                var editAmountValue = $(this).parent().parent().parent().find('#hdn_discount_amount').val();
                var parsedEditAmount = editAmountValue !== "" ? parseFloat(editAmountValue) : 0;

                var newDiscountAmount = discountAmount - parsedEditAmount;
            }
            newDiscountAmount = Math.max(newDiscountAmount, 0);

            // Replace the text with the new discount amount
            // $(".dis").text("( Discount: $" + newDiscountAmount.toFixed(2) + ")");
            // $('#dynamic_discount').text(' Discount: $' + newDiscountAmount.toFixed(2));

            $currentDiv.find('.dis').text("( Discount: $" + newDiscountAmount.toFixed(2) + ")");
            $('#dynamic_discount').text(' Discount: $' + newDiscountAmount.toFixed(2));
        }
        updateSubtotalAndTotal(type);
        return false;
    });

    $(document).on('click', '.n_plus', function(e) {
        var type="new";
        var $currentDiv = $(this).closest('.product-info2'); // Reference to the current div
        var $input = $currentDiv.find('input.quantity');
        $input.val(parseInt($input.val()) + 1);

        var chk_dis_type = $(this).parent().parent().parent().find('#discount_types').val();

        var main_price = parseFloat($currentDiv.find('#product_price').val());
        var price_amt;

        if (chk_dis_type == 'percent') {
            if($(this).parent().parent().parent().find('.inv-left').find('.dis').text() == '')
            {
                var discount = 0;
                price_amt = main_price - (main_price * (discount / 100));
            }
            else
            {
                var discount = parseFloat($(this).parent().parent().parent().find('#hdn_discount_amount').val());
                if($(this).parent().parent().parent().find('#hdn_discount_surcharge').val() == 'Credit Card Surcharge' || $(this).parent().parent().parent().find('#hdn_discount_surcharge').val() == 'Manual Surcharge')
                {
                    var discount = parseFloat($(this).parent().parent().parent().find('#hdn_discount_amount').val());
                    price_amt = main_price + (main_price * (discount / 100));
                }
                else
                {
                    var discount = parseFloat($(this).parent().parent().parent().find('#hdn_discount_amount').val());
                    price_amt = main_price - (main_price * (discount / 100));
                }
            }
            
        } else {
            if($(this).parent().parent().parent().find('.inv-left').find('.dis').text() == '')
            {
                price_amt = parseFloat(main_price);
            }else{
                if($(this).parent().parent().parent().find('#hdn_discount_surcharge').val() == 'Manual Surcharge')
                {
                    price_amt = parseFloat(main_price) + parseFloat($(this).parent().parent().parent().find('#hdn_discount_amount').val());
                }else{
                    price_amt = parseFloat(main_price) - parseFloat($(this).parent().parent().parent().find('#hdn_discount_amount').val());
                }
            }
        }

        var price_mul = price_amt * parseInt($input.val());
        $currentDiv.find('.inv-number b').text('$' + price_mul);

        $input.change();
        var textValue = $(this).parent().parent().parent().find('.dis').text();

        // Extract the number from the text using regular expressions
        var regex = /\$([\d.]+)/;
        var match = textValue.match(regex);

        if (match && match.length > 1) {
            // Extracted number from the text
            var discountAmount = parseFloat(match[1]);
            
            // Calculate half of the discount amount
            if(chk_dis_type =='percent')
            {
                var editAmountValue = $(this).parent().parent().parent().find('#hdn_discount_amount').val();
                var parsedEditAmount = editAmountValue !== "" ? parseFloat(editAmountValue) : 0;

                var discount = (parseFloat(main_price) * parsedEditAmount) / 100;
                var newDiscountAmount = discountAmount + discount;
            }else{
                var editAmountValue = $(this).parent().parent().parent().find('#hdn_discount_amount').val();
                var parsedEditAmount = editAmountValue !== "" ? parseFloat(editAmountValue) : 0;
                
                var newDiscountAmount = discountAmount + parsedEditAmount;
            }
            // var final = discountAmount - newDiscountAmount;

            newDiscountAmount = Math.max(newDiscountAmount, 0);
            $currentDiv.find('.dis').text("( Discount: $" + newDiscountAmount.toFixed(2) + ")");
            $('#dynamic_discount').text(' Discount: $' + newDiscountAmount.toFixed(2));
        }
        updateSubtotalAndTotal(type);
        return false;
    });

    $(document).on('click', '.e_minus', function(e) {
        var type = "existing";
        var $currentDiv = $(this).closest('.product-info3'); // Reference to the current div
        var $input = $currentDiv.find('input.quantity');
        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);

        var chk_dis_type = $(this).parent().parent().parent().find('#discount_types').val();

        var main_price = parseFloat($currentDiv.find('#product_price').val());
        var price_amt;
        
        if (chk_dis_type == 'percent') {
            if($(this).parent().parent().parent().find('.inv-left').find('.dis').text() == '')
            {
                var discount = 0;
                price_amt = main_price - (main_price * (discount / 100));
            }
            else
            {
                var discount = parseFloat($(this).parent().parent().parent().find('#hdn_discount_amount').val());
                if($(this).parent().parent().parent().find('#hdn_discount_surcharge').val() == 'Credit Card Surcharge' || $(this).parent().parent().parent().find('#hdn_discount_surcharge').val() == 'Manual Surcharge')
                {
                    price_amt = main_price + (main_price * (discount / 100));
                }
                else
                {
                    price_amt = main_price - (main_price * (discount / 100));
                }
            }
            
        } else {
            if($(this).parent().parent().parent().find('.inv-left').find('.dis').text() == '')
            {
                price_amt = parseFloat(main_price);
            }else{
                if($(this).parent().parent().parent().find('#hdn_discount_surcharge').val() == 'Manual Surcharge')
                {
                    price_amt = parseFloat(main_price) + parseFloat($(this).parent().parent().parent().find('#hdn_discount_amount').val());
                }else{
                    price_amt = parseFloat(main_price) - parseFloat($(this).parent().parent().parent().find('#hdn_discount_amount').val());
                }
            }
        }

        var price_mul = price_amt * parseInt($input.val());
        $currentDiv.find('.inv-number b').text('$' + price_mul);
        
        $input.change();
        var textValue = $(this).parent().parent().parent().find('.dis').text();

        // Extract the number from the text using regular expressions
        var regex = /\$([\d.]+)/;
        var match = textValue.match(regex);

        if (match && match.length > 1) {
            // Extracted number from the text
            var discountAmount = parseFloat(match[1]);
            
            if(chk_dis_type =='percent')
            {
                var editAmountValue = $(this).parent().parent().parent().find('#hdn_discount_amount').val();
                var parsedEditAmount = editAmountValue !== "" ? parseFloat(editAmountValue) : 0;

                var discount = (parseFloat(main_price) * parsedEditAmount) / 100;
                var newDiscountAmount = discountAmount - discount;
            }else{
                var editAmountValue = $(this).parent().parent().parent().find('#hdn_discount_amount').val();
                var parsedEditAmount = editAmountValue !== "" ? parseFloat(editAmountValue) : 0;

                var newDiscountAmount = discountAmount - parsedEditAmount;
            }
            // var final = discountAmount - newDiscountAmount;

            newDiscountAmount = Math.max(newDiscountAmount, 0);

            // Replace the text with the new discount amount
            // $(".dis").text("( Discount: $" + newDiscountAmount.toFixed(2) + ")");
            // $('#dynamic_discount').text(' Discount: $' + newDiscountAmount.toFixed(2));

            $currentDiv.find('.dis').text("( Discount: $" + newDiscountAmount.toFixed(2) + ")");
            $('#dynamic_discount').text(' Discount: $' + newDiscountAmount.toFixed(2));
        }
        updateSubtotalAndTotal(type);
        return false;
    });

    $(document).on('click', '.e_plus', function(e) {
        var type = "existing";
        var $currentDiv = $(this).closest('.product-info3'); // Reference to the current div
        var $input = $currentDiv.find('input.quantity');
        $input.val(parseInt($input.val()) + 1);

        var chk_dis_type = $(this).parent().parent().parent().find('#discount_types').val();

        var main_price = parseFloat($currentDiv.find('#product_price').val());
        var price_amt;

        if (chk_dis_type == 'percent') {
            if($(this).parent().parent().parent().find('.inv-left').find('.dis').text() == '')
            {
                var discount = 0;
                price_amt = main_price - (main_price * (discount / 100));
            }
            else
            {
                var discount = parseFloat($(this).parent().parent().parent().find('#hdn_discount_amount').val());
                if($(this).parent().parent().parent().find('#hdn_discount_surcharge').val() == 'Credit Card Surcharge' || $(this).parent().parent().parent().find('#hdn_discount_surcharge').val() == 'Manual Surcharge')
                {
                    var discount = parseFloat($(this).parent().parent().parent().find('#hdn_discount_amount').val());
                    price_amt = main_price + (main_price * (discount / 100));
                }
                else
                {
                    var discount = parseFloat($(this).parent().parent().parent().find('#hdn_discount_amount').val());
                    price_amt = main_price - (main_price * (discount / 100));
                }
            }
            
        } else {
            if($(this).parent().parent().parent().find('.inv-left').find('.dis').text() == '')
            {
                price_amt = parseFloat(main_price);
            }else{

                if($(this).parent().parent().parent().find('#hdn_discount_surcharge').val() == 'Manual Surcharge')
                {
                    price_amt = parseFloat(main_price) + parseFloat($(this).parent().parent().parent().find('#hdn_discount_amount').val());
                }else{
                    price_amt = parseFloat(main_price) - parseFloat($(this).parent().parent().parent().find('#hdn_discount_amount').val());
                }
                
            }
        }

        var price_mul = price_amt * parseInt($input.val());
        $currentDiv.find('.inv-number b').text('$' + price_mul);

        $input.change();
        var textValue = $(this).parent().parent().parent().find('.dis').text();

        // Extract the number from the text using regular expressions
        var regex = /\$([\d.]+)/;
        var match = textValue.match(regex);

        if (match && match.length > 1) {
            // Extracted number from the text
            var discountAmount = parseFloat(match[1]);
            
            // Calculate half of the discount amount
            if(chk_dis_type =='percent')
            {
                var editAmountValue = $(this).parent().parent().parent().find('#hdn_discount_amount').val();
                var parsedEditAmount = editAmountValue !== "" ? parseFloat(editAmountValue) : 0;

                var discount = (parseFloat(main_price) * parsedEditAmount) / 100;
                var newDiscountAmount = discountAmount + discount;
            }else{
                var editAmountValue = $(this).parent().parent().parent().find('#hdn_discount_amount').val();
                var parsedEditAmount = editAmountValue !== "" ? parseFloat(editAmountValue) : 0;
                
                var newDiscountAmount = discountAmount + parsedEditAmount;
            }
            // var final = discountAmount - newDiscountAmount;

            newDiscountAmount = Math.max(newDiscountAmount, 0);

            $currentDiv.find('.dis').text("( Discount: $" + newDiscountAmount.toFixed(2) + ")");
            $('#dynamic_discount').text(' Discount: $' + newDiscountAmount.toFixed(2));
        }
        updateSubtotalAndTotal(type);
        return false;
    });
    $(document).on('click', '.minus', function() {
        // Decrement quantity if greater than 1
        var quantityInput = $('.edit_quantity');
        var currentQuantity = parseInt(quantityInput.val());
        if (currentQuantity > 1) {
            quantityInput.val(currentQuantity - 1);
            $('.edit_product_quantity').text(currentQuantity - 1);
            calculateAndUpdate(); // Update total and recalculate
        }
    });

    $(document).on('click', '.plus', function() {
        // Increment quantity
        var quantityInput = $('.edit_quantity');
        var currentQuantity = parseInt(quantityInput.val());
        quantityInput.val(currentQuantity + 1);
        $('.edit_product_quantity').text(currentQuantity + 1);
        calculateAndUpdate(); // Update total and recalculate
    });


    $(document).on('click', '.casual_cus', function(e) {
        e.preventDefault(); // Prevent default link behavior
        $('#hdn_customer_type').val('casual');
        $('#customer_type').val('casual');
        $("#casual_customer").load(location.href + " #casual_customer");
        $('.add_dis').find('.subtotal').text('$0.00');
        $('.add_dis').find('.discount').text('$0.00');
        $('.add_dis').find('.total').text('$0.00');
        $('#amount').val(0);
        $('#discount_surcharge').val('Manual Discount');
        $('#amount').prop('disabled', false);
        $('#discount_type').prop('disabled', false);
        $('#percent_type').prop('disabled', false);
        $('#reason').prop('disabled', false);
        $('.discount-row').show();
        $('#reason').val('');
    });
    $(document).on('click', '.new_cus', function(e) {
        e.preventDefault(); // Prevent default link behavior
        $('#hdn_customer_type').val('new');
        $('#customer_type').val('new');
        $("#new_customer").load(location.href + " #new_customer");
        $('.add_dis').find('.subtotal').text('$0.00');
        $('.add_dis').find('.discount').text('$0.00');
        $('.add_dis').find('.total').text('$0.00');
        $('#amount').val(0);
        $('#discount_surcharge').val('Manual Discount');
        $('#amount').prop('disabled', false);
        $('#discount_type').prop('disabled', false);
        $('#percent_type').prop('disabled', false);
        $('#reason').prop('disabled', false);
        $('.discount-row').show();
        $('#reason').val('');
    });
    $(document).on('click', '.existing_cus', function(e) {
        e.preventDefault(); // Prevent default link behavior
        $('#hdn_customer_type').val('existing');
        $('#customer_type').val('existing');
        $("#exist_customer").load(location.href + " #exist_customer");
        $('.add_dis').find('.subtotal').text('$0.00');
        $('.add_dis').find('.discount').text('$0.00');
        $('.add_dis').find('.total').text('$0.00');
        $('#amount').val(0);
        $('#discount_surcharge').val('Manual Discount');
        $('#amount').prop('disabled', false);
        $('#discount_type').prop('disabled', false);
        $('#percent_type').prop('disabled', false);
        $('#reason').prop('disabled', false);
        $('.discount-row').show();
        $('#reason').val('');
    });
    // Call updateSubtotalAndTotal when discount type or amount changes
    $(document).on('change input', 'input[name="discount_type"], #amount', function() {
        var type =$('#discount_customer_type').val();
        updateSubtotalAndTotal(type);
    });
    // Event listener for change in discount selection
    $(document).on('change', '#discount_surcharge', function() {
        var type =$('#discount_customer_type').val();
        checkDiscountSelection();
        updateSubtotalAndTotal(type);
    });

    $(document).on('change', '#edit_discount_surcharge', function() {
        var selectedOption = $(this).val();
        var $discountType = $('#edit_discount_type');
        var $amount = $('#edit_amount');
        var $reason = $('#edit_reason');
        var $dynamicDiscount = $('#dynamic_discount');

        if (selectedOption === "No Discount") {
            $discountType.prop('disabled', true);
            $amount.prop('disabled', true);
            $reason.prop('disabled', true);
            $amount.val('');
            $reason.val('');
            
            // Remove dynamic discount
            $dynamicDiscount.text('');
            
            // Recalculate edit_product_price
            calculatePrice();
        } else if (selectedOption === "Credit Card Surcharge") {
             // Set discount type to percentage and disable the field
            $('input[name="edit_discount_type"][value="percent"]').prop('checked', true).prop('disabled', true);
            
            // Set the discount amount to 2%
            var pricePerUnit = parseFloat($('.edit_price_per_unit').val());
            var quantity = parseInt($('.edit_quantity').val());
            var totalAmount = pricePerUnit * quantity;
            var discountAmount = totalAmount * 0.02; // 2% discount amount for Credit Card Surcharge
            
            // Update dynamic discount display
            $dynamicDiscount.text(' Discount: $' + discountAmount.toFixed(2));

            $amount.val('2').prop('disabled', true);
            $reason.val('Credit Card Surcharge').prop('disabled', true);

            // Recalculate edit_product_price with fixed discount amount
            var newPrice = totalAmount + discountAmount;

            // Update edit_product_price
            $('.edit_product_price').text('$' + newPrice.toFixed(2));
        }else if (selectedOption === "Manual Surcharge") {
            // Enable all fields
            $discountType.prop('disabled', false);
            $discountType.closest('.form-group').find('input[type="radio"]').prop('disabled', false);
            $amount.prop('disabled', false);
            $reason.prop('disabled', false);
            $amount.val(0);
            // Check if amount is blank, if so set it to 0
            var amountValue = $('#edit_amount').val().trim() === '' ? 0 : parseFloat($('#edit_amount').val());

            // Update dynamic discount display
            var pricePerUnit = parseFloat($('.edit_price_per_unit').val());
            var quantity = parseInt($('.edit_quantity').val());
            var totalAmount = pricePerUnit * quantity;
            var discountAmount = amountValue; // Manual Surcharge discount amount

            $dynamicDiscount.text(' Discount: $' + discountAmount.toFixed(2));

            $amount.val(amountValue);

            // Recalculate edit_product_price with fixed discount amount
            var newPrice = totalAmount + discountAmount;

            // Update edit_product_price
            $('.edit_product_price').text('$' + newPrice.toFixed(2));
        } else {
            $discountType.prop('disabled', false);
            $discountType.closest('.form-group').find('input[type="radio"]').prop('disabled', false);
            $amount.prop('disabled', false);
            $reason.prop('disabled', false);
        }
    });
    $(document).on('change', '#edit_discount_type, #edit_amount, .edit_price_per_unit, .edit_quantity', function() {
        // var d_types = $('input[name="edit_discount_type"]:checked').val();
        // $('#discount_types').val(d_types);
        // var pricePerUnit = parseFloat($('.edit_price_per_unit').val());
        // var quantity = parseInt($('.edit_quantity').val());
        // var discountType = $('input[name="edit_discount_type"]:checked').val();
        // var amount = parseFloat($('#edit_amount').val());
        // var discountAmount = 0;

        // if (discountType === "amount" && !isNaN(amount)) {
        //     discountAmount = amount * quantity;
        // } else if (discountType === "percent" && !isNaN(amount)) {
        //     var discountPercent = amount / 100;
        //     discountAmount = (pricePerUnit * quantity) * discountPercent;
        // }

        // // Calculate new price after discount
        // var newPrice = (pricePerUnit * quantity) - discountAmount;

        // // Update edit_product_price
        // $('.edit_product_price').text('$' + newPrice.toFixed(2));

        // // Update dynamic discount display
        // $('#dynamic_discount').text(' Discount: $' + discountAmount.toFixed(2));
        calculateAndUpdate();
    });

    
    $(document).on('click', '.product-name.clickable', function() {
        var id = $(this).attr('product_id');
        var name = $(this).attr('product_name');
        var price = $(this).attr('product_price');//$('#product_price').val();
        var product_price = $(this).attr('product_price');
        var quanitity = $(this).parent().parent().find('.quantity').val();

        // var discountText = $('#dynamic_discount').text();
        // var dis_price = discountText.replace('Discount: $', '');
        var discountText = $(this).parent().parent().find('#hdn_discount_amount').val();
        var dis_price = 'Discount: $' + discountText;

        dis_price = $.trim(dis_price);
        
        if (dis_price === '') {
            dis_price = 0;
        }

        $('.edit_product').show();
        $('.main_walk_in').hide();
        
        $('#edit_product_id').val(id);
        $('.edit_product_name').text(name);
        $('.edit_product_quantity').text(quanitity);
        // $('.edit_product_price').text('$' + (price * quanitity - dis_price));
        $('.edit_product_price').text($(this).parent().find('b').text());
        
        $('.edit_price_per_unit').val(price);
        $('.edit_quantity').val(quanitity);
        // $('#edit_sale_staff_id').val($(this).parent().parent().parent().parent().find('.credit_sale').find('#sale_staff_id').val());

        //by default this field is disabled bcs of no discount selected
        // $('#edit_discount_type, #edit_amount, #edit_reason').prop('disabled', true);
        var dynamicValue = $(this).parent().parent().find('#discount_types').val();
        $('input[name="edit_discount_type"][value="' + dynamicValue + '"]').prop('checked', true);
        // if(dynamicValue == 'amount')
        // {

        // }
        var ck_sur = $(this).parent().parent().find('#hdn_discount_surcharge').val();
        if(ck_sur == 'No Discount')
        {
            $('#edit_discount_surcharge').val("No Discount");
            $('#edit_amount').val(0);
            $('#dynamic_discount').text()
            $('#edit_discount_type, #edit_amount, #edit_reason').prop('disabled', true);
            // $('#dynamic_discount').text('')
            $('#dynamic_discount').text('');
            $('#edit_reason').val('');
            $('#edit_sale_staff_id').val($(this).parent().parent().find('#hdn_who_did_work').val())
            
        }else if(ck_sur == 'Manual Discount'){
            $('#edit_discount_type, #edit_amount, #edit_reason').prop('disabled', false);
            $('#edit_discount_surcharge').val($(this).parent().parent().find('#hdn_discount_surcharge').val());
            $('#dynamic_discount').text('Discount: $' + $(this).parent().parent().find('#hdn_discount_amount').val());
            $('#edit_amount').val($(this).parent().parent().find('#hdn_discount_amount').val());
            $('#edit_reason').val($(this).parent().parent().find('#hdn_reason').val());
            $('#edit_sale_staff_id').val($(this).parent().parent().find('#hdn_who_did_work').val())
        }else if(ck_sur == 'Manual Surcharge'){
            $('#edit_discount_type, #edit_amount, #edit_reason').prop('disabled', false);
            $('#edit_discount_surcharge').val($(this).parent().parent().find('#hdn_discount_surcharge').val());
            $('#dynamic_discount').text('Discount: $' + $(this).parent().parent().find('#hdn_discount_amount').val());
            $('#edit_amount').val($(this).parent().parent().find('#hdn_discount_amount').val());
            $('#edit_reason').val($(this).parent().parent().find('#hdn_reason').val());
            $('#edit_sale_staff_id').val($(this).parent().parent().find('#hdn_who_did_work').val())
        }
        else{
            $('#edit_discount_surcharge').val($(this).parent().parent().find('#hdn_discount_surcharge').val());
            var totalPrice = parseFloat(price) * quanitity;
            // Calculate surcharge amount (2% of the total price)
            var surchargeAmount = totalPrice * 0.02;
            $('#dynamic_discount').text('Discount: $' + surchargeAmount);
            $('#edit_discount_type, #edit_amount, #edit_reason').prop('disabled', true);
            $('#edit_amount').val($(this).parent().parent().find('#hdn_discount_amount').val());
            $('#edit_reason').val('Credit Card Surcharge');
            $('#edit_sale_staff_id').val($(this).parent().parent().find('#hdn_who_did_work').val())
        }
    });

    $(document).on('click','.remove_product',function() {
        $(this).parent().remove();
        var type=$('#customer_type').val();
        updateSubtotalAndTotal(type); // Update Subtotal and Total
    })
    $(document).on('click','.remove_edit_product',function() {
        $('.edit_product').hide();
        $('.main_walk_in').show();

        var edit_prod_id = $('#edit_product_id').val();
        var type=$('#customer_type').val();

        $('.invo-notice').each(function(index, element) {
            if($(this).attr('prod_id') == edit_prod_id)
            {
                $(this).remove();
                updateSubtotalAndTotal(type); // Update Subtotal and Total
            }
        });
    })

    // $(document).on('change keyup', '.edit_price_per_unit', function() {
    //     $('.edit_product_price').text('$'+$(this).val());
    // });
    $(document).on('change keyup', '.edit_quantity', function() {
        updateQuantity();
        // updatePrice();
        calculateAndUpdate();
    });
    $(document).on('click', '.number-input .walk_number_input button', function() {
        var inputField = $(this).siblings('.edit_quantity');
        var currentValue = parseInt(inputField.val());
        if ($(this).hasClass('plus')) {
            inputField.val(currentValue + 1);
        } else {
            if (currentValue > 1) {
                inputField.val(currentValue - 1);
            }
        }
        updateQuantity();
        updatePrice(); 
    });

    $(document).on('click','.back_to_sale',function(){
        $('#take_payment').modal('hide');
        $('#Walkin_Retail').modal('show');
    })
    $(document).on('click','.add_another_payment',function(){
        var paymentDetailsClone = $('.payment_details').first().clone(); // Clone the first .payment_details div
        console.log('paymentDetailsClone',paymentDetailsClone);
        paymentDetailsClone.find('.payment_amount').val('0');

        $('.payment_details:last').after(paymentDetailsClone); // Append the cloned div after the last .payment_details div
        
        updateRemoveIconVisibility(); // Update remove icon visibility
        updateRemainingBalance(); // Update remaining balance
    })

    $(document).on('click', '.remove_payment_btn', function() {
        $(this).closest('.payment_details').remove(); // Remove the closest .payment_details div
        updateRemoveIconVisibility(); // Update remove icon visibility
        updateRemainingBalance(); // Update remaining balance
    });
    $(document).on('input', '.payment_amount', function() {
        updateRemainingBalance(); // Update remaining balance when payment amount changes
    });

    $(document).on('click', '.complete_sale', function() {
        var payment_total = $('.payment_total').text();
        var remaining_balance = $('.remaining_balance').text();

        var paymentTypes = []; // Array to store selected payment types
        $('select[name="payment_type[]"] option:selected').each(function() {
            paymentTypes.push($(this).val()); // Push each selected payment type into the array
        });

        var paymentAmounts = []; // Array to store payment amounts
        $('.payment_amount').each(function() {
            paymentAmounts.push($(this).val()); // Push each payment amount into the array
        });

        var paymentDates = [];
        $('input[name="payment_date[]"]').each(function() {
            paymentDates.push($(this).val());
        });

        var formData = new FormData($('#create_walkin')[0]);

        // Append each payment type separately to FormData
        paymentTypes.forEach(function(paymentType) {
            formData.append('payment_types[]', paymentType);
        });

        paymentAmounts.forEach(function(paymentAmount) {
            formData.append('payment_amounts[]', paymentAmount);
        });

        paymentDates.forEach(function(paymentDate) {
            formData.append('payment_dates[]', paymentDate);
        });

        // formData.append('payment_amounts[]', paymentAmounts);
        // formData.append('payment_dates[]', paymentDates);
        formData.append('payment_total', payment_total);
        formData.append('remaining_balance', remaining_balance);

        SubmitWalkIn(formData);
    });
    $(document).on('click', '.existing_client_change', function() {
        debugger;
        $('.client_search_bar').show();
        $('#existingclientmodal').hide();
    })

    
    updateRemoveIconVisibility();
    // updateRemainingBalance();

    function updateRemoveIconVisibility() {
        var paymentDetailsCount = $('.payment_details').length;
        if (paymentDetailsCount === 1) {
            $('.remove_payment_btn').hide();
        } else {
            $('.remove_payment_btn').show();
        }
    }
    function updateRemainingBalance() {
        
        var total = parseFloat($('.payment_total').text().replace('$', '')); // Get the total amount
        var totalPayments = 0;

        // Sum up all payment amounts
        $('.payment_amount').each(function() {
            var paymentAmount = parseFloat($(this).val());
            if (!isNaN(paymentAmount)) {
                totalPayments += paymentAmount;
            }
        });
        var remainingBalance = total - totalPayments; // Calculate the remaining balance
        $('.remaining_balance').text('$' + remainingBalance.toFixed(2)); // Update the remaining balance
    }
    
    function calculateAndUpdate() {
        var pricePerUnit = parseFloat($('.edit_price_per_unit').val()) || 0;
        var quantity = parseInt($('.edit_quantity').val()) || 0;
        var discountType = $('input[name="edit_discount_type"]:checked').val();
        var amount = parseFloat($('#edit_amount').val());
        var discountAmount = 0;
        var edit_dis_sur = $('#edit_discount_surcharge').val();
        if (discountType === "amount" && !isNaN(amount)) {
            if(edit_dis_sur == 'Manual Surcharge')
            {
                discountAmount = amount * quantity;

                var productPrice = pricePerUnit * quantity;
                var newTotal = productPrice + discountAmount;
            }else{
                discountAmount = amount * quantity;

                var productPrice = pricePerUnit * quantity;
                var newTotal = productPrice - discountAmount;
            }

        } else if (discountType === "percent" && !isNaN(amount)) {
                // if($(this).find('#hdn_discount_surcharge').val() == 'Credit Card Surcharge')
                // {
                //     var discountPercent = amount / 100;
                //     discountAmount = (pricePerUnit * quantity) * discountPercent;
                //     var newPrice = (pricePerUnit * quantity) + discountAmount;
                //     var productPrice = pricePerUnit * quantity;
                //     var newTotal = productPrice + discountAmount;
                // }
                // else
                // {
                    // var discountPercent = amount / 100;
                    // discountAmount = (pricePerUnit * quantity) * discountPercent;
                    // var newPrice = (pricePerUnit * quantity) - discountAmount;
                    // var productPrice = pricePerUnit * quantity;
                    // var newTotal = productPrice - discountAmount;
                // }
                if(edit_dis_sur == 'Manual Surcharge' || edit_dis_sur == "Credit Card Surcharge")
                {
                    var discountPercent = amount / 100;
                    discountAmount = (pricePerUnit * quantity) * discountPercent;
                    var newPrice = (pricePerUnit * quantity) - discountAmount;
                    var productPrice = pricePerUnit * quantity;
                    var newTotal = productPrice + discountAmount;
                }
                else{
                    var discountPercent = amount / 100;
                    discountAmount = (pricePerUnit * quantity) * discountPercent;
                    var newPrice = (pricePerUnit * quantity) - discountAmount;
                    var productPrice = pricePerUnit * quantity;
                    var newTotal = productPrice - discountAmount;
                }
        }else{
            var productPrice = pricePerUnit * quantity;
            var newTotal = productPrice + discountAmount;
        }

        // Calculate new price after discount
        

        // Update edit_product_price
        // $('.edit_product_price').text('$' + newPrice.toFixed(2));

        // Update dynamic discount display
        $('#dynamic_discount').text(' Discount: $' + discountAmount.toFixed(2));

        // Calculate new total after discount
        

        // Update edit_product_price
        $('.edit_product_price').text('$' + newTotal.toFixed(2));
    }

    function calculatePrice() {
        var pricePerUnit = parseFloat($('.edit_price_per_unit').val());
        var quantity = parseInt($('.edit_quantity').val());

        // Calculate new price without discount
        var newPrice = pricePerUnit * quantity;

        // Update edit_product_price
        $('.edit_product_price').text('$' + newPrice.toFixed(2));
    }

    function updateQuantity() {
        var newQuantity = parseInt($('.edit_quantity').val());
        // $('.edit_product_quantity').text(newQuantity);
    }
    function updatePrice() {
        var pricePerUnit = parseFloat($('.edit_price_per_unit').val());
        var quantity = parseInt($('.edit_quantity').val());
        var totalPrice = pricePerUnit * quantity;
        $('.edit_product_price').text('$' + totalPrice.toFixed(2));
    }

    function checkDiscountSelection() {
        var selectedOption = $('#discount_surcharge').val();
        
        if (selectedOption === 'No Discount') {
            // Disable the amount input
            $('#amount').val('').prop('disabled', true);

            // Disable the discount type radio buttons
            $('#discount_type').prop('disabled', true);
            $('#percent_type').prop('disabled', true);
            $('#reason').prop('disabled', true);
            $('.discount-row').hide(); // Or $('.discount-row').remove();
            $('#reason').val('');

            // $('#edit_discount_surcharge').val(selectedOption);//for edit product
        }
        else if(selectedOption === 'Credit Card Surcharge') {
            $('#amount').val('2').prop('disabled', true); // Set a default value of 2
            $('input[name="discount_type"][value="percent"]').prop('checked', true).prop('disabled', true);

            // Set the reason to "Credit Card Surcharge" and disable the input
            $('#reason').val('Credit Card Surcharge').prop('disabled', true);
            $('.discount-row').show();
        } else if (selectedOption === "Manual Surcharge") {
            // Enable all fields
            $('#discount_type').prop('disabled', false);
            $('#discount_type').closest('.form-group').find('input[type="radio"]').prop('disabled', false);
            $('#amount').prop('disabled', false);
            $('#reason').prop('disabled', false);
            $('#amount').val(0);
            // Check if amount is blank, if so set it to 0
            var amountValue = $('#amount').val().trim() === '' ? 0 : parseFloat($('#amount').val());

            // Update dynamic discount display
            // var pricePerUnit = parseFloat($('.edit_price_per_unit').val());
            // var quantity = parseInt($('.edit_quantity').val());
            // var totalAmount = pricePerUnit * quantity;
            var discountAmount = amountValue; // Manual Surcharge discount amount

            // $dynamicDiscount.text(' Discount: $' + discountAmount.toFixed(2));

            $('#amount').val(amountValue);

            // Recalculate edit_product_price with fixed discount amount
            var newPrice = amountValue + discountAmount;

            // Update edit_product_price
            $('.edit_product_price').text('$' + newPrice.toFixed(2));
        } else {
            // Enable the amount input
            $('#amount').prop('disabled', false);

            // Enable the discount type radio buttons
            $('#discount_type').prop('disabled', false);
            $('#reason').prop('disabled', false);
            $('.discount-row').show();
        }
    }
        
    //for match clients
    function matchClient(input) {
        var reg = new RegExp(input.trim(), "i");
        var res = [];
        if (input.trim().length === 0) {
            return res;
        }
        for (var i = 0, len = client_details.length; i < len; i++) {
            var person = client_details[i];
            // Check specifically for the mobile_number number field
            if (person.mobile_number && person.mobile_number.match(reg)) {
                res.push(person);
            } else {
                // If mobile_number number didn't match, check other fields
                for (var key in person) {
                    if (person.hasOwnProperty(key) && typeof person[key] === 'string' && person[key].match(reg)) {
                        res.push(person);
                        break; // Break loop if any field matches
                    }
                }
            }
        }
        return res;
    }

    function debounce(func, timeout = 300){
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => { func.apply(this, args); }, timeout);
        };
    }

    //change input event
    const changeInput = debounce((val) =>
    {
        $('#clientDetails').empty();
        $('.upcoming_appointments').empty();
        $('.history_appointments').empty();

        // ajax call
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('calendar.get-all-clients')}}",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                name: $('#search').val(),
            },
            dataType: "json",
            success: function(res) {
                if (res.length > 0) {
                    $('.client_list_box').show();
                    for (var i = 0; i < res.length; ++i) {
                        // Check if the record with the same id already exists in the array
                        var existingRecordIndex = client_details.findIndex(record => record.id === res[i].id);

                        // If the record doesn't exist in the array, add it
                        if (existingRecordIndex === -1) {
                            // Push client details to the client_details array
                            client_details.push({
                                id: res[i].id,
                                name: res[i].first_name,
                                lastname: res[i].last_name,
                                email: res[i].email,
                                mobile_number: res[i].mobile_no,
                                date_of_birth: res[i].date_of_birth,
                                gender: res[i].gender,
                                home_phone: res[i].home_phone,
                                work_phone: res[i].work_phone,
                                contact_method: res[i].contact_method,
                                send_promotions: res[i].send_promotions,
                                street_address: res[i].street_address,
                                suburb: res[i].suburb,
                                city: res[i].city,
                                postcode: res[i].postcode,
                                client_photos:res[i].client_photos,
                                client_documents: [], // Initialize an empty array for client documents
                                service_name: res[i].last_appointment.service_name,
                                staff_name: res[i].last_appointment.staff_name,
                                start_date: res[i].last_appointment.appointment_date,
                                status: res[i].last_appointment.status,
                                location_name: res[i].last_appointment.location_name
                            });
                        }
                        // Iterate over client documents and push only doc_name and created_at
                        if (res[i].documents && res[i].documents.length > 0) {
                            for (var j = 0; j < res[i].documents.length; j++) {
                                // If the record with the same doc_id already exists in the array, skip
                                if (existingRecordIndex !== -1 && client_details[existingRecordIndex].client_documents.some(doc => doc.doc_id === res[i].documents[j].doc_id)) {
                                    continue;
                                }
                                // If the record doesn't exist in the array or the doc_id doesn't exist in the documents array, add it
                                if (existingRecordIndex === -1 || !client_details[existingRecordIndex].client_documents.some(doc => doc.doc_id === res[i].documents[j].doc_id)) {
                                    client_details[existingRecordIndex !== -1 ? existingRecordIndex : i].client_documents.push({
                                        doc_id: res[i].documents[j].doc_id,
                                        doc_name: res[i].documents[j].doc_name,
                                        created_at: res[i].documents[j].created_at
                                    });
                                }
                            }
                        }
                    }
                } else {
                    $('.table-responsive').empty();
                }
            },
            error: function(jqXHR, exception) {
                // Handle error
            }
        });

        var autoCompleteResult = matchClient(val);
        var resultElement = document.getElementById("result");
        if (val.trim() === "") {
            resultElement.innerHTML = ""; // Clear the result if search box is empty
        } else {
            if (autoCompleteResult.length === 0) {
                resultElement.innerHTML = "<p>No records found</p>";
            } else {
                resultElement.innerHTML = ""; // Clear previous message if records are found
                for (var i = 0, limit = 10, len = autoCompleteResult.length; i < len && i < limit; i++) {
                    var person = autoCompleteResult[i];
                    var firstCharacter = person.name.charAt(0).toUpperCase();
                    if(person.service_name == null)
                    {
                        var appointment = `No Visit history`;
                    }
                    else
                    {
                        var appointment = `<p>last appt at ${person.location_name} on ${person.start_date} </p>
                                <p> ${person.service_name} with ${person.staff_name}(${person.status})</p>`;
                    }
                    resultElement.innerHTML = `<li onclick='setSearch("${person.name}")'>
                            <div class='client-name'>
                                <div class='drop-cap' style='background: #D0D0D0; color: #000;'>${firstCharacter}</div>
                                <div class="client-info">
                                    <h4 class="blue-bold">${person.name} ${person.lastname}</h4>
                                </div>
                            </div>
                            <div class="mb-2">
                                <a href="#" class="river-bed"><b> ${person.mobile_number} </b></a><br>
                                <a href="#" class="river-bed"><b> ${person.email} </b></a>
                            </div>
                            ${appointment}
                        </li>`;
                }
            }
        }
    });

    //change input modal
    const changeInputModal = debounce((val) =>
    {
        $('#clientDetails').empty();
        $('.upcoming_appointments').empty();
        $('.history_appointments').empty();
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('calendar.get-all-clients')}}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    name: $('#searchmodel').val(),
                },
                dataType: "json",
                success: function(res) {
                    if (res.length > 0) {
                        $('.client_list_box').show();
                        for (var i = 0; i < res.length; ++i) {
                            // Check if the record with the same id already exists in the array
                            var existingRecordIndex = client_details.findIndex(record => record.id === res[i].id);

                            // If the record doesn't exist in the array, add it
                            if (existingRecordIndex === -1) {
                                // Push client details to the client_details array
                                client_details.push({
                                    id: res[i].id,
                                    name: res[i].first_name,
                                    lastname: res[i].last_name,
                                    email: res[i].email,
                                    mobile_number: res[i].mobile_no,
                                    date_of_birth: res[i].date_of_birth,
                                    gender: res[i].gender,
                                    home_phone: res[i].home_phone,
                                    work_phone: res[i].work_phone,
                                    contact_method: res[i].contact_method,
                                    send_promotions: res[i].send_promotions,
                                    street_address: res[i].street_address,
                                    suburb: res[i].suburb,
                                    city: res[i].city,
                                    postcode: res[i].postcode,
                                    client_photos:res[i].client_photos,
                                    client_documents: [], // Initialize an empty array for client documents
                                    service_name: res[i].last_appointment.service_name,
                                    staff_name: res[i].last_appointment.staff_name,
                                    start_date: res[i].last_appointment.appointment_date,
                                    status: res[i].last_appointment.status,
                                    location_name: res[i].last_appointment.location_name
                                });
                            }
                            // Iterate over client documents and push only doc_name and created_at
                            for (var j = 0; j < res[i].documents.length; j++) {
                                // If the record with the same doc_id already exists in the array, skip
                                if (existingRecordIndex !== -1 && client_details[existingRecordIndex].client_documents.some(doc => doc.doc_id === res[i].documents[j].doc_id)) {
                                    continue;
                                }
                                // If the record doesn't exist in the array or the doc_id doesn't exist in the documents array, add it
                                if (existingRecordIndex === -1 || !client_details[existingRecordIndex].client_documents.some(doc => doc.doc_id === res[i].documents[j].doc_id)) {
                                    client_details[existingRecordIndex !== -1 ? existingRecordIndex : i].client_documents.push({
                                        doc_id: res[i].documents[j].doc_id,
                                        doc_name: res[i].documents[j].doc_name,
                                        created_at: res[i].documents[j].created_at
                                    });
                                }
                            }
                        }
                    } else {
                        $('.table-responsive').empty();
                    }
                },
                error: function(jqXHR, exception) {
                    // Handle error
                }
            });

            // $('#clientDetails').empty();
            var autoCompleteResult = matchClient(val);
            var resultElement = document.getElementById("resultmodal");
            if (val.trim() === "") {
                resultElement.innerHTML = ""; // Clear the result if search box is empty
        } else {
            if (autoCompleteResult.length === 0) {
                resultElement.innerHTML = "<p>No records found</p>";
            } else {
                resultElement.innerHTML = ""; // Clear previous message if records are found
                for (var i = 0, limit = 10, len = autoCompleteResult.length; i < len && i < limit; i++) {
                    var person = autoCompleteResult[i];
                    var firstCharacter = person.name.charAt(0).toUpperCase();
                    if(person.service_name == null)
                    {
                        var appointment = `No Visit history`;
                    }
                    else
                    {
                        var appointment = `<p>last appt at ${person.location_name} on ${person.start_date} </p>
                                <p> ${person.service_name} with ${person.staff_name}(${person.status})</p>`;
                    }
                    resultElement.innerHTML += `<li onclick='setSearchModal("${person.name}")'>
                            <div class='client-name'>
                                <div class='drop-cap' style='background: #D0D0D0; color: #000;'>${firstCharacter}</div>
                                <div class="client-info">
                                    <h4 class="blue-bold">${person.name} ${person.lastname}</h4>
                                </div>
                            </div>
                            <div class="mb-2">
                                <a href="#" class="river-bed"><b> ${person.mobile_number} </b></a><br>
                                <a href="#" class="river-bed"><b> ${person.email} </b></a>
                            </div>
                            ${appointment}
                        </li>`;
               }
            }
        }
    });

    //change input modal
    const changeEditInputModal = debounce((val) =>
    {
        $('#clientDetails').empty();
        $('.upcoming_appointments').empty();
        $('.history_appointments').empty();
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('calendar.get-all-clients')}}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    name: $('#searcheditmodel').val(),
                },
                dataType: "json",
                success: function(res) {
                    if (res.length > 0) {
                        $('.client_list_box').show();
                        for (var i = 0; i < res.length; ++i) {
                            // Check if the record with the same id already exists in the array
                            var existingRecordIndex = client_details.findIndex(record => record.id === res[i].id);

                            // If the record doesn't exist in the array, add it
                            if (existingRecordIndex === -1) {
                                // Push client details to the client_details array
                                client_details.push({
                                    id: res[i].id,
                                    name: res[i].first_name,
                                    lastname: res[i].last_name,
                                    email: res[i].email,
                                    mobile_number: res[i].mobile_no,
                                    date_of_birth: res[i].date_of_birth,
                                    gender: res[i].gender,
                                    home_phone: res[i].home_phone,
                                    work_phone: res[i].work_phone,
                                    contact_method: res[i].contact_method,
                                    send_promotions: res[i].send_promotions,
                                    street_address: res[i].street_address,
                                    suburb: res[i].suburb,
                                    city: res[i].city,
                                    postcode: res[i].postcode,
                                    client_photos:res[i].client_photos,
                                    client_documents: [], // Initialize an empty array for client documents
                                    service_name: res[i].last_appointment.service_name,
                                    staff_name: res[i].last_appointment.staff_name,
                                    start_date: res[i].last_appointment.appointment_date,
                                    status: res[i].last_appointment.status,
                                    location_name: res[i].last_appointment.location_name
                                });
                            }
                            // Iterate over client documents and push only doc_name and created_at
                            for (var j = 0; j < res[i].documents.length; j++) {
                                // If the record with the same doc_id already exists in the array, skip
                                if (existingRecordIndex !== -1 && client_details[existingRecordIndex].client_documents.some(doc => doc.doc_id === res[i].documents[j].doc_id)) {
                                    continue;
                                }
                                // If the record doesn't exist in the array or the doc_id doesn't exist in the documents array, add it
                                if (existingRecordIndex === -1 || !client_details[existingRecordIndex].client_documents.some(doc => doc.doc_id === res[i].documents[j].doc_id)) {
                                    client_details[existingRecordIndex !== -1 ? existingRecordIndex : i].client_documents.push({
                                        doc_id: res[i].documents[j].doc_id,
                                        doc_name: res[i].documents[j].doc_name,
                                        created_at: res[i].documents[j].created_at
                                    });
                                }
                            }
                        }
                    } else {
                        $('.table-responsive').empty();
                    }
                },
                error: function(jqXHR, exception) {
                    // Handle error
                }
            });

            // $('#clientDetails').empty();
            var autoCompleteResult = matchClient(val);
            var resultElement = document.getElementById("resulteditmodal");
            if (val.trim() === "") {
                resultElement.innerHTML = ""; // Clear the result if search box is empty
        } else {
            if (autoCompleteResult.length === 0) {
                resultElement.innerHTML = "<p>No records found</p>";
            } else {
                resultElement.innerHTML = ""; // Clear previous message if records are found
                for (var i = 0, limit = 10, len = autoCompleteResult.length; i < len && i < limit; i++) {
                    var person = autoCompleteResult[i];
                    var firstCharacter = person.name.charAt(0).toUpperCase();
                    if(person.service_name == null)
                    {
                        var appointment = `No Visit history`;
                    }
                    else
                    {
                        var appointment = `<p>last appt at ${person.location_name} on ${person.start_date} </p>
                                <p> ${person.service_name} with ${person.staff_name}(${person.status})</p>`;
                    }
                    resultElement.innerHTML += `<li onclick='setEditSearchModal("${person.name}")'>
                            <div class='client-name'>
                                <div class='drop-cap' style='background: #D0D0D0; color: #000;'>${firstCharacter}</div>
                                <div class="client-info">
                                    <h4 class="blue-bold">${person.name} ${person.lastname}</h4>
                                </div>
                            </div>
                            <div class="mb-2">
                                <a href="#" class="river-bed"><b> ${person.mobile_number} </b></a><br>
                                <a href="#" class="river-bed"><b> ${person.email} </b></a>
                            </div>
                            ${appointment}
                        </li>`;
               }
            }
        }
    });

    //change input event
    const changeExistingCutomerInput = debounce((val) =>
    {
        $('#clientDetails').empty();
        // $('.upcoming_appointments').empty();
        // $('.history_appointments').empty();

        // ajax call
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('calendar.get-all-clients')}}",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                name: $('#search_exist_customer').val(),
            },
            dataType: "json",
            success: function(res) {
                if (res.length > 0) {
                    $('.existing_client_list_box').show();
                    for (var i = 0; i < res.length; ++i) {
                        // Check if the record with the same id already exists in the array
                        var existingRecordIndex = client_details.findIndex(record => record.id === res[i].id);

                        // If the record doesn't exist in the array, add it
                        if (existingRecordIndex === -1) {
                            // Push client details to the client_details array
                            client_details.push({
                                id: res[i].id,
                                name: res[i].first_name,
                                lastname: res[i].last_name,
                                email: res[i].email,
                                mobile_number: res[i].mobile_no,
                                date_of_birth: res[i].date_of_birth,
                                gender: res[i].gender,
                                home_phone: res[i].home_phone,
                                work_phone: res[i].work_phone,
                                contact_method: res[i].contact_method,
                                send_promotions: res[i].send_promotions,
                                street_address: res[i].street_address,
                                suburb: res[i].suburb,
                                city: res[i].city,
                                postcode: res[i].postcode,
                                client_photos:res[i].client_photos,
                                client_documents: [], // Initialize an empty array for client documents
                                service_name: res[i].last_appointment.service_name,
                                staff_name: res[i].last_appointment.staff_name,
                                start_date: res[i].last_appointment.appointment_date,
                                status: res[i].last_appointment.status,
                                location_name: res[i].last_appointment.location_name
                            });
                        }
                        // Iterate over client documents and push only doc_name and created_at
                        if (res[i].documents && res[i].documents.length > 0) {
                            for (var j = 0; j < res[i].documents.length; j++) {
                                // If the record with the same doc_id already exists in the array, skip
                                if (existingRecordIndex !== -1 && client_details[existingRecordIndex].client_documents.some(doc => doc.doc_id === res[i].documents[j].doc_id)) {
                                    continue;
                                }
                                // If the record doesn't exist in the array or the doc_id doesn't exist in the documents array, add it
                                if (existingRecordIndex === -1 || !client_details[existingRecordIndex].client_documents.some(doc => doc.doc_id === res[i].documents[j].doc_id)) {
                                    client_details[existingRecordIndex !== -1 ? existingRecordIndex : i].client_documents.push({
                                        doc_id: res[i].documents[j].doc_id,
                                        doc_name: res[i].documents[j].doc_name,
                                        created_at: res[i].documents[j].created_at
                                    });
                                }
                            }
                        }
                    }
                } else {
                    $('.table-responsive').empty();
                }
            },
            error: function(jqXHR, exception) {
                // Handle error
            }
        });

        var autoCompleteResult = matchClient(val);
        var resultElement = document.getElementById("resultexistingmodal"); 
        if (val.trim() === "") {
            resultElement.innerHTML = ""; // Clear the result if search box is empty
        } else {
            if (autoCompleteResult.length === 0) {
                resultElement.innerHTML = "<p>No records found</p>";
            } else {
                resultElement.innerHTML = ""; // Clear previous message if records are found
                for (var i = 0, limit = 10, len = autoCompleteResult.length; i < len && i < limit; i++) {
                    var person = autoCompleteResult[i];
                    var firstCharacter = person.name.charAt(0).toUpperCase();
                    if(person.service_name == null)
                    {
                        var appointment = `No Visit history`;
                    }
                    else
                    {
                        var appointment = `<p>last appt at ${person.location_name} on ${person.start_date} </p>
                                <p> ${person.service_name} with ${person.staff_name}(${person.status})</p>`;
                    }
                    resultElement.innerHTML = `<li onclick='setSearchExistingModal("${person.name}")'>
                            <div class='client-name'>
                                <div class='drop-cap' style='background: #D0D0D0; color: #000;'>${firstCharacter}</div>
                                <div class="client-info">
                                    <h4 class="blue-bold">${person.name} ${person.lastname}</h4>
                                </div>
                            </div>
                            <div class="mb-2">
                                <a href="#" class="river-bed"><b> ${person.mobile_number} </b></a><br>
                                <a href="#" class="river-bed"><b> ${person.email} </b></a>
                            </div>
                            ${appointment}
                        </li>`;
                }
            }
        }
    });
    
    //change input modal
    const changeWaitListInputModal = debounce((val) =>
    {
        $('#clientDetails').empty();
        $('.upcoming_appointments').empty();
        $('.history_appointments').empty();
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('calendar.get-all-clients')}}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    name: $('#searchwaitlistmodel').val(),
                },
                dataType: "json",
                success: function(res) {
                    if (res.length > 0) {
                        $('.client_waitlist_box').show();
                        for (var i = 0; i < res.length; ++i) {
                            // Check if the record with the same id already exists in the array
                            var existingRecordIndex = client_details.findIndex(record => record.id === res[i].id);

                            // If the record doesn't exist in the array, add it
                            if (existingRecordIndex === -1) {
                                // Push client details to the client_details array
                                client_details.push({
                                    id: res[i].id,
                                    name: res[i].first_name,
                                    lastname: res[i].last_name,
                                    email: res[i].email,
                                    mobile_number: res[i].mobile_no,
                                    date_of_birth: res[i].date_of_birth,
                                    gender: res[i].gender,
                                    home_phone: res[i].home_phone,
                                    work_phone: res[i].work_phone,
                                    contact_method: res[i].contact_method,
                                    send_promotions: res[i].send_promotions,
                                    street_address: res[i].street_address,
                                    suburb: res[i].suburb,
                                    city: res[i].city,
                                    postcode: res[i].postcode,
                                    client_photos:res[i].client_photos,
                                    client_documents: [], // Initialize an empty array for client documents
                                    service_name: res[i].last_appointment.service_name,
                                    staff_name: res[i].last_appointment.staff_name,
                                    start_date: res[i].last_appointment.appointment_date,
                                    status: res[i].last_appointment.status,
                                    location_name: res[i].last_appointment.location_name
                                });
                            }
                            // Iterate over client documents and push only doc_name and created_at
                            for (var j = 0; j < res[i].documents.length; j++) {
                                // If the record with the same doc_id already exists in the array, skip
                                if (existingRecordIndex !== -1 && client_details[existingRecordIndex].client_documents.some(doc => doc.doc_id === res[i].documents[j].doc_id)) {
                                    continue;
                                }
                                // If the record doesn't exist in the array or the doc_id doesn't exist in the documents array, add it
                                if (existingRecordIndex === -1 || !client_details[existingRecordIndex].client_documents.some(doc => doc.doc_id === res[i].documents[j].doc_id)) {
                                    client_details[existingRecordIndex !== -1 ? existingRecordIndex : i].client_documents.push({
                                        doc_id: res[i].documents[j].doc_id,
                                        doc_name: res[i].documents[j].doc_name,
                                        created_at: res[i].documents[j].created_at
                                    });
                                }
                            }
                        }
                    } else {
                        $('.table-responsive').empty();
                    }
                },
                error: function(jqXHR, exception) {
                    // Handle error
                }
            });

            // $('#clientDetails').empty();
            var autoCompleteResult = matchClient(val);
            var resultElement = document.getElementById("resultwaitlistmodal");
            if (val.trim() === "") {
                resultElement.innerHTML = ""; // Clear the result if search box is empty
        } else {
            if (autoCompleteResult.length === 0) {
                resultElement.innerHTML = "<p>No records found</p>";
            } else {
                resultElement.innerHTML = ""; // Clear previous message if records are found
                for (var i = 0, limit = 10, len = autoCompleteResult.length; i < len && i < limit; i++) {
                    var person = autoCompleteResult[i];
                    var firstCharacter = person.name.charAt(0).toUpperCase();
                    if(person.service_name == null)
                    {
                        var appointment = `No Visit history`;
                    }
                    else
                    {
                        var appointment = `<p>last appt at ${person.location_name} on ${person.start_date} </p>
                                <p> ${person.service_name} with ${person.staff_name}(${person.status})</p>`;
                    }
                    resultElement.innerHTML += `<li onclick='setWaitlistSearchModal("${person.name}")'>
                            <div class='client-name'>
                                <div class='drop-cap' style='background: #D0D0D0; color: #000;'>${firstCharacter}</div>
                                <div class="client-info">
                                    <h4 class="blue-bold">${person.name} ${person.lastname}</h4>
                                </div>
                            </div>
                            <div class="mb-2">
                                <a href="#" class="river-bed"><b> ${person.mobile_number} </b></a><br>
                                <a href="#" class="river-bed"><b> ${person.email} </b></a>
                            </div>
                            ${appointment}
                        </li>`;
               }
            }
        }
    });

    //change input modal
    const changeProductInput = debounce((val) => {
        var results = matchProducts(val);
        if (results && results.length > 0) {
            updateSearchResults(results); // Update UI with search results
        } else {
            $('#resultproductmodal').empty(); // Clear search results if no data
            $('.products_box').hide(); // Hide the product search results box
        }
    }, 300);
    const changeProductInputNewCustomer = debounce((val) => {
        var results = matchProductsNewCustomer(val);
        if (results && results.length > 0) {
            updateSearchResultsNewCustomer(results); // Update UI with search results
        } else {
            $('#resultproductmodalNew').empty(); // Clear search results if no data
            $('.products_box_new').hide(); // Hide the product search results box
        }
    }, 300);
    const changeProductInputExistingCustomer = debounce((val) => {
        var results = matchProductsExistingCustomer(val);
        if (results && results.length > 0) {
            updateSearchResultsExistingCustomer(results); // Update UI with search results
        } else {
            $('#resultproductmodalExisting').empty(); // Clear search results if no data
            $('.products_box_existing').hide(); // Hide the product search results box
        }
    }, 300);

    //search and set clients
    function setSearch(value) {
        $('.client_list_box').hide();
        document.getElementById('search').value = value;
        document.getElementById("result").innerHTML = "";

        // Iterate over client_details to find a matching value
        for (const key in client_details) {
            console.log(client_details);
            if (client_details.hasOwnProperty(key)) {
                const client = client_details[key];
                // Check if value matches any field in the client object
                if (client.email === value || client.mobile_number === value || client.name === value) {
                    console.log(client);
                    // If a match is found, dynamically bind HTML to clientDetails element
                    $('#clientDetails').html(
                            `<div class="client-name">
                                <div class="drop-cap" style="background: #D0D0D0; color:#fff;">${client.name.charAt(0).toUpperCase()}
                                </div>
                                <div class="client-info">
                                    <input type='hidden' name='client_name' value='${client.name} ${client.lastname}'>
                                    <input type='hidden' id="client_id" name='client_id' value='${client.id}'>
                                    <h4 class="blue-bold">${client.name}  ${client.lastname}</h4>
                                </div>
                            </div>
                            <div class="mb-2">
                                <a href="#" class="river-bed"><b>${client.mobile_number}</b></a><br>
                                <a href="#" class="river-bed"><b>${client.email}</b></a>
                            </div>
                            <hr>
                            <div class="btns">
                                <button class="btn btn-secondary btn-sm open-client-card-btn" data-client-id="${client.id}" >Client Card</button>
                                <button class="btn btn-secondary btn-sm history" data-client-id="${client.id}" >History</button>
                                <button class="btn btn-secondary btn-sm upcoming" data-client-id="${client.id}" >Upcoming</button>
                            </div>
                            <hr>`
                    );

                    document.getElementById('search').value = '';
                    // Trigger the click event of the history button
                    $('.history').click();
                    break; // Stop iterating once a match is found
                }
            }
        }
    }

    //search and set clients modal
    function setSearchModal(value) {
        $('.client_list_box').hide();
        document.getElementById('search_exist_customer').value = value;//searchmodel
        document.getElementById("resultexistingmodal").innerHTML = "";

        // Iterate over client_details to find a matching value
        for (const key in client_details) {
            console.log(client_details);
            if (client_details.hasOwnProperty(key)) {
                const client = client_details[key];
                // Check if value matches any field in the client object
                if (client.email === value || client.mobile_number === value || client.name === value) {
                    console.log(client);
                    // If a match is found, dynamically bind HTML to clientDetails element
                    $('#clientmodal').show();
                    $('.clientCreateModal').hide();
                    $("#clientName").val(client.name+client.lastname);
                    $("#clientDetailsModal").html(
                        `<i class='ico-user2 me-2 fs-6'></i>  ${client.name}  ${client.lastname}`);
                    $('#clientDetails').html(
                        `<div class="client-name">
                                <div class="drop-cap" style="background: #D0D0D0; color:#fff;">${client.name.charAt(0).toUpperCase()}
                                </div>
                                <div class="client-info">
                                    <input type='hidden' name='client_name' value='${client.name} ${client.lastname}'>
                                    <input type='hidden' id="client_id" name='client_id' value='${client.id}'>
                                    <h4 class="blue-bold">${client.name} ${client.lastname}</h4>
                                </div>
                            </div>
                            <div class="mb-2">
                                <a href="#" class="river-bed"><b>${client.mobile_number}</b></a><br>
                                <a href="#" class="river-bed"><b>${client.email}</b></a>
                            </div>
                            <hr>
                            <div class="btns">
                                <button class="btn btn-secondary btn-sm open-client-card-btn" data-client-id="${client.id}" >Client Card</button>
                                <button class="btn btn-secondary btn-sm history" data-client-id="${client.id}" >History</button>
                                <button class="btn btn-secondary btn-sm upcoming" data-client-id="${client.id}" >Upcoming</button>
                            </div>
                            <hr>`
                    );
                    document.getElementById('search_exist_customer').value = '';
                    // Trigger the click event of the history button
                    // $('.history').click();
                    break; // Stop iterating once a match is found
                }
            }
        }
    }
    function setSearchExistingModal(value) {
        debugger;
        $('.existing_client_list_box').hide();
        document.getElementById('resultexistingmodal').value = value;
        document.getElementById("resultexistingmodal").innerHTML = "";

        // Iterate over client_details to find a matching value
        for (const key in client_details) {
            console.log(client_details);
            if (client_details.hasOwnProperty(key)) {
                const client = client_details[key];
                // Check if value matches any field in the client object
                if (client.email === value || client.mobile_number === value || client.name === value) {
                    console.log(client);
                    // If a match is found, dynamically bind HTML to clientDetails element
                    $('#existingclientmodal').show();
                    $('.existingclientmodal').hide();
                    $("#clientName").val(client.name+client.lastname);
                    $('.client_search_bar').hide();
                    $("#existingclientDetailsModal").html(
                        `<i class='ico-user2 me-2 fs-6'></i>  ${client.name}  ${client.lastname}`);
                    document.getElementById('search_exist_customer').value = '';
                    $('#walk_in_client_id').val(client.id);
                    // Trigger the click event of the history button
                    // $('.history').click();
                    break; // Stop iterating once a match is found
                }
            }
        }
    }
    function setEditSearchModal(value) {
        $('.client_list_box').hide();
        document.getElementById('searcheditmodel').value = value;
        document.getElementById("resultmodal").innerHTML = "";

        // Iterate over client_details to find a matching value
        for (const key in client_details) {
            console.log(client_details);
            if (client_details.hasOwnProperty(key)) {
                const client = client_details[key];
                // Check if value matches any field in the client object
                if (client.email === value || client.mobile_number === value || client.name === value) {
                    console.log(client);
                    // If a match is found, dynamically bind HTML to clientDetails element
                    $('#clienteditmodal').show();
                    $('.clientEditModal').hide();
                    $('#resulteditmodal').empty();
                    $("#clientName").val(client.name+client.lastname);
                    $("#clienteditDetailsModal").html(
                        `<i class='ico-user2 me-2 fs-6'></i>  ${client.name}  ${client.lastname}`);
                    $('#clientDetails').html(
                        `<div class="client-name">
                                <div class="drop-cap" style="background: #D0D0D0; color:#fff;">${client.name.charAt(0).toUpperCase()}
                                </div>
                                <div class="client-info">
                                    <input type='hidden' name='client_name' value='${client.name} ${client.lastname}'>
                                    <input type='hidden' id="client_id" name='client_id' value='${client.id}'>
                                    <h4 class="blue-bold">${client.name} ${client.lastname}</h4>
                                </div>
                            </div>
                            <div class="mb-2">
                                <a href="#" class="river-bed"><b>${client.mobile_number}</b></a><br>
                                <a href="#" class="river-bed"><b>${client.email}</b></a>
                            </div>
                            <hr>
                            <div class="btns">
                                <button class="btn btn-secondary btn-sm open-client-card-btn" data-client-id="${client.id}" >Client Card</button>
                                <button class="btn btn-secondary btn-sm history" data-client-id="${client.id}" >History</button>
                                <button class="btn btn-secondary btn-sm upcoming" data-client-id="${client.id}" >Upcoming</button>
                            </div>
                            <hr>`
                    );
                    document.getElementById('searcheditmodel').value = '';
                    // Trigger the click event of the history button
                    // $('.history').click();
                    break; // Stop iterating once a match is found
                }
            }
        }
    }
    function setWaitlistSearchModal(value) {
        $('.client_waitlist_box').hide();
        document.getElementById('searchwaitlistmodel').value = value;
        document.getElementById("resultwaitlistmodal").innerHTML = "";

        // Iterate over client_details to find a matching value
        for (const key in client_details) {
            console.log(client_details);
            if (client_details.hasOwnProperty(key)) {
                const client = client_details[key];
                // Check if value matches any field in the client object
                if (client.email === value || client.mobile_number === value || client.name === value) {
                    console.log(client);
                    // If a match is found, dynamically bind HTML to clientDetails element
                    $('#clienteditmodal').show();
                    $('.clientEditModal').hide();
                    $('#resulteditmodal').empty();
                    $("#clientName").val(client.name+client.lastname);
                    $("#clienteditDetailsModal").html(
                        `<i class='ico-user2 me-2 fs-6'></i>  ${client.name}  ${client.lastname}`);
                    $('#clientDetails').html(
                        `<div class="client-name">
                                <div class="drop-cap" style="background: #D0D0D0; color:#fff;">${client.name.charAt(0).toUpperCase()}
                                </div>
                                <div class="client-info">
                                    <input type='hidden' name='client_name' value='${client.name} ${client.lastname}'>
                                    <input type='hidden' id="client_id" name='client_id' value='${client.id}'>
                                    <h4 class="blue-bold">${client.name} ${client.lastname}</h4>
                                </div>
                            </div>
                            <div class="mb-2">
                                <a href="#" class="river-bed"><b>${client.mobile_number}</b></a><br>
                                <a href="#" class="river-bed"><b>${client.email}</b></a>
                            </div>
                            <hr>
                            <div class="btns">
                                <button class="btn btn-secondary btn-sm open-client-card-btn" data-client-id="${client.id}" >Client Card</button>
                                <button class="btn btn-secondary btn-sm history" data-client-id="${client.id}" >History</button>
                                <button class="btn btn-secondary btn-sm upcoming" data-client-id="${client.id}" >Upcoming</button>
                            </div>
                            <hr>`
                    );
                    document.getElementById('searcheditmodel').value = '';
                    // Trigger the click event of the history button
                    // $('.history').click();
                    break; // Stop iterating once a match is found
                }
            }
        }
    }
    function setProductSearchModal(value) {
        $('#search_products').val(value); // Set selected value to input field
        $('.products_box').hide();
        
        document.getElementById('search_products').value = value;
        document.getElementById("resultproductmodal").innerHTML = "";

        // Iterate over client_details to find a matching value
        for (const key in product_details) {
            console.log(product_details);
            if (product_details.hasOwnProperty(key)) {
                const product = product_details[key];
                // Check if value matches any field in the product object
                if (product.name === value) {
                    console.log(product);
                    // If a match is found, dynamically bind HTML to productDetails element
                    $('#productDetails').append(
                        `<div class="invo-notice mb-4 closed product-info1" prod_id='${product.id}'>
                            <a href="#" class="btn cross remove_product"><i class="ico-close"></i></a>
                            <input type='hidden' name='casual_product_name[]' value='${product.name}'>
                            <input type='hidden' id="product_id" name='casual_product_id[]' value='${product.id}'>
                            <input type='hidden' id="product_price" name='casual_product_price[]' value='${product.price}'>
                            <input type='hidden' id="product_gst" name='product_gst' value='${product.gst}'>
                            <input type='hidden' id="discount_types" name='casual_discount_types[]' value='amount'>
                            <input type='hidden' id="hdn_discount_surcharge" name='casual_discount_surcharge[]' value='No Discount'>
                            <input type='hidden' id="hdn_discount_amount" name='casual_discount_amount[]' value='0'>
                            <input type='hidden' id="hdn_reason" name='casual_reason[]' value=''>
                            <input type='hidden' id="hdn_who_did_work" name='casual_who_did_work[]' value='no one'>
                            <input type='hidden' id="hdn_edit_amount" name='casual_edit_amount[]' value='0'>
                            <input type='hidden' id="product_type" name='product_type[]' value='${product.product_type}'>
                            <div class="inv-left"><b>${product.name} </b><span class="who_did_work"></span><span class="dis"></span></div>
                            <div class="inv-center">
                                <div class="number-input walk_number_input safari_only form-group mb-0 number">
                                    <button class="c_minus"></button>
                                    <input class="quantity form-control" min="0" name="casual_product_quanitity[]" value="1" type="number">
                                    <button class="c_plus"></button>
                                </div>
                            </div>
                            <div class="inv-number go price"><b>${'$'+product.price}</b> <a href="#" class="btn btn-sm px-0 product-name clickable" product_id="${product.id}" product_name="${product.name}" product_price="${product.price}"><i class="ico-right-arrow fs-2 ms-3"></i></a></div>
                        </div>`
                    );
                    var type='casual';

                    updateSubtotalAndTotal(type); // Update Subtotal and Total

                    document.getElementById('search_products').value = '';
                    break; // Stop iterating once a match is found
                }
            }
        }
    }
    function setProductSearchModalNew(value) {
        $('#search_products_new_customer').val(value); // Set selected value to input field
        $('.products_box_new').hide();
        
        document.getElementById('search_products_new_customer').value = value;
        document.getElementById("resultproductmodalNew").innerHTML = "";

        // Iterate over client_details to find a matching value
        for (const key in product_details) {
            console.log(product_details);
            if (product_details.hasOwnProperty(key)) {
                const product = product_details[key];
                // Check if value matches any field in the product object
                if (product.name === value) {
                    console.log(product);
                    // If a match is found, dynamically bind HTML to productDetails element
                    $('#NewproductDetails').append(
                        `<div class="invo-notice mb-4 closed product-info2" prod_id='${product.id}'>
                            <a href="#" class="btn cross remove_product"><i class="ico-close"></i></a>
                            <input type='hidden' name='new_product_name[]' value='${product.name}'>
                            <input type='hidden' id="product_id" name='new_product_id[]' value='${product.id}'>
                            <input type='hidden' id="product_price" name='new_product_price[]' value='${product.price}'>
                            <input type='hidden' id="product_gst" name='product_gst' value='${product.gst}'>
                            <input type='hidden' id="discount_types" name='new_discount_types[]' value='amount'>
                            <input type='hidden' id="hdn_discount_surcharge" name='new_discount_surcharge[]' value='No Discount'>
                            <input type='hidden' id="hdn_discount_amount" name='new_discount_amount[]' value='0'>
                            <input type='hidden' id="hdn_reason" name='new_reason[]' value=''>
                            <input type='hidden' id="hdn_who_did_work" name='new_who_did_work[]' value='no one'>
                            <input type='hidden' id="hdn_edit_amount" name='new_edit_amount[]' value='0'>
                            <input type='hidden' id="product_type" name='product_type[]' value='${product.product_type}'>
                            <div class="inv-left"><b>${product.name} </b><span class="who_did_work"></span><span class="dis"></span></div>
                            <div class="inv-center">
                                <div class="number-input walk_number_input safari_only form-group mb-0 number">
                                    <button class="n_minus"></button>
                                    <input class="quantity form-control" min="0" name="new_product_quanitity[]" value="1" type="number">
                                    <button class="n_plus"></button>
                                </div>
                            </div>
                            <div class="inv-number go price"><b>${'$'+product.price}</b> <a href="#" class="btn btn-sm px-0 product-name clickable" product_id="${product.id}" product_name="${product.name}" product_price="${product.price}"><i class="ico-right-arrow fs-2 ms-3"></i></a></div>
                        </div>`
                    );
                    var type='new';

                    updateSubtotalAndTotal(type); // Update Subtotal and Total
                    document.getElementById('search_products_new_customer').value = '';
                    break; // Stop iterating once a match is found
                }
            }
        }
    }
    function setProductSearchModalExisting(value) {
        $('#search_products_existing_customer').val(value); // Set selected value to input field
        $('.products_box_existing').hide();
        
        document.getElementById('search_products_existing_customer').value = value;
        document.getElementById("resultproductmodalExisting").innerHTML = "";

        // Iterate over client_details to find a matching value
        for (const key in product_details) {
            console.log(product_details);
            if (product_details.hasOwnProperty(key)) {
                const product = product_details[key];
                // Check if value matches any field in the product object
                if (product.name === value) {
                    console.log(product);
                    // If a match is found, dynamically bind HTML to productDetails element
                    $('#ExistingproductDetails').append(
                        `<div class="invo-notice mb-4 closed product-info3" prod_id='${product.id}'>
                            <a href="#" class="btn cross remove_product"><i class="ico-close"></i></a>
                            <input type='hidden' name='existing_product_name[]' value='${product.name}'>
                            <input type='hidden' id="product_id" name='existing_product_id[]' value='${product.id}'>
                            <input type='hidden' id="product_price" name='existing_product_price[]' value='${product.price}'>
                            <input type='hidden' id="product_gst" name='product_gst' value='${product.gst}'>
                            <input type='hidden' id="hdn_discount_surcharge" name='existing_discount_surcharge[]' value='No Discount'>
                            <input type='hidden' id="hdn_discount_amount" name='existing_discount_amount[]' value='0'>
                            <input type='hidden' id="hdn_reason" name='existing_reason[]' value=''>
                            <input type='hidden' id="discount_types" name='existing_discount_types[]' value='amount'>
                            <input type='hidden' id="hdn_who_did_work" name='existing_who_did_work[]' value='no one'>
                            <input type='hidden' id="hdn_edit_amount" name='existing_edit_amount[]' value='0'>
                            <input type='hidden' id="product_type" name='product_type[]' value='${product.product_type}'>
                            <div class="inv-left"><b>${product.name} </b><span class="who_did_work"></span><span class="dis"></span></div>
                            <div class="inv-center">
                                <div class="number-input walk_number_input safari_only form-group mb-0 number">
                                    <button class="e_minus"></button>
                                    <input class="quantity form-control" min="0" name="existing_product_quanitity[]" value="1" type="number">
                                    <button class="e_plus"></button>
                                </div>
                            </div>
                            <div class="inv-number go price"><b>${'$'+product.price}</b> <a href="#" class="btn btn-sm px-0 product-name clickable" product_id="${product.id}" product_name="${product.name}" product_price="${product.price}"><i class="ico-right-arrow fs-2 ms-3"></i></a></div>
                        </div>`
                    );
                    var type='existing';

                    updateSubtotalAndTotal(type); // Update Subtotal and Total
                    document.getElementById('search_products_existing_customer').value = '';
                    break; // Stop iterating once a match is found
                }
            }
        }
    }
    function updateSubtotalAndTotal(type) {
        if(type === 'casual') {
            var subtotal = 0;
            var discount = 0;
            var discount_type = $('input[name="discount_type"]:checked').val();
            var amountInput = $('#amount').val();
            var amount = parseFloat(amountInput.trim() !== '' ? amountInput : 0);
            var gst = 0;
            $('.product-info1').each(function() {
                if($(this).find('.dis').text() == '')
                {
                    var price = parseFloat($(this).find('#product_price').val()); //parseFloat($(this).find('.price').text().replace('$', ''));
                }
                else
                {
                    var chk_dis_type = $(this).find('#discount_types').val();
                    if(chk_dis_type == 'amount')
                    {
                        if($(this).find('#hdn_discount_surcharge').val() == 'Manual Surcharge')
                        {
                            var price = parseFloat($(this).find('#product_price').val()) + parseFloat($(this).find('#hdn_discount_amount').val());    
                        }else{
                            var price = parseFloat($(this).find('#product_price').val()) - parseFloat($(this).find('#hdn_discount_amount').val());    
                        }
                    }
                    else
                    {
                        if($(this).find('#hdn_discount_surcharge').val() == 'Credit Card Surcharge' || $(this).find('#hdn_discount_surcharge').val() == 'Manual Surcharge')
                        {
                            var price = parseFloat($(this).find('#product_price').val()) + (parseFloat($(this).find('#product_price').val()) * ($(this).find('#hdn_discount_amount').val() / 100));    
                        }
                        else{
                            var price = parseFloat($(this).find('#product_price').val()) - (parseFloat($(this).find('#product_price').val()) * ($(this).find('#hdn_discount_amount').val() / 100));
                        }
                    }                    
                }
                var quantity = parseInt($(this).find('.quantity').val());
                subtotal += price * quantity;

                var text = $(this).find('.dis').text();

                // Regular expression to extract the numerical value
                var regex = /(\$[\d,]+\.\d{2})/;

                // Match the regular expression against the text
                var match = regex.exec(text);

                var discount = 0;

                if (match) {
                    // Extract the numerical value from the matched result
                    discount = match[0].replace(/\$/, ''); // Remove '$' sign
                }

                // if($(this).find('#discount_types').val() == 'percent')
                // {
                //     subtotal = subtotal + parseFloat(discount);
                // }

                if($(this).find('#product_gst').val() == 'yes'){
                    gst += price / 11; // Assuming GST is 11% of total
                } else {
                    gst += 0; // GST is 0 when the condition is not met
                }
            });

            // Calculate discount based on discount type
            if (discount_type === 'percent') {
                discount = (subtotal * amount) / 100; // Calculate percentage discount
            } else if (discount_type === 'amount') {
                discount = amount; // Use the entered amount as the discount
            }

            var dis_sur = $('#discount_surcharge').val();
            if(dis_sur == 'Credit Card Surcharge' || dis_sur == 'Manual Surcharge')
            {
                var total = subtotal + discount; // Calculate total after discount
            }else{
                var total = subtotal - discount; // Calculate total after discount
            }
            
            
            
            var grandTotal = total + gst; // Calculate total including GST
            $('#hdn_subtotal').val(subtotal.toFixed(2));
            $('#hdn_discount').val(discount.toFixed(2));
            $('#hdn_total').val(total.toFixed(2));
            $('#hdn_gst').val(gst.toFixed(2));
            $('.take_payment').attr('main_total',total.toFixed(2));
            // Update the displayed values on the page
            $('.subtotal').text('$' + subtotal.toFixed(2));
            $('.discount').text('$' + discount.toFixed(2));
            $('.total').text('$' + total.toFixed(2));
            $('.gst_total').text('(Includes GST of $' + gst.toFixed(2) + ')');
            // $('.grand-total').text('$' + grandTotal.toFixed(2));
        }
        else if(type === 'new') {
            
            var subtotal = 0;
            var discount = 0;
            var discount_type = $('input[name="discount_type"]:checked').val();
            var amountInput = $('#amount').val();
            var amount = parseFloat(amountInput.trim() !== '' ? amountInput : 0);
            var gst = 0;
            $('.product-info2').each(function() {
                if($(this).find('.dis').text() == '')
                {
                    var price = parseFloat($(this).find('#product_price').val()); //parseFloat($(this).find('.price').text().replace('$', ''));
                }
                else
                {
                    var chk_dis_type = $(this).find('#discount_types').val();
                    if(chk_dis_type == 'amount')
                    {
                        if($(this).find('#hdn_discount_surcharge').val() == 'Manual Surcharge')
                        {
                            var price = parseFloat($(this).find('#product_price').val()) + parseFloat($(this).find('#hdn_discount_amount').val());    
                        }else{
                            var price = parseFloat($(this).find('#product_price').val()) - parseFloat($(this).find('#hdn_discount_amount').val());    
                        }
                    }
                    else
                    {
                        if($(this).find('#hdn_discount_surcharge').val() == 'Credit Card Surcharge' || $(this).find('#hdn_discount_surcharge').val() == 'Manual Surcharge')
                        {
                            var price = parseFloat($(this).find('#product_price').val()) + (parseFloat($(this).find('#product_price').val()) * ($(this).find('#hdn_discount_amount').val() / 100));    
                        }
                        else{
                            var price = parseFloat($(this).find('#product_price').val()) - (parseFloat($(this).find('#product_price').val()) * ($(this).find('#hdn_discount_amount').val() / 100));
                        }
                    }
                }
                var quantity = parseInt($(this).find('.quantity').val());
                subtotal += price * quantity;

                var text = $(this).find('.dis').text();

                // Regular expression to extract the numerical value
                var regex = /(\$[\d,]+\.\d{2})/;

                // Match the regular expression against the text
                var match = regex.exec(text);

                var discount = 0;

                if (match) {
                    // Extract the numerical value from the matched result
                    discount = match[0].replace(/\$/, ''); // Remove '$' sign
                }

                // if($(this).find('#discount_types').val() == 'percent')
                // {
                //     subtotal = subtotal + parseFloat(discount);
                // }

                if($(this).find('#product_gst').val() == 'yes'){
                    gst += price / 11; // Assuming GST is 11% of total
                } else {
                    gst += 0; // GST is 0 when the condition is not met
                }
            });

            // Calculate discount based on discount type
            if (discount_type === 'percent') {
                discount = (subtotal * amount) / 100; // Calculate percentage discount
            } else if (discount_type === 'amount') {
                discount = amount; // Use the entered amount as the discount
            }

            var dis_sur = $('#discount_surcharge').val();
            if(dis_sur == 'Credit Card Surcharge' || dis_sur == 'Manual Surcharge')
            {
                var total = subtotal + discount; // Calculate total after discount
            }else{
                var total = subtotal - discount; // Calculate total after discount
            }
            // var total = subtotal - discount; // Calculate total after discount
            // var gst = total * 0.05; // Assuming GST is 5% of total
            // var grandTotal = total + gst; // Calculate total including GST

            // Update the displayed values on the page
            $('#hdn_subtotal').val(subtotal.toFixed(2));
            $('#hdn_discount').val(discount.toFixed(2));
            $('#hdn_total').val(total.toFixed(2));
            $('#hdn_gst').val(gst.toFixed(2));

            $('.take_payment').attr('main_total',total.toFixed(2));

            $('.subtotal').text('$' + subtotal.toFixed(2));
            $('.discount').text('$' + discount.toFixed(2));
            $('.total').text('$' + total.toFixed(2));
            $('.gst_total').text('(Includes GST of $' + gst.toFixed(2) + ')');
            // $('.grand-total').text('$' + grandTotal.toFixed(2));
        }
        else {
            var subtotal = 0;
            var discount = 0;
            var discount_type = $('input[name="discount_type"]:checked').val();
            var amountInput = $('#amount').val();
            var amount = parseFloat(amountInput.trim() !== '' ? amountInput : 0);
            var gst = 0;
            $('.product-info3').each(function() {
                if($(this).find('.dis').text() == '')
                {
                    var price = parseFloat($(this).find('#product_price').val()); //parseFloat($(this).find('.price').text().replace('$', ''));
                }
                else
                {
                    var chk_dis_type = $(this).find('#discount_types').val();
                    if(chk_dis_type == 'amount')
                    {
                        if($(this).find('#hdn_discount_surcharge').val() == 'Manual Surcharge')
                        {
                            var price = parseFloat($(this).find('#product_price').val()) + parseFloat($(this).find('#hdn_discount_amount').val());    
                        }else{
                            var price = parseFloat($(this).find('#product_price').val()) - parseFloat($(this).find('#hdn_discount_amount').val());    
                        }
                    }
                    else
                    {
                        if($(this).find('#hdn_discount_surcharge').val() == 'Credit Card Surcharge' || $(this).find('#hdn_discount_surcharge').val() == 'Manual Surcharge')
                        {
                            var price = parseFloat($(this).find('#product_price').val()) + (parseFloat($(this).find('#product_price').val()) * ($(this).find('#hdn_discount_amount').val() / 100));    
                        }
                        else{
                            var price = parseFloat($(this).find('#product_price').val()) - (parseFloat($(this).find('#product_price').val()) * ($(this).find('#hdn_discount_amount').val() / 100));
                        }
                    }
                }
                // var price = parseFloat($(this).find('.price').text().replace('$', ''));
                var quantity = parseInt($(this).find('.quantity').val());
                subtotal += price * quantity;

                var text = $(this).find('.dis').text();

                // Regular expression to extract the numerical value
                var regex = /(\$[\d,]+\.\d{2})/;

                // Match the regular expression against the text
                var match = regex.exec(text);

                var discount = 0;

                if (match) {
                    // Extract the numerical value from the matched result
                    discount = match[0].replace(/\$/, ''); // Remove '$' sign
                }

                // if($('input[name="edit_discount_type"]:checked').val() == 'percent')
                // {
                //     subtotal = subtotal + parseFloat(discount);
                // }
                // if($('input[name="edit_discount_type"]:checked').val() == 'percent')
                // {
                //     subtotal = subtotal + parseFloat(discount);
                // }

                if($(this).find('#product_gst').val() == 'yes'){
                    gst += price / 11; // Assuming GST is 11% of total
                } else {
                    gst += 0; // GST is 0 when the condition is not met
                }
            });

            // Calculate discount based on discount type
            if (discount_type === 'percent') {
                discount = (subtotal * amount) / 100; // Calculate percentage discount
            } else if (discount_type === 'amount') {
                discount = amount; // Use the entered amount as the discount
            }
            var dis_sur = $('#discount_surcharge').val();
            if(dis_sur == 'Credit Card Surcharge' || dis_sur == 'Manual Surcharge')
            {
                var total = subtotal + discount; // Calculate total after discount
            }else{
                var total = subtotal - discount; // Calculate total after discount
            }
            // var total = subtotal - discount; // Calculate total after discount
            // var gst = total * 0.05; // Assuming GST is 5% of total
            // var grandTotal = total + gst; // Calculate total including GST

            // Update the displayed values on the page
            $('#hdn_subtotal').val(subtotal.toFixed(2));
            $('#hdn_discount').val(discount.toFixed(2));
            $('#hdn_total').val(total.toFixed(2));
            $('#hdn_gst').val(gst.toFixed(2));

            $('.take_payment').attr('main_total',total.toFixed(2));
            
            $('.subtotal').text('$' + subtotal.toFixed(2));
            $('.discount').text('$' + discount.toFixed(2));
            $('.total').text('$' + total.toFixed(2));
            $('.gst_total').text('(Includes GST of $' + gst.toFixed(2) + ')');
            // $('.grand-total').text('$' + grandTotal.toFixed(2));
        }
    }


    // Assuming you have a function to open the modal
    function openClientCard(clientId) {
        // Find the client details by id
        var client = client_details.find(function(client) {
            return client.id == clientId;
        });

        // Update the modal with the client details
        if (client) {
            $('.modal-title-client').text('Client card - ' + client.name + ' ' + client.lastname);
            $('.client-name .blue-bold').text(client.name + ' ' + client.lastname);
            $('.client-info a:eq(0)').text(client.mobile_number ?? '').attr('href', 'tel:' + client.mobile_number ?? '');
            $('.client-info a:eq(1)').text(client.email).attr('href', 'mailto:' + client.email);
            $('.drop-cap').text(client.name.charAt(0));
            // You can add more fields as needed

            // clien details bind
            $('#id').val(client.id);
            $('#firstname').val(client.name);
            $('#lastname').val(client.lastname);
            $('input[name="gender"][value="' + client.gender + '"]').prop('checked', true);
            $('input[name="email"]').val(client.email);
            $('#date_of_birth').val(client.date_of_birth);
            $('#mobile_number').val(client.mobile_number);
            $('#home_phone').val(client.home_phone);
            $('#work_phone').val(client.work_phone);
            $('#contact_method').val(client.contact_method);
            $('input[name="send_promotions"][value="' + client.send_promotions + '"]').prop('checked', true);
            $('#street_address').val(client.street_address);
            $('#suburb').val(client.suburb);
            $('#city').val(client.city);
            $('#postcode').val(client.postcode);

            // Display client photos dynamically
            if (client.client_photos && client.client_photos.length > 0) {
                $('.photos_count').text(client.client_photos.length);

                var photoContainer = $('.gallery.client-phbox'); // Assuming you have a container for client photos in your modal
                photoContainer.empty(); // Clear previous photos
                client.client_photos.forEach(function(photoUrl) {
                    var img = $('<img>').attr('src', '{{ asset('storage/images/clients_photos/') }}' + '/' + photoUrl.photo_name).addClass('img-fluid');
                    var anchor = $('<a>').attr({
                        'href': '{{ asset('storage/images/clients_photos/') }}' + '/' + photoUrl.photo_name,
                        'data-fancybox': 'mygallery' // Add data-fancybox attribute
                    }).append(img);
                    var figure = $('<figure>').append(anchor);

                    // Create the delete button with a dynamic ID based on the photo index
                    var deleteButton = $('<button>')
                    .addClass('btn black-btn round-6 dt-delete remove_image')
                    .attr('type', 'button')
                    .attr('ids', photoUrl.id)
                    .click(function() {
                        // Functionality to delete the photo based on its ID
                        var photoId = $(this).attr('photos-id');
                        deletePhoto(photoId);
                    })
                    .append($('<i>').addClass('ico-trash'));

                    // Append the delete button to the figure element
                    figure.append(deleteButton);
                    
                    photoContainer.append(figure);
                });
            }
             // Display client documents dynamically
            if (client.client_documents && client.client_documents.length > 0) {
                $('.documents_count').text(client.client_documents.length);
                // client_documents_created_at
                var documentListContainer = $('.client_docs'); // Assuming you have a container for client documents in your modal
                documentListContainer.empty(); // Clear previous documents
                client.client_documents.forEach(function(doc) {
                    // Assuming each document object has a property called 'created_at' representing its creation date
                    var createdDate = new Date(doc.created_at);
                    var formattedDate = formatDate(createdDate); // Assuming formatDate function formats the date appropriately

                    var link = $('<a>').addClass('btn tag icon-btn-left skyblue mb-2').html('<span><i class="ico-pdf me-2 fs-2 align-middle"></i>' + doc.doc_name + '</span><span class="file-date">' + formattedDate + '</span><i class="del ico-trash remove_doc" ids = "'+ doc.doc_id+ '"></i>');
                    var listItem = $('<span>').append(link);
                    documentListContainer.append(listItem);
                });
            }


            // Open the modal
            $('#Client_card').modal('show');
        }
    }

    //format date
    function formatDate(date) {
        const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        const day = date.getDate();
        const monthIndex = date.getMonth();
        const month = months[monthIndex];
        const hours = date.getHours();
        const minutes = date.getMinutes();
        const ampm = hours >= 12 ? 'PM' : 'AM';
        const formattedHours = hours % 12 === 0 ? 12 : hours % 12;
        const formattedMinutes = minutes < 10 ? '0' + minutes : minutes;
        return `${day} ${month} ${formattedHours}:${formattedMinutes} ${ampm}`;
    }

    // Example usage:
    const date = new Date(); // Replace this with your actual date object
    const formattedDate = formatDate(date);

    //submit update client details form
    function SubmitUpdateClientDetails(data,id){
		$.ajax({
			headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: '/clients/' + id,
			type: "PUT",
			data: data,
            success: function(response) {
				// Show a Sweet Alert message after the form is submitted.
				if (response.success) {
					Swal.fire({
						title: "Client!",
						text: "Client Updated successfully.",
						type: "success",
					}).then((result) => {
                        // window.location = "{{url('calender')}}/"
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
    function SubmitEditWaitlistClient(data){
        var url = $("#clientCreate").data("url");
        $.ajax({
            headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: url,
            type: "post",
            data: data,
            async: false,
            success: function(response) {
                // Show a Sweet Alert message after the form is submitted.
                if (response.success) {
                    $('#clientid').val(response.data.id);
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: response.message,
                        info: "error",
                    });
                }
            },
        });
    }
    function wailtlistClientDraggable() {
        var containerEl2 = document.getElementById('waitlist-events');
        var waitingdraggable = new FullCalendar.Draggable(containerEl2, {
            itemSelector: '.fc-event',
            eventData: function (eventEl2) {
                var dataset = eventEl2.dataset;
                return {
                    title: eventEl2.innerText,
                    extendedProps: {
                        client_name: dataset.client_name,
                        service_id: dataset.service_id,
                        client_id: dataset.client_id,
                        category_id: dataset.category_id,
                        duration: dataset.duration,
                        app_id: dataset.app_id,
                        service_name: dataset.service_name
                    }
                };
            }
        });
    }
    function matchProducts(input) {
        var reg = new RegExp(input.trim(), "i");
        var res = [];
        if (input.trim().length === 0) {
            return res;
        }
        for (var i = 0, len = product_details.length; i < len; i++) {
            var product = product_details[i];
            if (product.name && product.name.match(reg)) {
                res.push(product);
            }
        }
        return res;
    }
    function matchProductsNewCustomer(input) {
        var reg = new RegExp(input.trim(), "i");
        var res = [];
        if (input.trim().length === 0) {
            return res;
        }
        for (var i = 0, len = product_details.length; i < len; i++) {
            var product = product_details[i];
            if (product.name && product.name.match(reg)) {
                res.push(product);
            }
        }
        return res;
    }
    function matchProductsExistingCustomer(input) {
        var reg = new RegExp(input.trim(), "i");
        var res = [];
        if (input.trim().length === 0) {
            return res;
        }
        for (var i = 0, len = product_details.length; i < len; i++) {
            var product = product_details[i];
            if (product.name && product.name.match(reg)) {
                res.push(product);
            }
        }
        return res;
    }
    function updateSearchResults(results) {
        var resultList = $('#resultproductmodal');
        resultList.empty(); // Clear previous search results
        for (var i = 0; i < results.length; i++) {
            // resultList.append(`<li>${results[i].name}</li>`); // Update HTML with search results

            resultList.append(`<li onclick='setProductSearchModal("${results[i].name}")'>
                <div class='client-name'>
                    <div class="client-info">
                        <h4 class="blue-bold"> ${results[i].name} (${'$'+results[i].price}) </h4>
                    </div>
                </div>
            </li>`);
        }
        $('.products_box').show(); // Show the product search results box
    }
    function updateSearchResultsNewCustomer(results) {
        var resultList = $('#resultproductmodalNew');
        resultList.empty(); // Clear previous search results
        for (var i = 0; i < results.length; i++) {
            // resultList.append(`<li>${results[i].name}</li>`); // Update HTML with search results

            resultList.append(`<li onclick='setProductSearchModalNew("${results[i].name}")'>
                <div class='client-name'>
                    <div class="client-info">
                        <h4 class="blue-bold"> ${results[i].name} (${'$'+results[i].price}) </h4>
                    </div>
                </div>
            </li>`);
        }
        $('.products_box_new').show(); // Show the product search results box
    }
    function updateSearchResultsExistingCustomer(results) {
        var resultList = $('#resultproductmodalExisting');
        resultList.empty(); // Clear previous search results
        for (var i = 0; i < results.length; i++) {
            // resultList.append(`<li>${results[i].name}</li>`); // Update HTML with search results

            resultList.append(`<li onclick='setProductSearchModalExisting("${results[i].name}")'>
                <div class='client-name'>
                    <div class="client-info">
                        <h4 class="blue-bold"> ${results[i].name} (${'$'+results[i].price}) </h4>
                    </div>
                </div>
            </li>`);
        }
        $('.products_box_existing').show(); // Show the product search results box
    }
    function SubmitWalkIn(formData){
		$.ajax({
			headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: "{{ route('calendar.store-walk-in') }}",
			type: "post",
			data: formData,
            contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
            processData: false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
            cache: false, // To unable request pages to be cached
			success: function(response) {
				
				// Show a Sweet Alert message after the form is submitted.
				if (response.success) {
					
					Swal.fire({
						title: "Walk-In!",
						text: "Your Walk-In created successfully.",
						type: "success",
					}).then((result) => {
                        window.location = "{{url('calender')}}"//'/player_detail?username=' + name;
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
</html>
@endsection