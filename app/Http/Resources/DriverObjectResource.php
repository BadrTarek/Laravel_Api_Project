<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DriverObjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this[0]->id,
            'name' => $this[0]->name,
            'image' => $this[0]->image,
            'car_name' => $this[0]->car_name,
            'car_model' => $this[0]->car_model,
            'car_license_number' => $this[0]->car_license_number,
            'driving_license_image' => $this[0]->driving_license_image,
            'car_license_image' => $this[0]->car_license_image,
            'car_photo' => $this[0]->car_photo,
            'trucks_types_id' => $this[0]->trucks_types_id,
            'id_image' => $this[0]->id_image,
            'trucks_types' => $this[1]
        ];
    }
}
