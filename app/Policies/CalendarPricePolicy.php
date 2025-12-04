<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CalendarPrice;
use Illuminate\Auth\Access\HandlesAuthorization;

class CalendarPricePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any calendar prices.
     */
    public function viewAny(User $user): bool
    {
        // User can view their own listings' calendar prices
        return true;
    }

    /**
     * Determine whether the user can view the calendar price.
     */
    public function view(User $user, CalendarPrice $calendarPrice): bool
    {
        return $calendarPrice->listing->user_id === $user->id;
    }

    /**
     * Determine whether the user can create calendar prices.
     */
    public function create(User $user): bool
    {
        return true; // any authenticated user can create prices for their listings
    }

    /**
     * Determine whether the user can update the calendar price.
     */
    public function update(User $user, CalendarPrice $calendarPrice): bool
    {
        return $calendarPrice->listing->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the calendar price.
     */
    public function delete(User $user, CalendarPrice $calendarPrice): bool
    {
        return $calendarPrice->listing->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the calendar price.
     */
    public function restore(User $user, CalendarPrice $calendarPrice): bool
    {
        return $calendarPrice->listing->user_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the calendar price.
     */
    public function forceDelete(User $user, CalendarPrice $calendarPrice): bool
    {
        return $calendarPrice->listing->user_id === $user->id;
    }
}
