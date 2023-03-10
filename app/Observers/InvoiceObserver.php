<?php

namespace App\Observers;

use App\Models\Invoice;

class InvoiceObserver
{
    /**
     * Handle the Invoice "saved" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function saved(Invoice $invoice)
    {
        $invoice->load('reservation');
        if($invoice->has('reservation')){
            $invoice->reservation->total_amount = $invoice->total_amount - $invoice->total_paid;
            $invoice->reservation->save();
        }
    }

    /**
     * Handle the Invoice "deleted" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function deleted(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the Invoice "restored" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function restored(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the Invoice "force deleted" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function forceDeleted(Invoice $invoice)
    {
        //
    }
}
