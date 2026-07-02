<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignTareaRequest;
use App\Http\Requests\MoveTareaStateRequest;
use App\Http\Requests\PlanTareaDatesRequest;
use App\Http\Requests\StoreTareaRequest;
use App\Http\Requests\UpdateTareaRequest;
use App\Models\Proyecto;
use App\Models\Tarea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Tarea::class);

        $query = Tarea::query();

        // Scope: filtrar por membresía si no es superadmin
        if (!$request->user()->hasRole('superadmin')) {
            $query->whereHas('proyecto.miembros', function ($q) use ($request) {
                $q->where('users.id', $request->user()->id)
                  ->where('proyecto_miembros.asignacion_activa', true);
            });
        }

        // Búsqueda
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        // Filtros
        if ($request->filled('proyecto_id')) {
            $query->where('proyecto_id', $request->proyecto_id);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('prioridad')) {
            $query->where('prioridad', $request->prioridad);
        }

        if ($request->filled('asignado_a')) {
            $query->where('asignado_a', $request->asignado_a);
        }

        $tareas = $query->with(['proyecto', 'asignadoA', 'creador'])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('tareas.index', compact('tareas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Tarea::class);

        $proyectos = $this->getAvailableProyectos();
        $usuarios = \App\Models\User::orderBy('name')->get();

        return view('tareas.create', compact('proyectos', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTareaRequest $request): RedirectResponse
    {
        $tarea = Tarea::create($request->validated());

        return redirect()
            ->route('tareas.show', $tarea)
            ->with('success', 'Tarea creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarea $tarea): View
    {
        $this->authorize('view', $tarea);

        $tarea->load([
            'proyecto.sistema',
            'asignadoA',
            'etiquetas',
            'comentarios.user',
            'checklists.items',
            'worklogs' => function ($q) {
                $q->latest()->limit(10);
            },
            'dependencias',
            'dependientes',
        ]);

        return view('tareas.show', compact('tarea'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarea $tarea): View
    {
        $this->authorize('update', $tarea);

        $proyectos = $this->getAvailableProyectos();
        $usuarios = \App\Models\User::orderBy('name')->get();

        return view('tareas.edit', compact('tarea', 'proyectos', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTareaRequest $request, Tarea $tarea): RedirectResponse
    {
        $tarea->update($request->validated());

        return redirect()
            ->route('tareas.show', $tarea)
            ->with('success', 'Tarea actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarea $tarea): RedirectResponse
    {
        $this->authorize('delete', $tarea);

        $tarea->delete();

        return redirect()
            ->route('tareas.index')
            ->with('success', 'Tarea eliminada exitosamente.');
    }

    /**
     * Vista Kanban del proyecto.
     */
    public function kanban(Proyecto $proyecto): View
    {
        $this->authorize('view', $proyecto);

        $tareas = $proyecto->tareas()
            ->with(['asignadoA', 'etiquetas', 'comentarios', 'worklogs'])
            ->orderBy('prioridad', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tareas.kanban', compact('proyecto', 'tareas'));
    }

    /**
     * Mover estado de la tarea (Kanban).
     */
    public function moveState(MoveTareaStateRequest $request, Tarea $tarea)
    {
        $tarea->update(['estado' => $request->estado]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Estado actualizado exitosamente.']);
        }

        return redirect()
            ->back()
            ->with('success', 'Estado de la tarea actualizado exitosamente.');
    }

    /**
     * Asignar responsable a la tarea.
     */
    public function assign(AssignTareaRequest $request, Tarea $tarea): RedirectResponse
    {
        $tarea->update(['asignado_a' => $request->asignado_a]);

        return redirect()
            ->route('tareas.show', $tarea)
            ->with('success', 'Tarea asignada exitosamente.');
    }

    /**
     * Planear fechas de la tarea.
     */
    public function planDates(PlanTareaDatesRequest $request, Tarea $tarea): RedirectResponse
    {
        $tarea->update($request->only(['fecha_inicio', 'fecha_fin']));

        return redirect()
            ->route('tareas.show', $tarea)
            ->with('success', 'Fechas de la tarea actualizadas exitosamente.');
    }

    /**
     * Obtener proyectos disponibles según scope.
     */
    private function getAvailableProyectos()
    {
        $user = request()->user();

        if ($user->hasRole('superadmin')) {
            return Proyecto::orderBy('nombre')->get();
        }

        // Solo proyectos donde es miembro
        return $user->proyectos()
            ->where('proyecto_miembros.asignacion_activa', true)
            ->orderBy('nombre')
            ->get();
    }
}
