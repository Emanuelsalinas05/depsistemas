<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConvertAcuerdoToTaskRequest;
use App\Http\Requests\StoreAcuerdoRequest;
use App\Http\Requests\UpdateAcuerdoRequest;
use App\Models\Acuerdo;
use App\Models\Tarea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AcuerdoController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Acuerdo::class);

        $query = Acuerdo::query();

        if (!$request->user()->hasRole('superadmin')) {
            $query->where(function ($q) use ($request) {
                $q->where('responsable_id', $request->user()->id)
                  ->orWhereHas('proyecto.miembros', function ($subQ) use ($request) {
                      $subQ->where('users.id', $request->user()->id)
                           ->where('proyecto_miembros.asignacion_activa', true);
                  });
            });
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where('titulo', 'like', "%{$search}%");
        }

        if ($request->filled('estatus')) {
            $query->where('estatus', $request->estatus);
        }

        if ($request->filled('proyecto_id')) {
            $query->where('proyecto_id', $request->proyecto_id);
        }

        $acuerdos = $query->with(['reunion', 'proyecto', 'responsable'])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('acuerdos.index', compact('acuerdos'));
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Acuerdo::class);

        $reuniones = $this->getAvailableReuniones();
        $proyectos = $this->getAvailableProyectos();
        $usuarios = \App\Models\User::orderBy('name')->get();

        return view('acuerdos.create', compact('reuniones', 'proyectos', 'usuarios'));
    }

    public function store(StoreAcuerdoRequest $request): RedirectResponse
    {
        Acuerdo::create($request->validated());

        return redirect()
            ->route('acuerdos.index')
            ->with('success', 'Acuerdo creado exitosamente.');
    }

    public function show(Acuerdo $acuerdo): View
    {
        $this->authorize('view', $acuerdo);

        $acuerdo->load([
            'reunion',
            'proyecto',
            'responsable',
            'comentarios.user',
        ]);

        return view('acuerdos.show', compact('acuerdo'));
    }

    public function edit(Acuerdo $acuerdo): View
    {
        $this->authorize('update', $acuerdo);

        $usuarios = \App\Models\User::orderBy('name')->get();

        return view('acuerdos.edit', compact('acuerdo', 'usuarios'));
    }

    public function update(UpdateAcuerdoRequest $request, Acuerdo $acuerdo): RedirectResponse
    {
        $acuerdo->update($request->validated());

        return redirect()
            ->route('acuerdos.show', $acuerdo)
            ->with('success', 'Acuerdo actualizado exitosamente.');
    }

    public function destroy(Acuerdo $acuerdo): RedirectResponse
    {
        $this->authorize('delete', $acuerdo);

        $acuerdo->delete();

        return redirect()
            ->route('acuerdos.index')
            ->with('success', 'Acuerdo eliminado exitosamente.');
    }

    public function toTask(ConvertAcuerdoToTaskRequest $request, Acuerdo $acuerdo): RedirectResponse
    {
        if (!$acuerdo->proyecto_id) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'El acuerdo debe estar asociado a un proyecto para convertirlo en tarea.']);
        }

        $this->authorize('view', $acuerdo->proyecto);

        DB::transaction(function () use ($request, $acuerdo) {
            $tarea = Tarea::create([
                'proyecto_id' => $acuerdo->proyecto_id,
                'titulo' => $acuerdo->titulo,
                'descripcion' => $acuerdo->detalle,
                'tipo' => $request->tipo,
                'prioridad' => $request->prioridad,
                'estado' => 'nuevo',
                'asignado_a' => $acuerdo->responsable_id,
                'fecha_inicio' => $acuerdo->fecha_compromiso,
                'created_by' => $request->user()->id,
            ]);

            // Marcar acuerdo como cumplido
            $acuerdo->update(['estatus' => 'cumplido']);
        });

        return redirect()
            ->route('tareas.index')
            ->with('success', 'Acuerdo convertido a tarea exitosamente.');
    }

    private function getAvailableReuniones()
    {
        $user = request()->user();

        if ($user->hasRole('superadmin')) {
            return \App\Models\Reunion::orderBy('fecha_inicio', 'desc')->get();
        }

        return \App\Models\Reunion::whereHas('asistentes', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->orWhereHas('proyecto.miembros', function ($q) use ($user) {
            $q->where('users.id', $user->id)
              ->where('proyecto_miembros.asignacion_activa', true);
        })->orderBy('fecha_inicio', 'desc')->get();
    }

    private function getAvailableProyectos()
    {
        $user = request()->user();

        if ($user->hasRole('superadmin')) {
            return \App\Models\Proyecto::orderBy('nombre')->get();
        }

        return $user->proyectos()
            ->where('proyecto_miembros.asignacion_activa', true)
            ->orderBy('nombre')
            ->get();
    }
}
