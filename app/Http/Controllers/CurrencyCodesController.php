<?php

namespace App\Http\Controllers;

use App\Traits\ResponseTrait;
class CurrencyCodesController extends Controller
{
    use ResponseTrait;
    public function index(){
        $currencyCodes = [];
        foreach(config('currency-codes') as $code => $currency){
            $currencyCodes[] = [
                'label' => $currency,
                'value' => $code,
            ];
        }
        return $this->success($currencyCodes);
    }
}
