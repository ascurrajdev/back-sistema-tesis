<?php

namespace App\Http\Controllers;

use App\Traits\ResponseTrait;
class CurrencyCodesController extends Controller
{
    use ResponseTrait;
    public function index(){
        $currencyCountries = [];
        foreach(config('country-codes') as $code => $country){
            $currencyCountries[$code] = config('currencies-country-codes')[$code];
        }
        return $this->success($currencyCountries);
    }
}
