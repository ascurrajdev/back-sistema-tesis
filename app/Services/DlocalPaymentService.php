<?php
namespace App\Services;
use App\Contracts\PaymentService;
use Illuminate\Support\Facades\Http;
use Stevebauman\Location\Facades\Location;
use Log;
class DlocalPaymentService implements PaymentService{

    private $apiKey;
    private $secretKey;

    public function __construct()
    {
        $this->apiKey = config('dlocal.api_key');
        $this->secretKey = config('dlocal.secret_key');
    }
    public function createLinkPayment($client,$amount,$description,$options = []){
        $location = Location::get(request()->ip());
        $currency = "PYG";
        $country = "PY";
        $successUrl = "http://localhost:5173/guards/clients/reservations/add?step=4";
        if(!empty($options) && is_array($options)){
            extract($options);
        }
        Log::info(url("/api/online-payments/dlocal/notification"));
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
            ],
            'success_url' => $successUrl,
            'notification_url' => env("APP_URL")."/api/online-payments/dlocal/notification"
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

    public function getPaymentById($paymentId){
        $response = Http::withOptions([
            'verify' => false
        ])->withBasicAuth($this->apiKey,$this->secretKey)->acceptJson()
        ->get(config('dlocal.base_url')."/v1/payments/{$paymentId}");
        return $response->json();
    }
}