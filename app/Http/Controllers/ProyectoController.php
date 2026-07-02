<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProyectoRequest;
use App\Http\Requests\UpdateProyectoMembersRequest;
use App\Http\Requests\UpdateProyectoRequest;
use App\Models\Proyecto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Proyecto::class);

        $query = Proyecto::query();

        // Scope: filtrar por membresía si no es superadmin
        if (!$request->user()->hasRole('superadmin')) {
            $query->whereHas('miembros', function ($q) use ($request) {
                $q->where('users.id', $request->user()->id)
                  ->where('proyecto_miembros.asignacion_activa', true);
            });
        }

        // Búsqueda
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Filtros
        if ($request->filled('estatus')) {
            $query->where('estatus', $request->estatus);
        }

        if ($request->filled('sistema_id')) {
            $query->where('sistema_id', $request->sistema_id);
        }

        $proyectos = $query->with(['sistema', 'creador', 'actualizador'])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('proyectos.index', compact('proyectos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', Proyecto::class);

        $sistemas = $this->getAvailableSistemas();

        return view('proyectos.create', compact('sistemas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProyectoRequest $request): RedirectResponse
    {
        $proyecto = Proyecto::create($request->validated());

        // Agregar creador como PM por defecto
        $proyecto->miembros()->attach($request->user()->id, [
            'rol_en_proyecto' => 'pm',
            'asignacion_activa' => true,
        ]);

        return redirect()
            ->route('proyectos.show', $proyecto)
            ->with('success', 'Proyecto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Proyecto $proyecto): View
    {
        $this->authorize('view', $proyecto);

        $proyecto->load([
            'sistema',
            'miembros' => function ($q) {
                $q->where('proyecto_miembros.asignacion_activa', true);
            },
            'tareas' => function ($q) {
                $q->latest()->limit(10);
            },
            'reuniones' => function ($q) {
                $q->latest()->limit(5);
            },
        ]);

        return view('proyectos.show', compact('proyecto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proyecto $proyecto): View
    {
        $this->authorize('update', $proyecto);

        $sistemas = $this->getAvailableSistemas();

        return view('proyectos.edit', compact('proyecto', 'sistemas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProyectoRequest $request, Proyecto $proyecto): RedirectResponse
    {
        $proyecto->update($request->validated());

        return redirect()
            ->route('proyectos.show', $proyecto)
            ->with('success', 'Proyecto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proyecto $proyecto): RedirectResponse
    {
        $this->authorize('delete', $proyecto);

        $proyecto->delete();

        return redirect()
            ->route('proyectos.index')
            ->with('success', 'Proyecto eliminado exitosamente.');
    }

    /**
     * Mostrar miembros del proyecto.
     */
    public function members(Proyecto $proyecto): View
    {
        $this->authorize('view', $proyecto);

        $proyecto->load([
            'miembros' => function ($q) {
                $q->orderBy('proyecto_miembros.rol_en_proyecto')
                  ->orderBy('users.name');
            },
        ]);

        $usuarios = \App\Models\User::orderBy('name')->get();

        return view('proyectos.members', compact('proyecto', 'usuarios'));
    }

    /**
     * Actualizar miembros del proyecto.
     */
    public function updateMembers(UpdateProyectoMembersRequest $request, Proyecto $proyecto): RedirectResponse
    {
        DB::transaction(function () use ($request, $proyecto) {
            $members = collect($request->input('members', []));
            
            $syncData = [];
            foreach ($members as $member) {
                $syncData[$member['user_id']] = [
                    'rol_en_proyecto' => $member['rol_en_proyecto'],
                    'asignacion_activa' => $member['asignacion_activa'] ?? true,
                ];
            }

            $proyecto->miembros()->sync($syncData);

            // Validar que el proyecto tenga al menos un PM activo
            $tienePM = $proyecto->miembros()
                ->where('proyecto_miembros.rol_en_proyecto', 'pm')
                ->where('proyecto_miembros.asignacion_activa', true)
                ->exists();

            if (!$tienePM) {
                throw new \InvalidArgumentException('El proyecto debe tener al menos un Project Manager (PM) activo.');
            }
        });

        return redirect()
            ->route('proyectos.members', $proyecto)
            ->with('success', 'Miembros actualizados exitosamente.');
    }

    /**
     * Obtener sistemas disponibles según scope.
     */
    private function getAvailableSistemas()
    {
        $user = request()->user();

        if ($user->hasRole('superadmin')) {
            return \App\Models\Sistema::orderBy('nombre')->get();
        }

        // Solo sistemas donde es miembro
        return \App\Models\Sistema::whereHas('proyectos.miembros', function ($q) use ($user) {
            $q->where('users.id', $user->id)
              ->where('proyecto_miembros.asignacion_activa', true);
        })->orderBy('nombre')->get();
    }
}
