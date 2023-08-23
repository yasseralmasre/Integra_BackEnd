<?php

namespace App\Http\Resources\Marketing;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id'      => $this->id ,
            'content' => $this->content,
            'sender'  => $this->sender,
            'reciver' => $this->reciver,
            'lead_id' => $this->leads,
        ];
    }
}
