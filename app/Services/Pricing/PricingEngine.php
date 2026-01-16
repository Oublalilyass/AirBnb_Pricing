<?php

namespace App\Services\Pricing;

use App\Models\Listing;
use App\Models\PricingRule;
use Carbon\Carbon;

class PricingEngine
{
    public function calculate(Listing $listing, Carbon $date): float
    {
        $price = (float) $listing->base_price;

        foreach ($listing->pricingRules as $rule) {

            // Weekend rule
            if ($rule->rule_type === 'weekend' && $date->isWeekend()) {
                $price = $this->applyRule($price, $rule);
            }

            // Date-based rules (season, event, demand)
            if (
                in_array($rule->rule_type, ['season', 'event', 'demand'])
                && $rule->start_date
                && $rule->end_date
                && $date->between(
                    Carbon::parse($rule->start_date),
                    Carbon::parse($rule->end_date)
                )
            ) {
                $price = $this->applyRule($price, $rule);
            }
        }

        return round($price, 2);
    }

    protected function applyRule(float $price, PricingRule $rule): float
    {
        if ($rule->value_type === 'percentage') {
            return $price + ($price * $rule->value / 100);
        }

        return $price + $rule->value;
    }
}
