<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PetDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'age' => $this->age,
            'gender' => $this->gender,
            'breed' => $this->breed,
            'color' => $this->color,
            'size' => $this->size,
            'collar' => $this->collar,
            'leg_ring' => $this->leg_ring,
            'lost_pet' => new LostPetResource($this->whenLoaded('lostPet'))
        ];
    }
}
