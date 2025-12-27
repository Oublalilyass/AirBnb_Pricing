<?php

// app/Http/Controllers/Api/ListingController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Inertia\Inertia;



class ListingController extends Controller
{
    use HasApiTokens;   // important

    // public function __construct()
    // {
    //     $this->middleware('auth:sanctum'); // correct
    // }
    public function index()
    {
        $listings = Listing::with('pricingRules', 'calendarPrices')
            ->orderBy('created_at', 'desc')
            ->get();
        return Inertia::render('listings/Index', [
            'listings' => $listings,
        ]);
    }
    public function create()
    {
        return Inertia::render('listings/Form');
    }

    public function show(Listing $listing)
    {
        // $this->authorize('view', $listing);
        // return response()->json($listing->load('pricingRules'));
        return Inertia::render('listings/Show', [
            'listing' => $listing->load('pricingRules'),
        ]);
    }

    public function store(Request $request)
    {
        try {
            \Log::info('Store method called', ['user' => auth()->id()]);

            $data = $request->validate([
                'name' => 'required|string|max:255',
                'location' => 'nullable|string|max:255',
                'base_price' => 'required|integer',
                'min_price' => 'nullable|integer',
                'max_price' => 'nullable|integer',
            ]);

            if (!auth()->check()) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }

            $listing = auth()->user()->listings()->create($data);

            return redirect('/listings')
                ->with('success', 'Listing created successfully!');
        } catch (\Exception $e) {
            \Log::error('Error creating listing: ' . $e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()]);
        }
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
    public function analytics(Listing $listing)
    {
        return inertia('Listings/Analytics', [
            'listing' => $listing,
            'competitors' => $listing->competitors,
            'recommendedPrices' => $listing->recommendedPrices,
        ]);
    }


    public function destroy(Listing $listing)
    {
        $this->authorize('delete', $listing);
        $listing->delete();
        return response()->json(['message' => 'Listing deleted']);
    }
}
