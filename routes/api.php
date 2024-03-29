<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Clients\ReservationController;
use App\Http\Controllers\Api\Clients\ClientController;
use App\Http\Controllers\Api\Clients\InvoiceDueController;
use App\Http\Controllers\Api\Clients\TransactionOnlinePaymentsController;
use App\Http\Controllers\Api\Users\AgenciesController;
use App\Http\Controllers\Api\Users\CollectionsController;
use App\Http\Controllers\Api\Users\CurrencyController;
use App\Http\Controllers\Api\Users\InvoicesController;
use App\Http\Controllers\Api\Users\PaymentsController;
use App\Http\Controllers\Api\Users\ProductsController;
use App\Http\Controllers\Api\Users\ReservationsController;
use App\Http\Controllers\Api\Users\RolesUserController;
use App\Http\Controllers\Api\Users\UsersController;
use App\Http\Controllers\CurrencyCodesController;
use App\Http\Controllers\Api\Users\StatisticsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix("clients")->name("clients.")->group(function(){
    Route::post("login",[LoginController::class,"loginClient"])->name("login");
    Route::post("register",[RegisterController::class,"registerClient"])->name("register");
    Route::middleware("auth:sanctum")->group(function(){
        Route::put("",[ClientController::class,"update"])->name('update');
        Route::get("",[ClientController::class,"getUser"]);
        Route::get("statistics",[ClientController::class,"statistics"])->name("statistics");
        Route::prefix("reservations")->name("reservations.")->group(function(){
            Route::get("products",[ReservationController::class,'products'])->name('products');
            Route::get("availabilities",[ReservationController::class,"availabilities"])->name("availabilities");
            Route::get("",[ReservationController::class,"index"])->name("index");
            Route::post("",[ReservationController::class,"store"])->name("store");
            Route::get('config',[ReservationController::class,'config'])->name('config');
            Route::get("{reservation}",[ReservationController::class,"view"])->name("view");
            Route::get("{reservation}/billing",[ReservationController::class,"billing"])->name("billing");
            Route::put("{reservation}",[ReservationController::class,"update"])->name("update");
            Route::post("{reservation}/make-payment",[ReservationController::class,"makePayment"])->name("makePayment");
        });
        Route::prefix('invoice_due')->name('invoice_due.')->group(function(){
            Route::get('payment/{invoiceDue}',[InvoiceDueController::class,'payment'])->name('payment');
        });
    });
});
Route::prefix("users")->name("users.")->group(function(){
    Route::post("login",[LoginController::class,"loginUser"])->name("login");
    Route::post("register",[RegisterController::class,"registerUser"])->name("register");
    Route::middleware("auth:sanctum")->group(function(){
        Route::prefix('statistics')->name('statistics.')->group(function(){
            Route::get('summary', [StatisticsController::class, 'index_summary'])->name('index_summary');
        });
        Route::prefix('invoices')->name('invoices.')->group(function(){
            Route::get('',[InvoicesController::class,'index'])->name('index');
        });
        Route::prefix('collections')->name('collections.')->group(function(){
            Route::get('',[CollectionsController::class,'index'])->name('index');
        });
        Route::prefix('reservations')->name('reservations.')->group(function(){
            Route::get('',[ReservationsController::class,'index'])->name('index');
        });
        Route::prefix('products')->name('products.')->group(function(){
            Route::get('',[ProductsController::class,'index'])->name('index');
            Route::get('{product}',[ProductsController::class,'view'])->name('view');
            Route::post('',[ProductsController::class,'store'])->name('store');
            Route::put('{product}',[ProductsController::class,'update'])->name('update');
            Route::delete('{product}',[ProductsController::class,'delete'])->name('delete');
        });
        Route::prefix('roles')->name('roles.')->group(function(){
            Route::get('abilities',[RolesUserController::class,'abilities'])->name('abilities');
            Route::get('',[RolesUserController::class,'index'])->name('index');
            Route::get('{role}',[RolesUserController::class,'view'])->name('view');
            Route::post('',[RolesUserController::class,'store'])->name('store');
            Route::put('{role}',[RolesUserController::class,'update'])->name('update');
            Route::delete('{role}',[RolesUserController::class,'delete'])->name('delete');
        });
        Route::prefix('agencies')->name('agencies.')->group(function(){
            Route::get('',[AgenciesController::class,'index'])->name('index');
            Route::get('{agency}',[AgenciesController::class,'view'])->name('view');
            Route::post('',[AgenciesController::class,'store'])->name('store');
            Route::put('{agency}',[AgenciesController::class,'update'])->name('update');
            Route::delete('{agency}',[AgenciesController::class,'delete'])->name('delete');
        });
        Route::prefix('payments')->name('payments.')->group(function(){
            Route::post('',[PaymentsController::class,'store'])->name('store');
            Route::get('{payment}',[PaymentsController::class,'view'])->name('view');
            Route::get('',[PaymentsController::class,'index'])->name('index');
            Route::put('{payment}',[PaymentsController::class,'update'])->name('update');
            Route::delete('{payment}',[PaymentsController::class,'delete'])->name('delete');
        });
        Route::prefix('currencies')->name('currencies.')->group(function(){
            Route::get('',[CurrencyController::class,'index'])->name('index');
            Route::get('{currency}',[CurrencyController::class,'view'])->name('view');
            Route::post('',[CurrencyController::class,'store'])->name('store');
            Route::put('{currency}',[CurrencyController::class,'update'])->name('update');
            Route::delete('{currency}',[CurrencyController::class,'delete'])->name('delete');
        });
        Route::get('',[UsersController::class,'index'])->name('index');
        Route::get('{user}',[UsersController::class,'view'])->name('view');
        Route::post('',[UsersController::class,'store'])->name('store');
        Route::put('{user}',[UsersController::class,'update'])->name('update');
        Route::delete('{user}',[UsersController::class,'delete'])->name('delete');
    });
});

Route::post('online-payments/callback',[TransactionOnlinePaymentsController::class,'callback'])->name('online-payments.callback');
Route::post('online-payments/dlocal/notification',[TransactionOnlinePaymentsController::class,'dlocalNotification'])->name('online-payments.dlocal.notifcation');
Route::get('currency-codes',[CurrencyCodesController::class,'index'])->name('currency-codes.index');