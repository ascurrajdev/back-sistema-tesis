<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ReservationDetail;
use App\Observers\ReservationDetailObserver;

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
        // ReservationDetail::observe(ReservationDetailObserver::class);
    }
}
