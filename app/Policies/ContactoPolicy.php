<?php

namespace App\Policies;

use App\Models\Contacto;
use App\Models\User;

class ContactoPolicy
{
    /**
     * Determine if the user can view any contactos.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('contactos.viewAny');
    }

    /**
     * Determine if the user can view the contacto.
     */
    public function view(User $user, Contacto $contacto): bool
    {
        return $user->can('contactos.view');
    }

    /**
     * Determine if the user can create contactos.
     */
    public function create(User $user): bool
    {
        return $user->can('contactos.create');
    }

    /**
     * Determine if the user can update the contacto.
     */
    public function update(User $user, Contacto $contacto): bool
    {
        return $user->can('contactos.update');
    }

    /**
     * Determine if the user can delete the contacto.
     */
    public function delete(User $user, Contacto $contacto): bool
    {
        return $user->can('contactos.delete');
    }

    /**
     * Determine if the user can manage interactions.
     */
    public function manageInteractions(User $user, Contacto $contacto): bool
    {
        return $user->can('contactos.manage_interactions');
    }
}
