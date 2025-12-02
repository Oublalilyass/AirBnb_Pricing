<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ListingController;
use App\Http\Controllers\Api\PricingRuleController;
use App\Http\Controllers\Api\CalendarPriceController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::middleware('auth:sanctum')->group(function () {


    // Pricing
    Route::post('/pricing/calculate', [PricingRuleController::class, 'calculate']);
