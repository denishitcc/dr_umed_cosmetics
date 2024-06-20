@extends('layouts.sidebar')
@section('title', 'Edit Client')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="card">

    <div class="card-head">
        <h4 class="small-title mb-0">Client card</h4>
    </div>
    <div class="card-body pb-3">
        <div class="client-invo-notice">
            <div class="inv-left">
                <div class="client-name">
                    <div class="drop-cap" style="background: #D0D0D0; color: #000;">{{ucfirst(substr($client->firstname, 0, 1))}}</div>
                    <div class="client-info">
                        <h4 class="blue-bold" id="clientcardid" data-client_id="{{ $client->id }}">{{$client->firstname.' '.$client->lastname}}</h4>
                        <a href="#" class="river-bed"><b>{{$client->mobile_number}}</b></a><br>
                        <a href="#" class="river-bed"><b>{{$client->email}}</b></a>
                    </div>
                </div>
            </div>
            <div class="inv-center">
                @if (isset($client->last_appointment))
                <div class="d-grey">
                    Last appt at {{ isset($client->last_appointment->staff->staff_location->location_name) ? $client->last_appointment->staff->staff_location->location_name : 'N/A' }} 
                    on {{ isset($client->last_appointment->start_date) ? $client->last_appointment->start_date : 'N/A' }}
                    <br>{{ isset($client->last_appointment->services->service_name) ? $client->last_appointment->services->service_name : 'N/A' }} 
                    with {{ isset($client->last_appointment->staff->name) ? $client->last_appointment->staff->name : 'N/A' }} 
                    ({{ isset($client->last_appointment->appointment_status) ? $client->last_appointment->appointment_status : 'N/A' }})
                </div>

                @endif
            </div>
            <div class="inv-right">
                <a href="#" class="btn btn-primary btn-md icon-btn-left"><i class="ico-user2 me-2 fs-6"></i> Give to Alana to Update Details</a>
            </div>
        </div>
    </div>

    <ul class="nav brand-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#tab_1" aria-selected="true" role="tab"><i class="ico-clipboard-text"></i> Client History</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab_2" aria-selected="false" tabindex="-1" role="tab"><i class="ico-task"></i> Client Details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab_3" aria-selected="false" tabindex="-1" role="tab"><i class="ico-photo"></i> Photos<span class="badge badge-circle ms-2 photos_count">{{count($client_photos)}}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab_4" aria-selected="false" tabindex="-1" role="tab"><i class="ico-folder"></i> Documents<span class="badge badge-circle ms-2 doc_count">{{count($client_documents)}}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab_5" aria-selected="false" tabindex="-1" role="tab"><i class="ico-appt-reminder"></i> Forms<span class="badge badge-circle ms-2">5</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab_6" aria-selected="false" tabindex="-1" role="tab"><i class="ico-payment-gateway"></i> Messages</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="tab_1" role="tabpanel">
            <div class="card-body">
                <div class="scaffold-layout-outr">
                <div class="scaffold-layout-list-details" id="appointmentTab">
                    <div class="scaffold-layout-list">
                        @if ($futureappointments->count())
                            <ul class="scaffold-layout-list-container h-50">
                                Next Appointment
                                @foreach ($futureappointments as $appointment)
                                    <li class="scaffold-layout-list-item active">
                                    <div class="appt-timeplace">
                                        {{ isset($appointment->start_date) ? date('D Y-m-d', strtotime($appointment->start_date)) : 'N/A' }} <br> 
                                        {{ isset($appointment->start_date) ? date('h:i A', strtotime($appointment->start_date)) : 'N/A' }} @<br> 
                                        {{ isset($appointment->staff->staff_location->location_name) ? $appointment->staff->staff_location->location_name : 'N/A' }} <br> 
                                        ({{ isset($appointment->appointment_status) ? $appointment->appointment_status : 'N/A' }})
                                    </div>

                                        <div class="appt-details">
                                            <span class="btn btn-primary btn-sm pointer"><i class="ico-right-arrow fs-4"></i></span>
                                            <div class="his-detaiils">
                                                <h5 class="black">{{ $appointment->services->service_name }} </h5>
                                                <p>{{ $appointment->duration }}m with {{ $appointment->staff->name }}<br>
                                                    {{-- <span class="font-13">(Uninvoiced) : $0.00</span> --}}
                                                </p>
                                                @if (isset($appointment->note->notescount))
                                                    <a href="javascript:void(0);" class="badge badge-alter badge-icon badge-note my-2 show_notes" data-appointment_id="{{ $appointment->id }}"><i class="ico-file-text me-2 fs-4 align-middle"></i> {{ $appointment->note->notescount }} Notes </a>
                                                    <div class="add-note-btn-box">
                                                        @if($appointment->note->treatment_notes == null)
                                                        <a href="javascript:void(0);" class="btn btn-primary font-13 alter" id="add_treatment_notes" data-appointment_id="{{ $appointment->id }}"> Add treatment notes </a>
                                                        @endif
                                                        @if($appointment->note->common_notes == null)
                                                        <a href="javascript:void(0);" class="btn btn-primary font-13 me-2" id="add_notes" data-appointment_id="{{ $appointment->id }}"> Add Notes </a>
                                                        @endif
                                                    </div>
                                                @else
                                                <div class="add-note-btn-box">
                                                    <a href="#" class="btn btn-primary font-13 me-2" id="add_notes" data-appointment_id="{{ $appointment->id }}"> Add
                                                        Notes</a>
                                                    <a href="#" class="btn btn-primary font-13 alter"id="add_treatment_notes" data-appointment_id="{{ $appointment->id }}">
                                                        Add treatment notes </a>
                                                </div>
                                                @endif
                                                {{-- <a href="#" class="badge badge-alter badge-icon badge-note my-2"><i
                                                        class="ico-file-text me-2 fs-4 align-middle"></i> 0
                                                    Notes</a> --}}
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <h6 class="fiord mb-5">This client has no upcoming appointments.</h6>
                        @endif
                        <hr>
                        @if ($pastappointments->count())
                            <ul class="scaffold-layout-list-container h-50">
                                History
                                @foreach ($pastappointments as $appointment)
                                    <li class="scaffold-layout-list-item">
                                        <div class="appt-timeplace">
                                            {{  date('D Y-m-d', strtotime($appointment->start_date)) }} <br> 
                                            {{ date('h:i A', strtotime($appointment->start_date)) }} @<br> 
                                            {{ isset($appointment->staff->staff_location->location_name)? $appointment->staff->staff_location->location_name : '' }} <br>
                                            ({{ $appointment->appointment_status }})
                                        </div>
                                        <div class="appt-details">
                                            <div class="his-detaiils">
                                                <h5 class="black">{{ $appointment->services->service_name }}</h5>
                                                <p>{{ $appointment->duration }}m with {{ $appointment->staff->name }}<br>
                                                    {{-- <span class="font-13">(Uninvoiced) : $0.00</span> --}}
                                                </p>
                                                @if (isset($appointment->note->notescount))
                                                    <a href="javascript:void(0);" class="badge badge-alter badge-icon badge-note my-2 show_notes" data-appointment_id="{{ $appointment->id }}"><i class="ico-file-text me-2 fs-4 align-middle"></i> {{ $appointment->note->notescount }} Notes </a>
                                                    <div class="add-note-btn-box">
                                                        @if($appointment->note->treatment_notes == null)
                                                        <a href="javascript:void(0);" class="btn btn-primary font-13 alter" id="add_treatment_notes" data-appointment_id="{{ $appointment->id }}"> Add treatment notes </a>
                                                        @endif
                                                        @if($appointment->note->common_notes == null)
                                                        <a href="javascript:void(0);" class="btn btn-primary font-13 me-2" id="add_notes" data-appointment_id="{{ $appointment->id }}"> Add Notes </a>
                                                        @endif
                                                    </div>
                                                @else
                                                <div class="add-note-btn-box">
                                                    <a href="javascript:void(0);" class="btn btn-primary font-13 alter" id="add_treatment_notes" data-appointment_id="{{ $appointment->id }}"> Add treatment notes </a>

                                                    <a href="javascript:void(0);" class="btn btn-primary font-13 me-2" id="add_notes" data-appointment_id="{{ $appointment->id }}"> Add Notes </a>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <h6 class="fiord mb-5">This client has no past appointments.</h6>
                        @endif

                        {{-- <h6 class="fiord mb-5">This client has no upcoming appointments.</h6>
                        <ul class="scaffold-layout-list-container"> --}}
                            {{-- <li class="scaffold-layout-list-item">
                                <div class="appt-timeplace">
                                    Today<br>12:00pm @<br> Hope Island<br> (Booked)
                                </div>
                                <div class="appt-details">
                                    <div class="his-detaiils">
                                        <h5 class="black">3 Area Anti Wrinkle Package</h5>
                                        <p>30m with Nurse Vish<br>
                                        <span class="font-13">(Uninvoiced) : $0.00</span></p>
                                        <a href="#" class="badge badge-alter badge-icon badge-note my-2"><i class="ico-file-text me-2 fs-4 align-middle"></i> 0 Notes</a>
                                    </div>
                                </div>
                            </li>
                            <li class="scaffold-layout-list-item active">
                                <div class="appt-timeplace">
                                    Today<br>12:00pm @<br> Hope Island<br> (Booked)
                                </div>
                                <div class="appt-details">
                                    <a href="#" class="btn btn-primary btn-sm pointer"><i class="ico-right-arrow fs-4"></i></a>
                                    <div class="his-detaiils">
                                        <h5 class="black">Client Consultation</h5>
                                        <p>15m with Dr Umed (Hope Island) Shekhawat<br>
                                        <span class="font-13">(Uninvoiced) : $0.00</span></p>
                                    </div>
                                    <div class="his-detaiils">
                                        <h5 class="black">Anti-Wrinkle - Dysport</h5>
                                        <p>15m with Dr Umed (Hope Island) Shekhawat<br>
                                        <span class="font-13">(Uninvoiced) : $0.00</span></p>
                                        <span class="badge badge-black my-2">Total: $400.00</span><br>
                                        <a href="#" class="badge badge-alter badge-icon badge-note my-2"><i class="ico-file-text me-2 fs-4 align-middle"></i> 2 Notes</a>
                                    </div>
                                </div>
                            </li>
                            <li class="scaffold-layout-list-item">
                                <div class="appt-timeplace">
                                    Fri 18 Mar 2022<br> 2:15pm @<br> Hope Island<br> (Completed)
                                </div>
                                <div class="appt-details">
                                    <div class="his-detaiils">
                                        <h5 class="black">Cosmetic Consultation</h5>
                                        <p>15m with Dr Umed (Hope Island) Shekhawat<br>
                                        <span class="font-13">(Uninvoiced) : $0.00</span></p>
                                        <div class="add-note-btn-box">
                                            <a href="#" class="btn btn-primary font-13 me-2">Add Notes</a>
                                            <a href="#" class="btn btn-primary font-13 alter"> Add treatment notes </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="scaffold-layout-list-item">
                                <div class="appt-timeplace">
                                    Mon 31 Jan 2022<br> 10:00am @<br> Hope Island<br> (Completed)
                                </div>
                                <div class="appt-details">
                                    <div class="his-detaiils">
                                        <h5 class="black">Anti-Wrinkle - Dysport</h5>
                                        <p>15m with Dr Umed (Hope Island) Shekhawat<br>
                                        <span class="font-13">(Uninvoiced) : $0.00</span></p>
                                        <div class="add-note-btn-box">
                                            <a href="#" class="btn btn-primary font-13 alter"> Add treatment notes </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="scaffold-layout-list-item">
                                <div class="appt-timeplace">
                                    Mon 28 Feb 2022<br> 8:00am @<br> Hope Island<br> (Completed)
                                </div>
                                <div class="appt-details">
                                    <div class="his-detaiils">
                                        <h5 class="black">HIFU Full Face</h5>
                                        <p>15m with Jen Taylor<br>
                                        <span class="font-13">(Uninvoiced) : $0.00</span></p>
                                        <div class="add-note-btn-box">
                                            <a href="#" class="btn btn-primary font-13 me-2">Add Notes</a>
                                            <a href="#" class="btn btn-primary font-13 alter"> Add treatment notes </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="scaffold-layout-list-item">
                                <div class="appt-timeplace">
                                    Fri 18 Mar 2022<br> 2:15pm @<br> Hope Island<br> (Completed)
                                </div>
                                <div class="appt-details">
                                    <div class="his-detaiils">
                                        <h5 class="black">Cosmetic Consultation</h5>
                                        <p>15m with Dr Umed (Hope Island) Shekhawat<br>
                                        <span class="font-13">(Uninvoiced) : $0.00</span></p>
                                        <div class="add-note-btn-box">
                                            <a href="#" class="btn btn-primary font-13 me-2">Add Notes</a>
                                            <a href="#" class="btn btn-primary font-13 alter"> Add treatment notes </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="scaffold-layout-list-item">
                                <div class="appt-timeplace">
                                    Mon 31 Jan 2022<br> 10:00am @<br> Hope Island<br> (Completed)
                                </div>
                                <div class="appt-details">
                                    <div class="his-detaiils">
                                        <h5 class="black">Anti-Wrinkle - Dysport</h5>
                                        <p>15m with Dr Umed (Hope Island) Shekhawat<br>
                                        <span class="font-13">(Uninvoiced) : $0.00</span></p>
                                        <div class="add-note-btn-box">
                                            <a href="#" class="btn btn-primary font-13 alter"> Add treatment notes </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="scaffold-layout-list-item">
                                <div class="appt-timeplace">
                                    Mon 28 Feb 2022<br> 8:00am @<br> Hope Island<br> (Completed)
                                </div>
                                <div class="appt-details">
                                    <div class="his-detaiils">
                                        <h5 class="black">HIFU Full Face</h5>
                                        <p>15m with Jen Taylor<br>
                                        <span class="font-13">(Uninvoiced) : $0.00</span></p>
                                        <div class="add-note-btn-box">
                                            <a href="#" class="btn btn-primary font-13 me-2">Add Notes</a>
                                            <a href="#" class="btn btn-primary font-13 alter"> Add treatment notes </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="scaffold-layout-list-item">
                                <div class="appt-timeplace">
                                    Today<br>12:00pm @<br> Hope Island<br> (Booked)
                                </div>
                                <div class="appt-details">
                                    <div class="his-detaiils">
                                        <h5 class="black">3 Area Anti Wrinkle Package</h5>
                                        <p>30m with Nurse Vish<br>
                                        <span class="font-13">(Uninvoiced) : $0.00</span></p>
                                        <a href="#" class="badge badge-alter badge-icon badge-note my-2"><i class="ico-file-text me-2 fs-4 align-middle"></i> 0 Notes</a>
                                    </div>
                                    <div class="his-detaiils">
                                        <h5 class="black">HIFU Full Face</h5>
                                        <p>15m with Jen Taylor<br>
                                        <span class="font-13">(Uninvoiced) : $0.00</span></p>
                                        <div class="add-note-btn-box">
                                            <a href="#" class="btn btn-primary font-13 me-2">Add Notes</a>
                                            <a href="#" class="btn btn-primary font-13 alter"> Add treatment notes </a>
                                        </div>
                                    </div>
                                    <div class="his-detaiils">
                                        <h5 class="black">HIFU Full Face</h5>
                                        <p>15m with Jen Taylor<br>
                                        <span class="font-13">(Uninvoiced) : $0.00</span></p>
                                        <div class="add-note-btn-box">
                                            <a href="#" class="btn btn-primary font-13 me-2">Add Notes</a>
                                            <a href="#" class="btn btn-primary font-13 alter"> Add treatment notes </a>
                                        </div>
                                    </div>
                                    <div class="his-detaiils">
                                        <h5 class="black">Anti-Wrinkle - Dysport</h5>
                                        <p>15m with Dr Umed (Hope Island) Shekhawat<br>
                                        <span class="font-13">(Uninvoiced) : $0.00</span></p>
                                        <span class="badge badge-black my-2">Total: $400.00</span><br>
                                        <a href="#" class="badge badge-alter badge-icon badge-note my-2"><i class="ico-file-text me-2 fs-4 align-middle"></i> 2 Notes</a>
                                    </div>
                                </div>
                            </li> --}}
                        {{-- </ul> --}}
                    </div>
                    <div class="scaffold-layout-detail" id="clientNotes">
                        <!-- <h4 class="d-grey mb-4">Notes</h4>
                        <div class="yellow-note-box">
                            <p> <strong>Common Notes:</strong><br> Form incomplete. 400 (paid together with Moey $1150 eft).</p>
                            <div class="add-note-btn-box">
                            <a href="#" class="btn btn-primary font-13 alter"> Edit Notes</a>
                        </div>
                        </div>
                        <div class="yellow-note-box">
                            <p>
                            <strong>Treatment Notes:</strong><br>
                                Client presented to clinic for cheek filler. Cheek Filler: <br><br>

                                Juvederm Voluma 2mls used. Treated ck1 and ck2 with 0.5mls on each side. And 1ml used to treat preauricular area. 0.5mls on each side using canulla.<br><br>

                                Has had dermal filler in the past and had no complications from the treatment<br>
                                -Allergies: Nil Known<br>
                                -Medical conditions:<br>
                                -Medications: Not taking any<br>
                                Not pregnant and not breastfeeding<br>
                                -Medical conditions:<br>
                                -Medications: Not taking any
                            </p>
                                <div class="add-note-btn-box">
                                    <a href="#" class="btn btn-primary font-13 me-2">Add Notes</a>
                                    <a href="#" class="btn btn-primary font-13 alter"> Edit Notes</a>
                                </div>
                        </div> -->
                        <div id="ClientNotesData">
                            <h4 class="d-grey mb-4">Notes</h4>
                            <div class="yellow-note-box common_notes">
                                <strong>Common Notes:</strong>
                                @if (isset($appointmentNotes))
                                <div class="viewnotes">
                                    <p> <br>
                                        {{ $appointmentNotes->common_notes }}
                                    </p>
                                    <div class="add-note-btn-box">
                                        <button type="button" class="btn btn-primary font-13 alter" id="edit_common_notes">Edit Notes </button>
                                    </div>
                                </div>
                                @endif
                                <div class="common d-none">
                                    <form method="post" >
                                        @if(isset($appointmentNotes))
                                            <input type="hidden" name="appointment_id" value="{{ $appointmentNotes->appointment_id }}" >
                                            <textarea name="common_notes" id="common_notes" cols="80" rows="5" class="form=control" > {{ $appointmentNotes->common_notes }} </textarea>
                                        @else
                                            <input type="hidden" name="appointment_id" >
                                            <textarea name="common_notes" id="common_notes" cols="80" rows="5" class="form=control" > </textarea>
                                        @endif
                                        <div class="add-note-btn-box">
                                            <br>
                                            <button type="button" class="btn btn-primary font-13 me-2" id="add_common_notes">Add Notes </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="yellow-note-box treatment_notes">
                                <strong>Treatment Notes:</strong><br>
                                @if (isset($appointmentNotes))
                                    <div class="treatmentviewnotes">
                                        <p>
                                            {{ $appointmentNotes->treatment_notes }}
                                        </p>
                                        <div class="add-note-btn-box">
                                            <button type="button" class="btn btn-primary font-13 alter" id="edit_treatment_notes">Edit Notes </button>
                                        </div>
                                    </div>
                                @endif
                                <div class="treatment_common d-none">
                                    <form method="post">
                                        @if(isset($appointmentNotes))
                                            <input type="hidden" name="appointment_id" value="{{ $appointmentNotes->appointment_id }}">
                                            <textarea name="treatment_notes" id="treatment_notes" cols="80" rows="5" class="form=control">  {{ $appointmentNotes->treatment_notes }}  </textarea>
                                        @else
                                            <input type="hidden" name="appointment_id" >
                                            <textarea name="treatment_notes" id="treatment_notes" cols="80" rows="5" class="form=control" > </textarea>
                                        @endif
                                    </form>
                                    <div class="add-note-btn-box">
                                        <br>
                                        <button type="button" class="btn btn-primary font-13 me-2" id="submit_treatment_notes">Add Notes </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clients_photos">
                            <h4 class="d-grey mb-3 mt-5">Photos</h4>
                            @if ($client_photos->count())
                            <div class="gallery client-phbox grid-4 history">
                                @foreach ($client_photos as $photos)
                                    <figure>
                                        <a href="{{ $photos->photourl }}" data-fancybox="mygallery">
                                            <img src="{{ $photos->photourl }}" alt="{{ $photos->client_photos }}">
                                        </a>
                                    </figure>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="tab_2" role="tabpanel">
            <div class="card-head pb-4">
                <h5 class="bright-gray mb-0">Client details </h5>
            </div>
            <form id="update_client_detail" name="update_client_detail" class="form">
            @csrf
            <input type="hidden" name="id" id="id" value="{{$client->id}}">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" placeholder="" name="firstname" id="firstname" maxlength="50" value="{{$client->firstname}}">
                            </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Last Name </label>
                            <input type="text" class="form-control" placeholder="" name="lastname" id="lastname" maxlength="50" value="{{$client->lastname}}">
                            </div>
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label">Gender</label>
                        <div class="toggle mb-1">
                        <input type="radio" name="gender" value="Male" {{ ($client->gender=="Male")? "checked" : "" }}  id="male" checked="checked" />
                        <label for="male">Male <i class="ico-tick"></i></label>
                        <input type="radio" name="gender" value="Female" {{ ($client->gender=="Female")? "checked" : "" }}  id="female" />
                        <label for="female">Female <i class="ico-tick"></i></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" placeholder="" name="email" maxlength="100" value="{{$client->email}}" disabled>
                            </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" class="form-control"  name="date_of_birth" id="date_of_birth" value="{{$client->date_of_birth}}">
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group mb-4">
                            <label class="form-label">Mobile Number</label>
                            <input type="text" class="form-control" name="mobile_number" id="mobile_number" value="{{$client->mobile_number}}" maxlength="15">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Location</label>
                            <select class="form-select form-control" name="location_name">
                                <option selected value=""> -- select an option -- </option>
                                @if(count($location)>0)
                                @foreach($location as $loc)
                                    <option value="{{ $loc->id }}" {{ ( $loc->id == $client->location_id) ? 'selected' : '' }}> {{ $loc->location_name }} </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group mb-0">
                            <label class="form-label">Home Phone</label>
                            <input type="text" class="form-control" name="home_phone" id="home_phone" value="{{$client->home_phone}}">
                            </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group mb-0">
                            <label class="form-label">Work Phone</label>
                            <input type="text" class="form-control" name="work_phone" id="work_phone" value="{{$client->work_phone}}">
                            </div>
                    </div>
                </div>
            </div>
            <div class="card-head pt-3 pb-4">
                <h5 class="bright-gray mb-0">Contact preferences</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group mb-0">
                            <label class="form-label">Preferred contact method</label>
                            <select class="form-select form-control" name="contact_method" id="contact_method">
                                <option selected="" value=""> -- select an option -- </option>
                                <option value="Text message (SMS)" {{ ($client->contact_method == "Text message (SMS)")? "selected" : "" }} >Text message (SMS)</option>
                                <option value="Email" {{ ($client->contact_method == "Email")? "selected" : "" }}>Email</option>
                                <option value="Phone call" {{ ($client->contact_method == "Phone call")? "selected" : "" }}>Phone call</option>
                                <option value="Post" {{ ($client->contact_method == "Post")? "selected" : "" }}>Post</option>
                                <option value="No preference" {{ ($client->contact_method == "No preference")? "selected" : "" }}>No preference</option>
                                <option value="Don't send reminders" {{ ($client->contact_method == "Don't send reminders")? "selected" : "" }}>Don't send reminders</option>
                            </select>
                            </div>
                    </div>
                    
                    <div class="col-lg-3">
                        <label class="form-label">Send promotions</label>
                        <div class="toggle mb-0">
                        <input type="radio" name="send_promotions" value="1" {{ ($client->send_promotions=="1")? "checked" : "" }}  id="yes" checked="checked" />
                        <label for="yes">Yes <i class="ico-tick"></i></label>
                        <input type="radio" name="send_promotions" value="0" {{ ($client->send_promotions=="0")? "checked" : "" }}  id="no" />
                        <label for="no">No <i class="ico-tick"></i></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-head pt-3 pb-4">
                <h5 class="bright-gray mb-0">Address</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Street address</label>
                            <input type="text" class="form-control" id="street_address" name="street_address" value="{{$client->street_address}}">
                            </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Suburb</label>
                            <input type="text" class="form-control" id="suburb" name="suburb" value="{{$client->suburb}}">
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group mb-0">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city" value="{{$client->city}}">
                            </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group mb-0">
                            <label class="form-label">Post code</label>
                            <input type="text" class="form-control" id="postcode" name="postcode" value="{{$client->postcode}}">
                            </div>
                    </div>
                    <div class="col-lg-12 text-lg-end mt-4">
                        <button type="button" class="btn btn-light me-2" onclick="window.location='{{ url("clients") }}'">Discard</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
        <div class="tab-pane fade" id="tab_3" role="tabpanel">
            <form id="update_client_photos" name="update_client_photos" class="form" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label class="gl-upload photo_img">
                        <div class="icon-box">
                            <img src="../img/upload-icon.png" alt="" class="up-icon">
                            <span class="txt-up">Choose a File or drag them here</span>
                            <input type="file" class="filepond form-control" name="filepond" id="client_photos" accept="image/png, image/jpeg" multiple/>
                        </div>
                    </label>
                    <div class="mt-2 d-grey font-13"><em>Photos you add here will be visible to this client in Online Booking.</em></div>
                </div>
                <div class="gallery client-phbox grid-6 gap-2 h-188">
                @if(count($client_photos)>0)
                    @foreach($client_photos as $photos)
                    <figure>
                        <a href="{{asset('storage/images/clients_photos/').'/'.$photos->client_photos}}" data-fancybox="mygallery"><img src="{{asset('storage/images/clients_photos/').'/'.$photos->client_photos}}" alt=""></a>
                        <button type="button" photos ids="{{$photos->id}}"class="btn black-btn round-6 dt-delete remove_image"><i class="ico-trash"></i></button>
                    </figure>
                    @endforeach
                @endif
                </div>
            </div>
            </form>
        </div>
        <div class="tab-pane fade" id="tab_4" role="tabpanel">
            <form id="update_client_documents" name="update_client_documents" class="form" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label class="gl-upload doc_img">
                        <div class="icon-box">
                            <img src="../img/upload-icon.png" alt="" class="up-icon">
                            <span class="txt-up">Choose a File or drag them here</span>
                            <span class="txt-up" style="opacity: .5;">.xls, Word, PNG, JPG or PDF</span>
                            <input class="form-control" type="file" id="client_documents" name="client_documents" accept="application/pdf, applucation/vnd.ms-excel,application/msword,image/png, image/jpeg" multiple>
                        </div>
                    </label>
                    <div class="mt-2 d-grey font-13"><em>Documents you add here will be visible to this client in Online Booking.</em></div>
                </div>
                <div class="form-group mb-0 docs">
                @if(count($client_documents)>0)
                    @foreach($client_documents as $doc)
                    <a href="#" class="btn tag icon-btn-left skyblue mb-2"><span><i class="ico-pdf me-2 fs-2 align-middle"></i> {{$doc->client_documents}}</span> <span class="file-date">{{date('d F h:i A', strtotime($doc->created_at))}}</span><i class="del ico-trash remove_doc" ids="{{$doc->id}}"></i></a>
                    @endforeach
                @endif
                </div>
            </div>
            </form>
        </div>
        <div class="tab-pane fade" id="tab_5" role="tabpanel">
        <div class="card-body">
            <table class="table all-db-table align-middle accordion-table">
                <thead>
                <tr>
                    <th class="blue-bold" width="70%" aria-sort="ascending">22 Sep 2023</th>
                    <th class="blue-bold" width="20%">Status </th>
                    <th class="blue-bold" width="10%"></th>
                </tr>
                </thead>
                <tbody>
                    <tr class="pnl-head">
                        <td><a href="#" style="color: #0747A6;">Aftercare Dermal Fillers - (Please take a snap shot)</a></td>
                        <td><span class="badge text-bg-blue badge-md badge-rounded">Submitted</span></td>
                        <td class="text-center"><button type="button" class="btn btn-sm black-btn round-6 dt-delete"> <i class="ico-trash"></i> </button></td>
                    </tr>
                    <tr class="pnl-content">
                        <td colspan="3">
                            <div class="table-card-header">
                                <h5>Aftercare Dermal Fillers - (Please take a snap shot) Form</h5> <button type="button" class="btn-close"></button>
                            </div>
                            <div class="table-card-body">
                                <div class="d-flex mb-4">
                                    <a href="#" class="btn btn-light-grey50 btn-md icon-btn-left"><i class="ico-user2 me-2 fs-6"></i> Give to Alana to Update Details</a>
                                </div>

                                <div class="alert alert-green alert-xs">
                                    This form is read-only because it's been completed.
                                    <a href="#" class="alert-close"><i class="ico-close"></i></a>
                                    </div>


                                <p>Dr Umed Shekhawat<br>
                                    Cosmetic Physician (Specialist Registration General Practice)<br>
                                    MBBS, FRACGP, Diploma of Skin Cancer / The Injecting Nurse has explained the products and procedure to me.<br><br>
                                        I have been informed by the Dr/ Nurse of possible complications of Dermal Fillers, such as local pain, redness, swelling, bruising, infection, biofilm, blistering or ulceration. There is also a risk of skin darkening or lightening, which can last for several months. There have also been reported cases of loss of vision, stroke and nerve paralysis, but these complications are extremely rare. There is a slight chance of having a poor cosmetic outcome, over correction or under correction.<br><br>
                                        
                                        Fillers can be dissolved if you are unhappy with the outcome, and in the case of under correction, more product may be injected however both options will incur a further cost.<br><br>
                                        
                                        Dr Umed and his Nurses are highly trained and experienced in all the cosmetic procedures he provides however, he is not able to guarantee the clients expected results will occur in a singular visit and as such, he has a strict no refund policy under any circumstances. <br><br>
                                        
                                        This informed consent document outlines most of the common and uncommon risks involving cosmetic injections. Other risks are possible. Once you have read and understood this information, and had the opportunity to ask questions and discuss any concerns with Dr. Umed or one of our Registered Nurses, please sign and date below.</p>

                                        <div class="white-layer">
                                        <label class="form-label"><b>I understand the above</b> </label><br>
                                        <label class="cst-radio"><input type="radio" checked="" name="form1"><span class="checkmark me-2"></span>Yes</label>
                                        </div>

                                        <div class="white-layer">
                                        <label class="form-label"><b>Alternatives to injections include no treatment, skin care, laser resurfacing, chemical peels, facelifts and other surgical therapies, and other modalities.
                                        </b> </label><br>
                                        <label class="cst-radio"><input type="radio" checked="" name="form2"><span class="checkmark me-2"></span>Yes</label>
                                        </div>

                                        <div class="white-layer">
                                        <label class="form-label"><b>I understand the above </b> </label><br>
                                        <label class="cst-radio"><input type="radio" checked="" name="form3"><span class="checkmark me-2"></span>Yes</label>
                                        </div>

                                        <div class="white-layer">
                                        <label class="form-label"><b>Risks. Every procedure (surgical or non-surgical) involves risks that can only be completely avoided by foregoing treatment. Determining whether or not a procedure is right for you depends on your evaluation of the risks, benefits, goals, alternatives, and recovery associated with the procedures.</b> </label><br>
                                        <label class="cst-radio"><input type="radio" checked="" name="form4"><span class="checkmark me-2"></span>I understand</label>
                                        </div>

                                        <div class="white-layer">
                                        <label class="form-label"><b>Bumpiness (nodularity). Patients often feel some bumpiness, firmness, or tightness under the skin at the site of filler injections. Usually, this is not visible and resolves in 1 -2 weeks.</b> </label><br>
                                        <label class="cst-radio"><input type="radio" checked="" name="form5"><span class="checkmark me-2"></span>I understand</label>
                                        </div>

                                        <div class="white-layer">
                                        <label class="form-label"><b>Bumpiness (nodularity). Patients often feel some bumpiness, firmness, or tightness under the skin at the site of filler injections. Usually, this is not visible and resolves in 1 -2 weeks. </b> </label><br>
                                        <label class="cst-radio me-3"><input type="radio" checked="" name="form6"><span class="checkmark me-2"></span>Yes</label>
                                        <label class="cst-radio"><input type="radio" checked="" name="form6"><span class="checkmark me-2"></span>No</label>
                                        </div>

                                        <p>By signing this document, I have read and understand the information provided in this waiver and grant permission for my treatment.</p>

                                        <div class="mb-4"><img src="../img/demo-signature.png" alt=""></div>

                                        <label>9:43 am 22 Sep 2023</label><br><br>

                                        <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <input type="date" class="form-control">
                                                </div>
                                        </div>
                                        </div>

                                        
                                
                            </div>
                            <div class="table-card-footer">
                                <div class="tf-left">
                                    <a href="#" class="btn btn-primary btn-md icon-btn-left"><i class="ico-user2 me-2 fs-6"></i> Download</a>
                                </div>
                                <div class="tf-right">
                                    <button type="button" class="btn btn-light btn-md me-2">Cancel</button>
                                    <button type="submit" class="btn btn-primary btn-md">Edit Form</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="#" style="color: #0747A6;">Aftercare Lips Dermal Fillers - (Please take a snap shot)</a></td>
                        <td><span class="badge text-bg-orange badge-md badge-rounded">In progress</span></td>
                        <td class="text-center"><button type="button" class="btn btn-sm black-btn round-6 dt-delete"> <i class="ico-trash"></i> </button></td>
                    </tr>
                    <tr>
                        <td><a href="#" style="color: #0747A6;">Informed Consent for Dermal Fillers</a></td>
                        <td><span class="badge text-bg-blue badge-md badge-rounded">Submitted</span></td>
                        <td class="text-center"><button type="button" class="btn btn-sm black-btn round-6 dt-delete"> <i class="ico-trash"></i> </button></td>
                    </tr>
                    <tr>
                        <td><a href="#" style="color: #0747A6;">NURSE- Injectable Product Prescription</a></td>
                        <td><span class="badge text-bg-green badge-md badge-rounded">Complete</span></td>
                        <td class="text-center"><button type="button" class="btn btn-sm black-btn round-6 dt-delete"> <i class="ico-trash"></i> </button></td>
                    </tr>
                </tbody>
            </table>
            <table class="table all-db-table align-middle">
                <thead>
                <tr>
                    <th class="blue-bold" width="70%" aria-sort="ascending">21 Oct 2022</th>
                    <th class="blue-bold" width="20%">Status </th>
                    <th class="blue-bold" width="10%"></th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><a href="#" style="color: #0747A6;">Informed Consent for Antiwrinkles</a></td>
                        <td><span class="badge text-bg-blue badge-md badge-rounded">Submitted</span></td>
                        <td class="text-center"><button type="button" class="btn btn-sm black-btn round-6 dt-delete"> <i class="ico-trash"></i> </button></td>
                    </tr>
                    <tr>
                        <td><a href="#" style="color: #0747A6;">After Care Anti Wrinkles</a></td>
                        <td><span class="badge text-bg-seagreen badge-md badge-rounded">New</span></td>
                        <td class="text-center"><button type="button" class="btn btn-sm black-btn round-6 dt-delete"> <i class="ico-trash"></i> </button></td>
                    </tr>
                </tbody>
            </table>

            

            
        </div>
        </div>
        <div class="tab-pane fade" id="tab_6" role="tabpanel">
        <div class="card-body">
            <h6 class="fiord mb-4">This client has no upcoming appointments.</h6>
            <div class="time-line--outr pd-20">
                <div class="time-line-item">
                    <div class="time-line-icon">
                        <div class="avatar" style="background: #D0D0D0; color: #000;">M</div>
                    </div>
                    <div class="time-line-content">
                        <div class="dot-box">
                            <span class="badge booked me-3 font-13">Booked</span>
                            <div class="dropdown">
                                <button class="dot-nav" data-bs-toggle="dropdown"><i class="ico-nav-dots"></i></button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Booked</a></li>
                                    <li><a class="dropdown-item" href="#">Completed</a></li>
                                    <li><a class="dropdown-item" href="#">Turned-up</a></li>
                                </ul>
                                </div>
                        </div>
                        <div class="blue-bold mb-2">Appointment: Wed 4 Oct 2023@ Hope Island</div>
                        <p class="mb-2">Zeina, Dr Umed Cosmetics 1/341 Hope Island Rd Hope Island 4212 Wed, 4-Oct 12:00pm. Please respond YES to confirm or call 0407 194 519 to reschedule.</p>
                        <em class="d-grey font-13">SMS Sent 4 Oct 2023, 12.00 PM</em>
                    </div>
                </div>
                <div class="time-line-item">
                    <div class="time-line-icon">
                        <div class="avatar" style="background: #D0D0D0; color: #000;">M</div>
                    </div>
                    <div class="time-line-content">
                        <div class="dot-box">
                            <span class="badge completed me-3 font-13">Completed</span>
                            <div class="dropdown">
                                <button class="dot-nav" data-bs-toggle="dropdown"><i class="ico-nav-dots"></i></button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Booked</a></li>
                                    <li><a class="dropdown-item" href="#">Completed</a></li>
                                    <li><a class="dropdown-item" href="#">Turned-up</a></li>
                                </ul>
                                </div>
                        </div>
                        <div class="blue-bold mb-2">Appointment: Wed 4 Oct 2023@ Hope Island</div>
                        <p class="mb-2">Zeina, Dr Umed Cosmetics 1/341 Hope Island Rd Hope Island 4212 Wed, 4-Oct 12:00pm. Please respond YES to confirm or call 0407 194 519 to reschedule.</p>
                        <em class="d-grey font-13">SMS Sent 4 Oct 2023, 12.00 PM</em>
                    </div>
                </div>
                <div class="time-line-item">
                    <div class="time-line-icon">
                        <div class="avatar" style="background: #D0D0D0; color: #000;">M</div>
                    </div>
                    <div class="time-line-content">
                        <div class="dot-box">
                            <span class="badge turned-up me-3 font-13">Turned-up</span>
                            <div class="dropdown">
                                <button class="dot-nav" data-bs-toggle="dropdown"><i class="ico-nav-dots"></i></button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Booked</a></li>
                                    <li><a class="dropdown-item" href="#">Completed</a></li>
                                    <li><a class="dropdown-item" href="#">Turned-up</a></li>
                                </ul>
                                </div>
                        </div>
                        <div class="blue-bold mb-2">Appointment: Wed 4 Oct 2023@ Hope Island</div>
                        <p class="mb-2">Zeina, Dr Umed Cosmetics 1/341 Hope Island Rd Hope Island 4212 Wed, 4-Oct 12:00pm. Please respond YES to confirm or call 0407 194 519 to reschedule.</p>
                        <em class="d-grey font-13">SMS Sent 4 Oct 2023, 12.00 PM</em>
                    </div>
                </div>
                <div class="time-line-item">
                    <div class="time-line-icon">
                        <div class="avatar" style="background: #D0D0D0; color: #000;">M</div>
                    </div>
                    <div class="time-line-content">
                        <div class="dot-box">
                            <span class="badge completed me-3 font-13">Completed</span>
                            <div class="dropdown">
                                <button class="dot-nav" data-bs-toggle="dropdown"><i class="ico-nav-dots"></i></button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Booked</a></li>
                                    <li><a class="dropdown-item" href="#">Completed</a></li>
                                    <li><a class="dropdown-item" href="#">Turned-up</a></li>
                                </ul>
                                </div>
                        </div>
                        <div class="blue-bold mb-2">Appointment: Wed 4 Oct 2023@ Hope Island</div>
                        <p class="mb-2">Zeina, Dr Umed Cosmetics 1/341 Hope Island Rd Hope Island 4212 Wed, 4-Oct 12:00pm. Please respond YES to confirm or call 0407 194 519 to reschedule.</p>
                        <em class="d-grey font-13">SMS Sent 4 Oct 2023, 12.00 PM</em>
                    </div>
                </div>
                <div class="time-line-item">
                    <div class="time-line-icon">
                        <div class="avatar" style="background: #D0D0D0; color: #000;">M</div>
                    </div>
                    <div class="time-line-content">
                        <div class="dot-box">
                            <span class="badge completed me-3 font-13">Completed</span>
                            <div class="dropdown">
                                <button class="dot-nav" data-bs-toggle="dropdown"><i class="ico-nav-dots"></i></button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Booked</a></li>
                                    <li><a class="dropdown-item" href="#">Completed</a></li>
                                    <li><a class="dropdown-item" href="#">Turned-up</a></li>
                                </ul>
                                </div>
                        </div>
                        <div class="blue-bold mb-2">Appointment: Wed 4 Oct 2023@ Hope Island</div>
                        <p class="mb-2">Zeina, Dr Umed Cosmetics 1/341 Hope Island Rd Hope Island 4212 Wed, 4-Oct 12:00pm. Please respond YES to confirm or call 0407 194 519 to reschedule.</p>
                        <em class="d-grey font-13">SMS Sent 4 Oct 2023, 12.00 PM</em>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
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
    $(document).ready(function(){
        $(document).on('click', '.show_notes', function(e) {
            var appointment_id = $(this).data('appointment_id'),
                clientId       = $('#clientcardid').data('client_id');
            $.ajax({
                url: "{{ route('calendar.view-appointment-notes') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'appointment_id': appointment_id,
                    'client_id' :clientId
                },
                success: function(data) {
                    $('#client_info').find('#ClientNotesData').remove();
                    $('#clientNotes').html(data.client_notes);
                    // $('.clients_photos').show();
                },
                error: function(error) {
                    console.error('Error fetching events:', error);
                }
            });
        });
        $(document).on('click','#add_notes', function(e){
            var $this           = $(this),
                appointment_id  = $this.data('appointment_id');

            $('.common_notes').find('input:hidden[name=appointment_id]').val(appointment_id);
            $(".viewnotes").remove();
            $(".common").removeClass('d-none');
            $("#common_notes").val('');

            // var commonNotesDiv = '<h4 class="d-grey mb-4">Notes</h4><div class="yellow-note-box common_notes">' +
            //     '<strong>Common Notes:</strong>' +
            //     '<div class="common">' +
            //     '<form method="post">' +
            //     '<input type="hidden" name="appointment_id" value="' + appointment_id + '">' +
            //     '<textarea name="common_notes" id="common_notes" cols="80" rows="5" class="form-control"></textarea>' +
            //     '<div class="add-note-btn-box">' +
            //     '<br>' +
            //     '<button type="button" class="btn btn-primary font-13 me-2" id="add_common_notes" fdprocessedid="dz4weo">Add Notes</button>' +
            //     '</div>' +
            //     '</form>' +
            //     '</div>' +
            //     '</div>';

            // Append the common_notes div
            // $('#clientNotes').html(commonNotesDiv);
        });
        // Open form on edit custom notes button
        $(document).on('click','#edit_common_notes', function(e){
            $(".common").removeClass('d-none');
            $(".viewnotes").remove();
        });
        // add common note ajax
        $(document).on('click','#add_common_notes', function(e){
            e.preventDefault();
            var appointmentId = $('.common_notes').find('input:hidden[name=appointment_id]').val(),
                commonNotes   = $('#common_notes').val(),
                clientId      = $('#clientcardid').data('client_id');

                $.ajax({
                url: "{!! route('calendar.add-appointment-notes') !!}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'appointmentId'  : appointmentId,
                    'commonNotes'    : commonNotes,
                    'client_id'      : clientId
                },
                success: function (data) {
                    // location.reload();
                    $('#client_info').find('#ClientNotesData').remove();
                    $('#clientNotes').html(data.client_notes);
                },
                error: function (error) {
                    console.error('Error fetching events:', error);
                }
            });
        });
        // Open form on add treatment notes button
        $(document).on('click','#add_treatment_notes', function(e){
            var $this           = $(this),
                appointment_id  = $this.data('appointment_id');

            $('.treatment_notes').find('input:hidden[name=appointment_id]').val(appointment_id);
            $(".treatmentviewnotes").remove();
            $(".treatment_common").removeClass('d-none');
            $("#treatment_notes").val('');

            // var commonNotesDiv = '<h4 class="d-grey mb-4">Notes</h4><div class="yellow-note-box treatment_notes">' +
            //     '<strong>Treatment Notes:</strong><br>' +
            //     '<div class="treatment_common">' +
            //     '<form method="post">' +
            //     '<input type="hidden" name="appointment_id" value="' + appointment_id + '">' +
            //     '<textarea name="treatment_notes" id="treatment_notes" cols="80" rows="5" class="form-control"></textarea>' +
            //     '</form>' +
            //     '<div class="add-note-btn-box">' +
            //     '<br>' +
            //     '<button type="button" class="btn btn-primary font-13 me-2" id="submit_treatment_notes" fdprocessedid="1nvl6f">Add Notes</button>' +
            //     '</div>' +
            //     '</div>' +
            //     '</div>';


            // // Append the common_notes div
            // $('#clientNotes').html(commonNotesDiv);
        });
        // Open form on edit treatment notes button
        $(document).on('click','#edit_treatment_notes', function(e){
            $(".treatment_common").removeClass('d-none');
            $(".treatmentviewnotes").remove();
        });
        // add treatment note ajax
        $(document).on('click','#submit_treatment_notes', function(e){
            e.preventDefault();
            var appointmentId    = $('.treatment_notes').find('input:hidden[name=appointment_id]').val(),
                treatmentNotes   = $('#treatment_notes').val(),
                clientId      = $('#clientcardid').data('client_id');

                $.ajax({
                url: "{!! route('calendar.add-appointment-notes') !!}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'appointmentId'  : appointmentId,
                    'treatmentNotes' : treatmentNotes,
                    'client_id'      : clientId
                },
                success: function (data) {
                    // location.reload();
                    $('#client_info').find('#ClientNotesData').remove();
                    $('#clientNotes').html(data.client_notes);
                },
                error: function (error) {
                    console.error('Error fetching events:', error);
                }
            });
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


        $(".list-group ul li.dropdown").click(function(){
            $(this).toggleClass("show");
        });
        $(".gallery a").attr("data-fancybox","mygallery");
        $(".gallery a").fancybox();

        var $panelHeader = $('.accordion-table tr.pnl-head');
        var $panelContent = $('.accordion-table tr.pnl-content');

        // Add classes to toggles and content
        $panelHeader.addClass("accordion-panel-header");
        $panelContent.addClass("accordion-panel-content");

        // Wrap the contents of the content panels with a div that we can target to slideToggle smoothly since it doesn't work on table rows.
        $('.accordion-panel-content td').wrapInner( "<div class='panel-content-wrapper'></div>" );

        $('.accordion-panel-header').each(function(){
            var $content = $(this).closest('tr').next().find('.panel-content-wrapper');
            $(this).click(function(e) {
                e.preventDefault();
                if ($(this).hasClass('toggled')) {
                    $(this).removeClass('toggled');
                    $content.slideToggle(200);
                } else {
                    $(this).addClass('toggled');
                    $content.slideToggle(200);
                }
            });
        });
        $("#update_client_detail").validate({
            rules: {
                location_name:{
                    required:true,
                },
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
        
        $("#client_photos").change(function () {
            var fileCount = this.files.length;
            var inputElement = document.getElementById('client_photos');
            var data = new FormData();
            var id = $('#id').val();
            var gallery = $('.client-phbox'); // Selecting the gallery container
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
                                icon: "success",
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
                                icon: "error",
                            });
                        }
                    }
                });
            }
        });
        $("#client_documents").change(function() {
            var fileCount = this.files.length;
            var inputElement = document.getElementById('client_documents');
            var data = new FormData();
            var id=$('#id').val();
            var gallery = $('.docs'); // Selecting the document container
            for (var i = 0; i < this.files.length; i++) {
                var reader = new FileReader();
                var files = this.files[i].name;
                var currFile = this.files[i];
                var fileExt = files.split('.').pop().toLowerCase(); // file extension
                // Check if the file has a valid extension
                if ($.inArray(fileExt, ['png', 'jpeg', 'jpg', 'xlsx', 'doc', 'pdf']) !== -1) { // 2MB in bytes  && fileSize <= 2097152
                    var reader = new FileReader();
                    reader.onload = (function (file) {
                        return function (e) {
                            var d = new Date();
                            const month = d.toLocaleString('default', { month: 'long' });
                            var fulldate = d.getDate()+' '+ month + ' ' + d.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
                            var fileName = file.name;
                            var fileContents = e.target.result;
                            // Append the document and delete button to the gallery
                            gallery.append('<a href="#" class="btn tag icon-btn-left skyblue mb-2 latest_remove_doc"><span><i class="ico-pdf me-2 fs-2 align-middle"></i> ' + fileName + '</span> <span class="file-date">' + fulldate + '</span><i class="del ico-trash remove_doc"></i></a>');
                        };
                    })(currFile);
                    reader.readAsDataURL(this.files[i]);
                    data.append('pics[]', currFile);
                    data.append('id',id);
                } else {
                    if(file_cnt != ''){
                        $('.photos_cnt').text(file_cnt);
                    } else {
                        $('.photos_cnt').text('');
                    }
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
                            uploadedImageIds = response.client_id;
                            Swal.fire({
                                title: "Client!",
                                text: "Client Documents Updated successfully.",
                                icon: "success",
                            }).then((result) => {
                                // Update document count
                                var docCount = parseInt($('.doc_count').text());
                                var resultDocCount = docCount + fileCount;
                                $('.doc_count').text(resultDocCount);
                                
                                // Assign IDs to the delete buttons
                                $('.latest_remove_doc').each(function(index) {
                                    $(this).find('.del').attr('ids', uploadedImageIds[index]);
                                });
                            });
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: response.message,
                                icon: "error",
                            });
                        }
                    }
                });
            }
        });

        
    });
    $(document).on('submit','#update_client_detail',function(e){
		e.preventDefault();
        var id=$('#id').val();
		var valid= $("#update_client_detail").validate();
			if(valid.errorList.length == 0){
                var data = $('#update_client_detail').serialize() ;
            // var data = new FormData(this);
            // $.each($('.client-phbox').find('img'),function(index){
            //     
            //     var photos_img = $('.client-phbox').find('img')[index].src;
            //     data.append('pics[]', photos_img);
            // });
            // $.each($('.file-hoder').find('a'),function(index){
            //     
            //     var docs_imgs = $('.file-hoder').find('img')[index].src;
            //     data.append('docs[]', docs_imgs);
            // });
			SubmitUpdateClientDetails(data,id);
		}
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
                        text: "Client Photo Deleted successfully.",
                        icon: "success",
                    }).then((result) => {
                        var photosCount = parseInt($('.photos_count').text());
                        var resultdoc = photosCount - 1;
                        $('.photos_count').text(resultdoc);
                        // window.location = "{{url('clients')}}/" + id
                    });
                } else {
                    
                    Swal.fire({
                        title: "Error!",
                        text: response.message,
                        icon: "error",
                    });
                }
            }
        });
    });
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
                        icon: "success",
                    }).then((result) => {
                        // window.location = "{{url('clients')}}/" + id
                        // window.location = "{{url('clients')}}/" + id
                        var docsCount = parseInt($('.doc_count').text());
                        var resultdoc = docsCount - 1;
                        $('.doc_count').text(resultdoc);
                    });
                } else {
                    
                    Swal.fire({
                        title: "Error!",
                        text: response.message,
                        icon: "error",
                    });
                }
            }
        });
    });
    function SubmitUpdateClientDetails(data,id){
		$.ajax({
			headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: id,
			type: "PUT",
			data: data,
            success: function(response) {
				
				// Show a Sweet Alert message after the form is submitted.
				if (response.success) {
					
					Swal.fire({
						title: "Client!",
						text: "Client Updated successfully.",
						icon: "success",
					}).then((result) => {
                        window.location = "{{url('clients')}}/" + id
                        // window.location = "{{url('clients')}}"//'/player_detail?username=' + name;
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