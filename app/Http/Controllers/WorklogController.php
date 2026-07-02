<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorklogRequest;
use App\Http\Requests\UpdateWorklogRequest;
use App\Models\Worklog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WorklogController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Worklog::class);

        $query = Worklog::query();

        // Scope: dev solo ve sus worklogs, PM ve todos de su proyecto
        if ($request->user()->hasRole('dev')) {
            $query->where('user_id', $request->user()->id);
        } elseif ($request->user()->hasRole('pm') && !$request->user()->hasRole('superadmin')) {
            $query->whereHas('tarea.proyecto.miembros', function ($q) use ($request) {
                $q->where('users.id', $request->user()->id)
                  ->where('proyecto_miembros.rol_en_proyecto', 'pm')
                  ->where('proyecto_miembros.asignacion_activa', true);
            });
        }

        if ($request->filled('proyecto_id')) {
            $query->whereHas('tarea', function ($q) use ($request) {
                $q->where('proyecto_id', $request->proyecto_id);
            });
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('fecha_desde')) {
            $query->where('fecha', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->where('fecha', '<=', $request->fecha_hasta);
        }

        $worklogs = $query->with(['tarea.proyecto', 'user'])
            ->latest('fecha')
            ->paginate(15)
            ->withQueryString();

        return view('worklogs.index', compact('worklogs'));
    }

    public function myWeek(Request $request): View
    {
        $this->authorize('viewAny', Worklog::class);

        $semana = $request->input('semana', now()->format('Y-\WW'));
        $fechaInicio = \Carbon\Carbon::parse($semana)->startOfWeek();
        $fechaFin = $fechaInicio->copy()->endOfWeek();

        $worklogs = Worklog::where('user_id', $request->user()->id)
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->with(['tarea.proyecto'])
            ->get();

        return view('worklogs.my-week', compact('worklogs', 'fechaInicio', 'fechaFin'));
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Worklog::class);

        $tareas = $this->getAvailableTareas();

        return view('worklogs.create', compact('tareas'));
    }

    public function store(StoreWorklogRequest $request): RedirectResponse
    {
        Worklog::create(array_merge($request->validated(), [
            'user_id' => $request->user()->id,
        ]));

        return redirect()
            ->route('worklogs.index')
            ->with('success', 'Registro de tiempo creado exitosamente.');
    }

    public function show(Worklog $worklog): View
    {
        $this->authorize('view', $worklog);

        $worklog->load(['tarea.proyecto', 'user', 'creador']);

        return view('worklogs.show', compact('worklog'));
    }

    public function edit(Worklog $worklog): View
    {
        $this->authorize('update', $worklog);

        return view('worklogs.edit', compact('worklog'));
    }

    public function update(UpdateWorklogRequest $request, Worklog $worklog): RedirectResponse
    {
        $worklog->update($request->validated());

        return redirect()
            ->route('worklogs.show', $worklog)
            ->with('success', 'Registro de tiempo actualizado exitosamente.');
    }

    public function destroy(Worklog $worklog): RedirectResponse
    {
        $this->authorize('delete', $worklog);

        $worklog->delete();

        return redirect()
            ->route('worklogs.index')
            ->with('success', 'Registro de tiempo eliminado exitosamente.');
    }

    private function getAvailableTareas()
    {
        $user = request()->user();

        if ($user->hasRole('superadmin')) {
            return \App\Models\Tarea::orderBy('titulo')->get();
        }

        return \App\Models\Tarea::whereHas('proyecto.miembros', function ($q) use ($user) {
            $q->where('users.id', $user->id)
              ->where('proyecto_miembros.asignacion_activa', true);
        })->orderBy('titulo')->get();
    }
}
