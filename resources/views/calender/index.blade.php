@extends('layouts.sidebar')
@section('title', 'Calender')
@section('content')
<link rel="stylesheet" href="{{ asset('js/formiojs/dist/formio.full.min.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.9.0/fullcalendar.min.css" rel="stylesheet" type="text/css" />
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
                @php
                    $isDisabled = !(Auth::check() && (Auth::user()->role_type == 'admin' || Auth::user()->checkPermission('calender') != 'View Only'));
                @endphp

                <div class="dropdown d-flex w-100">
                    @if (Auth::check() && !$isDisabled)
                        <button class="btn btn-primary btn-md me-3 w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Add
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" id="appointment" href="javascript:void(0);">New appointment</a></li>
                            <li><a class="dropdown-item" id="new_walk_in_sale" href="javascript:void(0);">New walk-in sale</a></li>
                        </ul>
                    @endif
                </div>

                @if (Auth::check() && !$isDisabled)
                    <a href="javascript:void(0);" class="btn btn-wait-list waitlist_btn">
                        <i class="ico-calendar"></i>
                    </a>
                @endif
                </div>
                </div>
                <div class="form-group icon searh_data">
                    <input type="text" id="search" class="form-control" autocomplete="off" placeholder="Search for a client" onkeyup="changeInput(this.value)">
                    <i class="ico-search"></i>
                </div>
                <div class="detaild-theos-scroll">
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
                    @if(count($waitlist) > 0)
                        @foreach($waitlist as $waitlists)
                            @php
                                // Initialize arrays for each waitlist
                                $ser_ids = [];
                                $ser_names = [];
                            @endphp

                            @foreach($waitlists->servid as $wait)
                                @php
                                    $ser_ids[] = $wait;
                                @endphp
                            @endforeach
                            @php
                                $ser_ids_str = implode(',', $ser_ids); // Convert array to comma-separated string
                            @endphp

                            @foreach($waitlists->service_name as $ser)
                                @php
                                    $ser_names[] = $ser;
                                @endphp
                            @endforeach
                            @php
                                $ser_names_str = implode(',', $ser_names); // Convert array to comma-separated string
                                $dur_str = implode(',', $waitlists->duration);
                            @endphp

                            <li class="fc-event" data-app_id="{{$waitlists->id}}" data-client_id="{{$waitlists->client_id}}" data-category_id="{{$waitlists->category_id}}" data-duration="{{$dur_str}}" data-service_name="{{$ser_names_str}}" data-service_id="{{$ser_ids_str}}" data-client_name="{{$waitlists->firstname.' '.$waitlists->lastname}}">
                                <div class="hist-strip">
                                    @php
                                        // Convert the date string to a DateTime object
                                        $date = new DateTime($waitlists->preferred_from_date ?? null);

                                        // Format the date as "D d F" (e.g., "Thu 28 March")
                                        $formattedDate = $date ? $date->format('D d F') : 'Anytime';
                                    @endphp
                                    {{$formattedDate}}
                                    <span><i class="ico-clock me-1 fs-5"></i> {{ \Carbon\Carbon::parse($waitlists->updated_at)->diffForHumans() }}</span>
                                </div>
                                <div class="client-name">
                                    <div class="drop-cap" style="background: #D0D0D0; color:#fff;">
                                        {{ $waitlists->firstname ? strtoupper(substr($waitlists->firstname, 0, 1)) : 'N' }}
                                    </div>
                                    <div class="client-info">
                                        <h4 class="blue-bold" data-clientid="{{ $waitlists->id }}">
                                            {{ $waitlists->firstname ? $waitlists->firstname . ' ' . $waitlists->lastname : 'No client' }}
                                        </h4>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <a href="#" class="river-bed"><b>{{ $waitlists->mobile_number }}</b></a><br>
                                    <a href="#" class="river-bed"><b>{{ $waitlists->email }}</b></a>
                                </div>

                                @foreach($waitlists->service_name as $key => $ser)
                                    @php
                                        $dur = isset($waitlists->duration[$key]) ? $waitlists->duration[$key] : '';
                                        $userFirstName = isset($waitlists->user_firstname) ? $waitlists->user_firstname : '';
                                        $userLastName = isset($waitlists->user_lastname) ? $waitlists->user_lastname : '';
                                        $userName = trim($userFirstName . ' ' . $userLastName);
                                    @endphp
                                    <p>{{ $ser }}</p>
                                    <p>{{ $dur }} Mins with {{ $userName ?: 'Anyone' }}</p>
                                @endforeach

                                <p class="additional_notes" style="display:none;">{{ $waitlists->additional_notes }}</p>
                                <div class="mt-2">
                                    <span class="dropdown show">
                                        <a class="btn btn-primary font-13 alter btn-sm slot-btn me-1 dropdown-toggle more-options-btn" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            More Options
                                        </a>

                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item edit-btn" href="javascript:void(0)" waitlist_id="{{ $waitlists->id }}" id="edit_waitlist_clients" client_id="{{ $waitlists->client_id }}" category_id="{{ $waitlists->category_id }}" duration="{{ $dur }}" service_name="{{ $ser_names_str }}" services_id="{{ $ser_ids_str }}" preferred-from-date="{{ $waitlists->preferred_from_date }}" user-id="{{ $waitlists->user_id }}" preferred-to-date="{{ $waitlists->preferred_to_date }}" additional-notes="{{ $waitlists->additional_notes }}" client-name="{{ $waitlists->firstname.' '.$waitlists->lastname }}">Edit</a>
                                            <a class="dropdown-item delete-btn delete_waitlist_client" href="#" waitlist_id="{{ $waitlists->id }}">Delete</a>
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
                        <span>No data found</span>
                    @endif

                </div>
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
    <div class="add_appointment">
        @include('calender.partials.new-appointment-modal')
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
                            <span class="custname me-3" id="clientEditDetailsModals"> </span>
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
                                    <option value="" selected>Anyone</option>
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
        <input type="hidden" class="edited_total" value="0">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content main_walk_in">
                <div class="modal-header">
                <h4 class="modal-title">Walk-in retail sale @ <span class="walkin_loc_name">Hope Island</span></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
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
                        <form id="create_walkin_casual" name="create_walkin_casual" class="form casual_tab" method="post">
                            @csrf
                            <input type="hidden" id="invoice_id" name="invoice_id" value="" class="invoice_id">
                            <input type="hidden" id="inv_type" name="inv_type" value="" class="inv_type">
                            <input type="hidden" id="appt_id" name="appt_id" value="" class="appt_id">
                            <input type="hidden" name="total_selected_product" id="total_selected_product" value="0" class="total_selected_product">
                            <input type="hidden" name="walk_in_location_id" id="walk_in_location_id" class="walk_in_location_id">
                            <input type="hidden" name="walk_in_client_id" id="walk_in_client_id" class="walk_in_client_id">
                            <input type="hidden" name="hdn_customer_type" id="hdn_customer_type" value="casual">
                            <input type='hidden' id="hdn_subtotal" name='hdn_subtotal' value='0' class="hdn_subtotal">
                            <input type='hidden' id="hdn_total" name='hdn_total' value='0' class="hdn_total">
                            <input type='hidden' id="hdn_gst" name='hdn_gst' value='0' class="hdn_gst">
                            <input type='hidden' id="hdn_discount" name='hdn_discount' value='0' class="hdn_discount">

                            <!--discount hidden fields-->
                            <input type='hidden' id="hdn_main_discount_surcharge" name='hdn_main_discount_surcharge' class="hdn_main_discount_surcharge" value='No Discount'>
                            <input type='hidden' id="hdn_main_discount_type" name='hdn_main_discount_type' class="hdn_main_discount_type" value='amount'>
                            <input type='hidden' id="hdn_main_discount_amount" name='hdn_main_discount_amount' class="hdn_main_discount_amount" value='0'>
                            <input type='hidden' id="hdn_main_discount_reason" name='hdn_main_discount_reason' value='' class="hdn_main_discount_reason">
                            <div class="tab-pane fade show active" id="casual_customer" role="tabpanel">
                                @include('calender.partials.walk-in')
                            </div>
                        </form>
                        <form id="create_walkin_new" name="create_walkin_new" class="form new_tab" method="post" style="display:none;">
                            @csrf
                            <input type="hidden" id="invoice_id" name="invoice_id" value="" class="invoice_id">
                            <input type="hidden" id="inv_type" name="inv_type" value="" class="inv_type">
                            <input type="hidden" id="appt_id" name="appt_id" value="" class="appt_id">
                            <input type="hidden" name="total_selected_product" id="total_selected_product" value="0" class="total_selected_product">
                            <input type="hidden" name="walk_in_location_id" id="walk_in_location_id" class="walk_in_location_id">
                            <input type="hidden" name="walk_in_client_id" id="walk_in_client_id" class="walk_in_client_id">
                            <input type="hidden" name="hdn_customer_type" id="hdn_customer_type" value="casual">
                            <input type='hidden' id="hdn_subtotal" name='hdn_subtotal' value='0' class="hdn_subtotal">
                            <input type='hidden' id="hdn_total" name='hdn_total' value='0' class="hdn_total">
                            <input type='hidden' id="hdn_gst" name='hdn_gst' value='0' class="hdn_gst">
                            <input type='hidden' id="hdn_discount" name='hdn_discount' value='0' class="hdn_discount">

                            <!--discount hidden fields-->
                            <input type='hidden' id="hdn_main_discount_surcharge" name='hdn_main_discount_surcharge' class="hdn_main_discount_surcharge" value='No Discount'>
                            <input type='hidden' id="hdn_main_discount_type" name='hdn_main_discount_type' value='amount' class="hdn_main_discount_type">
                            <input type='hidden' id="hdn_main_discount_amount" name='hdn_main_discount_amount' value='0' class="hdn_main_discount_amount">
                            <input type='hidden' id="hdn_main_discount_reason" name='hdn_main_discount_reason' value='' class="hdn_main_discount_reason">
                            <div class="tab-pane fade show" id="new_customer" role="tabpanel">
                                <div class="row">
                                    <div class="form-group icon col-lg-4">
                                        <label>First Name</label>
                                        <input type="text" id="walkin_first_name" name="walkin_first_name" class="form-control" placeholder="First">
                                    </div>
                                    <div class="form-group icon col-lg-4">
                                        <label>Last Name</label>
                                        <input type="text" id="walkin_last_name" name="walkin_last_name" class="form-control" placeholder="Last">
                                    </div>
                                    <div class="form-group icon col-lg-4">
                                        <label>Email</label>
                                        <input type="text" id="walkin_email" name="walkin_email" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group icon col-lg-4">
                                        <label>Phone</label>
                                            <select class="form-select form-control" name="walkin_phone_type" id="walkin_phone_type">
                                                <option selected="" value=""> -- select an option -- </option>
                                                <option>Mobile</option>
                                                <option>Home</option>
                                                <option>Work</option>
                                            </select>
                                    </div>
                                    <div class="form-group icon col-lg-4">
                                        <label></label>
                                        <input type="text" id="walkin_phone_no" name="walkin_phone_no" class="form-control">
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="form-label">Gender</label>
                                        <div class="toggle form-group">
                                            <input type="radio" name="walkin_gender" value="Male" id="males" checked="checked" />
                                            <label for="males">Male <i class="ico-tick"></i></label>
                                            <input type="radio" name="walkin_gender" value="Female" id="females" />
                                            <label for="females">Female <i class="ico-tick"></i></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="form-label">Preferred contact method</label>
                                            <select class="form-select form-control" name="walkin_contact_method" id="walkin_contact_method">
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
                                            <input type="radio" name="walkin_send_promotions" value="1" id="walkin_yes" checked="checked">
                                            <label for="walkin_yes">Yes <i class="ico-tick"></i></label>
                                            <input type="radio" name="walkin_send_promotions" value="0" id="walkin_no">
                                            <label for="walkin_no">No <i class="ico-tick"></i></label>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-4">
                                @include('calender.partials.walk-in')
                            </div>
                        </form>
                        <form id="create_walkin_existing" name="create_walkin_existing" class="form existing_tab" method="post" style="display:none;">
                            @csrf
                            <input type="hidden" id="invoice_id" name="invoice_id" value="" class="invoice_id">
                            <input type="hidden" id="inv_type" name="inv_type" value="" class="inv_type">
                            <input type="hidden" id="appt_id" name="appt_id" value="" class="appt_id">
                            <input type="hidden" name="total_selected_product" id="total_selected_product" value="0" class="total_selected_product">
                            <input type="hidden" name="walk_in_location_id" id="walk_in_location_id" class="walk_in_location_id">
                            <input type="hidden" name="walk_in_client_id" id="walk_in_client_id" class="walk_in_client_id">
                            <input type="hidden" name="hdn_customer_type" id="hdn_customer_type" value="casual">
                            <input type='hidden' id="hdn_subtotal" name='hdn_subtotal' value='0' class="hdn_subtotal">
                            <input type='hidden' id="hdn_total" name='hdn_total' value='0' class="hdn_total">
                            <input type='hidden' id="hdn_gst" name='hdn_gst' value='0' class="hdn_gst">
                            <input type='hidden' id="hdn_discount" name='hdn_discount' value='0' class="hdn_discount">

                            <!--discount hidden fields-->
                            <input type='hidden' id="hdn_main_discount_surcharge" name='hdn_main_discount_surcharge' class="hdn_main_discount_surcharge" value='No Discount'>
                            <input type='hidden' id="hdn_main_discount_type" name='hdn_main_discount_type' value='amount' class="hdn_main_discount_type">
                            <input type='hidden' id="hdn_main_discount_amount" name='hdn_main_discount_amount' value='0' class="hdn_main_discount_amount">
                            <input type='hidden' id="hdn_main_discount_reason" name='hdn_main_discount_reason' value='' class="hdn_main_discount_reason">
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
                                @include('calender.partials.walk-in')
                                </div>
                            </div>
                        </form>
                </div>
                
                <div class="modal-footer justify-content-between">
                    <div class="mod-ft-left d-flex gap-2">
                        <button type="button" class="btn btn-light-outline-grey btn-md icon-btn-left print_quote"><i class="ico-print3 me-2 fs-6"></i> Print Quote</button>
                        <!-- <button type="button" class="btn btn-light-outline-grey btn-md icon-btn-left"><i class="ico-draft me-2 fs-6"></i> Save sale as a draft</button> -->
                    </div>
                    <div class="mod-ft-right">
                        <button type="button" class="btn btn-light btn-md cancel_payment">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-md take_payment" main_total="" main_remain="" disabled>Take Payment</button>
                    </div>
                </div>
            </div>
            <div class="modal-content edit_product" style="display:none;">
                <div class="modal-header" id="edit_product">
                    <h4 class="modal-title">Edit Product</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="invo-notice mb-4">
                        <input type="hidden" name="edit_product_id" id="edit_product_id">
                        <div class="inv-left"><b class="edit_product_name">VIP Skin treatment</b><div id="dynamic_discount"></div></div>
                        <div class="inv-number edit_product_quantity"><b>1</b></div>
                        <div class="inv-number edit_product_price"><b>$60.00</b>
                            <div class="main_detail_price" style="display:none;">($60.00)</div>
                        </div>
                        
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
                                    <button class="minus edit_minus"></button>
                                    <input  type="number" class="quantity form-control edit_quantity" min="0" name="quantity">
                                    <button class="plus edit_plus"></button>
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
                                    <!-- <option selected>No Discount</option>
                                    <optgroup label="Discount">
                                        <option>Manual Discount</option>
                                        @if(count($loc_dis)>0)
                                            @foreach($loc_dis as $dis)
                                                <option value="{{$dis->discount_percentage}}">{{$dis->discount_type}}</option>
                                            @endforeach
                                        @endif
                                    </optgroup>
                                    <optgroup label="Surcharge">
                                        <option>Manual Surcharge</option>
                                        @if(count($loc_sur)>0)
                                            @foreach($loc_sur as $sur)
                                                <option value="{{$sur->surcharge_percentage}}">{{$sur->surcharge_type}}</option>
                                            @endforeach
                                        @endif
                                    </optgroup> -->
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
                                    <input type="number" class="form-control" id="edit_amount" placeholder="0" min="0">
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
                                    <!-- <option >No Discount</option>
                                    <optgroup label="Discount">
                                        <option selected>Manual Discount</option>
                                        @if(count($loc_dis)>0)
                                            @foreach($loc_dis as $dis)
                                                <option value="{{$dis->discount_percentage}}">{{$dis->discount_type}}</option>
                                            @endforeach
                                        @endif
                                    </optgroup>
                                    <optgroup label="Surcharge">
                                        <option>Manual Surcharge</option>
                                        @if(count($loc_sur)>0)
                                            @foreach($loc_sur as $sur)
                                                <option value="{{$sur->surcharge_percentage}}">{{$sur->surcharge_type}}</option>
                                            @endforeach
                                        @endif
                                    </optgroup> -->
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
                                <input type="number" class="form-control" id="amount" placeholder="0" min="0">
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
                <div class="modal-body main_payment_details">
                    <div class="row payment_details closed-stip payment_details_single">
                        <div class="col-lg-4 p_details">
                            <div class="form-group">
                                <label class="form-label">Payment</label>
                                <input type="hidden" name="hdn_tracking_number[]" class="hdn_tracking_number" data-id="1">
                                <select class="form-select form-control payment_type" name="payment_type[]" id="payment_type" data-id="1">
                                    <option>Card</option>
                                    <option>Afterpay</option>
                                    <option>Bank Transfer</option>
                                    <option>Cash</option>
                                    <option>Humm payment</option>
                                    <option>Zip Pay</option>
                                    <option>Gift Card</option>
                                </select>
                                </div>
                        </div>
                        <div class="col-lg-4 p_details">
                            <div class="form-group">
                                <label class="form-label">Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ico-dollar fs-4"></i></span>
                                    <input type="number" class="form-control payment_amount" name="payment_amount[]" placeholder="0" data-id="1">
                                    
                                    </div>
                                </div>
                        </div>
                        <div class="col-lg-4 p_details">
                            <div class="form-group">
                                <label class="form-label">Date</label>
                                <input type="date" id="datePicker4" name="payment_date[]" class="form-control payment_date" placeholder="date" value="<?php echo date('Y-m-d'); ?>" readonly>
                            </div>
                        </div>
                        <div class="remove_payment cross p_details">
                            <a href="#" class="remove_payment_btn"><button class="btn-close close_waitlist"></button></a>
                        </div>
                    </div>
                    
                    <div class="mb-3 payment_data">
                        <a href="#" class="btn btn-dashed w-100 btn-blue icon-btn-center mb-2 add_another_payment"><i class="ico-ticket-discount me-2 fs-5"></i> Add another payment</a>
                        <div class="form-text d-flex align-items-center"><span class="ico-danger fs-5 me-2"></span> Not all payment type supported</div>
                    </div>

                    <hr class="my-4">

                    <table width="100%">
                        <tbody>
                            <tr>
                                <td><b>Total</b></td>
                                <td class="text-end blue-bold payment_total"><b>$250.00</b></td>
                            </tr>
                            <tr class="remaining_balance_div">
                                <td>Remaining balance</td>
                                <td class="text-end remaining_balance">$0.00</td>
                            </tr>
                            <tr class="change_owing_div" style="display:none;">
                                <td>Change Owing</td>
                                <td class="text-end change_owing">$0.00</td>
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
    <div class="modal fade" id="payment_completed" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">Sale Complete</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="success-pop p-5 mb-4" style="
                    text-align: center;">
                        <img src="{{ asset('img/success-icon.png') }}" alt="" class="mb-3" style="
                    max-width: 12%;">
                    <span id="paymentMessage"></span>
                </div>
                    <div class="form-group mb-3 receipt_form">
                        <label class="form-label"><strong>Send receipt by email</strong></label>
                        <div class="row">
                            <div class="col-lg-10">
                                <input type="text" class="form-control send_email" placeholder="admin@tenderresponse.com.au (use comma for multiple email)">
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-primary btn-md send_payment_mail">Send</button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-light btn-md close_payment">Close</button>
                <button type="button" class="btn btn-primary btn-md print_completed_invoice_single"  walk_in_ids="">Print</button>
                <button type="button" class="btn btn-primary btn-md view_invoice" walk_in_ids="">View Invoice</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="paid_Invoice" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalTitle">Paid invoice</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="invo-notice mb-4">
                        <div class="inv-left"><b id="invoiceDate"></b></div>
                        <div class="inv-number">Invoice number: <span id="invoiceNumber"></span></div>
                    </div>
                    <div class="table-responsive mb-2">
                        <!-- Product table -->
                        <table class="table all-db-table align-middle mb-4" id="productTable">
                            <!-- Table header -->
                            <thead>
                                <tr>
                                    <th class="mine-shaft" width="55%">Items</th>
                                    <th class="mine-shaft" width="20%">Quantity</th>
                                    <th class="mine-shaft" width="25%">Price</th>
                                </tr>
                            </thead>
                            <!-- Table body -->
                            <tbody id="productTableBody">
                                <!-- Product rows will be dynamically added here -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"><b>Subtotal</b></td>
                                    <td id="subtotalProductPrice">
                                        <span class="blue-bold">$2,217.00 </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><b class="prd_dis">Discount</b></td>
                                    <td id="discountProductPrice">
                                        <span class="blue-bold">$2,217.00 </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><b>Total</b></td>
                                    <td id="totalProductPrice">
                                        <span class="blue-bold">$2,217.00 </span><br>
                                        <span class="d-grey font-13" id="totalProductPriceGST">Includes GST of $20.55</span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- Payment table -->
                    <div class="table-responsive mb-2">
                        <table class="table all-db-table align-middle mb-4" id="paymentTable">
                            <!-- Table header -->
                            <thead>
                                <tr>
                                    <th class="mine-shaft" width="55%">Payments</th>
                                    <th class="mine-shaft" width="20%">Date</th>
                                    <th class="mine-shaft" width="25%">Price</th>
                                </tr>
                            </thead>
                            <!-- Table body -->
                            <tbody>
                                <!-- Payment rows will be dynamically added here -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"><b>Total paid</b></td>
                                    <td id="totalPaid">
                                        <span class="blue-bold">$2,217.00 </span>
                                    </td>
                                </tr>
                                <tr class="change" style="display:none;">
                                    <td colspan="2"><b>Change</b></td>
                                    <td id="totalPaid">
                                        <span class="blue-bold change_amount">$0 </span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- Receipt form -->
                    <div class="form-group mb-3 receipt_form">
                        <label class="form-label"><strong>Send receipt by email</strong></label>
                        <div class="row">
                            <div class="col-lg-10">
                                <input type="text" class="form-control send_email_receipt" placeholder="admin@tenderresponse.com.au (use comma for multiple email)">
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-primary btn-md send_receipt_payment_mail">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-md delete_invoice" delete_id="">Delete</button>
                    <button type="button" class="btn btn-light btn-md edit_invoice" edit_id="">Edit</button>
                    <button type="button" class="btn btn-light btn-md cancel_invoice">Cancel</button>
                    <button type="button" class="btn btn-primary btn-md print_completed_invoice_single">Print</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="Redeem_voucher" tabindex="-1" row-id="">
        <input type="hidden" id="is_edit" value="no">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Redeem gift card</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="form-group icon">
                        <input type="text" class="form-control search_gift_card">
                        <i class="ico-search"></i>
                    </div>
                    <div id="gift-card-results"></div>
                    <!-- <div class="invo-notice mb-3" style="display:none;">
                        <div class="inv-left"><b>Voucher #9A6FCCED</b><br>
                            <span class="font-13">
                                <b>Expires:</b> 29 May 2025<br>
                                <b>Created:</b> 29 May 2024
                            </span>
                        </div>

                        <div class="inv-number"><b>$60.00</b><br>
                            <small class="font-13">remaining</small>
                            </div>
                    </div> -->

                    <!-- <div class="invo-notice mb-3" style="background: rgba(44, 44, 44, .07);display:none;">
                        <div class="inv-left"><b>Voucher #9A6FCCED</b><br>
                            <span class="font-13">
                                <b>Expires:</b> 29 May 2025<br>
                                <b>Created:</b> 29 May 2024
                            </span>
                        </div>

                        <div class="inv-number"><b>$60.00</b><br>
                            <small class="font-13">remaining</small>
                            </div>
                    </div> -->
                    <!-- <div class="invo-notice mb-3" style="background: rgba(211, 237, 191, .35);display:none;">
                        <div class="inv-left"><b>Voucher #9A6FCCED</b><br>
                            <span class="font-13">
                                <b>Expires:</b> 29 May 2025<br>
                                <b>Created:</b> 29 May 2024
                            </span>
                        </div>

                        <div class="inv-number"><b>$60.00</b><br>
                            <small class="font-13">remaining</small>
                            </div>
                    </div> -->
                    <!-- <div class="invo-notice mb-3" style="background: rgba(244, 181, 167, .30);display:none;">
                        <div class="inv-left"><b>Voucher #9A6FCCED</b><br>
                            <span class="font-13">
                                <b>Expires:</b> 29 May 2025<br>
                                <b>Created:</b> 29 May 2024
                            </span>
                        </div>

                        <div class="inv-number"><b>$60.00</b><br>
                            <small class="font-13">remaining</small>
                            </div>
                    </div> -->

                    <div class="yellow-note-box p-2"  style="display:none;">
                        <strong>Notes:</strong> test from vrushank
                    </div>

                    <div id="voucher-alert" class="alert alert-danger d-flex align-items-center mb-4 expired" role="alert" style="display: none !important;">
                        This gift card has expired but can still be redeemed
                    </div>
                    <div id="voucher-alert" class="alert alert-danger d-flex align-items-center mb-4 voucher_cancelled" role="alert" style="display: none !important;">
                        This voucher has been cancelled
                    </div>
                    <div id="voucher-alert" class="alert alert-danger d-flex align-items-center mb-4 voucher_already_added" role="alert" style="display: none !important;">
                        This voucher has already been added to the invoice
                    </div>
                    <div id="voucher-alert" class="alert alert-danger d-flex align-items-center mb-4 voucher_no_remaining" role="alert" style="display: none !important;">
                        This voucher has no value remaining
                    </div>

                    <hr class="my-4" style="display:none;">

                    <div class="form-group" id="redemption-amount-section" style="display:none;">
                        <label class="form-label">Redemption amount</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="ico-dollar fs-4"></i></span>
                            <input type="text" class="form-control" placeholder="0" id="redemption-amount">
                        </div>
                    </div>
                    <hr class="my-4" id="voucher-history" style="display: none;">
                        <a class="simple-link collapsed" data-bs-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample" style="display:none;">
                            Gift card history
                        </a>
                        <div class="collapse" id="collapseExample">
                            <table class="table all-db-table align-middle table-striped mb-0 voucher-history">
                                <tr>
                                    <td><strong>Created:</strong> 29 May 2024 as part of batch: vrushank</td>
                                </tr>
                                <tr>
                                    <td><strong>Redeemed:</strong> $10.00 on 30 May 2024</td>
                                </tr>
                                <tr>
                                    <td><strong>Redeemed:</strong> $10.00 on 30 May 2024</td>
                                </tr>
                                <tr>
                                    <td><strong>Redeemed:</strong> $10.00 on 30 May 2024</td>
                                </tr>
                            </table>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-md back_to_payment">Back to payment</button>
                    <button type="button" class="btn btn-primary btn-md redeem_gift_card" style="display:none;">Redeem</button>
                </div>
            </div>
        </div>
    </div>
    @include('calender.partials.client-modal')
    @include('calender.partials.client-services-form')
    @include('calender.partials.repeat-appointment-modal')
    @include('calender.partials.appointment-forms-modal')
    @include('calender.partials.exising-form')
    @include('calender.partials.send_forms_modal')
