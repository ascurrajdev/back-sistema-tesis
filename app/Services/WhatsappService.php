<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;
class WhatsappService {
    private $whatsappToken;
    private $whatsappNumberId;
    private $whatsappBaseUrl;

    function __construct()
    {
        $this->whatsappToken = config('services.whatsapp.token');
        $this->whatsappNumberId = config('services.whatsapp.number_id');
        $this->whatsappBaseUrl = config('services.whatsapp.base_url');
    }

    public function sendMessage($optionsMessage){
        $params = [
            "messaging_product" => "whatsapp",
        ];
        $params = array_merge($params,$optionsMessage);
        $response = Http::baseUrl($this->whatsappBaseUrl.$this->whatsappNumberId)->acceptJson()->withToken($this->whatsappToken)
        ->post('/messages',$params);
        return $response->json();
    }
}