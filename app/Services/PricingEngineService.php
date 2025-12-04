<?php

namespace App\Services;

use App\Models\Listing;
use App\Models\CalendarPrice;
use App\Models\Event;
use Carbon\Carbon;

class PricingEngineService
{
    public function calculateOptimalPrice(Listing $listing)
    {
        $competitors = $listing->competitors;
        $market = MarketStat::where('city', $listing->city)
            ->where('month', now()->month)
            ->first();

        $basePrice = $listing->base_price;

        $competitorAvg = $competitors->avg('price');
        $occupancyFactor = $market->avg_occupancy / 100;

        $optimal = ($competitorAvg * 0.6) +
                   ($basePrice * 0.2) +
                   ($market->avg_price * 0.2);

        if ($occupancyFactor > 0.8) {
            $optimal *= 1.15;
        }

        return round($optimal, 2);
    }
}
