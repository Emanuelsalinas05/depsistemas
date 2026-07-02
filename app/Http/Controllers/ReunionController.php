<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReunionRequest;
use App\Http\Requests\UpdateReunionRequest;
use App\Models\Proyecto;
use App\Models\Reunion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReunionController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Reunion::class);

        $query = Reunion::query();

        if (!$request->user()->hasRole('superadmin')) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('asistentes', function ($subQ) use ($request) {
                    $subQ->where('user_id', $request->user()->id);
                })->orWhereHas('proyecto.miembros', function ($subQ) use ($request) {
                    $subQ->where('users.id', $request->user()->id)
                         ->where('proyecto_miembros.asignacion_activa', true);
                });
            });
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where('titulo', 'like', "%{$search}%");
        }

        if ($request->filled('proyecto_id')) {
            $query->where('proyecto_id', $request->proyecto_id);
        }

        $reuniones = $query->with(['proyecto', 'creador'])
            ->latest('fecha_inicio')
            ->paginate(15)
            ->withQueryString();

        return view('reuniones.index', compact('reuniones'));
    }

    public function calendar(Request $request): View
    {
        $this->authorize('viewAny', Reunion::class);

        $query = Reunion::query();

        if (!$request->user()->hasRole('superadmin')) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('asistentes', function ($subQ) use ($request) {
                    $subQ->where('user_id', $request->user()->id);
                })->orWhereHas('proyecto.miembros', function ($subQ) use ($request) {
                    $subQ->where('users.id', $request->user()->id)
                         ->where('proyecto_miembros.asignacion_activa', true);
                });
            });
        }

        $reuniones = $query->with(['proyecto'])->get();

        return view('reuniones.calendar', compact('reuniones'));
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Reunion::class);

        $proyectos = $this->getAvailableProyectos();
        $usuarios = \App\Models\User::orderBy('name')->get();

        return view('reuniones.create', compact('proyectos', 'usuarios'));
    }

    public function store(StoreReunionRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $reunion = Reunion::create($request->only([
                'proyecto_id', 'titulo', 'fecha_inicio', 'fecha_fin', 'ubicacion', 'descripcion'
            ]));

            // Procesar asistentes del formulario
            if ($request->filled('asistentes')) {
                foreach ($request->asistentes as $asistente) {
                    if ($asistente['tipo'] === 'interno' && !empty($asistente['user_id'])) {
                        $reunion->asistentes()->create([
                            'user_id' => $asistente['user_id'],
                            'nombre_externo' => null,
                            'email_externo' => null,
                        ]);
                    } elseif ($asistente['tipo'] === 'externo' && !empty($asistente['nombre_externo'])) {
                        $reunion->asistentes()->create([
                            'user_id' => null,
                            'nombre_externo' => $asistente['nombre_externo'],
                            'email_externo' => $asistente['email_externo'] ?? null,
                        ]);
                    }
                }
            }
        });

        return redirect()
            ->route('reuniones.index')
            ->with('success', 'Reunión creada exitosamente.');
    }

    public function show(Reunion $reunion): View
    {
        $this->authorize('view', $reunion);

        $reunion->load([
            'proyecto',
            'asistentes.user',
            'minuta.creador',
            'acuerdos.responsable',
            'creador',
        ]);

        return view('reuniones.show', compact('reunion'));
    }

    public function edit(Reunion $reunion): View
    {
        $this->authorize('update', $reunion);

        $proyectos = $this->getAvailableProyectos();
        $usuarios = \App\Models\User::orderBy('name')->get();

        return view('reuniones.edit', compact('reunion', 'proyectos', 'usuarios'));
    }

    public function update(UpdateReunionRequest $request, Reunion $reunion): RedirectResponse
    {
        DB::transaction(function () use ($request, $reunion) {
            $reunion->update($request->only([
                'proyecto_id', 'titulo', 'fecha_inicio', 'fecha_fin', 'ubicacion', 'descripcion'
            ]));

            // Eliminar asistentes actuales
            $reunion->asistentes()->delete();

            // Agregar nuevos asistentes
            if ($request->filled('asistentes')) {
                foreach ($request->asistentes as $asistente) {
                    if ($asistente['tipo'] === 'interno' && !empty($asistente['user_id'])) {
                        $reunion->asistentes()->create([
                            'user_id' => $asistente['user_id'],
                            'nombre_externo' => null,
                            'email_externo' => null,
                        ]);
                    } elseif ($asistente['tipo'] === 'externo' && !empty($asistente['nombre_externo'])) {
                        $reunion->asistentes()->create([
                            'user_id' => null,
                            'nombre_externo' => $asistente['nombre_externo'],
                            'email_externo' => $asistente['email_externo'] ?? null,
                        ]);
                    }
                }
            }
        });

        return redirect()
            ->route('reuniones.show', $reunion)
            ->with('success', 'Reunión actualizada exitosamente.');
    }

    public function destroy(Reunion $reunion): RedirectResponse
    {
        $this->authorize('delete', $reunion);

        $reunion->delete();

        return redirect()
            ->route('reuniones.index')
            ->with('success', 'Reunión eliminada exitosamente.');
    }

    private function getAvailableProyectos()
    {
        $user = request()->user();

        if ($user->hasRole('superadmin')) {
            return Proyecto::orderBy('nombre')->get();
        }

        return $user->proyectos()
            ->where('proyecto_miembros.asignacion_activa', true)
            ->orderBy('nombre')
            ->get();
    }
}
