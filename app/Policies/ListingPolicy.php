<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Listing;

class ListingPolicy
{
    /**
     * Determine if the user can view the listing.
     */
    public function view(User $user, Listing $listing)
    {
        // Only the owner can view their listing
        return $user->id === $listing->user_id;
    }

    /**
     * Determine if the user can update the listing.
     */
    public function update(User $user, Listing $listing)
    {
        return $user->id === $listing->user_id;
    }

    /**
     * Determine if the user can delete the listing.
     */
    public function delete(User $user, Listing $listing)
    {
        return $user->id === $listing->user_id;
    }

    /**
     * Determine if the user can create listings.
     */
    public function create(User $user)
    {
        // All authenticated users can create listings
        return true;
    }
}