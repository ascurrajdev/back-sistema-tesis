<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgencySaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->tokenCan('agencies-store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required','string'],
            'active' => ['boolean'],
            'active_for_reservations_online' => ['boolean'],
            'city' => ['required','string'],
            'address' => ['required','string'],
            'neighborhood' => ['required','string'],
            'lat' => ['numeric'],
            'lng' => ['numeric']
        ];
    }
}
