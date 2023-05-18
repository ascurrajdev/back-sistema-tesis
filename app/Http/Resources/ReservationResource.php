<?php

namespace App\Http\Resources;

use App\Models\InvoiceDue;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
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
            'date_from' => $this->resource->date_from,
            'date_to' => $this->resource->date_to,
            'total_amount' => $this->resource->total_amount,
            'notes' => $this->resource->notes,
            'active' => $this->resource->active,
            'created_at' => $this->resource->created_at->format("d/m/Y H:i:s"),
            'currency' => new CurrencyResource($this->whenLoaded('currency')),
            'client' => new ClientResource($this->whenLoaded('client')),
            'agency' => new AgencyResource($this->whenLoaded('agency')),
            'invoiceDue' => InvoiceDueResource::collection($this->whenLoaded('invoiceDue')),
            'details' => ReservationDetailsResource::collection($this->whenLoaded('detailsReservation')),
        ];
    }
}
