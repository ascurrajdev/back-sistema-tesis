<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function invoiceDue(){
        return $this->belongsTo(InvoiceDue::class);
    }
}
