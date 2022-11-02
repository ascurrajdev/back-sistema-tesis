<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationLimit extends Model
{
    use HasFactory;

    public function scopeQuantity($query, $value){
        return $query->where('available','<',$value);
    }

}
