<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->tokenCan('payments-store');
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
            'is_card' => ['required_with:type_card','boolean'],
            'type_card' => [Rule::in(['credit','debit']),'required_with:is_card'],
            'is_cash' => ['boolean'],
            'is_transfer_bank' => ['boolean'],
            'required_vaucher' => ['boolean'],
            'is_online_transaction' => ['boolean']
        ];
    }
}
