<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->tokenCan('products-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "name" => ['string','min:3'],
            'amount' => ['numeric'],
            'tax_id' => ['exists:taxes,id','nullable'],
            'currency_id' => ['exists:currencies,id'],
            'active_for_reservation' => ['boolean'],
            'is_lodging' => ['boolean'],
            'capacity_for_day_max' => ['numeric'],
            'capacity_for_day_min' => ['numeric'],
            'stockable' => ['boolean']
        ];
    }
}
