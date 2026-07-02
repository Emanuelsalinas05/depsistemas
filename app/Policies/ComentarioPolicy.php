<?php

namespace App\Policies;

use App\Models\Comentario;
use App\Models\User;

class ComentarioPolicy
{
    /**
     * Determine if the user can create comentarios.
     */
    public function create(User $user): bool
    {
        return $user->can('comentarios.create');
    }

    /**
     * Determine if the user can update the comentario.
     */
    public function update(User $user, Comentario $comentario): bool
    {
        if (!$user->can('comentarios.update')) {
            return false;
        }

        // Solo puede actualizar sus propios comentarios
        return $comentario->created_by === $user->id;
    }

    /**
     * Determine if the user can delete the comentario.
     */
    public function delete(User $user, Comentario $comentario): bool
    {
        if (!$user->can('comentarios.delete')) {
            return false;
        }

        // Puede eliminar sus propios comentarios
        if ($comentario->created_by === $user->id) {
            return true;
        }

        // PM/superadmin pueden eliminar cualquier comentario
        return $user->hasRole(['pm', 'superadmin']);
    }

    /**
     * Determine if the user can view comentarios.
     */
    public function view(User $user, Comentario $comentario): bool
    {
        return $user->can('comentarios.view');
    }
}
