<?php

namespace App\Http\Resources\Marketing;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name ,
            'age'     => $this->age,
            'gender'  => $this->gender,
            'address' => $this->address,
            'email'   => $this->email,
            'phone'   => $this->phone,
        ];
    }
}
