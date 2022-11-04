<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationConfigResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'is_partial_payment' => $this->resource->is_partial_payment,
            'initial_payment_percent' => $this->resource->initial_payment_percent,
            'max_quantity_quotes' => $this->resource->max_quantity_quotes,
            'max_days_expiration_initial_payment' => $this->resource->max_days_expiration_initial_payment,
        ];
    }
}
