<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Clients\ReservationController;
use App\Http\Controllers\Api\Clients\ClientController;
use App\Models\ReservationConfig;

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
            Route::get("unavailable",[ReservationController::class])->name("unavailable");
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

    });
});
Route::any("/",function(){
    Log::info(request()->all());
    return request()->all();
});