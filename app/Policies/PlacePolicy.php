<?php

namespace App\Policies;

use App\Models\Manager;
use App\Models\Place;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PlacePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Manager $user): bool
    {
        return $user->hasPermissionTo('place-list');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Manager $user, Place $place): bool
    {
        return $user->hasPermissionTo('place_list');

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Manager $user): bool
    {
        return $user->hasPermissionTo('place-create');

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Manager $user, Place $place): bool
    {
        return $user->hasPermissionTo('place-edit');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Manager $user, Place $place): bool
    {
        return $user->hasPermissionTo('place_delete');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Manager $user, Place $place): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Manager $user, Place $place): bool
    {
        return $user->hasPermissionTo('place_delete');

    }
}
