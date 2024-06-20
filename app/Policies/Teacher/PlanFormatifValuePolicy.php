<?php

namespace App\Policies\Teacher;

use App\Models\User;
use App\Models\Teacher\PlanFormatifValue;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlanFormatifValuePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_teacher::plan::formatif::value');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PlanFormatifValue $planFormatifValue): bool
    {
        return $user->can('view_teacher::plan::formatif::value');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_teacher::plan::formatif::value');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PlanFormatifValue $planFormatifValue): bool
    {
        return $user->can('update_teacher::plan::formatif::value');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PlanFormatifValue $planFormatifValue): bool
    {
        return $user->can('delete_teacher::plan::formatif::value');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_teacher::plan::formatif::value');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, PlanFormatifValue $planFormatifValue): bool
    {
        return $user->can('force_delete_teacher::plan::formatif::value');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_teacher::plan::formatif::value');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, PlanFormatifValue $planFormatifValue): bool
    {
        return $user->can('restore_teacher::plan::formatif::value');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_teacher::plan::formatif::value');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, PlanFormatifValue $planFormatifValue): bool
    {
        return $user->can('replicate_teacher::plan::formatif::value');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_teacher::plan::formatif::value');
    }
}
