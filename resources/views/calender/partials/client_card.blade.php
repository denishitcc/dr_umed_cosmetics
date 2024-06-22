<div class="card-body pb-3" id="client-invo-notice">
    <div class="client-invo-notice">
        <div class="inv-left">
            <div class="client-name">
                <div class="drop-cap" style="background: #D0D0D0; color: #000;">{{ucfirst(substr($client->name, 0, 1))}}</div>
                <div class="client-info">
                    <h4 class="blue-bold" id="clientcardid" data-client_id="{{ $client->id }}">{{ $client->name }}</h4>
                    <a href="#" class="river-bed"><b> {{ $client->email  }} </b></a><br>
                    <a href="#" class="river-bed"><b> {{ $client->mobile_number }} </b></a>
                </div>
            </div>
        </div>
        <div class="inv-center">
            @if (isset($client->last_appointment))
                <div class="d-grey">
                    Last appt at {{ $client->last_appointment->staff->staff_location->location_name }} on {{  $client->last_appointment->start_date }}
                    <br>{{ $client->last_appointment->services->service_name }} with {{ isset($client->last_appointment->staff->name) ? $client->last_appointment->staff->name : '' }} ({{ $client->last_appointment->appointment_status }})
                </div>
            @endif
        </div>
        <div class="inv-right">
            <a href="#" class="btn btn-primary btn-md icon-btn-left"><i class="ico-user2 me-2 fs-6"></i> Give to
                Alana to Update Details</a>
        </div>
    </div>
</div>