<?php

namespace App\Providers;

use App\Models\ReservationDetail;
use App\Models\Product;
use App\Observers\ReservationDetailObserver;
use App\Observers\ProductObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class ModelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        ReservationDetail::observe(ReservationDetailObserver::class);
        Product::observe(ProductObserver::class);
    }
}
