<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LastAppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'service_name'      => $this->services->service_name,
            'staff_name'        => isset($this->staff->name) ? $this->staff->name : '',
            'location_name'     => isset($this->staff->staff_location) ? $this->staff->staff_location->location_name:'',
            'start_date'        => $this->start_date,
            'status'            => $this->appointment_status,
            'appointment_date'  => date('d M Y', strtotime($this->start_date)),
        ];
        // 'service_name'      => isset($client->last_appointment) ? $client->last_appointment->services->service_name : '',
        // 'start_date'        => isset($client->last_appointment) ? $client->last_appointment->start_date : '',
        // 'staff_name'        => isset($client->last_appointment) ? $client->last_appointment->staff->name : '',
        // 'location_name'     => isset($client->last_appointment) ? $client->last_appointment->staff->staff_location->location_name : '',
        // 'status'            => isset($client->last_appointment) ? $client->last_appointment->appointment_status : '',
    }
}
