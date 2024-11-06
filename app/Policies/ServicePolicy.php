<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ServicePolicy {
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user) {
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Service $service) {
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user) {
        return ($user->isEditor() || $user->isAdmin())
            ? Response::allow()
            : Response::deny(__('app.you_do_not_have_permission_for_this_action'));;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Service $service) {
        return ($user->isEditor() || $user->isAdmin())
            ? Response::allow()
            : Response::deny(__('app.you_do_not_have_permission_for_this_action'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Service $service) {
        return $user->isAdmin()
            ? Response::allow()
            : Response::deny(__('app.you_do_not_have_permission_for_this_action'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Service $service) {
        return $user->isAdmin()
            ? Response::allow()
            : Response::deny(__('app.you_do_not_have_permission_for_this_action'));
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Service $service) {
        return $user->isAdmin()
            ? Response::allow()
            : Response::deny(__('app.you_do_not_have_permission_for_this_action'));
    }
}
