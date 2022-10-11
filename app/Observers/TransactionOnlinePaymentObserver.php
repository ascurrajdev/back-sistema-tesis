<?php

namespace App\Observers;

use App\Models\TransactionOnlinePayment;
use App\Models\Collection;
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
            if($collection){
                $collection->total_amount_paid += $dataPayment['payment']['amount'];
                $collection->is_cancelled = $collection->total_amount_paid == $collection->total_amount;
                $collection->save();
            }
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
            $dataPayment = $transactionOnlinePayment->data;
            $collection = $transactionOnlinePayment->collection;
            if($collection){
                $collection->total_amount_paid -= $dataPayment['payment']['amount'];
                $collection->is_cancelled = $collection->total_amount_paid == $collection->total_amount;
                $collection->save();
            }
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
