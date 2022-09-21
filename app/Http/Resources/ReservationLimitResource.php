<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationLimitResource extends JsonResource
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
            'id' => $this->resource->id,
            'date' => $this->resource->date,
            'capacity_min' => $this->resource->capacity_min,
            'capacity_max' => $this->resource->capacity_max,
            'available' => $this->resource->available,
            'product_id' => $this->resource->product_id,
            'product' => new ProductResource($this->whenLoaded('product')),
        ];
    }
}
