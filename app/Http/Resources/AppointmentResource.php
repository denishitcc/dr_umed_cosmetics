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
            'date'              => $this->start_date,
            'appointment_date'  => date('D d M Y', strtotime($this->start_date)),
            'appointment_time'  => date('H:i a', strtotime($this->start_date)),
            'status'            => $this->appointment_status,
            'services_name'     => $this->services->service_name,
            'staff_name'        => $this->staff->name,
            'client_data'       => isset($this->clients) ? new ClientResource($this->clients) : []
        ];
    }
}
