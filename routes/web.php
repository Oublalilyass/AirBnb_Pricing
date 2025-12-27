<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\Api\ListingController;
use App\Http\Controllers\Api\CalendarPriceController;
use App\Http\Controllers\Api\PricingRuleController;
// use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DashboardController;

// Route::get('/dashboard', [DashboardController::class, 'index']);
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashborad 
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // ---- LISTINGS ----
    Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');
    Route::get('/listings/create', [ListingController::class, 'create'])->name('listings.create');
    Route::post('/listings', [ListingController::class, 'store']);
    Route::get('/listings/{listing}', [ListingController::class, 'show']);
    Route::put('/listings/{listing}', [ListingController::class, 'update']);
    Route::delete('/listings/{listing}', [ListingController::class, 'destroy']);

    // ---- CALENDAR PRICES ----
    Route::get('/calendar-prices', [CalendarPriceController::class, 'index']);
    Route::get('/calendar-prices/{calendarPrice}', [CalendarPriceController::class, 'show']);
    Route::post('/calendar-prices', [CalendarPriceController::class, 'store']);
    Route::put('/calendar-prices/{calendarPrice}', [CalendarPriceController::class, 'update']);
    Route::delete('/calendar-prices/{calendarPrice}', [CalendarPriceController::class, 'destroy']);

    // ---- PRICING RULES ----
    Route::get('/pricing-rules', [PricingRuleController::class, 'index']);
    Route::post('/pricing-rules', [PricingRuleController::class, 'store']);
    Route::get('/pricing-rules/{pricingRule}', [PricingRuleController::class, 'show']);
    Route::put('/pricing-rules/{pricingRule}', [PricingRuleController::class, 'update']);
    Route::delete('/pricing-rules/{pricingRule}', [PricingRuleController::class, 'destroy']);

    Route::get('/listings/{listing}/analytics', [ListingController::class, 'analytics']);
});

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');



// Route::get('dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/settings.php';
