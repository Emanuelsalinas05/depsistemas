<?php

namespace App\Policies;

use App\Models\Proyecto;
use App\Models\User;
use App\Policies\Traits\HasProjectAccess;

class ProyectoPolicy
{
    use HasProjectAccess;

    /**
     * Determine if the user can view any proyectos.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('proyectos.viewAny');
    }

    /**
     * Determine if the user can view the proyecto.
     */
    public function view(User $user, Proyecto $proyecto): bool
    {
        if (!$user->can('proyectos.view')) {
            return false;
        }

        // Consulta puede ver
        if ($user->hasRole('consulta')) {
            return true;
        }

        // Solo puede ver si es miembro del proyecto
        return $this->isProjectMember($user, $proyecto);
    }

    /**
     * Determine if the user can create proyectos.
     */
    public function create(User $user): bool
    {
        return $user->can('proyectos.create');
    }

    /**
     * Determine if the user can update the proyecto.
     */
    public function update(User $user, Proyecto $proyecto): bool
    {
        if (!$user->can('proyectos.update')) {
            return false;
        }

        // PM puede actualizar si es PM en el proyecto
        return $this->isProjectPM($user, $proyecto);
    }

    /**
     * Determine if the user can delete the proyecto.
     */
    public function delete(User $user, Proyecto $proyecto): bool
    {
        return $user->can('proyectos.delete');
    }

    /**
     * Determine if the user can manage members.
     */
    public function manageMembers(User $user, Proyecto $proyecto): bool
    {
        if (!$user->can('proyectos.manage_members')) {
            return false;
        }

        // PM puede gestionar miembros si es PM en el proyecto
        return $this->isProjectPM($user, $proyecto);
    }

    /**
     * Determine if the user can archive the proyecto.
     */
    public function archive(User $user, Proyecto $proyecto): bool
    {
        if (!$user->can('proyectos.archive')) {
            return false;
        }

        return $this->isProjectPM($user, $proyecto);
    }

    /**
     * Determine if the user can restore the proyecto.
     */
    public function restore(User $user, Proyecto $proyecto): bool
    {
        return $user->can('proyectos.restore');
    }
}
