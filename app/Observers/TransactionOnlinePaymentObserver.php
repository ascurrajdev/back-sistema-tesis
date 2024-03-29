<?php

namespace App\Observers;

use App\Models\TransactionOnlinePayment;
use App\Models\Collection;
use App\Models\CollectionPaymentDetail;
class TransactionOnlinePaymentObserver
{
    public function creating(TransactionOnlinePayment $transactionOnlinePayment){
        $dataPayment = $transactionOnlinePayment->data;
        $collection = Collection::firstWhere('hook_alias_payment',$dataPayment['order_id']);
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
        if($transactionOnlinePayment->data['status'] == 'PAID'){
            $dataPayment = $transactionOnlinePayment->data;
            $collection = $transactionOnlinePayment->collection;
            CollectionPaymentDetail::create([
                'collection_id' => $transactionOnlinePayment->collection_id,
                'amount' => $dataPayment['amount'],
                'transaction_online_payment_id' => $transactionOnlinePayment->id,
                'currency_id' => $collection->currency_id,
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
        if($transactionOnlinePayment->is_reverse && $transactionOnlinePayment->data['status'] == 'PAID'){
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
