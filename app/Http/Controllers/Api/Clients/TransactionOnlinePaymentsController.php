<?php

namespace App\Http\Controllers\Api\Clients;

use App\Contracts\PaymentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\DlocalNotificationRequest;
use App\Http\Requests\TransactionOnlinePaymentSave;
use App\Models\TransactionOnlinePayment;
use App\Models\Collection;
use App\Models\Payment;
use App\Models\CollectionPaymentDetail;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class TransactionOnlinePaymentsController extends Controller
{
    private $paymentService;
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }
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

    public function dlocalNotification(DlocalNotificationRequest $request){
        $dataPayment = $request->validated();
        Log::info($dataPayment);
        $paymentData = $this->paymentService->getPaymentById($dataPayment['payment_id']);
        Log::info($paymentData);
        $collection = Collection::firstWhere(['payment_online_id' => $dataPayment['payment_id']]);
        $transaction = TransactionOnlinePayment::create([
            'data' => $paymentData,
            'is_reverse' => false,
            'collection_id' => $collection->id,
        ]);
        switch($paymentData['status']){
            case "PAID":
                CollectionPaymentDetail::create([
                    'currency_id' => $collection->currency_id,
                    'amount' => $paymentData['amount'],
                    'transaction_online_payment_id' => $transaction->id
                ]);
                $collection->total_amount_paid = $paymentData['amount'];
                if($collection->total_amount_paid == $collection->total_amount){
                    $collection->is_paid = true;
                }
            break;
            case "PENDING":
            break;
            case "REJECTED":
            break;
            case "CANCELLED":
            break;
            case "EXPIRED":
            break;
        }
        $collection->save();
    }
}
