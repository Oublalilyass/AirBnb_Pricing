<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PricingRule;
use App\Models\Listing;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PricingRuleController extends Controller
{
    /**
     * List pricing rules for current user
     */
    public function index()
    {
        $rules = PricingRule::with('listing')
            ->whereHas('listing', fn($q) => $q->where('user_id', auth()->id()))
            ->orderBy('id', 'desc')
            ->get();

        $listings = Listing::where('user_id', auth()->id())
            ->select('id', 'name', 'location')
            ->orderBy('name')
            ->get();

        return Inertia::render('PricingRules/Index', [
            'pricingRules' => $rules,
            'listings' => $listings
        ]);
    }


    /**
     * Show single pricing rule
     */
    public function show($id)
    {
        // Validate that ID is numeric to prevent 'create' string issue
        if (!is_numeric($id)) {
            abort(404);
        }

        $rule = PricingRule::with('listing')
            ->where('id', $id)
            ->whereHas('listing', fn($q) => $q->where('user_id', auth()->id()))
            ->firstOrFail();

        return response()->json($rule);
    }

    /**
     * Create new pricing rule
     */
    public function store(Request $request)
    {
        $request->validate([
            'listing_id'   => 'required|exists:listings,id',
            'rule_type'    => 'required|in:season,weekend,event,demand',
            'name'         => 'required|string|max:255',
            'value'        => 'required|numeric',
            'value_type'   => 'required|in:percentage,fixed',
            'start_date'   => 'nullable|date',
            'end_date'     => 'nullable|date|after_or_equal:start_date',
        ]);

        // Ensure listing belongs to current user
        Listing::where('id', $request->listing_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $rule = PricingRule::create([
            'listing_id'  => $request->listing_id,
            'rule_type'   => $request->rule_type,
            'name'        => $request->name,
            'value'       => $request->value,
            'value_type'  => $request->value_type,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
        ]);

        // For Inertia requests, redirect back with success message
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Pricing rule created successfully',
                'data'    => $rule->load('listing'),
            ], 201);
        }

        return redirect()->back()->with('success', 'Pricing rule created successfully');
    }

    /**
     * Update an existing pricing rule
     */
    public function update(Request $request, $id)
    {
        // Validate that ID is numeric to prevent 'create' string issue
        if (!is_numeric($id)) {
            abort(404);
        }

        $rule = PricingRule::where('id', $id)
            ->whereHas('listing', fn($q) => $q->where('user_id', auth()->id()))
            ->firstOrFail();

        $request->validate([
            'rule_type'   => 'sometimes|in:season,weekend,event,demand',
            'name'        => 'sometimes|string|max:255',
            'value'       => 'sometimes|numeric',
            'value_type'  => 'sometimes|in:percentage,fixed',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
        ]);

        // Prevent updating listing_id to one that doesn't belong to user
        if ($request->has('listing_id')) {
            Listing::where('id', $request->listing_id)
                ->where('user_id', auth()->id())
                ->firstOrFail();
        }

        $rule->update($request->only([
            'listing_id',
            'rule_type',
            'name',
            'value',
            'value_type',
            'start_date',
            'end_date'
        ]));

        return response()->json([
            'message' => 'Pricing rule updated successfully',
            'data'    => $rule,
        ]);
    }

    /**
     * Delete rule
     */
    public function destroy($id)
    {
        // Validate that ID is numeric to prevent 'create' string issue
        if (!is_numeric($id)) {
            abort(404);
        }

        $rule = PricingRule::where('id', $id)
            ->whereHas('listing', fn($q) => $q->where('user_id', auth()->id()))
            ->firstOrFail();

        $rule->delete();

        return response()->json(['message' => 'Pricing rule deleted']);
    }
}
