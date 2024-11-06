<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CustomerPolicy {
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user) {
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Customer $customer) {
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
    public function update(User $user, Customer $customer) {
        return ($user->isEditor() || $user->isAdmin())
            ? Response::allow()
            : Response::deny(__('app.you_do_not_have_permission_for_this_action'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Customer $customer) {
        return $user->isAdmin()
            ? Response::allow()
            : Response::deny(__('app.you_do_not_have_permission_for_this_action'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Customer $customer) {
        return $user->isAdmin()
            ? Response::allow()
            : Response::deny(__('app.you_do_not_have_permission_for_this_action'));
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Customer $customer) {
        return $user->isAdmin()
            ? Response::allow()
            : Response::deny(__('app.you_do_not_have_permission_for_this_action'));
    }
}
