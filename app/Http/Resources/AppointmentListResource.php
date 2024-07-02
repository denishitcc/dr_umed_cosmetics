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
            'title'         => isset($this->services->service_name) ? $this->services->service_name : '',
            'start'         => $this->start_date,
            'end'           => $this->end_date,
            'color'         => isset($this->staff->calendar_color) ? $this->staff->calendar_color : '#0b5ed7',
            'className'     => "edit_appointment",
            'extendedProps' =>[
                'client_id'         => $this->client_id,
                'client_name'       => (isset($this->clients->firstname) ? $this->clients->firstname : '') . ' ' . (isset($this->clients->lastname) ? $this->clients->lastname : ''),
                'service_id'        => $this->service_id,
                'category_id'       => $this->category_id,
                'booking_notes'     => isset($this->note->booking_notes) ? $this->note->booking_notes : ''
            ],
        ];
    }
}
