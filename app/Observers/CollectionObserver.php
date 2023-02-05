<?php

namespace App\Observers;

use App\Models\Collection;
use App\Models\Reservation;
use App\Notifications\SendConfirmationReserved;

class CollectionObserver
{

    public function saved(Collection $collection){
        if($collection->is_paid && $collection->total_amount && $collection->total_amount_paid){
            $collection->load(['details.invoiceDue','client']);
            $sendConfirmationReserved = false;
            foreach($collection->details as $detail){
                if($detail->invoiceDue->is_initial_reservation_payment){
                    $sendConfirmationReserved = true;
                    $reservation = Reservation::find($detail->invoiceDue->reservation_id);
                    $reservation->update([
                        'active' => true,
                        'status' => 'reserved'
                    ]);
                }
            } 
            if($sendConfirmationReserved){
                $client = $collection->client;
                $client->notify(new SendConfirmationReserved());
            }          
        }
    }

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
