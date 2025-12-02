<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PricingRule;
use App\Models\Listing;
use Illuminate\Http\Request;

class PricingRuleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * List pricing rules for current user
     */
    public function index(Request $request)
    {
        $rules = PricingRule::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json($rules);
    }

    /**
     * Show single pricing rule
     */
    public function show($id)
    {
        $rule = PricingRule::where('id', $id)
            ->where('user_id', auth()->id())
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
            'start_date'   => 'nullable|date',
            'end_date'     => 'nullable|date|after_or_equal:start_date',
            'percentage'   => 'required|numeric',
        ]);

        // Ensure listing belongs to current user (if specific listing)
        if ($request->listing_id) {
            Listing::where('id', $request->listing_id)
                ->where('user_id', auth()->id())
                ->firstOrFail();
        }

        $rule = PricingRule::create([
            'user_id'     => auth()->id(),
            'listing_id'  => $request->listing_id,
            'rule_type'   => $request->rule_type,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'percentage'  => $request->percentage,
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
        $rule = PricingRule::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $request->validate([
            'rule_type'   => 'sometimes|string',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'percentage'  => 'sometimes|numeric',
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
            'start_date',
            'end_date',
            'percentage'
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
        $rule = PricingRule::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $rule->delete();

        return response()->json(['message' => 'Pricing rule deleted']);
    }
}
