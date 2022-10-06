<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrencySaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->tokenCan('currencies-store');
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
            'currency_format' => ['required','max:5','min:1'],
            'currency_quote_id' => ['exists:currencies,id','required_with:currency_quote_price'],
            'currency_quote_price' => ['number','required_with:currency_quote_id'],
            'decimals' => ['required','numeric'],
            'default' => ['boolean']
        ];
    }
}
