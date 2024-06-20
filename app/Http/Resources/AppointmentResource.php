<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
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
            'service_id'        => $this->service_id,
            'client_id'         => $this->client_id,
            // 'date'              => $this->start_date,
            'date'              => date('d-m-Y', strtotime($this->start_date)),
            'appointment_date'  => date('D d M Y', strtotime($this->start_date)),
            'appointment_time'  => date('h:i a', strtotime($this->start_date)),
            'status'            => $this->appointment_status,
            'status_no'         => $this->status,
            'services_name'     => $this->services->service_name,
            'services_id'       => $this->service_id,
            'category_id'       => $this->category_id,
            'staff_id'          => $this->staff_id,
            'staff_name'        => $this->staff->name,
            'duration'          => $this->services->appearoncalender->duration,
            'client_data'       => isset($this->clients) ? new ClientResource($this->clients) : [],
            'standard_price'    => $this->services->standard_price,
            'walk_in_id'        => $this->walk_in_id,
            'location_id'       => $this->location_id,
            'common_notes'      => $this->common_notes,
            'treatment_notes'   => $this->treatment_notes
        ];
    }
}
