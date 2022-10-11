<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class TransactionOnlinePayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function collection(){
        return $this->belongsTo(Collection::class,'collection_id');
    }

    protected $casts = [
        'data' => 'array'
    ];
}
