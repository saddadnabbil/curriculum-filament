<?php

namespace App\Policies\Teacher;

use App\Models\User;
use App\Models\PlanSumatifValue;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlanSumatifValuePolicy
{
    use HandlesAuthorization;

    protected function hasAccess(User $user, string $permission): bool
    {
        // Check if the user has the specified permission
        if ($user->can($permission)) {
            return true;
        }

        // Ensure the user's associated teacher is present in a classSchool
        return $user->employee
            && $user->employee->teacher
            && $user->employee->teacher->learningData()->exists();
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->hasAccess($user, 'view_any_teacher::plan::sumatif::value');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PlanSumatifValue $planSumatifValue): bool
    {
        return $this->hasAccess($user, 'view_teacher::plan::sumatif::value');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->hasAccess($user, 'create_teacher::plan::sumatif::value');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PlanSumatifValue $planSumatifValue): bool
    {
        return $this->hasAccess($user, 'update_teacher::plan::sumatif::value');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PlanSumatifValue $planSumatifValue): bool
    {
        return $this->hasAccess($user, 'delete_teacher::plan::sumatif::value');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $this->hasAccess($user, 'delete_any_teacher::plan::sumatif::value');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, PlanSumatifValue $planSumatifValue): bool
    {
        return $this->hasAccess($user, 'force_delete_teacher::plan::sumatif::value');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $this->hasAccess($user, 'force_delete_any_teacher::plan::sumatif::value');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, PlanSumatifValue $planSumatifValue): bool
    {
        return $this->hasAccess($user, 'restore_teacher::plan::sumatif::value');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $this->hasAccess($user, 'restore_any_teacher::plan::sumatif::value');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, PlanSumatifValue $planSumatifValue): bool
    {
        return $this->hasAccess($user, 'replicate_teacher::plan::sumatif::value');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $this->hasAccess($user, 'reorder_teacher::plan::sumatif::value');
    }
}
