<?php

namespace App\Policies;

use App\Models\IaGeneracion;
use App\Models\IaPrompt;
use App\Models\User;

class IaPolicy
{
    /**
     * Determine if the user can use IA.
     */
    public function use(User $user): bool
    {
        return $user->can('ia.use');
    }

    /**
     * Determine if the user can view IA generations.
     */
    public function view(User $user, ?IaGeneracion $generacion = null): bool
    {
        if (!$user->can('ia.view')) {
            return false;
        }

        // Si hay generación específica, puede ver si es suya o es PM/superadmin
        if ($generacion) {
            return $generacion->user_id === $user->id 
                || $user->hasRole(['pm', 'superadmin']);
        }

        return true;
    }

    /**
     * Determine if the user can manage prompts.
     */
    public function managePrompts(User $user): bool
    {
        return $user->can('ia.manage_prompts');
    }

    /**
     * Determine if the user can create prompt.
     */
    public function createPrompt(User $user): bool
    {
        return $this->managePrompts($user);
    }

    /**
     * Determine if the user can update prompt.
     */
    public function updatePrompt(User $user, IaPrompt $prompt): bool
    {
        return $this->managePrompts($user);
    }

    /**
     * Determine if the user can delete prompt.
     */
    public function deletePrompt(User $user, IaPrompt $prompt): bool
    {
        return $this->managePrompts($user);
    }
}
