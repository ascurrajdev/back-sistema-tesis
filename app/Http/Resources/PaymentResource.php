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
            'is_online_transaction' => $this->resource->is_online_transaction,
            'type_card' => $this->resource->type_card,
        ];
    }
}
