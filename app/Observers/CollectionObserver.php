<?php

namespace App\Observers;

use App\Models\Collection;

class CollectionObserver
{

    /**
     * Handle the Collection "created" event.
     *
     * @param  \App\Models\Collection  $collection
     * @return void
     */
    public function created(Collection $collection)
    {
        
    }

    /**
     * Handle the Collection "updated" event.
     *
     * @param  \App\Models\Collection  $collection
     * @return void
     */
    public function updated(Collection $collection)
    {
        $invoices = $collection->load(['invoices' => function($query){
            $query->where('paid_cancelled',false);
        }]);
        $totalAmountPaid = $collection->total_amount_paid - $collection->getOriginal('total_amount_paid');
        foreach($invoices as $invoice){
            if($totalAmountPaid > 0){
                $invoice->total_paid += $totalAmountPaid;
                $totalAmountPaid = $invoice->total_paid - $invoice->total_amount;
                if($invoice->total_paid == $invoice->total_amount){
                    $invoice->paid_cancelled = true;
                }
                $invoice->save();
            }
        }
    }

    /**
     * Handle the Collection "deleted" event.
     *
     * @param  \App\Models\Collection  $collection
     * @return void
     */
    public function deleted(Collection $collection)
    {
        //
    }

    /**
     * Handle the Collection "restored" event.
     *
     * @param  \App\Models\Collection  $collection
     * @return void
     */
    public function restored(Collection $collection)
    {
        //
    }

    /**
     * Handle the Collection "force deleted" event.
     *
     * @param  \App\Models\Collection  $collection
     * @return void
     */
    public function forceDeleted(Collection $collection)
    {
        //
    }
}
