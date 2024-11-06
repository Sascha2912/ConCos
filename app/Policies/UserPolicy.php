<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy {
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user) {
        return $user->isAdmin()
            ? Response::allow()
            : Response::deny(__('app.you_do_not_have_permission_for_this_action'));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model) {
        if($user->id === $model->id || $user->isAdmin()){
            return Response::allow();
        }

        return Response::deny(__('app.you_do_not_have_permission_for_this_action'));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user) {
        return $user->isAdmin()
            ? Response::allow()
            : Response::deny(__(__('app.you_do_not_have_permission_for_this_action')));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model) {
        if($user->isAdmin()){
            return Response::allow();
        }

        // Users can only update their own profile, excluding the email
        if($user->id === $model->id){
            // Verhindern, dass der Benutzer seine eigene Rolle aktualisiert
            if(request()->has('role') && request()->input('role') !== $model->role){
                return Response::deny(__('app.you_do_not_have_permission_for_this_action'));
            }

            return Response::allow();
        }

        return Response::deny(__('app.you_do_not_have_permission_for_this_action'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model) {
        return $user->isAdmin()
            ? Response::allow()
            : Response::deny(__('app.you_do_not_have_permission_for_this_action'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model) {
        return $user->isAdmin()
            ? Response::allow()
            : Response::deny(__('app.you_do_not_have_permission_for_this_action'));
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model) {
        return $user->isAdmin()
            ? Response::allow()
            : Response::deny(__('app.you_do_not_have_permission_for_this_action'));
    }
}
