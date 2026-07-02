<?php

namespace App\Policies;

use App\Models\Release;
use App\Models\User;
use App\Policies\Traits\HasProjectAccess;

class ReleasePolicy
{
    use HasProjectAccess;

    /**
     * Determine if the user can view any releases.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('releases.viewAny');
    }

    /**
     * Determine if the user can view the release.
     */
    public function view(User $user, Release $release): bool
    {
        if (!$user->can('releases.view')) {
            return false;
        }

        // Consulta puede ver
        if ($user->hasRole('consulta')) {
            return true;
        }

        // Solo puede ver si es miembro del sistema
        return $this->isSystemMember($user, $release->sistema_id);
    }

    /**
     * Determine if the user can create releases.
     */
    public function create(User $user): bool
    {
        return $user->can('releases.create');
    }

    /**
     * Determine if the user can update the release.
     */
    public function update(User $user, Release $release): bool
    {
        if (!$user->can('releases.update')) {
            return false;
        }

        // PM puede actualizar si es PM en algún proyecto del sistema
        if ($user->hasRole('pm')) {
            return $user->proyectos()
                ->whereHas('sistema', function ($q) use ($release) {
                    $q->where('id', $release->sistema_id);
                })
                ->wherePivot('rol_en_proyecto', 'pm')
                ->exists();
        }

        return false;
    }

    /**
     * Determine if the user can delete the release.
     */
    public function delete(User $user, Release $release): bool
    {
        return $user->can('releases.delete');
    }

    /**
     * Determine if the user can deploy to production.
     */
    public function deployProd(User $user, Release $release): bool
    {
        if (!$user->can('releases.deploy_prod')) {
            return false;
        }

        // Solo PM y superadmin pueden desplegar a producción
        return $user->hasRole(['pm', 'superadmin']);
    }

    /**
     * Determine if the user can deploy to QA.
     */
    public function deployQa(User $user, Release $release): bool
    {
        if (!$user->can('releases.deploy_qa')) {
            return false;
        }

        // PM puede desplegar a QA
        if ($user->hasRole('pm')) {
            return $user->proyectos()
                ->whereHas('sistema', function ($q) use ($release) {
                    $q->where('id', $release->sistema_id);
                })
                ->wherePivot('rol_en_proyecto', 'pm')
                ->exists();
        }

        return false;
    }

    /**
     * Determine if the user can approve the release.
     */
    public function approve(User $user, Release $release): bool
    {
        if (!$user->can('releases.approve')) {
            return false;
        }

        // PM puede aprobar
        if ($user->hasRole('pm')) {
            return $user->proyectos()
                ->whereHas('sistema', function ($q) use ($release) {
                    $q->where('id', $release->sistema_id);
                })
                ->wherePivot('rol_en_proyecto', 'pm')
                ->exists();
        }

        return false;
    }

    /**
     * Determine if the user can rollback the release.
     */
    public function rollback(User $user, Release $release): bool
    {
        if (!$user->can('releases.rollback')) {
            return false;
        }

        // Solo PM y superadmin pueden hacer rollback
        return $user->hasRole(['pm', 'superadmin']);
    }
}
