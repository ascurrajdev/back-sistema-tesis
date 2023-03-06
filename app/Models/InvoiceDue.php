<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDue extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function collection(){
        return $this->belongsToMany(Collection::class,'collection_details','invoice_due_id','collection_id')->orderBy('id');
    }

    public function reservation(){
        return $this->belongsTo(Reservation::class);
    }

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
}
