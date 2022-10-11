<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends Model
{
    use HasFactory, SoftDeletes;

    public function invoices(){
        return $this->belongsToMany(Invoice::class,'invoice_collection_details');
    }

    public function details(){
        return $this->hasMany(CollectionDetail::class);
    }
}
