<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Repository;
use Illuminate\Auth\Access\HandlesAuthorization; // Importa la clase HandlesAuthorization que permite manejar la autorización de manera más sencilla

class RepositoryPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determina si el usuario puede ver el repositorio.
     * 
     * @param  \App\Models\User  $user
     * @param  \App\Models\Repository  $repository
     * @return bool
     */
    public function pass(User $user, Repository $repository)
    {
        // Verifica si el usuario es el propietario del repositorio
        return $user->id === $repository->user_id;
    }
}
