<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'amount' => $this->resource->amount,
            'amount_untaxed' => $this->resource->amount_untaxed,
            'stockable' => boolval($this->resource->stockable),
            'active_for_reservation' => boolval($this->resource->active_for_reservation),
            'tax_id' => $this->resource->tax_id,
            'capacity_for_day_min' => $this->resource->capacity_for_day_min,
            'capacity_for_day_max' => $this->resource->capacity_for_day_max,
            'currency' => $this->whenLoaded('currency',new CurrencyResource($this->currency)),
        ];
    }
}
