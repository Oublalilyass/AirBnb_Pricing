<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'listing_id',
        'date',
        'calculated_price',
    ];

    // Relationships
    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
