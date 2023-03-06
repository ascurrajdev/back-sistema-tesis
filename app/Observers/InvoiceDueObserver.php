<?php

namespace App\Observers;
use App\Models\InvoiceDue;
class InvoiceDueObserver
{
    public function updated(InvoiceDue $invoiceDue){
        if($invoiceDue->paid){
            $invoiceDue->invoice->total_paid += $invoiceDue->amount;
            $invoiceDue->invoice->save();
        }
    }
}
