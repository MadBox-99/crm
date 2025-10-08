<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\Permission;
use App\Models\Opportunity;
use App\Models\User;

final class OpportunityPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(Permission::ViewAnyOpportunity);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Opportunity $opportunity): bool
    {
        return $user->can(Permission::ViewOpportunity);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(Permission::CreateOpportunity);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Opportunity $opportunity): bool
    {
        return $user->can(Permission::UpdateOpportunity);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Opportunity $opportunity): bool
    {
        return $user->can(Permission::DeleteOpportunity);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Opportunity $opportunity): bool
    {
        return $user->can(Permission::RestoreOpportunity);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Opportunity $opportunity): bool
    {
        return $user->can(Permission::ForceDeleteOpportunity);
    }
}
