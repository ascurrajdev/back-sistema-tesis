<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
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
        Route::get("user",);
    });
});
Route::prefix("users")->name("api.users.")->group(function(){
    Route::post("login",[LoginController::class,"loginUser"])->name("login");
    Route::post("register",[RegisterController::class,"registerUser"])->name("register");
    Route::middleware("auth:sanctum")->group(function(){

    });
});
