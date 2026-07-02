<?php

namespace App\Policies;

use App\Models\Tarea;
use App\Models\User;
use App\Policies\Traits\HasProjectAccess;

class TareaPolicy
{
    use HasProjectAccess;

    /**
     * Determine if the user can view any tareas.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('tareas.viewAny');
    }

    /**
     * Determine if the user can view the tarea.
     */
    public function view(User $user, Tarea $tarea): bool
    {
        if (!$user->can('tareas.view')) {
            return false;
        }

        // Consulta puede ver
        if ($user->hasRole('consulta')) {
            return true;
        }

        // Solo puede ver si es miembro del proyecto
        return $this->isProjectMember($user, $tarea->proyecto);
    }

    /**
     * Determine if the user can create tareas.
     */
    public function create(User $user): bool
    {
        if (!$user->can('tareas.create')) {
            return false;
        }

        // Soporte solo puede crear tareas tipo soporte
        // Esto se valida en el request/controller
        return true;
    }

    /**
     * Determine if the user can update the tarea.
     */
    public function update(User $user, Tarea $tarea): bool
    {
        if (!$user->can('tareas.update')) {
            return false;
        }

        // Dev puede actualizar si es asignado o creador
        if ($user->hasRole('dev')) {
            return $tarea->asignado_a === $user->id 
                || $tarea->created_by === $user->id
                || $this->isProjectMember($user, $tarea->proyecto);
        }

        // Otros roles: solo si es miembro del proyecto
        return $this->isProjectMember($user, $tarea->proyecto);
    }

    /**
     * Determine if the user can delete the tarea.
     */
    public function delete(User $user, Tarea $tarea): bool
    {
        return $user->can('tareas.delete');
    }

    /**
     * Determine if the user can assign tareas.
     */
    public function assign(User $user, Tarea $tarea): bool
    {
        if (!$user->can('tareas.assign')) {
            return false;
        }

        // PM puede asignar si es PM en el proyecto
        return $this->isProjectPM($user, $tarea->proyecto);
    }

    /**
     * Determine if the user can move state (Kanban).
     */
    public function moveState(User $user, Tarea $tarea, ?string $nuevoEstado = null): bool
    {
        if (!$user->can('tareas.move_state')) {
            return false;
        }

        // Solo puede mover estado si es miembro del proyecto
        if (!$this->isProjectMember($user, $tarea->proyecto)) {
            return false;
        }

        // QA solo puede mover hacia en_revision o listo_release
        if ($user->hasRole('qa') && $nuevoEstado) {
            return in_array($nuevoEstado, ['en_revision', 'listo_release']);
        }

        // Soporte solo puede mover hasta en_revision (no listo_release ni cerrado)
        if ($user->hasRole('soporte') && $nuevoEstado) {
            return in_array($nuevoEstado, ['nuevo', 'en_curso', 'en_revision']);
        }

        // Dev puede mover estados básicos (no cerrar)
        if ($user->hasRole('dev') && $nuevoEstado) {
            return !in_array($nuevoEstado, ['cerrado']);
        }

        // PM puede mover a cualquier estado
        if ($this->isProjectPM($user, $tarea->proyecto)) {
            return true;
        }

        return true;
    }

    /**
     * Determine if the user can plan dates.
     */
    public function planDates(User $user, Tarea $tarea): bool
    {
        if (!$user->can('tareas.plan_dates')) {
            return false;
        }

        // PM puede planear fechas si es PM en el proyecto
        return $this->isProjectPM($user, $tarea->proyecto);
    }

    /**
     * Determine if the user can reopen the tarea.
     */
    public function reopen(User $user, Tarea $tarea): bool
    {
        if (!$user->can('tareas.reopen')) {
            return false;
        }

        // Solo PM puede reabrir
        return $this->isProjectPM($user, $tarea->proyecto);
    }

    /**
     * Determine if the user can export tareas.
     */
    public function export(User $user): bool
    {
        return $user->can('tareas.export');
    }
}
