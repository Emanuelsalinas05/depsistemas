<?php

namespace App\Http\Controllers;

use App\Models\Acuerdo;
use App\Models\Proyecto;
use App\Models\Release;
use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        // Tareas en curso (mías)
        $tareasEnCurso = Tarea::where('asignado_a', $user->id)
            ->whereIn('estado', ['nuevo', 'en_curso', 'en_revision'])
            ->count();

        // Bloqueos (tareas sin avance X días / con dependencias)
        $bloqueos = Tarea::where('asignado_a', $user->id)
            ->whereIn('estado', ['nuevo', 'en_curso'])
            ->where(function ($q) {
                $q->whereNull('fecha_inicio')
                  ->orWhere('fecha_inicio', '<', now()->subDays(7))
                  ->orWhereHas('dependencias', function ($q2) {
                      $q2->whereIn('estado', ['nuevo', 'en_curso']);
                  });
            })
            ->count();

        // Acuerdos vencidos
        $acuerdosVencidos = Acuerdo::where('responsable_id', $user->id)
            ->where('estatus', '!=', 'cumplido')
            ->where('estatus', '!=', 'cancelado')
            ->whereNotNull('fecha_compromiso')
            ->where('fecha_compromiso', '<', now()->toDateString())
            ->count();

        // Releases del mes
        $releasesMes = Release::whereMonth('fecha_release', now()->month)
            ->whereYear('fecha_release', now()->year)
            ->count();

        // Mi agenda hoy
        $agendaHoy = collect();
        
        // Reuniones del día
        $reunionesHoy = \App\Models\Reunion::whereDate('fecha_inicio', now()->toDateString())
            ->where(function ($q) use ($user) {
                $q->whereHas('asistentes', function ($q2) use ($user) {
                    $q2->where('user_id', $user->id);
                })
                ->orWhereHas('proyecto.miembros', function ($q2) use ($user) {
                    $q2->where('users.id', $user->id)
                       ->where('proyecto_miembros.asignacion_activa', true);
                });
            })
            ->get();
        
        $agendaHoy = $agendaHoy->merge($reunionesHoy);

        // Últimos cambios (simplificado - usar ActivityLog si está disponible)
        $ultimosCambios = collect();

        // Proyectos en riesgo (solo PM)
        $proyectosRiesgo = collect();
        if ($user->hasRole(['pm', 'superadmin'])) {
            $proyectosRiesgo = Proyecto::where('estatus', 'en_progreso')
                ->whereNotNull('fecha_fin')
                ->where('fecha_fin', '<', now()->addDays(7))
                ->whereHas('miembros', function ($q) use ($user) {
                    $q->where('users.id', $user->id)
                      ->where('proyecto_miembros.rol_en_proyecto', 'pm')
                      ->where('proyecto_miembros.asignacion_activa', true);
                })
                ->limit(5)
                ->get();
        }

        return view('dashboard.index', compact(
            'tareasEnCurso',
            'bloqueos',
            'acuerdosVencidos',
            'releasesMes',
            'agendaHoy',
            'ultimosCambios',
            'proyectosRiesgo'
        ));
    }
}
