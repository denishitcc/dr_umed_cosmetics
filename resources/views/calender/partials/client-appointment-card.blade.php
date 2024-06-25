<div class="scaffold-layout-list"  id="appointmentsData">
    @if ($futureappointments->count())
        <ul class="scaffold-layout-list-container h-50">
            Next Appointment
            @foreach ($futureappointments as $appointment)
                <li class="scaffold-layout-list-item">
                    <div class="appt-timeplace">
                        {{  date('D Y-m-d', strtotime($appointment->start_date)) }} <br> {{ date('h:i A', strtotime($appointment->start_date)) }} @<br> {{ $appointment->staff->staff_location->location_name }} <br> ({{ $appointment->appointment_status }})
                    </div>
                    <div class="appt-details">
                        <div class="his-detaiils">
                            <h5 class="black">{{ $appointment->services->service_name }} </h5>
                            <p>{{ $appointment->duration }}m with {{ isset($appointment->staff->name) ? $appointment->staff->name : '' }}<br>
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
                                <a href="javascript:void(0);" class="btn btn-primary font-13 me-2" id="add_notes" data-appointment_id="{{ $appointment->id }}"> Add
                                    Notes</a>
                                <a href="javascript:void(0);" id="add_treatment_notes" class="btn btn-primary font-13 alter" data-appointment_id="{{ $appointment->id }}">
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
    <ul class="scaffold-layout-list-container">
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
                        <p>{{ $appointment->duration }}m with {{ isset($appointment->staff->name) ? $appointment->staff->name : '' }}<br>
                            {{-- <span class="font-13">(Uninvoiced) : $0.00</span> --}}
                        </p>
                        @if (isset($appointment->note->notescount))
                            <a href="javascript:void(0);" class="badge badge-alter badge-icon badge-note my-2 show_notes" data-appointment_id="{{ $appointment->id }}"><i class="ico-file-text me-2 fs-4 align-middle"></i> {{ $appointment->note->notescount }} Notes </a>
                            <div class="add-note-btn-box">
                                
                                @if($appointment->note->common_notes == null)
                                <a href="javascript:void(0);" class="btn btn-primary font-13 me-2" id="add_notes" data-appointment_id="{{ $appointment->id }}"> Add Notes </a>
                                @endif
                                @if($appointment->note->treatment_notes == null)
                                <a href="javascript:void(0);" class="btn btn-primary font-13 alter" id="add_treatment_notes" data-appointment_id="{{ $appointment->id }}"> Add treatment notes </a>
                                @endif
                            </div>
                        @else
                            <div class="add-note-btn-box">
                                

                                <a href="javascript:void(0);" class="btn btn-primary font-13 me-2" id="add_notes" data-appointment_id="{{ $appointment->id }}"> Add Notes </a>
                                <a href="javascript:void(0);" class="btn btn-primary font-13 alter" id="add_treatment_notes" data-appointment_id="{{ $appointment->id }}"> Add treatment notes </a>
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
</div>
