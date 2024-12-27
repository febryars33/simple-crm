<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Employee extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'company_id' => $this->company_id,
            'name' => $this->name,
            'nik' => $this->nik,
            'phone' => $this->phone,
            'birth_place' => $this->birth_place,
            'birth_date' => $this->birth_date,
            'address' => $this->address,
            'role' => $this->role,
            'user' => $this->when($this->relationLoaded('user'), new User($this->user)),
            'company' => $this->when($this->relationLoaded('company'), new Company($this->company)),
        ];
    }
}
