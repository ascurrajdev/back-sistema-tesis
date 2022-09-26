<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductObserver
{
    public function creating(Product $product)
    {
        $product->amount_untaxed = $product->amount;
        $tax = DB::table('taxes')->find($product->tax_id);
        if($tax){
            $product->tax_rate = $tax->rate;
            $product->amount_untaxed = $product->amount - ($product->amount * (100 + $tax->rate / 100));
        }
    }

    public function updating(Product $product)
    {
        $product->amount_untaxed = $product->amount;
        $tax = DB::table('taxes')->find($product->tax_id);
        if($tax){
            $product->tax_rate = $tax->rate;
            $product->amount_untaxed = $product->amount - ($product->amount * (100 + $tax->rate / 100));
        }
    }

    /**
     * Handle the Product "deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }
}
