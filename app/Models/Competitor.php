<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competitor extends Model
{
    protected $fillable = ['listing_id', 'name', 'address', 'price', 'rating', 'distance_km'];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
