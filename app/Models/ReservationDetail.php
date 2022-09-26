<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationDetail extends Model
{
    use HasFactory, HasEvents;

    protected $guarded = [];

    public function reservation(){
        return $this->belongsTo(Reservation::class);
    }

    public function productPricingProfile(){
        return $this->belongsTo(ProductPricingProfile::class);
    }

    public function product(){
        return $this->belongsTo(Product::class)->withTrashed();
    }
}
