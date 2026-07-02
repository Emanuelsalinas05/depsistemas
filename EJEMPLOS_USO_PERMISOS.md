# Ejemplos de Uso de Permisos y Policies

## En Rutas (Middleware)

```php
// routes/web.php

use Illuminate\Support\Facades\Route;

// Ver sistemas (requiere permiso)
Route::get('/sistemas', [SistemaController::class, 'index'])
    ->middleware('can:sistemas.viewAny');

// Crear sistema (requiere permiso)
Route::post('/sistemas', [SistemaController::class, 'store'])
    ->middleware('can:sistemas.create');

// Actualizar sistema (requiere permiso + policy)
Route::put('/sistemas/{sistema}', [SistemaController::class, 'update'])
    ->middleware('can:sistemas.update');

// Publicar documento (acción fina)
Route::post('/documentos/{documento}/publish', [DocumentoController::class, 'publish'])
    ->middleware('can:docs.publish');

// Asignar tarea (acción fina)
Route::post('/tareas/{tarea}/assign', [TareaController::class, 'assign'])
    ->middleware('can:tareas.assign');

// Mover estado de tarea (acción fina)
Route::post('/tareas/{tarea}/move-state', [TareaController::class, 'moveState'])
    ->middleware('can:tareas.move_state');
```

## En Controladores (authorize)

```php
// app/Http/Controllers/TareaController.php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function index()
    {
        // Verificar permiso
        $this->authorize('viewAny', Tarea::class);
        
        // Lógica...
    }

    public function store(Request $request)
    {
        // Verificar permiso
        $this->authorize('create', Tarea::class);
        
        // Validar que el proyecto existe y el usuario es miembro
        $proyecto = Proyecto::findOrFail($request->proyecto_id);
        $this->authorize('view', $proyecto);
        
        // Lógica...
    }

    public function update(Request $request, Tarea $tarea)
    {
        // Verificar permiso + policy (alcance)
        $this->authorize('update', $tarea);
        
        // Lógica...
    }

    public function assign(Request $request, Tarea $tarea)
    {
        // Verificar permiso de acción fina
        $this->authorize('assign', $tarea);
        
        // Lógica...
    }

    public function moveState(Request $request, Tarea $tarea)
    {
        // Verificar permiso + validar estado permitido
        $nuevoEstado = $request->estado;
        $this->authorize('moveState', [$tarea, $nuevoEstado]);
        
        // Lógica...
    }
}
```

## En Blade (Directivas)

```blade
{{-- Verificar permiso --}}
@can('sistemas.viewAny')
    <a href="{{ route('sistemas.index') }}">Sistemas</a>
@endcan

{{-- Verificar policy --}}
@can('update', $sistema)
    <a href="{{ route('sistemas.edit', $sistema) }}">Editar</a>
@endcan

{{-- Verificar acción fina --}}
@can('docs.publish', $documento)
    <form action="{{ route('documentos.publish', $documento) }}" method="POST">
        @csrf
        <button type="submit">Publicar</button>
    </form>
@endcan

{{-- Verificar rol --}}
@role('pm')
    <p>Eres Project Manager</p>
@endrole

{{-- Verificar múltiples roles --}}
@hasanyrole('pm|dev')
    <p>Eres PM o Dev</p>
@endhasanyrole
```

## En Requests (Form Requests)

```php
// app/Http/Requests/StoreTareaRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTareaRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Verificar permiso
        return $this->user()->can('tareas.create');
    }

    public function rules(): array
    {
        return [
            'proyecto_id' => 'required|exists:proyectos,id',
            'titulo' => 'required|string|max:255',
            // ...
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Verificar que el usuario es miembro del proyecto
            $proyecto = Proyecto::find($this->proyecto_id);
            if ($proyecto && !$this->user()->proyectos()->where('proyectos.id', $proyecto->id)->exists()) {
                $validator->errors()->add('proyecto_id', 'No eres miembro de este proyecto.');
            }

            // Soporte solo puede crear tareas tipo soporte
            if ($this->user()->hasRole('soporte') && $this->tipo !== 'soporte') {
                $validator->errors()->add('tipo', 'Solo puedes crear tareas de tipo soporte.');
            }
        });
    }
}
```

## Verificaciones Programáticas

```php
// Verificar permiso
if ($user->can('tareas.assign')) {
    // ...
}

// Verificar policy
if ($user->can('update', $tarea)) {
    // ...
}

// Verificar rol
if ($user->hasRole('pm')) {
    // ...
}

// Verificar múltiples permisos
if ($user->hasAnyPermission(['tareas.create', 'tareas.update'])) {
    // ...
}

// Verificar todos los permisos
if ($user->hasAllPermissions(['tareas.create', 'tareas.update'])) {
    // ...
}

// Obtener rol en proyecto
$rolEnProyecto = $user->proyectos()
    ->where('proyectos.id', $proyecto->id)
    ->first()
    ->pivot
    ->rol_en_proyecto;
```

## Scopes en Queries

```php
// Filtrar por permisos en queries
$tareas = Tarea::query()
    ->when(!auth()->user()->hasRole('superadmin'), function ($q) {
        // Solo tareas de proyectos donde es miembro
        $q->whereHas('proyecto.miembros', function ($query) {
            $query->where('users.id', auth()->id());
        });
    })
    ->get();

// Filtrar documentos publicados para consulta
$documentos = Documento::query()
    ->when(auth()->user()->hasRole('consulta'), function ($q) {
        $q->where('estado', 'publicado');
    })
    ->get();
```
