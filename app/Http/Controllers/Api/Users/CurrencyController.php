<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencySaveRequest;
use App\Http\Requests\CurrencyUpdateRequest;
use App\Http\Resources\CurrencyResource;
use App\Models\Currency;

class CurrencyController extends Controller
{

    public function index(){
        $this->authorize('viewAny',Currency::class);
        return CurrencyResource::collection(Currency::all());
    }

    public function store(CurrencySaveRequest $request)
    {
        $params = $request->validated();
        $currency = Currency::create($params);
        return new CurrencyResource($currency);
    }

    public function view(Currency $currency)
    {
        $this->authorize('view',$currency);
        return new CurrencyResource($currency);
    }

    public function update(CurrencyUpdateRequest $request, Currency $currency)
    {
        $params = $request->validated();
        $currency->fill($params);
        $currency->save();
        return new CurrencyResource($currency);
    }

    public function delete(Currency $currency)
    {
        $this->authorize('delete',$currency);
        $currency->delete();
        return new CurrencyResource($currency);
    }
}
