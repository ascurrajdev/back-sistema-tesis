<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationDetailsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'quantity' => $this->resource->quantity,
            'amount' => $this->resource->amount,
            'discount' => $this->resource->discount,
            'product' => new ProductResource($this->whenLoaded('product')),
        ];
    }
}
