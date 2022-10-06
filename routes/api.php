<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Clients\ReservationController;
use App\Http\Controllers\Api\Clients\ClientController;
use App\Http\Controllers\Api\Users\AgenciesController;
use App\Http\Controllers\Api\Users\CurrencyController;
use App\Http\Controllers\Api\Users\PaymentsController;
use App\Http\Controllers\Api\Users\ProductsController;
use App\Http\Controllers\Api\Users\RolesUserController;
use App\Http\Controllers\Api\Users\UsersController;

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

Route::prefix("clients")->name("api.clients.")->group(function(){
    Route::post("login",[LoginController::class,"loginClient"])->name("login");
    Route::post("register",[RegisterController::class,"registerClient"])->name("register");
    Route::middleware("auth:sanctum")->group(function(){
        Route::put("",[ClientController::class,"update"])->name('update');
        Route::get("",[ClientController::class,"getUser"]);
        Route::prefix("reservations")->name("reservations.")->group(function(){
            Route::get("availabilities",[ReservationController::class,"availabilities"])->name("availabilities");
            Route::get("",[ReservationController::class,"index"])->name("index");
            Route::post("",[ReservationController::class,"store"])->name("store");
            Route::get("{reservation}",[ReservationController::class,"view"])->name("view");
            Route::put("{reservation}",[ReservationController::class,"update"])->name("update");
        });
    });
});
Route::prefix("users")->name("api.users.")->group(function(){
    Route::post("login",[LoginController::class,"loginUser"])->name("login");
    Route::post("register",[RegisterController::class,"registerUser"])->name("register");
    Route::middleware("auth:sanctum")->group(function(){
        Route::prefix('products')->name('products.')->group(function(){
            Route::get('',[ProductsController::class,'index'])->name('index');
            Route::get('{product}',[ProductsController::class,'view'])->name('view');
            Route::post('',[ProductsController::class,'store'])->name('store');
            Route::put('{product}',[ProductsController::class,'update'])->name('update');
            Route::delete('{product}',[ProductsController::class,'delete'])->name('delete');
        });
        Route::prefix('roles')->name('roles.')->group(function(){
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