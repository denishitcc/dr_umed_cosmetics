<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'resourceId'    => $this->staff_id,
            'title'         => $this->services->service_name,
            'start'         => $this->start_date,
            'end'           => $this->end_date,
            'color'         => $this->staff->calendar_color,
            'className'     => "edit_appointment",
            'extendedProps' =>[
                'client_id'     => $this->client_id,
                'client_name'   => (isset($this->clients->firstname) ? $this->clients->firstname : '') . ' ' . (isset($this->clients->lastname) ? $this->clients->lastname : ''),
                'service_id'    => $this->service_id,
                'category_id'   => $this->category_id
            ],
        ];        
    }
}
