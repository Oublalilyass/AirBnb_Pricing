<?php

namespace App\Services\Pricing\Rules;

use App\Services\Pricing\PricingContext;

class WeekendRule implements PricingRuleInterface
{
    public function applies(PricingContext $context): bool
    {
        return $context->date->isWeekend();
    }

    public function apply(PricingContext $context): void
    {
        // Example: +20%
        $context->currentPrice *= 1.20;
    }
}
