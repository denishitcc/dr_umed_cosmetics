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
            'category_id'       => $this->category_id,
            'service_id'        => $this->service_id,
            'duration'          => $this->duration,
            'date'              => $this->start_date,
            'appointment_date'  => date('D d M Y', strtotime($this->start_date)),
            'appointment_time'  => date('H:i a', strtotime($this->start_date)),
            'status'            => $this->appointment_status,
            'services_name'     => $this->services->service_name,
            'staff_id'          => $this->staff_id,
            'staff_name'        => $this->staff->name,
            'client_data'       => isset($this->clients) ? new ClientResource($this->clients) : []
        ];
    }
}
