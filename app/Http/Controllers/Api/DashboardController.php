<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CalendarPrice;
use App\Models\Listing;
use App\Models\PricingRule;
use Illuminate\Http\Request;



class DashboardController extends Controller
{
   public function index()
{
    $userId = auth()->id();

    return inertia('Dashboard', [
        'stats' => [
            'listings_count' => Listing::where('user_id', $userId)->count(),
            'active_rules'   => PricingRule::whereHas('listing', fn($q) => $q->where('user_id', $userId))->count(),
            'calendar_prices' => CalendarPrice::whereHas('listing', fn($q) => $q->where('user_id', $userId))->count(),
        ],
    ]);
}

}
