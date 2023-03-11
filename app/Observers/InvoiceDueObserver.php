<?php

namespace App\Observers;
use App\Models\InvoiceDue;
class InvoiceDueObserver
{
    public function saved(InvoiceDue $invoiceDue){
        if($invoiceDue->paid){
            $invoiceDue->invoice->total_paid += $invoiceDue->amount;
            if($invoiceDue->invoice->total_paid == $invoiceDue->invoice->total_amount){
                $invoiceDue->invoice->paid_cancelled = true;
            }
            $invoiceDue->invoice->save();
        }
    }
}
