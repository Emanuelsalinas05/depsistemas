<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlantillaDocumentoRequest;
use App\Http\Requests\UpdatePlantillaDocumentoRequest;
use App\Models\PlantillaDocumento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlantillaDocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view', PlantillaDocumento::class);

        $query = PlantillaDocumento::query();

        // Búsqueda
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where('nombre', 'like', "%{$search}%");
        }

        // Filtros
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('activa')) {
            $query->where('activa', $request->activa);
        }

        $plantillas = $query->latest()->paginate(15)->withQueryString();

        return view('plantillas.index', compact('plantillas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('manage', PlantillaDocumento::class);

        return view('plantillas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlantillaDocumentoRequest $request): RedirectResponse
    {
        PlantillaDocumento::create($request->validated());

        return redirect()
            ->route('plantillas-documento.index')
            ->with('success', 'Plantilla creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PlantillaDocumento $plantillaDocumento): View
    {
        if (!request()->user()->can('plantillas.view')) {
            abort(403);
        }

        return view('plantillas.show', compact('plantillaDocumento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlantillaDocumento $plantillaDocumento): View
    {
        $this->authorize('manage', PlantillaDocumento::class);

        return view('plantillas.edit', compact('plantillaDocumento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlantillaDocumentoRequest $request, PlantillaDocumento $plantillaDocumento): RedirectResponse
    {
        $plantillaDocumento->update($request->validated());

        return redirect()
            ->route('plantillas-documento.show', $plantillaDocumento)
            ->with('success', 'Plantilla actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlantillaDocumento $plantillaDocumento): RedirectResponse
    {
        $this->authorize('manage', PlantillaDocumento::class);

        $plantillaDocumento->delete();

        return redirect()
            ->route('plantillas-documento.index')
            ->with('success', 'Plantilla eliminada exitosamente.');
    }
}
