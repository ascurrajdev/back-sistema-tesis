<?php

namespace App\Http\Controllers\Api\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionOnlinePaymentSave;
use App\Models\TransactionOnlinePayment;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class TransactionOnlinePaymentsController extends Controller
{
    public function callback(Request $request){
        Log::info($request->all());
        // $params = $request->validated();
        // TransactionOnlinePayment::create([
        //     'data' => $params,
        // ]);
        // if($params['payment']['status'] == "confirmed"){
        //     $response = response()->json([
        //         'status' => 'success',
        //         'messages' => [
        //             [
        //                 'level' => 'success',
        //                 'key' => 'Confirmed',
        //                 'description' => 'Pago recibido con exito',
        //             ]
        //         ]
        //     ]);
        // }else{
        //     $response = response()->json([
        //         'status' => 'error',
        //         'messages' => [
        //             [
        //                 'level' => 'error',
        //                 'key' => 'ConfirmedError',
        //                 'description' => 'No se pudo procesar la confirmacion'
        //             ]
        //         ]
        //     ]);
        // }
        // return $response;
        return $request->all();
    }
}
