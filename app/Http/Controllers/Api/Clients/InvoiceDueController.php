<?php

namespace App\Http\Controllers\Api\Clients;

use App\Http\Controllers\Controller;
use App\Models\InvoiceDue;
use App\Models\Collection;
use App\Models\CollectionDetail;
use Illuminate\Http\Request;
use App\Contracts\PaymentService;
use App\Traits\ResponseTrait;

class InvoiceDueController extends Controller
{
    use ResponseTrait;
    private $paymentService;

    public function __construct(PaymentService $paymentService){
        $this->paymentService = $paymentService;
    }

    public function payment(InvoiceDue $invoiceDue, Request $request){
        $invoiceDue->load(['reservation','collection.details']);
        $collection = $invoiceDue->collection->first();
        if(empty($collection)){
            $concept = "";
            if($invoiceDue->is_initial_reservation_payment){
                $concept = "Pago inicial de la reservacion Nro ".$invoiceDue->reservation->id;
            }
            $collection = Collection::create([
                'currency_id' => $invoiceDue->currency_id,
                'total_amount' => $invoiceDue->amount,
                'total_amount_paid' => 0,
                'client_id' => $request->user()->id,
                'agency_id' => $invoiceDue->agency_id,
            ]);
            CollectionDetail::create([
                'collection_id' => $collection->id,
                'invoice_due_id' => $invoiceDue->id,
                'currency_id' => $collection->currency_id,
                'amount' => $invoiceDue->amount,
                'concept' => $concept,
            ]);
            $collection->load('details');
        }
        $description = [];
        foreach($collection->details as $detail){
            $description[] = $detail->concept;
        }
        $paymentLink = $this->paymentService->createLinkPayment($request->user(),$collection->total_amount,implode(',',$description));
        if($paymentLink['status'] == 'error'){
            return $this->error($paymentLink,400);
        }
        $collection->link_payment = $paymentLink['redirect_url'];
        $collection->hook_alias_payment = $paymentLink['merchant_checkout_token'];
        $collection->save();
        return $this->success($collection->link_payment);
    }
}
