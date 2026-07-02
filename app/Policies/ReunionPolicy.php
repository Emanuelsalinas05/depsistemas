<?php

namespace App\Policies;

use App\Models\Reunion;
use App\Models\User;
use App\Policies\Traits\HasProjectAccess;

class ReunionPolicy
{
    use HasProjectAccess;

    /**
     * Determine if the user can view any reuniones.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('reuniones.viewAny');
    }

    /**
     * Determine if the user can view the reunion.
     */
    public function view(User $user, Reunion $reunion): bool
    {
        if (!$user->can('reuniones.view')) {
            return false;
        }

        // Consulta puede ver
        if ($user->hasRole('consulta')) {
            return true;
        }

        // Puede ver si es asistente
        if ($reunion->asistentes()->where('user_id', $user->id)->exists()) {
            return true;
        }

        // Puede ver si es miembro del proyecto
        if ($reunion->proyecto_id) {
            return $this->isProjectMember($user, $reunion->proyecto);
        }

        return false;
    }

    /**
     * Determine if the user can create reuniones.
     */
    public function create(User $user): bool
    {
        return $user->can('reuniones.create');
    }

    /**
     * Determine if the user can update the reunion.
     */
    public function update(User $user, Reunion $reunion): bool
    {
        if (!$user->can('reuniones.update')) {
            return false;
        }

        // PM puede actualizar si es PM en el proyecto
        if ($reunion->proyecto_id) {
            if ($this->isProjectPM($user, $reunion->proyecto)) {
                return true;
            }
        }

        // Creador puede actualizar
        return $reunion->created_by === $user->id;
    }

    /**
     * Determine if the user can delete the reunion.
     */
    public function delete(User $user, Reunion $reunion): bool
    {
        return $user->can('reuniones.delete');
    }

    /**
     * Determine if the user can manage attendees.
     */
    public function manageAttendees(User $user, Reunion $reunion): bool
    {
        if (!$user->can('reuniones.manage_attendees')) {
            return false;
        }

        // PM puede gestionar asistentes si es PM en el proyecto
        if ($reunion->proyecto_id) {
            return $this->isProjectPM($user, $reunion->proyecto);
        }

        // Creador puede gestionar asistentes
        return $reunion->created_by === $user->id;
    }
}
