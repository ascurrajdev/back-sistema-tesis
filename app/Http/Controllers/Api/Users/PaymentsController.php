<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentSaveRequest;
use App\Http\Requests\PaymentUpdateRequest;
use App\Http\Resources\PaymentResource;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentsController extends Controller
{
    public function index(){
        $payments = Payment::get();
        return PaymentResource::collection($payments);
    }

    public function view(Payment $payment){
        return new PaymentResource($payment);
    }

    public function store(PaymentSaveRequest $request){
        $params = $request->validated();
        $payment = Payment::create($params);
        return new PaymentResource($payment);
    }

    public function update(Payment $payment, PaymentUpdateRequest $request){
        $payment->fill($request->validated());
        $payment->save();
        return new PaymentResource($payment);
    }

    public function delete(Payment $payment){
        $payment->delete();
        return new PaymentResource($payment);
    }
}
