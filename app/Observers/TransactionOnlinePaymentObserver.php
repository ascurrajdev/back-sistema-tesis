<?php

namespace App\Observers;

use App\Models\TransactionOnlinePayment;
use App\Models\Collection;
use App\Models\CollectionPaymentDetail;
use App\Models\Payment;
class TransactionOnlinePaymentObserver
{
    public function creating(TransactionOnlinePayment $transactionOnlinePayment){
        $dataPayment = $transactionOnlinePayment->data;
        $collection = Collection::firstWhere('hook_alias_payment',$dataPayment['payment']['hook_alias']);
        if($collection){
            $transactionOnlinePayment->collection_id = $collection->id;
        }
    }
    /**
     * Handle the TransactionOnlinePayment "created" event.
     *
     * @param  \App\Models\TransactionOnlinePayment  $transactionOnlinePayment
     * @return void
     */
    public function created(TransactionOnlinePayment $transactionOnlinePayment)
    {
        if($transactionOnlinePayment->data['payment']['status'] == 'confirmed'){
            $dataPayment = $transactionOnlinePayment->data;
            $collection = $transactionOnlinePayment->collection;
            CollectionPaymentDetail::create([
                'collection_id' => $transactionOnlinePayment->collection_id,
                'amount' => $dataPayment['payment']['amount'],
                'transaction_online_payment_id' => $transactionOnlinePayment->id,
                'currency_id' => $collection->currency_id,
            ]);
            $collection->update([
                'is_paid' => true,
                'total_amount_paid' => $collection->total_amount_paid + $transactionOnlinePayment->data['payment']['amount'],
            ]);
        }
    }

    /**
     * Handle the TransactionOnlinePayment "updated" event.
     *
     * @param  \App\Models\TransactionOnlinePayment  $transactionOnlinePayment
     * @return void
     */
    public function updated(TransactionOnlinePayment $transactionOnlinePayment)
    {
        if($transactionOnlinePayment->is_reverse && $transactionOnlinePayment->data['payment']['status'] == 'confirmed'){
            $collectionPayment = CollectionPaymentDetail::firstWhere('transaction_online_payment_id',$transactionOnlinePayment->id);
            $collectionPayment->delete();
        }
    }

    /**
     * Handle the TransactionOnlinePayment "deleted" event.
     *
     * @param  \App\Models\TransactionOnlinePayment  $transactionOnlinePayment
     * @return void
     */
    public function deleted(TransactionOnlinePayment $transactionOnlinePayment)
    {
        //
    }

    /**
     * Handle the TransactionOnlinePayment "restored" event.
     *
     * @param  \App\Models\TransactionOnlinePayment  $transactionOnlinePayment
     * @return void
     */
    public function restored(TransactionOnlinePayment $transactionOnlinePayment)
    {
        //
    }

    /**
     * Handle the TransactionOnlinePayment "force deleted" event.
     *
     * @param  \App\Models\TransactionOnlinePayment  $transactionOnlinePayment
     * @return void
     */
    public function forceDeleted(TransactionOnlinePayment $transactionOnlinePayment)
    {
        //
    }
}
