<?php

namespace App\Http\Resources\Marketing;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TvResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray( $request): array
    {
        return [
            'id'                 => $this->id ,
            'channel'            => $this->channel ,
            'time'               => $this->time ,
            'cost'               => $this->cost ,
            'advertising_period' =>$this->advertising_period,
            'campaign_id'        => $this->campaign_id,
            'expected_revenue'   =>$this->expected_revenue ,
            'actual_revenue'     =>$this->actual_revenue
        ];
    }
}
