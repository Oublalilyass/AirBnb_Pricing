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
            ->orderBy('name')
            ->get(['id', 'name', 'location']);

        return Inertia::render('PricingRules/Index', [
            'pricingRules' => $rules,
            'listings' => $listings,
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
            'listing_id'   => 'nullable|exists:listings,id',
            'rule_type'    => 'required|string',
            'name'         => 'nullable|string|max:255',
            'start_date'   => 'nullable|date',
            'end_date'     => 'nullable|date|after_or_equal:start_date',
            'value'        => 'required|numeric',
            'value_type'   => 'required|in:percentage,fixed',
        ]);

        // Ensure listing belongs to current user (if specific listing)
        if ($request->listing_id) {
            Listing::where('id', $request->listing_id)
                ->where('user_id', auth()->id())
                ->firstOrFail();
        }

        $rule = PricingRule::create([
            'listing_id'  => $request->listing_id,
            'rule_type'   => $request->rule_type,
            'name'        => $request->name,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'value'       => $request->value,
            'value_type'  => $request->value_type,
        ]);

        return response()->json([
            'message' => 'Pricing rule created successfully',
            'data'    => $rule,
        ], 201);
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
            'rule_type'   => 'sometimes|string',
            'name'        => 'nullable|string|max:255',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'value'       => 'sometimes|numeric',
            'value_type'  => 'sometimes|in:percentage,fixed',
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
            'start_date',
            'end_date',
            'value',
            'value_type'
        ]));

        // Return JSON for API calls, or redirect for Inertia
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Pricing rule updated successfully',
                'data'    => $rule->fresh(['listing']),
            ]);
        }

        return back()->with('success', 'Pricing rule updated successfully');
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
