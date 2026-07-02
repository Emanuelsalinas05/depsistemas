<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSistemaRequest;
use App\Http\Requests\UpdateSistemaRequest;
use App\Models\Sistema;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SistemaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Sistema::class);

        $query = Sistema::query();

        // Scope: filtrar por membresía si no es superadmin
        if (!$request->user()->hasRole('superadmin')) {
            $query->whereHas('proyectos.miembros', function ($q) use ($request) {
                $q->where('users.id', $request->user()->id)
                  ->where('proyecto_miembros.asignacion_activa', true);
            });
        }

        // Búsqueda
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('area_usuaria', 'like', "%{$search}%");
            });
        }

        // Filtros
        if ($request->filled('estatus')) {
            $query->where('estatus', $request->estatus);
        }

        if ($request->filled('criticidad')) {
            $query->where('criticidad', $request->criticidad);
        }

        $sistemas = $query->with(['creador', 'actualizador'])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('sistemas.index', compact('sistemas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', Sistema::class);

        return view('sistemas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSistemaRequest $request): RedirectResponse
    {
        $sistema = Sistema::create($request->validated());

        return redirect()
            ->route('sistemas.show', $sistema)
            ->with('success', 'Sistema creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sistema $sistema): View
    {
        $this->authorize('view', $sistema);

        $sistema->load([
            'proyectos' => function ($q) {
                $q->latest()->limit(10);
            },
            'ambientes',
            'tecnologias',
            'releases' => function ($q) {
                $q->latest()->limit(5);
            },
            'documentos' => function ($q) {
                $q->latest()->limit(5);
            },
        ]);

        return view('sistemas.show', compact('sistema'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sistema $sistema): View
    {
        $this->authorize('update', $sistema);

        return view('sistemas.edit', compact('sistema'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSistemaRequest $request, Sistema $sistema): RedirectResponse
    {
        $sistema->update($request->validated());

        return redirect()
            ->route('sistemas.show', $sistema)
            ->with('success', 'Sistema actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sistema $sistema): RedirectResponse
    {
        $this->authorize('delete', $sistema);

        $sistema->delete();

        return redirect()
            ->route('sistemas.index')
            ->with('success', 'Sistema eliminado exitosamente.');
    }
}
