<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceDueResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'number_due' => $this->resource->number_due,
            'amount' => $this->resource->amount,
            'paid' => $this->resource->paid,
            'expiration_date' => $this->resource->expiration_date,
            'invoice_id' => $this->resource->invoice_id,
            'reservation_id' => $this->resource->reservation_id,
            'is_initial_reservation_payment' => $this->resource->is_initial_reservation_payment,
        ];
    }
}
