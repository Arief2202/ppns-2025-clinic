<?php

namespace App\Policies;

use App\Models\InventarisPeralatan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InventarisPeralatanPolicy
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
    public function view(User $user, InventarisPeralatan $inventarisPeralatan): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, InventarisPeralatan $inventarisPeralatan): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, InventarisPeralatan $inventarisPeralatan): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, InventarisPeralatan $inventarisPeralatan): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, InventarisPeralatan $inventarisPeralatan): bool
    {
        //
    }
}
