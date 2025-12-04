<?php

namespace App\Services;

use App\Models\Listing;
use App\Models\Competitor;
use App\Models\CalendarPrice;
use App\Models\Event;
use Carbon\Carbon;

class CompetitorAnalysisService
{
    public function fetchNearbyCompetitors(Listing $listing)
    {
        $coords = $this->geocode($listing->address);

        // Use external APIs (ScrapingBee / RapidAPI / AirDNA)
        $competitors = ExternalPricingAPI::search($coords);

        foreach ($competitors as $item) {
            Competitor::updateOrCreate([
                'listing_id' => $listing->id,
                'name' => $item['name'],
            ], [
                'address' => $item['address'],
                'price' => $item['price'],
                'rating' => $item['rating'],
                'distance_km' => $item['distance_km'],
            ]);
        }
    }
}
