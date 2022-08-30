<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function budget(){
        return $this->belongsTo(Budget::class);
    }

    public function productPricingProfile(){
        return $this->belongsTo(ProductPricingProfile::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
