<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                 => $this->id,
            'first_name'         => $this->firstname,
            'last_name'          => $this->lastname,
            'email'              => $this->email,
            'mobile_no'          => $this->mobile_number,
            'date_of_birth'      => $this->date_of_birth,
            'gender'             => $this->gender,
            'home_phone'         => $this->home_phone,
            'work_phone'         => $this->work_phone,
            'contact_method'     => $this->contact_method,
            'send_promotions'    => $this->send_promotions,
            'street_address'     => $this->street_address,
            'suburb'             => $this->suburb,
            'city'               => $this->city,
            'postcode'           => $this->postcode,
            'last_appointment'   => isset($this->last_appointment) ? new LastAppointmentResource($this->last_appointment) : [],
            'photos'             => isset($this->photos) ? ClientPhotosListResource::collection($this->photos) : [],
            'documents'          => isset($this->documents) ? ClientDocumentsListResource::collection($this->documents) : [],
        ];
    }
}
