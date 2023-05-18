<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            'total_amount' => $this->resource->total_amount,
            'operation_type' => $this->resource->operation_type,
            'created_at' => $this->resource->created_at->format('d/m/Y H:i:s')
        ];
    }
}
