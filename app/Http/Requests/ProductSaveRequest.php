<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->tokenCan('products-store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "name" => ['required','string','min:3'],
            'amount' => ['required','numeric'],
            'tax_id' => ['exists:taxes,id',"nullable"],
            // 'currency_id' => ['required','exists:currencies,id'],
            'active_for_reservation' => ['required_with_all:is_lodging,capacity_for_day_max,capacity_for_day_min'],
            'is_lodging' => ['boolean'],
            'capacity_for_day_max' => ['required_with_all:is_lodging,active_for_reservation,capacity_for_day_min'],
            'capacity_for_day_min' => ['required_with_all:is_lodging,active_for_reservation,capacity_for_day_max'],
            'stockable' => ['boolean']
        ];
    }
}
