<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LostPetResource extends JsonResource
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
            'image_path' => $this->image_path,
            'location' => $this->location,
            'lost_at' => $this->lost_at,
            'description' => $this->description,
            'contact_info' => $this->contact_info,
            'pet_detail' => new PetDetailResource($this->WhenLoaded('petDetail'))
        ];
    }
}
