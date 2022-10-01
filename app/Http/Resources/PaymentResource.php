<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'is_card' => $this->resource->is_card,
            'is_cash' => $this->resource->is_cash,
            'is_transfer_bank' => $this->resource->is_transfer_bank,
            'type_card' => $this->resource->type_card,
        ];
    }
}
