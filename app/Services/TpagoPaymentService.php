<?php
namespace App\Services;
use App\Contracts\PaymentService;
use Illuminate\Support\Facades\Http;
class TpagoPaymentService implements PaymentService{

    private $commerceCode;
    private $branchCode;

    public function __construct()
    {
        $this->commerceCode = config('tpago.commerce_code');
        $this->branchCode = config('tpago.branch_code');
    }
    public function createLinkPayment($amount,$description){
        $response = Http::withBasicAuth(config('tpago.public_key'),config('tpago.private_key'))->acceptJson()
        ->post(config('tpago.base_url')."commerces/{$this->commerceCode}/branches/{$this->branchCode}/links/generate-payment-link",[
            'amount' => $amount,
            'description' => $description
        ]);
        return $response->json();
    }
    public function makeReversePayment($paymentId){
        $response = Http::withBasicAuthAuth(config('tpago.public_key'),config('tpago.private_key'))->acceptJson()
        ->put(config('tpago.base_url')."commerces/{$this->commerceCode}/branches/{$this->branchCode}/links/payments/revert/{$paymentId}");
        return $response->json();
    }
}