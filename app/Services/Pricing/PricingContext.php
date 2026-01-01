<?php

namespace App\Services\Pricing;

use App\Models\Listing;
use Carbon\Carbon;

class PricingContext
{
    public function __construct(
        public Listing $listing,
        public Carbon $date,
        public float $basePrice,
        public float $currentPrice
    ) {}
}
