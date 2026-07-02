<?php

namespace App\Policies\Traits;

use App\Models\Proyecto;
use App\Models\User;

trait HasProjectAccess
{
    /**
     * Verificar si el usuario es miembro del proyecto
     */
    protected function isProjectMember(User $user, ?Proyecto $proyecto): bool
    {
        if (!$proyecto) {
            return false;
        }

        return $user->proyectos()
            ->where('proyectos.id', $proyecto->id)
            ->wherePivot('asignacion_activa', true)
            ->exists();
    }

    /**
     * Obtener el rol del usuario en el proyecto
     */
    protected function projectRole(User $user, ?Proyecto $proyecto): ?string
    {
        if (!$proyecto) {
            return null;
        }

        $miembro = $user->proyectos()
            ->where('proyectos.id', $proyecto->id)
            ->wherePivot('asignacion_activa', true)
            ->first();

        return $miembro?->pivot->rol_en_proyecto;
    }

    /**
     * Verificar si el usuario es PM en el proyecto
     */
    protected function isProjectPM(User $user, ?Proyecto $proyecto): bool
    {
        return $this->projectRole($user, $proyecto) === 'pm';
    }

    /**
     * Verificar si el usuario es miembro del sistema (a través de proyectos)
     */
    protected function isSystemMember(User $user, ?int $sistemaId): bool
    {
        if (!$sistemaId) {
            return false;
        }

        return $user->proyectos()
            ->whereHas('sistema', function ($q) use ($sistemaId) {
                $q->where('id', $sistemaId);
            })
            ->exists();
    }
}
