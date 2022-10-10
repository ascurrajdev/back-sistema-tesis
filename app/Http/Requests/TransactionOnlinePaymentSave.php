<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionOnlinePaymentSave extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'payment' => ['required','array'],
            'payment.hook_alias' => ['required','string'],
            'payment.link_url' => ['required','string'],
            'payment.status' => ['required','string'],
            'payment.response_code' => ['required','string'],
            'payment.response_description' => ['required',' string'],
            'payment.amount' => ['required','numeric'],
            'payment.currency' => ['required','string'],
            'payment.installment_number' => ['required','numeric'],
            'payment.description' => ['required','string'],
            'payment.date_time' => ['required','string','date_format:d/m/Y H:i:s'],
            'payment.ticket_number' => ['required','numeric'],
            'payment.authorization_code' => ['required_if:status,failed','string','nullable'],
            'payment.commerce_name' => ['required','string'],
            'payment.branch_name' => ['required','string'],
            'payment.account_type' => ['required','string'],
            'payment.card_last_numbers' => ['numeric'],
            'payment.bin' => ['string'],
            'payment.entity_id' => ['required','string'],
            'payment.entity_name' => ['required','string'],
            'payment.brand_id' => ['string','nullable'],
            'payment.brand_name' => ['string','nullable'],
            'payment.product_id' => ['string','nullable'],
            'payment.product_name' => ['string','nullable'],
            'payment.afinity_id' => ['string','nullable'],
            'payment.afinity_name' => ['string','nullable'],
            'payment.type' => ['string'],
            'payment.payer' => ['array'],
            'payment.payer.name' => ['string'],
            'payment.payer.lastname' => ['string'],
            'payment.payer.cellphone' => ['string'],
            'payment.payer.email' => ['string'],
            'payment.payer.notes' => ['string'],
        ];
    }
}
