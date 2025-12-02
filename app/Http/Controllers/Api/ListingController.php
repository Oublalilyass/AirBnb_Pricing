<?php

// app/Http/Controllers/Api/ListingController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;



class ListingController extends Controller
{
    use HasApiTokens;   // important

    // public function __construct()
    // {
    //     $this->middleware('auth:sanctum'); // correct
    // }
    public function index()
    {
        $user = auth()->user(); 
        $listings = Listing::with('pricingRules', 'calendarPrices')->get();
        return response()->json($listings);
    }


    public function show(Listing $listing)
    {
        // $this->authorize('view', $listing);
        return response()->json($listing->load('pricingRules'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'base_price' => 'required|integer',
            'min_price' => 'nullable|integer',
            'max_price' => 'nullable|integer',
        ]);

        $listing = auth()->user()->listings()->create($data);
        return response()->json($listing, 201);
    }

    public function update(Request $request, Listing $listing)
    {
        $this->authorize('update', $listing);
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'location' => 'nullable|string|max:255',
            'base_price' => 'sometimes|integer',
            'min_price' => 'nullable|integer',
            'max_price' => 'nullable|integer',
        ]);

        $listing->update($data);
        return response()->json($listing);
    }

    public function destroy(Listing $listing)
    {
        $this->authorize('delete', $listing);
        $listing->delete();
        return response()->json(['message' => 'Listing deleted']);
    }
}
