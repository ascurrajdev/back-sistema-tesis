<?php

namespace App\Http\Controllers\Api\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionOnlinePaymentSave;
use App\Models\TransactionOnlinePayment;

class TransactionOnlinePaymentsController extends Controller
{
    public function callback(TransactionOnlinePaymentSave $request){
        $params = $request->validated();
        TransactionOnlinePayment::create([
            'data' => json_encode($params),
        ]);
        if($params['payment']['status'] == "confirmed"){
            $response = response()->json([
                'status' => 'success',
                'messages' => [
                    [
                        'level' => 'success',
                        'key' => 'Confirmed',
                        'description' => 'Pago recibido con exito',
                    ]
                ]
            ]);
        }else{
            $response = response()->json([
                'status' => 'error',
                'messages' => [
                    [
                        'level' => 'error',
                        'key' => 'ConfirmedError',
                        'description' => 'No se pudo procesar la confirmacion'
                    ]
                ]
            ]);
        }
        return $response;
    }
}
