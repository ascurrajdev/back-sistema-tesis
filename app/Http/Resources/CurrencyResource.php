<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyResource extends JsonResource
{
    
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'currency_format' => $this->resource->currency_format,
            'decimals' => $this->resource->decimals,
            'default' => $this->resource->default,
        ];
    }
}
