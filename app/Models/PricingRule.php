<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'listing_id',
        'rule_type',
        'name',
        'value',
        'value_type',
        'start_date',
        'end_date',
    ];

    // Relationships
    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
