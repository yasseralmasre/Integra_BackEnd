<?php

namespace App\Http\Resources\Marketing;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SocialMediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'blogger'     => $this->blogger,
            'type'        => $this->type,
            'way'         => $this->way,
            'cost'        => $this->cost,
            'campaign_id' => $this->campaign_id,
            'expected_revenue' =>$this->expected_revenue,
            'actual_revenue'   =>$this->actual_revenue
        ];
    }
}
