<?php

namespace App\Policies;

use App\Models\Checklist;
use App\Models\User;
use App\Policies\Traits\HasProjectAccess;

class ChecklistPolicy
{
    use HasProjectAccess;

    /**
     * Determine if the user can create checklist.
     */
    public function create(User $user): bool
    {
        return $user->can('checklists.create');
    }

    /**
     * Determine if the user can update the checklist.
     */
    public function update(User $user, Checklist $checklist): bool
    {
        if (!$user->can('checklists.update')) {
            return false;
        }

        // Puede actualizar si es creador
        if ($checklist->created_by === $user->id) {
            return true;
        }

        // PM puede actualizar si es PM en el proyecto relacionado
        // Esto depende del modelo polimórfico
        $model = $checklist->model;
        if ($model instanceof \App\Models\Tarea && $model->proyecto) {
            return $this->isProjectPM($user, $model->proyecto);
        }

        return false;
    }

    /**
     * Determine if the user can delete the checklist.
     */
    public function delete(User $user, Checklist $checklist): bool
    {
        return $user->can('checklists.delete');
    }

    /**
     * Determine if the user can complete item.
     */
    public function completeItem(User $user): bool
    {
        return $user->can('checklists.complete_item');
    }
}
