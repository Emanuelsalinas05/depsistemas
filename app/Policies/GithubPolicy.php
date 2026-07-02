<?php

namespace App\Policies;

use App\Models\GithubInstallation;
use App\Models\GithubRepository;
use App\Models\User;
use App\Policies\Traits\HasProjectAccess;

class GithubPolicy
{
    use HasProjectAccess;

    /**
     * Determine if the user can manage GitHub installations.
     */
    public function manage(User $user): bool
    {
        return $user->can('github.manage');
    }

    /**
     * Determine if the user can view repositories.
     */
    public function view(User $user, ?GithubRepository $repository = null): bool
    {
        if (!$user->can('github.view')) {
            return false;
        }

        // Si hay repositorio específico, verificar acceso
        if ($repository) {
            // Puede ver si es miembro del sistema o proyecto
            if ($repository->sistema_id) {
                return $this->isSystemMember($user, $repository->sistema_id);
            }
            if ($repository->proyecto_id) {
                return $this->isProjectMember($user, $repository->proyecto);
            }
        }

        return true;
    }

    /**
     * Determine if the user can link repository.
     */
    public function linkRepo(User $user): bool
    {
        if (!$user->can('github.link_repo')) {
            return false;
        }

        // PM puede vincular repositorios
        return $user->hasRole('pm');
    }

    /**
     * Determine if the user can unlink repository.
     */
    public function unlinkRepo(User $user, GithubRepository $repository): bool
    {
        if (!$user->can('github.unlink_repo')) {
            return false;
        }

        // PM puede desvincular si es PM en el sistema/proyecto
        if ($user->hasRole('pm')) {
            if ($repository->sistema_id) {
                return $user->proyectos()
                    ->whereHas('sistema', function ($q) use ($repository) {
                        $q->where('id', $repository->sistema_id);
                    })
                    ->wherePivot('rol_en_proyecto', 'pm')
                    ->exists();
            }
            if ($repository->proyecto_id) {
                return $this->isProjectPM($user, $repository->proyecto);
            }
        }

        return false;
    }

    /**
     * Determine if the user can view webhooks.
     */
    public function viewWebhooks(User $user, GithubInstallation $installation): bool
    {
        return $user->can('github.view_webhooks');
    }
}
