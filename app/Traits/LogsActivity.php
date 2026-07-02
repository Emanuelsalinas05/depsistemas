<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait LogsActivity
{
    /**
     * Registrar actividad en el log
     */
    protected function logActivity(string $description, string $event = 'updated', array $properties = []): void
    {
        $logData = [
            'description' => $description,
            'event' => $event,
            'subject_type' => get_class($this),
            'subject_id' => $this->id,
            'causer_type' => Auth::check() ? get_class(Auth::user()) : null,
            'causer_id' => Auth::id(),
            'properties' => $properties,
        ];

        // Si tienes Spatie ActivityLog instalado, usarías:
        // activity()
        //     ->performedOn($this)
        //     ->causedBy(Auth::user())
        //     ->withProperties($properties)
        //     ->log($description);

        // Por ahora, solo log a archivo
        Log::channel('single')->info('Activity Log', $logData);
    }
}
