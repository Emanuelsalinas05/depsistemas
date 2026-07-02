<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Worklog;
use App\Policies\Traits\HasProjectAccess;

class WorklogPolicy
{
    use HasProjectAccess;

    /**
     * Determine if the user can view any worklogs.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('worklogs.viewAny');
    }

    /**
     * Determine if the user can view the worklog.
     */
    public function view(User $user, Worklog $worklog): bool
    {
        if (!$user->can('worklogs.view')) {
            return false;
        }

        // Puede ver sus propios worklogs
        if ($worklog->user_id === $user->id) {
            return true;
        }

        // PM puede ver worklogs del equipo
        if ($user->hasRole('pm') && $worklog->tarea) {
            return $this->isProjectMember($user, $worklog->tarea->proyecto);
        }

        return false;
    }

    /**
     * Determine if the user can create worklogs.
     */
    public function create(User $user): bool
    {
        return $user->can('worklogs.create');
    }

    /**
     * Determine if the user can update the worklog.
     */
    public function update(User $user, Worklog $worklog): bool
    {
        if (!$user->can('worklogs.update')) {
            return false;
        }

        // Solo puede actualizar sus propios worklogs
        return $worklog->user_id === $user->id;
    }

    /**
     * Determine if the user can delete the worklog.
     */
    public function delete(User $user, Worklog $worklog): bool
    {
        if (!$user->can('worklogs.delete')) {
            return false;
        }

        // Solo puede eliminar sus propios worklogs
        return $worklog->user_id === $user->id;
    }

    /**
     * Determine if the user can export worklogs.
     */
    public function export(User $user): bool
    {
        return $user->can('worklogs.export');
    }
}
