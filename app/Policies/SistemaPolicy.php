<?php

namespace App\Policies;

use App\Models\Sistema;
use App\Models\User;
use App\Policies\Traits\HasProjectAccess;

class SistemaPolicy
{
    use HasProjectAccess;

    /**
     * Determine if the user can view any sistemas.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('sistemas.viewAny');
    }

    /**
     * Determine if the user can view the sistema.
     */
    public function view(User $user, Sistema $sistema): bool
    {
        if (!$user->can('sistemas.view')) {
            return false;
        }

        // Superadmin ve todo
        if ($user->hasRole('superadmin')) {
            return true;
        }

        // Consulta puede ver
        if ($user->hasRole('consulta')) {
            return true;
        }

        // Otros roles: solo si es miembro del sistema
        return $this->isSystemMember($user, $sistema->id);
    }

    /**
     * Determine if the user can create sistemas.
     */
    public function create(User $user): bool
    {
        return $user->can('sistemas.create');
    }

    /**
     * Determine if the user can update the sistema.
     */
    public function update(User $user, Sistema $sistema): bool
    {
        if (!$user->can('sistemas.update')) {
            return false;
        }

        // PM puede actualizar si es PM en algún proyecto del sistema
        if ($user->hasRole('pm')) {
            return $user->proyectos()
                ->whereHas('sistema', function ($q) use ($sistema) {
                    $q->where('id', $sistema->id);
                })
                ->wherePivot('rol_en_proyecto', 'pm')
                ->exists();
        }

        return false;
    }

    /**
     * Determine if the user can delete the sistema.
     */
    public function delete(User $user, Sistema $sistema): bool
    {
        return $user->can('sistemas.delete');
    }

    /**
     * Determine if the user can manage technologies.
     */
    public function manageTech(User $user, Sistema $sistema): bool
    {
        if (!$user->can('sistemas.manage_tech')) {
            return false;
        }

        // PM puede gestionar tech si es PM en algún proyecto del sistema
        if ($user->hasRole('pm')) {
            return $user->proyectos()
                ->whereHas('sistema', function ($q) use ($sistema) {
                    $q->where('id', $sistema->id);
                })
                ->wherePivot('rol_en_proyecto', 'pm')
                ->exists();
        }

        return false;
    }

    /**
     * Determine if the user can manage infrastructure.
     */
    public function manageInfra(User $user, Sistema $sistema): bool
    {
        if (!$user->can('sistemas.manage_infra')) {
            return false;
        }

        // PM puede gestionar infra si es PM en algún proyecto del sistema
        if ($user->hasRole('pm')) {
            return $user->proyectos()
                ->whereHas('sistema', function ($q) use ($sistema) {
                    $q->where('id', $sistema->id);
                })
                ->wherePivot('rol_en_proyecto', 'pm')
                ->exists();
        }

        return false;
    }

    /**
     * Determine if the user can archive the sistema.
     */
    public function archive(User $user, Sistema $sistema): bool
    {
        return $user->can('sistemas.archive');
    }

    /**
     * Determine if the user can restore the sistema.
     */
    public function restore(User $user, Sistema $sistema): bool
    {
        return $user->can('sistemas.restore');
    }
}
