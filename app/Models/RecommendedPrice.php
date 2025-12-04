<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecommendedPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'listing_id',
        'date',
        'recommended_price',
    ];

    protected $casts = [
        'date' => 'date',
        'recommended_price' => 'decimal:2',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
