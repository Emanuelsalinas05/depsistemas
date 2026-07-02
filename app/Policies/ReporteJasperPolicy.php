<?php

namespace App\Policies;

use App\Models\ReporteJasper;
use App\Models\User;

class ReporteJasperPolicy
{
    /**
     * Determine if the user can view any reportes.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('jasper.view');
    }

    /**
     * Determine if the user can view the reporte.
     */
    public function view(User $user, ReporteJasper $reporte): bool
    {
        return $user->can('jasper.view');
    }

    /**
     * Determine if the user can manage reportes.
     */
    public function manage(User $user): bool
    {
        return $user->can('jasper.manage');
    }

    /**
     * Determine if the user can run the reporte.
     */
    public function run(User $user, ReporteJasper $reporte): bool
    {
        return $user->can('jasper.run');
    }

    /**
     * Determine if the user can export reportes.
     */
    public function export(User $user, ReporteJasper $reporte): bool
    {
        return $user->can('jasper.export');
    }
}
