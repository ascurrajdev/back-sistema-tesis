<?php

namespace App\Observers;

use App\Models\ReservationDetail;
use App\Models\ReservationLimit;

class ReservationDetailObserver
{
    public $afterCommit = true;
    /**
     * Handle the ReservationDetail "created" event.
     *
     * @param  \App\Models\ReservationDetail  $reservationDetail
     * @return void
     */
    public function created(ReservationDetail $reservationDetail)
    {
        $reservationDetail->load(['reservation','product']);
        if(!empty($reservationDetail->product->is_lodging)){
            $reservation = $reservationDetail->reservation;
            $intervalArray = getIntervalArray($reservation->date_from, $reservation->date_to);
            $reservationLimits = ReservationLimit::whereIn('date',$intervalArray)->get();
            $reservationLimitsArray = array();
            foreach($intervalArray as $date){
                $reservationLimit = array();
                $reservationSelected = $reservationLimits->where('date',$date)->where('product_id',$reservationDetail->product_id)->first();
                if(empty($reservationSelected)){
                    $reservationLimit['capacity_min'] = $reservationDetail->product->capacity_for_day_min;
                    $reservationLimit['capacity_max'] = $reservationDetail->product->capacity_for_day_max;
                    $reservationLimit['available'] = $reservationDetail->product->capacity_for_day_max - $reservationDetail->quantity;
                }else{
                    $reservationLimit['available'] -= $reservationDetail->quantity;
                    $reservationLimit['id'] = $reservationDetail->id;
                }
                $reservationLimit['date'] = $date;
                $reservationLimit['product_id'] = $reservationDetail->product_id;
                $reservationLimitsArray[] = $reservationLimit;
            }
            ReservationLimit::upsert($reservationLimitsArray,["id"],['available']);
        }
    }

    /**
     * Handle the ReservationDetail "updated" event.
     *
     * @param  \App\Models\ReservationDetail  $reservationDetail
     * @return void
     */
    public function updated(ReservationDetail $reservationDetail)
    {
        //
    }

    /**
     * Handle the ReservationDetail "deleted" event.
     *
     * @param  \App\Models\ReservationDetail  $reservationDetail
     * @return void
     */
    public function deleted(ReservationDetail $reservationDetail)
    {
        //
    }

    /**
     * Handle the ReservationDetail "restored" event.
     *
     * @param  \App\Models\ReservationDetail  $reservationDetail
     * @return void
     */
    public function restored(ReservationDetail $reservationDetail)
    {
        //
    }

    /**
     * Handle the ReservationDetail "force deleted" event.
     *
     * @param  \App\Models\ReservationDetail  $reservationDetail
     * @return void
     */
    public function forceDeleted(ReservationDetail $reservationDetail)
    {
        //
    }
}
