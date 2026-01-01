<?php

namespace App\Services\Pricing\Rules;

use App\Services\Pricing\PricingContext;

interface PricingRuleInterface
{
    public function applies(PricingContext $context): bool;

    public function apply(PricingContext $context): void;
}
