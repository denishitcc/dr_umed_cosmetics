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
                            <h5 class="black">{{ $appointment->services->service_name }}</h5>
                            <p>{{ $appointment->duration }}m with {{ $appointment->staff->name }}<br>
                                {{-- <span class="font-13">(Uninvoiced) : $0.00</span> --}}
                            </p>
                            <div class="add-note-btn-box">
                                <a href="#" class="btn btn-primary font-13 me-2">Add
                                    Notes</a>
                                <a href="#" class="btn btn-primary font-13 alter">
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
                        <div class="add-note-btn-box">
                            <a href="javascript:void(0);" class="btn btn-primary font-13 me-2" id="add_notes" data-appointment_id="{{ $appointment->id }}"> Add Notes </a>
                            <a href="javascript:void(0);" class="btn btn-primary font-13 alter" id="add_treatment_notes" data-appointment_id="{{ $appointment->id }}"> Add treatment notes </a>
                        </div>
                        {{-- <a href="#" class="badge badge-alter badge-icon badge-note my-2"><i
                                class="ico-file-text me-2 fs-4 align-middle"></i> 0
                            Notes</a> --}}
                    </div>
                </div>
            </li>
        @endforeach

        {{-- <li class="scaffold-layout-list-item active">
            <div class="appt-timeplace">
                Today<br>12:00pm @<br> Hope Island<br> (Booked)
            </div>
            <div class="appt-details">
                <a href="#" class="btn btn-primary btn-sm pointer"><i class="ico-right-arrow fs-4"></i></a>
                <div class="his-detaiils">
                    <h5 class="black">Client Consultation</h5>
                    <p>15m with Dr Umed (Hope Island) Shekhawat<br>
                        <span class="font-13">(Uninvoiced) : $0.00</span>
                    </p>
                </div>
                <div class="his-detaiils">
                    <h5 class="black">Anti-Wrinkle - Dysport</h5>
                    <p>15m with Dr Umed (Hope Island) Shekhawat<br>
                        <span class="font-13">(Uninvoiced) : $0.00</span>
                    </p>
                    <span class="badge badge-black my-2">Total: $400.00</span><br>
                    <a href="#" class="badge badge-alter badge-icon badge-note my-2"><i
                            class="ico-file-text me-2 fs-4 align-middle"></i> 2
                        Notes</a>
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
                        <span class="font-13">(Uninvoiced) : $0.00</span>
                    </p>
                    <div class="add-note-btn-box">
                        <a href="#" class="btn btn-primary font-13 me-2">Add
                            Notes</a>
                        <a href="#" class="btn btn-primary font-13 alter">
                            Add treatment notes </a>
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
                        <span class="font-13">(Uninvoiced) : $0.00</span>
                    </p>
                    <div class="add-note-btn-box">
                        <a href="#" class="btn btn-primary font-13 alter">
                            Add treatment notes </a>
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
                        <span class="font-13">(Uninvoiced) : $0.00</span>
                    </p>
                    <div class="add-note-btn-box">
                        <a href="#" class="btn btn-primary font-13 me-2">Add
                            Notes</a>
                        <a href="#" class="btn btn-primary font-13 alter">
                            Add treatment notes </a>
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
                        <span class="font-13">(Uninvoiced) : $0.00</span>
                    </p>
                    <div class="add-note-btn-box">
                        <a href="#" class="btn btn-primary font-13 me-2">Add
                            Notes</a>
                        <a href="#" class="btn btn-primary font-13 alter">
                            Add treatment notes </a>
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
                        <span class="font-13">(Uninvoiced) : $0.00</span>
                    </p>
                    <div class="add-note-btn-box">
                        <a href="#" class="btn btn-primary font-13 alter">
                            Add treatment notes </a>
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
                        <span class="font-13">(Uninvoiced) : $0.00</span>
                    </p>
                    <div class="add-note-btn-box">
                        <a href="#" class="btn btn-primary font-13 me-2">Add
                            Notes</a>
                        <a href="#" class="btn btn-primary font-13 alter">
                            Add treatment notes </a>
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
                        <span class="font-13">(Uninvoiced) : $0.00</span>
                    </p>
                    <a href="#" class="badge badge-alter badge-icon badge-note my-2"><i
                            class="ico-file-text me-2 fs-4 align-middle"></i> 0
                        Notes</a>
                </div>
                <div class="his-detaiils">
                    <h5 class="black">HIFU Full Face</h5>
                    <p>15m with Jen Taylor<br>
                        <span class="font-13">(Uninvoiced) : $0.00</span>
                    </p>
                    <div class="add-note-btn-box">
                        <a href="#" class="btn btn-primary font-13 me-2">Add
                            Notes</a>
                        <a href="#" class="btn btn-primary font-13 alter">
                            Add treatment notes </a>
                    </div>
                </div>
                <div class="his-detaiils">
                    <h5 class="black">HIFU Full Face</h5>
                    <p>15m with Jen Taylor<br>
                        <span class="font-13">(Uninvoiced) : $0.00</span>
                    </p>
                    <div class="add-note-btn-box">
                        <a href="#" class="btn btn-primary font-13 me-2">Add
                            Notes</a>
                        <a href="#" class="btn btn-primary font-13 alter">
                            Add treatment notes </a>
                    </div>
                </div>
                <div class="his-detaiils">
                    <h5 class="black">Anti-Wrinkle - Dysport</h5>
                    <p>15m with Dr Umed (Hope Island) Shekhawat<br>
                        <span class="font-13">(Uninvoiced) : $0.00</span>
                    </p>
                    <span class="badge badge-black my-2">Total: $400.00</span><br>
                    <a href="#" class="badge badge-alter badge-icon badge-note my-2"><i
                            class="ico-file-text me-2 fs-4 align-middle"></i> 2
                        Notes</a>
                </div>
            </div>
        </li> --}}
    </ul>
    @else
        <h6 class="fiord mb-5">This client has no past appointments.</h6>
    @endif
</div>
