<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComentarioRequest;
use App\Models\Comentario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ComentarioController extends Controller
{
    public function store(StoreComentarioRequest $request): RedirectResponse
    {
        $comentario = Comentario::create([
            'model_type' => $request->model_type,
            'model_id' => $request->model_id,
            'user_id' => $request->user()->id,
            'contenido' => $request->contenido,
            'is_private' => $request->is_private ?? false,
        ]);

        // Redirigir según el tipo de modelo
        $model = $request->model_type::find($request->model_id);
        
        if ($model instanceof \App\Models\Tarea) {
            return redirect()
                ->route('tareas.show', $model)
                ->with('success', 'Comentario agregado exitosamente.');
        } elseif ($model instanceof \App\Models\Documento) {
            return redirect()
                ->route('documentos.show', $model)
                ->with('success', 'Comentario agregado exitosamente.');
        } elseif ($model instanceof \App\Models\Acuerdo) {
            return redirect()
                ->route('acuerdos.show', $model)
                ->with('success', 'Comentario agregado exitosamente.');
        }

        return redirect()->back()->with('success', 'Comentario agregado exitosamente.');
    }

    public function update(Request $request, Comentario $comentario): RedirectResponse
    {
        $this->authorize('update', $comentario);

        $request->validate([
            'contenido' => ['required', 'string'],
        ]);

        $comentario->update(['contenido' => trim($request->contenido)]);

        return redirect()->back()->with('success', 'Comentario actualizado exitosamente.');
    }

    public function destroy(Comentario $comentario): RedirectResponse
    {
        $this->authorize('delete', $comentario);

        $comentario->delete();

        return redirect()->back()->with('success', 'Comentario eliminado exitosamente.');
    }
}
