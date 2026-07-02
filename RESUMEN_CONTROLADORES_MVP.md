# Resumen: Controladores y Form Requests MVP Fase 1

## Archivos Creados

### Controllers (9 archivos)
1. `app/Http/Controllers/SistemaController.php`
2. `app/Http/Controllers/ProyectoController.php`
3. `app/Http/Controllers/TareaController.php`
4. `app/Http/Controllers/PlantillaDocumentoController.php`
5. `app/Http/Controllers/DocumentoController.php`
6. `app/Http/Controllers/ReunionController.php`
7. `app/Http/Controllers/AcuerdoController.php`
8. `app/Http/Controllers/WorklogController.php`
9. `app/Http/Controllers/ComentarioController.php`

### Form Requests (17 archivos)
1. `app/Http/Requests/StoreSistemaRequest.php`
2. `app/Http/Requests/UpdateSistemaRequest.php`
3. `app/Http/Requests/StoreProyectoRequest.php`
4. `app/Http/Requests/UpdateProyectoRequest.php`
5. `app/Http/Requests/UpdateProyectoMembersRequest.php`
6. `app/Http/Requests/StoreTareaRequest.php`
7. `app/Http/Requests/UpdateTareaRequest.php`
8. `app/Http/Requests/MoveTareaStateRequest.php`
9. `app/Http/Requests/AssignTareaRequest.php`
10. `app/Http/Requests/PlanTareaDatesRequest.php`
11. `app/Http/Requests/StorePlantillaDocumentoRequest.php`
12. `app/Http/Requests/UpdatePlantillaDocumentoRequest.php`
13. `app/Http/Requests/StoreDocumentoRequest.php`
14. `app/Http/Requests/UpdateDocumentoRequest.php`
15. `app/Http/Requests/AddDocumentoVersionRequest.php`
16. `app/Http/Requests/StoreReunionRequest.php`
17. `app/Http/Requests/UpdateReunionRequest.php`
18. `app/Http/Requests/StoreAcuerdoRequest.php`
19. `app/Http/Requests/UpdateAcuerdoRequest.php`
20. `app/Http/Requests/ConvertAcuerdoToTaskRequest.php`
21. `app/Http/Requests/StoreWorklogRequest.php`
22. `app/Http/Requests/UpdateWorklogRequest.php`
23. `app/Http/Requests/StoreComentarioRequest.php`

## Rutas Completas (routes/web_mvp.php)

```php
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Sistemas
    Route::resource('sistemas', SistemaController::class);
    
    // Proyectos
    Route::resource('proyectos', ProyectoController::class);
    Route::get('proyectos/{proyecto}/members', [ProyectoController::class, 'members'])
        ->name('proyectos.members');
    Route::put('proyectos/{proyecto}/members', [ProyectoController::class, 'updateMembers'])
        ->name('proyectos.update-members');
    
    // Tareas
    Route::resource('tareas', TareaController::class);
    Route::get('proyectos/{proyecto}/kanban', [TareaController::class, 'kanban'])
        ->name('tareas.kanban');
    Route::post('tareas/{tarea}/move-state', [TareaController::class, 'moveState'])
        ->name('tareas.move-state');
    Route::post('tareas/{tarea}/assign', [TareaController::class, 'assign'])
        ->name('tareas.assign');
    Route::post('tareas/{tarea}/plan-dates', [TareaController::class, 'planDates'])
        ->name('tareas.plan-dates');
    
    // Plantillas de Documentos
    Route::resource('plantillas-documento', PlantillaDocumentoController::class);
    
    // Documentos
    Route::resource('documentos', DocumentoController::class);
    Route::get('documentos/create-from-template/{plantilla}/{sistema}', 
        [DocumentoController::class, 'createFromTemplate'])
        ->name('documentos.create-from-template');
    Route::post('documentos/{documento}/add-version', [DocumentoController::class, 'addVersion'])
        ->name('documentos.add-version');
    Route::post('documentos/{documento}/publish', [DocumentoController::class, 'publish'])
        ->name('documentos.publish');
    Route::get('documentos/{documento}/version/{version}', [DocumentoController::class, 'showVersion'])
        ->name('documentos.show-version');
    
    // Reuniones
    Route::resource('reuniones', ReunionController::class);
    
    // Acuerdos
    Route::resource('acuerdos', AcuerdoController::class);
    Route::post('acuerdos/{acuerdo}/to-task', [AcuerdoController::class, 'toTask'])
        ->name('acuerdos.to-task');
    
    // Worklogs
    Route::resource('worklogs', WorklogController::class);
    
    // Comentarios
    Route::post('comentarios', [ComentarioController::class, 'store'])
        ->name('comentarios.store');
    Route::put('comentarios/{comentario}', [ComentarioController::class, 'update'])
        ->name('comentarios.update');
    Route::delete('comentarios/{comentario}', [ComentarioController::class, 'destroy'])
        ->name('comentarios.destroy');
});
```

## Características Implementadas

### Scopes en Controllers
- **Superadmin**: Ve todo (sin filtros)
- **PM**: Ve recursos de proyectos donde `rol_en_proyecto = 'pm'`
- **Dev/QA/Soporte**: Ve recursos de proyectos donde son miembros activos
- **Consulta**: Solo documentos publicados

### Validaciones Específicas
- **Soporte**: Solo puede crear tareas tipo `soporte`
- **QA**: Solo puede mover tareas a `en_revision` o `listo_release`
- **Soporte**: Solo puede mover hasta `en_revision`
- **Dev**: No puede cerrar tareas
- **PM**: Puede asignar, planear fechas, publicar documentos

### Transacciones
- `ReunionController::store()` - Crear reunión + asistentes
- `ReunionController::update()` - Actualizar reunión + asistentes
- `ProyectoController::updateMembers()` - Sincronizar miembros
- `DocumentoController::publish()` - Publicar + crear versión
- `AcuerdoController::toTask()` - Convertir acuerdo a tarea + marcar cumplido

### Búsquedas y Filtros
- Búsqueda por parámetro `q` en todos los `index()`
- Paginación de 15 elementos
- Filtros por estatus, tipo, prioridad, etc.
- `withQueryString()` para mantener filtros en paginación

### Mensajes Flash
- `->with('success', '...')` para operaciones exitosas
- `->withErrors(...)` para errores de validación
