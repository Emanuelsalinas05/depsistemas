<?php

use App\Http\Controllers\AcuerdoController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\PlantillaDocumentoController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\ReunionController;
use App\Http\Controllers\SistemaController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\WorklogController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas MVP Fase 1 - Sistema de Gestión de Desarrollos
|--------------------------------------------------------------------------
*/

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
    Route::get('reuniones/calendar/view', [ReunionController::class, 'calendar'])->name('reuniones.calendar');
    
    // Acuerdos
    Route::resource('acuerdos', AcuerdoController::class);
    Route::post('acuerdos/{acuerdo}/to-task', [AcuerdoController::class, 'toTask'])
        ->name('acuerdos.to-task');
    
    // Worklogs
    Route::resource('worklogs', WorklogController::class);
    Route::get('worklogs/my-week', [WorklogController::class, 'myWeek'])->name('worklogs.my-week');
    
    // Comentarios
    Route::post('comentarios', [ComentarioController::class, 'store'])
        ->name('comentarios.store');
    Route::put('comentarios/{comentario}', [ComentarioController::class, 'update'])
        ->name('comentarios.update');
    Route::delete('comentarios/{comentario}', [ComentarioController::class, 'destroy'])
        ->name('comentarios.destroy');
    
    // Reportes
    Route::get('reportes', [\App\Http\Controllers\ReporteController::class, 'index'])
        ->name('reportes.index');
    Route::get('reportes/carga-por-dev', [\App\Http\Controllers\ReporteController::class, 'cargaPorDev'])
        ->name('reportes.carga-por-dev');
    Route::get('reportes/acuerdos-vencidos', [\App\Http\Controllers\ReporteController::class, 'acuerdosVencidos'])
        ->name('reportes.acuerdos-vencidos');
    Route::get('reportes/mi-gantt', [\App\Http\Controllers\ReporteController::class, 'miGantt'])
        ->name('reportes.mi-gantt');
    Route::get('proyectos/{proyecto}/gantt', [\App\Http\Controllers\ReporteController::class, 'ganttProyecto'])
        ->name('reportes.gantt-proyecto');
});
