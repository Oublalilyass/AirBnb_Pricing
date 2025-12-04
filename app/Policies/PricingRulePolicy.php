<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PricingRule;

class PricingRulePolicy
{
    /**
     * Determine if the user can view a pricing rule.
     */
    public function view(User $user, PricingRule $pricingRule): bool
    {
        return $pricingRule->listing->user_id === $user->id;
    }

    /**
     * Determine if the user can create pricing rules.
     */
    public function create(User $user): bool
    {
        return true; // any authenticated user can create
    }

    /**
     * Determine if the user can update a pricing rule.
     */
    public function update(User $user, PricingRule $pricingRule): bool
    {
        return $pricingRule->listing->user_id === $user->id;
    }

    /**
     * Determine if the user can delete a pricing rule.
     */
    public function delete(User $user, PricingRule $pricingRule): bool
    {
        return $pricingRule->listing->user_id === $user->id;
    }
}
