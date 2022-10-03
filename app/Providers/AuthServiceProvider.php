<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Reservation;
use App\Models\RoleUser;
use App\Models\User;
use App\Policies\PaymentsPolicy;
use App\Policies\ProductPolicy;
use App\Policies\UserPolicy;
use App\Policies\RoleUserPolicy;
use App\Policies\ReservationPolicy;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Reservation::class => ReservationPolicy::class,
        Product::class => ProductPolicy::class,
        RoleUser::class => RoleUserPolicy::class,
        User::class => UserPolicy::class,
        Payment::class => PaymentsPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
