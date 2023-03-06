<?php

namespace App\Providers;

use App\Models\ReservationDetail;
use App\Models\Product;
use App\Models\Collection;
use App\Models\InvoiceDue;
use App\Observers\InvoiceDueObserver;
use App\Models\TransactionOnlinePayment;
use App\Observers\CollectionObserver;
use App\Observers\ReservationDetailObserver;
use App\Observers\ProductObserver;
use App\Observers\TransactionOnlinePaymentObserver;
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
        TransactionOnlinePayment::observe(TransactionOnlinePaymentObserver::class);
        Collection::observe(CollectionObserver::class);
        InvoiceDue::observe(InvoiceDueObserver::class);
    }
}
