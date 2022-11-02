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
            'stockable' => $this->resource->stockable,
            'active_for_reservation' => $this->resource->active_for_reservation,
            'currency' => $this->whenLoaded('currency',new CurrencyResource($this->currency)),
        ];
    }
}
