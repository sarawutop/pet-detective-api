<?php

namespace App\Policies;

use App\Models\LostPet;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LostPetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LostPet  $lostPet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, LostPet $lostPet)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->isAdmin() or $user->isUser();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LostPet  $lostPet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, LostPet $lostPet)
    {
        return $user->isAdmin() or
            ($user->isUser() and $user->id === $lostPet->user_id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LostPet  $lostPet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, LostPet $lostPet)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LostPet  $lostPet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, LostPet $lostPet)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LostPet  $lostPet
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, LostPet $lostPet)
    {
        return $user->isAdmin();
    }
}
