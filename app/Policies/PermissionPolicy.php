<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class PermissionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Permission $model): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('admin_user_management');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Permission $model): bool
    {
        return true;
        dd();
        return $user->hasPermissionTo('admin_user_management');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Permission $model): bool
    {
        return $user->hasPermissionTo('admin_user_management');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Permission $model): bool
    {
        return $user->hasPermissionTo('admin_user_management');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Permission $model): bool
    {
        return $user->hasPermissionTo('admin_user_management');
    }
}
