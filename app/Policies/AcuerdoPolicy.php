<?php

namespace App\Policies;

use App\Models\Acuerdo;
use App\Models\User;
use App\Policies\Traits\HasProjectAccess;

class AcuerdoPolicy
{
    use HasProjectAccess;

    /**
     * Determine if the user can view any acuerdos.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('acuerdos.viewAny');
    }

    /**
     * Determine if the user can view the acuerdo.
     */
    public function view(User $user, Acuerdo $acuerdo): bool
    {
        if (!$user->can('acuerdos.view')) {
            return false;
        }

        // Puede ver si es responsable
        if ($acuerdo->responsable_id === $user->id) {
            return true;
        }

        // Puede ver si es miembro del proyecto
        if ($acuerdo->proyecto_id) {
            return $this->isProjectMember($user, $acuerdo->proyecto);
        }

        // Puede ver si asistió a la reunión
        if ($acuerdo->reunion_id) {
            return $acuerdo->reunion->asistentes()
                ->where('user_id', $user->id)
                ->exists();
        }

        return false;
    }

    /**
     * Determine if the user can create acuerdos.
     */
    public function create(User $user): bool
    {
        return $user->can('acuerdos.create');
    }

    /**
     * Determine if the user can update the acuerdo.
     */
    public function update(User $user, Acuerdo $acuerdo): bool
    {
        if (!$user->can('acuerdos.update')) {
            return false;
        }

        // Responsable puede actualizar
        if ($acuerdo->responsable_id === $user->id) {
            return true;
        }

        // PM puede actualizar si es PM en el proyecto
        if ($acuerdo->proyecto_id) {
            return $this->isProjectPM($user, $acuerdo->proyecto);
        }

        return false;
    }

    /**
     * Determine if the user can delete the acuerdo.
     */
    public function delete(User $user, Acuerdo $acuerdo): bool
    {
        return $user->can('acuerdos.delete');
    }

    /**
     * Determine if the user can mark as completed.
     */
    public function markCompleted(User $user, Acuerdo $acuerdo): bool
    {
        if (!$user->can('acuerdos.mark_completed')) {
            return false;
        }

        // Responsable puede marcar como cumplido
        if ($acuerdo->responsable_id === $user->id) {
            return true;
        }

        // PM puede marcar como cumplido
        if ($acuerdo->proyecto_id) {
            return $this->isProjectPM($user, $acuerdo->proyecto);
        }

        return false;
    }
}
