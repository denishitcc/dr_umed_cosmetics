<div class="scaffold-layout-list"  id="appointmentsData">
    @if ($futureappointments->count())
        <ul class="scaffold-layout-list-container">
            Next Appointment
            @foreach ($futureappointments as $appointment)
                <li class="scaffold-layout-list-item">
                    <div class="appt-timeplace">
                        {{  date('D Y-m-d', strtotime($appointment->start_date)) }} <br> {{ date('h:i A', strtotime($appointment->start_date)) }} @<br> {{ $appointment->staff->staff_location->location_name }} <br> ({{ $appointment->appointment_status }})
                    </div>
                    <div class="appt-details">
                        <div class="his-detaiils">
                            <h5 class="black">{{ $appointment->services->service_name }} </h5>
                            <p>{{ $appointment->duration }}m with {{ $appointment->staff->name }}<br>
                                {{-- <span class="font-13">(Uninvoiced) : $0.00</span> --}}
                            </p>
                            <div class="add-note-btn-box">
                                <a href="javascript:void(0);" class="btn btn-primary font-13 me-2"> Add
                                    Notes</a>
                                <a href="javascript:void(0);" class="btn btn-primary font-13 alter">
                                    Add treatment notes </a>
                            </div>
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
                    {{  date('D Y-m-d', strtotime($appointment->start_date)) }} <br> {{ date('h:i A', strtotime($appointment->start_date)) }} @<br> {{ $appointment->staff->staff_location->location_name }} <br> ({{ $appointment->appointment_status }})
                </div>
                <div class="appt-details">
                    <div class="his-detaiils">
                        <h5 class="black">{{ $appointment->services->service_name }}</h5>
                        <p>{{ $appointment->duration }}m with {{ $appointment->staff->name }}<br>
                            {{-- <span class="font-13">(Uninvoiced) : $0.00</span> --}}
                        </p>
                        @if (isset($appointment->note->notescount))
                            <a href="javascript:void(0);" class="badge badge-alter badge-icon badge-note my-2 show_notes" data-appointment_id="{{ $appointment->id }}"><i class="ico-file-text me-2 fs-4 align-middle"></i> {{ $appointment->note->notescount }} Notes </a>
                        @endif

                        @if (isset($appointment->note))
                            @if ($appointment->common_note)
                                <span>Common added</span>
                            @elseif ($appointment->treatment_notes)
                                <span>treatment_notes added</span>
                            @else
                                <span>no notes added</span>
                            @endif
                        @else
                            
                        @endif

                        <div class="add-note-btn-box">
                            <a href="javascript:void(0);" class="btn btn-primary font-13 alter" id="add_treatment_notes" data-appointment_id="{{ $appointment->id }}"> Add treatment notes </a>

                            <a href="javascript:void(0);" class="btn btn-primary font-13 me-2" id="add_notes" data-appointment_id="{{ $appointment->id }}"> Add Notes </a>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    @else
        <h6 class="fiord mb-5">This client has no past appointments.</h6>
    @endif
</div>
