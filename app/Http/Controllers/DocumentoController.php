<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddDocumentoVersionRequest;
use App\Http\Requests\StoreDocumentoRequest;
use App\Http\Requests\UpdateDocumentoRequest;
use App\Models\Documento;
use App\Models\DocumentoVersion;
use App\Models\PlantillaDocumento;
use App\Models\Sistema;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Documento::class);

        $query = Documento::query();

        // Scope: filtrar por membresía si no es superadmin
        if (!$request->user()->hasRole('superadmin')) {
            // Consulta solo ve publicados
            if ($request->user()->hasRole('consulta')) {
                $query->where('estado', 'publicado');
            } else {
                // Otros roles ven publicados + borradores de sus sistemas
                $query->where(function ($q) use ($request) {
                    $q->where('estado', 'publicado')
                      ->orWhereHas('sistema.proyectos.miembros', function ($subQ) use ($request) {
                          $subQ->where('users.id', $request->user()->id)
                               ->where('proyecto_miembros.asignacion_activa', true);
                      });
                });
            }
        }

        // Búsqueda
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%");
            });
        }

        // Filtros
        if ($request->filled('sistema_id')) {
            $query->where('sistema_id', $request->sistema_id);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $documentos = $query->with(['sistema', 'release', 'creador'])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('documentos.index', compact('documentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Documento::class);

        $sistemas = $this->getAvailableSistemas();
        $releases = \App\Models\Release::orderBy('version', 'desc')->get();
        $plantillas = PlantillaDocumento::where('activa', true)->orderBy('nombre')->get();

        return view('documentos.create', compact('sistemas', 'releases', 'plantillas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentoRequest $request): RedirectResponse
    {
        $documento = Documento::create($request->validated());

        return redirect()
            ->route('documentos.show', $documento)
            ->with('success', 'Documento creado exitosamente.');
    }

    /**
     * Crear documento desde plantilla.
     */
    public function createFromTemplate(PlantillaDocumento $plantilla, Sistema $sistema): View
    {
        $this->authorize('create', Documento::class);
        $this->authorize('view', $sistema);

        $releases = $sistema->releases()->orderBy('version', 'desc')->get();

        return view('documentos.create-from-template', compact('plantilla', 'sistema', 'releases'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Documento $documento): View
    {
        $this->authorize('view', $documento);

        $documento->load([
            'sistema',
            'release',
            'versiones' => function ($q) {
                $q->latest('created_at');
            },
            'etiquetas',
            'comentarios.user',
            'checklists.items',
        ]);

        return view('documentos.show', compact('documento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Documento $documento): View
    {
        $this->authorize('update', $documento);

        $releases = $documento->sistema->releases()->orderBy('version', 'desc')->get();

        return view('documentos.edit', compact('documento', 'releases'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocumentoRequest $request, Documento $documento): RedirectResponse
    {
        $documento->update($request->validated());

        return redirect()
            ->route('documentos.show', $documento)
            ->with('success', 'Documento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Documento $documento): RedirectResponse
    {
        $this->authorize('delete', $documento);

        $documento->delete();

        return redirect()
            ->route('documentos.index')
            ->with('success', 'Documento eliminado exitosamente.');
    }

    /**
     * Agregar versión al documento.
     */
    public function addVersion(AddDocumentoVersionRequest $request, Documento $documento): RedirectResponse
    {
        DocumentoVersion::create([
            'documento_id' => $documento->id,
            'version' => $request->version,
            'contenido' => $request->contenido,
            'archivo_path' => $request->archivo_path,
            'mermaid_source' => $request->mermaid_source,
            'created_by' => $request->user()->id,
            'created_at' => now(),
        ]);

        return redirect()
            ->route('documentos.show', $documento)
            ->with('success', 'Versión agregada exitosamente.');
    }

    /**
     * Publicar documento.
     */
    public function publish(Request $request, Documento $documento): RedirectResponse
    {
        $this->authorize('publish', $documento);

        DB::transaction(function () use ($request, $documento) {
            // Crear versión final antes de publicar
            $ultimaVersion = $documento->versiones()->latest('created_at')->first();
            
            if (!$ultimaVersion) {
                // Si no hay versión, crear una con el contenido actual
                DocumentoVersion::create([
                    'documento_id' => $documento->id,
                    'version' => '1.0.0',
                    'contenido' => '',
                    'created_by' => $request->user()->id,
                    'created_at' => now(),
                ]);
            }

            // Cambiar estado a publicado
            $documento->update(['estado' => 'publicado']);
        });

        return redirect()
            ->route('documentos.show', $documento)
            ->with('success', 'Documento publicado exitosamente.');
    }

    /**
     * Mostrar versión específica del documento.
     */
    public function showVersion(Documento $documento, DocumentoVersion $version): View
    {
        $this->authorize('view', $documento);

        // Verificar que la versión pertenece al documento
        if ($version->documento_id !== $documento->id) {
            abort(404);
        }

        $documento->load(['sistema', 'release']);

        return view('documentos.show-version', compact('documento', 'version'));
    }

    /**
     * Obtener sistemas disponibles según scope.
     */
    private function getAvailableSistemas()
    {
        $user = request()->user();

        if ($user->hasRole('superadmin')) {
            return Sistema::orderBy('nombre')->get();
        }

        // Solo sistemas donde es miembro
        return Sistema::whereHas('proyectos.miembros', function ($q) use ($user) {
            $q->where('users.id', $user->id)
              ->where('proyecto_miembros.asignacion_activa', true);
        })->orderBy('nombre')->get();
    }
}
