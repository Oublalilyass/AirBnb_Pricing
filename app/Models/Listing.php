<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'location',
        'base_price',
        'min_price',
        'max_price',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pricingRules()
    {
        return $this->hasMany(PricingRule::class);
    }

    public function calendarPrices()
    {
        return $this->hasMany(CalendarPrice::class);
    }
    public function competitors()
    {
        return $this->hasMany(Competitor::class);
    }

    public function recommendedPrices()
    {
        return $this->hasMany(RecommendedPrice::class);
    }

      public function getPricingRulesForPeriod(Carbon $start, Carbon $end)
    {
        return $this->pricingRules()
            ->where(function ($q) use ($start, $end) {
                $q->whereNull('start_date')
                  ->orWhere('start_date', '<=', $end);
            })
            ->where(function ($q) use ($start, $end) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', $start);
            })
            ->get();
    }
}
