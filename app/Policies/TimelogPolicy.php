<?php

namespace App\Policies;

use App\Models\Timelog;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TimelogPolicy {
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user) {
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Timelog $timelog) {
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user) {
        return ($user->isEditor() || $user->isAdmin())
            ? Response::allow()
            : Response::deny(__('app.you_do_not_have_permission_for_this_action'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Timelog $timelog) {
        return ($user->isEditor() || $user->isAdmin())
            ? Response::allow()
            : Response::deny(__('app.you_do_not_have_permission_for_this_action'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Timelog $timelog) {
        return $user->isAdmin()
            ? Response::allow()
            : Response::deny(__('app.you_do_not_have_permission_for_this_action'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Timelog $timelog) {
        return $user->isAdmin()
            ? Response::allow()
            : Response::deny(__('app.you_do_not_have_permission_for_this_action'));
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Timelog $timelog) {
        return $user->isAdmin()
            ? Response::allow()
            : Response::deny(__('app.you_do_not_have_permission_for_this_action'));
    }
}
