<?php

namespace App\Http\Controllers;

use App\Models\Acuerdo;
use App\Models\Proyecto;
use App\Models\Tarea;
use App\Models\User;
use App\Models\Worklog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    /**
     * Mostrar índice de reportes
     */
    public function index()
    {
        $this->authorize('reportes.view');

        return view('reportes.index');
    }

    /**
     * Reporte: Carga por desarrollador
     */
    public function cargaPorDev(Request $request)
    {
        $this->authorize('reportes.view');

        $fechaInicio = $request->input('fecha_inicio', now()->startOfWeek()->toDateString());
        $fechaFin = $request->input('fecha_fin', now()->endOfWeek()->toDateString());

        // Obtener usuarios con rol dev
        $devs = User::role('dev')->get();

        $carga = [];
        foreach ($devs as $dev) {
            // Tareas en curso
            $tareasEnCurso = Tarea::where('asignado_a', $dev->id)
                ->whereIn('estado', ['nuevo', 'en_curso', 'en_revision'])
                ->count();

            // Worklogs de la semana
            $worklogsSemana = Worklog::where('user_id', $dev->id)
                ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                ->sum('minutos');

            // Horas trabajadas
            $horasTrabajadas = round($worklogsSemana / 60, 2);

            $carga[] = [
                'usuario' => $dev,
                'tareas_en_curso' => $tareasEnCurso,
                'horas_trabajadas' => $horasTrabajadas,
                'minutos_trabajados' => $worklogsSemana,
            ];
        }

        return view('reportes.carga-por-dev', compact('carga', 'fechaInicio', 'fechaFin'));
    }

    /**
     * Reporte: Acuerdos vencidos por proyecto
     */
    public function acuerdosVencidos(Request $request)
    {
        $this->authorize('reportes.view');

        $proyectoId = $request->input('proyecto_id');

        $query = Acuerdo::where('estatus', '!=', 'cumplido')
            ->where('estatus', '!=', 'cancelado')
            ->whereNotNull('fecha_compromiso')
            ->where('fecha_compromiso', '<', now()->toDateString())
            ->with(['proyecto', 'responsable']);

        if ($proyectoId) {
            $query->where('proyecto_id', $proyectoId);
        }

        // Filtrar por scope del usuario
        $user = auth()->user();
        if (!$user->hasRole('superadmin')) {
            $proyectosIds = $user->proyectos()
                ->where('proyecto_miembros.asignacion_activa', true)
                ->pluck('proyectos.id');
            
            $query->whereIn('proyecto_id', $proyectosIds);
        }

        $acuerdos = $query->orderBy('fecha_compromiso', 'asc')->get();

        $proyectos = Proyecto::activos()->get();

        return view('reportes.acuerdos-vencidos', compact('acuerdos', 'proyectos', 'proyectoId'));
    }

    /**
     * Reporte: Mi Gantt (tareas del usuario)
     */
    public function miGantt()
    {
        $this->authorize('tareas.viewAny');

        $user = auth()->user();

        $tareas = Tarea::where('asignado_a', $user->id)
            ->whereNotNull('fecha_inicio')
            ->whereNotNull('fecha_fin')
            ->with(['proyecto', 'asignadoA'])
            ->orderBy('fecha_inicio', 'asc')
            ->get();

        return view('reportes.mi-gantt', compact('tareas'));
    }

    /**
     * Reporte: Gantt por proyecto
     */
    public function ganttProyecto(Proyecto $proyecto)
    {
        $this->authorize('view', $proyecto);

        $tareas = $proyecto->tareas()
            ->whereNotNull('fecha_inicio')
            ->whereNotNull('fecha_fin')
            ->with(['asignadoA'])
            ->orderBy('fecha_inicio', 'asc')
            ->get();

        return view('reportes.gantt-proyecto', compact('proyecto', 'tareas'));
    }
}
