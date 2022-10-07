<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgencyUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->tokenCan('agencies-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['string'],
            'active' => ['boolean'],
            'active_for_reservations_online' => ['boolean'],
            'city' => ['string'],
            'address' => ['string'],
            'neighborhood' => ['string'],
            'lat' => ['numeric'],
            'lng' => ['numeric']
        ];
    }
}
