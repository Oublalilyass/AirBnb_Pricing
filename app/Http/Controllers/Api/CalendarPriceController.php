<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CalendarPrice;
use App\Models\Listing;
use Illuminate\Http\Request;

class CalendarPriceController extends Controller
{
    public function __construct()
    {
        // Protect controller with Sanctum
        $this->middleware('auth:sanctum');
    }

    /**
     * List calendar prices (with filters)
     */
    public function index(Request $request)
    {
        $query = CalendarPrice::with('listing')
            ->whereHas('listing', function ($q) {
                $q->where('user_id', auth()->id()); // User sees only their listings
            });

        // Optional filters
        if ($request->listing_id) {
            $query->where('listing_id', $request->listing_id);
        }

        if ($request->start_date) {
            $query->whereDate('date', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        $prices = $query->orderBy('date', 'asc')->paginate(30);

        return response()->json($prices);
    }

    /**
     * Show a single calendar price
     */
    public function show($id)
    {
        $price = CalendarPrice::where('id', $id)
            ->whereHas('listing', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->firstOrFail();

        return response()->json($price);
    }

    /**
     * Create a new calendar price manually
     */
    public function store(Request $request)
    {
        $request->validate([
            'listing_id'      => 'required|exists:listings,id',
            'date'            => 'required|date',
            'calculated_price'=> 'required|numeric|min:1',
        ]);

        // Ensure the listing belongs to authenticated user
        $listing = Listing::where('id', $request->listing_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $price = CalendarPrice::create([
            'listing_id'      => $listing->id,
            'date'            => $request->date,
            'calculated_price'=> $request->calculated_price,
        ]);

        return response()->json([
            'message' => 'Calendar price created successfully',
            'data'    => $price,
        ], 201);
    }

    /**
     * Update an existing calendar price
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'calculated_price' => 'required|numeric|min:1',
        ]);

        $price = CalendarPrice::where('id', $id)
            ->whereHas('listing', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->firstOrFail();

        $price->update([
            'calculated_price' => $request->calculated_price,
        ]);

        return response()->json([
            'message' => 'Calendar price updated successfully',
            'data'    => $price,
        ]);
    }

    /**
     * Delete a calendar price
     */
    public function destroy($id)
    {
        $price = CalendarPrice::where('id', $id)
            ->whereHas('listing', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->firstOrFail();

        $price->delete();

        return response()->json(['message' => 'Calendar price deleted']);
    }
}