</div>
@stop
@section('script')
{{-- <script src="{{ asset('js/jquery/dist/jquery.min.js') }}"></script> --}}
<script src="{{ asset('js/@formio/js/dist/formio.form.min.js') }}"></script>
<script src="{{ asset('js/formiojs/dist/formio.full.min.js') }}"></script>
<script src="{{ asset('js/@formio/js/dist/formio.full.js') }}"></script>
<script src="{{ asset('js/section_break.js') }}"></script>
<script src="{{ asset('js/index.js') }}"></script>
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
        getLocation:                  "{!! route('get-all-locations') !!}",
        getSelectedLocation:          "{!! route('calendar.get-selected-location') !!}",
        getCategoriesAndServices:     "{!! route('calendar.get-categories-and-services') !!}",
        getUserSelectedLocation:      "{!! route('calender.get-user-selected-location') !!}",
        getAppointmentForms:          "{!! route('calendar.get-appointment-forms', ':ID')!!}",
        addAppointmentForms:          "{!! route('calendar.add-appointment-forms') !!}",
        deleteAppointmentForms:       "{!! route('calendar.delete-appointment-forms', ':ID' ) !!}",
        sentForms:                    "{!! route('calendar.sent-forms') !!}",
        apptConfirmation:             "{!! route('calendar.appt-confirmation') !!}",
        getforms:                     "{!! route('get-forms') !!}",
        getClientFormsData:           "{!! route('calendar.get-client-forms-data', ':ID' ) !!}",
        updateClientStatusForm:       "{!! route('calendar.update-client-status-form') !!}",
    };

    $(document).ready(function()
    {
        //for permission check store value in localstorage
        var permissionValue = "{{ $permissions }}";
        localStorage.setItem('permissionValue', permissionValue);

        var product_details = [];
        // var discount_types_details = [];
        // var surcharge_types_details = [];
        // console.log('discount_types_details',discount_types_details);
        var today = new Date();
        
        // Set the max attribute of the date pickers to yesterday
        document.getElementById("datePicker1").setAttribute("max", today.toISOString().split('T')[0]);
        // document.getElementById("datePicker2").setAttribute("max", today.toISOString().split('T')[0]);
        // document.getElementById("datePicker3").setAttribute("max", today.toISOString().split('T')[0]);
        // document.getElementById("datePicker4").setAttribute("min", today.toISOString().split('T')[0]);
        // document.getElementById("datePicker4").setAttribute("max", today.toISOString().split('T')[0]);
        
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
            },
            walkin_first_name: {
                required:true
            },
            walkin_last_name: {
                required:true
            },
            walkin_email: {
                required:true,
                email: true,
                    remote: {
                        url: "../clients/checkClientEmail",
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            email: function () {
                                return $("#walkin_email").val();
                            }
                        },
                        dataFilter: function (data) {
                            var json = $.parseJSON(data);
                            return json.exists ? '"Email already exists!"' : '"true"';
                        }
                    }
            },
            walkin_phone_type: {
                required:true
            },
            walkin_phone_no: {
                required:true
            },
            walkin_contact_method: {
                required:true
            },
        };

        $("#create_walkin_casual").validate({
            rules: validationRules,
            messages: {
                casual_staff: {
                    required: "Please select credit sale."
                }
            },
            errorPlacement: function(error, element) {
                // Custom error placement
                error.insertAfter(element); // Display error message after the element
            }
        });
        $("#create_walkin_new").validate({
            rules: validationRules,
            messages: {
                new_staff: {
                    required: "Please select credit sale."
                }
            },
            errorPlacement: function(error, element) {
                // Custom error placement
                error.insertAfter(element); // Display error message after the element
            }
        });
        $("#create_walkin_existing").validate({
            rules: validationRules,
            messages: {
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
            var id = $('#id').val();
            var gallery = $('.client-phbox.photos'); // Selecting the gallery container
            var gallery_history = $('.client-phbox.history'); // Selecting the gallery container
            var uploadedImageIds = []; // Array to hold IDs of uploaded images
            var numFiles = this.files.length; // Store the number of uploaded files
            for (var i = 0; i < numFiles; i++) {
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
                            // Append the image and delete button to the gallery
                            gallery.append('<figure><a href="' + fileContents + '" data-fancybox="mygallery"><img src="' + fileContents + '" alt=""></a><button type="button" class="btn black-btn round-6 dt-delete remove_image latest_remove" ids=""><i class="del ico-trash"></i></button></figure>');
                            gallery_history.append('<figure><a href="' + fileContents + '" data-fancybox="mygallery"><img src="' + fileContents + '" alt=""></a></figure>');
                        };
                    })(currFile);
                    reader.readAsDataURL(this.files[i]);
                    data.append('pics[]', currFile);
                    data.append('id', id);
                } else {
                    if (file_cnt != '') {
                        $('.photos_cnt').text(file_cnt);
                    } else {
                        $('.photos_cnt').text('');
                    }
                }
            }
            if (data.has('pics[]')) {
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
                                var photosCount = parseInt($('.photos_count').text());
                                var resultdoc = photosCount + fileCount;
                                $('.photos_count').text(resultdoc);

                                // Handle success if needed
                                var latestImages = gallery.children('figure').slice(-numFiles); // Get the latest appended images
                                latestImages.each(function(index) {
                                    $(this).find('.latest_remove').attr('ids', uploadedImageIds[index]); // Assign the ID to the corresponding delete button
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
        $(document).on('click', '.close_payment', function(e) {
            $('#payment_completed').modal('hide');
            $('.productDetails').empty();
            $('.NewproductDetails').empty();
            $('.ExistingproductDetails').empty();
            $('#existingclientmodal').hide();
            $('.subtotal').text('$0.00');
            $('.discount').text('$0.00');
            $('.total').text('$0.00');
            $('.gst_total').text('(Includes GST of $0.00)');
            $('#create_walkin_casual')[0].reset();
            $('#create_walkin_new')[0].reset();
            $('#create_walkin_existing')[0].reset();
            $('.main_walk_in').find('.add_discount').each(function() {
                // Update the HTML content of the element
                $(this).html('<i class="ico-percentage me-2 fs-5"></i>Add discount / surcharge');

                // Your additional code logic here for each element with the class 'add_discount'
            });
            $('input[name="discount_type"]').prop('disabled', false);
            $('#amount').prop('disabled', false);
            $('#amount').val(0);
            $('#reason').prop('disabled',false);
            $('#reason').val('');
            $('.discount').each(function() {
                var parentTd = $(this).parent().find('td');
                parentTd.text('Discount');

                var parentTds = $(this).parent().find('.discount');
                parentTds.text('$0.00');
            });
            $('#notes').text('');
            //payment
            $('#payment_type option:first').prop('selected',true);
            $('.send_email').val('');
        })
        $(document).on('click', '.cancel_invoice', function(e) {
            $('#paid_Invoice').modal('hide');
            $('.productDetails').empty();
            $('.NewproductDetails').empty();
            $('.ExistingproductDetails').empty();
            $('#existingclientmodal').hide();
            $('.subtotal').text('$0.00');
            $('.discount').text('$0.00');
            $('.total').text('$0.00');
            $('.gst_total').text('(Includes GST of $0.00)');
            $('#create_walkin_casual')[0].reset();
            $('#create_walkin_new')[0].reset();
            $('#create_walkin_existing')[0].reset();
            $('.main_walk_in').find('.add_discount').each(function() {
                // Update the HTML content of the element
                $(this).html('<i class="ico-percentage me-2 fs-5"></i>Add discount / surcharge');

                // Your additional code logic here for each element with the class 'add_discount'
            });
            $('input[name="discount_type"]').prop('disabled', false);
            $('#amount').prop('disabled', false);
            $('#amount').val(0);
            $('#reason').prop('disabled',false);
            $('#reason').val('');
            $('.discount').each(function() {
                var parentTd = $(this).parent().find('td');
                parentTd.text('Discount');

                var parentTds = $(this).parent().find('.discount');
                parentTds.text('$0.00');
            });
            $('#notes').text('');
            //payment
            $('#payment_type option:first').prop('selected',true);
            $('.send_email').val('');
        })
        $(document).on('click', '.delete_invoice', function(e) {
            var id = $(this).attr('delete_id');
            var url = 'calender/delete-walk-in/' + id; // Corrected the URL construction

            if (confirm("Are you sure to delete this walk-in?")) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data.success) {
                            Swal.fire({
                                title: "Walk-In Sale!",
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
        })
        $(document).on('click', '.edit_invoice', function(e) {
            if($('.total_selected_product').val() == 0)
            {
                $('.take_payment').prop('disabled', true);
            }
            
            var id = $(this).attr('edit_id');
            $.ajax({
                headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{ route('calendar.edit-invoice') }}",
                type: "POST",
                data: {'walk_ids': id},
                success: function (response) {
                    if (response.success) {
                        console.log('data',response.invoice);
                        $('#paid_Invoice').modal('hide');
                        $('#Walkin_Retail').modal('show');
                        var type_cus = response.invoice.customer_type;
                        if(type_cus =='new')
                        {
                            $('.existing_cus').click();
                            $('.nav-link').removeClass('active');
                            $('.existing_cus').addClass('active');
                            $('#existingclientmodal').show();
                            $('.walk_in_client_id').val(response.invoice.client_id);
                            $('#existingclientDetailsModal').html('<i class="ico-user2 me-2 fs-6"></i>' + response.invoice.client_name);
                        }
                        $('.main_walkin').hide();
                        $('.invoice_id').val(response.invoice.id);
                        $('.invoice_date').hide();
                        var invoiceDate = new Date(response.invoice.invoice_date);

                        // Get day, month, and year
                        var day = invoiceDate.getDate();
                        var month = invoiceDate.getMonth() + 1; // Month is zero-based, so add 1
                        var year = invoiceDate.getFullYear();

                        // Ensure day and month are displayed with leading zeros if needed
                        var formattedInvoiceDate = `${day < 10 ? '0' + day : day}-${month < 10 ? '0' + month : month}-${year}`;

                        $('.edit_invoice_date').text(formattedInvoiceDate);

                        $('.edit_invoice_number').text('Invoice number: '+ 'INV' +response.invoice.id)
                        $('.edited_total').val(response.invoice.total);

                        //new code start
                        $('.productDetails').empty();
                        // Iterate over each product in the response
                        $.each(response.invoice.products, function(index, product) {
                            $('.productDetails').append(
                                `<div class="invo-notice mb-4 closed product-info1" prod_id='${product.id}'>
                                    <a href="#" class="btn cross remove_product"><i class="ico-close"></i></a>
                                    <input type='hidden' name='casual_product_name[]' value='${product.product_name}'>
                                    <input type='hidden' id="product_id" name='casual_product_id[]' value='${product.product_id}'>
                                    <input type='hidden' id="product_price" name='casual_product_price[]' value='${product.product_price}'>
                                    <input type='hidden' id="product_gst" name='product_gst' value='${response.invoice.gst}'>
                                    <input type='hidden' id="discount_types" name='casual_discount_types[]' value='${product.discount_type}'>
                                    <input type='hidden' id="hdn_discount_surcharge" name='casual_discount_surcharge[]' value='${product.product_discount_surcharge}'>
                                    <input type='hidden' id="hdn_discount_surcharge_type" name='hdn_discount_surcharge_type[]' value='${product.type}'>
                                    <input type='hidden' id="hdn_discount_amount" name='casual_discount_amount[]' value='${product.discount_amount}'>
                                    <input type='hidden' id="hdn_discount_text" name='casual_discount_text[]' value='${product.discount_value}'>
                                    <input type='hidden' id="hdn_reason" name='casual_reason[]' value='${product.discount_reason}'>
                                    <input type="hidden" id="hdn_who_did_work" name="casual_who_did_work[]" value="${product.who_did_work === null ? '' : product.who_did_work}">
                                    <input type='hidden' id="hdn_edit_amount" name='casual_edit_amount[]' value='0'>
                                    <input type='hidden' id="product_type" name='product_type[]' value='${product.product_type}'>
                                    <div class="inv-left">
                                        <div>
                                            <b>${product.product_name}</b>
                                            <div class="who_did_work">Sold by ${product.user_full_name}</div>
                                            <span class="dis">Discount: $${product.discount_value}</span>
                                        </div>
                                    </div>
                                    <div class="inv-center">
                                        <div class="number-input walk_number_input safari_only form-group mb-0 number">
                                            <button class="c_minus minus"></button>
                                            <input type="number" class="casual_quantity quantity form-control" min="0" name="casual_product_quanitity[]" value="${product.product_quantity}">
                                            <button class="c_plus plus"></button>
                                        </div>
                                    </div>
                                    <div class="inv-number go price">
                                        <div>
                                        <div class="m_p">${'$' + ((product.product_price * product.product_quantity) - (product.discount_value * product.product_quantity)).toFixed(2)}</div>
                                            ${product.product_quantity > 1 ?
                                                `<div class="main_p_price">
                                                    ${('$' + (product.product_price - product.discount_value).toFixed(2) + ' ea')}
                                                </div>` :
                                                `<div class="main_p_price" style="display:none;">
                                                    ${('$' + (product.product_price - product.discount_value).toFixed(2) + ' ea')}
                                                </div>`
                                            }
                                        </div>
                                        <a href="#" class="btn btn-sm px-0 product-name clickable" product_id="${product.id}" product_name="${product.product_name}" product_price="${product.product_price}"><i class="ico-right-arrow fs-2 ms-3"></i></a>
                                    </div>
                                </div>`
                            );
                            $('.total_selected_product').val(parseFloat($('.total_selected_product').val()) + 1);
                            if($('.total_selected_product').val() > 0)
                            {
                                $('.take_payment').prop('disabled', false);
                            }
                        });

                        //subtotal
                        $('.subtotal').text('$'+ response.invoice.subtotal);
                        $('.discount').text('$'+ response.invoice.discount);
                        $('.total').text('$'+ response.invoice.total);
                        $('.gst_total').text("(Includes GST of $" + response.invoice.gst + ")");
                        
                        $('#sale_staff_id').val(response.invoice.user_id);
                        $('#notes').text(response.invoice.note);
                        $('.take_payment').attr('main_total',response.invoice.total);
                        $('.take_payment').attr('main_remain',response.invoice.remaining_balance);

                        //discount
                        $('#discount_surcharge').val(response.invoice.discount_surcharges[0].discount_surcharge);
                        $('input[name="discount_type"][value="' + response.invoice.discount_surcharges[0].discount_type + '"]').prop('checked', true);
                        $('#amount').val(response.invoice.discount_surcharges[0].discount_amount);
                        $('#reason').text(response.invoice.discount_surcharges[0].discount_reason);
                        if(response.invoice.discount_surcharges[0].discount_surcharge == 'Manual Discount')
                        {
                            $('#amount').prop('disabled', false);
                            $('#discount_type').prop('disabled', false);
                            $('#percent_type').prop('disabled', false);
                            $('#reason').prop('disabled', false);
                            $('.discount-row').show();
                        }else if(response.invoice.discount_surcharges[0].discount_surcharge == 'Manual Surcharge')
                        {
                            $('#amount').prop('disabled', false);
                            $('#discount_type').prop('disabled', false);
                            $('#percent_type').prop('disabled', false);
                            $('#reason').prop('disabled', false);
                            $('.discount-row').show();
                        }
                        else{
                            $('#amount').prop('disabled', true);
                            $('#discount_type').prop('disabled', true);
                            $('#percent_type').prop('disabled', true);
                            $('#reason').prop('disabled', true);
                            $('.discount-row').show();
                            $('#reason').val('');
                        }
                        $('.walk_in_location_id').val(response.invoice.location_id);
                        //
                        $('.hdn_main_discount_surcharge').val(response.invoice.discount_surcharges[0].discount_surcharge);
                        $('.hdn_main_discount_type').val(response.invoice.discount_surcharges[0].discount_type);
                        $('.hdn_main_discount_amount').val(response.invoice.discount_surcharges[0].discount_amount);
                        $('.hdn_main_discount_reason').val(response.invoice.discount_surcharges[0].discount_reason);

                        //subtotal
                        $('#hdn_subtotal').val(response.invoice.subtotal);
                        $('#hdn_discount').val(response.invoice.discount);
                        $('#hdn_gst').val(response.invoice.gst);
                        $('#hdn_total').val(response.invoice.total);
                        //new code end
                        $('.take_payment').attr('main_remain',response.invoice.remaining_balance);
                    }
                }
            });
        });
        $(document).on('click', '.show_notes', function(e) {
            e.preventDefault();
            var isDisabled = $(this).attr('disabled') !== undefined;
            if(isDisabled == false)
            {
                var notesDiv = $(this).closest('li').find('.additional_notes');
                notesDiv.toggle(); // Toggle the visibility of notes
            }
        });
        $(document).on('click', '.more-options-btn', function(e) {
            e.preventDefault();
            // $(this).next('.more-options').toggle();
            $(this).next().toggle();
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
                                        <div class="drop-cap" style="background: #D0D0D0; color:#fff;">
                                            ${item.firstname ? item.firstname.charAt(0).toUpperCase() : 'N'}
                                        </div>
                                        <div class="client-info">
                                            <h4 class="blue-bold" data-clientid="${item.client_id}">
                                                ${item.client_id ? `${item.firstname} ${item.lastname}` : 'No client'}
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <a href="#" class="river-bed"><b>${item.client_id ? item.mobile_number : ''}</b></a><br>
                                        <a href="#" class="river-bed"><b>${item.client_id ? item.email : ''}</b></a>
                                    </div>
                                    <!-- Your other content -->
                                    ${item.service_name.map((service, index) => `
                                        <p>${service}</p>
                                        <p>${item.duration[index]} Mins with ${item.user_firstname ? item.user_firstname + ' ' + item.user_lastname : 'Anyone'}</p>
                                    `).join('')}
                                    <p class="additional_notes" style="display:none;">${item.additional_notes}</p>
                                    <div class="mt-2">
                                        <span class="dropdown show">
                                            <a class="btn btn-primary font-13 alter btn-sm slot-btn me-1 dropdown-toggle more-options-btn" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
        $(document).on('click', '.take_payment', function(e) {
            e.preventDefault();
            
            // Check if the form is valid based on the active tab
            var activeTabId = $('.tab-pane.show.active').attr('id');
            var formIsValid = false;
            var formElement;

            if (activeTabId === 'casual_customer') {
                formIsValid = $("#create_walkin_casual").valid();
                formElement = document.getElementById("create_walkin_casual");
            } else if (activeTabId === 'new_customer') {
                formIsValid = $("#create_walkin_new").valid();
                formElement = document.getElementById("create_walkin_new");
            } else if (activeTabId === 'exist_customer') {
                formIsValid = $("#create_walkin_existing").valid();
                formElement = document.getElementById("create_walkin_existing");
            }
            
            if (formIsValid) {
                var data = new FormData(formElement); // Pass the correct form element
                $('#Walkin_Retail').modal('hide');
                $('#take_payment').modal('show');

                if($('.edit_invoice_number:first').text()=='')
                {
                    $('.payment_total').text('$' + $('.take_payment').attr('main_total'));
                }
                else
                {
                    $('.payment_total').text('$' + $('.hdn_total').val());
                }
                $('.payment_amount').val($('.take_payment').attr('main_total'));
                
                // SubmitWalkIn(data);

                //update payment details
                var id = $('#invoice_id').val();
                if (id != '') {
                    $.ajax({
                        headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        url: "{{ route('calendar.edit-invoice') }}",
                        type: "POST",
                        data: { 'walk_ids': id },
                        success: function(response) {
                            if (response.success) {
                                $('.payment_details').remove(); // Clear existing payment details
                                var totalPaymentAmount = 0;

                                // Create the row outside of the loop
                                var paymentRow = $('<div class="row payment_details closed-stip"></div>');

                                // Append payment details from response
                                $.each(response.invoice.payments.reverse(), function(index, payment) {
                                    // Create a clone of the payment row for each payment
                                    var clonedRow = paymentRow.clone();

                                    // Append payment details to the cloned row
                                    clonedRow.append(`
                                        <input type="hidden" class="payment_id" name="payment_id[]" value="${payment.id}">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label">Payment</label>
                                                <select class="form-select form-control payment_type" name="payment_type[]" id="payment_type_${index}">
                                                    <option ${payment.payment_type === 'Card' ? 'selected' : ''}>Card</option>
                                                    <option ${payment.payment_type === 'Afterpay' ? 'selected' : ''}>Afterpay</option>
                                                    <option ${payment.payment_type === 'Bank Transfer' ? 'selected' : ''}>Bank Transfer</option>
                                                    <option ${payment.payment_type === 'Cash' ? 'selected' : ''}>Cash</option>
                                                    <option ${payment.payment_type === 'Humm payment' ? 'selected' : ''}>Humm payment</option>
                                                    <option ${payment.payment_type === 'Zip Pay' ? 'selected' : ''}>Zip Pay</option>
                                                    <option ${payment.payment_type === 'Gift Card' ? 'selected' : ''}>Gift Card</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label">Amount</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="ico-dollar fs-4"></i></span>
                                                    <input type="number" class="form-control payment_amount" name="payment_amount[]" placeholder="0" value="${payment.amount}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label">Date</label>
                                                <input type="date" name="payment_date[]" class="form-control payment_date" placeholder="date" value="${payment.date}" readonly>
                                            </div>
                                        </div>
                                        <div class="remove_payment cross">
                                            <a href="#" class="remove_payment_btn"><button class="btn-close close_waitlist"></button></a>
                                        </div>
                                    `);

                                    // Append the cloned row to the payment details container
                                    $('.payment_data').prepend(clonedRow);

                                    // Add the payment amount to the total payment amount
                                    totalPaymentAmount += parseFloat(payment.amount);
                                });

                                // Update the total payment amount display
                                // $('.payment_total').text('$' + totalPaymentAmount);
                                // $('.remaining_balance').text('$' + $('.take_payment').attr('main_remain'));
                                $('.remaining_balance').text('$' + $('.take_payment').attr('main_remain'));
                                updateRemainingBalance();
                            }
                        }
                    });
                }
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
                                                <a class="btn btn-primary font-13 alter btn-sm slot-btn me-1 dropdown-toggle more-options-btn" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
            var event_id = $(this).attr('event_id');
            var waitlist_id = $(this).attr('waitlist_id');
            if(clientId == "null")
            {
                $('#client_id').val('');
            }else{
                $('#client_id').val(clientId);
            }
            
            var staff_id = $(this).attr('user-id');
            if(staff_id == "null"){
                $('#user_id').val('');
            }else{
                $('#user_id').val(staff_id ? staff_id : '');
            }
            $('#waitlist_id').val(waitlist_id);
            // Set values in modal fields
            $('#latest_staff_id').val(staff_id);
            $('#latest_start_time').val(app_date);
            $('#latest_end_time').val(app_time);
            $('#event_id').val(event_id);
            $('#preferred_from_date').val(app_date);
            $('#preferred_to_date').val(app_time);
            if($(this).attr('additional-notes') =='' || $(this).attr('additional-notes') =="null")
            {
                $('#additional_notes').val('');
            }else{
                $('#additional_notes').val($(this).attr('additional-notes'));
            }
            

            if(clientId == '' || clientId == 'null')
            {
                $('.clientWaitListEditModal').show();
                $('#clientWaitListEditModal').hide();
            }else{
                $('.clientWaitListEditModal').hide();
                // $("#Edit_waitlist_client").modal('show');
            }
            
            $("#Edit_waitlist_client").modal('show');
            $('#clientWaitListEditModal').show();
            $("#clientEditDetailsModals").html(`<i class='ico-user2 me-2 fs-6'></i>${clientName}`);

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
            if(clientId == '' || clientId == 'null')
            {
                $('#clientWaitListEditModal').hide();
            }
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
    // var product_details = @json($productServiceJson);
    // console.log('product_details',product_details);
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
        var location_id = $(this).attr('location_id');
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

        $("#edit_selected_services").append(`<li class='selected remove' test="1" data-appointment_date= "${app_date}"  data-appointment_time= "${app_time}" data-staff_name= "${staff_name}" data-services_id= ${serviceId}  data-category_id= ${categoryId}  data-duration='${duration}' data-location_id='${location_id}'><a href='javascript:void(0);' > ${serviceTitle} </a><span class='btn btn-cross cross-red remove_services'><i class='ico-close'></i></span></li>`);
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
        var searchText = 'Manual Discount';
        $('#discount_surcharge').val($('#discount_surcharge option').filter(function() {
            return $(this).text() === searchText;
        }).val());
        if($(this).text() == 'Edit discount / surcharge')
        {
            $('#main_discount').find('h4').text('Edit discount / surcharge')
            $('#hdn_amt').val($('#amount').val());
            $('#hdn_dis_type').val($('input[name="discount_type"]:checked').val());

            $('#discount_surcharge').val($('.hdn_main_discount_surcharge').val());
        }
    });
    $(document).on('click','.cancel_discount',function(e){
        
        $('.main_discount').hide();
        $('.main_walk_in').show();
        // $('#discount_surcharge').val($('#hdn_discount_surcharge').val());
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
            // $('#amount').val(0);
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
        $('.productDetail .edit_product_price').find('b').text('$' + productPrice.toFixed(2));
        $('.productDetail .main_detail_price').text('$' + productPrice.toFixed(2) + 'ea');
        var cus_type = $('#customer_type').val();
        var edit_prod_id = $('#edit_product_id').val();
        $('.invo-notice').each(function(index, element) {
            if($(this).attr('prod_id') == edit_prod_id)
            {
                $(this).find('.inv-number').find('.m_p').text($('.edit_product_price').find('b').text());
                // $(this).find('.inv-number').find('b').text($('.main_detail_price').text());
                $(this).find('.inv-number').find('.m_p').next().text($('.main_detail_price').text());
                $(this).find('.inv-left').find('.dis').text($('#dynamic_discount').text());
                $(this).find('.quantity').val($('.edit_product_quantity').text());

                if($('.edit_product_quantity').text() > 1)
                {
                    $(this).find('.main_p_price').show();
                }else{
                    $(this).find('.main_p_price').hide();
                }
                $(this).find('#product_price').val($('.edit_price_per_unit').val()); 
                var productPrice = $(this).find('#product_price').val() // Get the text content of edit_product_price
                var priceWithoutDollar = productPrice.replace('$', ''); // Remove the dollar sign
                $(this).find('.product-name').attr('product_price', priceWithoutDollar); // Set the product_price attribute
                $(this).find('#hdn_discount_surcharge_type').val($('#edit_discount_surcharge').find(':selected').parent().attr('label'));
                $(this).find('#hdn_discount_surcharge').val($('#edit_discount_surcharge').find('option:selected').text());
                 
                var discountText = $('#dynamic_discount').text();

                // Extract the amount part
                var amountString = discountText.split('$')[1];

                // Convert the extracted string to a float number
                var amount = parseFloat(amountString);

                // Check if the amount is a valid number
                if (!isNaN(amount)) {
                    // Now 'amount' contains the extracted amount
                    console.log(amount);
                } else {
                    // console.log('Invalid amount');
                    var amount = 0;
                }
                $(this).find('#hdn_discount_amount').val($('#edit_amount').val());
                $(this).find('#hdn_discount_text').val(amount);
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
        $('.hdn_main_discount_surcharge').val($('#discount_surcharge').val());
        $('.hdn_main_discount_type').val($('input[name="discount_type"]:checked').val());
        $('.hdn_main_discount_amount').val($('#amount').val());
        $('.hdn_main_discount_reason').val($('#reason').val());
    })
    $(document).on('click', '.c_minus', function(e) {
        var type = "casual";
        var $currentDiv = $(this).closest('.product-info1');
        var chk_dis_type = $currentDiv.find('#discount_types').val();

        var main_price = parseFloat($currentDiv.find('#product_price').val());
        var price_amt;

        // Calculate price based on discount type
        if (chk_dis_type == 'percent') {
            var discount = parseFloat($currentDiv.find('#hdn_discount_amount').val() || 0);
            if ($currentDiv.find('.inv-left .dis').text() == '') {
                price_amt = main_price;
            } else {
                if ($currentDiv.find('#hdn_discount_surcharge_type').val() == 'Surcharge') {
                    price_amt = main_price + (main_price * (discount / 100));
                } else {
                    price_amt = main_price - (main_price * (discount / 100));
                }
            }
        } else {
            var discount = parseFloat($currentDiv.find('#hdn_discount_amount').val() || 0);
            if ($currentDiv.find('.inv-left .dis').text() == '') {
                price_amt = parseFloat(main_price);
            } else {
                if ($currentDiv.find('#hdn_discount_surcharge_type').val() == 'Surcharge') {
                    price_amt = parseFloat(main_price) + discount;
                } else {
                    price_amt = parseFloat(main_price) - discount;
                }
            }
        }

        // Update quantity for the current product
        var $input = $currentDiv.find('input.quantity');
        var newQuantity = parseInt($input.val()) - 1;
        newQuantity = newQuantity < 1 ? 1 : newQuantity; // Ensure quantity doesn't go below 1
        $input.val(newQuantity);

        // Update price for the current product
        var newPrice = price_amt * newQuantity;
        $currentDiv.find('.m_p').text('$' + newPrice);

        // Show the main_p_price if quantity is greater than or equal to 1
        if (newQuantity == 1) {
            $currentDiv.find('.main_p_price').hide();
        }else{
            $currentDiv.find('.main_p_price').show();
        }
        

        // Update quantity and price in other tabs
        $('.tab-pane').not($currentDiv.closest('.tab-pane')).each(function() {
            var $otherTab = $(this);
            $otherTab.find('.product-info1').each(function() {
                var $otherProduct = $(this);
                var productId = $otherProduct.attr('prod_id');

                if ($currentDiv.attr('prod_id') === productId) {
                    var $quantity = $otherProduct.find('.quantity');
                    var $price = $otherProduct.find('.m_p');

                    if ($quantity.length > 0) {
                        var newQuantity = parseInt($quantity.val()) - 1;
                        newQuantity = newQuantity < 1 ? 1 : newQuantity; // Ensure quantity doesn't go below 1
                        $quantity.val(newQuantity);

                        var nPrice = price_amt;
                        $price.text('$' + nPrice * newQuantity);
                    }
                    // Exit the loop once the product is found
                    return false;
                }
            });
        });

        // Update discount display
        var textValue = $currentDiv.find('.dis').text();
        var regex = /\$([\d.]+)/;
        var match = textValue.match(regex);

        if (match && match.length > 1) {
            var discountAmount = parseFloat(match[1]);

            // Calculate new discount amount based on discount type
            var newDiscountAmount = discountAmount;
            if (chk_dis_type == 'percent') {
                var editAmountValue = $currentDiv.find('#hdn_discount_amount').val();
                var parsedEditAmount = editAmountValue !== "" ? parseFloat(editAmountValue) : 0;

                var discount = (parseFloat(main_price) * parsedEditAmount) / 100;
                // newDiscountAmount = discountAmount - discount;
            } else {
                var editAmountValue = $currentDiv.find('#hdn_discount_amount').val();
                var parsedEditAmount = editAmountValue !== "" ? parseFloat(editAmountValue) : 0;

                // newDiscountAmount = discountAmount - parsedEditAmount;
            }
            newDiscountAmount = Math.max(newDiscountAmount, 0);

            // Update displayed discount value
            if ($currentDiv.find('#hdn_discount_surcharge_type').val() == 'Surcharge') {
                $currentDiv.find('.dis').text("( Surcharge: $" + newDiscountAmount.toFixed(2) + ")");
                $('#dynamic_discount').text(' Surcharge: $' + newDiscountAmount.toFixed(2));
            } else {
                $currentDiv.find('.dis').text("( Discount: $" + newDiscountAmount.toFixed(2) + ")");
                $('#dynamic_discount').text(' Discount: $' + newDiscountAmount.toFixed(2));
            }
        }

        updateSubtotalAndTotal(type);
        return false;
    });

    $(document).on('click', '.c_plus', function(e) {
        var type = "casual";
        var $currentDiv = $(this).closest('.product-info1');
        var chk_dis_type = $currentDiv.find('#discount_types').val();

        var main_price = parseFloat($currentDiv.find('#product_price').val());
        var price_amt;

        // Calculate price based on discount type
        if (chk_dis_type == 'percent') {
            var discount = parseFloat($currentDiv.find('#hdn_discount_amount').val() || 0);
            if ($currentDiv.find('.inv-left .dis').text() == '') {
                price_amt = main_price;
            } else {
                if ($currentDiv.find('#hdn_discount_surcharge_type').val() == 'Surcharge') {
                    price_amt = main_price + (main_price * (discount / 100));
                } else {
                    price_amt = main_price - (main_price * (discount / 100));
                }
            }
        } else {
            var discount = parseFloat($currentDiv.find('#hdn_discount_amount').val() || 0);
            if ($currentDiv.find('.inv-left .dis').text() == '') {
                price_amt = parseFloat(main_price);
            } else {
                if ($currentDiv.find('#hdn_discount_surcharge_type').val() == 'Surcharge') {
                    price_amt = parseFloat(main_price) + discount;
                } else {
                    price_amt = parseFloat(main_price) - discount;
                }
            }
        }

        // Update quantity for the current product
        var $input = $currentDiv.find('input.quantity');
        var newQuantity = parseInt($input.val()) + 1;
        $input.val(newQuantity);

        // Update price for the current product
        var newPrice = price_amt * newQuantity;
        $currentDiv.find('.m_p').text('$' + newPrice);

        // Show the main_p_price if quantity is greater than or equal to 1
        if (newQuantity >= 1) {
            $currentDiv.find('.main_p_price').show();
        }

        // Update quantity and price in other tabs
        $('.tab-pane').not($currentDiv.closest('.tab-pane')).each(function() {
            var $otherTab = $(this);
            $otherTab.find('.product-info1').each(function() {
                var $otherProduct = $(this);
                var productId = $otherProduct.attr('prod_id');

                if ($currentDiv.attr('prod_id') === productId) {
                    var $quantity = $otherProduct.find('.quantity');
                    var $price = $otherProduct.find('.m_p');

                    if ($quantity.length > 0) {
                        var newQuantity = parseInt($quantity.val()) + 1;
                        $quantity.val(newQuantity);

                        var nPrice = price_amt;
                        $price.text('$' + nPrice * newQuantity);

                        if (newQuantity === 1) {
                            $currentDiv.find('.main_p_price').hide();
                        } else {
                            $currentDiv.find('.main_p_price').show();
                        }
                    }
                    // Exit the loop once the product is found
                    return false;
                }
            });
        });

        // Update discount display
        var textValue = $currentDiv.find('.dis').text();
        var regex = /\$([\d.]+)/;
        var match = textValue.match(regex);

        if (match && match.length > 1) {
            var discountAmount = parseFloat(match[1]);

            // Calculate new discount amount based on discount type
            var newDiscountAmount = discountAmount;
            if (chk_dis_type == 'percent') {
                var editAmountValue = $currentDiv.find('#hdn_discount_amount').val();
                var parsedEditAmount = editAmountValue !== "" ? parseFloat(editAmountValue) : 0;

                var discount = (parseFloat(main_price) * parsedEditAmount) / 100;
                // newDiscountAmount = discountAmount + discount;
            } else {
                var editAmountValue = $currentDiv.find('#hdn_discount_amount').val();
                var parsedEditAmount = editAmountValue !== "" ? parseFloat(editAmountValue) : 0;

                // newDiscountAmount = discountAmount + parsedEditAmount;
            }
            newDiscountAmount = Math.max(newDiscountAmount, 0);

            // Update displayed discount value
            if ($currentDiv.find('#hdn_discount_surcharge_type').val() == 'Surcharge') {
                $currentDiv.find('.dis').text("( Surcharge: $" + newDiscountAmount.toFixed(2) + ")");
                $('#dynamic_discount').text(' Surcharge: $' + newDiscountAmount.toFixed(2));
            } else {
                $currentDiv.find('.dis').text("( Discount: $" + newDiscountAmount.toFixed(2) + ")");
                $('#dynamic_discount').text(' Discount: $' + newDiscountAmount.toFixed(2));
            }
        }

        updateSubtotalAndTotal(type);
        return false;
    });



    $(document).on('keyup', '.casual_quantity', function(e) {
        var type = 'casual';
        var $currentDiv = $(this).closest('.product-info1'); // Reference to the current div
        var quantity = parseInt($(this).val());
        var mainPrice = parseFloat($currentDiv.find('#product_price').val());
        var discountAmount = parseFloat($currentDiv.find('.dis').text().replace(/[^\d.]/g, '')) || 0;

        // Calculate the total price based on quantity and discounts
        var totalPrice = mainPrice * quantity - discountAmount;

        // Update the displayed price
        $currentDiv.find('.inv-number .m_p').text('$' + totalPrice.toFixed(2));

        // Trigger subtotal update
        updateSubtotalAndTotal(type);
    });
    $(document).on('click', '.edit_minus', function() {
        // Decrement quantity if greater than 1
        var quantityInput = $('.edit_quantity');
        var currentQuantity = parseInt(quantityInput.val());
        if (currentQuantity > 1) {
            quantityInput.val(currentQuantity - 1);
            $('.edit_product_quantity').text(currentQuantity - 1);
            if(currentQuantity - 1 == 1)
            {
                $('.main_detail_price').hide();
            }
            calculateAndUpdate(); // Update total and recalculate
        }
    });

    $(document).on('click', '.edit_plus', function() {
        // Increment quantity
        var quantityInput = $('.edit_quantity');
        var currentQuantity = parseInt(quantityInput.val());
        quantityInput.val(currentQuantity + 1);
        $('.edit_product_quantity').text(currentQuantity + 1);
        if(currentQuantity + 1 >= 1)
        {
            var text = $('#dynamic_discount').text();
            // Use a regular expression to extract the number
            var text = $('#dynamic_discount').text();
            var number = 0; // Default value is 0
            // Check if text is not null and matches the regular expression
            if (text !== null) {
                var match = text.match(/\d+\.\d+/);
                // If the match is found, parse the number
                if (match !== null) {
                    number = parseFloat(match[0]);
                }
            }

            var pricePerUnit = parseFloat($('.edit_price_per_unit').val());
            var discountedPrice = pricePerUnit - number;
            $('.main_detail_price').text('$' + discountedPrice.toFixed(2) + 'ea');
            $('.main_detail_price').show();
        }
        calculateAndUpdate(); // Update total and recalculate
    });


    $(document).on('click', '.casual_cus', function(e) {
        e.preventDefault(); // Prevent default link behavior
        var activeTab = $('.tab-pane.active').find('.productDetails');
        // Iterate over each .productDetails element
        activeTab.find('.product-info1').each(function() {
            if($(this).find('.casual_quantity').val() == 1)
            {
                $(this).find('.main_p_price').hide();
            }else{
                $(this).find('.main_p_price').show();
            }
        });
        $('#new_customer').hide();
        $('#casual_customer').show();
        $('#exist_customer').hide();
        // $('.total_selected_product').val('0');
        if($('.total_selected_product').val() == 0)
        {
            $('.take_payment').prop('disabled', true);
        }
        // if($('.casual_quantity').val() > 1)
        // {
        //     $('.main_p_price').show();
        // }else{
        //     $('.main_p_price').hide();
        // }
        $('#hdn_customer_type').val('casual');
        $('#customer_type').val('casual');
        // $("#casual_customer").load(location.href + " #casual_customer");
        // $('.add_dis').find('.subtotal').text('$0.00');
        // $('.add_dis').find('.discount').text('$0.00');
        // $('.add_dis').find('.total').text('$0.00');
        // $('#amount').val(0);
        $('#discount_surcharge').val('Manual Discount');
        $('#amount').prop('disabled', false);
        $('#discount_type').prop('disabled', false);
        $('#percent_type').prop('disabled', false);
        $('#reason').prop('disabled', false);
        $('.discount-row').show();
        $('#reason').val('');
    });
    $(document).on('click', '.new_cus', function(e) {
        var activeTab = $('.tab-pane.active').find('.productDetails');
        // Iterate over each .productDetails element
        activeTab.find('.product-info1').each(function() {
            if($(this).find('.casual_quantity').val() == 1)
            {
                $(this).find('.main_p_price').hide();
            }else{
                $(this).find('.main_p_price').show();
            }
        });
        e.preventDefault(); // Prevent default link behavior
        $('#casual_customer').hide();
        $('#exist_customer').hide();
        $('#new_customer').show();
        $('.new_tab').show();
        // $('.total_selected_product').val('0');
        if($('.total_selected_product').val() == 0)
        {
            $('.take_payment').prop('disabled', true);
        }
        // if($('.casual_quantity').val() > 1)
        // {
        //     $('.main_p_price').show();
        // }else{
        //     $('.main_p_price').hide();
        // }
        $('#hdn_customer_type').val('new');
        $('#customer_type').val('new');
        // $("#new_customer").load(location.href + " #new_customer");
        // $('.add_dis').find('.subtotal').text('$0.00');
        // $('.add_dis').find('.discount').text('$0.00');
        // $('.add_dis').find('.total').text('$0.00');
        // $('#amount').val(0);
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
        var activeTab = $('.tab-pane.active').find('.productDetails');
        // Iterate over each .productDetails element
        activeTab.find('.product-info1').each(function() {
            if($(this).find('.casual_quantity').val() == 1)
            {
                $(this).find('.main_p_price').hide();
            }else{
                $(this).find('.main_p_price').show();
            }
        });
        $('#casual_customer').hide();
        $('.existing_tab').show();
        $('#exist_customer').show();
        $('#new_customer').hide();
        // $('.total_selected_product').val('0');
        if($('.total_selected_product').val() == 0)
        {
            $('.take_payment').prop('disabled', true);
        }
        // if($('.casual_quantity').val() > 1)
        // {
        //     $('.main_p_price').show();
        // }else{
        //     $('.main_p_price').hide();
        // }
        $('#hdn_customer_type').val('existing');
        $('#customer_type').val('existing');
        // $("#exist_customer").load(location.href + " #exist_customer");
        // $('.add_dis').find('.subtotal').text('$0.00');
        // $('.add_dis').find('.discount').text('$0.00');
        // $('.add_dis').find('.total').text('$0.00');
        // $('#amount').val(0);
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

        var selectedOption = $(this).find('option:selected');
        var optgroupLabel = selectedOption.parent().attr('label');
        
        if(optgroupLabel == 'Discount')
        {
            $('input[name="edit_discount_type"][value="percent"]').prop('checked', true);

            // Set the discount amount dynamically based on the selected dropdown value
            var discountValue = parseFloat($(this).val());
            if (isNaN(discountValue)) {
                discountValue = 0;
            }
            var pricePerUnit = parseFloat($('.edit_price_per_unit').val());
            var quantity = parseInt($('.edit_quantity').val());
            var totalAmount = pricePerUnit;
            var discountAmount = totalAmount * (discountValue / 100); // Calculate discount based on selected dropdown value

            // Update dynamic discount display
            $dynamicDiscount.text(' Discount: $' + discountAmount.toFixed(2));

            $amount.val(discountValue).prop('disabled', true); // Set the dropdown value to the discount field
            // $reason.val('Credit Card Surcharge').prop('disabled', true);

            // Recalculate edit_product_price with the discounted amount
            var newPrice = (totalAmount * quantity)- (discountAmount * quantity);

            // Update edit_product_price
            $('.edit_product_price').find('b').text('$' + newPrice.toFixed(2));
            var text = $('#dynamic_discount').text();
            // Use a regular expression to extract the number
            var text = $('#dynamic_discount').text();
            var number = 0; // Default value is 0
            // Check if text is not null and matches the regular expression
            if (text !== null) {
                var match = text.match(/\d+\.\d+/);
                // If the match is found, parse the number
                if (match !== null) {
                    number = parseFloat(match[0]);
                }
            }

            $('.main_detail_price').text('$' + (pricePerUnit - number).toFixed(2) + 'ea');

            // Re-enable disabled fields
            // $amount.prop('disabled', false);
            $reason.prop('disabled', true);
            if($(this).find('option:selected').text() == 'Manual Discount')
            {
                $discountType.prop('disabled', false);
                $reason.val('');
                $amount.prop('disabled', false);
                $reason.prop('disabled', false);
            }else{
                $discountType.prop('disabled', true);
                $reason.val($('#edit_discount_surcharge').find('option:selected').text());
                $amount.prop('disabled', true);
            }
        }
        else if(optgroupLabel == 'Surcharge'){
            // Set the discount amount dynamically based on the selected dropdown value
            var discountValue = parseFloat($(this).val());
            if (isNaN(discountValue)) {
                discountValue = 0;
            }
            var pricePerUnit = parseFloat($('.edit_price_per_unit').val());
            var quantity = parseInt($('.edit_quantity').val());
            var totalAmount = pricePerUnit * quantity;
            var discountAmount = totalAmount * (discountValue / 100); // Calculate discount based on selected dropdown value

            // Update dynamic discount display
            $dynamicDiscount.text(' Surcharge: $' + discountAmount.toFixed(2));

            $amount.val(discountValue).prop('disabled', true); // Set the dropdown value to the discount field
            // $reason.val('Credit Card Surcharge').prop('disabled', true);

            // Recalculate edit_product_price with the discounted amount
            var newPrice = totalAmount + discountAmount;

            // Update edit_product_price
            $('.edit_product_price').find('b').text('$' + newPrice.toFixed(2));

            var text = $('#dynamic_discount').text();
            // Use a regular expression to extract the number
            var text = $('#dynamic_discount').text();
            var number = 0; // Default value is 0
            // Check if text is not null and matches the regular expression
            if (text !== null) {
                var match = text.match(/\d+\.\d+/);
                // If the match is found, parse the number
                if (match !== null) {
                    number = parseFloat(match[0]);
                }
            }

            $('.main_detail_price').text('$' + (pricePerUnit + number).toFixed(2) + 'ea');
            

            // Re-enable disabled fields
            // $amount.prop('disabled', false);
            $reason.prop('disabled', true);
            if($(this).find('option:selected').text() == 'Manual Surcharge')
            {
                // $discountType.prop('disabled', false);
                $('input[name="edit_discount_type"]').prop('disabled', false);
                $reason.val('');
                $amount.prop('disabled', false);
                $reason.prop('disabled', false);
            }else{
                $discountType.prop('disabled', true);
                $reason.val($('#edit_discount_surcharge').find('option:selected').text());
                $('input[name="edit_discount_type"][value="percent"]').prop('checked', true).prop('disabled', true);
                $amount.prop('disabled', true);
            }
        }
        else{
            $discountType.prop('disabled', true);
            $amount.prop('disabled', true);
            $reason.prop('disabled', true);
            $amount.val('');
            $reason.val('');
            
            // Remove dynamic discount
            $dynamicDiscount.text('');
            
            // Recalculate edit_product_price
            calculatePrice();
        }
    });
    $(document).on('change', '#edit_discount_type, #edit_amount, .edit_price_per_unit, .edit_quantity', function() {
        var quantityInput = $('.edit_quantity');
        var currentQuantity = parseInt(quantityInput.val());
        quantityInput.val(currentQuantity);
        $('.edit_product_quantity').text(currentQuantity);
        // updateQuantity();
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
        if(quanitity > 1)
        {
            $('.main_detail_price').show();
        }else{
            $('.main_detail_price').hide();
        }
        $('#edit_product_id').val(id);
        $('.edit_product_name').text(name);
        $('.edit_product_quantity').text(quanitity);
        // $('.edit_product_price').text('$' + (price * quanitity - dis_price));
        $('.edit_product_price').find('b').text($(this).parent().find('.m_p').text());
        $('.main_detail_price').text('($' + price + ' ea)');
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
            var searchText = 'Manual Discount';
            $('#edit_discount_surcharge').val($('#edit_discount_surcharge option').filter(function() {
                return $(this).text() === searchText;
            }).val());
            $('#dynamic_discount').text('Discount: $' + $(this).parent().parent().find('#hdn_discount_text').val());
            $('#edit_amount').val($(this).parent().parent().find('#hdn_discount_amount').val());
            $('#edit_reason').val($(this).parent().parent().find('#hdn_reason').val());
            $('#edit_sale_staff_id').val($(this).parent().parent().find('#hdn_who_did_work').val())
        }else if(ck_sur == 'Manual Surcharge'){
            $('#edit_discount_type, #edit_amount, #edit_reason').prop('disabled', false);
            var searchText = 'Manual Surcharge';
            $('#edit_discount_surcharge').val($('#edit_discount_surcharge option').filter(function() {
                return $(this).text() === searchText;
            }).val());
            $('#dynamic_discount').text('Surcharge: $' + $(this).parent().parent().find('#hdn_discount_text').val());
            $('#edit_amount').val($(this).parent().parent().find('#hdn_discount_amount').val());
            $('#edit_reason').val($(this).parent().parent().find('#hdn_reason').val());
            $('#edit_sale_staff_id').val($(this).parent().parent().find('#hdn_who_did_work').val())
        }
        else{
            var searchText = $(this).parent().parent().find('#hdn_discount_surcharge').val();
            $('#edit_discount_surcharge').val($('#edit_discount_surcharge option').filter(function() {
                return $(this).text() === searchText;
            }).val());
            // $('#edit_discount_surcharge').val($(this).parent().parent().find('#hdn_discount_surcharge').val());
            var totalPrice = parseFloat(price) * quanitity;
            $('#dynamic_discount').text('Discount: $' + $(this).parent().parent().find('#hdn_discount_text').val());
            $('#edit_discount_type, #edit_amount, #edit_reason').prop('disabled', true);
            $('#edit_amount').val($(this).parent().parent().find('#hdn_discount_amount').val());
            $('#edit_reason').val($(this).parent().parent().find('#hdn_reason').val());
            $('#edit_sale_staff_id').val($(this).parent().parent().find('#hdn_who_did_work').val())
        }
    });

    $(document).on('click', '.remove_product', function() {
        var $productElement = $(this).closest('.product-info1'); // Get the closest product-info1 element to the clicked remove button
        var productId = $productElement.attr('prod_id'); // Get the product ID of the element to be removed

        // Remove the product element from the current tab
        $productElement.remove();

        // Remove the product element from all other tabs
        $('.tab-pane').find('.product-info1').each(function() {
            if ($(this).attr('prod_id') == productId) {
                $(this).remove();
            }
        });

        // Update the total selected products and the button state
        var type = $('#customer_type').val();
        var totalSelectedProducts = parseInt($('.total_selected_product').val()) - 1;
        $('.total_selected_product').val(totalSelectedProducts);
        if (totalSelectedProducts == 0) {
            $('.take_payment').prop('disabled', true);
        }
        updateSubtotalAndTotal(type); // Update Subtotal and Total
    });
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
    $(document).on('click','.cancel_payment',function(){
        $('#Walkin_Retail').modal('hide');
        $('.productDetails').empty();
        $('.NewproductDetails').empty();
        $('.ExistingproductDetails').empty();
        $('#existingclientmodal').hide();
        $('.subtotal').text('$0.00');
        $('.discount').text('$0.00');
        $('.total').text('$0.00');
        $('.gst_total').text('(Includes GST of $0.00)');
        $('#create_walkin_casual')[0].reset();
        $('#create_walkin_new')[0].reset();
        $('#create_walkin_existing')[0].reset();
        $('.main_walk_in').find('.add_discount').each(function() {
            // Update the HTML content of the element
            $(this).html('<i class="ico-percentage me-2 fs-5"></i>Add discount / surcharge');

            // Your additional code logic here for each element with the class 'add_discount'
        });
        $('input[name="discount_type"]').prop('disabled', false);
        $('#amount').prop('disabled', false);
        $('#amount').val(0);
        $('#reason').prop('disabled',false);
        $('#reason').val('');
        $('.discount').each(function() {
            var parentTd = $(this).parent().find('td');
            parentTd.text('Discount');

            var parentTds = $(this).parent().find('.discount');
            parentTds.text('$0.00');
        });
        $('#notes').text('');
        //payment
        $('#payment_type option:first').prop('selected',true);
    })
    $(document).on('click', '.add_another_payment', function() {
        var lastRowId = 0;
        var totalPaymentAmount = parseFloat($('.take_payment').attr('main_total')); // Get the total payment amount
        var currentPaymentsTotal = 0; // Declare currentPaymentsTotal here

        $('.payment_details').each(function() {
            var currentId = parseInt($(this).find('.payment_amount').attr('data-id'));
            var currentPayment = parseFloat($(this).find('.payment_amount').val());
            currentPaymentsTotal += isNaN(currentPayment) ? 0 : currentPayment;

            if (currentId > lastRowId) {
                lastRowId = currentId;
            }
        });

        var remainingBalance = totalPaymentAmount - currentPaymentsTotal;
        var newRowId = lastRowId + 1;
        var paymentDetailsClone = $('.payment_details').first().clone(); // Clone the first .payment_details div
        console.log('paymentDetailsClone', paymentDetailsClone);

        paymentDetailsClone.find('.payment_type').val('Card').attr('data-id', newRowId);
        paymentDetailsClone.find('.payment_amount').val(remainingBalance.toFixed(2)).attr('data-id', newRowId); // Set remaining balance as payment amount
        paymentDetailsClone.find('.hdn_tracking_number').val('').attr('data-id', newRowId);
        paymentDetailsClone.find('.payment_id').val('0');

        $('.payment_details:last').after(paymentDetailsClone); // Append the cloned div after the last .payment_details div

        updateRemoveIconVisibility(); // Update remove icon visibility
        updateRemainingBalance(); // Update remaining balance
    });

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

        var hdn_tracking_number = [];
        $('.hdn_tracking_number').each(function() {
            hdn_tracking_number.push($(this).val()); // Push each payment amount into the array
        });
        
        var paymentIds = []; // Array to store selected payment types
        $('.payment_id').each(function() {
            paymentIds.push($(this).val()); // Push each payment amount into the array
        });

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

        // var formData = new FormData($('#create_walkin_casual')[0]);
        var activeTabId = $('.tab-pane.show.active').attr('id');
        var formIsValid = false;
        var formElement;

        if (activeTabId === 'casual_customer') {
            var formData = new FormData($('#create_walkin_casual')[0]);
            formData.append('hdn_customer_type', 'casual');

        } else if (activeTabId === 'new_customer') {
            var formData = new FormData($('#create_walkin_new')[0]);
            formData.append('hdn_customer_type', 'new');
        } else if (activeTabId === 'exist_customer') {
            var formData = new FormData($('#create_walkin_existing')[0]);
            formData.append('hdn_customer_type', 'existing');
        }

        // Append each payment type separately to FormData
        paymentIds.forEach(function(paymentIds) {
            formData.append('payment_ids[]', paymentIds);
        });
        
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

        hdn_tracking_number.forEach(function(hdn_tracking_number) {
            formData.append('hdn_tracking_number[]', hdn_tracking_number);
        });
        
        SubmitWalkIn(formData);
    });
    $(document).on('click', '.existing_client_change', function() {
        $('.client_search_bar').show();
        $('#existingclientmodal').hide();
    })
    
    var voucherModalOpened = false;
    $(document).on('click', '.payment_type', function() {
        var rowId = $(this).parent().parent().parent().find('.payment_amount').attr('data-id');

        if ($(this).val() === 'Gift Card' && !voucherModalOpened) {
            //clear content
            $('.search_gift_card').val('');
            $('#gift-card-results').empty();
            $('#voucher-alert').attr('style','display:none !important');
            $('#redemption-amount-section').hide();
            $('.simple-link').hide();
            $('#voucher-history').hide();
            $('.voucher-history').hide();
            $('.voucher_cancelled').attr('style','display:none !important');
            $('.voucher_already_added').attr('style','display:none !important');
            $('.voucher_no_remaining').attr('style','display:none !important');
            
            $('#take_payment').modal('hide'); // Hide the Take Payment modal
            // $('#Redeem_voucher').modal('show'); // Show the Redeem Voucher modal
            $('#Redeem_voucher').attr('row-id', rowId).modal('show');
            voucherModalOpened = true;
        }else if($(this).val() != 'Gift Card')
        {
            voucherModalOpened = false;
        }
    });

    // Optionally, you can add a handler to go back to payment modal from redeem voucher modal
    $(document).on('click', '.back_to_payment', function() {
        var rowId = $('#Redeem_voucher').attr('row-id');
        $('#Redeem_voucher').modal('hide');
        $('#take_payment').modal('show');
        // $('#payment_type').val('Card');
        // Set data-id attribute of payment_amount[] inputs to 'Card'
        // $('.payment_type').attr('data-id', 'Card');
        if($('#is_edit').val() == 'yes')
        {
            $('.payment_type[data-id="' + rowId + '"]').val('Gift Card');
        }else{
            $('.payment_type[data-id="' + rowId + '"]').val('Card');
        }
        
    });
    $(document).on('keypress', '.search_gift_card', function(event) {
        var query = $(this).val();
        if (query) {  // Start searching after 3 characters
            $.ajax({
                url: '{{ route('search-gift-card') }}',
                type: 'GET',
                data: { query: query },
                success: function(data) {
                    $('.collapse').removeClass('show');
                    $('.redeem_gift_card').show();
                    updateVoucherList(data);
                },
                error: function() {
                    console.log('Error in AJAX request');
                }
            });
        } else {
            clearVoucherList();
        }
    });
    $(document).on('click','.redeem_gift_card',function(e){
        $('.error').remove();
        console.log("Redeem gift card clicked"); // Check if this log appears in the console
        var tracking_number = $('.search_gift_card').val();
        var rowId = $('#Redeem_voucher').attr('row-id');
        var redemptionAmount = $('#redemption-amount').val();
        
        // Set the tracking number value to the hidden field
        $('.hdn_tracking_number[data-id="' + rowId + '"]').val(tracking_number);


        if(parseInt($('.remain_values').attr('remain_val')) >= parseInt($('#redemption-amount').val()))
        {
            $('#Redeem_voucher').modal('hide');
            $('#take_payment').modal('show');
            $('.payment_amount[data-id="' + rowId + '"]').val(redemptionAmount);
            updateRemainingBalance(); // Update remaining balance
        }else{
            $('#collapseExample').after('<p class="error" style="color:red;">Redemption amount is greater than remaining value of gift card</p>');
        }
    })
    $(document).on('click','.payment_amount',function(e){
        var paymentTypeSelect = $(this).closest('.payment_details').find('#payment_type');
        if (paymentTypeSelect.val() === 'Gift Card') {
                    // Inject CSS to hide the arrows in the number input
                    // $('<style>')
                    //     .prop('type', 'text/css')
                    //     .html('\n\
                    //         input::-webkit-outer-spin-button, input::-webkit-inner-spin-button {\n\
                    //             -webkit-appearance: none;\n\
                    //             margin: 0;\n\
                    //         }\n\
                    //         input[type=number] {\n\
                    //             -moz-appearance: textfield;\n\
                    //         }\n\
                    //     ')
                    //     .appendTo('head');

                    $('#take_payment').modal('hide');
                    $('#Redeem_voucher').modal('show');
                    $('#is_edit').val('yes');
                }
    });
    $(document).on('click', '#locations', function() {
        $('.client_search_bar').show();
        $('#existingclientmodal').hide();
    })
    $(document).on('click', '.print_quote', function() {
        // Create a hidden container element
        var dateValue = $('#datePicker1').val();
        var dateParts = dateValue.split('-'); // Assuming the date is in the format yyyy-mm-dd
        var formattedDates = dateParts[2] + '-' + dateParts[1] + '-' + dateParts[0]; // Rearranging the parts to dd-mm-yyyy format
        // Define an array to store product details
        var products = [];
        var activeTab = $('.tab-pane.active').find('.productDetails');
        // Iterate over each .productDetails element
        activeTab.find('.product-info1').each(function() {
            // Extract product information from the current .productDetails element
            var productName = $(this).find('[name="casual_product_name[]"]').val();
            var productQuanitity = $(this).find('[name="casual_product_quanitity[]"]').val();
            var productPrice = $(this).find('.m_p').text();

            // Create an object for the current product and push it to the products array
            var product = {
                name: productName,
                quantity: productQuanitity,
                price: productPrice
            };
            products.push(product);
        });
        console.log('products',products);
        var printContainer = document.createElement('div');
        printContainer.setAttribute('id', 'print-container');

        // Create printable content
        var printableContent = `
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
                <style>
                    @media print {
                        body * {
                            visibility: hidden;
                        }
                        #printable-content, #printable-content * {
                            visibility: visible;
                        }
                        #printable-content {
                            position: absolute;
                            left: 0;
                            right:0;
                            top: 0;
                            bottom:0;
                        }
                    }
                </style>
            </head>
            <body>
                <div id="printable-content">
                    <table style="width: 100%; font-family: Verdana, Geneva, Tahoma, sans-serif; font-weight: 400; vertical-align: middle; line-height: 1.5em;">
                        <tr>
                            <td style="text-align: right;">
                                <b>Dr Umed Cosmetics</b><br>
                                0407194519<br>
                                <a href="mailto:info@drumedcosmetics.com.au">info@drumedcosmetics.com.au</a><br>
                                ABN # xx-xxx-xxx
                            </td>
                        </tr>
                    </table>
                    <h3 style="font-family: Verdana, Geneva, Tahoma, sans-serif; line-height: 1.5em;">QUOTE</h3>
                    <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; line-height: 1.5em;">CUSTOMER</p>
                    <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; line-height: 1.5em;">DATE OF ISSUE<br> <b>${formattedDates}</b></p>
                    <br>
                    <table style="width: 100%; font-family: Verdana, Geneva, Tahoma, sans-serif; font-weight: 400; vertical-align: middle; line-height: 1.5em;">
                        <tr>
                            <th style="background-color: #F6F8FA; padding: 0.9rem; border-bottom: 1px solid #EBF5FF; text-align: left;" >Quantity</th>
                            <th style="background-color: #F6F8FA; padding: 0.9rem; border-bottom: 1px solid #EBF5FF; text-align: left;">Service</th>
                            <th style="background-color: #F6F8FA; padding: 0.9rem; border-bottom: 1px solid #EBF5FF; text-align: right;" >Price</th>
                        </tr>
                        ${products.map(product => `
                        <tr>
                            <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;">${product.quantity}</td>
                            <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;">${product.name}</td>
                            <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: right;">${product.price}</td>
                        </tr>
                        `).join('')}
                        <tr>
                            <td colspan="3" style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: right;">
                                Subtotal ${$('.tab-pane.active').find('.subtotal').text()}<br>
                                Total: <strong style="font-size: 20px;">${$('.tab-pane.active').find('.total').text()}</strong><br>
                                ${$('.tab-pane.active').find('.gst_total').text()}
                            </td>
                        </tr>
                    </table>
                </div>
            </body>
        </html>
        `;

        // Set printable content to the container
        printContainer.innerHTML = printableContent;

        // Append container to document body
        document.body.appendChild(printContainer);

        // Print the page
        window.print();

        // Remove the container from the document body
        document.body.removeChild(printContainer);
    });


    $(document).on('click', '.print_completed_invoice', function() {
        // Create a hidden container element
        var dateValue = $('#datePicker1').val();
        var dateParts = dateValue.split('-'); // Assuming the date is in the format yyyy-mm-dd
        var formattedDates = dateParts[2] + '-' + dateParts[1] + '-' + dateParts[0]; // Rearranging the parts to dd-mm-yyyy format

        // Define an array to store product details
        var products = [];
        var activeTab = $('.tab-pane.active').find('.productDetails');
        // Iterate over each .productDetails element
        activeTab.find('.product-info1').each(function() {
            // Extract product information from the current .productDetails element
            var productName = $(this).find('[name="casual_product_name[]"]').val();
            var productQuanitity = $(this).find('[name="casual_product_quanitity[]"]').val();
            var productPrice = $(this).find('.m_p').text();

            // Create an object for the current product and push it to the products array
            var product = {
                name: productName,
                quantity: productQuanitity,
                price: productPrice
            };
            products.push(product);
        });
        console.log('products',products);
        var cardDetails = [];
        var totalCardPayments = 0; // Initialize total card payments

        $('.main_payment_details').find('.payment_details').each(function(){
            var cardType = $(this).find('.payment_type').val();
            var cardAmount = $(this).find('.payment_amount').val();
            var cardDate = $(this).find('.payment_date').val();

            // Split the date string assuming the format is yyyy-mm-dd
            var dateParts = cardDate.split('-');

            // Reconstruct the date string in the format dd-mm-yyyy
            var formattedDate = dateParts[2] + '-' + dateParts[1] + '-' + dateParts[0];

            // Create an object for the current product and push it to the cardDetails array
            var c_details = {
                card: cardType,
                amount: cardAmount,
                date: formattedDate
            };
            cardDetails.push(c_details);
            totalCardPayments += parseFloat(cardAmount);
        })
        var totalPaid = parseFloat($('.main_payment_details').find('.payment_total').text());
        var printContainer = document.createElement('div');
        printContainer.setAttribute('id', 'print-container');

        // Create printable content
        var printableContent = `
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
                <style>
                    @media print {
                        body * {
                            visibility: hidden;
                        }
                        #printable-content, #printable-content * {
                            visibility: visible;
                        }
                        #printable-content {
                            position: absolute;
                            left: 0;
                            right:0;
                            top: 0;
                            bottom:0;
                        }
                    }
                </style>
            </head>
            <body>
                <div id="printable-content">
                    <table style="width: 100%; font-family: Verdana, Geneva, Tahoma, sans-serif; font-weight: 400; vertical-align: middle; line-height: 1.5em;">
                        <tr>
                            <td style="text-align: right;">
                                <b>Dr Umed Cosmetics</b><br>
                                0407194519<br>
                                <a href="mailto:info@drumedcosmetics.com.au">info@drumedcosmetics.com.au</a><br>
                                ABN # xx-xxx-xxx
                            </td>
                        </tr>
                    </table>
                    <h3 style="font-family: Verdana, Geneva, Tahoma, sans-serif; line-height: 1.5em;">TAX INVOICE / RECEIPT</h3>
                    <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; line-height: 1.5em;">CUSTOMER</p>
                    <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; line-height: 1.5em;">DATE OF ISSUE<br> <b>${formattedDates}</b></p>
                    <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; line-height: 1.5em; text-align: right;">INVOICE NUMBER: <b>#INV${$('.view_invoice').attr('walk_in_ids')}</b></p>
                    <br>
                    <table style="width: 100%; font-family: Verdana, Geneva, Tahoma, sans-serif; font-weight: 400; vertical-align: middle; line-height: 1.5em;">
                        <tr>
                            <th style="background-color: #F6F8FA; padding: 0.9rem; border-bottom: 1px solid #EBF5FF; text-align: left;" >Quantity</th>
                            <th style="background-color: #F6F8FA; padding: 0.9rem; border-bottom: 1px solid #EBF5FF; text-align: left;">Service</th>
                            <th style="background-color: #F6F8FA; padding: 0.9rem; border-bottom: 1px solid #EBF5FF; text-align: right;" >Price</th>
                        </tr>
                        ${products.map(product => `
                        <tr>
                            <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;">${product.quantity}</td>
                            <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;">${product.name}</td>
                            <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: right;">${product.price}</td>
                        </tr>
                        `).join('')}
                        <tr>
                            <td colspan="3" style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: right;">
                                Subtotal ${$('.tab-pane.active').find('.subtotal').text()}<br>
                                Total: <strong style="font-size: 20px;">${$('.tab-pane.active').find('.total').text()}</strong><br>
                                ${$('.tab-pane.active').find('.gst_total').text()}
                            </td>
                        </tr>
                        ${cardDetails.length > 0 ? `
                        <tr>
                            <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;" colspan="2">PAYMENTS</td>
                            <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: right;"></td>
                        </tr>
                        ${cardDetails.map(cards => `
                        <tr>
                            <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;"><b>${cards.date} ${cards.card}</b></td>
                            <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;"></td>
                            <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: right;">$${cards.amount}</td>
                        </tr>
                        `).join('')}
                        ` : ''}
                        <tr>
                            <td colspan="3" style="padding: 0.9rem; text-align: right;">
                                Total Paid: <strong style="font-size: 20px;">$${totalCardPayments}</strong><br>
                            </td>
                        </tr>
                    </table>
                </div>
            </body>
        </html>
        `;

        // Set printable content to the container
        printContainer.innerHTML = printableContent;

        // Append container to document body
        document.body.appendChild(printContainer);

        // Print the page
        window.print();

        // Remove the container from the document body
        document.body.removeChild(printContainer);
    });

    $(document).on('click', '.print_completed_invoice_single', function() {
        // var walk_ids = $('.delete_invoice').attr('delete_id');
        var walk_ids = $('.view_invoice').attr('walk_in_ids');
        // var formattedDates = $('#datePicker1').val().split('-').reverse().join('-'); // Reformatting the date

        $.ajax({
            headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: "{{ route('calendar.paid-invoice') }}",
            type: "POST",
            data: {'walk_ids': walk_ids},
            success: function (response) {
                if (response.success) {
                    // Call a function to handle printing
                    printInvoice(response.invoice);
                }
            }
        });
    });
    
    $(document).on('click', '.view_invoice', function() {
        $('.error').remove();
        $('#payment_completed').modal('hide');
        $('#paid_Invoice').modal('show');
        var walk_ids = $(this).attr('walk_in_ids');
        $('.delete_invoice').attr('delete_id',walk_ids);
        $('.edit_invoice').attr('edit_id',walk_ids);
        //ajax for invoice data
        $.ajax({
            headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: "{{ route('calendar.paid-invoice') }}",
            type: "POST",
            data: {'walk_ids': walk_ids},
            success: function (response) {
                if (response.success) {
                    console.log('data',response.invoice)
                    // response.invoice.invoice_date;
                    // populateInvoiceModal(response.invoice);
                    populateInvoiceModal(response.invoice, response.invoice.subtotal, response.invoice.discount, response.invoice.total);
                    //change owing code
                    if(parseFloat($('#totalPaid').text().replace('$', '')) > response.invoice.total)
                    {
                        $('.change').show();
                        var totalPaid = parseFloat($('#totalPaid').text().replace('$', ''));

                        // Calculate the change amount
                        var changeAmount = totalPaid - response.invoice.total;

                        // Update the .change_amount element with the change amount, formatted with a dollar sign
                        $('.change_amount').text('$' + changeAmount.toFixed(2));
                    }else{
                        $('.change').hide();
                    }
                    // Check if payment type is 'Gift Card' and hide buttons accordingly
                    // Check if any payment type is 'Gift Card'
                    let hasGiftCard = false;
                    $.each(response.invoice.payments, function(index, payment) {
                        if (payment.payment_type === 'Gift Card') {
                            hasGiftCard = true;
                            return false; // break out of the loop
                        }
                    });

                    $('.voucher_not_edit').remove();
                    if (hasGiftCard) {
                        $('.delete_invoice').hide();
                        $('.edit_invoice').hide();
                        $('.receipt_form').after('<div id="voucher-alert" class="alert alert-danger d-flex align-items-center mb-4 voucher_not_edit" role="alert" style="display: none;">This invoice cannot be edited or deleted as it includes Gift card payment types.</div>');
                    } else {
                        $('.delete_invoice').show();
                        $('.edit_invoice').show();
                    }
                }
            }
        });
    });
    $(document).on('click','.send_payment_mail',function() {
        var email = $('.send_email').val();
        var walk_in_id = $('.view_invoice').attr('walk_in_ids');

        // Regular expression for email validation
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        $('.error').remove();
        // Check if email is blank or doesn't match the email format
        if (!email) {
            // Show validation message for required field
            $('.send_email').after('<label for="email" class="error">Email is required.</label>');
            return; // Exit function
        } else if (!emailRegex.test(email)) {
            // Show validation message for invalid email format
            $('.send_email').after('<label for="email" class="error">Please enter a valid email.</label>');
            return; // Exit function
        }

        
        $.ajax({
            headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: "{{ route('calendar.send-payment-mail') }}",
            type: "POST",
            data: {'email': email,'walk_in_id':walk_in_id},
            success: function (response) {
                if (response.success) {
					Swal.fire({
						title: "Payment!",
						text: "Payment Mail send successfully.",
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
            }
        });
    })
    $(document).on('click','.send_receipt_payment_mail',function() {
        var email = $('.send_email_receipt').val();
        var walk_in_id = $('.view_invoice').attr('walk_in_ids');

        // Regular expression for email validation
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        $('.error').remove();
        // Check if email is blank or doesn't match the email format
        if (!email) {
            // Show validation message for required field
            $('.send_email_receipt').after('<label for="email" class="error">Email is required.</label>');
            return; // Exit function
        } else if (!emailRegex.test(email)) {
            // Show validation message for invalid email format
            $('.send_email_receipt').after('<label for="email" class="error">Please enter a valid email.</label>');
            return; // Exit function
        }

        
        $.ajax({
            headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: "{{ route('calendar.send-payment-mail') }}",
            type: "POST",
            data: {'email': email,'walk_in_id':walk_in_id},
            success: function (response) {
                if (response.success) {
					Swal.fire({
						title: "Payment!",
						text: "Payment Mail send successfully.",
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
            }
        });
    })
    $(document).on('click','#new_walk_in_sale',function(){
        $('#Walkin_Retail').modal('show');
        $('.main_walkin').show();
        $('.inv_type').val('walk-in');
        $('.walkin_loc_name').text($('#locations option:selected').text());
        $('.walk_in_location_id').val($('#locations').val());
        // Reset the modal content to its initial state
        // $('#Walkin_Retail .modal-content').html(initialModalContent);
        //clear all data
        $('.productDetails').empty();
        $('.NewproductDetails').empty();
        $('.ExistingproductDetails').empty();
        $('#existingclientmodal').hide();
        $('.subtotal').text('$0.00');
        $('.discount').text('$0.00');
        $('.total').text('$0.00');
        $('.gst_total').text('(Includes GST of $0.00)');
        $('#create_walkin_casual')[0].reset();
        $('#create_walkin_new')[0].reset();
        $('#create_walkin_existing')[0].reset();
        $('.main_walk_in').find('.add_discount').each(function() {
            // Update the HTML content of the element
            $(this).html('<i class="ico-percentage me-2 fs-5"></i>Add discount / surcharge');

            // Your additional code logic here for each element with the class 'add_discount'
        });
        $('input[name="discount_type"]').prop('disabled', false);
        $('#amount').prop('disabled', false);
        $('#amount').val(0);
        $('#reason').prop('disabled',false);
        $('#reason').val('');
        $('.discount').each(function() {
            var parentTd = $(this).parent().find('td');
            parentTd.text('Discount');

            var parentTds = $(this).parent().find('.discount');
            parentTds.text('$0.00');
        });
        $('#notes').text('');
        //payment
        $('#payment_type option:first').prop('selected',true);
        // $('.edit_invoice_date').remove();
        // $('.edit_invoice_number').remove();
        if($('.total_selected_product').val() == 0)
        {
            $('.take_payment').prop('disabled', true);
        }
        $('.remaining_balance').val(0);
        $('.take_payment').attr('main_total','');
        $('.take_payment').attr('main_remain',0);
        $('.edited_total').val(0);
        $('.invoice_id').val('');
    })
    $(document).on('click','.make_sale',function(){
        $('#Walkin_Retail').modal('show');
        $('.main_walkin').show();
        $('.appt_id').val($('#make_sale').attr('appt_id'));
        $('.inv_type').val('appt');
        $('.walkin_loc_name').text($('#locations option:selected').text());
        $('.walk_in_location_id').val($('#locations').val());
        // Reset the modal content to its initial state
        // $('#Walkin_Retail .modal-content').html(initialModalContent);
        //clear all data
        $('.productDetails').empty();
        $('.NewproductDetails').empty();
        $('.ExistingproductDetails').empty();
        $('#existingclientmodal').hide();
        $('.subtotal').text('$0.00');
        $('.discount').text('$0.00');
        $('.total').text('$0.00');
        $('.gst_total').text('(Includes GST of $0.00)');
        $('#create_walkin_casual')[0].reset();
        $('#create_walkin_new')[0].reset();
        $('#create_walkin_existing')[0].reset();
        $('.main_walk_in').find('.add_discount').each(function() {
            // Update the HTML content of the element
            $(this).html('<i class="ico-percentage me-2 fs-5"></i>Add discount / surcharge');

            // Your additional code logic here for each element with the class 'add_discount'
        });
        $('input[name="discount_type"]').prop('disabled', false);
        $('#amount').prop('disabled', false);
        $('#amount').val(0);
        $('#reason').prop('disabled',false);
        $('#reason').val('');
        $('.discount').each(function() {
            var parentTd = $(this).parent().find('td');
            parentTd.text('Discount');

            var parentTds = $(this).parent().find('.discount');
            parentTds.text('$0.00');
        });
        $('#notes').text('');
        //payment
        $('#payment_type option:first').prop('selected',true);
        // $('.edit_invoice_date').remove();
        // $('.edit_invoice_number').remove();
        if($('.total_selected_product').val() == 0)
        {
            $('.take_payment').prop('disabled', true);
        }
        $('.remaining_balance').val(0);
        $('.take_payment').attr('main_total','');
        $('.take_payment').attr('main_remain',0);
        $('.edited_total').val(0);
        $('.invoice_id').val('');
        //append product details
        $('.productDetails').append(
            `<div class="invo-notice mb-4 closed product-info1" prod_id='${$(this).attr('product_id')}'>
                <a href="#" class="btn cross remove_product"><i class="ico-close"></i></a>
                <input type='hidden' name='casual_product_name[]' value='${$(this).attr('product_name')}'>
                <input type='hidden' id="product_id" name='casual_product_id[]' value='${$(this).attr('product_id')}'>
                <input type='hidden' id="product_price" name='casual_product_price[]' value='${$(this).attr('product_price')}'>
                <input type='hidden' id="product_gst" name='product_gst' value='yes'>
                <input type='hidden' id="discount_types" name='casual_discount_types[]' value='amount'>
                <input type='hidden' id="hdn_discount_surcharge" name='casual_discount_surcharge[]' value='No Discount'>
                <input type='hidden' id="hdn_discount_surcharge_type" name='hdn_discount_surcharge_type[]' value=''>
                <input type='hidden' id="hdn_discount_amount" name='casual_discount_amount[]' value='0'>
                <input type='hidden' id="hdn_discount_text" name='casual_discount_text[]' value='0'>
                <input type='hidden' id="hdn_reason" name='casual_reason[]' value=''>
                <input type='hidden' id="hdn_who_did_work" name='casual_who_did_work[]' value='no one'>
                <input type='hidden' id="hdn_edit_amount" name='casual_edit_amount[]' value='0'>
                <input type='hidden' id="product_type" name='product_type[]' value='service'>
                <div class="inv-left"><div><b>${$(this).attr('product_name')}</b><div class="who_did_work"></div><span class="dis"></div></span></div>
                <div class="inv-center">
                    <div class="number-input walk_number_input safari_only form-group mb-0 number">
                        <button class="c_minus minus"></button>
                        <input type="number" class="casual_quantity quantity form-control" min="0" name="casual_product_quanitity[]" value="1">
                        <button class="c_plus plus"></button>
                    </div>
                </div>
                <div class="inv-number go price">
                    <div>
                        <div class="m_p">$${$(this).attr('product_price')}</div>
                        <div class="main_p_price" style="display:none;">($${$(this).attr('product_price')} ea)</div>
                    </div>
                    <a href="#" class="btn btn-sm px-0 product-name clickable" product_id="${$(this).attr('product_id')}" product_name="${$(this).attr('product_name')}" product_price="${$(this).attr('product_price')}"><i class="ico-right-arrow fs-2 ms-3"></i></a>
                </div>
            </div>`
        );
        var type='casual';
        $('.total_selected_product').val(parseFloat($('.total_selected_product').val()) + 1);
        if($('.total_selected_product').val() > 0)
        {
            $('.take_payment').prop('disabled', false);
        }
        updateSubtotalAndTotal(type); // Update Subtotal and Total

        // document.getElementsByClassName('search_products').value = '';
        $('.search_products').val('');
        $('#sale_staff_id').val($(this).attr('staff_id'));
    })
    function updateVoucherList(vouchers) {
        var container = $('#gift-card-results');
        container.empty();  // Clear previous results

        // Check if vouchers array is empty
        if (vouchers.length === 0) {
            container.append('<div class="alert alert-danger">No gift card found.</div>');
            
            // Hide additional content when no voucher is found
            $('#voucher-alert').attr('style', 'display:none !important');
            $('#redemption-amount-section').hide();
            $('.voucher-history').hide();
            $('#voucher-history').hide();
            $('.simple-link').hide();
            $('.redeem_gift_card').hide();
            $('.voucher_no_remaining').attr('style','display:none !important');
            return;
        }

        var paymentTotal = parseFloat($('.payment_total').text().replace('$', ''));

        vouchers.forEach(function(voucher) {
            var expiryDate = voucher.expiry_date ? new Date(voucher.expiry_date) : null;
            var formattedExpiryDate = expiryDate ? expiryDate.toLocaleDateString('en-GB', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            }) : 'Never expires';

            var createdDate = new Date(voucher.created_at);
            var formattedCreatedDate = createdDate.toLocaleDateString('en-GB', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });

            var voucherHTML = `<div class="invo-notice mb-3">
                <div class="inv-left"><b>Gift Card #${voucher.tracking_number}</b><br>
                    <span class="font-13">
                        <b>Expires:</b> ${formattedExpiryDate}<br>
                        <b>Created:</b> ${formattedCreatedDate}
                    </span>
                </div>
                <div class="inv-number remain_values" remain_val="${voucher.remaining_value}"><b>$${voucher.remaining_value}</b><br>
                    <small class="font-13">remaining</small>
                </div>
            </div>`;

            if (voucher.notes) {
                var notesHTML = `<div class="yellow-note-box p-2">
                    <strong>Notes:</strong> ${voucher.notes}
                </div>`;
                voucherHTML += notesHTML;
            }
            container.append(voucherHTML);
            

            if (voucher.cancelled_at != null) {
                $('.yellow-note-box').hide();
                $('#redemption-amount-section').hide();
                $('.voucher_cancelled').show();
                $('#voucher-alert').attr('style', 'display:none !important');
                $('.redeem_gift_card').hide();
                $('#voucher-history').show();
                $('.redeem_gift_card').hide();
                $('.voucher_already_added').attr('style', 'display:none !important');
                $('.voucher_no_remaining').attr('style','display:none !important');
                // Fetch and display voucher history
                fetchVoucherHistory(voucher.id);
            }else if (voucher.remaining_value =='0.00'){
                $('.voucher_no_remaining').show();
                $('.voucher_already_added').hide();
                $('#redemption-amount-section').hide();
                $('.redeem_gift_card').hide();
                $('#voucher-alert').attr('style', 'display:none !important');
                return;
            } else {
                // Check if the voucher is expired
                if (expiryDate && expiryDate < new Date()) {
                    $('#voucher-alert').show();
                    $('.voucher_cancelled').attr('style', 'display:none !important');
                    $('.redeem_gift_card').show();
                    $('.voucher_already_added').attr('style', 'display:none !important');
                    $('.voucher_no_remaining').attr('style','display:none !important');
                } else {
                    $('#voucher-alert').attr('style', 'display:none !important');
                    $('.voucher_cancelled').attr('style', 'display:none !important');
                    $('.redeem_gift_card').show();
                    $('.voucher_already_added').attr('style', 'display:none !important');
                    $('.voucher_no_remaining').attr('style','display:none !important');
                }
                
                $('#redemption-amount-section').show();
                // Show the redemption amount section
                var remainingAmount = parseFloat(voucher.remaining_value);

                // Set the redemption amount as the minimum of remaining amount and payment total
                var redemptionAmount = Math.min(remainingAmount, paymentTotal);

                $('#redemption-amount').val(parseFloat(redemptionAmount).toFixed(2));

                $('#voucher-history').show();
                $('.voucher_already_added').attr('style', 'display:none !important');
                // Fetch and display voucher history
                fetchVoucherHistory(voucher.id);
            }

            $('.hdn_tracking_number').each(function() {
                var val = $(this).val();
                var searchValue = $('.search_gift_card').val();
                if (val === searchValue) {
                    $('.voucher_already_added').show();
                    $('#redemption-amount-section').hide();
                    $('.redeem_gift_card').hide();
                    $('#voucher-alert').attr('style', 'display:none !important');
                    $('.voucher_no_remaining').attr('style','display:none !important');
                    return;
                }
            });
        });
    }
    function fetchVoucherHistory(id) {
        $.ajax({
            url: '{{ route('get-gift-card-history') }}',
            type: 'GET',
            data: { id: id },
            success: function(data) {
                showVoucherHistory(data);
            },
            error: function() {
                console.log('Error fetching voucher history');
            }
        });
    }
    function showVoucherHistory(history) {
        var table = $('.voucher-history');
        table.empty(); // Clear previous data

        // Loop through history and populate table rows
        history.forEach(function(entry) {
            var redeemedDate = new Date(entry.date_time);
            var formattedRedeemedDate = redeemedDate.toLocaleDateString('en-GB', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });

            // Determine the text and color based on redeemed_value_type
            var typeText = "";
            var typeColor = "";
            if (entry.redeemed_value_type === "increase") {
                typeText = "Credited";
                typeColor = "green";
            } else if (entry.redeemed_value_type == "decrease" || entry.invoice_number != null) {
                typeText = "Redeemed";
                typeColor = "black";
            }else if (entry.redeemed_value_type === "Created") {
                typeText = "Created";
                typeColor = "black";
            }else if (entry.redeemed_value_type === "Cancelled") {
                typeText = "Cancelled";
                typeColor = "red";
            }else if (entry.redeemed_value_type === "Expired") {
                typeText = "Expired";
                typeColor = "red";
            }
            // Construct the table row with styled text
            var redeemedValue = entry.redeemed_value ? '$' + entry.redeemed_value : '';
            var row = '<tbody><tr><td><strong><span style="color: ' + typeColor + ';">' + typeText + '</span>:</strong> ' + redeemedValue + ' on ' + formattedRedeemedDate + '</td></tr></tbody>';
            table.append(row);
        });


        // Show the voucher history section
        $('.voucher-history').show();
        $('.simple-link').show();
    }
    function clearVoucherList() {
        $('#gift-card-results').empty();
        $('.search_gift_card').val('');
        $('#gift-card-results').empty();
        $('#voucher-alert').attr('style','display:none !important');
        $('#redemption-amount-section').hide();
        $('.simple-link').hide();
        $('#voucher-history').hide();
        $('.voucher-history').hide();
        $('.voucher_cancelled').attr('style','display:none !important');
        $('.redeem_gift_card').hide();
        $('#gift-card-results').append('<div class="alert alert-danger">No gift card found.</div>');
    }
    updateRemoveIconVisibility();
    // updateRemainingBalance();
    function populateInvoiceModal(invoiceData, subtotal, discount, total) {
        // Update the modal content with the retrieved invoice data
        // $('#modalTitle').text('Paid invoice for ' + invoiceData.client_name);
        var invoiceDate = new Date(invoiceData.invoice_date);

        // Get day, month, and year
        var day = invoiceDate.getDate();
        var month = invoiceDate.getMonth() + 1; // Month is zero-based, so add 1
        var year = invoiceDate.getFullYear();

        // Ensure day and month are displayed with leading zeros if needed
        var formattedInvoiceDate = `${day < 10 ? '0' + day : day}-${month < 10 ? '0' + month : month}-${year}`;

        $('#invoiceDate').text(formattedInvoiceDate);
        $('#invoiceNumber').text('INV' + invoiceData.id);

        // Populate product table
        var productTableBody = $('#productTableBody');
        productTableBody.empty();
        invoiceData.products.forEach(function (product) {
            if(product.type == 'Surcharge')
            {
                var p_price = (parseFloat(product.product_price) + parseFloat(product.discount_value)).toFixed(2)
            }else if(product.type == 'Discount')
            {
                var p_price = (parseFloat(product.product_price) - parseFloat(product.discount_value)).toFixed(2)
            }else
            {
                var p_price = (parseFloat(product.product_price)).toFixed(2)
            }
            productTableBody.append('<tr><td><b>' + product.product_name + '</b><br><span class="d-grey">' + product.user_full_name + '</span></td><td><b>' + product.product_quantity + '</b></td><td><b>$' + p_price + '</b></td></tr>');
        });

        // Calculate GST
        var gst = invoiceData.gst;

        // Populate payment table
        var paymentTableBody = $('#paymentTable tbody');
        paymentTableBody.empty();
        invoiceData.payments.forEach(function (payment) {
            var paymentDate = new Date(payment.date);

            // Get day, month, and year
            var day = paymentDate.getDate();
            var month = paymentDate.getMonth() + 1; // Month is zero-based, so add 1
            var year = paymentDate.getFullYear();

            // Ensure day and month are displayed with leading zeros if needed
            var formattedPaymentDate = `${day < 10 ? '0' + day : day}-${month < 10 ? '0' + month : month}-${year}`;

            paymentTableBody.append('<tr><td><b>' + payment.payment_type + '</b></td><td class="d-grey">' + formattedPaymentDate + '</td><td><b>$' + payment.amount + '</b></td></tr>');
        });


        // Populate subtotal, discount, total, and total paid
        $('#subtotalProductPrice').html('<span class="blue-bold">$' + subtotal + '</span>');
        $('#discountProductPrice').html('<span class="blue-bold">$' + discount + '</span>');
        $('#totalProductPrice').html('<span class="blue-bold">$' + total + '</span><br><span class="d-grey font-13" id="totalProductPriceGST">Includes GST of $' + gst + '</span>');

        // Calculate total paid amount including payments
        var totalPaid = 0;
        invoiceData.payments.forEach(function (payment) {
            totalPaid += parseFloat(payment.amount);
        });

        // Populate total paid amount
        $('#totalPaid').html('$' + totalPaid.toFixed(2));
    }

    // Example data
    var invoiceData = {
        customer_name: "John Doe",
        invoice_date: "2024-04-19",
        id: 123,
        gst: 20.55,
        products: [
            { product_name: "Product A", user_full_name: "User A", product_quantity: 2, product_price: 1000 },
            { product_name: "Product B", user_full_name: "User B", product_quantity: 1, product_price: 500 }
        ],
        payments: [
            { payment_type: "Cash", date: "2024-04-19", amount: 1000 },
            { payment_type: "Card", date: "2024-04-19", amount: 500 }
        ]
    };

    // Subtotal, discount, and total values from walk_in_retail_sale table
    var subtotal = 2000; // Example subtotal
    var discount = 100; // Example discount
    var total = subtotal - discount; // Example total

    // Populate the invoice modal with example data and subtotal, discount, total values
    populateInvoiceModal(invoiceData, subtotal, discount, total);


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

        var remainingBalance;

        if (totalPayments > total) {
            $('.change_owing_div').show();
            $('.remaining_balance_div').hide();
            remainingBalance = totalPayments - total; // Calculate the change owing
            $('.change_owing').text('$' + remainingBalance.toFixed(2)); // Update the change owing
            $(".complete_sale").prop('disabled', false);
            $('.remaining_balance').text('$' + 0); // Update the remaining balance
        } else {
            $('.change_owing_div').hide();
            $('.remaining_balance_div').show();
            remainingBalance = total - totalPayments; // Calculate the remaining balance
            $('.remaining_balance').text('$' + remainingBalance.toFixed(2)); // Update the remaining balance

            // Enable or disable the complete sale button
            if (remainingBalance > 0) {
                $(".complete_sale").prop('disabled', true); // Disable button if balance is positive
            } else {
                $(".complete_sale").prop('disabled', false); // Enable button if balance is zero or negative
            }
        }
    }
    
    function calculateAndUpdate() {
        var pricePerUnit = parseFloat($('.edit_price_per_unit').val()) || 0;
        var quantity = parseInt($('.edit_quantity').val()) || 0;
        var discountType = $('input[name="edit_discount_type"]:checked').val();
        var amount = parseFloat($('#edit_amount').val());
        var discountAmount = 0;
        var edit_dis_sur = $('#edit_discount_surcharge').val();
        if (discountType === "amount" && !isNaN(amount)) {
            var selectedOption = $('#edit_discount_surcharge').find('option:selected');
            var optgroupLabel = selectedOption.parent().attr('label');
            if(optgroupLabel == 'Surcharge')
            {
                discountAmount = amount * 1;//quantity;

                var productPrice = pricePerUnit * quantity;
                var newTotal = productPrice + (discountAmount * quantity);
                // Update dynamic discount display
                $('#dynamic_discount').text(' Surcharge: $' + discountAmount.toFixed(2));
            }else if(optgroupLabel == 'Discount'){
                discountAmount = amount * 1;//quantity;

                var productPrice = pricePerUnit * quantity;
                var newTotal = productPrice - (discountAmount * quantity);
                $('input[name="edit_discount_type"][value="percent"]').prop('disabled', false);
                $('#dynamic_discount').text(' Discount: $' + discountAmount.toFixed(2));
            }else{
                var productPrice = pricePerUnit * quantity;
                var newTotal = productPrice + discountAmount;
            }

        } else if (discountType === "percent" && !isNaN(amount)) {
                var selectedOption = $('#edit_discount_surcharge').find('option:selected');
                var optgroupLabel = selectedOption.parent().attr('label');
                if(optgroupLabel == 'Surcharge'){
                    var discountPercent = amount / 100;
                    discountAmount = (pricePerUnit * 1) * discountPercent;
                    // discountAmount = (pricePerUnit * quantity) * discountPercent;
                    var newPrice = (pricePerUnit * quantity) - discountAmount;
                    var productPrice = pricePerUnit * quantity;
                    var newTotal = productPrice + (discountAmount * quantity);
                    $('#dynamic_discount').text(' Surcharge: $' + discountAmount.toFixed(2));
                }
                else if(optgroupLabel == 'Discount'){
                    var discountPercent = amount / 100;
                    discountAmount = (pricePerUnit * 1) * discountPercent;
                    // discountAmount = (pricePerUnit * quantity) * discountPercent;
                    var newPrice = (pricePerUnit * quantity) - discountAmount;
                    var productPrice = pricePerUnit * quantity;
                    var newTotal = productPrice - (discountAmount * quantity);
                    $('#dynamic_discount').text(' Discount: $' + discountAmount.toFixed(2));
                }else{
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

        

        // Calculate new total after discount
        

        // Update edit_product_price
        $('.edit_product_price').find('b').text('$' + newTotal.toFixed(2));

        var text = $('#dynamic_discount').text();
        // Use a regular expression to extract the number
        var text = $('#dynamic_discount').text();
        var number = 0; // Default value is 0
        // Check if text is not null and matches the regular expression
        if (text !== null) {
            var match = text.match(/\d+\.\d+/);
            // If the match is found, parse the number
            if (match !== null) {
                number = parseFloat(match[0]);
            }
        }
        if(optgroupLabel == 'Surcharge'){
            $('.main_detail_price').text('$' + (pricePerUnit + number).toFixed(2) + 'ea');
        }else if(optgroupLabel == 'Discount'){
            $('.main_detail_price').text('$' + (pricePerUnit - number).toFixed(2) + 'ea');
        }else{
            $('.main_detail_price').text('$' + (pricePerUnit).toFixed(2) + 'ea');
        }
        // $('.main_detail_price').text('$' + (pricePerUnit - number).toFixed(2) + 'ea');
        
        // $('.main_detail_price').text('($' + pricePerUnit + ' ea)');
    }

    function calculatePrice() {
        var pricePerUnit = parseFloat($('.edit_price_per_unit').val());
        var quantity = parseInt($('.edit_quantity').val());

        // Calculate new price without discount
        var newPrice = pricePerUnit * quantity;

        // Update edit_product_price
        $('.edit_product_price').find('b').text('$' + newPrice.toFixed(2));
        $('.main_detail_price').text('($' + pricePerUnit + ' ea)');
    }

    function updateQuantity() {
        var newQuantity = parseInt($('.edit_quantity').val());
        // $('.edit_product_quantity').text(newQuantity);
    }
    function updatePrice() {
        var pricePerUnit = parseFloat($('.edit_price_per_unit').val());
        var quantity = parseInt($('.edit_quantity').val());
        var totalPrice = pricePerUnit * quantity;
        $('.edit_product_price').find('b').text('$' + totalPrice.toFixed(2));
        $('.main_detail_price').text('($' + totalPrice + ' ea)');
    }

    function checkDiscountSelection() {
        var selectedOption = $('#discount_surcharge').find('option:selected');
        var optgroupLabel = selectedOption.parent().attr('label');
        
        var selectedOption = $('#discount_surcharge');
        var $discountType = $('#discount_type');
        var $amount = $('#amount');
        var $reason = $('#reason');
        var $dynamicDiscount = $('#dynamic_discount');

        if(optgroupLabel == 'Discount')
        {
            $('input[name="discount_type"][value="percent"]').prop('checked', true);

            // Set the discount amount dynamically based on the selected dropdown value
            var discountValue = parseFloat($('#discount_surcharge').val());
            if (isNaN(discountValue)) {
                discountValue = 0;
            }
            var pricePerUnit = parseFloat($('#hdn_total').val());
            var quantity = parseInt($('.quantity').val());
            var totalAmount = pricePerUnit * quantity;
            var discountAmount = totalAmount * (discountValue / 100); // Calculate discount based on selected dropdown value

            // Update dynamic discount display
            // $dynamicDiscount.text(' Discount: $' + discountAmount.toFixed(2));

            $amount.val(discountValue).prop('disabled', true); // Set the dropdown value to the discount field
            // $reason.val('Credit Card Surcharge').prop('disabled', true);

            // Recalculate edit_product_price with the discounted amount
            var newPrice = totalAmount - discountAmount;

            // Update edit_product_price
            $('.edit_product_price').find('b').text('$' + newPrice.toFixed(2));
            $('.main_detail_price').text('($' + newPrice + ' ea)');

            // Re-enable disabled fields
            $amount.prop('disabled', false);
            $reason.prop('disabled', true);
            if($('#discount_surcharge').find('option:selected').text() == 'Manual Discount')
            {
                $('input[name="discount_type"]').prop('disabled', false);
                $reason.val('');
                $amount.prop('disabled', false);
                $reason.prop('disabled', false);
            }else{
                $discountType.prop('disabled', true);
                $reason.val($('#discount_surcharge').find('option:selected').text());
                $('input[name="discount_type"][value="percent"]').prop('checked', true).prop('disabled', true);
                $amount.prop('disabled', true);
            }
        }else if(optgroupLabel == 'Surcharge'){
            // Set the discount amount dynamically based on the selected dropdown value
            var discountValue = parseFloat($('#discount_surcharge').val());
            if (isNaN(discountValue)) {
                discountValue = 0;
            }
            var pricePerUnit = parseFloat($('#hdn_total').val());
            var quantity = parseInt($('.quantity').val());
            var totalAmount = pricePerUnit * quantity;
            var discountAmount = totalAmount * (discountValue / 100); // Calculate discount based on selected dropdown value

            // Update dynamic discount display
            // $dynamicDiscount.text(' Discount: $' + discountAmount.toFixed(2));

            $amount.val(discountValue).prop('disabled', true); // Set the dropdown value to the discount field
            // $reason.val('Credit Card Surcharge').prop('disabled', true);

            // Recalculate edit_product_price with the discounted amount
            var newPrice = totalAmount + discountAmount;

            // Update edit_product_price
            $('.product_price').text('$' + newPrice.toFixed(2));

            // Re-enable disabled fields
            $amount.prop('disabled', false);
            $reason.prop('disabled', true);
            if($('#discount_surcharge').find('option:selected').text() == 'Manual Surcharge')
            {
                $('input[name="discount_type"]').prop('disabled', false);
                $reason.val('');
                $amount.prop('disabled', false);
                $reason.prop('disabled', false);
            }else{
                $discountType.prop('disabled', true);
                $reason.val($('#discount_surcharge').find('option:selected').text());
                $('input[name="discount_type"][value="percent"]').prop('checked', true).prop('disabled', true);
                $amount.prop('disabled', true);
            }
        }
        else{
            $discountType.prop('disabled', true);
            $amount.prop('disabled', true);
            $reason.prop('disabled', true);
            $amount.val('');
            $reason.val('');
            
            // Remove dynamic discount
            $dynamicDiscount.text('');
            
            // Recalculate edit_product_price
            calculatePrice();
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
                                if (existingRecordIndex !== -1 && client_details[existingRecordIndex].client_documents.some(doc => doc.doc_id === res[i].documents[j].id)) {
                                    continue;
                                }
                                // If the record doesn't exist in the array or the doc_id doesn't exist in the documents array, add it
                                if (existingRecordIndex === -1 || !client_details[existingRecordIndex].client_documents.some(doc => doc.doc_id === res[i].documents[j].id)) {
                                    client_details[existingRecordIndex !== -1 ? existingRecordIndex : i].client_documents.push({
                                        doc_id: res[i].documents[j].id,
                                        doc_name: res[i].documents[j].doc_name,
                                        created_at: res[i].documents[j].created_at
                                    });
                                }
                            }
                        }
                        if (res[i].photos && res[i].photos.length > 0) {
                            $('.photos_count').text(res[i].photos.length);

                            var photoContainer = $('.gallery.client-phbox'); // Assuming you have a container for client photos in your modal
                            photoContainer.empty(); // Clear previous photos
                            res[i].photos.forEach(function(photoUrl) {
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
                                if (existingRecordIndex !== -1 && client_details[existingRecordIndex].client_documents.some(doc => doc.doc_id === res[i].documents[j].id)) {
                                    continue;
                                }
                                // If the record doesn't exist in the array or the doc_id doesn't exist in the documents array, add it
                                if (existingRecordIndex === -1 || !client_details[existingRecordIndex].client_documents.some(doc => doc.doc_id === res[i].documents[j].id)) {
                                    client_details[existingRecordIndex !== -1 ? existingRecordIndex : i].client_documents.push({
                                        doc_id: res[i].documents[j].id,
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
                                if (existingRecordIndex !== -1 && client_details[existingRecordIndex].client_documents.some(doc => doc.doc_id === res[i].documents[j].id)) {
                                    continue;
                                }
                                // If the record doesn't exist in the array or the doc_id doesn't exist in the documents array, add it
                                if (existingRecordIndex === -1 || !client_details[existingRecordIndex].client_documents.some(doc => doc.doc_id === res[i].documents[j].id)) {
                                    client_details[existingRecordIndex !== -1 ? existingRecordIndex : i].client_documents.push({
                                        doc_id: res[i].documents[j].id,
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
                                if (existingRecordIndex !== -1 && client_details[existingRecordIndex].client_documents.some(doc => doc.doc_id === res[i].documents[j].id)) {
                                    continue;
                                }
                                // If the record doesn't exist in the array or the doc_id doesn't exist in the documents array, add it
                                if (existingRecordIndex === -1 || !client_details[existingRecordIndex].client_documents.some(doc => doc.doc_id === res[i].documents[j].id)) {
                                    client_details[existingRecordIndex !== -1 ? existingRecordIndex : i].client_documents.push({
                                        doc_id: res[i].documents[j].id,
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
                                if (existingRecordIndex !== -1 && client_details[existingRecordIndex].client_documents.some(doc => doc.doc_id === res[i].documents[j].id)) {
                                    continue;
                                }
                                // If the record doesn't exist in the array or the doc_id doesn't exist in the documents array, add it
                                if (existingRecordIndex === -1 || !client_details[existingRecordIndex].client_documents.some(doc => doc.doc_id === res[i].documents[j].id)) {
                                    client_details[existingRecordIndex !== -1 ? existingRecordIndex : i].client_documents.push({
                                        doc_id: res[i].documents[j].id,
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
            $('.resultproductmodal').empty(); // Clear search results if no data
            $('.products_box').hide(); // Hide the product search results box
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
                // Generate the client details HTML
                let clientDetailsHTML = `
                    <div class="client-name">
                        <div class="drop-cap" style="background: #D0D0D0; color:#fff;">${client.name.charAt(0).toUpperCase()}</div>
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
                    <div class="btns">`;

                // Add buttons conditionally based on the permission value
                if (localStorage.getItem('permissionValue') == '1') {
                    clientDetailsHTML += `
                        <button class="btn btn-secondary btn-sm open-client-card-btn" data-client-id="${client.id}">Client Card</button>
                        <button class="btn btn-secondary btn-sm history" data-client-id="${client.id}">History</button>
                        <button class="btn btn-secondary btn-sm upcoming" data-client-id="${client.id}">Upcoming</button>
                    `;
                }else{
                    clientDetailsHTML += `
                        <button class="btn btn-secondary btn-sm open-client-card-btn" data-client-id="${client.id}" disabled>Client Card</button>
                        <button class="btn btn-secondary btn-sm history" data-client-id="${client.id}" disabled>History</button>
                        <button class="btn btn-secondary btn-sm upcoming" data-client-id="${client.id}" disabled>Upcoming</button>
                    `;
                }

                clientDetailsHTML += `</div><hr>`;

                // Dynamically bind the HTML to clientDetails element
                $('#clientDetails').html(clientDetailsHTML);

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
                    $('.walk_in_client_id').val(client.id);
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
                    $('#clientWaitListEditModal').show();
                    $('.clientWaitListEditModal').hide();
                    $('#resulteditmodal').empty();
                    $("#clientName").val(client.name+client.lastname);
                    $("#clientEditDetailsModals").html(
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
                    // $("#clientDetailsModal").html(
                    // `<i class='ico-user2 me-2 fs-6'></i> ${client.name} ${client.lastname}`);
                    document.getElementById('searchwaitlistmodel').value='';
                    // Trigger the click event of the history button
                    // $('.history').click();
                    break; // Stop iterating once a match is found
                }
            }
        }
    }
    function setProductSearchModal(value,id,type) {
        // Retrieve the selected value from the clicked element
        $('.products_box').hide();

        var activeTabContainer = $('.productDetails');

        // Get existing product elements associated with the active tab
        var activeTabProducts = activeTabContainer.find('.product-info1');

        // Iterate over existing products to check if the selected product already exists
        var productExists = false;
        activeTabProducts.each(function() {
            var prodName = $(this).find('.inv-left b').text();
            var prodId = $(this).find('#product_id').val();
            var prodType = $(this).find('#product_type').val();
            // If the product already exists, update its quantity
            if (prodName === value && prodId === id && prodType === type) {
                var quantityInput = $(this).find('.casual_quantity');
                var quantity = parseInt(quantityInput.val()) + 1;
                quantityInput.val(quantity);

                productExists = true;
                
                //update total start
                var newPrice = $(this).find('#product_price').val() * quantity;
                // $currentDiv.find('.m_p').text('$' + newPrice);
                $(this).find('.m_p').text(parseFloat(newPrice).toFixed(2));

                // Show the main_p_price if quantity is greater than or equal to 1
                if (quantity >= 1) {
                    // $currentDiv.find('.main_p_price').show();
                    $(this).find('.main_p_price').show();
                }
                
                //update total end
                updateSubtotalAndTotal(type); // Update Subtotal and Total

                // document.getElementsByClassName('search_products').value = '';
                $('.search_products').val('');
                // return false; // Exit the loop
            }
        });

        // If the product does not exist, add a new entry
        if (!productExists) {
            for (const key in product_details) {
                console.log(product_details);
                if (product_details.hasOwnProperty(key)) {
                    const product = product_details[key];
                    // Check if value matches any field in the product object
                    if (product.name === value) {
                        console.log(product);
                        // If a match is found, dynamically bind HTML to productDetails element
                        $('.productDetails').append(
                            `<div class="invo-notice mb-4 closed product-info1" prod_id='${product.id}'>
                                <a href="#" class="btn cross remove_product"><i class="ico-close"></i></a>
                                <input type='hidden' name='casual_product_name[]' value='${product.name}'>
                                <input type='hidden' id="product_id" name='casual_product_id[]' value='${product.id}'>
                                <input type='hidden' id="product_price" name='casual_product_price[]' value='${product.price}'>
                                <input type='hidden' id="product_gst" name='product_gst' value='${product.gst}'>
                                <input type='hidden' id="discount_types" name='casual_discount_types[]' value='amount'>
                                <input type='hidden' id="hdn_discount_surcharge" name='casual_discount_surcharge[]' value='No Discount'>
                                <input type='hidden' id="hdn_discount_surcharge_type" name='hdn_discount_surcharge_type[]' value=''>
                                <input type='hidden' id="hdn_discount_amount" name='casual_discount_amount[]' value='0'>
                                <input type='hidden' id="hdn_discount_text" name='casual_discount_text[]' value='0'>
                                <input type='hidden' id="hdn_reason" name='casual_reason[]' value=''>
                                <input type='hidden' id="hdn_who_did_work" name='casual_who_did_work[]' value='no one'>
                                <input type='hidden' id="hdn_edit_amount" name='casual_edit_amount[]' value='0'>
                                <input type='hidden' id="product_type" name='product_type[]' value='${product.product_type}'>
                                <div class="inv-left"><div><b>${product.name}</b><div class="who_did_work"></div><span class="dis"></div></span></div>
                                <div class="inv-center">
                                    <div class="number-input walk_number_input safari_only form-group mb-0 number">
                                        <button class="c_minus minus"></button>
                                        <input type="number" class="casual_quantity quantity form-control" min="0" name="casual_product_quanitity[]" value="1">
                                        <button class="c_plus plus"></button>
                                    </div>
                                </div>
                                <div class="inv-number go price">
                                    <div>
                                        <div class="m_p">${'$'+product.price}</div>
                                            <div class="main_p_price" style="display:none;">(${'$'+product.price} ea)
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-sm px-0 product-name clickable" product_id="${product.id}" product_name="${product.name}" product_price="${product.price}"><i class="ico-right-arrow fs-2 ms-3"></i></a>
                                </div>
                            </div>`
                        );
                        var type='casual';
                        $('.total_selected_product').val(parseFloat($('.total_selected_product').val()) + 1);
                        if($('.total_selected_product').val() > 0)
                        {
                            $('.take_payment').prop('disabled', false);
                        }
                        updateSubtotalAndTotal(type); // Update Subtotal and Total

                        // document.getElementsByClassName('search_products').value = '';
                        $('.search_products').val('');
                        break; // Stop iterating once a match is found
                    }
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
            $('.tab-pane.active .product-info1').each(function() {
                if($(this).find('.dis').text() == '')
                {
                    var price = parseFloat($(this).find('#product_price').val()); //parseFloat($(this).find('.price').text().replace('$', ''));
                }
                else
                {
                    var chk_dis_type = $(this).find('#discount_types').val();
                    if(chk_dis_type == 'amount')
                    {
                        if($(this).find('#hdn_discount_surcharge_type').val() == 'Surcharge')
                        {
                            var price = parseFloat($(this).find('#product_price').val()) + parseFloat($(this).find('#hdn_discount_amount').val());    
                        }else{
                            var price = parseFloat($(this).find('#product_price').val()) - parseFloat($(this).find('#hdn_discount_amount').val());    
                        }
                    }
                    else
                    {
                        if($(this).find('#hdn_discount_surcharge_type').val() == 'Surcharge')
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

            var dis_sur = $('#discount_surcharge option:selected').closest('optgroup').attr('label');
            if(dis_sur == 'Surcharge')
            {
                var total = subtotal + discount; // Calculate total after discount
            }else{
                var total = subtotal - discount; // Calculate total after discount
            }
            
            
            
            var grandTotal = total + gst; // Calculate total including GST
            $('.hdn_subtotal').val(subtotal.toFixed(2));
            $('.hdn_discount').val(discount.toFixed(2));
            $('.hdn_total').val(total.toFixed(2));
            $('.hdn_gst').val(gst.toFixed(2));
            if($('.edit_invoice_number:first').text()=='')
            {
                $('.take_payment').attr('main_total',total.toFixed(2));
            }
            else
            {
                var edit_total = $('.edited_total').val();
                $('.take_payment').attr('main_total',edit_total);
                $('.remaining_balance').text('$' + (total.toFixed(2) - edit_total));
                $('.payment_total').text('$' + (total.toFixed(2)));
                if(parseFloat($('.take_payment').attr('main_remain')) == 0)
                {
                    $('.take_payment').attr('main_remain',parseFloat((total.toFixed(2) - edit_total)).toFixed(2));    
                }else{
                    $('.take_payment').attr('main_remain',parseFloat((total.toFixed(2) - parseFloat($('.take_payment').attr('main_remain')))).toFixed(2));
                }
            }

            // Update the displayed values on the page
            $('.subtotal').text('$' + subtotal.toFixed(2));

            $('.discount').each(function() {
                var parentTd = $(this).parent().find('td');
                parentTd.text($('#discount_surcharge option:selected').closest('optgroup').attr('label'));
            });


            $('.discount').text('$' + discount.toFixed(2));
            $('.total').html('<b>$' + total.toFixed(2) + '</b>');
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
            $('.tab-pane.active .product-info1').each(function() {
                if($(this).find('.dis').text() == '')
                {
                    var price = parseFloat($(this).find('#product_price').val()); //parseFloat($(this).find('.price').text().replace('$', ''));
                }
                else
                {
                    var chk_dis_type = $(this).find('#discount_types').val();
                    if(chk_dis_type == 'amount')
                    {
                        if($(this).find('#hdn_discount_surcharge_type').val() == 'Surcharge')
                        {
                            var price = parseFloat($(this).find('#product_price').val()) + parseFloat($(this).find('#hdn_discount_amount').val());    
                        }else{
                            var price = parseFloat($(this).find('#product_price').val()) - parseFloat($(this).find('#hdn_discount_amount').val());    
                        }
                    }
                    else
                    {
                        if($(this).find('#hdn_discount_surcharge_type').val() == 'Surcharge')
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

            var dis_sur = $('#discount_surcharge option:selected').closest('optgroup').attr('label');
            if(dis_sur == 'Surcharge')
            {
                var total = subtotal + discount; // Calculate total after discount
            }else{
                var total = subtotal - discount; // Calculate total after discount
            }
            // var total = subtotal - discount; // Calculate total after discount
            // var gst = total * 0.05; // Assuming GST is 5% of total
            // var grandTotal = total + gst; // Calculate total including GST

            // Update the displayed values on the page
            $('.hdn_subtotal').val(subtotal.toFixed(2));
            $('.hdn_discount').val(discount.toFixed(2));
            $('.hdn_total').val(total.toFixed(2));
            $('.hdn_gst').val(gst.toFixed(2));
            if($('.edit_invoice_number:first').text()=='')
            {
                $('.take_payment').attr('main_total',total.toFixed(2));
            }
            else
            {
                var edit_total = $('.edited_total').val();
                $('.take_payment').attr('main_total',edit_total);
                $('.remaining_balance').text('$' + (total.toFixed(2) - edit_total));
                $('.payment_total').text('$' + (total.toFixed(2)));
                if(parseFloat($('.take_payment').attr('main_remain')) == 0)
                {
                    $('.take_payment').attr('main_remain',parseFloat((total.toFixed(2) - edit_total)).toFixed(2));    
                }else{
                    $('.take_payment').attr('main_remain',parseFloat((total.toFixed(2) - parseFloat($('.take_payment').attr('main_remain')))).toFixed(2));
                }
            }

            $('.subtotal').text('$' + subtotal.toFixed(2));
            
            $('.discount').each(function() {
                var parentTd = $(this).parent().find('td');
                parentTd.text($('#discount_surcharge option:selected').closest('optgroup').attr('label'));
            });

            $('.discount').text('$' + discount.toFixed(2));
            $('.total').html('<b>$' + total.toFixed(2) + '</b>');
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
            $('.tab-pane.active .product-info1').each(function() {
                if($(this).find('.dis').text() == '')
                {
                    var price = parseFloat($(this).find('#product_price').val()); //parseFloat($(this).find('.price').text().replace('$', ''));
                }
                else
                {
                    var chk_dis_type = $(this).find('#discount_types').val();
                    if(chk_dis_type == 'amount')
                    {
                        if($(this).find('#hdn_discount_surcharge_type').val() == 'Surcharge')
                        {
                            var price = parseFloat($(this).find('#product_price').val()) + parseFloat($(this).find('#hdn_discount_amount').val());    
                        }else{
                            var price = parseFloat($(this).find('#product_price').val()) - parseFloat($(this).find('#hdn_discount_amount').val());    
                        }
                    }
                    else
                    {
                        if($(this).find('#hdn_discount_surcharge_type').val() == 'Surcharge')
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
            var dis_sur = $('#discount_surcharge option:selected').closest('optgroup').attr('label');
            if(dis_sur == 'Surcharge')
            {
                var total = subtotal + discount; // Calculate total after discount
            }else{
                var total = subtotal - discount; // Calculate total after discount
            }
            // var total = subtotal - discount; // Calculate total after discount
            // var gst = total * 0.05; // Assuming GST is 5% of total
            // var grandTotal = total + gst; // Calculate total including GST

            // Update the displayed values on the page
            $('.hdn_subtotal').val(subtotal.toFixed(2));
            $('.hdn_discount').val(discount.toFixed(2));
            $('.hdn_total').val(total.toFixed(2));
            $('.hdn_gst').val(gst.toFixed(2));
            
            if($('.edit_invoice_number:first').text()=='')
            {
                $('.take_payment').attr('main_total',total.toFixed(2));
            }
            else
            {
                var edit_total = $('.edited_total').val();
                $('.take_payment').attr('main_total',edit_total);
                $('.remaining_balance').text('$' + (total.toFixed(2) - edit_total)); 
                $('.payment_total').text('$' + (total.toFixed(2)));
                if(parseFloat($('.take_payment').attr('main_remain')) == 0)
                {
                    $('.take_payment').attr('main_remain',parseFloat((total.toFixed(2) - edit_total)).toFixed(2));    
                }else{
                    $('.take_payment').attr('main_remain',parseFloat((total.toFixed(2) - parseFloat($('.take_payment').attr('main_remain')))).toFixed(2));
                }
            }
            
            $('.subtotal').text('$' + subtotal.toFixed(2));
            
            $('.discount').each(function() {
                var parentTd = $(this).parent().find('td');
                parentTd.text($('#discount_surcharge option:selected').closest('optgroup').attr('label'));
            });

            $('.discount').text('$' + discount.toFixed(2));
            $('.total').html('<b>$' + total.toFixed(2) + '</b>');
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
                        waitlist_id: dataset.app_id,
                        service_name: dataset.service_name,
                        location_id :$('#walk_in_location_id').val(),
                        appt_type:'waitlist',
                        app_id:dataset.app_id,
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
    function updateSearchResults(results) {
        var resultList = $('.resultproductmodal');
        resultList.empty(); // Clear previous search results
        for (var i = 0; i < results.length; i++) {
            // resultList.append(`<li>${results[i].name}</li>`); // Update HTML with search results

            resultList.append(`<li class="selectedProduct" prods_id="${results[i].id}" prods_type="${results[i].product_type}" prods_name="${results[i].name}" onclick='setProductSearchModal("${results[i].name}", "${results[i].id}", "${results[i].product_type}")'>
                <aside>${results[i].name}</aside> <aside>${'$'+results[i].price}</aside>
            </li>`);

        }
        $('.products_box').show(); // Show the product search results box
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
                    console.log("res",response);
                    var amount = response.amount;
                    var walk_in_id = response.walk_in_id;
                    var username = response.username;
                    var client_email = response.client_email;
                    $('.send_email').val(client_email);
                    $('#take_payment').modal('hide');
                    $("#payment_completed").modal('show');
                    $('.view_invoice').attr('walk_in_ids',walk_in_id);
                    // Get today's date
                    var today = new Date();
                    // Define month names
                    var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                    // Format the date
                    var formattedDate = today.getDate() + ' ' + monthNames[today.getMonth()] + ' ' + today.getFullYear();

                    // var message = 'Payment of $' + amount + ' has been processed by Praharsh test on ' + formattedDate;
                    // var message = '<h4>Payment Completed</h4>Payment of $' + amount + ' has been processed by Praharsh test on ' + formattedDate;
                    // $('.payment_complete_message').text(message);

                    var message = '<h4>Payment Completed</h4>Payment of $' + amount + ' has been processed by '+ username +' on ' + formattedDate;

                    // Assuming you're using jQuery to update an element with id "paymentMessage"
                    $('#paymentMessage').html(message);
                    $('#create_walkin_new')[0].reset();
                    $('#edit_appointment').prop('disabled', true);
                    $('#make_sale').remove();//.css('display', 'none !important');
                    $('#deleteAppointment').hide();
                    $('.view_invoice').show();

                    $('.change_status').val(4);
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
    function printInvoice(invoiceData) {
        var date = invoiceData.invoice_date;
        var d = new Date(date.split("/").reverse().join("-"));
        var dd = String(d.getDate()).padStart(2, '0'); // Ensure two digits for day
        var mm = String(d.getMonth() + 1).padStart(2, '0'); // Ensure two digits for month
        var yy = d.getFullYear();
        var formattedDate = dd + "-" + mm + "-" + yy;
        console.log(formattedDate); // Output: "29-04-2024"

        var productsHTML = invoiceData.products.map(product => `
            <tr>
                <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;">${product.product_quantity}</td>
                <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;">${product.product_name}</td>
                <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: right;">$${product.product_price}</td>
            </tr>
        `).join('');

        var cardDetailsHTML = invoiceData.payments.map(cards => {
            // Convert the date string to a Date object
            var date = new Date(cards.date);

            // Get the day, month, and year
            var day = date.getDate();
            var month = date.getMonth() + 1; // Month is zero-based, so we add 1
            var year = date.getFullYear();

            // Pad single-digit day and month with leading zeros if necessary
            day = day < 10 ? '0' + day : day;
            month = month < 10 ? '0' + month : month;

            // Format the date as dd-mm-yyyy
            var formattedDate = `${day}-${month}-${year}`;

            // Construct the HTML for the table row
            return `
                <tr>
                    <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;"><b>${formattedDate} ${cards.payment_type}</b></td>
                    <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;"></td>
                    <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: right;">$${cards.amount}</td>
                </tr>
            `;
        }).join('');

        var totalPaid = calculateTotalPaid(invoiceData.payments);
        var changeAmount = parseInt(totalPaid) > invoiceData.total ? parseInt(totalPaid) - invoiceData.total : 0;
        
        var printableContent = `
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
                <style>
                    @media print {
                        body * {
                            visibility: hidden;
                        }
                        #printable-content, #printable-content * {
                            visibility: visible;
                        }
                        #printable-content {
                            position: absolute;
                            left: 0;
                            right:0;
                            top: 0;
                            bottom:0;
                        }
                    }
                </style>
            </head>
            <body>
            <div id="printable-content">
                <table style="width: 100%; font-family: Verdana, Geneva, Tahoma, sans-serif; font-weight: 400; vertical-align: middle; line-height: 1.5em;">
                    <tr>
                        <td style="text-align: right;">
                            <b>Dr Umed Cosmetics</b><br>
                            0407194519<br>
                            <a href="mailto:info@drumedcosmetics.com.au">info@drumedcosmetics.com.au</a><br>
                            ABN # xx-xxx-xxx
                        </td>
                    </tr>
                </table>
                <h3 style="font-family: Verdana, Geneva, Tahoma, sans-serif; line-height: 1.5em;">TAX INVOICE / RECEIPT</h3>
                <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; line-height: 1.5em;">CUSTOMER</p>
                <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; line-height: 1.5em;">
                    DATE OF ISSUE<br> 
                    <b>${formattedDate}</b>
                </p>

                <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; line-height: 1.5em; text-align: right;">INVOICE NUMBER: <b>#INV${invoiceData.id}</b></p>
                <br>
                <table style="width: 100%; font-family: Verdana, Geneva, Tahoma, sans-serif; font-weight: 400; vertical-align: middle; line-height: 1.5em;">
                    <tr>
                        <th style="background-color: #F6F8FA; padding: 0.9rem; border-bottom: 1px solid #EBF5FF; text-align: left;" >Quantity</th>
                        <th style="background-color: #F6F8FA; padding: 0.9rem; border-bottom: 1px solid #EBF5FF; text-align: left;">Service</th>
                        <th style="background-color: #F6F8FA; padding: 0.9rem; border-bottom: 1px solid #EBF5FF; text-align: right;" >Price</th>
                    </tr>
                    ${productsHTML} <!-- Insert productsHTML here -->
                    <tr>
                        <td colspan="3" style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: right;">
                            Subtotal $${invoiceData.subtotal}<br>
                            Total: <strong style="font-size: 20px;">$${invoiceData.total}</strong><br>
                            GST: $${invoiceData.gst}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;" colspan="2">PAYMENTS</td>
                        <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: right;"></td>
                    </tr>
                    ${cardDetailsHTML} <!-- Insert cardDetailsHTML here -->
                    <tr>
                        <td colspan="3" style="padding: 0.9rem; text-align: right;">
                            Total Paid: <strong style="font-size: 20px;">$${totalPaid}</strong><br>
                            ${changeAmount > 0 ? `Change: <strong style="font-size: 20px;">$${changeAmount.toFixed(2)}</strong>` : ''}
                        </td>
                    </tr>
                </table>
            </div>
            </body>
            </html>
        `;

        var printContainer = document.createElement('div');
        printContainer.setAttribute('id', 'print-container');
        printContainer.innerHTML = printableContent;
        document.body.appendChild(printContainer);

        // Print the page
        window.print();

        // Remove the container from the document body
        document.body.removeChild(printContainer);
    }
    function calculateTotalPaid(payments) {
        return payments.reduce((total, payment) => total + parseFloat(payment.amount), 0).toFixed(2);
    }
</script>
</html>
@endsection