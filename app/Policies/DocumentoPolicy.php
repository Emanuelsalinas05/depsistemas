<?php

namespace App\Policies;

use App\Models\Documento;
use App\Models\User;
use App\Policies\Traits\HasProjectAccess;

class DocumentoPolicy
{
    use HasProjectAccess;

    /**
     * Determine if the user can view any documentos.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('docs.viewAny');
    }

    /**
     * Determine if the user can view the documento.
     */
    public function view(User $user, Documento $documento): bool
    {
        if (!$user->can('docs.view')) {
            return false;
        }

        // Consulta solo ve publicados
        if ($user->hasRole('consulta')) {
            return $documento->estado === 'publicado';
        }

        // Si está publicado, todos pueden ver
        if ($documento->estado === 'publicado') {
            return true;
        }

        // Para borradores, debe ser miembro del sistema
        if ($documento->sistema_id) {
            return $this->isSystemMember($user, $documento->sistema_id);
        }

        return false;
    }

    /**
     * Determine if the user can create documentos.
     */
    public function create(User $user): bool
    {
        return $user->can('docs.create');
    }

    /**
     * Determine if the user can update the documento.
     */
    public function update(User $user, Documento $documento): bool
    {
        if (!$user->can('docs.update')) {
            return false;
        }

        // Solo puede actualizar borradores
        if ($documento->estado === 'publicado') {
            return false;
        }

        // Dev puede actualizar si es creador o miembro del sistema
        if ($user->hasRole('dev')) {
            return $documento->created_by === $user->id 
                || ($documento->sistema_id && $this->isSystemMember($user, $documento->sistema_id));
        }

        // Otros: solo si es miembro del sistema
        if ($documento->sistema_id) {
            return $this->isSystemMember($user, $documento->sistema_id);
        }

        return false;
    }

    /**
     * Determine if the user can delete the documento.
     */
    public function delete(User $user, Documento $documento): bool
    {
        return $user->can('docs.delete');
    }

    /**
     * Determine if the user can publish the documento.
     */
    public function publish(User $user, Documento $documento): bool
    {
        if (!$user->can('docs.publish')) {
            return false;
        }

        // PM puede publicar si es PM en algún proyecto del sistema
        if ($user->hasRole('pm') && $documento->sistema_id) {
            return $user->proyectos()
                ->whereHas('sistema', function ($q) use ($documento) {
                    $q->where('id', $documento->sistema_id);
                })
                ->wherePivot('rol_en_proyecto', 'pm')
                ->exists();
        }

        return false;
    }

    /**
     * Determine if the user can add version.
     */
    public function addVersion(User $user, Documento $documento): bool
    {
        if (!$user->can('docs.add_version')) {
            return false;
        }

        // Solo puede agregar versión si puede actualizar
        return $this->update($user, $documento);
    }

    /**
     * Determine if the user can view versions.
     */
    public function viewVersions(User $user, Documento $documento): bool
    {
        return $user->can('docs.view_versions') && $this->view($user, $documento);
    }

    /**
     * Determine if the user can delete version.
     */
    public function deleteVersion(User $user, Documento $documento): bool
    {
        return $user->can('docs.delete_version');
    }

    /**
     * Determine if the user can archive the documento.
     */
    public function archive(User $user, Documento $documento): bool
    {
        return $user->can('docs.archive');
    }

    /**
     * Determine if the user can restore the documento.
     */
    public function restore(User $user, Documento $documento): bool
    {
        return $user->can('docs.restore');
    }

    /**
     * Determine if the user can export the documento.
     */
    public function export(User $user, Documento $documento): bool
    {
        return $user->can('docs.export') && $this->view($user, $documento);
    }
}
