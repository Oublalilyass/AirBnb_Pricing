<?php

namespace App\Services\Pricing\Rules;

use App\Services\Pricing\PricingContext;

class SeasonalRule implements PricingRuleInterface
{
    public function applies(PricingContext $context): bool
    {
        return $context->listing
            ->getPricingRulesForPeriod($context->date, $context->date)
            ->where('rule_type', 'season')
            ->isNotEmpty();
    }

    public function apply(PricingContext $context): void
    {
        $rules = $context->listing
            ->getPricingRulesForPeriod($context->date, $context->date)
            ->where('rule_type', 'season');

        foreach ($rules as $rule) {
            if ($rule->value_type === 'percentage') {
                $context->currentPrice += $context->currentPrice * ($rule->value / 100);
            } else {
                $context->currentPrice += $rule->value;
            }
        }
    }
}
