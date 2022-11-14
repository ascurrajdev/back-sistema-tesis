<?php
namespace App\Services;
use App\Contracts\PaymentService;
use Illuminate\Support\Facades\Http;
class TpagoPaymentService implements PaymentService{

    private $apiKey;
    private $secretKey;

    public function __construct()
    {
        $this->apiKey = config('dlocal.api_key');
        $this->secretKey = config('dlocal.secret_key');
    }
    public function createLinkPayment($amount,$description){
        $response = Http::withBasicAuth($this->apiKey,$this->secretKey)->acceptJson()
        ->post(config('dlocal.base_url')."/v1/payments",[
            'amount' => $amount,
            'description' => $description
        ]);
        return $response->json();
    }
    public function makeReversePayment($paymentId){
        $response = Http::withBasicAuth($this->apiKey,$this->secretKey)->acceptJson()
        ->put(config('dlocal.base_url')."commerces/{$this->commerceCode}/branches/{$this->branchCode}/links/payments/revert/{$paymentId}");
        return $response->json();
    }
}