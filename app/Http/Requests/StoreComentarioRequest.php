<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComentarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Comentario::class);
    }

    public function rules(): array
    {
        return [
            'model_type' => ['required', 'string'],
            'model_id' => ['required', 'integer'],
            'contenido' => ['required', 'string'],
            'is_private' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'model_type.required' => 'El tipo de modelo es obligatorio.',
            'model_id.required' => 'El ID del modelo es obligatorio.',
            'contenido.required' => 'El contenido del comentario es obligatorio.',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $modelType = $this->model_type;
            $modelId = $this->model_id;

            // Whitelist de modelos permitidos
            $allowedModels = [
                \App\Models\Tarea::class,
                \App\Models\Documento::class,
                \App\Models\Acuerdo::class,
            ];

            if (!in_array($modelType, $allowedModels)) {
                $validator->errors()->add('model_type', 'Tipo de modelo no permitido.');
                return;
            }

            // Verificar que el modelo existe
            if (!class_exists($modelType)) {
                $validator->errors()->add('model_type', 'La clase del modelo no existe.');
                return;
            }

            $model = $modelType::find($modelId);
            if (!$model) {
                $validator->errors()->add('model_id', 'El recurso no existe.');
                return;
            }

            // Verificar acceso según el tipo de modelo
            $user = $this->user();
            
            if ($model instanceof \App\Models\Tarea) {
                if (!$user->proyectos()->where('proyectos.id', $model->proyecto_id)->exists()) {
                    $validator->errors()->add('model_id', 'No tienes acceso a esta tarea.');
                }
            } elseif ($model instanceof \App\Models\Documento) {
                if ($model->estado !== 'publicado' && !$user->hasRole('consulta')) {
                    if ($model->sistema_id) {
                        $isMember = $user->proyectos()
                            ->whereHas('sistema', function ($q) use ($model) {
                                $q->where('id', $model->sistema_id);
                            })
                            ->exists();
                        if (!$isMember) {
                            $validator->errors()->add('model_id', 'No tienes acceso a este documento.');
                        }
                    }
                }
            } elseif ($model instanceof \App\Models\Acuerdo) {
                if ($model->proyecto_id) {
                    if (!$user->proyectos()->where('proyectos.id', $model->proyecto_id)->exists()) {
                        $validator->errors()->add('model_id', 'No tienes acceso a este acuerdo.');
                    }
                }
            }

            // Solo PM/superadmin pueden crear comentarios privados
            if ($this->is_private && !$user->hasRole(['pm', 'superadmin'])) {
                $validator->errors()->add('is_private', 'Solo PM y superadmin pueden crear comentarios privados.');
            }
        });
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'contenido' => trim($this->contenido ?? ''),
            'is_private' => $this->has('is_private') ? (bool) $this->is_private : false,
        ]);
    }
}
