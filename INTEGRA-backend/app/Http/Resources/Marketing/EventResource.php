<?php

namespace App\Http\Resources\Marketing;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray( $request): array
    {
        return [
            'id'                => $this->id,
            'name'              =>$this->name,
            'place'             => $this->place,
            'description'       => $this->description,
            'type'              => $this->type,
            'cost'              =>$this->cost,
            'expected_revenue'  =>$this->expected_revenue,
            'actual_revenue'    =>$this->actual_revenue,
            'campaign_id'       => $this->campaign_id
        ];
    }
}
