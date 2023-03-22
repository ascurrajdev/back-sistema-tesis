<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AgencyResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'address' => $this->resource->address,
            'city' => $this->resource->city,
            'neighborhood' => $this->resource->neighborhood,
            'active' => $this->resource->active,
            'active_for_reservations_online' => $this->resource->active_for_reservations_online,
        ]; 
    }
}
