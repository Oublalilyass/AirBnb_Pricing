<?php

namespace App\Services\Pricing;

use App\Models\Listing;
use Carbon\Carbon;
use App\Services\Pricing\Rules\{
    WeekendRule,
    SeasonalRule
};

class PricingEngine
{
    protected array $rules;

    public function __construct()
    {
        $this->rules = [
            new WeekendRule(),
            new SeasonalRule(),
            // EventRule(),
            // DemandRule(),
        ];
    }

    public function calculate(Listing $listing, Carbon $date): float
    {
        $context = new PricingContext(
            listing: $listing,
            date: $date,
            basePrice: $listing->base_price,
            currentPrice: $listing->base_price
        );

        foreach ($this->rules as $rule) {
            if ($rule->applies($context)) {
                $rule->apply($context);
            }
        }

        return round($context->currentPrice, 2);
    }
}
