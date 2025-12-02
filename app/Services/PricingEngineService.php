<?php

namespace App\Services;

use App\Models\Listing;
use App\Models\CalendarPrice;
use App\Models\Event;
use Carbon\Carbon;

class PricingEngineService
{
    public function calculateListingPrices(Listing $listing, int $days = 30)
    {
        $prices = [];
        $today = Carbon::today();

        for ($i = 0; $i < $days; $i++) {
            $date = $today->copy()->addDays($i);
            $price = $listing->base_price;

            // Apply Pricing Rules
            foreach ($listing->pricingRules as $rule) {
                if ($rule->start_date && $rule->end_date) {
                    if ($date->lt($rule->start_date) || $date->gt($rule->end_date)) continue;
                }

                if ($rule->value_type === 'percentage') {
                    $price += $price * ($rule->value / 100);
                } else {
                    $price += $rule->value;
                }
            }

            // Apply Event Boosts
            $events = Event::where('start_date', '<=', $date)
                           ->where('end_date', '>=', $date)
                           ->get();
            foreach ($events as $event) {
                $price += $price * ($event->price_multiplier / 100);
            }

            // Apply Weekend Boost
            if ($date->isWeekend()) {
                $weekendRule = $listing->pricingRules->where('rule_type', 'weekend')->first();
                if ($weekendRule) {
                    $price += $weekendRule->value_type === 'percentage'
                        ? $price * ($weekendRule->value / 100)
                        : $weekendRule->value;
                }
            }

            // Ensure min/max
            if ($listing->min_price && $price < $listing->min_price) $price = $listing->min_price;
            if ($listing->max_price && $price > $listing->max_price) $price = $listing->max_price;

            // Save to database
            $calendarPrice = CalendarPrice::updateOrCreate(
                [
                    'listing_id' => $listing->id,
                    'date' => $date->format('Y-m-d')
                ],
                [
                    'calculated_price' => round($price)
                ]
            );

            $prices[] = $calendarPrice;
        }

        return $prices;
    }
}
