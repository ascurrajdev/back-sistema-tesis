<?php
namespace App\Services;
use App\Contracts\PaymentService;
use Illuminate\Support\Facades\Http;
use Stevebauman\Location\Facades\Location;
class DlocalPaymentService implements PaymentService{

    private $apiKey;
    private $secretKey;

    public function __construct()
    {
        $this->apiKey = config('dlocal.api_key');
        $this->secretKey = config('dlocal.secret_key');
    }
    public function createLinkPayment($client,$amount,$description){
        $location = Location::get(request()->ip());
        $currency = "PYG";
        $country = "PY";
        if(!empty($location->countryCode)){
            $country = $location->countryCode;
            $currency = config('currencies-country-codes'.$country,'PYG');
        }
        $response = Http::withOptions([
            'verify' => false
        ])->withBasicAuth($this->apiKey,$this->secretKey)->acceptJson()
        ->post(config('dlocal.base_url')."/v1/payments",[
            'amount' => $amount,
            'currency' => $currency,
            'country' => $country,
            'description' => $description,
            'payer' => [
                'name' => $client->name,
                'email' => $client->email,
            ]
        ]);
        return $response->json();
    }
    public function makeReversePayment($paymentId){
        $response = Http::withOptions([
            'verify' => false
        ])->withBasicAuth($this->apiKey,$this->secretKey)->acceptJson()
        ->put(config('dlocal.base_url')."commerces/{$this->commerceCode}/branches/{$this->branchCode}/links/payments/revert/{$paymentId}");
        return $response->json();
    }
}