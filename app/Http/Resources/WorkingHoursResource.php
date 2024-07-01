<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkingHoursResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id'                => $this->id,
            'start'             => $this->start_date,
            'end'               => $this->end_date,
            'resourceId'        => $this->staff_id,
            'title'             => $this->working_start_time.' - '.$this->working_end_time,
            'backgroundColor'   => $this->color,
        ];
    }
}
