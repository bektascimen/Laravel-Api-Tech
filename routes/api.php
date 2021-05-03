<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResources([
    'users' => \App\Http\Controllers\Api\UserController::class,
    'devices' => \App\Http\Controllers\Api\DeviceController::class,
    'purchase' => \App\Http\Controllers\Api\PurchaseController::class,
    'subscription' => \App\Http\Controllers\Api\SubscriptionController::class
]);

Route::apiResource('report', \App\Http\Controllers\Api\ReportController::class);
