<?php

namespace App\Observers;

use App\Models\CollectionPaymentDetail;

class CollectionPaymentDetailObserver
{
    /**
     * Handle the CollectionPaymentDetail "created" event.
     *
     * @param  \App\Models\CollectionPaymentDetail  $collectionPaymentDetail
     * @return void
     */
    public function created(CollectionPaymentDetail $collectionPaymentDetail)
    {
        //
    }

    /**
     * Handle the CollectionPaymentDetail "updated" event.
     *
     * @param  \App\Models\CollectionPaymentDetail  $collectionPaymentDetail
     * @return void
     */
    public function updated(CollectionPaymentDetail $collectionPaymentDetail)
    {
        //
    }

    /**
     * Handle the CollectionPaymentDetail "deleted" event.
     *
     * @param  \App\Models\CollectionPaymentDetail  $collectionPaymentDetail
     * @return void
     */
    public function deleted(CollectionPaymentDetail $collectionPaymentDetail)
    {
        $collectionPaymentDetail->load('collection.details');
        $details = $collectionPaymentDetail->collection->details;
        $collectionPaymentDetail->collection->total_amount_paid = 0;
        foreach($details as $detail){
            $collectionPaymentDetail->collection->total_amount_paid = $detail->amount;
        }
        $collectionPaymentDetail->collection->save();
    }

    /**
     * Handle the CollectionPaymentDetail "restored" event.
     *
     * @param  \App\Models\CollectionPaymentDetail  $collectionPaymentDetail
     * @return void
     */
    public function restored(CollectionPaymentDetail $collectionPaymentDetail)
    {
        //
    }

    /**
     * Handle the CollectionPaymentDetail "force deleted" event.
     *
     * @param  \App\Models\CollectionPaymentDetail  $collectionPaymentDetail
     * @return void
     */
    public function forceDeleted(CollectionPaymentDetail $collectionPaymentDetail)
    {
        //
    }
}
