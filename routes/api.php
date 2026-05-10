<?php

use App\Http\Controllers\API\PayStackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('payment/callback',[PayStackController::class,'callback'])->name('payment.callback');