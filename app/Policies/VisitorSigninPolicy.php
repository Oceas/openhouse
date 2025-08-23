<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VisitorSignin;
use Illuminate\Auth\Access\HandlesAuthorization;

class VisitorSigninPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Users can view their own leads
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, VisitorSignin $visitorSignin): bool
    {
        // User can only view leads for properties they own
        return $user->id === $visitorSignin->property->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Anyone can create visitor sign-ins
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, VisitorSignin $visitorSignin): bool
    {
        // User can only update leads for properties they own
        return $user->id === $visitorSignin->property->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, VisitorSignin $visitorSignin): bool
    {
        // User can only delete leads for properties they own
        return $user->id === $visitorSignin->property->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, VisitorSignin $visitorSignin): bool
    {
        // User can only restore leads for properties they own
        return $user->id === $visitorSignin->property->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, VisitorSignin $visitorSignin): bool
    {
        // User can only permanently delete leads for properties they own
        return $user->id === $visitorSignin->property->user_id;
    }
}
